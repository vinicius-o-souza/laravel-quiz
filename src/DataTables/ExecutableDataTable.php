<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
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
        $parentId = request()->parent_id;
        $questionnaireId = request()->questionnaire_id;
        $modelId = request()->model_id;
        
        $executables = Executable::whereHas('questionnaire', function (Builder $query) use ($parentId) {
            $query->where('parent_id', $parentId);
        });
        if($modelId) {
            $executables->where('executable_id', $modelId);
        }
        if($questionnaireId) {
            $executables->where('questionnaire_id', $questionnaireId);
        }
        
        $executables->get(); 
        

        return Datatables::of($executables)
            ->addColumn('action' , 'pandoapps::executables.datatables_actions')
            ->editColumn('questionnaire_id', function(Executable $executable) {
                return $executable->questionnaire->name;
            })
            ->editColumn('executable_id', function(Executable $executable) {
                $type = $executable->executable_type;
                $columnName = config('quiz.models.executable_column_name');
                if ($columnName) {
                   return $executable->executable->$columnName; 
                }
                return $executable->id;
            })
            ->editColumn('created_at', function(Executable $executable) {
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
        $modelId = request()->model_id;
        if($modelId) {
            return [
                'questionnaire_id'  => ['title' => 'Questionário'],
                'score'             => ['title' => 'Nota'],
                'created_at'        => ['title' => 'Data']
            ];
        } else {
            return [
                'executable_id'     => ['title' => 'Respondeu'],
                'questionnaire_id'  => ['title' => 'Questionário'],
                'score'             => ['title' => 'Nota'],
                'created_at'        => ['title' => 'Data']
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
