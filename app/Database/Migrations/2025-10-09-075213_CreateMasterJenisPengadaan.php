<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterJenisPengadaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master_jenis_pengadaan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_master_jenis_pengadaan' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => false],
            'singkatan_master_jenis_pengadaan' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => false],
            'keterangan' => ['type' => 'TEXT', 'null' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_master_jenis_pengadaan', true);
        $this->forge->createTable('master_jenis_pengadaan');
    }

    public function down()
    {
        $this->forge->dropTable('master_jenis_pengadaan');
    }
}
