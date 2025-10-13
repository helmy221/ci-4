<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrganization extends Migration
{
    public function up()
    {
        // Master Jabatan
        $this->forge->addField([
            'id_master_jabatan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_jabatan'      => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'kode_jabatan'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'keterangan'        => ['type' => 'TEXT', 'null' => false],
            'is_active'         => ['type' => 'boolean', 'default' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id_master_jabatan', true);
        $this->forge->createTable('master_jabatan');

        // Master Unit Organisasi
        $this->forge->addField([
            'id_unit_organisasi'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_unit_organisasi'  => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'kode_unit_organisasi'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'keterangan'            => ['type' => 'TEXT', 'null' => false],
            'is_active'             => ['type' => 'boolean', 'default' => true],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id_unit_organisasi', true);
        $this->forge->createTable('master_unit_organisasi');
    }

    public function down()
    {
        $this->forge->dropTable('master_jabatan');
        $this->forge->dropTable('master_unit_organisasi');
    }
}
