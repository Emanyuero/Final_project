<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
            Schema::create('jokes', function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->text('joke')->nullable();
                $table->text('setup')->nullable();
                $table->text('delivery')->nullable();
                $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
