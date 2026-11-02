<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id')->nullable(false);
            $table->integer('section_id')->nullable(false);
            $table->integer('subject_id')->nullable(false);
            $table->integer('staff_id')->nullable(false);
            $table->string('day')->nullable(false);
            $table->time('start_time')->nullable(false);
            $table->time('end_time')->nullable(false);
            $table->string('room_no')->nullable(true);
            $table->integer('session_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
