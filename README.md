# Laravel Quiz

## 1. Publicação dos assets
php artisan vendor:publish --provider="PandoApps\Quiz\QuizServiceProvider"

## 2. Seeder de QuestionType
Rodar seeder de question_types

## 3. Configuração dos Modelos:
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

## 5. Criação das Datatables:
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