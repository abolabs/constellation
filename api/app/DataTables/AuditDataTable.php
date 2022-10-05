<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\DataTables;

use App\Models\Audit;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class AuditDataTable extends AbstractCommonDatatable
{
    public const DEFAULT_CLASSNAME = 'btn btn-sm no-corner';

    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'audit';
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

        return $dataTable->addColumn('action', 'audits.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Audit  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Audit $model)
    {
        return $model->newQuery();
    }

    /**
     * @override
     */
    protected function getHtmlButtons(): array
    {
        return [
            'dom' => [
                'button' => [
                    'tag' => 'button',
                    'className' => '',
                ],
            ],
            'buttons' => [
                ['extend' => 'export', 'className' => self::DEFAULT_CLASSNAME],
                ['extend' => 'print', 'className' => self::DEFAULT_CLASSNAME],
                ['extend' => 'reset', 'className' => self::DEFAULT_CLASSNAME],
                ['extend' => 'reload', 'className' => self::DEFAULT_CLASSNAME],
            ],
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
            'auditable_type' => new Column([
                'title' => Lang::get('audit.auditable_type'),
                'data'  => 'auditable_type',
                'name'  => 'auditable_type',
            ]),
            'event' => new Column([
                'title' => Lang::get('audit.event'),
                'data'  => 'event',
                'name'  => 'event',
            ]),
            'old_values' => new Column([
                'title' => Lang::get('audit.old_values'),
                'data'  => 'old_values',
                'name'  => 'old_values',
            ]),
            'new_values' => new Column([
                'title' => Lang::get('audit.new_values'),
                'data'  => 'new_values',
                'name'  => 'new_values',
            ]),
            'created_at' => new Column([
                'title' => Lang::get('common.field_created_at'),
                'data'  => 'created_at',
                'name'  => 'created_at',
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
        return 'audits_datatable_' . time();
    }
}
