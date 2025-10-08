<?php

use Config\Services;

if (!function_exists('auth')) {
    function auth()
    {
        return new class {
            private $session;
            private $encrypter;

            public function __construct()
            {
                $this->session   = Services::session();
                $this->encrypter = service('encrypter');
            }

            public function user()
            {
                $user = $this->session->get('user');

                if (empty($user)) {
                    return null;
                }

                // Jika data user terenkripsi, dekripsi dulu
                if (is_string($user)) {
                    try {
                        $decrypted = $this->encrypter->decrypt($user);
                        $user = json_decode($decrypted, true);
                    } catch (\Throwable $e) {
                        log_message('error', 'Failed to decrypt user session: ' . $e->getMessage());
                        return null;
                    }
                }

                // Jika hasilnya bukan array valid, keluar
                if (!is_array($user)) {
                    return null;
                }

                // Pastikan roles dan permissions selalu dalam bentuk array
                $user['roles'] = is_array($user['roles'] ?? null)
                    ? $user['roles']
                    : (empty($user['roles']) ? [] : explode(',', (string) $user['roles']));

                $user['permissions'] = is_array($user['permissions'] ?? null)
                    ? $user['permissions']
                    : (empty($user['permissions']) ? [] : explode(',', (string) $user['permissions']));


                return new class($user) {
                    private $user;

                    public function __construct(array $user)
                    {
                        $this->user = $user;
                    }

                    public function id()
                    {
                        return $this->user['id'] ?? null;
                    }

                    public function username()
                    {
                        return $this->user['name'] ?? null;
                    }

                    public function fullname()
                    {
                        return $this->user['fullname'] ?? null;
                    }

                    public function email()
                    {
                        return $this->user['email'] ?? null;
                    }

                    public function roles()
                    {
                        return $this->user['roles'] ?? [];
                    }

                    public function token()
                    {
                        return $this->user['token'] ?? [];
                    }

                    public function permissions()
                    {
                        return $this->user['permissions'] ?? [];
                    }

                    public function hasRole(string $role): bool
                    {
                        return in_array($role, $this->roles(), true);
                    }

                    public function can(string $permission): bool
                    {
                        return in_array($permission, $this->permissions(), true);
                    }
                };
            }

            public function check()
            {
                return $this->session->has('user');
            }

            public function logout()
            {
                $this->session->remove(['user', 'isLoggedIn']);
            }
        };
    }
}
