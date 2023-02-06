<?php

namespace App\Services;

use App\Models\Url;

class UrlShortenerService
{
    public function generateUniqueKey(int $len = 5): string
    {
        $key = $this->generateKey($len);

        // Check if key exists or not for uniqueness
        $url = new Url;
        while ($url->getOriginalUrlByKey($key)) {
            $key = $this->generateKey($len);
        }

        return $key;
    }

    public function generateKey(int $len = 5): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $len; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        /* 
        
        // Get cryptographically secure random bytes
        $randomString = bin2hex(random_bytes($len));

        // OR
        $index = random_int(0, strlen($characters) - 1);
        
        */

        return $randomString;
    }
}
