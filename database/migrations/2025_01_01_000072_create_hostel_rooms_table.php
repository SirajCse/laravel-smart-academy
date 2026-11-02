<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostel_rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('hostel_id')->nullable(false);
            $table->string('room_type')->nullable(false);
            $table->string('room_no')->nullable(false);
            $table->integer('no_of_bed')->nullable(false)->default(0);
            $table->decimal('cost_per_bed')->nullable(false)->default(0);
            $table->text('description')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel_rooms');
    }
};
