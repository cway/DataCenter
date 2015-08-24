<?php
/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author cway
 */
class ErrorController extends Yaf_Controller_Abstract {

	private function _renderJson( $psResultData, $errNO =DWDData_ErrorCode::SERVER_ERROR, $errMsg = DWDData_ErrorCode::SERVER_ERROR_MSG )
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

	//从2.1开始, errorAction支持直接通过参数获取异常
	public function errorAction($exception) {
		//1. assign to view engine
		if( $exception instanceof DWDData_Exception ){
			return self::_renderJson( array(), $exception->getCode(), $exception->getMessage() );
		}

		if( $exception instanceof Yaf_Exception_LoadFailed_Action ){
			return self::_renderJson( array(), DWDData_ErrorCode::REQUEST_URL_ERROR, DWDData_ErrorCode::REQUEST_URL_ERROR_MSG );
		}

		return self::_renderJson( array() );
		//5. render by Yaf 
	}
}
