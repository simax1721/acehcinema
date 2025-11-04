<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getThumbnailAttribute($value)
    {
        if (!$value) return null;

        $base = rtrim(config('app.assets_uploads_url'), '/');
        return $base . '/' . ltrim($value, '/');
    }

    /**
     * Akses URL penuh untuk poster.
     */
    public function getPosterAttribute($value)
    {
        if (!$value) return null;

        $base = rtrim(config('app.assets_uploads_url'), '/');
        return $base . '/' . ltrim($value, '/');
    }
}
