<?php

namespace App\CustomClass;

class UserData
{
    public $token = '';
    public $user_name = '';
    public $permissions = [];

    public function __construct($token, $user_name, $permissions) {
        $this->token = $token;
        $this->user_name = $user_name;
        $this->permissions = $permissions;
    }
}
