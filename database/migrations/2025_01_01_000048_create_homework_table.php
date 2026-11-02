<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id')->nullable(false);
            $table->integer('section_id')->nullable(false);
            $table->integer('subject_id')->nullable(false);
            $table->integer('staff_id')->nullable(false);
            $table->date('homework_date')->nullable(false);
            $table->date('submit_date')->nullable(false);
            $table->decimal('marks')->nullable(true);
            $table->text('description')->nullable(false);
            $table->string('document')->nullable(true);
            $table->integer('session_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
