<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth']], function () {
    Route::redirect('/', '/login');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('users', 'UserController');
    Route::get('/address-render', 'UserController@addressRender')->name('address-render');

    Route::resource('roles', 'RoleController');
    Route::get('roles/{role}/permissions', 'RoleController@getPermissions')->name('roles.get-permissions');
    Route::put('roles/{role}/permissions', 'RoleController@updatePermissions')->name('roles.update-permissions');
});
Auth::routes(['verify' => true]);



