<?php
/**
 * @file    OAuthes.php
 * @des     获取用户订单列表
 * @author  caowei
 *
 */
class OAuthesAction extends DWDData_Action
{
    protected $_isCheckAuth    = false; 


    public function _exec()
    {
        
        $userId                = $this->getRequest()->getParam('userId');
        $m_oauth               = new OAuthModel;
        $options               = self::_initQueryOptions();
       	$type			       = $this->getRequest()->getParam('type');
       	$res                   = $m_oauth->getUserOAuthes( $userId, $options );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}