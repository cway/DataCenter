<?php
/**
 * @file    LockedRecords.php
 * @des     获取用户封号信息
 * @author  caowei
 *
 */
class SMSRecordsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {  
    	$params             =  $this->getRequest()->allParams();
        $userMobile         =  '';

        if( false == isset( $params['mobile'] ) ||  empty( $params['mobile'] ) ){
        	$m_user         = new UserModel;
        	$res            = $m_user->getUser( $params['userId'], array( 'mobile' ) );
        	$userMobile     = $res['mobile'];
        } else {
            $userMobile     = $params['mobile'];
        }
        
        $m_logSMS           = new LogSMSModel;
        $options            = self::_initQueryOptions();
        $res                = $m_logSMS->getUserSMS( $userMobile, $options );
        
        $this->renderSuccessJson( array( 'data' =>  $res ) );
    }
}