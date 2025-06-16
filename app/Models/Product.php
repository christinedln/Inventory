<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = [
        'product_name', 'clothing_type', 'color', 'size', 'date', 'quantity',
    ];
    protected $primaryKey = 'product_id';
    public $timestamps = false;
}



