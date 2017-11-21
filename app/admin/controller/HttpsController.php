<?php

namespace app\admin\controller;

use think\Controller;
use app\lib\https\Curl;
use app\lib\factory\Factory;

class HttpsController extends Controller
{


    //curl网络协议
    public function index(){
        return $this->fetch();
    }

    public function  send(){
        $data=input();
        if ($data['type']=='get'){
            $curl=Factory::getCurl();
            $rs=$curl->sendGet($data['url']);

        }else {
            $curl=Factory::getCurl();
            $Nonce=microtime();
            $curTime=time();
            $header=[
                'Content-Type:application/x-www-form-urlencoded;charset=utf-8',
                //'Content-Type:application/json;charset=utf-8',json格式
                'Appkey:'.config('system')['wy_app_key'],
                'CurTime:'.$curTime,
                'Nonce:'.$Nonce,
                'CheckSum:'.sha1(config('system')['wy_app_secret'].$Nonce.$curTime),
            ];
            $rs=$curl->sendPost($data['url'],['mobile'=>'15899595363'],$header);
        }
        if ($rs['code']==400){
            var_dump($rs['error']);die;

        }else{
            var_dump($rs['data']);die;

        }
    }
}
