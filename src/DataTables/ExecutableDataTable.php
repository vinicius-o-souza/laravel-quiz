<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
use PandoApps\Quiz\Models\Executable;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

class ExecutableDataTable extends DataTable
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
        $questionnaireId = request()->questionnaire_id;
        $modelId = request()->model_id;
        
        $executables = Executable::whereHas('questionnaire', function (Builder $query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        });
        if ($modelId) {
            $executables->where('executable_id', $modelId);
        }
        if ($questionnaireId) {
            $executables->where('questionnaire_id', $questionnaireId);
        }
        
        $executables->get();
        

        return Datatables::of($executables)
            ->addColumn('action', 'pandoapps::executables.datatables_actions')
            ->editColumn('questionnaire_id', function (Executable $executable) {
                return $executable->questionnaire->name;
            })
            ->editColumn('executable_id', function (Executable $executable) {
                $columnName = config('quiz.models.executable_column_name');
                if ($columnName) {
                    return $executable->executable->$columnName;
                }
                return $executable->id;
            })
            ->editColumn('created_at', function (Executable $executable) {
                return $executable->created_at->format('d/m/Y');
            });
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
        $modelId = request()->model_id;
        if ($modelId) {
            return [
                'questionnaire_id'  => ['title' => \Lang::get('pandoapps::datatable.columns.executables.questionnaire_id')],
                'score'             => ['title' => \Lang::get('pandoapps::datatable.columns.executables.score')],
                'created_at'        => ['title' => \Lang::get('pandoapps::datatable.columns.executables.created_at')]
            ];
        } else {
            return [
                'executable_id'     => ['title' => \Lang::get('pandoapps::datatable.columns.executables.executable_id')],
                'questionnaire_id'  => ['title' => \Lang::get('pandoapps::datatable.columns.executables.questionnaire_id')],
                'score'             => ['title' => \Lang::get('pandoapps::datatable.columns.executables.score')],
                'created_at'        => ['title' => \Lang::get('pandoapps::datatable.columns.executables.created_at')]
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
