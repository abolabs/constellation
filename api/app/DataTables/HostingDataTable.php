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

use App\Models\Hosting;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class HostingDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'hosting';
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

        return $dataTable->addColumn('action', 'hostings.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Hosting $model)
    {
        return $model->newQuery()->with(['hostingType'])->select(['hosting.*']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'hosting_id' => new Column([
                'title' => Lang::get('hosting.id'),
                'data' => 'id',
                'name' => 'hosting.id',
            ]),
            'name' => new Column([
                'title' => Lang::get('hosting.name'),
                'data' => 'name',
                'name' => 'name',
            ]),
            'hosting_type' => new Column([
                'title' => 'Hosting Type',
                'data' => 'hosting_type.name',
                'name' => 'hostingType.name',
            ]),
            'localisation' => new Column([
                'title' => Lang::get('hosting.localisation'),
                'data' => 'localisation',
                'name' => 'hosting.localisation',
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
        return 'hostings_datatable_'.time();
    }
}
