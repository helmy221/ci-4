<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table            = 'transaksi_pemenang_pengadaan';
    protected $primaryKey       = 'id_transaksi_pemenang';
    protected $useAutoIncrement = true;
    //protected $returnType       = 'array';
    //protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    public function getDataJasaKonsultansi()
    {
        $query = $this->db->query("SELECT COUNT(id_transaksi_pemenang) AS total FROM transaksi_pemenang_pengadaan WHERE id_master_jenis_pengadaan = ? and tahun = ?", [1, 2024]);
        $row = $query->getRowArray();
        return $row && isset($row['total']) ? (int) $row['total'] : 0;
    }

    public function getDataPekerjaanKonstruksi()
    {
        $query = $this->db->query("SELECT COUNT(id_transaksi_pemenang) AS total FROM transaksi_pemenang_pengadaan WHERE id_master_jenis_pengadaan = ? and tahun = ?", [2, 2024]);
        $row = $query->getRowArray();
        return $row && isset($row['total']) ? (int) $row['total'] : 0;
    }

    public function getDataPengadaanBarang()
    {
        $query = $this->db->query("SELECT COUNT(id_transaksi_pemenang) AS total FROM transaksi_pemenang_pengadaan WHERE id_master_jenis_pengadaan = ? and tahun = ?", [3, 2024]);
        $row = $query->getRowArray();
        return $row && isset($row['total']) ? (int) $row['total'] : 0;
    }

    public function getDataJasaLainnya()
    {
        $query = $this->db->query("SELECT COUNT(id_transaksi_pemenang) AS total FROM transaksi_pemenang_pengadaan WHERE id_master_jenis_pengadaan = ? and tahun = ?", [4, 2024]);
        $row = $query->getRowArray();
        return $row && isset($row['total']) ? (int) $row['total'] : 0;
    }

    /**
     * Return monthly counts (1..12) for a given jenis and year.
     * @return int[] array with 12 integers indexed 1..12 (0-based index 0..11)
     */
    public function getMonthlyCounts(int $jenis, int $year = 2024): array
    {
        $sql = "SELECT MONTH(tanggal_penetapan_final) AS m, COUNT(*) AS total
                FROM transaksi_pemenang_pengadaan
                WHERE id_master_jenis_pengadaan = ? AND YEAR(tanggal_penetapan_final) = ?
                GROUP BY m";

        $query = $this->db->query($sql, [$jenis, $year]);
        $rows = $query->getResultArray();

        // Initialize 12 months with zeros
        $months = array_fill(0, 12, 0);
        foreach ($rows as $r) {
            $m = (int) ($r['m'] ?? 0);
            $total = (int) ($r['total'] ?? 0);
            if ($m >= 1 && $m <= 12) {
                $months[$m - 1] = $total;
            }
        }

        return $months;
    }
}
