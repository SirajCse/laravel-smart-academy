<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frontcms_setting', function (Blueprint $table) {
            $table->id();
            $table->string('theme')->nullable(false);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->string('sidebar_option')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontcms_setting');
    }
};
