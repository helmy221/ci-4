<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'is_active'  => ['type' => 'boolean', 'default' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'last_login' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_users');

        $this->forge->addField([
            'id'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'full_name'  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'address'    => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'master_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_user_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('master_users');
    }
}
