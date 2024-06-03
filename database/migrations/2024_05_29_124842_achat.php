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
        Schema::create('achat', function (Blueprint $table) {
            $table->id();
            $table->date('Date');
            $table->integer('prix');
                        
$table->unsignedBigInteger('id_mode_paiement');
$table->unsignedBigInteger('id_voiture');
$table->unsignedBigInteger('id_vignette'); 
$table->unsignedBigInteger('id_code_q_r');

            $table->foreign('id_mode_paiement')->references('id')->on('mode_paiement');
            $table->foreign('id_voiture')->references('id')->on('voitures');
            $table->foreign('id_vignette')->references('id')->on('vignettes');
            $table->foreign('id_code_q_r')->references('id')->on('codeQR');
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
        Schema::dropIfExists('achat');
    }
};
