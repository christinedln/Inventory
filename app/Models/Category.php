<?php
<<<<<<< HEAD
namespace App\Models;

=======

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> c12a34d5dffa73c6dce250e6ee4fbfb3854970a2
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
<<<<<<< HEAD
    protected $primaryKey = 'category_id';
    protected $fillable = ['category'];
=======
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category',
    ];
>>>>>>> c12a34d5dffa73c6dce250e6ee4fbfb3854970a2
}
