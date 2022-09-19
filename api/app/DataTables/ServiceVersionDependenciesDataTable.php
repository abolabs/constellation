<?php

namespace App\DataTables;

use App\Models\ServiceVersionDependencies;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ServiceVersionDependenciesDataTable extends AbstractCommonDatatable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
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
     * @param  \App\Models\ServiceVersionDependencies  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceVersionDependencies $model)
    {
        return $model->newQuery()->with(['serviceVersion.service', 'serviceVersionDep.service'])->select(['service_version_dependencies.*']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'service_version.id',
                'name'  => 'serviceVersion.id',
            ]),
            'service_version_name' => new Column([
                'title' => '# ' . Lang::get('infra.service'),
                'data'  => 'service_version.service.name',
                'name'  => 'serviceVersion.service.name',
            ]),
            'service_version' => new Column([
                'title' => Lang::get('infra.service'),
                'data'  => 'service_version.version',
                'name'  => 'serviceVersion.version',
            ]),
            'service_version_dependency_id' => new Column([
                'title' => '# ' . Lang::get('infra.service_dependency'),
                'data'  => 'service_version_dep.service.name',
                'name'  => 'serviceVersionDep.service.name',
            ]),
            'service_version_dependency' => new Column([
                'title' => Lang::get('infra.service_dependency'),
                'data'  => 'service_version_dep.version',
                'name'  => 'serviceVersionDep.version',
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
