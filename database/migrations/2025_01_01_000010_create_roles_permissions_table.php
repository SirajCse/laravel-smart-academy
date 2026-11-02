<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->nullable(false);
            $table->integer('permission_category_id')->nullable(false);
            $table->boolean('can_view')->nullable(false)->default(0);
            $table->boolean('can_add')->nullable(false)->default(0);
            $table->boolean('can_edit')->nullable(false)->default(0);
            $table->boolean('can_delete')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
    }
};
