<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'manager1',
                'password' => password_hash('manager123', PASSWORD_DEFAULT),
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'staff1',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];


        $builder = $this->db->table('master_user');
        if (method_exists($builder, 'ignore')) $builder->ignore(true);
        $builder->insertBatch($data);
    }
}
