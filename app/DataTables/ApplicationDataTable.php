<?php

namespace App\DataTables;

use App\Models\Application;
use Yajra\DataTables\EloquentDataTable;

class ApplicationDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'applications.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Application $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Application $model)
    {
        return $model->newQuery()->with(['team:id,name as team_name']);
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
                'title' => 'Id',
                'data'  => 'id',
                'name'  => 'application.id',
            ]),
            'name',
            'team_name' =>  new \Yajra\DataTables\Html\Column([
                'title' => 'Team',
                'data'  => 'team.team_name',
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
