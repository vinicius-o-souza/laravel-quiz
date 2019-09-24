<!-- Name Field -->
<div class="form-group col-sm-12 col-md-6">
    <label for="name"> Nome:  <span class="text-danger"> * </span></label>
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Is active Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_active', 'Questionário ativo?') !!}
    {!! Form::checkbox('is_active', null, null) !!}
</div>

<!-- Answer Once Field -->
<div class="form-group col-sm-12">
    {!! Form::label('answer_once', 'Resposta única?') !!}
    {!! Form::checkbox('answer_once', null, null) !!}
</div>

<!-- Rand Questions Field -->
<div class="form-group col-sm-12">
    {!! Form::label('rand_questions', 'Deseja randomizar as questões na hora da execução?') !!}
    {!! Form::checkbox('rand_questions', null, null) !!}
</div>

<!-- Waiting Time Checkbox -->
<div class="form-group col-sm-12 col-md-6" id="checkbox_waiting_time_block">
    {!! Form::label('checkbox_waiting_time', 'Deseja definir um tempo de espera para submeter outra resposta?') !!}
    {!! Form::checkbox('checkbox_waiting_time', null, null, ['id' => 'checkbox_waiting_time']) !!}
    <div class="row" id="waiting_time_block" style="display:none">
        <!-- Waiting Time Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('waiting_time', 'Tempo de Espera:') !!}
            {!! Form::text('waiting_time', null, ['class' => 'form-control']) !!}
        </div>
        
        <!-- Type Waiting Time Field -->
        <div class="form-group col-sm-12 col-md-6">
            {!! Form::label('waiting_time', 'Tipo do Tempo de Espera:') !!}
            <select id="type_waiting_time" name="type_waiting_time" class="form-control select2">
                <option value="{{ config('quiz.type_time.MINUTES.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_waiting_time == config('quiz.type_time.MINUTES.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.MINUTES.name') }}
                </option>
                <option value="{{ config('quiz.type_time.HOURS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_waiting_time == config('quiz.type_time.HOURS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.HOURS.name') }}
                </option>
                <option value="{{ config('quiz.type_time.DAYS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_waiting_time == config('quiz.type_time.DAYS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.DAYS.name') }}
                </option>
                <option value="{{ config('quiz.type_time.MONTHS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_waiting_time == config('quiz.type_time.MONTHS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.MONTHS.name') }}
                </option>
                <option value="{{ config('quiz.type_time.YEARS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_waiting_time == config('quiz.type_time.YEARS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.YEARS.name') }}
                </option>
            </select>
        </div>
    </div>
</div>

<!-- Execution Time Checkbox -->
<div class="form-group col-sm-12 col-md-6">
    {!! Form::label('checkbox_execution_time', 'Deseja definir um tempo máximo de execução do questionário?') !!}
    {!! Form::checkbox('checkbox_execution_time', null, null, ['id' => 'checkbox_execution_time']) !!}
    <div class="row" id="execution_time_block" style="display:none">
        <!-- Execution Time Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('execution_time', 'Tempo de Execução:') !!}
            {!! Form::text('execution_time', null, ['class' => 'form-control']) !!}
        </div>
        
        <!-- Type execution Time Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('execution_time', 'Tipo do Tempo de Execução:') !!}
            <select id="type_execution_time" name="type_execution_time" class="form-control select2">
                <option value="{{ config('quiz.type_time.MINUTES.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_execution_time == config('quiz.type_time.MINUTES.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.MINUTES.name') }}
                </option>
                <option value="{{ config('quiz.type_time.HOURS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_execution_time == config('quiz.type_time.HOURS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.HOURS.name') }}
                </option>
                <option value="{{ config('quiz.type_time.DAYS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_execution_time == config('quiz.type_time.DAYS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.DAYS.name') }}
                </option>
                <option value="{{ config('quiz.type_time.MONTHS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_execution_time == config('quiz.type_time.MONTHS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.MONTHS.name') }}
                </option>
                <option value="{{ config('quiz.type_time.YEARS.id') }}"
                        {{ isset($questionnaire) && ($questionnaire->type_execution_time == config('quiz.type_time.YEARS.id')) ? 'selected': ''}}>
                        {{ config('quiz.type_time.YEARS.name') }}
                </option>
            </select>
        </div>
    </div>
