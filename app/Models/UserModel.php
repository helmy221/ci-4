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

    public function getUserData($identifier)
    {
        return $this->where('email', $identifier)
            ->orWhere('username', $identifier)
            ->Where('is_active', true)
            ->first();
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

    public function getAllUserList($limit = 10, $offset = 0, $search = null, $status = null)
    {
        $builder = $this->db->table('master_user u')
            ->select('u.id_user, u.username as username, mp.nama_lengkap, u.is_active, u.created_at, r.description as role_name')
            ->join('master_personil mp', 'mp.id_user = u.id_user', 'left')
            ->join('master_user_roles ur', 'ur.id_user = u.id_user', 'left')
            ->join('master_roles r', 'r.id_role = ur.id_role', 'left')
            ->orderBy('u.id_user', 'ASC');

        if ($search) {
            $builder->groupStart()
                ->like('u.username', $search)
                ->groupEnd();
        }

        if ($status) {
            $builder->where('u.is_active', $status);
        }

        $builder->limit($limit, $offset);

        $query = $builder->get()->getResultArray();

        // Gabungkan roles per user
        $users = [];
        foreach ($query as $row) {
            $id = $row['id_user'];
            if (!isset($users[$id])) {
                $users[$id] = [
                    'id' => $row['id_user'],
                    'username' => $row['username'],
                    'nama_lengkap' => $row['nama_lengkap'],
                    'roles' => [],
                    'status' => $row['is_active'],
                    'created_at' => $row['created_at']
                ];
            }
            if ($row['role_name']) {
                $users[$id]['roles'][] = $row['role_name'];
            }
        }

        return array_values($users);
    }

    /**
     * Count total users with optional search & status filter
     */
    public function countUsersList($search = null, $status = null)
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

    public function softDeleteUser($userId)
    {
        return $this->update($userId, ['is_active' => '0']);
    }
}
