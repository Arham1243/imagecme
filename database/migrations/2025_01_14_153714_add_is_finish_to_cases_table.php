<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFinishToCasesTable extends Migration
{
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->timestamp('is_finish')->nullable();
        });
    }

    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn('is_finish');
        });
    }
}
