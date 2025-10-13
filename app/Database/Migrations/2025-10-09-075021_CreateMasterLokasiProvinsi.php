<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterLokasiProvinsi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lokasi_provinsi' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nama_provinsi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'id_parent_provinsi' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'default' => 0],
            'keterangan' => ['type' => 'TEXT', 'null' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_lokasi_provinsi', true);
        $this->forge->createTable('master_lokasi_provinsi');
    }

    public function down()
    {
        $this->forge->dropTable('master_lokasi_provinsi');
    }
}
