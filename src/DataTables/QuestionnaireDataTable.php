<?php

namespace PandoApps\Quiz\DataTables;

use PandoApps\Quiz\Models\Questionnaire;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class QuestionnaireDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Datatables
     */
    public function dataTable()
    {
        $questionnaires = Questionnaire::with('executables')->get();

        return Datatables::of($questionnaires)
            ->addColumn('action', 'pandoapps::questionnaires.datatables_actions')
            ->editColumn('is_active', function(Questionnaire $questionnaire) {
                return $questionnaire->is_active ? 'Sim' : 'Não';
            })
            ->editColumn('answer_once', function(Questionnaire $questionnaire) {
                return $questionnaire->answer_once ? 'Sim' : 'Não';
            })
            ->addColumn('questions', function(Questionnaire $questionnaire) {
                return '<a href="'. route('questions.index', ['questionnaire_id' => $questionnaire->id]) .'"> Questões </a>';
            })
            ->rawColumns(['action', 'is_active', 'answer_once', 'questions']);
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
            'name'          => ['title' => 'Nome'],
            'answer_once'   => ['title' => 'Resposta Única'],
            'is_active'     => ['title' => 'Ativo'],
            'questions'     => ['title' => 'Questões']
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
