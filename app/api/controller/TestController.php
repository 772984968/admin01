<?php

namespace app\api\controller;

use think\Controller;
use app\lib\factory\Factory;


/**
 *
 *测试接口控制器
 *
 */
class TestController
{
    public function  test(){

        $abc= \app\common\lib\message\Msg::getFindpasswordNote('15899595363');
        var_dump($abc);die;


    }

}
