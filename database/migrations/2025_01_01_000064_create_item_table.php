<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->integer('item_category_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('item_code')->nullable(false);
            $table->text('description')->nullable(true);
            $table->string('unit')->nullable(true);
            $table->decimal('purchase_price')->nullable(false)->default(0);
            $table->decimal('sale_price')->nullable(false)->default(0);
            $table->integer('opening_quantity')->nullable(false)->default(0);
            $table->integer('current_quantity')->nullable(false)->default(0);
            $table->integer('reorder_level')->nullable(false)->default(0);
            $table->string('image')->nullable(true);
            $table->boolean('is_active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item');
    }
};
