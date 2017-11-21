<?php

namespace app\admin\controller;

use think\Controller;
use think\console\Input;

class RoleController extends TemplateController
{

   public $config = [
        'modelName' => 'app\common\model\Role', // 模型字段
        'field' =>['id','name','state','access_id','update_time','remark'], // 查询的字段
        'bars' => [
            'head' => '角色管理',
            'title' => '角色列表'
        ],//标题
        'add'=>['title'=>'添加角色','url'=>'role/add'],
        'del'=>['title'=>'删除角色','url'=>'role/del'],
        'edit'=>['title'=>'编辑角色','url'=>'role/edit'],

    ];
    public function getTitle()
    {
      return [
         'ID',
         '角色名称',
          '状态',
         '权限ID',
          '更新时间',
          '备注',
         '操作',
         ];
    }
    //添加
    public function add(){
        if ($this->request->isAjax()){
            $data=input('post.');
            $list['name']=$data['name'];
            $list['remark']=$data['remark'];
            $list['state']=$data['state'];
            $list['access_id']=implode(',',$data['access_ids']);
            $model=new $this->config['modelName'];
            if($model->allowField(true)->save($list)){
                return  json(['code'=>200,'msg'=>'添加成功']);
            }else{
                return json(['code'=>400,'msg'=>$model->getError]);
            }

        }
        $data['config']=$this->config;//获取配置
        $this->assign('data',$data);
        return   $this->fetch();

    }

    public function getOption()
    {
        return [];

    }
    //编辑
    public function edit(){
        $model=new $this->config['modelName'];
        if ($this->request->isAjax()){
            $data=input('post.');
            $list['id']=$data['id'];
            $list['name']=$data['name'];
            $list['remark']=$data['remark'];
            $list['state']=$data['state'];
            $list['access_id']=implode(',',$data['access_ids']);
            $model=new $this->config['modelName'];
            if($model->allowField(true)->update()->save($list)){
                return  json(['code'=>200,'msg'=>'添加成功']);
            }else{
                return json(['code'=>400,'msg'=>$model->getError]);
            }

        }
        $data=$model->where(['id'=>input('id')])->find();
        $data['access_id']=explode(',',$data['access_id']);
        $data['config']=$this->config;
        $this->assign('data',$data);
            return $this->fetch();

    }

}
