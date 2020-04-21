<?php

use App\Helpers\Facades\UserFacade;

Route::group(['prefix' => 'writer', 'middleware' => ['auth', 'role:writer']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
