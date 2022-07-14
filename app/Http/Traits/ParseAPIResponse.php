<?php

namespace App\Http\Traits;

trait ParseAPIResponse
{
    public static function parseResult($result){
        $retResult['errCode'] = $result['errCode'];
        $retResult['errMsg'] = $result['errMsg'];

        $data = $result['data'];

        if($retResult['errCode'] == 1){
            if(count($data) > 2){
                foreach ($data as $key => $value) {
                    if ($key != 'size' and $key != 'data'){
                        $retResult['data'][$key] = $data[$key];
                    }
                }
            }

            if (array_key_exists('size', $data)){
                $retResult['data']['size'] = $data['size'];
                $retResult['data']['data'] = $data['data'];
            }
            else
            {
                if(!empty($data['data'])){
                    $retResult['data'] = $data['data'][0];
                }
            }
        }

        return $retResult;
    }
}
