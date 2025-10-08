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
            'iss' => 'ci4-app',        // issuer
            'sub' => $user['id'],      // subject (user_id)
            'email' => $user['email'],
            'iat' => time(),           // issued at
            'exp' => time() + $this->expire
        ];

        return JWT::encode($payload, $this->key, $this->algo);
    }

    public function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->key, $this->algo));
        } catch (\Exception $e) {
            return null;
        }
    }
}
