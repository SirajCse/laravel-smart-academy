<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id')->nullable(false);
            $table->integer('subject_id')->nullable(false);
            $table->integer('class_id')->nullable(false);
            $table->integer('section_id')->nullable(false);
            $table->integer('session_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_subjects');
    }
};
