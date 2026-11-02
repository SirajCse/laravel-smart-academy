<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_config', function (Blueprint $table) {
            $table->id();
            $table->string('mailer')->nullable(false);
            $table->string('smtp_host')->nullable(true);
            $table->integer('smtp_port')->nullable(true);
            $table->string('smtp_username')->nullable(true);
            $table->string('smtp_password')->nullable(true);
            $table->string('encryption')->nullable(true);
            $table->string('from_email')->nullable(true);
            $table->string('from_name')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_config');
    }
};
