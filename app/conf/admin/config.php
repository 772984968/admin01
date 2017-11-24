<?php
return
[
    //数据缓存方式
    'cache' =>  [
        // 使用复合缓存类型
        'type'  =>  'complex',
        // 默认使用的缓存
        'default'   =>  [
            // 驱动方式
            'type'   => 'File',
            // 缓存保存目录
            'path'   => CACHE_PATH,
        ],
        // 文件缓存
        'file'   =>  [
            // 驱动方式
            'type'   => 'file',
            // 设置不同的缓存保存目录
            'path'   => RUNTIME_PATH . 'file/',
        ],
        // redis缓存
        'redis'   =>  [
            // 驱动方式
            'type'   => 'redis',
            // 服务器地址
            'host'       => '127.0.0.1',
            //端口号
            'port'       => 6379,
            // 密码
            'password'   => '123456',
            'timeout'=> 0,
        ],
    ],
    //验证码配置
    'captcha'  => [
        // 字体大小
        'fontSize' => 20,
        //验证码高度
        'imageH'=>40,
        //验证码宽度
        'imageW'=>140,
        // 验证码长度（位数）
        'length'   => 4,
        //是否添加杂点
        'useNoise'=>true,
        //验证码字符集
        'codeSet'=>'123567890',
        // 是否画混淆曲线
        'useCurve' => false,
    ],

];