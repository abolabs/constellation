<?php

namespace App\DataTables;

use App\Models\ServiceInstanceDependencies;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Facades\Lang;
use \Yajra\DataTables\Html\Column;

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
            'id'=>  new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'id',
                'name'  => 'id',
            ]),
            'instance_id'=>  new Column([
                'title' => "# ".Lang::get('infra.service_instance'),
                'data'  => 'instance_id',
                'name'  => 'instance_id',
            ]),
            'service_name' => new Column([
                'title' => Lang::get('infra.service_instance'),
                'data'  => 'service_instance.service_version.service.name',
                'name'  => 'ServiceInstance.serviceVersion.service.name',
            ]),
            'instance_dep_id'=>  new Column([
                'title' => "# ". Lang::get('infra.service_dependency'),
                'data'  => 'instance_dep_id',
                'name'  => 'instance_dep_id',
            ]),
            'dep_service_name' => new Column([
                'title' => Lang::get('infra.service_dependency'),
                'data'  => 'service_instance_dep.service_version.service.name',
                'name'  => 'ServiceInstanceDep.serviceVersion.service.name',
            ]),
            'level'=>  new Column([
                'title' => Lang::get('infra.dependency_level'),
                'data'  => 'level',
                'name'  => 'level',
                'render' => 'window.DataTableRenderer.level("level")'
            ]),
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
