<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MasterLokasiPekerjaanController extends BaseController
{
    public function index()
    {
        return view('master/view_master_lokasi_pekerjaan', [
            'page'  => 'All Data Pengadaan',
            'title' => 'All Data - TailAdmin'
        ]);
    }
}
