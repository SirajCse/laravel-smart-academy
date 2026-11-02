<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_fees_discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('student_fees_master_id')->nullable(false);
            $table->integer('fees_discount_id')->nullable(false);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->string('status')->nullable(false);
            $table->text('description')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fees_discounts');
    }
};
