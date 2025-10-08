<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class JWT extends BaseConfig
{
    public string $key;
    public string $algo;
    public int $expire;

    public function __construct()
    {
        parent::__construct();

        // $appConfig = config('App');
        $this->key    = env('JWT_SECRET', 'fallbackKey'); // kalau env kosong
        $this->algo   = env('JWT_ALGO', 'HS256');
        $this->expire = (int) env('JWT_EXPIRE', 3600);
        // $this->expire = $appConfig->sessionExpiration; // sinkron dengan session
    }
}
