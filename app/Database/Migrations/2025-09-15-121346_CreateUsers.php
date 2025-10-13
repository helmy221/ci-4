<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        // Master User
        $this->forge->addField([
            'id_user'    => ['type' => 'INT', 'constraint'  => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'is_active'  => ['type' => 'boolean', 'default' => true, 'null' => false,],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'last_login' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('master_user');

        // Master Personil
        $this->forge->addField([
            'id_master_personil'    => ['type' => 'INT', 'constraint'  => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'               => ['type' => 'INT', 'constraint'  => 11, 'unsigned' => true],
            'nama_lengkap'          => ['type' => 'VARCHAR', 'constraint'  => 255, 'null' => true],
            'master_jabatan_id'     => ['type' => 'INT', 'constraint'  => 11, 'unsigned' => true],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id_master_personil', true);
        $this->forge->addForeignKey('id_user', 'master_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_personil');
    }

    public function down()
    {
        $this->forge->dropTable('master_user');
        $this->forge->dropTable('master_personil');
    }
}
