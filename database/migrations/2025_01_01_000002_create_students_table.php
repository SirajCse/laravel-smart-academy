<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no')->nullable(false);
            $table->string('roll_no')->nullable(true);
            $table->date('admission_date')->nullable(true);
            $table->string('firstname')->nullable(false);
            $table->string('middlename')->nullable(true);
            $table->string('lastname')->nullable(false);
            $table->string('image')->nullable(true);
            $table->string('mobileno')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('state')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('pincode')->nullable(true);
            $table->text('current_address')->nullable(true);
            $table->text('permanent_address')->nullable(true);
            $table->string('guardian_is')->nullable(true);
            $table->string('guardian_name')->nullable(true);
            $table->string('guardian_relation')->nullable(true);
            $table->string('guardian_phone')->nullable(true);
            $table->string('guardian_email')->nullable(true);
            $table->string('guardian_occupation')->nullable(true);
            $table->text('guardian_address')->nullable(true);
            $table->string('guardian_image')->nullable(true);
            $table->string('father_name')->nullable(true);
            $table->string('father_phone')->nullable(true);
            $table->string('father_occupation')->nullable(true);
            $table->string('father_image')->nullable(true);
            $table->string('mother_name')->nullable(true);
            $table->string('mother_phone')->nullable(true);
            $table->string('mother_occupation')->nullable(true);
            $table->string('mother_image')->nullable(true);
            $table->string('gender')->nullable(true);
            $table->date('dob')->nullable(true);
            $table->integer('category_id')->nullable(true);
            $table->string('religion')->nullable(true);
            $table->string('cast')->nullable(true);
            $table->string('blood_group')->nullable(true);
            $table->string('height')->nullable(true);
            $table->string('weight')->nullable(true);
            $table->date('measurement_date')->nullable(true);
            $table->string('previous_school')->nullable(true);
            $table->text('previous_school_details')->nullable(true);
            $table->text('admission_reason')->nullable(true);
            $table->text('note')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->integer('disable_reason_id')->nullable(true);
            $table->date('disable_date')->nullable(true);
            $table->text('disable_note')->nullable(true);
            $table->string('rte')->nullable(true);
            $table->string('adhar_no')->nullable(true);
            $table->string('samagra_id')->nullable(true);
            $table->string('bank_account_no')->nullable(true);
            $table->string('bank_name')->nullable(true);
            $table->string('ifsc_code')->nullable(true);
            $table->string('national_identification_no')->nullable(true);
            $table->string('local_identification_no')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
