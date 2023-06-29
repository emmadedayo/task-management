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
            $table->string('task_name');
            $table->string('task_description');
            $table->enum('task_priority', ['LOW', 'MEDIUM', 'HIGH'])->default('LOW');
            $table->date('task_start_date');
            $table->date('task_due_date');
            $table->enum('task_status', ['PENDING', 'IN-PROGRESS', 'BLOCKER', 'COMPLETED'])->default('PENDING');
            $table->string('task_final_remarks')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
