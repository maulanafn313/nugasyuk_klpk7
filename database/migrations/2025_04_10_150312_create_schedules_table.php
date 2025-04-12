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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('schedule_name');
            $table->enum('schedule_category',['task', 'activities']);
            $table->enum('priority',['important', 'very important', 'not important']);
            $table->dateTime('start_schedule');
            $table->dateTime('due_schedule');
            $table->dateTime('before_start_schedule');
            $table->string('upload_file');
            $table->string('url');
            $table->text('description');
            $table->enum('status', ['to-do','processed', 'completed', 'overdue']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
