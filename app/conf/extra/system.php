<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [
    //不需要权限可访问URL
    'url'=>[
        'Index/welcome',
        'Index/index',
    ],
    'wy_app_key' => '1afd0cff01e8f89a6f7f1655905c0d67',//网易云秘钥
    'wy_app_secret'=>'ff28807bcae3',
    'ali_pay_Notify_Url' => 'http://appapi.atkj6666.com/order/ali',
    'upload'=>[
        'maxImageSize'=>3*1024*1024,//允许上传的图片大小
        'maxFileSize'=>5*1024*1024,//允许上传的文件大小
        'allowImageExt'=>['jpeg','jpg','png','gif'],//图片上传类型
        'allowFileExt'=>['mp3','txt','world','rar','mp4'],//允许上传的文件类型
        'uploadImagePath'=>ROOT_PATH . 'public' . DS . 'uploads'.DS.'images',//图片上传路径
        'uploadFilePath'=>ROOT_PATH . 'public' . DS . 'uploads'.DS.'files',//文件上传路径
    ],
];
