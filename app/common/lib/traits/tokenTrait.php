<?phpnamespace app\common\lib\traits;trait tokenTrait{    private static $TOKEN_CACHE_NAME = 'token_';    //设置令牌    public function setToken()    {        $this->userId = $this->iid;        Yii::$app->cache->set(self::$TOKEN_CACHE_NAME.$this->userId, $this->createToken());    }    //取令牌    public function getToken()    {        return Yii::$app->cache->get( self::$TOKEN_CACHE_NAME.$this->userId );    }    //消除令牌    public function clearToken()    {        Yii::$app->cache->delete( self::$TOKEN_CACHE_NAME.$this->userId );    }    //退出    public function logout()    {        $this->clearToken();    }    //通过token,user_id加载数据    public function loginByToken($token)    {        $token_cache = $this->getToken();        if( $token_cache && $token == $token_cache ) {            $this->userId = $this->userId;            return true;        }        return false;    }    // 创建TOken    private static function createToken()    {        return md5(time(). AdCommon::randomkeys(20) . mt_rand(1000,9999));    }    //是否已登入    public function isLogin() {        return $this->userId ? true : false;    }}?>