<?php

namespace App\DataTables;

use App\Models\HostingType;
use Yajra\DataTables\EloquentDataTable;

class HostingTypeDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'hosting_types.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\HostingType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(HostingType $model)
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
            'name',
            'description'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'hosting_types_datatable_' . time();
    }
}
