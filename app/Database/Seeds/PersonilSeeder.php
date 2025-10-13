<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PersonilSeeder extends Seeder
{
    public function run()
    {
        // lookup user ids by username
        $users = $this->db->table('master_user')->select('id_user, username')->get()->getResultArray();
        $uid = array_column($users, 'id_user', 'username');


        // lookup jabatan ids by nama
        $jab = $this->db->table('master_jabatan')->select('id_master_jabatan, nama_jabatan')->get()->getResultArray();
        $jid = array_column($jab, 'id_master_jabatan', 'nama_jabatan');


        $now = Time::now();
        $rows = [];


        $map = [
            ['username' => 'admin', 'nama_lengkap' => 'Admin Utama', 'nama_jabatan' => 'Pengelola Pengadaan Barang/Jasa Ahli Pertama'],
            ['username' => 'manager1', 'nama_lengkap' => 'Manajer Satu', 'nama_jabatan' => 'Pembina Jasa Konstruksi Ahli Pertama'],
            ['username' => 'staff1', 'nama_lengkap' => 'Staf Satu', 'nama_jabatan' => 'Staf Pengadaan'],
        ];


        foreach ($map as $m) {
            $idUser = $uid[$m['username']] ?? null;
            $idJab = $jid[$m['nama_jabatan']] ?? null;
            if (!$idUser || !$idJab) continue;
            $rows[] = [
                'id_user' => $idUser,
                'nama_lengkap' => $m['nama_lengkap'],
                'master_jabatan_id' => $idJab, // sesuai kolom di dump
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }


        if ($rows) {
            $builder = $this->db->table('master_personil');
            if (method_exists($builder, 'ignore')) $builder->ignore(true);
            $builder->insertBatch($rows);
        }
    }
}
