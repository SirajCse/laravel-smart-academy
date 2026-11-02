<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_users', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id')->nullable(true);
            $table->integer('student_id')->nullable(true);
            $table->integer('parent_id')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->datetime('last_seen')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_users');
    }
};
