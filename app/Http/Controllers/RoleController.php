<?php

namespace App\Http\Controllers;

use App\Role;
use App\Module;
use App\Helpers\DNA;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\RoleDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct()
    {
        $this->middleware(['permission:roles-index'])->only(['index']);
        $this->middleware(['permission:roles-add'])->only(['store']);
        $this->middleware(['permission:roles-edit'])->only(['edit','update']);

    }

    public function index(RoleDataTable $dataTable)
    {
        $title = 'Role';
        return $dataTable->render('role.index',['title' => $title]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $name = Str::slug($request->get('name'));

        do {
            $count = Role::where('name', $name)->count();
            if ($count > 0) {
                $name .= "-" . ($count++);
            }else{
                break;
            }
        } while ($count > 0);


        $role = new Role();
        $role->name = $name;
        $role->display_name = $request->get('name');
        $role->description = $request->get('description') ?? '';
        $role->save();
        return redirect()->route('roles.index')->with('success', 'Successfuly Created');

    }

    public function show(Role $role)
    {
        return response()->json($role);
    }

    public function edit(Role $role)
    {
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $role->display_name = $request->get('display_name');
        $role->description = $request->get('description') ?? '';
        $role->save();
        return redirect()->route('roles.index')->with('success', 'Successfuly Updated');

    }

    public function destroy(Role $role)
    {

    }

    public function getPermissions(Role $role)
    {
        $title = 'Permission';
        $modules = Module::all();
        $checked_permissions = [];
        foreach ($modules as $module){
            $not_crud_array = [];

            foreach($module->permissions as $permission){
                if(!in_array($permission->action,array_keys(DNA::getActionList()))){
                    $not_crud_array[] = $permission;
                }
            }
            $module['not_crud'] = $not_crud_array;
        }

        foreach($role->permissions as $permission){
            $checked_permissions[] = $permission->id;
        }

        return view('role.permission',compact('title','modules','role','checked_permissions'));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->get('permissions'));
        return redirect()->route('roles.index')->with('success', 'Successfuly Updated');
    }
}
