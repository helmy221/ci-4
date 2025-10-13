<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDemoSeeder extends Seeder
{
    public function run()
    {
        $this->call('RolesSeeder');
        $this->call('PermissionsSeeder');
        $this->call('RolePermissionsSeeder');


        $this->call('UsersSeeder');
        $this->call('UserRolesSeeder');


        $this->call('MasterDictionarySeeder');


        $this->call('PersonilSeeder');
    }
}
