<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\lib\factory\Factory;
use app\common\model\User;

class UserController extends BaseController
{

    //用户登录
    public function login(){
        $data=input('post.');
        $result = $this->validate($data,'User.login');
        if(true !== $result){
            $this->jsonError($result);
        }
        $userModel=User::get(['username'=>$data['username'],'password'=>md5($data['password'])]);
        if (!$userModel){
            $this->jsonError('用户不存在或密码错误');
        }
        $factorty=new Factory();
        $factorty->getUser($userModel->id);
        session('userId',$userModel->id);
        $this->jsonSuccess('用户登录成功');
        }
}
