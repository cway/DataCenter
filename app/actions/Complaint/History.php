<?php
/**
 * @file    History.php
 * @des     获取投诉标签列表
 * @author  caowei
 *
 */
class HistoryAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    { 
    	$orderId			   = $this->getRequest()->getParam('orderId');

        $m_complaint           = new ComplaintModel; 
        $options               = self::_initQueryOptions();
        $res                   = $m_complaint->getOrderCamplaints( $orderId, $options );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}