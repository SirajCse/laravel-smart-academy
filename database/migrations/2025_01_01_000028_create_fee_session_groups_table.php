<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('fee_session_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id')->nullable(false);
            $table->integer('fee_groups_feetype_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_session_groups');
    }
};
