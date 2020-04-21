<?php

//get user name 

use App\Helpers\Facades\UserFacade;

if (!function_exists('name')) {
    function name()
    {
        return UserFacade::name();
    }
}
