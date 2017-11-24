<?php
namespace app\common\lib\message;
use think\Validate;
use app\common\model\User;
use think\Cache;

//短信验证类
class msg{


    public $username;                           //帐号
    public $validMinute = 5;                    //短信有效时间(分钟)
    public $error='';//错误信息
    //缓存的关键字
    const REGISTER_NAME = 'register_sms_';      //注册记录【缓存名称】
    const FIND_NAME = 'find_sms_';              //查找密码记录【缓存名称】
    const FIND_CODE = 'find_sms_code_';             //找回密码验证码【缓存名称】
    const FIND_CODE_ERROR = 'find_sms_code_error_'; //找回密码短信验证码错误 【缓存名称】
    const REGISTER_CODE = 'register_sms_code_'; //注册验证码 【缓存名称】
    const REGISTER_CODE_ERROR = 'register_sms_code_error_'; //注册验证码错误名称
    const IP_CODE = 'ip_code'; //ip


    public function validateUsername()
    {
        if (User::get(['username'=>$this->username])){
            $this->error='账号已经存在';
            return false;
        }
        return true;
    }

    //检测发送的数据
    public function checkSendNumber( $key )
    {
        $redis=Cache::store('redis')->handler();
        //不存在
        if(!$redis->get($key.$this->username)) {
            return  true;
//             $this->error='60秒内不能重复发送!';
//             return false;
        }
        //判断发送时间
        if ($redis->get)
        //判断当天发送次数
        //判断Ip发送次数
        if(!RedisNode::listCountCheck($key.$this->username, 99999, 3600*24)) {
            $this->addError('username', '24小时内不能超过10次!');
            return false;
        }

        $ip = ip2long(Yii::$app->getRequest()->getUserIP());

        if(!RedisNode::listCountCheck(static::REGISTER_IP.$ip, 99999, 3600*24)) {
            $this->addError('username', '1个IP24小时内不能超过10次!');
            return false;
        }
        return  true;
    }



    public function register()
    {
        if ($this->validateUsername()&&$this->checkSendNumber(self::REGISTER_CODE)){

       }
        return false;


         //   $sendClass = $this->sendClass;
            if( $sendClass::register($this->username) ) {
           //     Cache::store('redis')->lpush(self::REGISTER_NAME.$this->username,time());
                //手机发送记录加1
                $redis = Yii::$app->redis;
                $redis->lpush( self::REGISTER_NAME.$this->username, time() );
                $redis->expire( self::REGISTER_NAME.$this->username,3600*24 );

                //IP发送记录加1
                $ip = ip2long( Yii::$app->getRequest()->getUserIP() );
                $redis->lpush( self::REGISTER_IP . $ip, time() );
                $redis->expire( self::REGISTER_IP . $ip,3600*24 );

                //设置验证码有效期
                Yii::$app->getCache()->set(self::REGISTER_CODE . $this->username, $sendClass::$code, $this->validMinute * 60);
                return true;

            } else {
                //发送失败
                $this->addError('username', Yii::t('common','sms_send_error'));
                return false;
            }
    }

    //取短信验证码
    public static function getRegisterNote( $username )
    {

        return Yii::$app->getCache()->get( self::REGISTER_CODE . $username);
    }

    //删除短信验证码
    public static function delRegisterNode( $username )
    {
        Yii::$app->getCache()->delete( self::REGISTER_CODE . $username );
    }

    /**
     * 验证注册验证码 , 验证3次失败删除验证码
     * @param $code     注册账号,验证码
     * @param $username   注册账号手机
     * @return bool
     */
    public static function checkRegister($username,$code)
    {
        if( self::getRegisterNote($username) == $code ) {
            return true;
        } else {
            $redis = Yii::$app->redis;
            $keyName = self::REGISTER_CODE_ERROR . $username;
            $redis->incr( $keyName );

            if( $redis->get( $keyName ) >= 99999 ) {
                self::delRegisterNode( $username );
                $redis->del( $keyName );
            }
            return false;
        }
    }


    /**
     * 找回密码
     * @return bool
     */
    public function findpassword()
    {

        if($this->validate())
        {
            $sendClass = $this->sendClass;
            if( $sendClass::find($this->username) ) {
                //发送成功
                //手机发送记录加1
                $redis = Yii::$app->redis;
                $redis->lpush( self::FIND_NAME.$this->username, time() );

                //IP发送记录加1
                $ip = ip2long( Yii::$app->getRequest()->getUserIP() );
                $redis->lpush( self::REGISTER_IP . $ip, time() );

                //设置验证码有效期
                Yii::$app->getCache()->set(self::FIND_CODE . $this->username, $sendClass::$code, $this->validMinute * 60);

                return true;

            } else {
                //发送失败
                $this->addError('username','验证码发送失败,请稍后再试!');
                return false;
            }
        }
    }


    //取短信验证码
    public static function getFindNote( $username )
    {

        return Yii::$app->getCache()->get( self::FIND_CODE . $username);
    }


    //删除短信验证码
    public static function delFindNode( $username )
    {
        Yii::$app->getCache()->delete( self::FIND_CODE . $username );
    }


    /**
     * 验证找密验证码
     * @param $code     注册账号,验证码
     * @param $username   注册账号手机
     * @return bool
     */
    public static function checkfindpassword($username,$code)
    {

        $find_code = self::getFindNote( $username );

        if(empty($find_code) ) {
            return false;
        }

        if( $find_code == $code ) {
            return true;
        } else {
            $redis = Yii::$app->redis;
            $keyName = self::FIND_CODE_ERROR . $username;
            $redis->incr( $keyName );

            if( $redis->get( $keyName ) >= 3 ) {
                self::delRegisterNode( $username );
                $redis->del( $keyName );
            }
            return false;
        }
    }



}