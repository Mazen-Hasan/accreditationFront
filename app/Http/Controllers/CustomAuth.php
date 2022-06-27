<?php

namespace App\Http\Controllers;

use App\CustomClass\UserLoginInfo;
use App\Http\Traits\CallAPI;
use Illuminate\Http\Request;
use \GuzzleHttp\Psr7\Request as GRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CustomAuth extends Controller
{

    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){

        $email = $request->input('email');
        $password = $request->input('password');

        $body = [
            'email' => $email,
            'password' =>  $password,
        ];

        $result = CallAPI::postAPI('user/login',$body);

        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];

        $token = $data['token'];
        $user_name = $data['user_name'];
        $permissions = json_decode(json_encode($data['data']), true);

        UserLoginInfo::set($token, $user_name, $permissions);

        return redirect()->route('events');
    }

    public function logout(Request $request){
        Session::forget('userData') ;
        Session::flush();

        return redirect()->route('welcome');
    }
}
