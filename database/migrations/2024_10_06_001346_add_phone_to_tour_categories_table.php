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
        Schema::table('tour_categories', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('tour_count_btn_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_categories', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};
