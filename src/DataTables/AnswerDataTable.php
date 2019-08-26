<?php

namespace PandoApps\Quiz\DataTables;

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
        $question_id = request()->question_id;
        $answers = Answer::where('question_id', $question_id)->with('questions')->with('alternatives')->get();

        return Datatables::of($answers)
            ->addColumn('action' , 'pandoapps::answers.datatables_actions')
            ->addColumn('question', function(Answer $answer) {
                return $answer->question->title;
            })
            ->addColumn('alternative', function(Answer $answer) {
                return $answer->alternative->title;
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
            'description'   => ['title' => 'Descrição'],
            'alternative'   => ['title' => 'Alternativa'],
            'score'         => ['title' => 'Pontuação'],
            'alternativa'   => ['title' => 'Alternativa']
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
