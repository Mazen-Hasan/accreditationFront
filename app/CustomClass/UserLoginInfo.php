<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\Session;

class  UserLoginInfo
{

    public static function get(){
        return Session::get('userData');
    }

    public static function set($token, $user_name, $permissions){
        $userData = new UserData($token, $user_name,$permissions);
        Session::put('userData', $userData);
    }
}
