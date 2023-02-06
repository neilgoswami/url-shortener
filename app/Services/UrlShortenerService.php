<?php

namespace App\Services;

use App\Models\Url;

class UrlShortenerService
{
    public function generateUniqueKey(int $len = 5): string
    {
        $key = $this->generateKey($len);

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

        return $randomString;
    }
}
