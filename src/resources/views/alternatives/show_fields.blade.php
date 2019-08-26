
<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Descrição:') !!}
    <p> {!! $alternative->description !!} </p>
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Nota da alternativa:') !!}
    <p> {!! $alternative->value !!} </p>
</div>

<!-- Is Correct Field -->
<div class="form-group col-sm-12 col-md-6">
    <label>Questão correta?</label>
    <p>{!! $alternative->is_correct ? 'Sim' : 'Não' !!}</p>
</div>
    