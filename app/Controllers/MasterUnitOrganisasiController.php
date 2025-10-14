<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MasterUnitOrganisasiController extends BaseController
{
    public function index()
    {
        return view('master/view_master_unit_organisasi', [
            'page'  => 'All Data Pengadaan',
            'title' => 'All Data - TailAdmin'
        ]);
    }
}
