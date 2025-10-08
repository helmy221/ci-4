<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'role_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['user_id', 'role_id'], true);
        $this->forge->addForeignKey('user_id', 'master_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'master_roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_user_roles');
    }

    public function down()
    {
        $this->forge->dropTable('master_user_roles');
    }
}
