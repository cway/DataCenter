<?php
/**
 * @file    OrderInfo.php
 * @des     获取商户订单列表
 * @author  caowei
 *
 */
class OrderInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $orderId           = $this->getRequest()->getParam('orderId');
        $redeemNumber      = $this->getRequest()->getParam('redeemNumer');
        $m_productOrder    = new ProductOrderModel;
        $orderInfo         = array();
        if( false == empty( $orderId ) ){
            $orderInfo     = $m_productOrder->getOrder( $orderId );
        } else if( false == empty( $redeemNumber ) ){
            $orderInfo     = $m_productOrder->getOrderByRedeemNumber( $redeemNumber );
        } 
       
        $this->renderSuccessJson( array( 'data' => $orderInfo ) );
    }
}