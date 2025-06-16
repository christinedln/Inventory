<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category', 'color', 'size', 'date', 'quantity'
    ];
    
    protected $casts = [
        'date' => 'date'
    ];
}