<?php

namespace App\DataTables;

use App\Models\ServiceInstanceDependencies;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ServiceInstanceDependenciesDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'service_instance_dependencies.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ServiceInstanceDependencies $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceInstanceDependencies $model)
    {
        return $model->newQuery()
                ->with(['ServiceInstance','ServiceInstanceDep','ServiceInstance.serviceVersion.service','ServiceInstanceDep.serviceVersion.service'])
                ->select(['service_instance_dep.*']);
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
            'instance_id',
            'service_name' => new \Yajra\DataTables\Html\Column([
                'title' => 'Service Name',
                'data'  => 'service_instance.service_version.service.name',
                'name'  => 'ServiceInstance.serviceVersion.service.name',
            ]),
            'instance_dep_id',
            'dep_service_name' => new \Yajra\DataTables\Html\Column([
                'title' => 'Dependency Service Name',
                'data'  => 'service_instance_dep.service_version.service.name',
                'name'  => 'ServiceInstanceDep.serviceVersion.service.name',
            ]),
            'level',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'service_instance_dependencies_datatable_' . time();
    }
}
