<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frontcms_menu', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->string('slug')->nullable(true);
            $table->string('url')->nullable(true);
            $table->integer('parent_id')->nullable(true)->default(0);
            $table->integer('page_id')->nullable(true);
            $table->integer('order')->nullable(true)->default(0);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->boolean('open_in_new_tab')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontcms_menu');
    }
};
