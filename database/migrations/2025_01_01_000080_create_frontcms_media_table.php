<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('frontcms_media', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->string('file')->nullable(false);
            $table->string('file_type')->nullable(false);
            $table->integer('gallery_id')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontcms_media');
    }
};
