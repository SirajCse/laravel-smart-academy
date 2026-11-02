<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('item_issue', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id')->nullable(false);
            $table->integer('member_id')->nullable(false);
            $table->string('member_type')->nullable(false);
            $table->date('issue_date')->nullable(false);
            $table->date('return_date')->nullable(false);
            $table->date('actual_return_date')->nullable(true);
            $table->integer('quantity')->nullable(false)->default(1);
            $table->boolean('is_returned')->nullable(false)->default(0);
            $table->text('remark')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_issue');
    }
};
