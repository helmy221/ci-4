<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function createJWT($data)
{
    $key = getenv('JWT_SECRET');
    $issuedAt   = time();
    $expire     = $issuedAt + 3600; // 1 jam

    $payload = array_merge($data, [
        'iat' => $issuedAt,
        'exp' => $expire,
    ]);

    return JWT::encode($payload, $key, 'HS256');
}

function decodeJWT($token)
{
    $key = getenv('JWT_SECRET');
    return JWT::decode($token, new Key($key, 'HS256'));
}
