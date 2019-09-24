# Laravel Quiz

## Redis
O redis é usado para cachear o timer da execução do questionário

## 1. Publicação dos assets
php artisan vendor:publish --provider="PandoApps\Quiz\QuizServiceProvider"

## 2. Seeder de QuestionType
Rodar seeder de question_types

## 3. Configuração dos Modelos
No arquivo quiz.php insira o modelo que executa questionários (executable) e o modelos que cria questionário (parent_type).

```
/*
*   Tipo do Modelo que responderá o questionário
*/
'executable' => App\User::class,

/*
*   Nome da coluna que representa a descrição do modelo que executa o questionário
*/
'executable_column_name' => 'name',

/*
*   Tipo do Modelo que pertence o questionário
*/
'parent_type' => App\User::class,
```

## 4. Configurar relacionamentos dos modelos
Modelo que executa questionários:
```
/**
* @return \Illuminate\Database\Eloquent\Relations\HasMany
**/
public function executionTests()
{
	return $this->morphToMany(\PandoApps\Quiz\Models\Questionnaire::class, 'executable')->withPivot('score')->withTimestamps();
}
```

Modelo que cria questionários:
```
/**
* @return \Illuminate\Database\Eloquent\Relations\HasMany
**/
public function questionnaires()
{
	return $this->morphMany(\PandoApps\Quiz\Models\Questionnaire::class, 'parent');
}
```

## 5. Criação das Datatables
Criar as datatables de questionnaires, questions, alternatives, answers e executable.
Crie um arquivo dentro da pasta App/DataTables com o nome do modelo + 'DataTable', exemplo: QuestionnaireDataTable. Essa classe do datatable deve implementar a classe do modelo correspondente.
Exemplo da classe QuestionnaireDataTable implementando sua interface correspondente.

```
namespace App\DataTables;

use PandoApps\Quiz\DataTables\QuestionnaireDataTableInterface;
use PandoApps\Quiz\Models\Questionnaire;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

class QuestionnaireDataTable extends DataTable implements QuestionnaireDataTableInterface
{
```

## Rotas

```
Route::group(['prefix' => config('quiz.models.parent_url_name'). '/{' . config('quiz.models.parent_id'). '}'], function () {
    
    Route::group(['prefix' => 'alternatives'], function () {
        Route::get('/',                                        ['as'=>'alternatives.index',   'uses'=>'\PandoApps\Quiz\Controllers\AlternativeController@index']);
        Route::get('/{alternative_id}',                        ['as'=>'alternatives.show',    'uses'=>'\PandoApps\Quiz\Controllers\AlternativeController@show']);
        Route::match(['put', 'patch'], '/{alternative_id}',    ['as'=>'alternatives.update',  'uses'=>'\PandoApps\Quiz\Controllers\AlternativeController@update']);
        Route::delete('/{alternative_id}',                     ['as'=>'alternatives.destroy', 'uses'=>'\PandoApps\Quiz\Controllers\AlternativeController@destroy']);
        Route::get('/{alternative_id}/edit',                   ['as'=>'alternatives.edit',    'uses'=>'\PandoApps\Quiz\Controllers\AlternativeController@edit']);
    });
    
    Route::group(['prefix' => 'answers'], function () {
        Route::get('/',                                     ['as'=>'answers.index',   'uses'=>'\PandoApps\Quiz\Controllers\AnswerController@index']);
        Route::get('/{answer_id}',                          ['as'=>'answers.show',    'uses'=>'\PandoApps\Quiz\Controllers\AnswerController@show']);
    });
    
    Route::group(['prefix' => 'executables'], function () {
        Route::get('/',                                     ['as'=>'executables.index',         'uses'=>'\PandoApps\Quiz\Controllers\ExecutableController@index']);
        Route::get('/{questionnaire_id}/questionnaire',     ['as'=>'executables.statistics',    'uses'=>'\PandoApps\Quiz\Controllers\ExecutableController@statistics']);
        Route::get('{executable_id}/',                      ['as'=>'executables.show',          'uses'=>'\PandoApps\Quiz\Controllers\ExecutableController@show']);
        Route::get('{questionnaire_id}/create/{model_id}',  ['as'=>'executables.create',        'uses'=>'\PandoApps\Quiz\Controllers\ExecutableController@create']);
        Route::post('{questionnaire_id}/store',             ['as'=>'executables.store',         'uses'=>'\PandoApps\Quiz\Controllers\ExecutableController@store']);
        Route::post('start',                                ['as'=>'executables.start',         'uses'=>'\PandoApps\Quiz\Controllers\ExecutableController@start']);
    });
    
    Route::group(['prefix' => 'questionnaires'], function () {
        Route::get('/',                                          ['as'=>'questionnaires.index', 'uses'=>'\PandoApps\Quiz\Controllers\QuestionnaireController@index']);
        Route::get('/create',                                    ['as'=>'questionnaires.create',  'uses'=>'\PandoApps\Quiz\Controllers\QuestionnaireController@create']);
        Route::post('/',                                         ['as'=>'questionnaires.store',   'uses'=>'\PandoApps\Quiz\Controllers\QuestionnaireController@store']);
        Route::get('/{questionnaire_id}',                        ['as'=>'questionnaires.show',    'uses'=>'\PandoApps\Quiz\Controllers\QuestionnaireController@show']);
        Route::match(['put', 'patch'], '/{questionnaire_id}',    ['as'=>'questionnaires.update',  'uses'=>'\PandoApps\Quiz\Controllers\QuestionnaireController@update']);
        Route::delete('/{questionnaire_id}',                     ['as'=>'questionnaires.destroy', 'uses'=>'\PandoApps\Quiz\Controllers\QuestionnaireController@destroy']);
        Route::get('/{questionnaire_id}/edit',                   ['as'=>'questionnaires.edit',    'uses'=>'\PandoApps\Quiz\Controllers\QuestionnaireController@edit']);
    });

    Route::group(['prefix' => 'questions'], function () {
        Route::get('/',                                         ['as'=>'questions.index',   'uses'=>'\PandoApps\Quiz\Controllers\QuestionController@index']);
        Route::get('/{question_id}',                            ['as'=>'questions.show',    'uses'=>'\PandoApps\Quiz\Controllers\QuestionController@show']);
        Route::match(['put', 'patch'], '/{question_id}',        ['as'=>'questions.update',  'uses'=>'\PandoApps\Quiz\Controllers\QuestionController@update']);
        Route::delete('/{question_id}',                         ['as'=>'questions.destroy', 'uses'=>'\PandoApps\Quiz\Controllers\QuestionController@destroy']);
        Route::get('/{question_id}/edit',                       ['as'=>'questions.edit',    'uses'=>'\PandoApps\Quiz\Controllers\QuestionController@edit']);
    });
});
```