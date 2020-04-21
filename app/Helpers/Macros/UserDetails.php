<?php

namespace App\Helpers\Macros;

use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;


class UserDetails
{
    public function getLoggedInURL()
    {
        if (!Auth::guest())
            return Auth::user()->roles[0]->name;
        return '/home';
    }

    public function name()
    {
        if (!Auth::guest())
            return Auth::user()->name;
        else
            return "Guest";
    }
}
