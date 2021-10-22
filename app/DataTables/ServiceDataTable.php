<?php

namespace App\DataTables;

use App\Models\Service;
use Yajra\DataTables\EloquentDataTable;

class ServiceDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'services.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Service $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Service $model)
    {
        return $model->newQuery()->with(['team'])->select(['service.*']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'service_id' =>  new \Yajra\DataTables\Html\Column([
                'title' => 'Id',
                'data'  => 'id',
                'name'  => 'service.id',
            ]),
            'name',
            'git_repo',
            'team' =>  new \Yajra\DataTables\Html\Column([
                'title' => 'Team',
                'data'  => 'team.name',
                'name'  => 'team.name',
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
        return 'services_datatable_' . time();
    }
}
