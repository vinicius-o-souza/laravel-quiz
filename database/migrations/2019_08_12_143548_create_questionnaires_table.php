<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Tabela de questionários:
         *    is_active   => define se o questionário está ativo ou não,
         *    name        => nome do questionário,
         *    answer_once => define se o questionário pode ser respondido apenas uma vez ou não para cada usuário
         */
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active')->default(true);
            $table->text('name');
            $table->boolean('answer_once')->default(false);
            $table->integer('waiting_time')->nullable();
            $table->integer('type_waiting_time')->nullable();
            $table->integer('execution_time')->nullable();
            $table->integer('type_execution_time')->nullable();

            $table->integer('parent_id');
            $table->string('parent_type');

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
        Schema::dropIfExists('questionnaires');
    }
}
