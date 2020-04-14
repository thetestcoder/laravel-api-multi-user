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
    Route::get('/fetch/roles', "RolePermissionController@fetchRoles");
    Route::get('/fetch/permissions', "RolePermissionController@fetchPermissions");
    Route::post('/add-role', "RolePermissionController@saveRole");
    Route::view('/{any?}', 'backend.layouts.app');
});
