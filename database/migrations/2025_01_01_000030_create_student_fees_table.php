<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->integer('student_fees_master_id')->nullable(false);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->decimal('amount_discount')->nullable(false)->default(0);
            $table->decimal('amount_fine')->nullable(false)->default(0);
            $table->string('payment_mode')->nullable(false);
            $table->text('description')->nullable(true);
            $table->date('date')->nullable(false);
            $table->integer('received_by')->nullable(true);
            $table->string('invoice_no')->nullable(true);
            $table->string('payment_transaction_id')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};
