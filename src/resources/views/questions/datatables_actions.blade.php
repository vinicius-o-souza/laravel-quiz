{!! Form::open(['route' => ['questions.destroy', request()->$parentId, $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('questions.show', ['parent_id' => request()->$parentId, 'question_id' => $id]) }}" class='btn btn-info'>
       <i class="fa fa-info-circle"></i>
    </a>
    <a href="{{ route('questions.edit', ['parent_id' => request()->$parentId, 'question_id' => $id]) }}" class='btn btn-warning'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger',
        'onclick' => "return confirm('Deseja realmente deletar?')"
    ]) !!}
</div>
{!! Form::close() !!}
