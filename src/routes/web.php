<?php

Route::group(['prefix' => 'question_types'], function () {
    Route::get('/',                                          ['as'=>'question_types.index',   'uses'=>'QuestionTypeController@index']);
    Route::get('/create',                                    ['as'=>'question_types.create',  'uses'=>'QuestionTypeController@create']);
    Route::post('/',                                         ['as'=>'question_types.store',   'uses'=>'QuestionTypeController@store']);
    Route::get('/{question_type_id}',                        ['as'=>'question_types.show',    'uses'=>'QuestionTypeController@show']);
    Route::match(['put', 'patch'], '/{question_type_id}',    ['as'=>'question_types.update',  'uses'=>'QuestionTypeController@update']);
    Route::delete('/{question_type_id}',                     ['as'=>'question_types.destroy', 'uses'=>'QuestionTypeController@destroy']);
    Route::get('/{question_type_id}/edit',                   ['as'=>'question_types.edit',    'uses'=>'QuestionTypeController@edit']);
});

Route::group(['prefix' => config('quiz.models.parent_url_name'). '/{' . config('quiz.models.parent_id'). '}'], function () {
    
    Route::group(['prefix' => 'alternatives'], function () {
        Route::get('/',                                        ['as'=>'alternatives.index',   'uses'=>'AlternativeController@index']);
        Route::get('/{alternative_id}',                        ['as'=>'alternatives.show',    'uses'=>'AlternativeController@show']);
        Route::match(['put', 'patch'], '/{alternative_id}',    ['as'=>'alternatives.update',  'uses'=>'AlternativeController@update']);
        Route::delete('/{alternative_id}',                     ['as'=>'alternatives.destroy', 'uses'=>'AlternativeController@destroy']);
        Route::get('/{alternative_id}/edit',                   ['as'=>'alternatives.edit',    'uses'=>'AlternativeController@edit']);
    });
    
    Route::group(['prefix' => 'answers'], function () {
        Route::get('/',                                     ['as'=>'answers.index',   'uses'=>'AnswerController@index']);
        Route::get('/{answer_id}',                          ['as'=>'answers.show',    'uses'=>'AnswerController@show']);
    });
    
    Route::group(['prefix' => 'executables'], function () {
        Route::get('/{questionnaire_id}/questionnaire', 'ExecutableController@index')->name('executables.index');
        Route::get('{executable_id}/', 'ExecutableController@show')->name('executables.show');
        Route::get('{questionnaire_id}/create/{model_id}', 'ExecutableController@create')->name('executables.create');
        Route::post('{questionnaire_id}/store', 'ExecutableController@store')->name('executables.store');
        Route::post('start', 'ExecutableController@handleStartExecutable')->name('executables.start');
    });
    
    Route::group(['prefix' => 'questionnaires'], function () {
        Route::get('/',                                          ['as'=>'questionnaires.index',   'uses'=>'QuestionnaireController@index']);
        Route::get('/create',                                    ['as'=>'questionnaires.create',  'uses'=>'QuestionnaireController@create']);
        Route::post('/',                                         ['as'=>'questionnaires.store',   'uses'=>'QuestionnaireController@store']);
        Route::get('/{questionnaire_id}',                        ['as'=>'questionnaires.show',    'uses'=>'QuestionnaireController@show']);
        Route::match(['put', 'patch'], '/{questionnaire_id}',    ['as'=>'questionnaires.update',  'uses'=>'QuestionnaireController@update']);
        Route::delete('/{questionnaire_id}',                     ['as'=>'questionnaires.destroy', 'uses'=>'QuestionnaireController@destroy']);
        Route::get('/{questionnaire_id}/edit',                   ['as'=>'questionnaires.edit',    'uses'=>'QuestionnaireController@edit']);
    });

    Route::group(['prefix' => 'questions'], function () {
        Route::get('/',                                         ['as'=>'questions.index',   'uses'=>'QuestionController@index']);
        Route::get('/{question_id}',                            ['as'=>'questions.show',    'uses'=>'QuestionController@show']);
        Route::match(['put', 'patch'], '/{question_id}',        ['as'=>'questions.update',  'uses'=>'QuestionController@update']);
        Route::delete('/{question_id}',                         ['as'=>'questions.destroy', 'uses'=>'QuestionController@destroy']);
        Route::get('/{question_id}/edit',                       ['as'=>'questions.edit',    'uses'=>'QuestionController@edit']);
    });

});
