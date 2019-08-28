<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
use PandoApps\Quiz\Models\Answer;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class AnswerDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Datatables
     */
    public function dataTable()
    {
        $parentId = request()->parent_id;
        $question_id = request()->question_id;
        
        $answers = Answer::whereHas('question.questionnaire', function (Builder $query) use ($parentId) {
            $query->where('parent_id', $parentId);
        })->with('alternative');
        if($question_id) {
            $answers->where('question_id', $question_id);
        }
        $answers->get();

        return Datatables::of($answers)
            ->addColumn('action' , 'pandoapps::answers.datatables_actions')
            ->addColumn('question', function(Answer $answer) {
                return $answer->question->description;
            })
            ->addColumn('alternative', function(Answer $answer) {
                if($answer->alternative)
                    return $answer->alternative->description;
                return 'Questão aberta';
            })
            ->rawColumns(['action']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->minifiedAjax()
            ->columns($this->getColumns())
            ->addAction(['width' => '75px', 'printable' => false, 'title' => 'Opções'])
            ->parameters(DataTablesDefaults::getParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'question'      => ['title' => 'Questão'],
            'alternative'   => ['title' => 'Alternativa'],
            'description'   => ['title' => 'Resposta'],
            'score'         => ['title' => 'Pontuação'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'questionnairesdatatable_' . time();
    }
}
