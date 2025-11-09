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


    public function getAllPaketPemenangList($limit, $offset, $search)
    {
        $where = "";
        if (!empty($search)) {
            $where = "AND u.nama_paket LIKE '%$search%'";
        }

        $query = $this->db->query("SELECT tpp.id_transaksi_pemenang,
                                          tpp.nama_paket,
                                          unit.nama_unit_organisasi AS nama_unit,
                                          tpp.ketua_pokja,
                                          lokasi.nama_provinsi AS provinsi,
                                          tpp.persentase_nilai_kontrak,
                                          tpp.harga_perkiraan_sendiri,
                                          tpp.pemenang,
                                          tpp.durasi_pemilihan,
                                          tpp.tanggal_tayang,
                                          tpp.tanggal_penetapan,
                                          jenis.nama_master_jenis_pengadaan AS nama_pengadaan,
                                          tpp.tanggal_penetapan_awal,
                                          tpp.tanggal_penetapan_final,
                                          tpp.keterangan,
                                          tpp.created_at,
                                          tpp.updated_at
                                    FROM transaksi_pemenang_pengadaan tpp
                                    LEFT JOIN master_unit_organisasi unit ON unit.id_unit_organisasi = tpp.id_unit_organisasi
                                    LEFT JOIN master_lokasi_provinsi lokasi ON lokasi.id_lokasi_provinsi = tpp.id_lokasi_provinsi
                                    LEFT JOIN master_jenis_pengadaan jenis ON jenis.id_master_jenis_pengadaan = tpp.id_master_jenis_pengadaan
                                    WHERE 1=1 -- Selalu true untuk memudahkan penambahan kondisi
                                    $where
                                    ORDER BY tpp.id_transaksi_pemenang ASC
                                    LIMIT $limit OFFSET $offset
                                ");

        return $query->getResultArray();
    }

    public function countPaketPemenangList($search)
    {
        $builder = $this->db->table($this->table);

        if ($search) {
            $builder->groupStart()
                ->like('nama_paket', $search)
                ->groupEnd();
        }
        return $builder->countAllResults();
    }
}
