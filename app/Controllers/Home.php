<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // dd(session()->get());
        // exit;
        return view('dashboard', [
            'page'  => 'dashboard',
            'title' => 'Dashboard - TailAdmin'
        ]);
    }

    public function create()
    {
        // if (!hasPermission('user.create')) {
        //     return redirect()->back()->with('error', 'Anda tidak punya izin membuat user.');
        // }
        return 'Halaman untuk membuat user baru.';
    }
}
