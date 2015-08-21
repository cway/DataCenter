<?php
/**
 * @name IndexController
 * @author cway
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends DWDData_Base {

	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/sample/index/index/index/name/cway 的时候, 你就会发现不同
     */
	public function indexAction() 
	{
		$result    =  new DWDData_Result();
        $result->setErrno( DWDData_ErrorCode::NORMAL );
        $result->setErrmsg( DWDData_ErrorCode::NORMAL_MSG );

        $this->getResponse()->setBody( $result->toJson() );
	}
}
