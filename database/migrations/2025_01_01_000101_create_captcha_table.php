<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('captcha', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable(false);
            $table->string('captcha')->nullable(false);
            $table->datetime('created_at')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('captcha');
    }
};
