<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TransaksiGetDataByFilterController extends BaseController
{
    public function index()
    {
        return view('transaksi/view_transaksi_get_data_by_filter', [
            'page'  => 'Filter Data',
            'title' => 'By Pemenang - TailAdmin'
        ]);
    }
}