</div>

<!-- Instructions Before Start Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instructions_before_start', 'Instruções do questionário antes de iniciá-lo!') !!}
    {!! Form::textarea('instructions_before_start', null, ['id' => 'instructions_before_start']) !!}
</div>

<!-- Instructions Start Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instructions_start', 'Instruções no início do questionário!') !!}
    {!! Form::textarea('instructions_start', null, ['id' => 'instructions_start']) !!}
</div>

<!-- Instructions End Field -->
<div class="form-group col-sm-12">
    {!! Form::label('instructions_end', 'Instruções do fim do questionário!') !!}
    {!! Form::textarea('instructions_end', null, ['class' => 'form-control', 'id' => 'instructions_end']) !!}
</div>

<input type="hidden" name="countQuestion" id="countQuestion" value="0">

<div class="col-sm-12">
    <div class="box box-info box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Questões</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btnCollapse btn btn-info" type="button" data-toggle="collapse" data-target="#questions_body" aria-expanded="false" aria-controls="questions_body"><i class="fa fa-minus"></i></button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div id="questions_body" class="box-body collapse in">
            <div id="questions"></div>
            <!-- Add Question Field -->
            <div class="form-group col-sm-12">
                <a id="questionAdd_js" class="btn btn-success text-white float-right">Questão <i class="fa fa-plus"></i></a>
            </div>    
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 pt-5">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary', 'id' => 'submitBtn']) !!}
    <a href="{!! route('questionnaires.index', request()->$parentId) !!}" class="btn btn-default">Cancelar</a>
</div>

@push('scripts_quiz')
<script src="{{ asset('vendor/pandoapps/js/ractive.js') }}"></script>
<script src="{{ asset('vendor/pandoapps/js/jquery.ba-throttle-debounce.min.js') }}"></script>
<script src="{{ asset('vendor/pandoapps/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/pandoapps/js/ckeditor/config.js') }}"></script>

