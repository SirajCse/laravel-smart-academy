<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_config', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->nullable(false);
            $table->string('api_key')->nullable(true);
            $table->string('sender_id')->nullable(true);
            $table->string('api_url')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_config');
    }
};
