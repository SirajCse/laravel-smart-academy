<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('send_notification', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->text('message')->nullable(false);
            $table->string('notification_type')->nullable(false);
            $table->string('sent_to')->nullable(false);
            $table->integer('role_id')->nullable(true);
            $table->integer('class_id')->nullable(true);
            $table->integer('section_id')->nullable(true);
            $table->integer('send_by')->nullable(true);
            $table->datetime('send_date')->nullable(false);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('send_notification');
    }
};
