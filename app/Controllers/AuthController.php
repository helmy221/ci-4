<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\JwtLib;
use App\Models\UserModel;
use App\Models\UserInfoModel;

class AuthController extends BaseController
{

    public function index()
    {
        return view('Auth/view_login', [
            'title' => 'Login - TailAdmin'
        ]);
    }

    public function doLogin()
    {

        $encrypter = service('encrypter');

        $userModel = new UserModel();
        $jwt       = new JwtLib();

        $identifier = $this->request->getPost('identifier');
        $password = $this->request->getPost('password');

        // $user = $userModel->where('email', $identifier)
        //     ->orWhere('username', $identifier)->first();

        $user = $userModel->getUserWithRolesAndPermissions($identifier);


        if (!$user || !password_verify($password, $user['password'])) {
            session()->setFlashdata('notification', [
                'type'    => 'error',
                'title'   => 'Error',
                'message' => 'Username atau password salah!',
            ]);

            return redirect()->back()->withInput();
        }


        $token = $jwt->generateToken($user);
        $userData = [
            'id_user'    => $user['id_user'],
            'username'  => $user['username'] ?? null,
            'nama_lengkap'  => $user['nama_lengkap'] ?? null,
            'roles'  => $user['roles'],
            'permissions' => $user['permissions'],
            'token' => $token
        ];

        $jsonData = json_encode($userData);

        $encrypData = $encrypter->encrypt($jsonData);

        session()->set([
            'isLoggedIn' => true,
            'user'       => $encrypData,
        ]);

        // Update last login
        $userModel->updateLastLogin($user['id_user']);

        // dd($update);
        // exit;
        session()->setFlashdata('notification', [
            'type'    => 'success',
            'title'   => 'Success',
            'message' => 'Anda Berhasil Login!',
        ]);
        return redirect()->to('/dashboard');
    }

    public function logout()
    {

        session()->setFlashdata('notification', [
            'type'    => 'success',
            'title'   => 'Success',
            'message' => 'Berhasil Logout!',
        ]);
        session()->destroy();
        // return redirect()->to('/login');
        return redirect()->to(site_url('login'));
        // return redirect()->to(site_url('login'))->with('success', 'Berhasil Logout!');
    }
}
