<?php

Route::resource('questionnaires', 'QuestionnaireController');

Route::resource('question_types', 'QuestionTypeController');

Route::resource('questions', 'QuestionController');

Route::resource('user_identification', 'UserIdentificationController');

Route::resource('alternatives', 'AlternativeController');

Route::resource('answers', 'AnswerController');

Route::group(['prefix' => 'executables'], function () {
    
    Route::get('/', 'ExecutableController@index')->name('executables.index');
    
    Route::get('{questablenaire_id}/create/{model_id}', 'ExecutableController@create')->name('executables.create');
    
    Route::post('{questablenaire_id}/store/{model_id}', 'ExecutableController@store')->name('executables.store');
    
});