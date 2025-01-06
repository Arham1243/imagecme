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
        Schema::table('case_images', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->unsignedBigInteger('type')->nullable()->default(null);
            $table->foreign('type')->references('id')->on('image_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_images', function (Blueprint $table) {
            $table->dropForeign(['type']);
            $table->dropColumn('type');
            $table->string('type')->nullable()->default(null);
        });
    }
};
