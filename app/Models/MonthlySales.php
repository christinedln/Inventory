<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlySales extends Model
{
    protected $fillable = [
        'month',
        'year',
        'total_sales',
        'total_quantity'
    ];

    public function dailySales()
    {
        return $this->hasMany(DailySales::class);
    }
}