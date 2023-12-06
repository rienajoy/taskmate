<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 100);
            $table->text('description', 1000)->nullable();
            $table->dateTime('scheduled')->default(now()); // Set default value here
            $table->boolean('is_recurring')->default(false);
            $table->enum('category', ['Personal', 'Work']);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};