<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\JWT as JWTConfig;

class JwtLib
{
    protected $key;
    protected $algo;
    protected $expire;

    public function __construct()
    {
        $config = new JWTConfig();
        $this->key    = $config->key;
        $this->algo   = $config->algo;
        $this->expire = $config->expire;
    }

    public function generateToken($user)
    {
        $payload = [
            'iss'       => 'ci4-app',        // issuer
            'sub'       => $user['id_user'],      // subject (user_id)
            'username'  => $user['username'],
            'iat'       => time(),           // issued at
            'exp'       => time() + $this->expire
        ];

        return JWT::encode($payload, $this->key, $this->algo);
    }

    public function validateToken($token)
    {
        try {
            $decoded =  JWT::decode($token, new Key($this->key, $this->algo));
            // Cek expired token (secara otomatis diperiksa oleh JWT)
            if (isset($decoded->exp) && $decoded->exp < time()) {
                return false; // token expired
            }

            return $decoded; // token valid
        } catch (\Exception $e) {
            return null;
        }
    }
}
