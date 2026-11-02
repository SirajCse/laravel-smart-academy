<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_id')->nullable(false);
            $table->integer('class_id')->nullable(false);
            $table->integer('section_id')->nullable(false);
            $table->integer('subject_id')->nullable(false);
            $table->integer('session_id')->nullable(false);
            $table->date('date_of_exam')->nullable(false);
            $table->time('start_time')->nullable(false);
            $table->time('end_time')->nullable(false);
            $table->string('room_no')->nullable(true);
            $table->decimal('full_marks')->nullable(false)->default(0);
            $table->decimal('passing_marks')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_schedules');
    }
};
