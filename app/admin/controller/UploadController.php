<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\lib\factory\Factory;
use think\File;
/**
 *
 *文件上传
 *
 */
class uploadcontroller extends Controller
{

    public function index()
    {
        return $this->fetch();
    }

    // 图片上传
    public function uploadImage(){
         $upload=(new Factory)->getUpload($_FILES['file1']);
         $upload->allowImageExt=config('system')['upload']['allowImageExt'];
         $upload->maxImageSize=config('system')['upload']['maxImageSize'];
         $upload->uploadPath=config('system')['upload']['uploadImagePath'];
         $rs=$upload->uploadImage();
        if ($rs===true){
            return $upload->getUrl();
        }
        return $rs;
    }
    //文件上传
    public function uploadFile(){
        $upload=(new Factory)->getUpload($_FILES['file2']);
        $rs=$upload->uploadFile();
        if ($rs===true){
            return $upload->getUrl();
        }
        return $rs;

    }
    // 多图片上传
    public function uploadImages(){
        foreach ($_FILES as $key=> $file){
            foreach ($file['name'] as $key=>$val){
                $files[$key]['name']=$file['name'][$key];
                $files[$key]['type']=$file['type'][$key];
                $files[$key]['tmp_name']=$file['tmp_name'][$key];
                $files[$key]['error']=$file['error'][$key];
                $files[$key]['size']=$file['size'][$key];
            }
        }
        foreach ($files as $val){
            $upload=(new Factory)->getUpload($val);
            $upload->allowImageExt=config('system')['upload']['allowImageExt'];
            $upload->maxImageSize=config('system')['upload']['maxImageSize'];
            $upload->uploadPath=config('system')['upload']['uploadImagePath'];
            $rs=$upload->uploadImage();
            if ($rs===true){
               echo  $upload->getUrl();
               echo '<br>';
            }else{
                echo  $rs;
                echo '<br>';
            }

        }
    }

    //Tp5单文件上传
    public function tpUpload(){
        $file = request()->file('image');
        if (empty($file)) {
            $this->error('请选择上传文件');
        }
        //检查后缀
        if (!$file->checkExt(config('system')['upload']['allowImageExt'])){
            $this->error('不允许的文件类型');

        }
        //检查文件大小
        if (!$file->checkSize(config('system')['upload']['maxImageSize'])){
            $this->error('文件大小超出限制');
        }
        $info = $file->move(config('system')['upload']['uploadImagePath']);
        if ($info) {
            $this->success('文件上传成功：' . $info->getInfo());
        } else {

            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }

    // Tp5多文件上传
    public function tpUploads()
    {
        // 获取表单上传文件
        $files = request()->file('images');
        $item = [];
        foreach ($files as $key => $file) {
            // 检查后缀
            if (! $file->checkExt(config('system')['upload']['allowImageExt'])) {
                $item[$key]['type'] = '不允许的文件类型';
                continue;

            }
            // 检查文件大小
            if (! $file->checkSize(config('system')['upload']['maxImageSize'])) {
                $item[$key]['type'] = '文件大小超出限制';
                continue;
            }
            $info = $file->move(config('system')['upload']['uploadImagePath']);
            if ($info) {
                $item[$key]['success'] = $info->getRealPath();
            }else{
                // 上传失败获取错误信息
                $item[$key]['error']=$file->getError();
            }
        }
       var_dump($item);die;
    }

    //百度上传插件
   public function webuploader(){
       if ($this->request->isPost()){
           $file = request()->file('file');
           if (empty($file)) {
               $this->error('请选择上传文件');
           }
           //检查后缀
           if (!$file->checkExt(config('system')['upload']['allowImageExt'])){
               return json(['code'=>400,'error'=>'不允许的文件类型']);


           }
           //检查文件大小
           if (!$file->checkSize(config('system')['upload']['maxImageSize'])){
               return json(['code'=>400,'error'=>'文件大小超出限制']);
           }
           $info = $file->move(config('system')['upload']['uploadImagePath']);
           if ($info) {
               return json(['code'=>200,'url'=>$info->getRealPath()]);
           } else {
               return json(['code'=>400,'error'=>$file->getError()]);
           }

       }
      return $this->fetch();
   }

    //文件下载
   public function downLoad(){
       $filename='./abc.png';
       header('content-disposition:attachment;filename='.basename($filename));
       header('content-length:'.filesize($filename));
       readfile($filename);

   }
}
