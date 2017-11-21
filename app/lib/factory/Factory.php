<?php
namespace app\lib\factory;
/**
 *工厂类
 */
class  Factory{
    private  $UserModel;
    //用户类
    public function getUser($userId=''){
        if (!$this->UserModel){
            $this->UserModel= \app\common\model\User::get(['id'=>$userId]);
            if (!$this->UserModel){
                return false;
            }
            return $this->UserModel;
        }
        return $this->UserModel;
    }
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