<form action="{{ route('questionnaires.destroy', [$parentId => request()->$parentId, 'questionnaire_id' => $id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class='btn-group'>
        <a href="{{ route('executables.statistics', [$parentId => request()->$parentId, 'questionnaire_id' => $id]) }}" class='btn btn-primary' title="Estatísticas do Questionário">
            <i class="fa fa-pie-chart"></i>
        </a>
        <a href="{{ route('executables.index', [$parentId => request()->$parentId, 'questionnaire_id' => $id]) }}" class='btn btn-secondary text-white' title="Respostas do Questionário">
            <i class="fa fa-tasks"></i>
        </a>
        <a href="{{ route('executables.create', [$parentId => request()->$parentId, 'questionnaire_id' => $id, 'model_id' => Auth::user()->id]) }}" class='btn btn-success' title="Responder questionário">
            <i class="fa fa-play"></i>
        </a>
        <a href="{{ route('questionnaires.show', [$parentId => request()->$parentId, 'questionnaire_id' => $id]) }}" class='btn btn-info'>
        <i class="fa fa-info-circle"></i>
        </a>
        <a href="{{ route('questionnaires.edit', [$parentId => request()->$parentId, 'questionnaire_id' => $id]) }}" class='btn btn-warning'>
        <i class="fa fa-edit"></i>
        </a>
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-danger',
            'onclick' => "return confirm('Deseja realmente deletar?')"
        ]) !!}
    </div>
</form>
