<?php

namespace App\Models\master;

use CodeIgniter\Model;

class JenisPekerjaanModel extends Model
{
    protected $table            = 'master_jenis_pengadaan';
    protected $primaryKey       = 'id_master_jenis_pengadaan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_master_jenis_pengadaan', 'nama_master_jenis_pengadaan', 'singkatan_master_jenis_pengadaan', 'keterangan', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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

    public function getListJabatan()
    {
        return $this->db->table('master_jenis_pengadaan')
            ->select('*')
            ->where('is_active', 1)
            ->get()
            ->getResultArray();
    }
}
