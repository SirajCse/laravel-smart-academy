<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('homework_evaluation', function (Blueprint $table) {
            $table->id();
            $table->integer('homework_id')->nullable(false);
            $table->integer('student_session_id')->nullable(false);
            $table->string('evaluation')->nullable(true);
            $table->decimal('marks')->nullable(true);
            $table->text('remark')->nullable(true);
            $table->string('file')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework_evaluation');
    }
};
