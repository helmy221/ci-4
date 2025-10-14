<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\JWT as JWTConfig;
use App\Models\TokenModel;

class JwtLib
{
    protected $key;
    protected $algo;
    protected $expire;
    protected $tokenModel;

    public function __construct()
    {

        $config = new JWTConfig();
        $this->key    = $config->key;
        $this->algo   = $config->algo;
        $this->expire = $config->expire;
        $this->tokenModel = new TokenModel();
    }

    public function generateToken($user)
    {

        // dd($user);
        // exit;
        $tokenId = bin2hex(random_bytes(16));
        $issuedAt = time();
        $exp = time() + $this->expire;
        $payload = [
            'iss'       => 'ci4-app',
            'sub'       => $user['id_user'],
            'username'  => $user['username'],
            'roles'     => $user['roles'],
            'jti'       => $tokenId,
            'iat'       => $issuedAt,
            'exp'       => $exp
        ];

        $jwt = JWT::encode($payload, $this->key, $this->algo);

        // Simpan ke tabel user_tokens
        $this->tokenModel->insert([
            'id_user'   => $user['id_user'],
            'jti'       => $tokenId,
            'issued_at' => date('Y-m-d H:i:s', $issuedAt),
            'expires_at' => date('Y-m-d H:i:s', $exp),
        ]);

        return $jwt;
    }

    public function decodeToken(string $jwt)
    {
        try {
            $decoded = JWT::decode($jwt, new Key($this->key, $this->algo));
            return $decoded;
        } catch (\Firebase\JWT\ExpiredException $e) {
            return ['error' => 'Token expired'];
        } catch (\Exception $e) {
            return ['error' => 'Invalid token'];
        }
    }

    public function validateToken(string $jwt, ?string $sessionJti = null): bool
    {
        $decoded = $this->decodeToken($jwt);

        if (isset($decoded['error'])) {
            return false;
        }

        $tokenJti = $decoded->jti ?? null;

        // Cocokkan dengan session
        if ($sessionJti && $tokenJti !== $sessionJti) {
            return false;
        }

        // Cek di database
        $record = $this->tokenModel
            ->where('jti', $tokenJti)
            ->where('revoked', false)
            ->first();

        return $record !== null;
    }

    public function refreshToken(string $oldJwt, array $user, int $duration = 3600): ?string
    {
        $decoded = $this->decodeToken($oldJwt);
        // $decoded = JWT::decode($oldJwt, new Key($this->key, $this->algo));

        if (isset($decoded['error'])) {
            return null;
        }

        $oldJti = $decoded->jti ?? null;
        if ($oldJti) {
            $this->tokenModel->where('jti', $oldJti)->set(['revoked' => true])->update();
        }

        // Generate token baru
        return $this->generateToken($user, $duration);
    }

    public function revokeToken(string $jti): bool
    {
        if (empty($jti)) {
            log_message('warning', 'revokeToken dipanggil tapi jti kosong (mungkin session expired)');
            return false;
        }

        return $this->tokenModel
            ->where('jti', $jti)
            ->set(['revoked' => true])
            ->update();
    }

    public function extractJti(string $jwt): ?string
    {
        try {
            $tokenParts = explode('.', $jwt);
            $payload = json_decode(base64_decode($tokenParts[1]), true);
            return $payload['jti'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
