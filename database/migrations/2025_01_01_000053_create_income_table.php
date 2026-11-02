<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->integer('income_head_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('invoice_no')->nullable(true);
            $table->date('date')->nullable(false);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->text('description')->nullable(true);
            $table->string('documents')->nullable(true);
            $table->string('payment_mode')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income');
    }
};
