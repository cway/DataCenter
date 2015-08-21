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
        try
        {
            $branchId          = $this->getRequest()->getParam('branchId');
            $m_productOrder    = new ProductOrderModel;
            $records           = $m_productOrder->getBranchOrders( $branchId );
            $total             = $m_productOrder->getBranchOrderssCnt( $branchId );
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