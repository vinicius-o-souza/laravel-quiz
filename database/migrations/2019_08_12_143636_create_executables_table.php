<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExecutablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Tabela de relação polimorfica do questionário com qualquer modelo
         *    executable_id            => id do modelo,
         *    executable_type          => tipo do modelo,
         *    questionnaire_id         => id do questionário
         */
        Schema::create('executables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('executable_id');
            $table->string('executable_type');
            $table->float('score');
            $table->boolean('answered')->nullable();
            
            $table->integer('questionnaire_id')->unsigned();
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires')->onDelete('cascade');

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
        Schema::dropIfExists('executables');
    }
}
