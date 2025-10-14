<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JwtLib;
use App\Models\TokenModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        $session = session();
        $jwtLib = new JwtLib();
        $tokenModel = new TokenModel();

        // Jika header tidak ada, cek session
        if (!$authHeader) {
            $sessionToken = auth()->user()->token() ?? null;

            if ($sessionToken) {
                // Pastikan session belum expired
                $sessionExp = $session->get('expires_at');
                if ($sessionExp && time() > $sessionExp) {
                    $session->destroy();
                    return Services::response()
                        ->setJSON(['error' => 'Session expired'])
                        ->setStatusCode(401);
                }
                // Jika session valid, lanjutkan proses
                Services::request()->setGlobal('auth_user', $sessionToken);
                return;
            }

            return Services::response()
                ->setJSON(['error' => 'Token not provided'])
                ->setStatusCode(401);
        }

        // Validasi JWT jika header ada
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return Services::response()
                ->setJSON(['error' => 'Token format invalid'])
                ->setStatusCode(401);
        }

        $token = $matches[1];

        // =========================
        // 3️⃣ Decode & validasi JWT
        // =========================
        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Jika JWT expired, hapus session juga agar sinkron
            $session->destroy();
            return Services::response()
                ->setJSON(['error' => 'JWT expired'])
                ->setStatusCode(401);
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON(['error' => 'Invalid JWT'])
                ->setStatusCode(401);
        }

        // =========================
        // 4️⃣ Sinkronisasi JWT <-> Session
        // =========================
        $sessionJti = $session->get('jti');
        $sessionExp = $session->get('expires_at');

        // a. Jika session expired → token juga dianggap expired
        if (!$sessionExp || time() > $sessionExp) {
            $session->destroy();
            return Services::response()
                ->setJSON(['error' => 'Session expired'])
                ->setStatusCode(401);
        }

        // b. Jika JTI mismatch antara session dan token
        if ($sessionJti !== ($decoded->jti ?? null)) {
            return Services::response()
                ->setJSON(['error' => 'Token mismatch'])
                ->setStatusCode(401);
        }

        // c. Cek DB: token masih valid dan belum revoked
        $record = $tokenModel->where('jti', $decoded->jti)
            ->where('revoked', false)
            ->first();

        if (!$record) {
            return Services::response()
                ->setJSON(['error' => 'Token revoked or invalid'])
                ->setStatusCode(401);
        }

        // d. Cek expiry DB (supaya sinkron dengan JWT/session)
        if (strtotime($record['expires_at']) < time()) {
            $session->destroy();
            $tokenModel->where('jti', $decoded->jti)->set(['revoked' => true])->update();
            return Services::response()
                ->setJSON(['error' => 'Token expired'])
                ->setStatusCode(401);
        }

        // =========================
        // 5️⃣ Semua OK → lanjut request
        // =========================
        $userData = [
            'id_user' => $decoded->sub ?? null,
            'username' => $decoded->username ?? null,
            'roles' => $decoded->roles ?? [],
            'permissions' => $decoded->permissions ?? [],
        ];

        // Menyimpan data user ke session atau request global
        // $session->set('user', $userData);
        // Menyimpan data user ke global request menggunakan setGlobal
        Services::request()->setGlobal('auth_user', $userData);
        return;
        // return;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
