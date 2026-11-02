<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('belong_to')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('type')->nullable(false);
            $table->string('label')->nullable(false);
            $table->text('options')->nullable(true);
            $table->boolean('is_required')->nullable(false)->default(0);
            $table->boolean('is_unique')->nullable(false)->default(0);
            $table->boolean('is_visible_on_list')->nullable(false)->default(0);
            $table->integer('order')->nullable(false)->default(0);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
    }
};
