<?php

namespace App\DataTables;

use App\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->notSuperadmin()->orderBy('name','asc');
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return view('components.action', [
                    'view_modal' => [
                        'href' => route('roles.show', ['role' => $data->id]),
                        'class' => 'view_modal',
                        'target' => 'role-view-modal',
                        'permission' => 'roles-index'
                    ],
                    'edit_modal' => [
                        'href' => route('roles.edit', ['role' => $data->id]),
                        'class' => 'edit_modal',
                        'target' => 'role-edit-modal',
                        'permission' => 'roles-edit'
                    ],
                    'permission' => [
                        'route' => route('roles.get-permissions', ['role' => $data->id]),
                        'permission' => 'roles-edit'
                    ],
                ])->render();
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->toDateTimeString();
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('role-table')
                    ->addTableClass('table-hover table-bordered table-head-fixed table-striped')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->responsive(true)
                    ->autoWidth(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', '#'),
            Column::make('display_name')->title('Name'),
            Column::make('description')->title('Description'),
            Column::make('created_at')->title('Created At'),
            Column::computed('action', 'Action'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Role_' . date('YmdHis');
    }
}
