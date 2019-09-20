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