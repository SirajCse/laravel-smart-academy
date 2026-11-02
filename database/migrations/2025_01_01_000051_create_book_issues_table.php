<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->integer('book_id')->nullable(false);
            $table->integer('member_id')->nullable(false);
            $table->string('member_type')->nullable(false);
            $table->date('issue_date')->nullable(false);
            $table->date('return_date')->nullable(false);
            $table->date('actual_return_date')->nullable(true);
            $table->boolean('is_returned')->nullable(false)->default(0);
            $table->decimal('fine_amount')->nullable(true);
            $table->text('remark')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_issues');
    }
};
