<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'admin', 'description' => 'Super Administrator', 'is_active' => 1, 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['name' => 'manager', 'description' => 'Manager Unit/Divisi', 'is_active' => 1, 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['name' => 'staff', 'description' => 'Staf Pengadaan', 'is_active' => 1, 'created_at' => Time::now(), 'updated_at' => Time::now()],
        ];
        $builder = $this->db->table('master_roles');
        if (method_exists($builder, 'ignore')) $builder->ignore(true);
        $builder->insertBatch($data);
    }
}
