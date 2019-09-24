<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->boolean('rand_questions');
            $table->longtext('instructions_before_start')->nullable();
            $table->longtext('instructions_start')->nullable();
            $table->longtext('instructions_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn('rand_questions');
            $table->dropColumn('instructions_before_start');
            $table->dropColumn('instructions_start');
            $table->dropColumn('instructions_end');
        });
    }
}
