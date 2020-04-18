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

// Route::view('/', 'layouts.app');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {

    //roles route
    Route::get('/fetch/roles', "RolePermissionController@fetchRoles");
    Route::post('/add-role', "RolePermissionController@saveRole");
    Route::get('/role/{role}', "RolePermissionController@editRole");
    Route::delete('/delete-role/{role}', "RolePermissionController@deleteRole");

    //permission routes
    Route::get('/fetch/permissions', "RolePermissionController@fetchPermissions");
    Route::post('/add-permission', "RolePermissionController@savePermission");
    Route::get('/permission/{permission}', "RolePermissionController@editPermission");
    Route::delete('/delete-permission/{permission}', "RolePermissionController@deletePermission");

    //users route
    Route::get('/fetch/users', "UserController@fetchUsers");
    Route::get('/fetch/all-roles', "UserController@fetchAllRoles");
    Route::get('/user/fetch/{id}', "UserController@onEdit");
    Route::post('/user/create', "UserController@saveUser");
    Route::put('/user/update', "UserController@updateUser");
    Route::delete('/user/delete/{id}', "UserController@deleteUser");
    Route::put('/user/change-password', "UserController@changePassword");



    Route::view('/{any?}', 'backend.layouts.app');
});
