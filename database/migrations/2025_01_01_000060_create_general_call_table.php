<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('general_call', function (Blueprint $table) {
            $table->id();
            $table->string('call_type')->nullable(false);
            $table->integer('call_by')->nullable(true);
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(false);
            $table->date('date')->nullable(false);
            $table->text('description')->nullable(true);
            $table->date('follow_up_date')->nullable(true);
            $table->date('next_follow_up_date')->nullable(true);
            $table->string('status')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_call');
    }
};
