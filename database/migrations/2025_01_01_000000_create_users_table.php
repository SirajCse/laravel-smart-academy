<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable(false);
            $table->string('username')->nullable(false);
            $table->string('password')->nullable(false);
            $table->integer('user_id')->nullable(true);
            $table->string('name')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('image')->nullable(true);
            $table->string('gender')->nullable(true);
            $table->text('address')->nullable(true);
            $table->string('verification_code')->nullable(true);
            $table->boolean('is_verified')->nullable(false)->default(0);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->boolean('is_parent')->nullable(false)->default(0);
            $table->integer('parent_id')->nullable(true);
            $table->integer('language_id')->nullable(true);
            $table->datetime('last_login')->nullable(true);
            $table->string('device_token')->nullable(true);
            $table->string('api_token')->nullable(true);
            $table->string('remember_token')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
