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
        try
        { 
            $userId            = $this->getRequest()->getParam('userId');
            $m_logUserLock     = new LogUserLockModel;
            $records           = $m_logUserLock->getUserLockedRecords( $userId );
            $total             = $m_logRecommendApp->getUserLockedRecordsCnt( $userId );
            $res               = array(
                                    'list'   => $records,
                                    'total'  => $total,
                                 );
            $this->renderSuccessJson( array( 'data' => $res ) );
        }
        catch (Tee_Exception $e)
        {
            $this->renderErrorJson( array( 'errno' => $e->getCode(), 'errmsg' => $e->getMessage() ) );
        }
    }
}