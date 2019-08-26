{!! Form::open(['route' => ['questionnaires.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('executables.index', ['model_id' => Auth::user()->id]) }}" class='btn btn-primary' title="Respostas do Questionário">
        <i class="fa fa-tasks"></i>
    </a>
    <a href="{{ route('executables.create', ['questionnaire_id' => $id, 'model_id' => Auth::user()->id]) }}" class='btn btn-success' title="Responder questionário">
        <i class="fa fa-play"></i>
    </a>
    <a href="{{ route('questionnaires.show', $id) }}" class='btn btn-info'>
       <i class="fa fa-info-circle"></i>
    </a>
    <a href="{{ route('questionnaires.edit', $id) }}" class='btn btn-warning'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger',
        'onclick' => "return confirm('Deseja realmente deletar?')"
    ]) !!}
</div>
{!! Form::close() !!}
