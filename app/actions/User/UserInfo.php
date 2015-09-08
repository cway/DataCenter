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
        $userId             = $this->getRequest()->getParam('userId');
        $mobile             = $this->getRequest()->getParam('mobile');
        $redeemNumber       = $this->getRequest()->getParam('redeemNumber');

        $m_user             = new UserModel;
        $userInfo           = array();
        if( false == empty( $userId ) ){
        	$userInfo       = $m_user->getUser( $userId );
        } else if( false == empty( $mobile )  ){
        	$userInfo       = $m_user->getUserByMobile( $mobile );
        } else if( false == empty( $redeemNumber ) ){
            $m_productOrder = new ProductOrderModel;
            $orderInfo      = $m_productOrder->getOrderByRedeemNumber( $redeemNumber );
         
            if( false == empty( $orderInfo ) ){
                $userInfo   = $m_user->getUser( $orderInfo['user_id'] );
            }
        }
     
        $this->renderSuccessJson( array( 'data' => $userInfo ) );
    }
}