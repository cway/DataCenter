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
       
        $userId             = $this->getRequest()->getParam('userId');
        $m_complaint        = new LogMoneyBalanceModel;
        $options            = self::_initQueryOptions();
        $res                = $m_complaint->getUserMoneyRecords( $userId, $options );
               
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}