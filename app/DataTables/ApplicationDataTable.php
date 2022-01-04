<?php

namespace App\DataTables;

use App\Models\Application;
use Lang;
use Yajra\DataTables\EloquentDataTable;

class ApplicationDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'application';
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

        return $dataTable->addColumn('action', 'applications.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Application  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Application $model)
    {
        return $model->newQuery()->with(['team'])->select(['application.*']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'application' =>  new \Yajra\DataTables\Html\Column([
                'title' => Lang::get('application.id'),
                'data'  => 'id',
                'name'  => 'application.id',
            ]),
            'name' =>  new \Yajra\DataTables\Html\Column([
                'title' => Lang::get('application.name'),
                'data'  => 'name',
                'name'  => 'application.name',
            ]),
            'team_name' =>  new \Yajra\DataTables\Html\Column([
                'title' => Lang::get('application.team'),
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
        return 'applications_datatable_' . time();
    }
}
