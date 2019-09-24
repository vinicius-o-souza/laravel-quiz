<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
use PandoApps\Quiz\DataTables\QuestionDataTableInterface;
use PandoApps\Quiz\Models\Question;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

class QuestionDataTable extends DataTable implements QuestionDataTableInterface
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
        $questionnaire_id = request()->questionnaire_id;
        
        if ($questionnaire_id) {
            $questions = Question::where('questionnaire_id', $questionnaire_id)->with('questionnaire')->with('questionType')->get();
        } else {
            $questions = Question::whereHas('questionnaire', function (Builder $query) use ($parentId) {
                $query->where('parent_id', $parentId);
            })->get();
        }
        

        return Datatables::of($questions)
            ->addColumn('action', 'pandoapps::questions.datatables_actions')
            ->addColumn('question_type', function (Question $question) {
                return $question->questionType->name;
            })
            ->editColumn('is_active', function (Question $question) {
                return $question->is_active ? 'Sim' : 'Não';
            })
            ->editColumn('is_required', function (Question $question) {
                return $question->is_required ? 'Sim' : 'Não';
            })
            ->editColumn('questionnaire_id', function (Question $question) {
                return $question->questionnaire->name;
            })
            ->addColumn('alternatives', function (Question $question)  use ($parentName, $parentId) {
                if ($question->isCLosed()) {
                    return '<a href="'. route('alternatives.index', [$parentName => $parentId, 'question_id' => $question->id, 'questionnaire_id' => $question->questionnaire_id]) .'"> Alternativas </a>';
                }
                return '';
            })
            ->rawColumns(['action', 'question_type', 'is_active', 'is_required', 'alternatives']);
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
            'questionnaire_id'  => ['title' => \Lang::get('pandoapps::datatable.columns.questions.questionnaire_id')],
            'question_type'     => ['title' => \Lang::get('pandoapps::datatable.columns.questions.question_type')],
            'description'       => ['title' => \Lang::get('pandoapps::datatable.columns.questions.description')],
            'hint'              => ['title' => \Lang::get('pandoapps::datatable.columns.questions.hint')],
            'weight'            => ['title' => \Lang::get('pandoapps::datatable.columns.questions.weight')],
            'is_required'       => ['title' => \Lang::get('pandoapps::datatable.columns.questions.is_required')],
            'is_active'         => ['title' => \Lang::get('pandoapps::datatable.columns.questions.is_active')],
            'alternatives'      => ['title' => \Lang::get('pandoapps::datatable.columns.questions.alternatives')]
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
