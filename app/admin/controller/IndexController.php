<?php
namespace app\admin\controller;
use think\Db;

/**
 *
 * @author Administrator
 * 后台首页控制器
 *
 */
class IndexController extends BaseController
{
    //后台首页
    public function index()
    {

        $abc=Db('access')->select();
        return $this->fetch();
    }
    //后台欢迎页
    public function welcome(){

        return $this->fetch();
    }
}
