<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\master\JenisPekerjaanModel;

class MasterJenisPekerjaanController extends BaseController
{
    public function index()
    {
        //return view('master/view_master_jenis_pekerjaan', [
        //    'page'  => 'All Data Pengadaan',
        //    'title' => 'All Data - TailAdmin'
        //]);

        $JenisPekerjaanModel = new JenisPekerjaanModel();
        $data['jenis_pekerjaan'] = $JenisPekerjaanModel->findAll();

        // Add page metadata into the same $data array so the view receives everything as one array
        $data['page']  = 'Master Jenis Pengadaan';
        $data['title'] = 'Master Jenis Pengadaan';

        return view('master/view_master_jenis_pekerjaan', $data);
    }
}
