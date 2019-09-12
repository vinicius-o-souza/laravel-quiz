{!! Form::open(['route' => ['questionnaires.destroy', request()->$parentName, $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('executables.index', ['parent_id' => request()->$parentName, 'model_id' => Auth::user()->id]) }}" class='btn btn-primary' title="Respostas do Questionário">
        <i class="fa fa-tasks"></i>
    </a>
    <a href="{{ route('executables.create', ['parent_id' => request()->$parentName, 'questionnaire_id' => $id, 'model_id' => Auth::user()->id]) }}" class='btn btn-success' title="Responder questionário">
        <i class="fa fa-play"></i>
    </a>
    <a href="{{ route('questionnaires.show', ['parent_id' => request()->$parentName, 'questionnaire_id' => $id]) }}" class='btn btn-info'>
       <i class="fa fa-info-circle"></i>
    </a>
    <a href="{{ route('questionnaires.edit', ['parent_id' => request()->$parentName, 'questionnaire_id' => $id]) }}" class='btn btn-warning'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger',
        'onclick' => "return confirm('Deseja realmente deletar?')"
    ]) !!}
</div>
{!! Form::close() !!}
