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
            $table->string('product_name', 100);
            $table->string('clothing_type', 50);
            $table->string('color', 30);
            $table->string('size', 20);
            $table->integer('quantity');
            $table->integer('requested_reduction')->nullable(); 
            $table->decimal('price', 10, 2);
            $table->string('image_path');
            $table->string('last_reason', 1000)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
