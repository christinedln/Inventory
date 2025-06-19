<?php
// filepath: c:\laragon\www\Inventory\app\Models\TargetInputForm.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetInputForm extends Model
{
    use HasFactory;

    protected $table = 'target_sales';
    protected $fillable = ['quarter', 'target_revenue'];

    public static $rules = [
        'quarter' => 'required|integer|min:1|max:4|unique:target_sales',
        'target_revenue' => 'required|numeric|min:0',
    ];
}