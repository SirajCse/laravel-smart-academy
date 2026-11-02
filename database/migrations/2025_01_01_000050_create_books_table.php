<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_title')->nullable(false);
            $table->string('book_no')->nullable(false);
            $table->string('isbn_no')->nullable(true);
            $table->integer('subject_id')->nullable(true);
            $table->string('rack_no')->nullable(true);
            $table->string('publish_year')->nullable(true);
            $table->string('publisher')->nullable(true);
            $table->string('author')->nullable(true);
            $table->integer('qty')->nullable(false)->default(1);
            $table->decimal('perunitcost')->nullable(true);
            $table->date('postdate')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('cover_image')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
