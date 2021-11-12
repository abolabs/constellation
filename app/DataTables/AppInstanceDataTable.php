<?php

namespace App\DataTables;

use App\Models\AppInstance;
use Yajra\DataTables\EloquentDataTable;

class AppInstanceDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'app_instances.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AppInstance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AppInstance $model)
    {
        return $model->newQuery()
                ->with(['serviceVersion','serviceVersion.service','environnement','application','hosting'])
                ->select(['app_instance.*']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'app_instance_id' =>  new \Yajra\DataTables\Html\Column([
                'title' => 'Id',
                'data'  => 'id',
                'name'  => 'app_instance.id'
            ]),
            'application_name' => new \Yajra\DataTables\Html\Column([
                'title' => 'Application',
                'data'  => 'application.name',
                'name'  => 'application.name',
            ]),
            'service_name' => new \Yajra\DataTables\Html\Column([
                'title' => 'Service name',
                'data'  => 'service_version.service.name',
                'name'  => 'serviceVersion.service.name',
            ]),
            'service_version' => new \Yajra\DataTables\Html\Column([
                'title' => 'Service version',
                'data'  => 'service_version.version',
                'name'  => 'serviceVersion.version',
            ]),
            'environnement_name' => new \Yajra\DataTables\Html\Column([
                'title' => 'Environnement',
                'data'  => 'environnement.name',
                'name'  => 'environnement.name',
            ]),
            'hosting_name' => new \Yajra\DataTables\Html\Column([
                'title' => 'Hosting',
                'data'  => 'hosting.name',
                'name'  => 'hosting.name',
            ]),
            'url',
            'statut' => new \Yajra\DataTables\Html\Column([
                'title' => 'Statut',
                'data'  => 'statut',
                'name'  => 'app_instance.statut',
                'render' => 'window.DataTableRenderer.boolean("statut")'
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
        return 'app_instances_datatable_' . time();
    }
}
