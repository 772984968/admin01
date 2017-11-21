<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class AdminLogController extends TemplateController
{


    public $config = [
     'modelName' => 'app\common\model\AdminLog', // 模型字段
     'field' => [
     'id',
     'admin_username',
     'ip',
     'time',
     ], // 查询的字段
     'bars' => [
     'head' => '管理员管理',
     'title' => '管理员登录列表'
     ],//标题
     'del'=>['title'=>'删除管理员日志','url'=>'adminLog/del'],
     ];

    public function getTitle()
    {
        return [
         'ID',
         '登录用户名',
         '登录ip',
         '登录时间 ',
         '操作',
         ];

    }


    public function getOption()
    {
         return [
         ];


    }


}
