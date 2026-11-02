<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('content', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->string('slug')->nullable(true);
            $table->text('description')->nullable(false);
            $table->integer('content_type_id')->nullable(false);
            $table->string('page_type')->nullable(true);
            $table->boolean('is_menu')->nullable(false)->default(0);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->date('publish_date')->nullable(true);
            $table->string('image')->nullable(true);
            $table->integer('gallery_id')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content');
    }
};
