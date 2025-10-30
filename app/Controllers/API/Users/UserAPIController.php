<?php

namespace App\Controllers\API\Users;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\Roles;
use App\Models\RolesModel;
use Config\Services;

class UserAPIController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $format = 'json';
    protected $modelName = UserModel::class;
    protected $modelRoles;
    use ResponseTrait;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Inisialisasi model tambahan
        $this->modelRoles = new RolesModel();
    }

    public function index()
    {
        //
    }

    public function getListUser()
    {

        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 5);
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';


        if ($page < 1) $page = 1;
        if ($limit < 1) $limit = 5;

        $offset = ($page - 1) * $limit;

        $users = $this->model->getAllUserList($limit, $offset, $search, $status);

        $total = $this->model->countUsersList($search, $status);

        return $this->respond([
            'status' => 'success',
            'data' => $users,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]
        ]);
    }

    public function softDeleteUser($userId)
    {
        $user = $this->model->find($userId);

        if (!$user) {
            return $this->response
                ->setJSON(['status' => 'error', 'message' => 'User not found'])
                ->setStatusCode(404);
        }
        if ($user['is_active'] == 0) {
            if ($this->model->activateUser($userId)) { // soft delete karena useSoftDeletes = true
                return $this->response
                    ->setJSON(['status' => 'success', 'message' => 'User activate successfully']);
            } else {
                return $this->response
                    ->setJSON(['status' => 'error', 'message' => 'Failed to activate user'])
                    ->setStatusCode(500);
            }
        } else {
            if ($this->model->deactivateUser($userId)) { // soft delete karena useSoftDeletes = true
                return $this->response
                    ->setJSON(['status' => 'success', 'message' => 'User deactivate successfully']);
            } else {
                return $this->response
                    ->setJSON(['status' => 'error', 'message' => 'Failed to deactivate user'])
                    ->setStatusCode(500);
            }
        }
    }

    /**
     * Return the properties of a resource object.
     *  
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $users = $this->model->getAllUserList();
        $user = array_filter($users, fn($u) => $u['id'] == $id);

        if (!$user) {
            return $this->failNotFound("User with id $id not found");
        }

        return $this->respond([
            'status' => 'success',
            'data' => array_values($user)[0]
        ]);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
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
        if (empty($data->username) || empty($data->nama_lengkap)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Username dan Nama Lengkap wajib diisi.'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        //cek username sudah ada atau belum
        $existingUser = $this->model->getUsername($data->username);
        if ($existingUser) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Username sudah digunakan.',
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }

        //Mulai transaksi
        $this->db->transStart();
        try {
            //simpan master_user
            $userData = [
                'username' => $data->username,
                'password' => password_hash('defaultpassword', PASSWORD_DEFAULT),
                'is_active' => isset($data->status) ? $data->status : 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $userId = $this->model->insertUser($userData);

            if (!$userId) {
                throw new \Exception('Gagal menyimpan data master_user.');
            }

            //simpan master_data_personil
            $userDataPersonil = [
                'id_user' => $userId,
                'nama_lengkap' => $data->nama_lengkap,
                'id_master_jabatan' => $data->id_master_jabatan,
                'id_master_organisasi' => $data->id_unit_organisasi,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $insertPersonil = $this->db->table('master_personil')->insert($userDataPersonil);

            if (!$insertPersonil) {
                throw new \Exception('Gagal menyimpan data master_personil.');
            }

            //simpan user roles
            if (!empty($data->roles)) {
                $rolesData = [];
                foreach ($data->roles as $roleId) {
                    $rolesData[] = [
                        'id_user'    => $userId,
                        'id_role'    => $roleId,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
                $savedRoles = $this->modelRoles->saveUserRole($rolesData);
                if (!$savedRoles) {
                    throw new \Exception('Gagal menyimpan data user role.');
                }
            }

            $this->db->transComplete();

            // Cek status transaksi
            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal.');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'User berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            $this->db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menambahkan user: ' . $e->getMessage(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null) {}

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $model_user = new UserModel();
        $model_roles = new RolesModel();

        $data = $this->request->getJSON();

        // Validasi data
        if (!isset($data->id) || !isset($data->username) || !isset($data->roles)) {
            return $this->failValidationError('User data is incomplete');
        }

        $user = $model_user->find($data->id);
        if ($user) {
            $userData = [
                'username' => $data->username,
                'is_active' => isset($data->status) ? $data->status : $user['status'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $model_user->update($data->id, $userData);

            $userDataPersonil = [
                'nama_lengkap' => $data->nama_lengkap,
                'id_master_jabatan' => $data->id_master_jabatan,
                'id_master_organisasi' => $data->id_unit_organisasi,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $model_user->updateDataPersonil($data->id, $userDataPersonil);

            // $model_roles->where('id_user', $data->id)->delete();
            $model_roles->deleteUserRoleById($data->id);

            $rolesData = [];
            if ($data->roles) {
                foreach ($data->roles as $roleId) {
                    $rolesData[] = [
                        'id_user' => $data->id,
                        'id_role' => $roleId,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $model_roles->saveUserRole($rolesData);
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'User updated successfully'
            ]);
        }

        return $this->failNotFound('User not found');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
