<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolePermissions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'role_id'       => ['type' => 'INT', 'unsigned' => true],
            'permission_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['role_id', 'permission_id'], true);
        $this->forge->addForeignKey('role_id', 'master_roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'master_permissions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_role_permissions');
    }

    public function down()
    {
        $this->forge->dropTable('master_role_permissions');
    }
}
