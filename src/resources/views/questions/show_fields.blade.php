<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Descrição:') !!}
    <p> {!! $question->description !!}</p>
</div>

<!-- Hint Field -->
<div class="form-group col-sm-12">
    {!! Form::label('hint', 'Dica:') !!}
    <p> {!! $question->hint !!}</p>
</div>

<!-- Is Required Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_required', 'Questão obrigatória?') !!}
    <p>{!! $question->is_required ? 'Sim' : 'Não' !!}</p>
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_active', 'Questão ativa?') !!}
    <p>{!! $question->is_active ? 'Sim' : 'Não' !!}</p>
</div>

<!-- Weight Field -->
<div class="form-group col-sm-12">
    {!! Form::label('weight', 'Peso da questão:') !!}
    <p> {!! $question->weight !!}</p>
</div>

