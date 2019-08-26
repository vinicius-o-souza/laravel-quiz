<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Nota da alternativa:') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Correct Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_correct', 'Resposta correta?') !!}
    {!! Form::checkbox('is_correct', null, null) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('alternatives.index') !!}" class="btn btn-default">Cancelar</a>
</div>
