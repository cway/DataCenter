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
        /*    $data           = array(
                                    array(
                                        'url'    => 'http://localhost/user/userInfo',
                                        'data'   => array(
                                                      'userId'         => 289066,
                                                    ),
                                        'method' => 'get',
                                    ),
                                    array(
                                        'url'    => 'http://localhost/user/orderlist',
                                        'data'   => array(
                                                      'userId'         => 289066,
                                                      'needPagination' => 1,
                                                      'type'           => 2,
                                                      'pageLimit'      => 1,
                                                    ),
                                        'method' => 'get',
                                    ),
                                    array(
                                        'url'    => 'http://localhost/user/coinrecords',
                                        'data'   => array(
                                                      'userId'         => 289066,
                                                      'type'           => 1,
                                                      'needPagination' => 1,
                                                      'pageLimit'      => 1,
                                                    ),
                                        'method' => 'get',
                                        'key'    => 'a',
                                    ),
                                );

        $res                = DWDData_Http::MutliCall( $data );
        var_dump( $res );exit; */

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