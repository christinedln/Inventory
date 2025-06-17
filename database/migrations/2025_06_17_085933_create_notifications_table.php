<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id'); 
            $table->string('notification', 255);
            $table->string('type', 50);
            $table->string('category', 50);
            $table->string('notifiable_id', 50)->nullable();
            $table->string('status')->default('unresolved'); 
            $table->timestamp('created_at')->useCurrent(); 
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
