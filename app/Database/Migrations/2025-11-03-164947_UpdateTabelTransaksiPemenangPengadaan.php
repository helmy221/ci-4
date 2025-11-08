<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTabelTransaksiPemenangPengadaan extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('transaksi_pemenang_pengadaan', [
            'harga_perkiraan_sendiri' => [
                'name'       => 'harga_perkiraan_sendiri', // nama kolom tidak berubah
                'type'       => 'DECIMAL',
                'constraint' => '20,2', // ubah sesuai kebutuhan
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('transaksi_pemenang_pengadaan', [
            'harga_perkiraan_sendiri' => [
                'name'       => 'harga_perkiraan_sendiri',
                'type'       => 'DECIMAL',
                'constraint' => '15,0',
                'null'       => false,
            ],
        ]);
    }
}
