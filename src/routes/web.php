<?php

Route::resource('question_types', 'QuestionTypeController');

Route::group(['prefix' => 'parent/{parent_id}'], function () {
    Route::resource('questionnaires', 'QuestionnaireController');

    Route::resource('questions', 'QuestionController')->except(['create', 'store', 'update']);

    Route::resource('alternatives', 'AlternativeController')->except(['create', 'store', 'update']);

    Route::resource('answers', 'AnswerController')->except(['create', 'store', 'update']);

    Route::group(['prefix' => 'executables'], function () {
        Route::get('/', 'ExecutableController@index')->name('executables.index');
        
        Route::get('{executable_id}/', 'ExecutableController@show')->name('executables.show');
        
        Route::get('{questionnaire_id}/create/{model_id}', 'ExecutableController@create')->name('executables.create');
        
        Route::post('{questionnaire_id}/store/{model_id}', 'ExecutableController@store')->name('executables.store');
    });
});
