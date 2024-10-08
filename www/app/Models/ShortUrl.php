<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory;
    // create model with original_url and shortened_url
    protected $fillable = ['original_url', 'shortened_url'];

    // generate short url
    public static function generateShortUrl()
    {
        do {
            $shortened = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        } while (self::where('shortened_url', $shortened)->exists());

        return $shortened;
    }
}
