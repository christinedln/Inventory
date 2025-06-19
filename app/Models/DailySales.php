<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySales extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'daily_revenue'
    ];

    protected $casts = [
        'date' => 'date',
        'daily_revenue' => 'decimal:2'
    ];
}