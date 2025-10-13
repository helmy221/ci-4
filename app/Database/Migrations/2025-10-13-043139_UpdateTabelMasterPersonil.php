<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTabelMasterPersonil extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('master_personil', [
            'master_jabatan_id' => [
                'name'       => 'id_master_jabatan',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                // 'null'       => false,
            ],
        ]);

        $fields = [
            'id_master_organisasi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                //'null'       => true,
                'after'      => 'id_master_jabatan',
            ],
        ];

        $this->forge->addColumn('master_personil', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('master_personil', ['id_master_organisasi']);
    }
}
