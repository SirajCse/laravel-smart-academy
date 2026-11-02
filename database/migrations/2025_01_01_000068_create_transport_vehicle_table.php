<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('transport_vehicle', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_no')->nullable(false);
            $table->string('vehicle_model')->nullable(true);
            $table->string('driver_name')->nullable(true);
            $table->string('driver_phone')->nullable(true);
            $table->decimal('vehicle_fee')->nullable(false)->default(0);
            $table->integer('capacity')->nullable(false)->default(0);
            $table->text('description')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_vehicle');
    }
};
