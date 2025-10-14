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
            // session-based fallback (untuk internal view)
            $sessionUser = auth()->user()->token();
            if ($sessionUser) {
                $request->user = $sessionUser;
                return; // bypass JWT
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

        $jwtLib = new JwtLib();
        $decoded = $jwtLib->validateToken($matches[1]);
        // dd($decoded);
        // exit;
        if (!$decoded) {
            return Services::response()
                ->setJSON(['error' => 'Invalid or expired token'])
                ->setStatusCode(401);
        }

        // Simpan user dari JWT ke request agar bisa dipakai controller
        $request->user = $decoded;
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
