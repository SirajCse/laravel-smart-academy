<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('sch_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->nullable(false);
            $table->string('school_code')->nullable(true);
            $table->integer('session_id')->nullable(false);
            $table->string('start_month')->nullable(true);
            $table->string('start_week')->nullable(true);
            $table->integer('lang_id')->nullable(true);
            $table->string('timezone')->nullable(true);
            $table->string('theme')->nullable(true);
            $table->boolean('rtl')->nullable(false)->default(0);
            $table->boolean('is_rtl')->nullable(false)->default(0);
            $table->string('currency')->nullable(true);
            $table->string('currency_symbol')->nullable(true);
            $table->string('currency_place')->nullable(true);
            $table->string('date_format')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('email')->nullable(true);
            $table->text('address')->nullable(true);
            $table->string('logo')->nullable(true);
            $table->string('sidebar')->nullable(true);
            $table->string('student_login')->nullable(true);
            $table->string('parent_login')->nullable(true);
            $table->string('staff_login')->nullable(true);
            $table->string('admin_login')->nullable(true);
            $table->string('super_admin_login')->nullable(true);
            $table->string('marksheet')->nullable(true);
            $table->string('mobile_app_url')->nullable(true);
            $table->string('app_primary_color')->nullable(true);
            $table->string('app_secondary_color')->nullable(true);
            $table->string('app_logo')->nullable(true);
            $table->string('copyright')->nullable(true);
            $table->string('youtube_url')->nullable(true);
            $table->string('facebook_url')->nullable(true);
            $table->string('twitter_url')->nullable(true);
            $table->string('linkedin_url')->nullable(true);
            $table->string('instagram_url')->nullable(true);
            $table->string('pinterest_url')->nullable(true);
            $table->string('office_hours')->nullable(true);
            $table->text('languages')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sch_settings');
    }
};
