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

use App\Models\ServiceVersion;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ServiceVersionDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'serviceVersion';
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

        return $dataTable->addColumn('action', 'service_versions.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\ServiceVersion  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceVersion $model)
    {
        return $model->newQuery()->with(['service']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'service_version_id' =>  new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'id',
                'name'  => 'service_version.id',
            ]),
            'service' => new Column([
                'title' => Lang::get('infra.service'),
                'data'  => 'service.name',
                'name'  => 'service.name',
            ]),
            'version' => new Column([
                'title' => Lang::get('infra.version'),
                'data'  => 'version',
                'name'  => 'service_version.version',
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
        return 'service_versions_datatable_' . time();
    }
}
