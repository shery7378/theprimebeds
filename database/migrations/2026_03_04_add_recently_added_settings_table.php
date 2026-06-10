<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'is_recently_added')) {
                $table->tinyInteger('is_recently_added')->default(1);
            }
            if (!Schema::hasColumn('settings', 'is_popular_categories_display')) {
                $table->tinyInteger('is_popular_categories_display')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'is_recently_added')) {
                $table->dropColumn('is_recently_added');
            }
            if (Schema::hasColumn('settings', 'is_popular_categories_display')) {
                $table->dropColumn('is_popular_categories_display');
            }
        });
    }
};
