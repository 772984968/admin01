<?phpnamespace app\common\lib\send;use app\lib\https\Curl;//网易短信class WysmsNode extends Curl{    private static $Nonce; //随机数（最大长度128个字符）    private static $CurTime; //当前UTC时间戳，从1970年1月1日0点0 分0 秒开始到现在的秒数(String)    private static $CheckSum;//SHA1(AppSecret + Nonce + CurTime),三个参数拼接的字符串，进行SHA1哈希计算，转化成16进制字符(String，小写)    const   HEX_DIGITS = "0123456789abcdef";    public  $code;  //验证码    const REGISTER_TEMPLATE = '3055548';      //注册短信模版    const FIND_TEMPLATE = '3090032';         //找回密码短信模版    const APP_KEY = '1afd0cff01e8f89a6f7f1655905c0d67';    const APP_SECRET = 'ff28807bcae3';    const POST_URL = 'https://api.netease.im/sms/sendtemplate.action';    public static function postData($data){        self::checkSumBuilder();       //发送请求前需先生成checkSum       $postdata = '';        foreach ($data as $key=>$value){            $postdata.= ($key.'='.urlencode($value).'&');        }        // building POST-request:        $URL_Info=parse_url(self::POST_URL);       if(!isset($URL_Info["port"])){          $URL_Info["port"]=80;        }        $request = '';        $request.="POST ".$URL_Info["path"]." HTTP/1.1\r\n";        $request.="Host:".$URL_Info["host"]."\r\n";        $request.="Content-type: application/x-www-form-urlencoded;charset=utf-8\r\n";        $request.="Content-length: ".strlen($postdata)."\r\n";        $request.="Connection: close\r\n";        $request.="AppKey: ".self::APP_KEY."\r\n";        $request.="Nonce: ".self::$Nonce."\r\n";        $request.="CurTime: ".self::$CurTime."\r\n";        $request.="CheckSum: ".self::$CheckSum."\r\n";        $request.="\r\n";        $request.=$postdata."\r\n";        $fp = fsockopen($URL_Info["host"],$URL_Info["port"]);        fputs($fp, $request);        $result = '';        while(!feof($fp)) {            $result .= fgets($fp, 128);        }        fclose($fp);        $str_s = strpos($result,'{');        $str_e = strrpos($result,'}');        $str = substr($result, $str_s,$str_e-$str_s+1);        //return self::json_to_array($str);        return json_decode($str);    }    //注册短信验证码    public static function register($mobile)    {        if(HUANG_JING < 2) {            $this->code=666666;            return true;        }       $data= array(            'templateid' => self::REGISTER_TEMPLATE,            'mobiles' => json_encode([$mobile]),            'params' => json_encode(),        );        if(self::$RequestType=='curl'){            $result = self::postDataCurl($data);        }else{            $result = self::postDataFsockopen($data);        }        if( isset($result->code) && $result->code == 200 ) {            return true;        } else {            \lib\models\CodeLog::addlog('短信发送失败',$result);            return false;        }    }/** * * @param 找回短信验证码 * @return boolean */    public static function find($mobile)    {        self::create_rand();        if(HUANG_JING < 3) {            return true;        }        $params=[ self::$code ];        $data= array(            'templateid' => self::FIND_TEMPLATE,            'mobiles' => json_encode([$mobile]),            'params' => json_encode($params),        );        if(self::$RequestType=='curl'){                   $result = self::postDataCurl($data);        }else{                 $result = self::postDataFsockopen($data);        }        if( isset($result->code) && $result->code == 200 ) {            return true;        } else {            \lib\models\CodeLog::addlog('短信发送失败',$result);            return false;        }    }}