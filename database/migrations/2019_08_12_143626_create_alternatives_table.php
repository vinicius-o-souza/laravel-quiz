<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlternativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Tabela de alternativas:
         *    description        => descrição da alternativa,
         *    question_id  => id da questão associada,
         */
        Schema::create('alternatives', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->float('value');
            $table->boolean('is_correct');

            $table->integer('question_id')->unsigned();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');

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
        Schema::dropIfExists('alternatives');
    }
}
