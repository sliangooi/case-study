<?php

namespace App\DataTables;

use App\Role;
use App\User;
use App\Helpers\DNA;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
        $query = $query->notSuperadmin()->orderBy('name','asc');

        if($request->get('search_status') && $request->search_status == DNA::STRING_DELETED){
            $query->whereNotNull('deleted_at')->withTrashed();
        }
        if($request->get('search_name')){
            $query->where('name', 'LIKE', "%$request->search_name%");
        }
        if($request->get('search_address')){
            $query->whereHas('addresses',function ($subquery) use ($request){
                return $subquery->where('full_address', 'LIKE', "%$request->search_address%");
            });
        }

        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('role', function ($data) {
                $string = '';
                foreach($data->roles as $role){
                    $string .= $role->display_name. ' ';
                }
                return $string;
            })
            ->addColumn('email_verified_at', function ($data){
                $class = 'warning';
                $text = 'No Verify';

                if($data->email_verified_at){
                    $class = 'success';
                    $text = 'Verified';
                }
                return view('components.badge', [
                    'class' => $class,
                    'text' => $text,
                ])->render();
            })
            ->addColumn('action', function ($data) {
                if(empty($data->deleted_at)){
                    return view('components.action', [
                        'update' => [
                            'route' => route('users.edit', ['user' => $data->id]),
                            'permission' => 'users-edit'
                        ],
                        'delete_modal' => [
                            'href' => route('users.destroy', ['user' => $data->id]),
                            'class' => 'delete_modal',
                            'target' => 'user-delete-modal',
                            'permission' => 'users-delete'
                        ]
                    ])->render();
                }
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->toDateTimeString();
            })
            ->rawColumns(['action','email_verified_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('user-table')
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
            Column::make('name')->title('Name'),
            Column::make('role')->title('Role'),
            Column::make('email')->title('Email Address'),
            Column::make('email_verified_at')->title('Email Verification'),
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
        return 'User_' . date('YmdHis');
    }
}
