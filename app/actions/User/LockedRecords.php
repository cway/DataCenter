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
        $res                = $m_logUserLock->getUserLockedRecords( $userId, $options );
        
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}