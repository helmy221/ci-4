<?php

if (! function_exists('hasPermission')) {
    function hasPermission(string $permission): bool
    {
        $session = session();
        $userId  = $session->get('user_id');

        if (! $userId) {
            return false;
        }

        $db = \Config\Database::connect();

        $query = $db->table('master_users u')
            ->select('p.name')
            ->join('master_user_roles ur', 'u.id = ur.user_id')
            ->join('master_roles r', 'ur.role_id = r.id')
            ->join('master_role_permissions rp', 'r.id = rp.role_id')
            ->join('master_permissions p', 'rp.permission_id = p.id')
            ->where('u.id', $userId)
            ->where('p.name', $permission)
            ->get();

        return $query->getNumRows() > 0;
    }
}
