<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_report', function (Blueprint $table) {
            $table->date('month')->primary();
            $table->decimal('total_sales_revenue', 15, 2);
            $table->integer('total_sales');
            $table->integer('target_sales_revenue');
            $table->decimal('accomplishment', 5, 2);
            $table->decimal('growth_per_month', 5, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_report');
    }
};
