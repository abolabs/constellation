<?php

namespace App\DataTables;

use App\Models\AppInstanceDependencies;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AppInstanceDependenciesDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'app_instance_dependencies.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AppInstanceDependencies $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AppInstanceDependencies $model)
    {
        return $model->newQuery()->with(['appInstance','appInstanceDep','appInstance.serviceVersion.service','appInstanceDep.serviceVersion.service'])->select(['app_instance_dep.*']);
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
                'data'  => 'app_instance.service_version.service.name',
                'name'  => 'appInstance.serviceVersion.service.name',
            ]),
            'instance_dep_id',
            'dep_service_name' => new \Yajra\DataTables\Html\Column([
                'title' => 'Dependency Service Name',
                'data'  => 'app_instance_dep.service_version.service.name',
                'name'  => 'appInstanceDep.serviceVersion.service.name',
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
        return 'app_instance_dependencies_datatable_' . time();
    }
}
