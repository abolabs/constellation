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

use App\Models\ServiceVersionDependencies;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ServiceVersionDependenciesDataTable extends AbstractCommonDatatable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'service_version_dependencies.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\ServiceVersionDependencies  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceVersionDependencies $model)
    {
        return $model->newQuery()->with(['serviceVersion.service', 'serviceVersionDep.service'])->select(['service_version_dependencies.*']);
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
                'data'  => 'service_version.id',
                'name'  => 'serviceVersion.id',
            ]),
            'service_version_name' => new Column([
                'title' => '# ' . Lang::get('infra.service'),
                'data'  => 'service_version.service.name',
                'name'  => 'serviceVersion.service.name',
            ]),
            'service_version' => new Column([
                'title' => Lang::get('infra.service'),
                'data'  => 'service_version.version',
                'name'  => 'serviceVersion.version',
            ]),
            'service_version_dependency_id' => new Column([
                'title' => '# ' . Lang::get('infra.service_dependency'),
                'data'  => 'service_version_dep.service.name',
                'name'  => 'serviceVersionDep.service.name',
            ]),
            'service_version_dependency' => new Column([
                'title' => Lang::get('infra.service_dependency'),
                'data'  => 'service_version_dep.version',
                'name'  => 'serviceVersionDep.version',
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
        return 'service_version_dependencies_datatable_' . time();
    }
}
