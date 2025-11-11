<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\transaksi\GetDataFilterModel;

class TransaksiGetDataByFilterController extends BaseController
{
    public function index()
    {
        $GetDataFilterModel = new GetDataFilterModel();
        $listmasterunit = $GetDataFilterModel->getDataMasterUnitArray();
        $listjenispekerjaan = $GetDataFilterModel->getDataMasterJenisPekerjaanArray();
        $listlokasipekerjaan = $GetDataFilterModel->getDataLokasiPekerjaanArray();

        // Ambil input filter dari GET
        //$filters = [
        //    'id_unit_organisasi' => $this->request->getGet('organisasi'),
        //    'id_master_jenis_pengadaan'    => $this->request->getGet('jenis_pekerjaan'),
        //    'id_lokasi_provinsi'    => $this->request->getGet('lokasi_pekerjaan'),
        //    'tahun'    => $this->request->getGet('tahun'),
        //    'harga_min'   => $this->request->getGet('harga_min'),
        //    'harga_max'   => $this->request->getGet('harga_max'),
        //    'nama_paket'   => $this->request->getGet('nama_paket'),
        //];

        // Ambil hasil pencarian
        //$data['produk'] = $GetDataFilterModel->searchPaket($filters);
        //$data['filters'] = $filters;

        return view('transaksi/view_transaksi_get_data_by_filter', [
            'page'  => 'Filter Data',
            'title' => 'By Pemenang - TailAdmin',
            'listmasterunit' => $listmasterunit,
            'listjenispekerjaan' => $listjenispekerjaan,
            'listlokasipekerjaan' => $listlokasipekerjaan
            //$data
        ]);
    }

    public function hasil()
    {
        // Build an associative filters array from GET parameters (use empty string as default)
        $filters = [
            'id_unit_organisasi' => $this->request->getGet('organisasi') ?? '',
            'id_master_jenis_pengadaan' => $this->request->getGet('jenis_pekerjaan') ?? '',
            'id_lokasi_provinsi' => $this->request->getGet('lokasi_pekerjaan') ?? '',
            'tahun' => $this->request->getGet('tahun') ?? '',
            'nama_paket' => $this->request->getGet('nama_paket') ?? '',
            'harga_min' => $this->request->getGet('harga_min') ?? '',
            'harga_max' => $this->request->getGet('harga_max') ?? ''
        ];

        // Ambil hasil pencarian
        $GetDataFilterModel = new GetDataFilterModel();
        $data['hasil'] = $GetDataFilterModel->searchPaket($filters);
        $data['filters'] = $filters;
        return view('transaksi/view_hasil_pencarian_by_filter', $data);
    }
}
