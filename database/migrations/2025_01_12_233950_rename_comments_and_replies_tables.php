<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::rename('comments', 'case_comments');
        Schema::rename('comment_replies', 'case_comment_replies');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('case_comments', 'comments');
        Schema::rename('case_comment_replies', 'comment_replies');
    }
};
