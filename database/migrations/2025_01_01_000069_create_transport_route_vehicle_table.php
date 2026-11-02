<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_route_vehicle', function (Blueprint $table) {
            $table->id();
            $table->integer('transport_route_id')->nullable(false);
            $table->integer('transport_vehicle_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_route_vehicle');
    }
};
