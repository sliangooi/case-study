<?php

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exist = User::where('email','superadmin@company.com')->first();

        if(empty($exist)){
            $user = User::create([
                'name' => 'Superadmin',
                'email' => 'superadmin@company.com',
                'password' => Hash::make('admin123456'),
                'email_verified_at' => Carbon::now(),
            ]);
            $user->assignRole(Role::SUPERADMIN);
        }
    }
}
