<?php
/**
 * @file    Complaints.php
 * @des     获取用户封号信息
 * @author  caowei
 *
 */
class BalanceRecordsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        try
        { 
            $userId            = $this->getRequest()->getParam('userId');
            $m_complaint       = new LogMoneyBalanceModel;
            $records           = $m_complaint->getUserMoneyRecords( $userId );
            $total             = $m_complaint->getUserMoneyRecordsCnt( $userId );
            $res               = array(
                                    'list'   => empty( $records ) ? array() : $records,
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