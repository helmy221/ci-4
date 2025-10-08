<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'master_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'is_active', 'created_at', 'updated_at', 'last_login'];

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
        $user = $this->db->table('master_users')
            ->select('id, username, email, password, is_active, last_login')
            ->groupStart()
            ->where('email', $identifier)
            ->orWhere('username', $identifier)
            ->groupEnd()
            ->get()
            ->getRowArray();

        if (!$user) {
            return null;
        }

        // Ambil profile user
        $profile = $this->db->table('master_user_profiles')
            ->select('full_name, address, phone')
            ->where('user_id', $user['id'])
            ->get()
            ->getRowArray();
        $user = array_merge($user, $profile ?? []);

        // Ambil semua roles user
        $roles = $this->db->table('master_user_roles ur')
            ->select('r.id, r.name')
            ->join('master_roles r', 'r.id = ur.role_id', 'left')
            ->where('ur.user_id', $user['id'])
            ->get()
            ->getResultArray();

        $user['roles'] = array_column($roles, 'name');
        $roleIds = array_column($roles, 'id');

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
        $builder = $this->db->table('master_users u')
            ->select('u.id, u.username as name, u.email, u.is_active, u.created_at, r.name as role_name')
            ->join('master_user_roles ur', 'ur.user_id = u.id', 'left')
            ->join('master_roles r', 'r.id = ur.role_id', 'left')
            ->orderBy('u.id', 'ASC');

        if ($search) {
            $builder->groupStart()
                ->like('u.username', $search)
                ->orLike('u.email', $search)
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
            $id = $row['id'];
            if (!isset($users[$id])) {
                $users[$id] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
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
                ->orLike('email', $search)
                ->groupEnd();
        }

        if ($status) {
            $builder->where('is_active', $status);
        }

        return $builder->countAllResults();
    }

    public function getAllUserListDatatable()
    {
        $builder = $this->db->table('master_users u')
            ->select('u.id, 
                    u.username as name, 
                    u.email, 
                    u.is_active as is_active, 
                    u.created_at, 
                    GROUP_CONCAT(r.name) as roles', false)
            ->join('master_user_roles ur', 'ur.user_id = u.id', 'left')
            ->join('master_roles r', 'r.id = ur.role_id', 'left')
            ->groupBy('u.id');

        return $builder; // jangan ->get()->getResultArray()
    }

    public function getUserDataProfile($identifier)
    {
        return $this->select('master_users.id, master_users.username, master_users.email, master_users.password, master_user_profiles.full_name, master_roles.name as role_name')
            ->join('master_user_profiles', 'master_user_profiles.user_id = master_users.id', 'left')
            ->join('master_user_roles', 'master_user_roles.user_id = master_users.id', 'left')
            ->join('master_roles', 'master_roles.id = master_user_roles.role_id', 'left')
            ->where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
