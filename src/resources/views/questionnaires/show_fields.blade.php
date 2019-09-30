<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Nome:') !!}
    <p>{!! $questionnaire->name !!}</p>
</div>

<!-- Is active Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_active', 'Questionário ativo:') !!}
    <p>{!! $questionnaire->is_active ? 'Sim' : 'Não' !!}</p>
</div>

<!-- Answer Once Field -->
<div class="form-group col-sm-12">
    {!! Form::label('answer_once', 'Resposta Única:') !!}
    <p>{!! $questionnaire->answer_once ? 'Sim' : 'Não' !!}</p>
</div>

<!-- Rand Questions Field -->
<div class="form-group col-sm-12">
    {!! Form::label('rand_questions', 'Randomizar as questões na hora da execução:') !!}
    <p>{!! $questionnaire->rand_questions ? 'Sim' : 'Não' !!}</p>
</div>

@if(isset($questionnaire->waiting_time))
    <!-- Waiting Time Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('waiting_time', 'Tempo de Espera:') !!}
        <p>{!! $questionnaire->waiting_time !!}
            @switch($questionnaire->type_waiting_time)
                @case(config('quiz.type_time.MINUTES.id'))
                    {{ config('quiz.type_time.MINUTES.name')}}
                    @break
                @case(config('quiz.type_time.HOURS.id'))
                    {{ config('quiz.type_time.HOURS.name')}}
                    @break
                @case(config('quiz.type_time.DAYS.id'))
                    {{ config('quiz.type_time.DAYS.name')}}
                    @break
                @case(config('quiz.type_time.MONTHS.id'))
                    {{ config('quiz.type_time.MONTHS.name')}}
                    @break
                @default
                    {{ config('quiz.type_time.YEARS.name')}}
            @endswitch
        </p>
    </div>
@endif

@if(isset($questionnaire->execution_time))
    <!-- Execution Time Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('execution_time', 'Tempo de Execução:') !!}
        <p>{!! $questionnaire->execution_time !!}
            @switch($questionnaire->type_execution_time)
                @case(config('quiz.type_time.MINUTES.id'))
                    {{ config('quiz.type_time.MINUTES.name')}}
                    @break
                @case(config('quiz.type_time.HOURS.id'))
                    {{ config('quiz.type_time.HOURS.name')}}
                    @break
                @case(config('quiz.type_time.DAYS.id'))
                    {{ config('quiz.type_time.DAYS.name')}}
                    @break
                @case(config('quiz.type_time.MONTHS.id'))
                    {{ config('quiz.type_time.MONTHS.name')}}
                    @break
                @default
                    {{ config('quiz.type_time.YEARS.name')}}
            @endswitch
        </p>
    </div>
@endif

<!-- Instructions Before Start Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instructions_before_start', 'Instruções do questionário antes de iniciá-lo!') !!}
    {!! Form::textarea('instructions_before_start', $questionnaire->instructions_before_start, ['id' => 'instructions_before_start']) !!}
</div>

<!-- Instructions Start Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instructions_start', 'Instruções no início do questionário!') !!}
    {!! Form::textarea('instructions_start', $questionnaire->instructions_start, ['id' => 'instructions_start']) !!}
</div>

<!-- Instructions End Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instructions_end', 'Instruções do fim do questionário!') !!}
    {!! Form::textarea('instructions_end', $questionnaire->instructions_end, ['class' => 'form-control', 'id' => 'instructions_end']) !!}
</div>

<div class="col-sm-12">
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h2 class="box-title">QUESTÕES</h2>
            <div class="box-tools pull-right">
                <button type="button" class="btnCollapse btn btn-primary" type="button" data-toggle="collapse" data-target="#questions_body" aria-expanded="false" aria-controls="questions_body"><i class="fa fa-minus"></i></button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div id="questions_body" class="box-body collapse in">
            @foreach ($questionnaire->questions as $key => $question)
            <div class="questions col-sm-12" id="question_{{ $question->id }}">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b> Questão {{ $key + 1 }} </b></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btnCollapse btn btn-primary" data-toggle="collapse" data-target="#question_body_{{ $question->id }}" aria-expanded="false" aria-controls="question_body_{{ $question->id }}">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div id="question_body_{{ $question->id }}" class="box-body collapse">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Descrição:</label>
                                <p>{!! $question->description !!}</p>
                            </div>

                            <!-- Hint Field -->
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Dica:</label>
                                <p>{!! $question->hint !!}</p>
                            </div>
                            
                            <!-- Weight Field -->
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Peso da questão:</label>
                                <p> {!! $question->weight !!}</p>
                            </div>
        
                            <!-- Is Required Field -->
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Obrigatória?</label>
                                <p>{!! $question->is_required ? 'Sim' : 'Não' !!}</p>
                            </div>
                            
                            <!-- Question Type Field -->
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="question_type_id_{{ $question->id }}">Tipo da Questão:</label>
                                <p>{!! $question->questionType->name !!}</p>
                            </div>
                            
                            @if ($question->alternatives)
                                <div id="alternatives_block_{{ $question->id }}" class="col-sm-12">
                                    <div class="box box-primary box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><b>Alternativas</b></h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btnCollapse btn btn-primary" data-toggle="collapse" data-target="#alternatives_body_{{ $question->id }}" aria-expanded="false" aria-controls="alternatives_body_{{ $question->id }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div id="alternatives_body_{{ $question->id }}" class="box-body collapse">
                                            @foreach ($question->alternatives as $key => $alternative)
                                                <div class="col-sm-12 row alternatives" id="alternative_{!! $alternative->id !!}">
                                                    <hr class="col-sm-12">
                                                    <div class="col-sm-12 col-md-3 d-flex align-items-center">
                                                        <h4><b> Alternativa {!! $key + 1 !!} </b></h4>
                                                    </div>
                                                    <div class="col-sm-12 col-md-9 row">
                                                        <!-- Description Field -->
                                                        <div class="form-group col-sm-12 col-md-6">
                                                            <label>Descrição:</label>
                                                            <p> {!! $alternative->description !!}</p>
                                                        </div>
                                                        
                                                        <!-- Value Field -->
                                                        <div class="form-group col-sm-12 col-md-6">
                                                            <label>Valor da alternativa:</label>
                                                            <p> {!! $alternative->value !!}</p>
                                                        </div>
                                                        
                                                        <!-- Is Correct Field -->
                                                        <div class="form-group col-sm-12 col-md-6">
                                                            <label>Alternativa correta?</label>
                                                            <p>{!! $alternative->is_correct ? 'Sim' : 'Não' !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach        
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            @endforeach
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

@push('scripts_quiz')
    <script src="{{ asset('vendor/pandoapps/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/pandoapps/js/ckeditor/config.js') }}"></script>
    <script>
        CKEDITOR.replace('instructions_before_start');
        CKEDITOR.replace('instructions_start');
        CKEDITOR.replace('instructions_end');
        
        CKEDITOR.config.readOnly = true;
        
        $(document).on('click', '.btnCollapse', function() {
            var icon = $(this).find('i');
            var parent = icon.parent();
            if(parent.hasClass('collapsed')) {
                icon.removeClass('fa-minus');
                icon.addClass('fa-plus');
            } else {
                icon.removeClass('fa-plus');
                icon.addClass('fa-minus');
            }
        });
    </script>
@endpush