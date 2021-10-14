<?php

namespace App\DataTables;

use App\Models\Audit;
use Yajra\DataTables\EloquentDataTable;

class AuditDataTable extends AbstractCommonDatatable
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
            'user_id',
            'event',
            'auditable_type',
            'auditable_id',
            'old_values',
            'new_values',
            //'url',
            'ip_address',
            //'user_agent',
            //'tags'
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
