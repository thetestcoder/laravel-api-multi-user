<?php

use App\Helpers\Facades\UserFacade;



Route::get('/test', function () {
    UserFacade::getRoleName();
});

require('admin.php');
require('writer.php');

Route::view('/', 'layouts.app');

Auth::routes();
