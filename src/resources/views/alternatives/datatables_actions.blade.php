<form action="{{ route('alternatives.destroy', [$parentId => request()->$parentId, 'alternative_id' => $id, 'question_id' => request()->question_id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class='btn-group'>
        <a href="{{ route('alternatives.show', [$parentId => request()->$parentId, 'alternative_id' => $id, 'question_id' => request()->question_id]) }}" class='btn btn-info'>
            <i class="fa fa-info-circle"></i>
        </a>
        <a href="{{ route('alternatives.edit', [$parentId => request()->$parentId, 'alternative_id' => $id, 'question_id' => request()->question_id]) }}" class='btn btn-warning'>
            <i class="fa fa-edit"></i>
        </a>
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-danger',
            'onclick' => "return confirm('Deseja realmente deletar?')"
        ]) !!}
    </div>
</form>
