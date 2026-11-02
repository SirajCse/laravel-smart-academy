<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id')->nullable(true);
            $table->string('role')->nullable(true);
            $table->integer('department_id')->nullable(true);
            $table->integer('designation_id')->nullable(true);
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('emergency_phone')->nullable(true);
            $table->string('gender')->nullable(true);
            $table->string('image')->nullable(true);
            $table->date('dob')->nullable(true);
            $table->date('joining_date')->nullable(true);
            $table->date('leaving_date')->nullable(true);
            $table->text('address')->nullable(true);
            $table->string('qualification')->nullable(true);
            $table->string('work_experience')->nullable(true);
            $table->text('note')->nullable(true);
            $table->string('facebook')->nullable(true);
            $table->string('twitter')->nullable(true);
            $table->string('linkedin')->nullable(true);
            $table->string('instagram')->nullable(true);
            $table->string('resume')->nullable(true);
            $table->string('joining_letter')->nullable(true);
            $table->string('documents')->nullable(true);
            $table->string('signature')->nullable(true);
            $table->decimal('salary')->nullable(true);
            $table->string('account_number')->nullable(true);
            $table->string('bank_name')->nullable(true);
            $table->string('ifsc_code')->nullable(true);
            $table->string('bank_branch')->nullable(true);
            $table->string('epf_number')->nullable(true);
            $table->decimal('basic_salary')->nullable(true);
            $table->string('work_shift')->nullable(true);
            $table->string('work_location')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
