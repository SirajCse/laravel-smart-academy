<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_schedule_id')->nullable(false);
            $table->integer('student_session_id')->nullable(false);
            $table->decimal('get_marks')->nullable(false)->default(0);
            $table->text('note')->nullable(true);
            $table->boolean('is_absent')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
