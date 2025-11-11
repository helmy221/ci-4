<?php

namespace App\Models\transaksi;

use CodeIgniter\Model;

class GetDataFilterModel extends Model
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

        if (!empty($filters['nama_paket'])) {
            $builder->like('nama_paket', $filters['nama_paket']);
        }

        if (!empty($filters['id_unit_organisasi'])) {
            $builder->where('id_unit_organisasi', $filters['id_unit_organisasi']);
        }

        if (!empty($filters['id_master_jenis_pengadaan'])) {
            $builder->where('id_master_jenis_pengadaan', $filters['id_master_jenis_pengadaan']);
        }

        if (!empty($filters['id_lokasi_provinsi'])) {
            $builder->where('id_lokasi_provinsi', $filters['id_lokasi_provinsi']);
        }

        if (!empty($filters['tahun'])) {
            $builder->where('tahun', $filters['tahun']);
        }

        // Filter by estimated price range (harga_perkiraan_sendiri)
        // Support cases:
        //  - both harga_min and harga_max provided -> apply BETWEEN (inclusive)
        //  - only harga_min provided -> apply >= harga_min
        //  - only harga_max provided -> apply <= harga_max
        $hasMin = isset($filters['harga_min']) && $filters['harga_min'] !== '';
        $hasMax = isset($filters['harga_max']) && $filters['harga_max'] !== '';

        if ($hasMin || $hasMax) {
            if ($hasMin && $hasMax) {
                // ensure numeric values
                $min = (float) $filters['harga_min'];
                $max = (float) $filters['harga_max'];
                // swap if user accidentally provided min > max
                if ($min > $max) {
                    [$min, $max] = [$max, $min];
                }
                $builder->where('harga_perkiraan_sendiri >=', $min);
                $builder->where('harga_perkiraan_sendiri <=', $max);
            } elseif ($hasMin) {
                $min = (float) $filters['harga_min'];
                $builder->where('harga_perkiraan_sendiri >=', $min);
            } elseif ($hasMax) {
                $max = (float) $filters['harga_max'];
                $builder->where('harga_perkiraan_sendiri <=', $max);
            }
        }

        // Return as array so views can access fields using array syntax
        return $builder->get()->getResultArray();
    }
}