<script id="question-template" type="text/ractive">
    <div class="questions col-sm-12" id="question_@{{ id }}">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><b> Questão @{{ count }} </b></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btnCollapse btn btn-info" data-toggle="collapse" data-target="#question_body_@{{ id }}" aria-expanded="false" aria-controls="question_body_@{{ id }}">
                        <i class="fa 
                        @{{#if collapseIn }}
                            fa-minus 
                        @{{else}}
                            fa-plus
                        @{{/if}}"></i>
                    </button>
                    <button type="button" class="btn btn-danger questionDelete_js" data-id="@{{ id }}"><i class="fa fa-trash"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="question_body_@{{ id }}" class="box-body collapse @{{ collapseIn }}">
                <div class="row">
                    <!-- Description Field -->
                    <div class="form-group col-sm-12">
                        <label for="description">Descrição:  <span class="text-danger"> * </span></label>
                        <textarea id="description" name="description[@{{ id }}]" class="form-control" rows="3" required>@{{ description }}</textarea>
                    </div>
                    
                    <!-- Question Type Field -->
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="question_type_id_@{{ id }}">Tipo da Questão:</label>
                        <select id="question_type_id_@{{ id }}" name="question_type_id[@{{ id }}]" data-id="@{{ id }}" class="form-control question_type_js" 
                            @{{#if question_type_id }}
                                value="@{{ question_type_id }}" 
                            @{{/if}}
                        required>
                            @{{#each questionsType}}
                                <option value="@{{ id }}"> @{{ name }}</option>
                            @{{/each}}
                        </select>
                        <p class="help-block">Questões do tipo aberta não possuem alternativas.</p>
                    </div>

                    <!-- Hint Field -->
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="hint">Dica:</label>
                        <input type="text" id="hint" name="hint[@{{ id }}]" class="form-control" value="@{{ hint }}">
                    </div>
                    
                    <!-- Weight Field -->
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="weight">Peso da questão:  <span class="text-danger"> * </span></label>
                        <input type="number" id="weight" name="weight[@{{ id }}]" class="form-control" min="1" value="@{{ weight }}" required>
                    </div>

                    <!-- Is Required Field -->
                    <div class="col-sm-12 col-md-3 d-flex align-items-center">
                        <label>
                            <input id="is_required" type="checkbox" name="is_required[@{{ id }}]"
                                @{{#if is_required }}
                                    checked
                                @{{/if }}
                            > Questão obrigatória?
                        </label>
                    </div>

                    <!-- Is Active Field -->
                    <div class="col-sm-12 col-md-3 d-flex align-items-center">
                        <label>
                            <input type="checkbox" name="is_active_question[@{{ id }}][]"
                                @{{#if is_active }}
                                    checked
                                @{{/if }}
                            > Questão ativa?
                        </label>
                    </div>
                    
                    <div id="alternatives_block_@{{ id }}" class="col-sm-12" style="display: none">
                        <div class="box box-info box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><b>Alternativas</b></h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btnCollapse btn btn-info" data-toggle="collapse" data-target="#alternatives_body_@{{ id }}" aria-expanded="false" aria-controls="alternatives_body_@{{ id }}">
                                        <i class="fa 
                                        @{{#if collapseIn }}
                                            fa-minus 
                                        @{{else}}
                                            fa-plus
                                        @{{/if}}"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div id="alternatives_body_@{{ id }}" class="box-body collapse">
                                <div id="alternatives_@{{ id }}" class="col-sm-12"></div>
                                <!-- Add Alternative Field -->
                                <div class="form-group col-sm-12">
                                    <a id="alternativeAdd_js_@{{ id }}" data-id="@{{ id }}" class="alternativeAdd_js btn btn-success text-white float-right">Alternativas <i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    
                    <input type="hidden" name="countAlternatives[@{{ id }}]" id="countAlternatives_@{{ id }}" value="0">
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</script>

<script id="alternative-template" type="text/ractive">
    <div class="col-sm-12 row alternatives" id="alternative_@{{ idQuestion }}_@{{ id }}">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Alternativa @{{ count }}</b></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btnCollapse btn btn-info" data-toggle="collapse" data-target="#alternative_body_@{{ idQuestion }}_@{{ id }}" aria-expanded="false" aria-controls="alternatives_body_@{{ idQuestion }}_@{{ id }}">
                        <i class="fa 
                        @{{#if collapseIn }}
                            fa-minus 
                        @{{else}}
                            fa-plus
                        @{{/if}}"></i>
                    </button>
                    <button type="button" class="btn btn-danger alternativeDelete_js float-right" data-id="@{{ id }}" data-id-question="@{{ idQuestion }}"><i class="fa fa-trash"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="alternative_body_@{{ idQuestion }}_@{{ id }}" class="box-body collapse @{{ collapseIn }}">
                <div class="col-sm-12 row">
                    <!-- Description Field -->
                    <div class="form-group col-sm-12">
                        <label for="description">Descrição:  <span class="text-danger"> * </span></label>
                        <textarea id="description" name="description_alternative[@{{ idQuestion }}][@{{ id }}]" class="form-control" rows="2" required>@{{ description }}</textarea>
                    </div>
                    
                    <!-- Is Correct Field -->
                    <div class="col-sm-12 col-md-6 d-flex align-items-center">
                        <label>
                            <input class="is_correct" type="checkbox" name="is_correct[@{{ idQuestion }}][@{{ id }}]" data-id="@{{ id }}" data-id-question="@{{ idQuestion }}"
                                @{{#if is_correct }}
                                    checked
                                @{{/if }}
                            > Alternativa correta?
                        </label>
                    </div>
                    
                    <!-- Value Field -->
                    <div class="form-group col-sm-12 col-md-6" id="alternative_value_@{{ idQuestion }}_@{{ id }}">
                        <label for="value">Valor da alternativa:  <span class="text-danger"> * </span></label>
                        <input type="number" id="value" name="value_alternative[@{{ idQuestion }}][@{{ id }}]" class="form-control" value="@{{ value }}" min='0' max='10'>
                    </div>
                    
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</script>
<script type="text/javascript">
    const questionsType = {!! json_encode(config('quiz.question_types')) !!};
    
    var generator = new IdGenerator();
    var questionnaire = new Object;
    var questionnaireEdit = null;
    @if(Request::is('*/questionnaires/*/edit'))
        var questionnaireEdit = {!! json_encode($questionnaire) !!};
    @endif
    
    
    $(document).ready(function() {
        

        CKEDITOR.replace('instructions_before_start');
        CKEDITOR.replace('instructions_start');
        CKEDITOR.replace('instructions_end');
        
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
        })
        
        $(document).on('change', '#answer_once', function () {
            if($('#answer_once').prop('checked')) {
                $('#checkbox_waiting_time_block').hide();
                $('#checkbox_waiting_time').prop('checked', false);
                $('#waiting_time_block').hide();
                $('#waiting_time_block input').attr('disabled', true);
                $('#waiting_time_block select').attr('disabled', true);
            } else {
                $('#checkbox_waiting_time_block').show();
            }
        });
        
        $('#waiting_time_block').hide();
        $('#waiting_time_block input').attr('disabled', true);
        $('#waiting_time_block select').attr('disabled', true);   
        $('#execution_time_block').hide();
        $('#execution_time_block input').attr('disabled', true);
        $('#execution_time_block select').attr('disabled', true);
        
        if(questionnaireEdit) {
            if(questionnaireEdit.waiting_time) {
                $('#checkbox_waiting_time').prop('checked', true);
                $('#waiting_time_block').show();
                $('#waiting_time_block input').attr('disabled', false);
                $('#waiting_time_block select').attr('disabled', false);       
            }
            if(questionnaireEdit.execution_time) {
                $('#checkbox_execution_time').prop('checked', true);
                $('#execution_time_block').show();
                $('#execution_time_block input').attr('disabled', false);
                $('#execution_time_block select').attr('disabled', false);       
            }
        }
        
        $(document).on('change', '#checkbox_waiting_time', function () {
            if($('#checkbox_waiting_time').prop('checked')) {
                $('#waiting_time_block').show();
                $('#waiting_time_block input').attr('disabled', false);
                $('#waiting_time_block select').attr('disabled', false);
            } else {
                $('#waiting_time_block').hide();
                $('#waiting_time_block input').attr('disabled', true);
                $('#waiting_time_block select').attr('disabled', true);
            }
        });
        
        $(document).on('change', '#checkbox_execution_time', function () {
            if($('#checkbox_execution_time').prop('checked')) {
                $('#execution_time_block').show();
                $('#execution_time_block input').attr('disabled', false);
                $('#execution_time_block select').attr('disabled', false);
            } else {
                $('#execution_time_block').hide();
                $('#execution_time_block input').attr('disabled', true);
                $('#execution_time_block select').attr('disabled', true);
            }
        });
        
        $(document).on('change', '.is_correct', function () {
            var id = $(this).data('id');
            var idQuestion = $(this).data('id-question');
            if($(this).prop('checked')) {
                $('#alternative_value_'+ idQuestion + '_' + id).show();
                $('#alternative_value_'+ idQuestion + '_' + id + ' input').prop('required', true);
            } else {
                $('#alternative_value_'+ idQuestion + '_' + id).hide();
                $('#alternative_value_'+ idQuestion + '_' + id + ' input').prop('required', false);
            }
        });
        
        @if(Request::is('*/questionnaires/*/edit'))
            handleQuestionnaireEdit();
        @endif
        
        $(document).on('click', '#submitBtn', function(event) {
            handleSubmitRequiredInputCollapse();
        });

        $(document).on('click', '#questionAdd_js', function() {
            var idQuestion = addQuestion();
            handleQuestionType(idQuestion);
        });
        
        $(document).on('change', '.question_type_js', function() {    
            var thisIdQuestion = $(this).data('id');
            handleQuestionType(thisIdQuestion);
        });
            
        $(document).on('click', '.alternativeAdd_js', function() {
            var thisIdQuestion = $(this).data('id');
            addAlternative(thisIdQuestion, null, 0, null, null);
        });
        
        $(document).on('click', '.questionDelete_js', function() {
            var thisIdQuestion = $(this).data('id');
            var count = 1;
            for (var key in questionnaire) {
                if(key == thisIdQuestion) {
                    delete questionnaire[key]; 
                } else {
                    questionnaire[key]['questions'].set('count', count);   
                    count++;
                }
            }
            
            var status = true;
            if(typeof thisIdQuestion != "string") {
                status = questionDeleteAjax(thisIdQuestion);
            } 
            if(status) {
                $('#question_' + thisIdQuestion).remove();
                var countQuestion = $('.questions').length;
                $('#countQuestion').val(countQuestion);
            }
            
        });
    
        $(document).on('click', '.alternativeDelete_js', function() {
            var thisIdAlternative = $(this).data('id');
            var thisIdQuestion = $(this).data('id-question');
            
            var keys = Object.keys(questionnaire[thisIdQuestion]['alternatives']);
            if(keys.length == 1) {
                alert('Questões fechadas devem ter no mínimo 1 questão');
            } else {
                var status = true;
                if(typeof thisIdAlternative != "string") {
                    status = alternativeDeleteAjax(thisIdAlternative);
                }
                if(status) {
                    $('#alternative_'+ thisIdQuestion + '_' + thisIdAlternative).remove();   
                    var count = 1;
                    for (var key in questionnaire[thisIdQuestion]['alternatives']) {
                        if(key == thisIdAlternative) {
                            delete questionnaire[thisIdQuestion]['alternatives'][key]; 
                        } else {
                            questionnaire[thisIdQuestion]['alternatives'][key].set('count', count);
                            count++;
                        }
                    }
                }   
            }
        });

    });
    
    function addQuestion(description = null, hint = null, is_required = null, is_active = null, weight = null, question_type_id = null, idDB = null) {
        var countQuestion = $('.questions').length + 1;
        var collapseIn = '';
            
        $('#countQuestion').val(countQuestion);
        
        if(idDB) {
            idQuestion = idDB;
        } else {
            idQuestion = generator.generate() + '_new';
            is_active = true;
            collapseIn = 'in';
        }
        
        questionnaire[idQuestion] = [];
        questionnaire[idQuestion]['questions'] = new Ractive({
            target: '#questions',
            append: true,
            template: '#question-template',
            data: {
                questionsType: questionsType,
                count: countQuestion,
                id: idQuestion,
                description: description,
                hint: hint,
                is_required: is_required,
                is_active: is_active, 
                weight: weight,
                question_type_id: question_type_id,
                collapseIn: collapseIn
            }
        });
        questionnaire[idQuestion]['alternatives'] = new Object;
        
        return idQuestion;
    }
    
    function addAlternative(idQuestion, description = null, value = null, is_correct = null, idDB = null) {
        var countAlternative = $('#alternatives_' + idQuestion + ' .alternatives').length + 1;
        var collapseIn = '';
        
        if(idDB) {
            idAlternative = idDB;
        } else {
            idAlternative = generator.generate() + '_new';
            collapseIn = 'in';
        }
            
        questionnaire[idQuestion]['alternatives'][idAlternative] = new Ractive({
            target: '#alternatives_' + idQuestion,
            append: true,
            template: '#alternative-template',
            data: {
                questionsType: questionsType,
                count: countAlternative,
                id: idAlternative,
                idQuestion: idQuestion,
                description: description,
                value: value,
                is_correct: is_correct,
                collapseIn: collapseIn
            }
        });
        
        if (is_correct) {
            $('#alternative_value_'+ idQuestion + '_' + idAlternative).show();
            $('#alternative_value_'+ idQuestion + '_' + idAlternative + ' input').prop('required', true);
        } else {
            $('#alternative_value_'+ idQuestion + '_' + idAlternative).hide();
            $('#alternative_value_'+ idQuestion + '_' + idAlternative + ' input').prop('required', false);
        }
        
        $('#countAlternatives_' + idQuestion).val(countAlternative);
    }
    
    function questionDeleteAjax(id) {
        var success = false;
        $.ajax({
            url: '/{{ $parentName }}/{{ request()->$parentId }}/questions/' + id,
            type: 'POST',
            async: false,
            datatype: 'json',
            data: {
                "_token": '{{ csrf_token() }}',
                "_method": 'DELETE',
                id: id,
            },
            success: function(response){
                if(response.status == 'success') {
                    success = true;
                }
                alert(response.msg);
            },
            error: function(response) {
                alert("Não foi possível deletar a questão. Tente novamente mais tarde.");
            },
            fail: function(response) {
                alert("Não foi possível deletar a questão. Tente novamente mais tarde.");
            }
        });
        return success;
    }
    
    function alternativeDeleteAjax(id) {
        var success = false;
        $.ajax({
            url: '/{{ $parentName }}/{{ request()->$parentId }}/alternatives/' + id,
            type: 'POST',
            async: false,
            datatype: 'json',
            data: {
                "_token": '{{ csrf_token() }}',
                "_method": 'DELETE',
                id: id,
            },
            success: function(response){
                if(response.status == 'success') {
                    success = true;
                }
                alert(response.msg);
            },
            error: function(response) {
                alert("Não foi possível deletar a alternativa. Tente novamente mais tarde.");
            },
            fail: function(response) {
                alert("Não foi possível deletar a alternativa. Tente novamente mais tarde.");
            }
        });
        return success;
    }
    
    function handleQuestionType(idQuestion) {
        if($('#question_type_id_' + idQuestion).val() == questionsType.CLOSED.id) {
            if($('#question_' + idQuestion + ' .alternatives').length == 0) {
                addAlternative(idQuestion);
            }
            
            $('#alternatives_body_' + idQuestion).addClass('in');
            var icon = $('#alternatives_block_' + idQuestion).find('.btnCollapse i').first();
            icon.removeClass('fa-plus');
            icon.addClass('fa-minus');
            $('#alternatives_block_' + idQuestion).show();
            $('#alternativeAdd_js_' + idQuestion).show();
            $('#question_' + idQuestion + ' #alternatives_' + idQuestion).show();
            
            $('#question_' + idQuestion + ' .alternatives input').each(function() {
                $(this).attr('disabled', false);
            });
                    
        } else {
            $('#alternatives_block_' + idQuestion).hide();
            $('#alternativeAdd_js_' + idQuestion).hide();
            $('#question_' + idQuestion + ' #alternatives_' + idQuestion).hide();
            
            $('#question_' + idQuestion + ' .alternatives input').each(function() {
                $(this).attr('disabled', true);
            });
        }
    }
    
    function handleQuestionnaireEdit() {
        for(let question of questionnaireEdit['questions']) {
            var description = question['description'] ? question['description'] : null;
            var hint = question['hint'] ? question['hint'] : null;
            var is_required = question['is_required'] ? question['is_required'] : null;
            var is_active = question['is_active'] ? question['is_active'] : null;
            var weight = question['weight'] ? question['weight'] : null;
            var question_type_id = question['question_type_id'] ? question['question_type_id'] : null;
            var idDB = question['id'];
            
            var idQuestion = addQuestion(description, hint, is_required, is_active, weight, question_type_id, idDB);
            
            for(let alternative of question['alternatives']) {
                addAlternative(idQuestion, alternative['description'], alternative['value'], alternative['is_correct'], alternative['id']);    
            }
            
            handleQuestionType(idQuestion); 
        }
    }
    
    function IdGenerator() {
        this.length = 8;
        this.timestamp = +new Date;
        var _getRandomInt = function( min, max ) {
            return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
        }
        this.generate = function() {
            var ts = this.timestamp.toString();
            var parts = ts.split( "" ).reverse();
            var id = "";
            for( var i = 0; i < this.length; ++i ) {
                var index = _getRandomInt( 0, parts.length - 1 );
                id += parts[index];	 
            }   
            return id;
        }
    }
    
    function handleSubmitRequiredInputCollapse() {
        var error = false;
        $('#questions_body :input[required]').each(function() {
            if($(this).val() == "") {
                error = true;
                var box = $(this).closest('.box');
                var box_body = box.find('.box-body');
                var btn = box.find('.btnCollapse');
                if(btn.hasClass('collapsed')) {
                    btn.click();
                    var boxes = $(box).parents('.box');
                    console.log(boxes);
                    for(var i = 0; i < boxes.length; i++) {
                        var btn = $(boxes[i]).find('.btnCollapse')[0];
                        if(btn && $(btn).hasClass('collapsed')) {
                            btn.click();
                        }
                    }
                }
            }
        });
        return error;
    }
    
</script>
@endpush