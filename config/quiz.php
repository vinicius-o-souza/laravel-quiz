<?php

return [

    'models' => [
        
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
        
        /*
        *   Nome do Modelo que pertence o questionário no singular e minusculo
        */
        'parent_id' => 'user_id',
        
        /*
        *   Nome do Modelo que pertence o questionário no plural e minusculo
        */
        'parent_url_name' => 'users',

    ],

    'question_types' => [

        'OPEN'          => ['id' => 1, 'name' => 'Questão aberta', 'description' => 'Questão com resposta livre para o usuário'],
        'CLOSED'        => ['id' => 2, 'name' => 'Questão fechada', 'description' => 'Questão fechada com alternativas de respostas para o usuário'],

    ],
    
    'type_time' => [
        'MINUTES'   => ['id' => 1,    'name' => 'Minutos'],
        'HOURS'     => ['id' => 2,    'name' => 'Horas'],
        'DAYS'      => ['id' => 3,    'name' => 'Dias'],
        'MONTHS'    => ['id' => 4,    'name' => 'Meses'],
        'YEARS'     => ['id' => 5,    'name' => 'Anos'],
    ]
];
