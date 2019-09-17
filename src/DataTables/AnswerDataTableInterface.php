<?php

namespace PandoApps\Quiz\DataTables;

use Illuminate\Database\Eloquent\Builder;
use PandoApps\Quiz\Models\Answer;
use PandoApps\Quiz\Services\DataTablesDefaults;
use Yajra\DataTables\Datatables;
use Yajra\DataTables\Services\DataTable;

interface AnswerDataTableInterface
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\Datatables
     */
    public function dataTable();

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html();

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns();

    /**
     * Get filename for export.
     *
     * @return string
     */
    public function filename();
}
