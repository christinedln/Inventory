<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySales extends Model
{
    protected $fillable = [
        'date',
        'daily_revenue'
    ];

    protected $casts = [
        'date' => 'date',
        'daily_revenue' => 'decimal:2'
    ];
}