<?php

namespace App\DataTables;

use App\Models\ServiceVersionDependencies;
use Yajra\DataTables\EloquentDataTable;

class ServiceVersionDependenciesDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'service_version_dependencies.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ServiceVersionDependencies $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceVersionDependencies $model)
    {
        return $model->newQuery()->with(['serviceVersion.service','serviceVersionDep.service'])->select(['service_version_dependencies.*']);
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
            'service_version_id',
            'service_version' => new \Yajra\DataTables\Html\Column([
                'title' => 'Service',
                'data'  => 'service_version.service.name',
                'name'  => 'serviceVersion.service.name',
            ]),
            'service_version_dependency_id',
            'service_version_dependency' => new \Yajra\DataTables\Html\Column([
                'title' => 'Dépendance',
                'data'  => 'service_version_dep.service.name',
                'name'  => 'serviceVersionDep.service.name',
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
        return 'service_version_dependencies_datatable_' . time();
    }
}
