<div class='btn-group'>
    <a href="{{ route('executables.show', ['parent_id' => request()->config('quiz.models.parent_name_singular'), 'executable_id' => $id]) }}" class='btn btn-info btn-xs' title="Respostas">
        <i class="fa fa-info-circle"></i>
    </a>
</div>
