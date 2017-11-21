<?php

namespace app\admin\controller;

use think\Controller;

class SystemLogController extends TemplateController
{

   public $config = [
     'modelName' => 'app\common\model\SystemLog', // 模型字段
     'field' => [
     'id',
     'admin_username',
     'target_url',
     'query_params',
     'ua',
     'ip',
     'note',
      'create_time',
     ], // 查询的字段
     'bars' => [
     'head' => '系统管理',
     'title' => '系统操作列表'
     ],//标题
     'del'=>['title'=>'删除系统','url'=>'SystemLog/del'],
     ];


    public function getTitle()
    {
        return [
         'ID',
         '操作用户名',
         '操作路由',
         '操作参数',
         '浏览器信息',
         '操作ip',
         '备注',
         '操作时间',
          '操作',
         ];

    }


    public function getOption()
    {

        return [];

    }


}
