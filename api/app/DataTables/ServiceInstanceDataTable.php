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

use App\Models\ServiceInstance;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ServiceInstanceDataTable extends AbstractCommonDatatable
{
    /**
     * Constructor
     * Define permission prefix.
     */
    public function __construct()
    {
        $this->permissionPrefix = 'serviceInstance';
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

        return $dataTable->addColumn('action', 'service_instances.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\ServiceInstance  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceInstance $model)
    {
        return $model->newQuery()
                ->with(['serviceVersion', 'serviceVersion.service', 'environnement', 'application', 'hosting'])
                ->select(['service_instance.*']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'service_instance_id' =>  new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'id',
                'name'  => 'service_instance.id',
            ]),
            'application_name' => new Column([
                'title' => Lang::get('infra.application'),
                'data'  => 'application.name',
                'name'  => 'application.name',
            ]),
            'service_name' => new Column([
                'title' => Lang::get('infra.service_version'),
                'data'  => 'service_version.service.name',
                'name'  => 'serviceVersion.service.name',
            ]),
            'service_version' => new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'service_version.version',
                'name'  => 'serviceVersion.version',
            ]),
            'environnement_name' => new Column([
                'title' => Lang::get('infra.hosting'),
                'data'  => 'environnement.name',
                'name'  => 'environnement.name',
            ]),
            'hosting_name' => new Column([
                'title' => Lang::get('infra.id'),
                'data'  => 'hosting.name',
                'name'  => 'hosting.name',
            ]),
            'url' =>  new Column([
                'title' => Lang::get('infra.url'),
                'data'  => 'url',
                'name'  => 'service_instance.url',
            ]),
            'role' =>  new Column([
                'title' => Lang::get('infra.role'),
                'data'  => 'role',
                'name'  => 'service_instance.role',
            ]),
            'statut' => new Column([
                'title' => Lang::get('infra.status'),
                'data'  => 'statut',
                'name'  => 'service_instance.statut',
                'render' => 'window.DataTableRenderer.boolean("statut")',
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
        return 'service_instances_datatable_' . time();
    }
}
