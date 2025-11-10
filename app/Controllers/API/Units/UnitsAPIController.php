<?php

namespace App\Controllers\API\Units;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UnitModel;

class UnitsAPIController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $format = 'json';
    protected $modelName = UnitModel::class;
    use ResponseTrait;

    public function __construct()
    {
        // make sure we have DB connection available for transactions
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        //
    }

    public function getListUnits()
    {
        $units = $this->model->getListUnits();

        return $this->respond([
            'status' => 'success',
            'data' => $units,
        ]);
    }

    public function update($id = null)
    {
        $model_unit = new UnitModel();
        //$model_roles = new RolesModel();

        $data = $this->request->getJSON();
        // Determine unit id: prefer URL param $id, otherwise expect id_unit_organisasi in JSON
        $unitId = $id ?? ($data->id_unit_organisasi ?? null);

        if (!$unitId) {
            return $this->failValidationError('Unit id is required');
        }

        $unit = $model_unit->find($unitId);

        if ($unit) {
            //$userData = [
            //    'username' => $data->username,
            //    'is_active' => isset($data->status) ? $data->status : $user['status'],
            //    'updated_at' => date('Y-m-d H:i:s')
            //];

            //$model_unit->update($data->id, $userData);

            $unitData = [
                'nama_unit_organisasi' => $data->nama_unit_organisasi ?? $unit['nama_unit_organisasi'],
                'kode_unit_organisasi' => $data->kode_unit_organisasi ?? $unit['kode_unit_organisasi'],
                'keterangan' => $data->keterangan ?? $unit['keterangan'],
                'is_active' => isset($data->is_active) ? $data->is_active : $unit['is_active'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Use the standard Model::update method
            $model_unit->update($unitId, $unitData);

            // $model_roles->where('id_user', $data->id)->delete();
            //$model_roles->deleteUserRoleById($data->id);

            //$rolesData = [];
            //if ($data->roles) {
            //    foreach ($data->roles as $roleId) {
            //        $rolesData[] = [
            //            'id_user' => $data->id,
            //            'id_role' => $roleId,
            //            'updated_at' => date('Y-m-d H:i:s')
            //        ];
            //    }
            //    $model_roles->saveUserRole($rolesData);
            //}

            return $this->respond([
                'status' => 'success',
                'message' => 'Unit updated successfully'
            ]);
        }

        return $this->failNotFound('Unit not found');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON();

        //validasi data
        //if (empty($data->username) || empty($data->nama_lengkap)) {
        //    return $this->response->setJSON([
        //        'success' => false,
        //        'message' => 'Username dan Nama Lengkap wajib diisi.'
        //    ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        //}

        //cek nama unit sudah ada atau belum
        $existingNamaUnit = $this->model->where('nama_unit_organisasi', $data->nama_unit_organisasi)->first();
        if ($existingNamaUnit) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Unit sudah digunakan.',
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }

        //Mulai transaksi
        $this->db->transStart();
        try {
            //simpan master_unit_organisasi
            $userData = [
                'nama_unit_organisasi' => $data->nama_unit_organisasi,
                'kode_unit_organisasi' => $data->kode_unit_organisasi,
                'keterangan' => $data->keterangan,
                'is_active' => isset($data->is_active) ? $data->is_active : 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $unitId = $this->model->insert($userData);

            if (!$unitId) {
                throw new \Exception('Gagal menyimpan data master unit organisasi.');
            }

            $this->db->transComplete();

            // Cek status transaksi
            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal.');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Unit berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            $this->db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menambahkan unit: ' . $e->getMessage(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
