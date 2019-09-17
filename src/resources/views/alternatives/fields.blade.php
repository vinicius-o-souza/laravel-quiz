<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6" id="value_block">
    {!! Form::label('value', 'Nota da alternativa:') !!}
    {!! Form::number('value', null, ['class' => 'form-control', 'min' => '0', 'max' => '10']) !!}
</div>

<!-- Is Correct Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_correct', 'Resposta correta?') !!}
    {!! Form::checkbox('is_correct', null, null) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('alternatives.index', request()->$parentId) !!}" class="btn btn-default">Cancelar</a>
</div>

@push('scripts_quiz')
    <script src="{{ asset('vendor/pandoapps/js/jquery.min.js') }}"></script>
    <script type="text/javascript">
        if($('#is_correct').prop('checked')) {
            $('#value_block').show();
        } else {
            $('#value_block').hide();
        }
        $(document).on('change', '#is_correct', function () {
            if($('#is_correct').prop('checked')) {
                $('#value_block').show();
            } else {
                $('#value_block').hide();
            }
        });    
    </script>
@endpush