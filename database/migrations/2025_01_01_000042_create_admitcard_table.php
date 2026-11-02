<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('admitcard', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->integer('exam_group_id')->nullable(false);
            $table->string('template')->nullable(true);
            $table->string('background')->nullable(true);
            $table->string('logo')->nullable(true);
            $table->string('left_logo')->nullable(true);
            $table->string('right_logo')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admitcard');
    }
};
