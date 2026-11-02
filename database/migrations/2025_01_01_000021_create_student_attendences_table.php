<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_attendences', function (Blueprint $table) {
            $table->id();
            $table->integer('student_session_id')->nullable(false);
            $table->integer('attendence_type_id')->nullable(false);
            $table->date('date')->nullable(false);
            $table->string('remark')->nullable(true);
            $table->boolean('biometric_attendance')->nullable(false)->default(0);
            $table->integer('created_by')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_attendences');
    }
};
