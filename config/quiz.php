<?php

return [

    'models' => [
        

        /*
        *   Tipo do Modelo que responderá o questionário
        */
        'questionnaire' => PandoApps\Quiz\Models\Questionnaire::class,
        

        /*
        *   Tipo do Modelo que responderá o questionário
        */
        'executable' => App\User::class,

        /*
        *   Tipo do Modelo que pertence o questionário
        */
        'parent_questionnaire' => App\User::class

    ],

    'question_types' => [

        'OPEN'          => ['id' => 1, 'name' => 'Questão aberta', 'description' => 'Questão com resposta livre para o usuário'],
        'CLOSED'        => ['id' => 2, 'name' => 'Questão fechada', 'description' => 'Questão fechada com alternativas de respostas para o usuário'],

    ]
];
