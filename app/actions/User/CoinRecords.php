<?php
/**
 * @file    Complaints.php
 * @des     获取用户封号信息
 * @author  caowei
 *
 */
class CoinRecordsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        $userId             = $this->getRequest()->getParam('userId');
        $m_complaint        = new LogCoinBalanceModel;
        $options            = self::_initQueryOptions();
        $records            = $m_complaint->getUserCoinRecords( $userId, $options );
        $total              = $m_complaint->getUserCoinRecordsCnt( $userId );
        $res                = array(
                                 'list'   => empty( $records ) ? array() : $records,
                                 'total'  => $total,
                              );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}