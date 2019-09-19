<form action="{{ route('questions.destroy', [$parentId => request()->$parentId, 'question_id' => $id, 'questionnaire_id' => request()->questionnaire_id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class='btn-group'>
        <a href="{{ route('questions.show', [$parentId => request()->$parentId, 'question_id' => $id, 'questionnaire_id' => request()->questionnaire_id]) }}" class='btn btn-info'>
        <i class="fa fa-info-circle"></i>
        </a>
        <a href="{{ route('questions.edit', [$parentId => request()->$parentId, 'question_id' => $id, 'questionnaire_id' => request()->questionnaire_id]) }}" class='btn btn-warning'>
        <i class="fa fa-edit"></i>
        </a>
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-danger',
            'onclick' => "return confirm('Deseja realmente deletar?')"
        ]) !!}
    </div>
</form>
