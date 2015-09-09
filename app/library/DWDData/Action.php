<?php
/**
 * @file Abstract.php
 *
 * @author caowei
 *         @date 2015-2-3 下午0:38:07
 *         @brief Action基类
 *
 */
abstract class DWDData_Action extends Yaf_Action_Abstract
{
    // 协议GET POST
    protected $_method = 'GET';

    // 输出格式
    protected $_outputFormat = 'json';

    /*
     * 类名,可以手动指定
     */
    protected $_requestClass = 'DWDData_Request';

    // 输入
    protected $_requestObj;

    //验参版本
    protected $_signV = '';

    //_authValue,权限验证value;
    protected $_authValue = '';

    //_isCheckAuth action级别是否验权限
    protected $_isCheckAuth = false;

    //_isCheckAuthRediect action级别是否验权限并跳转
    protected $_isCheckAuthRedirect = false;

    // json 回调名
    protected $_callback = '';

    // dev模式自动更改
    protected function _initDev ()
    {}

    protected function _initQueryOptions(){
            $options                   =  array(
                                             'limit'       => DWDData_Const::DEFAULT_PAGE_LIMIT,
                                             'offset'      => DWDData_Const::DEFAULT_OFFSET,
                                           );

        if( null != $this->getRequest()->getParam('pageLimit') && intval( $this->getRequest()->getParam('pageLimit') ) > 0 ){
            $options['limit']          = intval( $this->getRequest()->getParam('pageLimit') );
        }

        if( null != $this->getRequest()->getParam('pageNum') && intval( $this->getRequest()->getParam('pageNum') ) > 1 ){
            $options['offset']         = ( intval( $this->getRequest()->getParam('pageNum') ) - 1 ) * $options['limit'];
        } 

        if( null != $this->getRequest()->getParam('needPagination') ){
            $options['needPagination'] = true;
            if( null != $this->getRequest()->getParam('pageNum') && intval( $this->getRequest()->getParam('pageNum') ) > 0 ){
                $options['pageNum']    = intval( $this->getRequest()->getParam('pageNum') );
            } else {
                $options['pageNum']    = DWDData_Const::DEFAULT_PAGE_NUM;
            }
        }

        return $options;
    }

    public function init ()
    {
        Yaf_Dispatcher::getInstance()->disableView();
        $this->checkLogin();
        $this->checkAuth();  
    }

    final public function execute ()
    {
        try {
            $this->init();
            $this->safeCheck();
            $this->_exec();
            $this->after();
        }
        catch (DWDData_Exception $e) {
            $psResult   = new DWDData_Result();
            $psResult->setErrno( $e->getCode() );
            $psResult->setErrmsg( $e->getMessage() );
            $this->_outputFormat == 'json' ? $this->renderErrorJson( $psResult->getResult() ) : $this->renderErrorPage( $psResult->getResult() );
        }
        catch (Exception $e) {
            $psResult   = new DWDData_Result();
            $psResult->setErrno( DWDData_ErrorCode::SERVER_ERROR );
            $psResult->setErrmsg( DWDData_ErrorCode::SERVER_ERROR_MSG );
            $logger     = DWDData_Logger::getInstance();
            $logger->error( $e->getMessage(), $e->getCode() );
            $this->_outputFormat == 'json' ? $this->renderErrorJson( $psResult->getResult() ) : $this->renderErrorPage( $psResult->getResult() );
        }
    }

    public function _exec()
    {}

    /*
     * 检验是否安全
     */
    final public function safeCheck ()
    {
    }

    /*
     * 强制替换RequestObj;
     */
    public function setRequestObj (DWDData_Request $requestObj)
    {
        $this->_requestObj = $requestObj;
        return $this;
    }


    /*
     * 自动化Requestname;
     */
    protected function getRequestName ()
    {
        /*
         * 继承类设定了,就直接使用
         */
        if (!empty($this->_requestClass) && $this->_requestClass != 'DWDData_Request') {
            return $this->_requestClass;
        }
        /*
         * 非设定,则自动计算;
         */
        $classArray      = explode('_', get_class($this));
        $appFileDirct    = Yaf_Dispatcher::getInstance()->getApplication()->getAppDirectory();

        if (is_array($classArray)) {
            $last            = array_pop($classArray);
            $requestFileName = str_replace('Action', '', $last );
            array_push($classArray, $this->_name);
            array_push($classArray, $requestFileName);
            array_push($classArray, 'Request');
            $requestFilePath = $appFileDirct .'/requests/' . $this->_name . '/' . $requestFileName . ".php";

            if(@file_exists( $requestFilePath )){
                require_once $requestFilePath;
            }
        } else {
            throw new DWDData_Exception(DWDData_ErrorCode::MSG_PARAMS_NOT_ARRAY);
        }
        $className = implode('_', $classArray);

        /*
         * 使用默认
         */
        if (@class_exists($className)) {
            return $className;
        } elseif ($this->_requestClass) {
            return $this->_requestClass;
        }
    }

