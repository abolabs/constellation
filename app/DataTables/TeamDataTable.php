<?php

namespace App\DataTables;

use App\Models\Team;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Facades\Lang;
use \Yajra\DataTables\Html\Column;

class TeamDataTable extends AbstractCommonDatatable
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

        return $dataTable->addColumn('action', 'teams.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Team $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Team $model)
    {
        return $model->newQuery();
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
                'data'  => 'id',
                'name'  => 'id',
            ]),
            'name' => new Column([
                'title' => Lang::get('infra.name'),
                'data'  => 'name',
                'name'  => 'name',
            ]),
            'manager' => new Column([
                'title' => Lang::get('infra.manager'),
                'data'  => 'manager',
                'name'  => 'manager',
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
        return 'teams_datatable_' . time();
    }
}
