<?php

namespace App\DataTables;

use App\Models\Service;
use App\Models\ServiceVersion;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ServiceVersionDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'service_versions.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ServiceVersion $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceVersion $model)
    {
        return $model->newQuery()->with(['service']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'service_version_id' =>  new \Yajra\DataTables\Html\Column([
                'title' => 'Id',
                'data'  => 'id',
                'name'  => 'service_version.id',
            ]),
            'service' => new \Yajra\DataTables\Html\Column([
                'title' => 'Service',
                'data'  => 'service.name',
                'name'  => 'service.name',
            ]),
            'version'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'service_versions_datatable_' . time();
    }
}
