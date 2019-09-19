<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
use PandoApps\Quiz\DataTables\AlternativeDataTableInterface;
use PandoApps\Quiz\Models\Alternative;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

class AlternativeDataTable extends DataTable implements AlternativeDataTableInterface
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
        $alternativeId = request()->alternative_id;
        $questionId = request()->question_id;
        
        if ($alternativeId) {
            $alternatives = Alternative::whereHas('question.questionnaire', function (Builder $query) use ($parentId) {
                $query->where('parent_id', $parentId);
            })->where('alternative_id', $alternativeId)->with('question');
        } else {
            $alternatives = Alternative::whereHas('question.questionnaire', function (Builder $query) use ($parentId) {
                $query->where('parent_id', $parentId);
            });
        }
        
        if ($questionId) {
            $alternatives = $alternatives->where('question_id', $questionId);
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
    public function getColumns()
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
    public function filename()
    {
        return 'questionnairesdatatable_' . time();
    }
}
