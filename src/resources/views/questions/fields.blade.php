<!-- Question Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('question_type_id', 'Tipo da Questão:') !!}
    {!! Form::select('question_type_id', ['' => 'Selecione um tipo de questão'] + $questionsType, null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('decription', 'Descrição:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Hint Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hint', 'Dica:') !!}
    {!! Form::text('hint', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Required Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_required', 'Questão obrigatória?') !!}
    {!! Form::checkbox('is_required', null, null) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Questão ativa?') !!}
    {!! Form::checkbox('is_active', null, null) !!}
</div>

<!-- Weight Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weight', 'Peso da questão:') !!}
    {!! Form::number('weight', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('questions.index', request()->$parentName) !!}" class="btn btn-default">Cancelar</a>
</div>
