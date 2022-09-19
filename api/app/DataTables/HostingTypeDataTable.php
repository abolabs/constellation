<?php

namespace App\DataTables;

use App\Models\HostingType;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class HostingTypeDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'hostingType';
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

        return $dataTable->addColumn('action', 'hosting_types.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\HostingType  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(HostingType $model)
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
            'id' =>  new Column([
                'title' => Lang::get('hosting_type.id'),
                'data'  => 'id',
                'name'  => 'id',
            ]),
            'name' =>  new Column([
                'title' => Lang::get('hosting_type.name'),
                'data'  => 'name',
                'name'  => 'name',
            ]),
            'description' =>  new Column([
                'title' => Lang::get('hosting_type.description'),
                'data'  => 'description',
                'name'  => 'description',
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
        return 'hosting_types_datatable_' . time();
    }
}
