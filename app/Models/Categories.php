<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'uuid',
        'name',
        'slug'
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
