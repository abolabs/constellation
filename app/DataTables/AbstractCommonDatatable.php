<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;

abstract class AbstractCommonDatatable extends DataTable
{
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
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => $this->getHtmlButtons(),
                'initComplete' => '
                    function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var input = document.createElement("input");
                            $(input).appendTo($(column.footer()).empty())
                            .on("change", function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        });
                    }
                '
            ]);
    }

    /**
     * Return the html buttons options
     * @return array
     */
    protected function getHtmlButtons() : array
    {
        return [
            ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
            ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
            ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
            ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
            ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
        ];
    }
}