    /*
     * 执行Request必须从这个入口走
     */
    public function getRequest ()
    {
        if (! $this->_requestObj instanceof DWDData_Request) {
            $ClassName = $this->getRequestName();
            $this->_requestObj = new $ClassName();
        }
        return $this->_requestObj;
    }

    /*
     * 执行Request必须从这个入口走
     */
    public function after ()
    {
        //  $this->getRequest()->_logHandle->notice();
    }

    /**
     * [返回错误页 description]
     * @param  [type] $errNO  [description]
     * @param  [type] $errMsg [description]
     * @return [type]         [description]
     */
    public function renderErrorPage( $psResult )
    {
        $this->forward('error', 'error', array( 'err_msg' => $psResult['errmsg'] ));
    }

    /**
     * [返回json错误信息 description]
     * @param  [type] $errNO  [description]
     * @param  [type] $errMsg [description]
     * @return [type]         [description]
     */
    public function renderErrorJson( $psResult )
    {
        $this->renderJson( $psResult['data'], $psResult['errno'], $psResult['errmsg'] );
    }

    /**
     * [返回json信息 description]
     * @param  [type] $errNO  [description]
     * @param  [type] $errMsg [description]
     * @return [type]         [description]
     */
    public function renderSuccessJson( $psResult )
    {
        $this->renderJson( $psResult['data'] );
    }

    /**
     * [返回json信息 description]
     * @param  [type] $psResult [description]
     * @return [type]           [description]
     */
    public function renderJson( $psResultData, $errNO =DWDData_ErrorCode::NORMAL, $errMsg = DWDData_ErrorCode::NORMAL_MSG )
    {
        $result    =  new DWDData_Result();
        $result->setErrno( $errNO );
        $result->setErrmsg( $errMsg );
        $result->setData( $psResultData );
        $this->getResponse()->setHeader( 'Content-Type', 'application/json;charset=utf-8' );
        $this->getResponse()->setHeader( 'Server', 'apache/1.8.0' );
        $this->getResponse()->setHeader( 'X-Powered-By', 'PHP' );
        $this->getResponse()->setBody( $result->toJson() );
    }


    /**
     * 判断是否登录
     * @return bool
     */
    public function checkLogin(){
        $userTokenParam = $this->getRequest()->getParam('user_token');

        if(( !isset($_COOKIE['user_token']) || empty($_COOKIE['user_token']) )
            && ( !isset($userTokenParam) || empty($userTokenParam) )) {
            return false;
        }

        $userToken = isset($_COOKIE['user_token']) ? $_COOKIE['user_token'] : $userTokenParam;
        $m_User = new UserModel();
        $currentUser = $m_User->FindUsrByToken($userToken);
        if(false === $currentUser || strtotime($currentUser['last_sign_in_at']) + DWDData_Const::TOKEN_TIMEOUT < time()) {
            return false;
        }
        $this->_authValue = array( 'user_id' => $currentUser['id'], 'user_token' => $userToken);
        return true;
    }

    /**
     * 身份验证
     */
    public function checkAuth()
    {
        if(true === $this->_isCheckAuth && '' === $this->_authValue) {
            throw new DWDData_Exception( DWDData_ErrorCode::LOGIN_NOT_SIGN_IN_ERROR_MSG, DWDData_ErrorCode::LOGIN_NOT_SIGN_IN_ERROR );
        }

        if(true === $this->_isCheckAuthRedirect && '' === $this->_authValue) {
        }
    }

    /**
     * 判断访问是否来自移动端
     */
    public function checkMobile()
    {
        $host = $_SERVER['HTTP_HOST'];
        $hostArray = explode('.', $host);
        if( !empty($hostArray) && 'm' == current($hostArray) ) {
            $this->_isMobileClient = true;
        }
    }
}




