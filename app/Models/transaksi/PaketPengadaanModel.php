<?php

namespace App\Models\transaksi;

use CodeIgniter\Model;

class PaketPengadaanModel extends Model
{
    protected $table            = 'transaksi_pemenang_pengadaan';
    protected $primaryKey       = 'id_transaksi_pemenang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_transaksi_pemenang',
        'nama_paket',
        'id_unit_organisasi',
        'ketua_pokja',
        'id_lokasi_provinsi',
        'persentase_nilai_kontrak',
        'harga_perkiraan_sendiri',
        'pemenang',
        'durasi_pemilihan',
        'tanggal_tayang',
        'tanggal_penetapan',
        'id_master_jenis_pengadaan',
        'tanggal_penetapan_awal',
        'tanggal_penetapan_final',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
