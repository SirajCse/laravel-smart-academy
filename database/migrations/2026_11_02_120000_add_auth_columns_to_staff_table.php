<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            if (! Schema::hasColumn('staff', 'password')) {
                $table->string('password')->nullable()->after('role');
            }
            if (! Schema::hasColumn('staff', 'last_login')) {
                $table->datetime('last_login')->nullable()->after('is_active');
            }
            if (! Schema::hasColumn('staff', 'language_id')) {
                $table->integer('language_id')->nullable()->after('last_login');
            }
            if (! Schema::hasColumn('staff', 'remember_token')) {
                $table->rememberToken()->after('language_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['password', 'last_login', 'language_id', 'remember_token']);
        });
    }
};
