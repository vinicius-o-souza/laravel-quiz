<?php

namespace PandoApps\Quiz\DataTables;

use PandoApps\Quiz\Models\Questionnaire;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

class QuestionnaireDataTable extends DataTable implements QuestionnaireDataTableInterface
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
        
        $questionnaires = Questionnaire::where('parent_id', $parentId)->with('executables')->get();

        return Datatables::of($questionnaires)
            ->addColumn('action', 'pandoapps::questionnaires.datatables_actions')
            ->editColumn('is_active', function (Questionnaire $questionnaire) {
                return $questionnaire->is_active ? 'Sim' : 'Não';
            })
            ->editColumn('answer_once', function (Questionnaire $questionnaire) {
                return $questionnaire->answer_once ? 'Sim' : 'Não';
            })
            ->addColumn('questions', function (Questionnaire $questionnaire) use ($parentName, $parentId) {
                return '<a href="'. route('questions.index', [$parentName => $parentId, 'questionnaire_id' => $questionnaire->id]) .'"> Questões </a>';
            })
            ->addColumn('execution_time', function (Questionnaire $questionnaire) {
                if ($questionnaire->execution_time) {
                    return $questionnaire->execution_time .' ' . $questionnaire->handleTypeTime($questionnaire->type_execution_time);
                }
                return 'Ilimitado';
            })
            ->addColumn('waiting_time', function (Questionnaire $questionnaire) {
                if ($questionnaire->waiting_time) {
                    return $questionnaire->waiting_time .' ' . $questionnaire->handleTypeTime($questionnaire->type_waiting_time);
                }
                return 'Sem espera';
            })
            ->rawColumns(['action', 'is_active', 'answer_once', 'questions', 'execution_time', 'waiting_time']);
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
            'name'              => ['title' => \Lang::get('pandoapps::datatable.columns.questionnaires.name')],
            'answer_once'       => ['title' => \Lang::get('pandoapps::datatable.columns.questionnaires.answer_once')],
            'is_active'         => ['title' => \Lang::get('pandoapps::datatable.columns.questionnaires.is_active')],
            'questions'         => ['title' => \Lang::get('pandoapps::datatable.columns.questionnaires.questions')],
            'execution_time'    => ['title' => \Lang::get('pandoapps::datatable.columns.questionnaires.execution_time')],
            'waiting_time'      => ['title' => \Lang::get('pandoapps::datatable.columns.questionnaires.waiting_time')]
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
