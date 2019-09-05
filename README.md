# laravel-quiz
Library for adding questionnaires into Laravel framework

1. Publicar assets (php artisan vendor:publish);

2. Adicionar QuestionTypeSeeder no DatabaseSeeder;

3. Fazer relacionamento com a classe que realizar questionários;
/**
* @return \Illuminate\Database\Eloquent\Relations\HasMany
**/
public function executionTests()
{
	return $this->morphToMany(\PandoApps\Quiz\Models\Questionnaire::class, 'executable')->withPivot('score')->withTimestamps();
}

4. Fazer relacionamento com a classe que cria questionários;
/**
* @return \Illuminate\Database\Eloquent\Relations\HasMany
**/
public function questionnaires()
{
	return $this->morphMany(\PandoApps\Quiz\Models\Questionnaire::class, 'parent');
}

Não é possível realizar o cadastro de novas questões e/ou alternativas pelas rotas de store e create, a criação das mesmas só é dado pela rota de edição do questionário.

Também não é possível cadastrar respostas pelas rotas de store e create, o cadastro de respostas é feito através da rota de execução de questionário que cria uma resposta para cada questão do questionário.

Rotas:

Todos as rotas possuem um parent_id que é o id do modelo que cria/criou o questionário.

1. Questionnaire: rota resource padrão;

2. Questions: 

3. Alternatives:

4. Answers:

5. Executables:
