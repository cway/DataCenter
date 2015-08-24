<?php
/**
 * @file    UserInfo.php
 * @des     获取用户信息
 * @author  caowei
 *
 */
class UserInfoAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    { 
        $userId         = $this->getRequest()->getParam('userId');
        $mobile         = $this->getRequest()->getParam('mobile');
        $m_user         = new UserModel;
        $userInfo       = array();
        if( false == empty( $userId ) ){
        	$userInfo   = $m_user->getUser( $userId );
        } else if( false == empty( $mobile ) ){
        	$userInfo   = $m_user->getUserByMobile( $mobile );
        }
     
        $this->renderSuccessJson( array( 'data' => $userInfo ) );
    }
}