<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiry', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('purpose')->nullable(false);
            $table->string('source')->nullable(true);
            $table->date('date')->nullable(false);
            $table->date('next_follow_up_date')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('status')->nullable(false);
            $table->integer('assigned_to')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry');
    }
};
