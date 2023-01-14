<?php

if(!function_exists('responseFormatter')){

    function responseFormatter(array $data){
        if($data['status']==true){
            return response($data,200);
        }else{
            return response($data, 400);
        }
    }

}

if(!function_exists('apiResponseFormatter')){
    function apiResponseFormatter(array $data){
        return response($data,$data['code']);
    }
}

if(!function_exists('apiStandardSuccessFormatter')){

    function apiStandardSuccessFormatter(array $data = null,$msg, $code){

        return array(
            'status' => true,
            'msg' => $msg,
            'data' => $data,
            'code' => $code
        );
    }

}

if(!function_exists('apiStandardFailedFormatter')){

    function apiStandardFailedFormatter(array $data = null,$msg, $code){

        if(rangeNumber($code,100,599)){
            $errCode = $code;
        }else{
            $errCode = 503;
        }

        return array(
            'status' => false,
            'msg' => $msg,
            'data' => $data,
            'code' => $errCode
        );
    }

}

if(!function_exists('standardSuccessFormatter')){

    function standardSuccessFormatter(array $data = null,$msg){
        return array(
          'status' => true,
          'msg' => $msg,
          'data' => $data
        );
    }

}

if(!function_exists('standardFailedFormatter')){

    function standardFailedFormatter(array $data = null,$msg){
        return array(
            'status' => true,
            'msg' => $msg,
            'data' => $data
        );
    }

}
