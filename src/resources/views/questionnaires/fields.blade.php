<!-- Name Field -->
<div class="form-group col-sm-12 col-md-6">
    <label for="name"> Nome:  <span class="text-danger"> * </span></label>
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Answer Once Field -->
<div class="form-group col-sm-12">
    {!! Form::label('answer_once', 'Resposta única?') !!}
    {!! Form::checkbox('answer_once', null, null) !!}
</div>

<!-- Waiting Time Checkbox -->
<div class="form-group col-sm-12" id="checkbox_waiting_time_block">
    {!! Form::label('checkbox_waiting_time', 'Deseja definir um tempo de espera para submeter outra resposta?') !!}
    {!! Form::checkbox('checkbox_waiting_time', null, null, ['id' => 'checkbox_waiting_time']) !!}
</div>

<div class="row col-sm-12" id="waiting_time_block" style="display:none">
    <!-- Waiting Time Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('waiting_time', 'Tempo de Espera:') !!}
        {!! Form::text('waiting_time', null, ['class' => 'form-control']) !!}
    </div>
    
    <!-- Type Waiting Time Field -->
    <div class="form-group col-sm-6">
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

<!-- Execution Time Checkbox -->
<div class="form-group col-sm-12">
    {!! Form::label('checkbox_execution_time', 'Deseja definir um tempo máximo de execução do questionário?') !!}
    {!! Form::checkbox('checkbox_execution_time', null, null, ['id' => 'checkbox_execution_time']) !!}
</div>

<div class="row col-sm-12" id="execution_time_block" style="display:none">
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

<input type="hidden" name="countQuestion" id="countQuestion" value="0">

<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4>Questões</h4>
        </div>
        <ul class="list-group list-group-flush" id="questions"></ul>
        
        <!-- Add Question Field -->
        <div class="form-group col-sm-12">
            <a id="questionAdd_js" class="btn btn-success text-white float-right">Questão <i class="fa fa-plus"></i></a>
        </div>
    </div>      
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12 pt-5">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('questionnaires.index', request()->$parentId) !!}" class="btn btn-default">Cancelar</a>
</div>

@push('scripts_quiz')
<script src="{{ asset('vendor/pandoapps/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/pandoapps/js/ractive.js') }}"></script>
<script src="{{ asset('vendor/pandoapps/js/jquery.ba-throttle-debounce.min.js') }}"></script>

