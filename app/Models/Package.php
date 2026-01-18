<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'type', 'price', 'features', 'is_featured'];
    protected $casts = [
        'is_featured' => 'boolean',
        'price' => 'decimal:2'
    ];
}