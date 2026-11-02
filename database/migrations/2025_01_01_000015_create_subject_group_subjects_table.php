<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('subject_group_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_group_id')->nullable(false);
            $table->integer('subject_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_group_subjects');
    }
};
