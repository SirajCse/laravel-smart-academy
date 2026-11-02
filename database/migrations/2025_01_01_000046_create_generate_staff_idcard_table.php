<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('generate_staff_idcard', function (Blueprint $table) {
            $table->id();
            $table->integer('idcard_template_id')->nullable(false);
            $table->integer('staff_id')->nullable(false);
            $table->string('file')->nullable(true);
            $table->integer('created_by')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generate_staff_idcard');
    }
};
