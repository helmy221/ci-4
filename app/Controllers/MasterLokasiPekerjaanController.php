<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\master\LokasiPekerjaanModel;

class MasterLokasiPekerjaanController extends BaseController
{
    public function index()
    {
        //return view('master/view_master_lokasi_pekerjaan', [
        //    'page'  => 'All Data Pengadaan',
        //    'title' => 'All Data - TailAdmin'
        //]);
        $LokasiPekerjaanModel = new LokasiPekerjaanModel();
        $data['lokasi_pekerjaan'] = $LokasiPekerjaanModel->findAll();

        // Add page metadata into the same $data array so the view receives everything as one array
        $data['page']  = 'Master Lokasi Pekerjaan';
        $data['title'] = 'Master Lokasi Pekerjaan';

        return view('master/view_master_lokasi_pekerjaan', $data);
    }
}
