<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_waafi_1', function (Blueprint $table) {
            $table->integer('failed_attempts')->default(0);
            $table->timestamp('last_failed_attempt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_waafi_1', function (Blueprint $table) {
            $table->dropColumn('failed_attempts');
            $table->dropColumn('last_failed_attempt');
        });
    }
};
