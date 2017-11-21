<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Console;

    /**
 *开发控制器
 */
 class DevelopController extends Controller
{

    /**
     * 创建控制器.
     *
     * @return \think\Response
     */
    public function makeController()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $module = $data['module'];
            $controller = ucfirst($data['name']);
            if (Console::call('make:controller', [
                $module . '/' . $controller
            ])) {
                return json([
                    'code'=>200,'msg'=>'添加成功']);
            }
            }
      return $this->fetch();

    }
    /**
     * 创建模型.
     *
     * @return \think\Response
     */
    public function makeModel()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $module = $data['module'];
            $model = ucfirst($data['name']);
            if (Console::call('make:model', [
                $module . '/' . $model
            ])) {
                return json([
                    'code'=>200,'msg'=>'添加成功']);
            }
        }
        return $this->fetch();

    }



}
