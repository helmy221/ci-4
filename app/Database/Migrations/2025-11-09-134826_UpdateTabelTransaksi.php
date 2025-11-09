<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTabelTransaksi extends Migration
{
    public function up()
    {
        $fields = [
            'id_rup' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
                'after'      => 'id_transaksi_pemenang',
            ],
        ];
        $this->forge->addKey('id_rup', true);
        $this->forge->addColumn('transaksi_pemenang_pengadaan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transaksi_pemenang_pengadaan', ['id_rup']);
    }
}
