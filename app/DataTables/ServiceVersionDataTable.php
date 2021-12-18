<?php

namespace App\DataTables;

use App\Models\ServiceVersion;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Facades\Lang;
use \Yajra\DataTables\Html\Column;

class ServiceVersionDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix
     */
    public function __construct()
    {
        $this->permissionPrefix = "serviceVersion";
    }
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
            'service_version_id' =>  new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'id',
                'name'  => 'service_version.id',
            ]),
            'service' => new Column([
                'title' => Lang::get('infra.service'),
                'data'  => 'service.name',
                'name'  => 'service.name',
            ]),
            'version' => new Column([
                'title' => Lang::get('infra.version'),
                'data'  => 'version',
                'name'  => 'service_version.version',
            ])
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
