<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->integer('complaint_type_id')->nullable(false);
            $table->string('source')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->date('date')->nullable(false);
            $table->text('description')->nullable(false);
            $table->text('action_taken')->nullable(true);
            $table->integer('assigned')->nullable(true);
            $table->string('status')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
