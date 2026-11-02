<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('student_fees_deposite', function (Blueprint $table) {
            $table->id();
            $table->integer('student_fees_id')->nullable(false);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->string('payment_mode')->nullable(false);
            $table->date('date')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fees_deposite');
    }
};
