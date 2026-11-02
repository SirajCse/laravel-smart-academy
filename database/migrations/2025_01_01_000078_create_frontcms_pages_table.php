<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frontcms_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->text('description')->nullable(false);
            $table->string('meta_title')->nullable(true);
            $table->string('meta_keyword')->nullable(true);
            $table->string('meta_description')->nullable(true);
            $table->date('publish_date')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->string('image')->nullable(true);
            $table->string('page_type')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontcms_pages');
    }
};
