<?php

namespace App\Http\Traits;

trait CallAPI
{
    static public function postAPI($apiName, $body){
        $base_url = env("API_BASE_URL", "http://127.0.0.1:8000/api/");
        $content_type = env("API_CONTENT_TYPE", "application/json");
        $accept = env("API_ACCEPT", "application/json");
        $accept_language = env("API_ACCEPT_LANGUAGE", "1");
        $token = '3d7a48e4-f1d1-11ec-be2a-aae9fe74b1d2';
        $client = new \GuzzleHttp\Client([
            'base_uri' => $base_url,
            'headers' => ['Content-Type' => $content_type, "Accept" => $accept, 'Accept-Language'=> $accept_language,'user-token'=> $token]
        ]);

        $res = $client->post($apiName, [
            'body' => json_encode($body)
        ]);

        $resJson = (json_decode($res->getBody()->getContents()));
        $result['status'] = true;
        $result['errCode'] = $resJson->errCode;
        $result['errMsg'] = $resJson->errMsg;
        $result['data'] = json_decode(json_encode($resJson->data), true);;

        return $result;
    }
}
