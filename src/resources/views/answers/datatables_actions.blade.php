{!! Form::open(['route' => ['answers.destroy', request()->config('quiz.models.parent_name_singular'), $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('answers.show', ['parent_id' => request()->config('quiz.models.parent_name_singular'), 'answer_id' => $id]) }}" class='btn btn-info'>
       <i class="fa fa-info-circle"></i>
    </a>
    <a href="{{ route('answers.edit', ['parent_id' => request()->config('quiz.models.parent_name_singular'), 'answer_id' => $id]) }}" class='btn btn-warning'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger',
        'onclick' => "return confirm('Deseja realmente deletar?')"
    ]) !!}
</div>
{!! Form::close() !!}
