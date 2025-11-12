<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Home extends BaseController
{
    public function index(): string
    {
        // dd(session()->get());
        // exit;
        $DashboardModel = new DashboardModel();
        $jk = $DashboardModel->getDataJasaKonsultansi();
        $pk = $DashboardModel->getDataPekerjaanKonstruksi();
        $pb = $DashboardModel->getDataPengadaanBarang();
        $jl = $DashboardModel->getDataJasaLainnya();
        // monthly data for chart (year 2024)
        $monthly_jk = $DashboardModel->getMonthlyCounts(1, 2024);
        $monthly_pk = $DashboardModel->getMonthlyCounts(2, 2024);
        $monthly_pb = $DashboardModel->getMonthlyCounts(3, 2024);
        $monthly_jl = $DashboardModel->getMonthlyCounts(4, 2024);
        return view('dashboard', [
            'page'  => 'dashboard',
            'title' => 'Dashboard - TailAdmin',
            'jasa_konsultansi' => $jk,
            'pekerjaan_konstruksi' => $pk,
            'pengadaan_barang' => $pb,
            'jasa_lainnya' => $jl
            ,'monthly_jk' => $monthly_jk
            ,'monthly_pk' => $monthly_pk
            ,'monthly_pb' => $monthly_pb
            ,'monthly_jl' => $monthly_jl
        ]);
    }

    public function create()
    {
        // if (!hasPermission('user.create')) {
        //     return redirect()->back()->with('error', 'Anda tidak punya izin membuat user.');
        // }
        return 'Halaman untuk membuat user baru.';
    }
}