<script id="question-template" type="text/ractive">
    <li class="list-group-item questions" id="question_@{{ id }}">
        <div class="row">
            <div class="col-sm-12">
                <button type="button" class="btn btn-danger questionDelete_js" data-id="@{{ id }}"><i class="fa fa-trash"></i></button>
            </div>
            <div class="col-sm-12 col-md-2 d-flex align-items-center">
                <h2><b> Questão @{{ count }} </b></h2>
            </div>
            <div class="col-sm-12 col-md-10">
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
                        <input type="number" id="weight" name="weight[@{{ id }}]" class="form-control" value="@{{ weight }}" required>
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
                            <input type="checkbox" name="is_active[@{{ id }}][]"
                                @{{#if is_active }}
                                    checked
                                @{{/if }}
                            > Questão ativa?
                        </label>
                    </div>
                    
                    <div id="alternatives_@{{ id }}" class="col-sm-12"></div>
                    
                    <input type="hidden" name="countAlternatives[@{{ id }}]" id="countAlternatives_@{{ id }}" value="0">
                    
                    <!-- Add Alternative Field -->
                    <div class="form-group col-sm-12">
                        <a id="alternativeAdd_js_@{{ id }}" data-id="@{{ id }}" class="alternativeAdd_js btn btn-success text-white float-right">Alternativas <i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </li>
</script>

<script id="alternative-template" type="text/ractive">
    <div class="col-sm-12 row alternatives" id="alternative_@{{ idQuestion }}_@{{ id }}">
        <hr class="col-sm-12">
        <div class="col-sm-12">
            <button type="button" class="btn btn-danger alternativeDelete_js float-right" data-id="@{{ id }}" data-id-question="@{{ idQuestion }}"><i class="fa fa-trash"></i></button>
        </div>
        <div class="col-sm-12 col-md-3 d-flex align-items-center">
            <h4><b> Alternativa @{{ count }} </b></h4>
        </div>
        <div class="col-sm-12 col-md-9 row">
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
                <label for="value">Nota da alternativa:  <span class="text-danger"> * </span></label>
                <input type="number" id="value" name="value_alternative[@{{ idQuestion }}][@{{ id }}]" class="form-control" value="@{{ value }}" min='0' max='10' required>
            </div>
            
        </div>
    </div>
</script>

<script type="text/javascript">
    const questionsType = {!! json_encode(config('quiz.question_types')) !!};
    
    var questionnaire = [];
    var questionnaireEdit = null;
    @if(Request::is('*/questionnaires/*/edit'))
        var questionnaireEdit = {!! json_encode($questionnaire) !!};
    @endif
    
    
    $(document).ready(function() {
        
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
            } else {
                $('#alternative_value_'+ idQuestion + '_' + id).hide();
            }
        });
        
        @if(Request::is('*/questionnaires/*/edit'))
            handleQuestionnaireEdit();
        @endif

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
            
            addAlternative(thisIdQuestion);
            
        });
        
        $(document).on('click', '.questionDelete_js', function() {
            var thisIdQuestion = $(this).data('id');
            
            questionnaire.forEach(function(value, index) {
                if(index >= thisIdQuestion) {
                    questionnaire[index]['questions'].set('id', index);
                } 
            });
            
            questionnaire.splice(thisIdQuestion - 1, 1); 
            
            $('#question_' + thisIdQuestion).remove();
            
            var countQuestion = $('.questions').length;
            
            $('#countQuestion').val(countQuestion);
            
            if(typeof thisIdQuestion != "string") {
                questionDeleteAjax(thisIdQuestion);
            }
            
        });
    
        $(document).on('click', '.alternativeDelete_js', function() {
            var thisIdAlternative = $(this).data('id');
            var thisIdQuestion = $(this).data('id-question');
            
            questionnaire[thisIdQuestion - 1]['alternatives'].forEach(function(value, index) {
                if(index >= thisIdAlternative) {
                    questionnaire[thisIdQuestion - 1]['alternatives'][index].set('id', index);
                } 
            });
            
            questionnaire[thisIdQuestion - 1]['alternatives'].splice(thisIdAlternative - 1, 1);
            
            $('#alternative_'+ thisIdQuestion + '_' + thisIdAlternative).remove();
            
            if(typeof thisIdAlternative != "string") {
                alternativeDeleteAjax(thisIdAlternative);
            }
        });

    });
    
    function addQuestion(description = null, hint = null, is_required = null, is_active = null, weight = null, question_type_id = null, idDB = null) {
        var countQuestion = $('.questions').length + 1;
            
        $('#countQuestion').val(countQuestion);
        
        if(idDB) {
            idQuestion = idDB;
        } else {
            idQuestion = countQuestion + '_new';
            is_active = true;
        }
        
        questionnaire[idQuestion - 1] = [];
        questionnaire[idQuestion - 1]['questions'] = new Ractive({
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
                question_type_id: question_type_id
            }
        });
        questionnaire[idQuestion - 1]['alternatives'] = [];
        
        return idQuestion;
    }
    
    function addAlternative(idQuestion, description = null, value = null, is_correct = null, idDB = null) {
        var countAlternative = $('#alternatives_' + idQuestion + ' .alternatives').length + 1;
        
        if(idDB) {
            idAlternative = idDB;
        } else {
            idAlternative = countAlternative + '_new';
        }
            
        questionnaire[idQuestion - 1]['alternatives'][countAlternative - 1] = new Ractive({
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
                is_correct: is_correct
            }
        });
        
        if (is_correct) {
            $('#alternative_value_'+ idQuestion + '_' + idAlternative).show();
        } else {
            $('#alternative_value_'+ idQuestion + '_' + idAlternative).hide();
        }
        
        $('#countAlternatives_' + idQuestion).val(countAlternative);
    }
    
    function questionDeleteAjax(id) {
        $.ajax({
            url: '/{{ $parentName }}/{{ request()->$parentId }}/questions/' + id,
            type: 'POST',
            datatype: 'json',
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "_method": 'DELETE',
                id: id,
            },
            success: function(response){
                alert("Questão deletada com suceso!");
            },
            error: function(response) {
                alert("Não foi possível deletar a questão. Tente novamente mais tarde.");
            },
            fail: function(response) {
                alert("Não foi possível deletar a questão. Tente novamente mais tarde.");
            }
        });
    }
    
    function alternativeDeleteAjax(id) {
        $.ajax({
            url: '/alternatives/' + id,
            type: 'POST',
            datatype: 'json',
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "_method": 'DELETE',
                id: id,
            },
            success: function(response){
                alert("Alternativa deletada com suceso!");
            },
            error: function(response) {
                alert("Não foi possível deletar a alternativa. Tente novamente mais tarde.");
            },
            fail: function(response) {
                alert("Não foi possível deletar a alternativa. Tente novamente mais tarde.");
            }
        });
    }
    
    function handleQuestionType(idQuestion) {
        if($('#question_type_id_' + idQuestion).val() == questionsType.CLOSED.id) {
            if($('#question_' + idQuestion + ' .alternatives').length == 0) {
                addAlternative(idQuestion);
            }
            $('#alternativeAdd_js_' + idQuestion).show();
            $('#question_' + idQuestion + ' #alternatives_' + idQuestion).show();
            
            $('#question_' + idQuestion + ' .alternatives input').each(function() {
                $(this).attr('disabled', false);
            });
                    
        } else {
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
    
</script>
@endpush