<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MasterJenisPekerjaanController extends BaseController
{
    public function index()
    {
        return view('master/view_master_jenis_pekerjaan', [
            'page'  => 'All Data Pengadaan',
            'title' => 'All Data - TailAdmin'
        ]);
    }
}
