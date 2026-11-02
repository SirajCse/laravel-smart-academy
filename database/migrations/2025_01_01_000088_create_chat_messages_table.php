<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('chat_user_id')->nullable(false);
            $table->text('message')->nullable(false);
            $table->string('file')->nullable(true);
            $table->integer('sender_id')->nullable(false);
            $table->string('sender_type')->nullable(false);
            $table->boolean('is_read')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
