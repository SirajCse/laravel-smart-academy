<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_fees_master', function (Blueprint $table) {
            $table->id();
            $table->integer('student_session_id')->nullable(false);
            $table->integer('fee_session_group_id')->nullable(false);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->decimal('discount_amount')->nullable(false)->default(0);
            $table->boolean('is_system')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fees_master');
    }
};
