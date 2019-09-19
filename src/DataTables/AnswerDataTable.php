<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
use PandoApps\Quiz\DataTables\AnswerDataTableInterface;
use PandoApps\Quiz\Models\Answer;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

class AnswerDataTable extends DataTable implements AnswerDataTableInterface
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Datatables
     */
    public function dataTable()
    {
        $parentName = config('quiz.models.parent_url_name');
        $parentId = config('quiz.models.parent_id');
        $parentId = request()->$parentId;
        $questionId = request()->question_id;
        
        $answers = Answer::whereHas('question.questionnaire', function (Builder $query) use ($parentId) {
            $query->where('parent_id', $parentId);
        })->with('alternative');
        if ($questionId) {
            $answers->where('question_id', $questionId);
        }
        $answers->get();

        return Datatables::of($answers)
            ->addColumn('action', 'pandoapps::answers.datatables_actions')
            ->addColumn('question', function (Answer $answer) {
                return $answer->question->description;
            })
            ->addColumn('alternative', function (Answer $answer) {
                if ($answer->alternative) {
                    return $answer->alternative->description;
                }
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
            ->addAction(['printable' => false, 'title' => 'Opções'])
            ->parameters(DataTablesDefaults::getParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            'question'      => ['title' => \Lang::get('pandoapps::datatable.columns.answers.question')],
            'alternative'   => ['title' => \Lang::get('pandoapps::datatable.columns.answers.alternative')],
            'description'   => ['title' => \Lang::get('pandoapps::datatable.columns.answers.description')],
            'score'         => ['title' => \Lang::get('pandoapps::datatable.columns.answers.score')]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    public function filename()
    {
        return 'questionnairesdatatable_' . time();
    }
}
