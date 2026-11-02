<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('transport_member', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->nullable(false);
            $table->string('member_type')->nullable(false);
            $table->integer('transport_route_vehicle_id')->nullable(false);
            $table->date('start_date')->nullable(false);
            $table->date('end_date')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_member');
    }
};
