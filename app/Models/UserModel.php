<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'master_user';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password', 'is_active', 'created_at', 'updated_at', 'last_login'];

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

    /**
     * Get users with roles, pagination, search, and status filter
     * 
     * @param int $limit
     * @param int $offset
     * @param string|null $search
     * @param string|null $status
     * @return array
     */

    public function getUsername($identifier)
    {
        return $this->where('username', $identifier)
            ->first();
    }

    public function insertUser(array $userData)
    {
        return $this->insert($userData);
    }

    public function getUserWithRolesAndPermissions(string $identifier): ?array
    {
        // Ambil user berdasarkan username atau email
        $user = $this->db->table('master_user')
            ->select('id_user, username, password, is_active, last_login')
            ->groupStart()
            ->Where('username', $identifier)
            ->groupEnd()
            ->get()
            ->getRowArray();

        if (!$user) {
            return null;
        }

        // Ambil profile user
        $profile = $this->db->table('master_personil')
            ->select('nama_lengkap, id_master_jabatan')
            ->where('id_user', $user['id_user'])
            ->get()
            ->getRowArray();
        $user = array_merge($user, $profile ?? []);

        // Ambil semua roles user
        $roles = $this->db->table('master_user_roles ur')
            ->select('r.id_role, r.name')
            ->join('master_roles r', 'r.id_role = ur.id_role', 'left')
            ->where('ur.id_user', $user['id_user'])
            ->get()
            ->getResultArray();

        $user['roles'] = array_column($roles, 'name');
        $roleIds = array_column($roles, 'id_user');

        // Ambil semua permissions dari roles
        $permissions = [];
        if (!empty($roleIds)) {
            $rolePermissions = $this->db->table('master_role_permissions rp')
                ->select('DISTINCT p.name', false)
                ->join('master_permissions p', 'p.id = rp.permission_id', 'left')
                ->whereIn('rp.role_id', $roleIds)
                ->get()
                ->getResultArray();

            $permissions = array_column($rolePermissions, 'name');
        }

        $user['permissions'] = $permissions;

        return $user;
    }

    public function getAllUserList($limit, $offset, $search, $status)
    {
        $where = "";
        if (!empty($search)) {
            $where = "AND u.username LIKE '%$search%'";
        }
        // Cek apakah status 1 dan this.showInactive diaktifkan
        if ($status == 1 && !$this->showInactive) {
            // Tambahkan kondisi WHERE untuk status aktif
            $where .= " AND u.is_active = $status";
        }
        $query = $this->db->query("SELECT u.id_user as id, 
                                            u.username as username, 
                                            mp.nama_lengkap as nama_lengkap, 
                                            mp.id_master_jabatan as id_master_jabatan, 
                                            mp.id_master_organisasi as id_master_organisasi, 
                                            u.is_active as status, 
                                            u.created_at
                                    FROM master_user u
                                    LEFT JOIN master_personil mp ON mp.id_user = u.id_user
                                    WHERE 1=1 -- Selalu true untuk memudahkan penambahan kondisi
                                    $where
                                    ORDER BY u.id_user ASC
                                    LIMIT $limit OFFSET $offset
                                ");

        $users = $query->getResultArray();

        // Step 2: Ambil roles berdasarkan id_user
        $userIds = array_column($users, 'id');  // Ambil array id_user dari hasil query user
        $userIds = implode(',', $userIds);

        // Query untuk mengambil roles
        $roleQuery = $this->db->query("SELECT ur.id_user, r.id_role, r.display_name
                                        FROM master_user_roles ur
                                        LEFT JOIN master_roles r ON r.id_role = ur.id_role
                                        WHERE ur.id_user IN ($userIds)
                                    ");

        $roles = $roleQuery->getResultArray();
        $rolesPerUser = [];
        foreach ($roles as $role) {
            $rolesPerUser[$role['id_user']][] = [
                'id_role' => $role['id_role'],
                'display_name' => $role['display_name']
            ];
        }

        // Step 4: Gabungkan data user dengan roles
        foreach ($users as &$user) {
            if (isset($rolesPerUser[$user['id']])) {
                $user['roles'] = $rolesPerUser[$user['id']];  // Menambahkan roles ke user
            } else {
                $user['roles'] = [];  // Jika tidak ada roles, set roles sebagai array kosong
            }
        }

        // Mengembalikan data user dengan roles
        return $users;
        //     // Gabungkan roles per user
        // $users = [];
        // foreach ($result as $row) {
        //     $id = $row['id_user'];
        //     if (!isset($users[$id])) {
        //         $users[$id] = [
        //             'id' => $row['id_user'],
        //             'username' => $row['username'],
        //             'nama_lengkap' => $row['nama_lengkap'],
        //             'roles' => [],
        //             'id_master_jabatan' => $row['id_master_jabatan'],
        //             'id_master_organisasi' => $row['id_master_organisasi'],
        //             'status' => $row['is_active'],
        //             'created_at' => $row['created_at']
        //         ];
        //     }
        //     if ($row['role_name']) {
        //         $users[$id]['roles'][] = [
        //             'id_role' => $row['id_role'],
        //             'display_name' => $row['role_name']
        //         ];
        //     }
        // }

        // return array_values($users);
    }

    /**
     * Count total users with optional search & status filter
     */
    public function countUsersList($search, $status)
    {
        $builder = $this->db->table($this->table);

        if ($search) {
            $builder->groupStart()
                ->like('username', $search)
                ->groupEnd();
        }

        if ($status) {
            $builder->where('is_active', $status);
        }

        return $builder->countAllResults();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    public function deactivateUser($userId)
    {
        return $this->update($userId, ['is_active' => '0']);
    }

    public function activateUser($userId)
    {
        return $this->update($userId, ['is_active' => '1']);
    }

    public function updateDataPersonil($userId, $userDataPersonil)
    {
        return $this->db->table('master_personil')->where('id_user', $userId)->update($userDataPersonil);
    }
}
