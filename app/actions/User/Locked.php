<?php
/**
 * @file    Locked.php
 * @des     用户封号
 * @author  caowei
 *
 */
class LockedAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    { 
        $userId             = $this->getRequest()->getParam('userId');
        $opUserId           = $this->getRequest()->getParam('opUserId');
        $unlockDate         = $this->getRequest()->getParam('unlockDate');
        $note               = $this->getRequest()->getParam('note');
        $type               = $this->getRequest()->getParam('type');
        $reasonType         = $this->getRequest()->getParam('reasonType');

        if( $unlockDate ){
            $unlockDate     =  date('Y-m-d H:i:s', strtotime( $unlockDate ) );
        } else {
            $unlockDate     =  date('Y-m-d H:i:s', time() + 3600 * 24 * 30);
        }

        $now                = date('Y-m-d H:i:s');

        $m_user             = new UserModel;
        $updates            = array(
                                'id'          => $userId,
                                'locked'      => $type,
                                'locked_at'   => $now, 
                                'lock_date'   => $unlockDate,
                              );
        $res                = $m_user->updateUserInfo( $userId, $updates );
 
        if( !$res ){
            $this->renderErrorJson( array( 'data' => $data, 'errno' => DWDData_ErrorCode::USER_LOCKED_FAILED, 'errmsg' => DWDData_ErrorCode::USER_LOCKED_FAILED_MSG ) );
            return ;
        }

        $record             = array(
                                'user_id'     => $userId,
                                'op_user_id'  => $opUserId,
                                'type'        => $type,
                                'lock_date'   => $unlockDate,
                                'note'        => $note,
                                'create_at'   => $now,
                                'reason_type' => $reasonType,
                              );
        $m_logUserLockModel = new LogUserLockModel;
        $m_logUserLockModel->addLockRecord( $record );
        $this->renderSuccessJson( array( 'data' => 'success' ) );
    }
}