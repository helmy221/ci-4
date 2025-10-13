<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class MasterDictionarySeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();


        // master_jabatan (unique: nama_jabatan)
        $jabatan = [
            ['nama_jabatan' => 'Pengelola Pengadaan Barang/Jasa Ahli Pertama', 'kode_jabatan' => 'PBJ1', 'keterangan' => 'Pengelola PBJ Ahli Pertama', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nama_jabatan' => 'Pembina Jasa Konstruksi Ahli Pertama', 'kode_jabatan' => 'PJK1', 'keterangan' => 'Pembina JK Ahli Pertama', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nama_jabatan' => 'Staf Pengadaan', 'kode_jabatan' => 'STF', 'keterangan' => 'Staf Bagian Pengadaan', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];
        $b = $this->db->table('master_jabatan');
        if (method_exists($b, 'ignore')) $b->ignore(true);
        $b->insertBatch($jabatan);


        // master_unit_organisasi (unique: nama_unit_organisasi)
        $unit = [
            ['nama_unit_organisasi' => 'Direktorat Jenderal Sumber Daya Air', 'kode_unit_organisasi' => 'SDA', 'keterangan' => 'Direktorat Jenderal Sumber Daya Air', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nama_unit_organisasi' => 'Direktorat Jenderal Bina Marga', 'kode_unit_organisasi' => 'BM', 'keterangan' => 'Direktorat Jenderal Bina Marga', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nama_unit_organisasi' => 'Direktorat Jenderal Cipta Karya', 'kode_unit_organisasi' => 'CK', 'keterangan' => 'Direktorat Jenderal Cipta Karya', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nama_unit_organisasi' => 'Direktorat Jenderal Prasarana Strategis', 'kode_unit_organisasi' => 'PS', 'keterangan' => 'Direktorat Jenderal Prasarana Strategis', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now]
        ];
        $b = $this->db->table('master_unit_organisasi');
        if (method_exists($b, 'ignore')) $b->ignore(true);
        $b->insertBatch($unit);


        // master_lokasi_provinsi
        $prov = [
            ['nama_provinsi' => 'Jawa Barat', 'id_parent_provinsi' => 0, 'keterangan' => 'Provinsi Jawa Barat', 'created_at' => $now, 'updated_at' => $now],
            ['nama_provinsi' => 'Non Jawa Barat', 'id_parent_provinsi' => 0, 'keterangan' => 'Non Jawa Barat', 'created_at' => $now, 'updated_at' => $now],
        ];
        $b = $this->db->table('master_lokasi_provinsi');
        if (method_exists($b, 'ignore')) $b->ignore(true);
        $b->insertBatch($prov);


        // master_jenis_pengadaan
        $jenis = [
            ['nama_master_jenis_pengadaan' => 'Jasa Konsultansi Konstruksi', 'singkatan_master_jenis_pengadaan' => 'JK', 'keterangan' => 'Jasa Konsultansi Konstruksi', 'created_at' => $now, 'updated_at' => $now],
            ['nama_master_jenis_pengadaan' => 'Pekerjaan Konstruksi', 'singkatan_master_jenis_pengadaan' => 'PK', 'keterangan' => 'Pekerjaan Konstruksi', 'created_at' => $now, 'updated_at' => $now],
        ];
        $b = $this->db->table('master_jenis_pengadaan');
        if (method_exists($b, 'ignore')) $b->ignore(true);
        $b->insertBatch($jenis);
    }
}
