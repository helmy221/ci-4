<?php

namespace App\Controllers\API\Auth;

use CodeIgniter\RESTful\ResourceController;
// use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JwtLib;
use App\Models\UserModel;
use App\Models\UserInfoModel;

class AuthControllers extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        //
    }

    // public function login()
    // {
    //     $userModel = new UserModel();
    //     $userInfoModel = new UserInfoModel();
    //     $jwt       = new JwtLib();

    //     $data = (array) $this->request->getJSON();

    //     // Validasi input kosong
    //     if (!$data || empty($data['email']) || empty($data['password'])) {
    //         return $this->response->setJSON([
    //             'status'  => 'error',
    //             'message' => 'Email and password are required'
    //         ])->setStatusCode(400);
    //     }

    //     $user = $userModel->where('email', $data['email'])->first();

    //     if (!$user || !password_verify($data['password'], $user['password'])) {
    //         return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid credentials'])->setStatusCode(401);
    //     }

    //     $token = $jwt->generateToken($user);
    //     $userInfo = $userInfoModel->where('user_id', $user['id'])->first();

    //     $data = [
    //         'name' => $userInfo['full_name'],
    //         'username' => $user['username'],
    //         'email' => $user['email'],
    //         'phone' => $userInfo['phone'],
    //         'address' => $userInfo['address']
    //     ];

    //     return $this->response->setJSON([
    //         'status' => 'success',
    //         'user_info' => $data,
    //         'token'  => $token
    //     ]);
    // }

    public function refresh()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $jwt = new JwtLib();

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $this->response->setJSON(['error' => 'Token not provided'])->setStatusCode(401);
        }

        $decoded = $jwt->validateToken($matches[1]);
        if (!$decoded) {
            return $this->response->setJSON(['error' => 'Invalid token'])->setStatusCode(401);
        }

        $newToken = $jwt->generateToken([
            'id' => $decoded->sub,
            'email' => $decoded->email
        ]);

        return $this->response->setJSON(['token' => $newToken]);
    }

    public function refreshToken()
    {
        $user = session()->get('user');
        if (!$user) {
            return response()->setJSON(['error' => 'Not authenticated'])->setStatusCode(401);
        }

        $jwtLib = new JwtLib();
        $newToken = $jwtLib->generateToken($user);

        // Update token di session
        session()->set('user.token', $newToken);

        return response()->setJSON(['status' => 'success', 'token' => $newToken]);
    }
}
