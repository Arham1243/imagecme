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
        Schema::table('cases', function (Blueprint $table) {
            Schema::table('cases', function (Blueprint $table) {
                $table->json('ai_conversation')->nullable();
                $table->boolean('publish_ai_conversation')->nullable()->default(false);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn('ai_conversation');
            $table->dropColumn('publish_ai_conversation');
        });
    }
};
