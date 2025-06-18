<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model representing monthly sales report data.
class SalesReport extends Model
{
    use HasFactory; // Enables model factory for testing/seeding.

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_report'; // Explicitly sets the database table name.

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'month'; // Uses 'month' (e.g., YYYY-MM) as the primary key.

    // Indicates that the primary key is not an auto-incrementing integer.
    public $incrementing = false;

    // Specifies that the primary key 'month' is a string.
    protected $keyType = 'string';

    // Disables Laravel's default created_at/updated_at timestamp columns.
    public $timestamps = false;

    // Attributes that are mass assignable.
    protected $fillable = [
        'month',
        'total_sales_revenue',
        'total_sales',
        'target_sales_revenue',
        'accomplishment',
        'growth_per_month',
    ];
}