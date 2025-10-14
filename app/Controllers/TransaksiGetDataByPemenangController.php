<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TransaksiGetDataByPemenangController extends BaseController
{
    public function index()
    {
        return view('transaksi/view_transaksi_get_data_by_pemenang', [
            'page'  => 'Get Data By Pemenang',
            'title' => 'By Pemenang - TailAdmin'
        ]);
    }
}
