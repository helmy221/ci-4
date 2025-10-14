<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TransaksiAllDataController extends BaseController
{
    public function index()
    {
        return view('view_transaksi_alldata', [
            'page'  => 'Transaksi All Data',
            'title' => 'All Data - TailAdmin'
        ]);
    }
}
