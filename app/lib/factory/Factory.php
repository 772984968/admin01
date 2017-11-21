<?php
namespace app\lib\factory;
/**
 *工厂类
 */
class  Factory{
    //权限认证类
    public static function getRbac(){
        if (isset($rbac)){
            return  $rbac;
        }
        return   new \app\lib\auth\Rbac;
    }
    //cURl类
    public static function getCurl(){
        return   new \app\lib\https\Curl;
    }
    //upload类
    public  function getUpload($fileInfo){
        return   new \app\lib\upload\Upload($fileInfo);
    }

}