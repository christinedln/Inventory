<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public $timestamps = true;

    protected $fillable = [
        'product_name',
        'clothing_type',
        'color',
        'size',
        'quantity',
        'price',
        'image_path',
        'last_reason',
        'status',
        'status',
        'requested_reduction',
    ];
}

