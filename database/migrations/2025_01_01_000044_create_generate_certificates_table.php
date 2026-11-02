<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generate_certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('certificate_id')->nullable(false);
            $table->integer('student_id')->nullable(false);
            $table->text('text')->nullable(true);
            $table->string('file')->nullable(true);
            $table->integer('created_by')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generate_certificates');
    }
};
