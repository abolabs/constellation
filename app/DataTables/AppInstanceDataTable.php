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
        return $model->query()
        ->select([
            'app_instance.id as id',
            'app_instance.url as url',
            'app_instance.statut as statut',
            'application.name as application',
            'service_version.version as service_version',
            'environnement.name as environnement'
        ])
        ->leftJoin('application','app_instance.application_id','=','application.id')
        ->leftJoin('service_version','app_instance.service_version_id','=','service_version.id')
        ->leftJoin('environnement','app_instance.environnement_id','=','environnement.id');
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
            'application',
            'service_version',
            'environnement',
            'url',
            'statut'
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
