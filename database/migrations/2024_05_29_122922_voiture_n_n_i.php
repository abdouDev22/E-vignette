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
        Schema::create('voitureNNis', function (Blueprint $table) {
            $table->id();
            $table->string('nom_proprio');
            $table->string('matricule');
            $table->string('marque');
            $table->string('type');
            $table->string('NNIclient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voitureNNis');
    }
};
