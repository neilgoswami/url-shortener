<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    public function getAllUrls()
    {
        return $this::where('is_active', 1)->orderByDesc('id')->simplePaginate(5);
    }

    public function getOriginalUrlByKey(string $key = ''): string
    {
        $result = $this::select('original_url')
            ->where('key', $key)
            ->where('is_active', 1)
            ->first();

        return $result ? $result['original_url'] : '';
    }
}
