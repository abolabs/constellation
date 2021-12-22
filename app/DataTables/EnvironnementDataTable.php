<?php

namespace App\DataTables;

use App\Models\Environnement;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class EnvironnementDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'environnement';
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

        return $dataTable->addColumn('action', 'environnements.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Environnement  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Environnement $model)
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
                'title' => Lang::get('environnement.id'),
                'data'  => 'id',
                'name'  => 'id',
            ]),
            'name' => new Column([
                'title' => Lang::get('environnement.name'),
                'data'  => 'name',
                'name'  => 'name',
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
        return 'environnements_datatable_'.time();
    }
}
