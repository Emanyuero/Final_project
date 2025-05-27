<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintsToJokesTable extends Migration
{
    public function up()
    {
        Schema::table('jokes', function (Blueprint $table) {
            $table->unique(['type', 'joke'], 'unique_single_jokes')->where('type', 'single');
            $table->unique(['type', 'setup', 'delivery'], 'unique_twopart_jokes')->where('type', 'twopart');
        });
    }

    public function down()
    {
        Schema::table('jokes', function (Blueprint $table) {
            $table->dropUnique('unique_single_jokes');
            $table->dropUnique('unique_twopart_jokes');
        });
    }
}
