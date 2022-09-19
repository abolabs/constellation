<?php

namespace App\DataTables;

use App\Models\Service;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ServiceDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'service';
    }

    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
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
     * @param  \App\Models\Service  $model
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
            'service_id' =>  new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'id',
                'name'  => 'service.id',
            ]),
            'name' =>  new Column([
                'title' => Lang::get('infra.name'),
                'data'  => 'name',
                'name'  => 'service.name',
            ]),
            'git_repo' =>  new Column([
                'title' => Lang::get('infra.git_repo'),
                'data'  => 'git_repo',
                'name'  => 'service.git_repo',
            ]),
            'team' =>  new Column([
                'title' => Lang::get('infra.team'),
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
