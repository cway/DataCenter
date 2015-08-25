<?php
/**
 * @file    BalanceRecords.php
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
        $m_logMoneyBalance  = new LogMoneyBalanceModel;
        $options            = self::_initQueryOptions();
        $res                = $m_logMoneyBalance->getUserMoneyRecords( $userId, $options );
               
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}