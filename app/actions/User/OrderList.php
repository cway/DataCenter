<?php
/**
 * @file    OrderList.php
 * @des     获取用户订单列表
 * @author  caowei
 *
 */
class OrderListAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $userId            = $this->getRequest()->getParam('userId');
        $m_productOrder    = new ProductOrderModel;
        $options           = self::_initQueryOptions();
        $records           = $m_productOrder->getUserOrders( $userId, $options );
        
        $total             = $m_productOrder->getUserOrdersCnt( $userId );
        $res               = array(
                                'list'   => empty( $records ) ? array() : $records,
                                'total'  => $total,
                             );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}