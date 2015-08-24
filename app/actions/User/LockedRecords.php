<?php
/**
 * @file    LockedRecords.php
 * @des     获取用户封号信息
 * @author  caowei
 *
 */
class LockedRecordsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        
        $userId             = $this->getRequest()->getParam('userId');
        $m_logUserLock      = new LogUserLockModel;
        $options            = self::_initQueryOptions();
        $records            = $m_logUserLock->getUserLockedRecords( $userId, $options );
        $total              = $m_logUserLock->getUserLockedRecordsCnt( $userId );
        $res                = array(
                                 'list'   => empty( $records ) ? array() : $records,
                                 'total'  => $total,
                              );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}