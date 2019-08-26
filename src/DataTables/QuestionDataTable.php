<?php

namespace PandoApps\Quiz\DataTables;

use PandoApps\Quiz\Models\Question;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class QuestionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Datatables
     */
    public function dataTable()
    {
        $questionnaire_id = request()->questionnaire_id;
        
        if($questionnaire_id) {
            $questions = Question::where('questionnaire_id', $questionnaire_id)->with('questionnaire')->with('questionType')->get();
        } else {
            $questions = Question::all(); 
        }
        

        return Datatables::of($questions)
            ->addColumn('action' , 'pandoapps::questions.datatables_actions')
            ->addColumn('question_type', function(Question $question) {
                return $question->questionType->name;
            })
            ->editColumn('is_active', function(Question $question) {
                return $question->is_active ? 'Sim' : 'Não';
            })
            ->editColumn('is_required', function(Question $question) {
                return $question->is_required ? 'Sim' : 'Não';
            })
            ->editColumn('questionnaire_id', function(Question $question) {
                return $question->questionnaire->name;
            })
            ->addColumn('alternatives', function(Question $question) {
                if($question->question_type_id == config('quiz.question_types.CLOSED.id'))
                    return '<a href="'. route('alternatives.index', ['question_id' => $question->id]) .'"> Alternativas </a>';
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
        $questionnaire_id = request()->questionnaire_id;
        if($questionnaire_id) {
            return [
                'question_type'     => ['title' => 'Tipo da Questão'],
                'description'        => ['title' => 'Descrição'],
                'hint'              => ['title' => 'Dica'],
                'weight'            => ['title' => 'Peso'],
                'is_required'       => ['title' => 'Obrigatória'],
                'is_active'         => ['title' => 'Ativa'],
                'alternatives'      => ['title' => 'Alternativas']
            ];
        } else {
            return [
                'questionnaire_id'  => ['title' => 'Questionário'],
                'question_type'     => ['title' => 'Tipo da Questão'],
                'description'       => ['title' => 'Descrição'],
                'hint'              => ['title' => 'Dica'],
                'weight'            => ['title' => 'Peso'],
                'is_required'       => ['title' => 'Obrigatória'],
                'is_active'         => ['title' => 'Ativa'],
                'alternatives'      => ['title' => 'Alternativas']
            ];
        }
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
