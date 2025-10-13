<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        // Ambil id role
        $roles = $this->db->table('master_roles')->select('id_role, name')->get()->getResultArray();
        $rolesByName = array_column($roles, 'id_role', 'name');


        // Ambil id permission
        $perms = $this->db->table('master_permissions')->select('id_permission, name')->get()->getResultArray();
        $permsByName = array_column($perms, 'id_permission', 'name');


        $map = [
            'admin' => ['manage_users', 'view_reports', 'edit_personil', 'manage_pengadaan'],
            'manager' => ['view_reports', 'edit_personil'],
            'staff' => ['view_reports'],
        ];


        $rows = [];
        $now = Time::now();
        foreach ($map as $roleName => $permNames) {
            $roleId = $rolesByName[$roleName] ?? null;
            if (!$roleId) continue;
            foreach ($permNames as $permName) {
                $permId = $permsByName[$permName] ?? null;
                if (!$permId) continue;
                $rows[] = [
                    'role_id' => $roleId,
                    'permission_id' => $permId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }


        if ($rows) {
            $builder = $this->db->table('master_role_permissions');
            if (method_exists($builder, 'ignore')) $builder->ignore(true);
            $builder->insertBatch($rows);
        }
    }
}
