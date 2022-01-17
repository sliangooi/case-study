<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::where('name',Role::SUPERADMIN)->first();
        $admin = Role::where('name',Role::ADMIN)->first();
        $employee = Role::where('name',Role::EMPLOYEE)->first();

        if(empty($superadmin)){
            Role::create([
                'name' => Role::SUPERADMIN,
                'display_name' => 'Super Admin',
                'description' => 'Superadmin role description',
                'guard_name' => config(User::GUARD),
            ]);
        }
        if(empty($admin)){
            Role::create([
                'name' => Role::ADMIN,
                'display_name' => 'Admin',
                'description' => 'Admin role description',
                'guard_name' => config(User::GUARD),
            ]);
        }
        if(empty($employee)){
            Role::create([
                'name' => Role::EMPLOYEE,
                'display_name' => 'Employee',
                'description' => 'Employee role description',
                'guard_name' => config(User::GUARD),
            ]);
        }
    }
}
