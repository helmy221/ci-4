<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'manage_users', 'description' => 'Kelola user & roles', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['name' => 'view_reports', 'description' => 'Lihat laporan & dashboard', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['name' => 'edit_personil', 'description' => 'CRUD data personil', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['name' => 'manage_pengadaan', 'description' => 'Kelola data pemenang pengadaan', 'created_at' => Time::now(), 'updated_at' => Time::now()],
        ];
        $builder = $this->db->table('master_permissions');
        if (method_exists($builder, 'ignore')) $builder->ignore(true);
        $builder->insertBatch($data);
    }
}
