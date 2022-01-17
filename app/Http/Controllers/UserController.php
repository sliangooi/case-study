<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Address;
use App\Helpers\DNA;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:users-index'])->only(['index','show']);
        $this->middleware(['permission:users-add'])->only(['create','store']);
        $this->middleware(['permission:users-edit'])->only(['edit','update']);
        $this->middleware(['permission:users-delete'])->only(['destory']);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(UserDataTable $dataTable)
    {
        $title = 'User';
        return $dataTable->render('user.index',['title' => $title]);
    }

    public function create()
    {
        $title = 'Create User';
        $route = route('users.store');
        $roles = Role::notSuperadmin()->get();
        $user = new User();

        return view('user.modify',compact('route','title','user','roles'));
    }

    public function store(UserRequest $request)
    {

        DB::beginTransaction();
        try{
            $fields = $request->validated();
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
            ]);
    
            $user->save();
            $user->syncRoles($fields['role']);

            if (isset($fields['addresses'])) {
                foreach ($fields['addresses'] as $address) {
                    $state = '';
                    $country = '';

                    foreach(DNA::getStateList() as $key => $value){
                        if($key == $address['state']){
                            $state = $value;
                        }
                    }

                    foreach(DNA::getCountryList() as $key => $value){
                        if($key == $address['country']){
                            $country = $value;
                        }
                    }
                    $full_address = $address['address'].', '.$address['postcode'].', '.$state.', '.$country;

                    $new_address = new Address;
                    $new_address->user_id = $user->id;
                    $new_address->full_address = $full_address;
                    $new_address->address = $address['address'];
                    $new_address->postcode = $address['postcode'];
                    $new_address->state = $address['state'];
                    $new_address->country = $address['country'];
                    $new_address->save();
                }
            }

            event(new Registered($user));
            $status = 'success';
            $msg = 'Successfully Created';
            DB::commit();

        }catch(\Exception | \Error $e){
            DB::rollback();
            $status = 'error';
            $msg = 'Create Failed';
        }
        return redirect()->route('users.index')->with($status, $msg);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function edit(User $user)
    {

        $title = 'Edit User';
        $route = route('users.update',$user);
        $roles = Role::notSuperadmin()->get();

        return view('user.modify',compact('route','title','user','roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        DB::beginTransaction();
        try{
            $fields = $request->validated();
            $user->name = $fields['name'];
            $user->email = $fields['email'];
            $user->save();
            $user->syncRoles($fields['role']);

            $user->addresses()->delete();
            if (isset($fields['addresses'])) {
                foreach ($fields['addresses'] as $address) {
                    $state = '';
                    $country = '';

                    foreach(DNA::getStateList() as $key => $value){
                        if($key == $address['state']){
                            $state = $value;
                        }
                    }

                    foreach(DNA::getCountryList() as $key => $value){
                        if($key == $address['country']){
                            $country = $value;
                        }
                    }
                    $full_address = $address['address'].', '.$address['postcode'].', '.$state.', '.$country;

                    $new_address = new Address;
                    $new_address->user_id = $user->id;
                    $new_address->full_address = $full_address;
                    $new_address->address = $address['address'];
                    $new_address->postcode = $address['postcode'];
                    $new_address->state = $address['state'];
                    $new_address->country = $address['country'];
                    $new_address->save();
                }
            }


            $status = 'success';
            $msg = 'Successfully Updated';
            DB::commit();

        }catch(\Exception | \Error $e){
            DB::rollback();
            $status = 'error';
            $msg = 'Update Failed';
        }
        return redirect()->route('users.index')->with($status, $msg);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User is successfully delete.');
    }

    public function addressRender()
    {
        $unique = uniqid();
        return view('components.user.address-render',compact('unique'))->render();
    }

}
