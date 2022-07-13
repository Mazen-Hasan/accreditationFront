<?php

namespace App\Http\Traits;

use App\CustomClass\UserLoginInfo;

trait CallAPI
{
    static public function postAPI($apiName, $body){
        $base_url = env("API_BASE_URL", "http://127.0.0.1:8000/api/");
        $content_type = env("API_CONTENT_TYPE", "application/json");
        $accept = env("API_ACCEPT", "application/json");
        $accept_language = env("API_ACCEPT_LANGUAGE", "1");


        //Super admin
        $token = 'dc84b0ba-0234-11ed-a655-e8d8d1fd9cf6';
        //for ivan
        //$token = '3d7a48e4-f1d1-11ec-be2a-aae9fe74b1d2';

        //event admin 1
        //$token = 'b084e1b2-fa23-11ec-a655-e8d8d1fd9cf6';
        ////for ivan
//        $token = 'a11f33a0-007c-11ed-be2a-aae9fe74b1d2';

        //company admin
        //$token = '54d86938-fa25-11ec-a655-e8d8d1fd9cf6';
        $client = new \GuzzleHttp\Client([
            'base_uri' => $base_url,
            'headers' => ['Content-Type' => $content_type, "Accept" => $accept, 'Accept-Language'=> $accept_language,'user-token'=> $token]
        ]);

        // $userData = UserLoginInfo::get();

        // if ($userData != null){
        //     $client = new \GuzzleHttp\Client([
        //         'base_uri' => $base_url,
        //         'headers' => ['Content-Type' => $content_type, "Accept" => $accept, 'Accept-Language'=> $accept_language, 'user-token' => $userData->token]
        //     ]);
        // }
        // else{
        //     $client = new \GuzzleHttp\Client([
        //         'base_uri' => $base_url,
        //         'headers' => ['Content-Type' => $content_type, "Accept" => $accept, 'Accept-Language'=> $accept_language]
        //     ]);
        // }

        try{
            $res = $client->post($apiName, [
                'body' => json_encode($body)
            ]);

            $resJson = (json_decode($res->getBody()->getContents()));
            $result['status'] = true;
            $result['errCode'] = $resJson->errCode;
            $result['errMsg'] = $resJson->errMsg;
            $result['data'] = json_decode(json_encode($resJson->data), true);;
        }catch (\Exception $e) {
            $result['status'] = true;
            $result['errCode'] = '-999';
            $result['errMsg'] = 'General error occurred';
//            $result['errMsg'] = $e->getMessage();
            $result['data'] = '';
        }

        return $result;
    }
}
