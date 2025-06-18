<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing monthly sales report data.
 */
class SalesReport extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_report';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'month';

    public $incrementing = false;
    protected $keyType = 'string';
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