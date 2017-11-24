<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\common\lib\message\msg;
use think\Cache;

class MsgController extends BaseController
{
    //注册验证码
    public  function sendRegister(){
        $usrename = $this->request->post('username');
        if(!isMobile( $usrename ) ) {
            $this->jsonError('帐号需为手机号码!');
        }
        $msg=new msg();
        $msg->username=$usrename;
        if (!$msg->register()){
            $this->jsonError($msg->error);
        }
        $this->jsonSuccess('验证码发送成功,有效时间'.$msg->validMinute.'分钟');

    }
    //找回密码
    public function sendFindPassword(){

    }
    //通知短信
    public function sendNotice(){

    }

}
