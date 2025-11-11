<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\transaksi\GetDataPemenangModel;

class TransaksiGetDataByPemenangController extends BaseController
{
    public function index()
    {
        return view('transaksi/view_transaksi_get_data_by_pemenang', [
            'page'  => 'Get Data By Pemenang',
            'title' => 'By Pemenang - TailAdmin'
        ]);
    }

    public function hasil()
    {
        // Build an associative filters array from GET parameters (use empty string as default)
        $filters = [
            'pemenang' => $this->request->getGet('nama_pemenang') ?? '',
            'tahun' => $this->request->getGet('tahun') ?? ''
        ];

        // Ambil hasil pencarian
        $GetDataPemenangModel = new GetDataPemenangModel();
        $data['hasil'] = $GetDataPemenangModel->searchPaket($filters);
        $data['filters'] = $filters;
        return view('transaksi/view_hasil_pencarian_by_pemenang', $data);
    }

    /**
     * API: return paket list filtered by pemenang (JSON)
     * Accessible via GET /transaksi/pemenang/list
     */
    public function apiListByPemenang()
    {
        $pemenang = $this->request->getGet('pemenang') ?? '';
        $tahun = $this->request->getGet('tahun') ?? '';

        $filters = [
            'pemenang' => $pemenang,
            'tahun' => $tahun
        ];

        $model = new GetDataPemenangModel();
        $rows = $model->searchDetailPaket($filters);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $rows
        ]);
    }
}
