<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees_discount', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('code')->nullable(false);
            $table->text('description')->nullable(true);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->integer('session_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees_discount');
    }
};
