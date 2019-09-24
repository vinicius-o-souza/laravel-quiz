<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Tabela de respostas:
         *    description                 => resposta do usuário,
         *    score                       => nota da resposta,
         *    file                        => arquivo contendo a resposta caso a questão seja do tipo attachment,
         *    question_id                 => id da questão associada,
         *    model_has_questionnaire_id  => id da relação de questionario e modelo que respondeu o questionário
         */

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description')->nullable();
            $table->float('score')->nullable();

            $table->integer('alternative_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned();
            $table->integer('executable_id')->unsigned();

            $table->foreign('alternative_id')->references('id')->on('alternatives')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('executable_id')->references('id')->on('executables')->onDelete('cascade');

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
        Schema::dropIfExists('answers');
    }
}
