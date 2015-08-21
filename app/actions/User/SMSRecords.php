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
        try
        { 
        	$params         =  $this->getRequest()->allParams();
            $userMobile     =  '';

            if( false == isset( $params['mobile'] ) ||  empty( $params['mobile'] ) ){
            	$m_user     = new UserModel;
            	$res        = $m_user->getUser( $userId, array( 'mobile' ) );
            	$userMobile = $res['mobile'];
            } else {
                $userMobile = $params['mobile'];
            }
            
            $m_logSMS       = new LogSMSModel;
             
            $records        = $m_logSMS->getUserSMS( $userMobile );
            $total          = $m_logSMS->getUserSMSCnt( $userMobile );
            $res            = array(
            					'list'   => $records,
            					'total'  => $total,
            				  );
            
            $this->renderSuccessJson( array( 'data' =>  $res ) );
        }
        catch (Tee_Exception $e)
        {
            $this->renderErrorJson( array( 'errno' => $e->getCode(), 'errmsg' => $e->getMessage() ) );
        }
    }
}