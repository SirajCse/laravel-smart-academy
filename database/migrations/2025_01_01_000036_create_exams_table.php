<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_group_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);
            $table->boolean('publish_result')->nullable(false)->default(0);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->date('date')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
