<?php

use App\User;
use App\Role;
use App\Module;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::where('name', Role::SUPERADMIN)->first();

        $permission_with_modules = json_decode(file_get_contents(storage_path('app/json/module.json')), true);
        foreach ($permission_with_modules as $key => $module) {
            if (empty($module['name'])) {
                continue;
            }

            $new_module = Module::where('name',$module['name'])->first();
            if(empty($new_module)){
                $new_module = new Module();
            }
            $new_module->name = $module['name'];
            $new_module->display_name = $module['display_name'];
            $new_module->status = $module['status'];
            $new_module->save();

            foreach ($module['permissions'] as $permission) {

                $action = $permission['name'];
                $name = $new_module->name.'-'.$permission['name'];
                $display_name = $new_module->display_name.' - '.ucwords($action);

                $new_permission = Permission::where('name',$name)->first();
                if(empty($new_permission)){
                    $new_permission = new Permission();
                }
                $new_permission->module_id = $new_module->id;
                $new_permission->action = $action;
                $new_permission->name = $name;
                $new_permission->display_name = $display_name;
                $new_permission->guard_name = config(User::GUARD);
                $new_permission->save();

                $superadmin->givePermissionTo($new_permission);
            }
        }
    }
}
