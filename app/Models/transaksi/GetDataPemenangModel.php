<?php

namespace App\Models\transaksi;

use CodeIgniter\Model;

class GetDataPemenangModel extends Model
{
    protected $table            = 'transaksi_pemenang_pengadaan';
    protected $primaryKey       = 'id_transaksi_pemenang';
    protected $useAutoIncrement = true;
    //protected $returnType       = 'array';
    //protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    public function getDataMasterUnitArray()
    {
        $query =  $this->db->query("SELECT * from master_unit_organisasi where is_active = ? ", 1);
        return $query->getResultArray(); // Pastikan mengembalikan array
    }

    public function getDataMasterJenisPekerjaanArray()
    {
        $query =  $this->db->query("SELECT * from master_jenis_pengadaan");
        return $query->getResultArray(); // Pastikan mengembalikan array
    }

    public function getDataLokasiPekerjaanArray()
    {
        $query =  $this->db->query("SELECT * from master_lokasi_provinsi");
        return $query->getResultArray(); // Pastikan mengembalikan array
    }

    public function searchPaket($filters = [])
    {
        $builder = $this->builder();

        if (!empty($filters['pemenang'])) {
            $builder->like('pemenang', $filters['pemenang']);
        }

        if (!empty($filters['tahun'])) {
            $builder->where('tahun', $filters['tahun']);
        }

        $builder->groupBy('pemenang');

        // Return as array so views can access fields using array syntax
        return $builder->get()->getResultArray();
    }

    public function searchDetailPaket($filters = [])
    {
        $builder = $this->builder();

        if (!empty($filters['pemenang'])) {
            $builder->like('pemenang', $filters['pemenang']);
        }

        if (!empty($filters['tahun'])) {
            $builder->where('tahun', $filters['tahun']);
        }

        // Return as array so views can access fields using array syntax
        return $builder->get()->getResultArray();
    }
}
