<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserRolesSeeder extends Seeder
{
    public function run()
    {
        $users = $this->db->table('master_user')->select('id_user, username')->get()->getResultArray();
        $userId = array_column($users, 'id_user', 'username');


        $roles = $this->db->table('master_roles')->select('id_role, name')->get()->getResultArray();
        $roleId = array_column($roles, 'id_role', 'name');


        $now = Time::now();
        $rows = [];


        $pairs = [
            ['username' => 'admin', 'role' => 'admin'],
            ['username' => 'manager1', 'role' => 'manager'],
            ['username' => 'staff1', 'role' => 'staff'],
        ];


        foreach ($pairs as $p) {
            if (!isset($userId[$p['username']], $roleId[$p['role']])) continue;
            $rows[] = [
                'id_user' => $userId[$p['username']],
                'id_role' => $roleId[$p['role']],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }


        if ($rows) {
            $builder = $this->db->table('master_user_roles');
            if (method_exists($builder, 'ignore')) $builder->ignore(true);
            $builder->insertBatch($rows);
        }
    }
}
