<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->string('clothing_type');
            $table->string('color');
            $table->string('size');
            $table->date('date');
            $table->integer('quantity');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
