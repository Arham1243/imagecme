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
        Schema::table('case_comment_replies', function (Blueprint $table) {
            $table->renameColumn('comment_id', 'case_comment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_comment_replies', function (Blueprint $table) {
            $table->renameColumn('case_comment_id', 'comment_id');
        });
    }
};
