<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('libarary_members', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->nullable(false);
            $table->string('member_type')->nullable(false);
            $table->string('library_card_no')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libarary_members');
    }
};
