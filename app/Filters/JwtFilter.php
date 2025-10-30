<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JwtLib;
use App\Models\TokenModel;
use Config\Services;

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
        // $decoded = $jwtLib->validateToken($matches[1]);
        try {
            // $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            $decoded = $jwtLib->validateToken($matches[1]);
            // Simpan info user jika perlu
            $request->user = $decoded;
        } catch (\Exception $e) {
            log_message('error', 'Token expired or invalid: ' . $token);

            // 🔴 Auto redirect ke logout
            session()->destroy();
            return redirect()->to(site_url('logout'));
        }
        // if (!$decoded) {
        //     log_message('error', 'Token expired or invalid: ' . $token); // Log expired/invalid token

        //     return Services::response()
        //         ->setJSON(['error' => 'Invalid or expired token'])
        //         ->setStatusCode(401);
        // }

        // log_message('info', 'Token is valid for user: ' . $decoded->sub); // Log valid token

        // // Simpan user dari JWT ke request agar bisa dipakai controller
        // $request->user = $decoded;
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
