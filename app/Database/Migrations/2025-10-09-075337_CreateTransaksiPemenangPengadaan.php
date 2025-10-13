<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiPemenangPengadaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi_pemenang' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nama_paket' => ['type' => 'TEXT', 'null' => false],
            'id_unit_organisasi' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => false],
            'ketua_pokja' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => false],
            'id_lokasi_provinsi' => ['type' => 'INT', 'constraint' => 2, 'unsigned' => true, 'null' => false],
            'persentase_nilai_kontrak' => ['type' => 'DECIMAL', 'constraint' => '2,0', 'null' => false],
            'harga_perkiraan_sendiri' => ['type' => 'DECIMAL', 'constraint' => '15,0', 'null' => false],
            'pemenang' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => false],
            'durasi_pemilihan' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'tanggal_tayang' => ['type' => 'DATE', 'null' => false],
            'tanggal_penetapan' => ['type' => 'DATE', 'null' => false],
            'id_master_jenis_pengadaan' => ['type' => 'INT', 'constraint' => 2, 'unsigned' => true, 'null' => false],
            'tanggal_penetapan_awal' => ['type' => 'DATE', 'null' => false],
            'tanggal_penetapan_final' => ['type' => 'DATE', 'null' => false],
            'keterangan' => ['type' => 'TEXT', 'null' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_transaksi_pemenang', true);
        $this->forge->addForeignKey('id_unit_organisasi', 'master_unit_organisasi', 'id_unit_organisasi', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_lokasi_provinsi', 'master_lokasi_provinsi', 'id_lokasi_provinsi', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('id_master_jenis_pengadaan', 'master_jenis_pengadaan', 'id_master_jenis_pengadaan', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('transaksi_pemenang_pengadaan');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_pemenang_pengadaan');
    }
}
