<?php

use App\Helpers\Facades\UserFacade;


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

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
