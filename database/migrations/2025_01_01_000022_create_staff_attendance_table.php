<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('staff_attendance', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id')->nullable(false);
            $table->integer('attendence_type_id')->nullable(false);
            $table->date('date')->nullable(false);
            $table->string('remark')->nullable(true);
            $table->boolean('biometric_attendance')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_attendance');
    }
};
