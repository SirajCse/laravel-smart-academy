<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('gateway_ins', function (Blueprint $table) {
            $table->id();
            $table->string('gateway')->nullable(false);
            $table->string('reference_no')->nullable(false);
            $table->string('payment_id')->nullable(true);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->string('currency')->nullable(true);
            $table->string('status')->nullable(false);
            $table->text('payload')->nullable(true);
            $table->string('ip_address')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gateway_ins');
    }
};
