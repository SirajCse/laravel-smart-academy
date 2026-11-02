<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('multi_branch', function (Blueprint $table) {
            $table->id();
            $table->string('hostname')->nullable(false);
            $table->string('branch_name')->nullable(false);
            $table->string('database')->nullable(false);
            $table->string('username')->nullable(true);
            $table->string('password')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('multi_branch');
    }
};
