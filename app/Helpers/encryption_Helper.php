<?php

use Config\Services;

if (!function_exists('encrypt_data')) {
    function encrypt_data(array $data): string
    {
        // Pastikan service encryption dimuat dari CodeIgniter kernel
        $encryption = Services::encryption();
        // dd($encryption);
        // Ubah array ke JSON sebelum dienkripsi
        $json = json_encode($data);

        return $encryption->encrypt($json);
    }
}

if (!function_exists('decrypt_data')) {
    function decrypt_data(string $encrypted): array
    {
        $encryption = Services::encryption();

        $decrypted = $encryption->decrypt($encrypted);
        return json_decode($decrypted, true);
    }
}
