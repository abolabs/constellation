<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;

abstract class AbstractCommonDatatable extends DataTable
{
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
                'dom'       => 'Bfrtip',
                'responsive'=> true,
                'colReorder' => true,
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => $this->getHtmlButtons(),
                'language'  =>  [
                    'processing' => '<div class="lds-dual-ring"></div>',
                    'search'=> '_INPUT_',            // Removes the 'Search' field label
                    'searchPlaceholder'=> \Lang::get('datatable.search'),  // Placeholder for the search box
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
     *
     * @return array
     */
    protected function getHtmlButtons(): array
    {
        $buttons = [];
        if (auth()->user()->can('create '.$this->permissionPrefix)) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-sm no-corner', 'text'=> '<i class="fa fa-plus"></i> '.\Lang::get('datatable.create')];
        }
        $buttons[] = ['extend' => 'excel', 'className' => 'btn btn-sm no-corner', 'text'=> '<i class="fa fa-file-excel-o"></i> '.\Lang::get('datatable.excel')];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-sm no-corner', 'text'=> '<i class="fa fa-print"></i> '.\Lang::get('datatable.print')];
        $buttons[] = ['extend' => 'reset', 'className' => 'btn btn-sm no-corner', 'text'=> '<i class="fa fa-undo"></i> '.\Lang::get('datatable.reset')];
        $buttons[] = ['extend' => 'reload', 'className' => 'btn btn-sm no-corner', 'text'=> '<i class="fa fa-refresh"></i> '.\Lang::get('datatable.reload')];

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
