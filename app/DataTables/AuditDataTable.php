<?php

namespace App\DataTables;

use App\Models\Audit;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Facades\Lang;
use \Yajra\DataTables\Html\Column;
class AuditDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix
     */
    public function __construct()
    {
        $this->permissionPrefix = "audit";
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'audits.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Audit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Audit $model)
    {
        return $model->newQuery();
    }

    /**
     * @override
     */
    protected function getHtmlButtons() : array
    {
        return [
            'dom' => [
                'button' => [
                    'tag' => 'button',
                    'className' => ''
                ]
            ],
            'buttons' => [
                ['extend' => 'export', 'className' => 'btn btn-secondary btn-sm no-corner',],
                ['extend' => 'print', 'className' => 'btn btn-secondary btn-sm no-corner',],
                ['extend' => 'reset', 'className' => 'btn btn-secondary btn-sm no-corner',],
                ['extend' => 'reload', 'className' => 'btn btn-secondary btn-sm no-corner',],
            ]
        ];
    }



    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            //'user_type',
            'user_id' =>  new Column([
                'title' => Lang::get('audit.user_id'),
                'data'  => 'user_id',
                'name'  => 'user_id',
            ]),
            'auditable_id' => new Column([
                'title' => Lang::get('audit.auditable_id'),
                'data'  => 'auditable_id',
                'name'  => 'auditable_id',
            ]),
            'auditable_type'=> new Column([
                'title' => Lang::get('audit.auditable_type'),
                'data'  => 'auditable_type',
                'name'  => 'auditable_type',
            ]),
            'event'=> new Column([
                'title' => Lang::get('audit.event'),
                'data'  => 'event',
                'name'  => 'event',
            ]),
            'old_values'=> new Column([
                'title' => Lang::get('audit.old_values'),
                'data'  => 'old_values',
                'name'  => 'old_values',
            ]),
            'new_values'=> new Column([
                'title' => Lang::get('audit.new_values'),
                'data'  => 'new_values',
                'name'  => 'new_values',
            ]),
            'created_at'=> new Column([
                'title' => Lang::get('common.field_created_at'),
                'data'  => 'created_at',
                'name'  => 'created_at',
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
        return 'audits_datatable_' . time();
    }
}
