<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permission_category', function (Blueprint $table) {
            if (! Schema::hasColumn('permission_category', 'icon')) {
                $table->string('icon')->nullable()->after('parent_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permission_category', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
