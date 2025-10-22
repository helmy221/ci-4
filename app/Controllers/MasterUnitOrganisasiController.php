<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\master\UnitOrganisasiModel;

class MasterUnitOrganisasiController extends BaseController
{
    public function index()
    {
        $UnitOrganisasiModel = new UnitOrganisasiModel();
        $data['organisasi'] = $UnitOrganisasiModel->where('is_active', '1')->findAll();

        // Add page metadata into the same $data array so the view receives everything as one array
        $data['page']  = 'Master Unit Organisasi';
        $data['title'] = 'Master Unit Organisasi';

        return view('master/view_master_unit_organisasi', $data);
    }
}
