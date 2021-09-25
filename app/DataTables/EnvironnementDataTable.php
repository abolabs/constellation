<?php

namespace App\DataTables;

use App\Models\Environnement;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class EnvironnementDataTable extends AbstractCommonDatatable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'environnements.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Environnement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Environnement $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'name'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'environnements_datatable_' . time();
    }
}
