<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('audit', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(true);
            $table->string('user_type')->nullable(true);
            $table->string('module')->nullable(false);
            $table->string('action')->nullable(false);
            $table->text('message')->nullable(true);
            $table->string('ip_address')->nullable(true);
            $table->string('user_agent')->nullable(true);
            $table->text('old_data')->nullable(true);
            $table->text('new_data')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit');
    }
};
