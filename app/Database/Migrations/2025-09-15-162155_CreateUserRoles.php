<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => ['type' => 'INT', 'unsigned' => true],
            'id_role' => ['type' => 'INT', 'unsigned' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['id_user', 'id_role'], true);
        $this->forge->addForeignKey('id_user', 'master_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_role', 'master_roles', 'id_role', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_user_roles');
    }

    public function down()
    {
        $this->forge->dropTable('master_user_roles');
    }
}
