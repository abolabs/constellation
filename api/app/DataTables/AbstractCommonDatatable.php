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

use Yajra\DataTables\Services\DataTable;

abstract class AbstractCommonDatatable extends DataTable
{
    public const DEFAULT_CLASSNAME = 'btn btn-sm no-corner';

    protected $permissionPrefix = '';

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom' => 'Bfrtip',
                'responsive' => true,
                'colReorder' => true,
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'buttons' => $this->getHtmlButtons(),
                'language' => [
                    'processing' => '<div class="lds-dual-ring"></div>',
                    'search' => '_INPUT_',            // Removes the 'Search' field label
                    'searchPlaceholder' => \Lang::get('datatable.search'),  // Placeholder for the search box
                ],
                'initComplete' => '
                    function () {
                        const maxCols = this.api().columns()[0].length;
                        let nbCol = 0;
                        this.api().columns().every(function () {
                            nbCol++;
                            if(maxCols == nbCol){
                                return ;
                            }
                            var column = this;
                            var input = document.createElement("input");
                            $(input).addClass("form-control");
                            $(input).appendTo($(column.footer()).empty())
                            .on("change", function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        });
                    }
                ',
            ]);
    }

    /**
     * Return the html buttons options.
     */
    protected function getHtmlButtons(): array
    {
        $buttons = [];
        if (auth()->user()->can('create '.$this->permissionPrefix)) {
            $buttons[] = ['extend' => 'create', 'className' => self::DEFAULT_CLASSNAME, 'text' => '<i class="fa fa-plus"></i> '.\Lang::get('datatable.create')];
        }
        $buttons[] = ['extend' => 'excel', 'className' => self::DEFAULT_CLASSNAME, 'text' => '<i class="fa fa-file-excel-o"></i> '.\Lang::get('datatable.excel')];
        $buttons[] = ['extend' => 'print', 'className' => self::DEFAULT_CLASSNAME, 'text' => '<i class="fa fa-print"></i> '.\Lang::get('datatable.print')];
        $buttons[] = ['extend' => 'reset', 'className' => self::DEFAULT_CLASSNAME, 'text' => '<i class="fa fa-undo"></i> '.\Lang::get('datatable.reset')];
        $buttons[] = ['extend' => 'reload', 'className' => self::DEFAULT_CLASSNAME, 'text' => '<i class="fa fa-refresh"></i> '.\Lang::get('datatable.reload')];

        return [
            'dom' => [
                'button' => [
                    'tag' => 'button',
                    'className' => '',
                ],
            ],
            'buttons' => $buttons,
        ];
    }
}
