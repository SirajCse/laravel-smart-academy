<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {
        Schema::create('frontcms_menuitems', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->nullable(false);
            $table->string('item_type')->nullable(false);
            $table->integer('item_id')->nullable(true);
            $table->integer('order')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontcms_menuitems');
    }
};
