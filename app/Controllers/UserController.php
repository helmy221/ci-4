<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        return view('view_users', [
            'page'  => 'users',
            'title' => 'Users - TailAdmin'
        ]);
    }
}
