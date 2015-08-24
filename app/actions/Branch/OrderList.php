<?php
/**
 * @file    OrderList.php
 * @des     获取商户订单列表
 * @author  caowei
 *
 */
class OrderListAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $branchId          = $this->getRequest()->getParam('branchId');
        $m_productOrder    = new ProductOrderModel;
        $options           = self::_initQueryOptions();
        $records           = $m_productOrder->getBranchOrders( $branchId, $options );
        $total             = $m_productOrder->getBranchOrdersCnt( $branchId );
        $res               = array(
                                'list'   => empty( $records ) ? array() : $records,
                                'total'  => $total,
                             );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}