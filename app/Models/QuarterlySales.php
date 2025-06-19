<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarterlySales extends Model
{
    use HasFactory;

    protected $fillable = ['quarter', 'target', 'accomplished'];
}