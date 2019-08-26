<?php

namespace PandoApps\Quiz\DataTables;

use PandoApps\Quiz\Models\Executable;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\EloquentDataTable;
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
        $modelId = request()->model_id;
        
        if($modelId) {
            $executables = Executable::where('executable_id', $modelId)->with('questionnaire')->get();
        } else {
            $executables = Executable::all(); 
        }
        

        return Datatables::of($executables)
            ->editColumn('questionnaire_id', function(Executable $executable) {
                return $executable->questionnaire->name;
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
        if($modelId) {
            return [
                'questionnaire_id'  => ['title' => 'Questionário'],
                'score'             => ['title' => 'Nota'],
            ];
        } else {
            return [
                'executable_id'     => ['title' => 'Respondeu'],
                'questionnaire_id'  => ['title' => 'Questionário'],
                'score'             => ['title' => 'Nota'],
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
