<?php
/**
 * @file    UnbindDevice.php
 * @des     解绑设备
 * @author  caowei
 *
 */
class UnbindDeviceAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    { 
        $userId         = $this->getRequest()->getParam('userId');
        $opUserId       = $this->getRequest()->getParam('opUserId');
        $reason         = $this->getRequest()->getParam('reasonType');

        $m_userDevice   = new UserDeviceModel;
        $m_userDevice->startTransaction(); 
        $deviceInfo     = $m_userDevice->unBindDevice( $userId );
        $data           = 'failed';
 
        if( empty( $deviceInfo ) ){
            $m_userDevice->rollback();
        } else {
            $m_logUserDeviceUnbund = new LogUserDeviceUnbundModel;
            $record                = array(
                                        'user_id'     => intval($userId),
                                        'op_user_id'  => intval($opUserId),
                                        'udid'        => $deviceInfo['udid'],
                                        'reasonType'  => intval($reason),
                                        'remark_json' => json_encode( $deviceInfo ),
                                        'remark'      => json_encode( $deviceInfo ),
                                        'created_at'  => time(),
                                     );
            $res                   = $m_logUserDeviceUnbund->addUnbindRecord( $record );
            if( false == $res ){
              $m_userDevice->rollback();
            }

            $data                  = 'success';
            $m_userDevice->commit();
        }
    
        $data == 'failed' ? $this->renderErrorJson( array( 'data' => $data, 'errno' => DWDData_ErrorCode::USER_UNBIND_DEVICE_FAILED, 'errmsg' => DWDData_ErrorCode::USER_UNBIND_DEVICE_FAILED_MSG ) ) : $this->renderSuccessJson( array( 'data' => $data ) );
    }
}