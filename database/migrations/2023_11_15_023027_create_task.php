<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100); // REQ4: Task title limited to 100 characters
            $table->text('description', 1000)->nullable(); // REQ4: Task description limited to 1000 characters
            $table->boolean('is_recurring')->default(false); // REQ6: Indicator for recurring tasks
            $table->enum('category', ['Personal', 'Work']); // REQ7: Predefined categories
            $table->boolean('completed')->default(false); // REQ11: Indicator for task completion
            $table->timestamps();
            $table->dateTime('scheduled_at')->default(now());

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
