<?php
/**
 * @file    OrderLog.php
 * @des     获取商户订单列表
 * @author  caowei
 *
 */
class OrderLogAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $orderId           = $this->getRequest()->getParam('orderId');
        $m_logOrder        = new LogOrderModel; 
        $orderLogInfo      = $m_logOrder->getOrderLog( $orderId );
         
       
        $this->renderSuccessJson( array( 'data' => $orderLogInfo ) );
    }
}