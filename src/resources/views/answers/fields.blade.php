<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Resposta:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('answers.index') !!}" class="btn btn-default">Cancelar</a>
</div>
