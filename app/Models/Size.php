<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $primaryKey = 'size_id';
<<<<<<< HEAD
    protected $fillable = ['size'];
=======

    protected $fillable = [
        'size',
    ];
>>>>>>> c12a34d5dffa73c6dce250e6ee4fbfb3854970a2
}
