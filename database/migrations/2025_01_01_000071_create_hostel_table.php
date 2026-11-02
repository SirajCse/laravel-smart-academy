<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('hostel', function (Blueprint $table) {
            $table->id();
            $table->string('hostel_name')->nullable(false);
            $table->string('hostel_type')->nullable(true);
            $table->text('address')->nullable(true);
            $table->string('contact_number')->nullable(true);
            $table->integer('intake')->nullable(false)->default(0);
            $table->text('description')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel');
    }
};
