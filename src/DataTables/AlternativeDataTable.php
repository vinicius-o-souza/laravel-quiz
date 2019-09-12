<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
use PandoApps\Quiz\Models\Alternative;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

class AlternativeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Datatables
     */
    public function dataTable()
    {
        $parentName = config('quiz.models.parent_id');
        $parent_id = request()->$parentName;
        $question_id = request()->question_id;
        
        if ($question_id) {
            $alternatives = Alternative::whereHas('question.questionnaire', function (Builder $query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })->where('question_id', $question_id)->with('question')->get();
        } else {
            $alternatives = Alternative::whereHas('question.questionnaire', function (Builder $query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })->get();
        }
        
        return Datatables::of($alternatives)
            ->addColumn('action', 'pandoapps::alternatives.datatables_actions')
            ->addColumn('question', function (Alternative $alternative) {
                return $alternative->question->description;
            })
            ->editColumn('is_correct', function (Alternative $alternative) {
                return $alternative->is_correct ? 'Sim' : 'Não';
            })
            ->rawColumns(['action', 'question']);
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
    protected function getColumns()
    {
        return [
            'question'      => ['title' => \Lang::get('pandoapps::datatable.columns.alternatives.question')],
            'description'   => ['title' => \Lang::get('pandoapps::datatable.columns.alternatives.description')],
            'value'         => ['title' => \Lang::get('pandoapps::datatable.columns.alternatives.value')],
            'is_correct'    => ['title' => \Lang::get('pandoapps::datatable.columns.alternatives.is_correct')],
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
