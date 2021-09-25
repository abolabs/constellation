<?php

namespace App\DataTables;

use App\Models\Hosting;
use Yajra\DataTables\EloquentDataTable;

class HostingDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'hostings.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Hosting $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Hosting $model)
    {
        return $model->newQuery()->with(['hostingType']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'hosting_id' =>  new \Yajra\DataTables\Html\Column([
                'title' => 'Id',
                'data'  => 'id',
                'name'  => 'hosting.id',
            ]),
            'name',
            'hosting_type' => new \Yajra\DataTables\Html\Column([
                'title' => 'Hosting Type',
                'data'  => 'hosting_type.name',
                'name'  => 'hostingType.name',
            ]),
            'localisation'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'hostings_datatable_' . time();
    }
}
