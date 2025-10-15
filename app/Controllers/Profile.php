<?php

namespace App\Controllers;

class Profile extends BaseController
{
    public function index(): string
    {
        // dd(session()->get());
        // exit;
        return view('profile', [
            'page'  => 'profile',
            'title' => 'Profile - TailAdmin'
        ]);
    }

    public function create()
    {
        // if (!hasPermission('user.create')) {
        //     return redirect()->back()->with('error', 'Anda tidak punya izin membuat user.');
        // }
        return 'Halaman untuk menampilkan user profile.';
    }
}
