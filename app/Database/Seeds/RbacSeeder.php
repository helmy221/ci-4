<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RbacSeeder extends Seeder
{
    public function run()
    {
        // Insert Roles
        $roles = [
            [
                'name'        => 'superadmin',
                'description' => 'Full access to the system',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'user',
                'description' => 'Regular user with limited access',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('master_roles')->insertBatch($roles);

        // === Insert Permissions ===
        $permissions = [
            ['name' => 'user.create', 'description' => 'Create new users'],
            ['name' => 'user.edit',   'description' => 'Edit existing users'],
            ['name' => 'user.delete', 'description' => 'Delete users'],
            ['name' => 'user.read', 'description' => 'Read Data users'],
        ];
        foreach ($permissions as &$p) {
            $p['created_at'] = date('Y-m-d H:i:s');
            $p['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('master_permissions')->insertBatch($permissions);

        // Insert Default Users
        $users = [
            [
                'username'   => 'superadmin',
                'email'      => 'superadmin@example.com',
                'password'   => password_hash('superadmin123', PASSWORD_BCRYPT),
                'is_active'  => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'user',
                'email'      => 'user@example.com',
                'password'   => password_hash('user123', PASSWORD_BCRYPT),
                'is_active'  => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('master_users')->insertBatch($users);

        $users_profiles = [
            [
                'user_id'    => 1,
                'full_name'  => 'Super Admin',
                'phone'      => '1234567890',
                'address'    => '123 Admin St, Admin City',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'    => 2,
                'full_name'  => 'Demo User',
                'phone'      => '0987654321',
                'address'    => '456 User Ave, User City',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('master_user_profiles')->insertBatch($users_profiles);

        // Ambil ID role
        $roleSuperadmin = $this->db->table('master_roles')->where('name', 'superadmin')->get()->getRow()->id;
        $roleUser       = $this->db->table('master_roles')->where('name', 'user')->get()->getRow()->id;

        // Ambil ID user
        $userSuperadmin = $this->db->table('master_users')->where('username', 'superadmin')->get()->getRow()->id;
        $userDemo       = $this->db->table('master_users')->where('username', 'user')->get()->getRow()->id;

        // Assign Roles ke Users
        $userRoles = [
            [
                'user_id' => $userSuperadmin,
                'role_id' => $roleSuperadmin,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => $userDemo,
                'role_id' => $roleUser,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // === Ambil semua permission id ===
        $perm = $this->db->table('master_permissions')->get()->getResultArray();
        $map = [];
        foreach ($perm as $p) {
            $map[$p['name']] = $p['id'];
        }


        // === Assign Permissions ke Roles ===
        $rolePermissions = [];

        // superadmin → semua permission
        foreach ($map as $pid) {
            $rolePermissions[] = ['role_id' => $roleSuperadmin, 'permission_id' => $pid];
        }

        // user → hanya report.view
        $rolePermissions[] = ['role_id' => $roleUser, 'permission_id' => $map['user.read']];

        $this->db->table('master_role_permissions')->insertBatch($rolePermissions);

        $this->db->table('master_user_roles')->insertBatch($userRoles);
    }
}
