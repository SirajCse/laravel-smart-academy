<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_route', function (Blueprint $table) {
            $table->id();
            $table->string('route_title')->nullable(false);
            $table->decimal('fare')->nullable(false)->default(0);
            $table->string('from_place')->nullable(true);
            $table->string('to_place')->nullable(true);
            $table->text('description')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_route');
    }
};
