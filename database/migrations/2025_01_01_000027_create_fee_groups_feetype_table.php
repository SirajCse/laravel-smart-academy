<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_groups_feetype', function (Blueprint $table) {
            $table->id();
            $table->integer('feegroup_id')->nullable(false);
            $table->integer('feetype_id')->nullable(false);
            $table->decimal('amount')->nullable(false)->default(0);
            $table->integer('session_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_groups_feetype');
    }
};
