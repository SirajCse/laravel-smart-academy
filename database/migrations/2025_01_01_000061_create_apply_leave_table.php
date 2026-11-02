<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('apply_leave', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id')->nullable(true);
            $table->integer('student_session_id')->nullable(true);
            $table->date('apply_date')->nullable(false);
            $table->date('leave_from')->nullable(false);
            $table->date('leave_to')->nullable(false);
            $table->text('reason')->nullable(false);
            $table->string('status')->nullable(false);
            $table->integer('approved_by')->nullable(true);
            $table->date('approved_date')->nullable(true);
            $table->text('remark')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apply_leave');
    }
};
