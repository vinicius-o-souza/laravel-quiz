<?php

return [

    'action'            => 'Ação',
    'print'             => '<i class="fa fa-print datatable-icons"></i> Imprimir',
    'reload'            => 'Recarregar',
    'csv'               => 'Exportar',
    'colvis'            => '<i class="fa fa-columns datatable-icons"></i> Colunas visíveis',
    'page_length'       => '<i class="fa fa-sort datatable-icons"></i> %d registros por página',
    'length_menu'       => 'Mostrar _MENU_ linhas',
    'search'            => 'Pesquisar: ',
    'empty_table'       => 'Não há registros nessa tabela',
    'info'              => 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
    'info_empty'        => 'Mostrando 0 até 0 de 0 registros',
    'info_filtered'     => '(filtrados de _MAX_ registros)',
    'loading_records'   => 'Carregando...',
    'processing'        => 'Processando...',
    'zero_records'      => 'Nenhum registro encontrado',
    'next'              => '&gt;',
    'previous'          => '&lt;',
    
    'columns'           => [
        'alternatives'  => [
            'question'          => 'Questão',
            'description'       => 'Descrição',
            'value'             => 'Valor',
            'is_correct'        => 'Correta?'    
        ],
        'answers'       => [
            'question'          => 'Questão',
            'alternative'       => 'Alternativa',
            'description'       => 'Descrição',
            'score'             => 'Pontuação'
        ],
        'executables'   => [
            'executable_id'     => 'Respondeu',
            'questionnaire_id'  => 'Questionário',
            'score'             => 'Nota',
            'created_at'        => 'Data'  
        ],
        'questions'     => [
            'questionnaire_id'  => 'Questionário',
            'question_type'     => 'Tipo da Questão',
            'description'       => 'Descrição',
            'hint'              => 'Dica',
            'weight'            => 'Peso',
            'is_required'       => 'Obrigatória',
            'is_active'         => 'Ativa',
            'alternatives'      => 'Alternativas'
        ],
        'questionnaires' => [
            'name'              => 'Nome',
            'answer_once'       => 'Resposta Única',
            'is_active'         => 'Ativo',
            'questions'         => 'Questões',
            'execution_time'    => 'Tempo total para execução do questionário',
            'waiting_time'      => 'Tempo de espera para a próxima execução'
        ]
    ]
    
];
