<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frontcms_page_content', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id')->nullable(false);
            $table->string('section')->nullable(false);
            $table->text('content')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontcms_page_content');
    }
};
