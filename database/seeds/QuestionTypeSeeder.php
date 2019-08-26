<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Add timestamp to item before insering into database.
 */
function quiz_addTimestamp($item) {
    return array_merge($item, ['created_at' => DB::raw('CURRENT_TIMESTAMP'), 'updated_at' => DB::raw('CURRENT_TIMESTAMP')]);
}

class QuestionTypeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionTypesArray = array_map('quiz_addTimestamp', array_values(config('quiz.question_types')));
        DB::table('question_types')->insert($questionTypesArray);
    }
}
