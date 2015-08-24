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

    const TYPE_REDEEM		   = 2;


    private function _getRedeemOrders( $m_productOrder, $userId, $options )
    {
    	$conditions            = array(
    								 array(
    								 	 'field'  => 'user_id',
    							     	 'value'  =>  $userId,
    							     	 'op'	  => '=',
    								 ),
    								 array(
    							     	 'field'  => 'expire_date',
    							     	 'value'  =>  time(), //new DateTime(),
    							     	 'op'	  => '<=',
    							     ),
    							     array(
    							     	 'field'  => 'status',
    							     	 'values' => array(
    							     	 				ProductOrderModel::STATUS_PAID,
    							     	 				ProductOrderModel::STATUS_WAITING_CONFIRM,
    							     	 				ProductOrderModel::STATUS_UNKNOW,
    							     	 			 ),
    							     	 'op'     => 'IN',
    							     ),
    							 );

    	return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    public function _exec()
    {
        
        $userId                = $this->getRequest()->getParam('userId');
        $m_productOrder        = new ProductOrderModel;
        $options               = self::_initQueryOptions();
       	$type			       = $this->getRequest()->getParam('type');
       
        switch( $type ){
       	    case self::TYPE_REDEEM:
       	    	$res           = self::_getRedeemOrders( $m_productOrder, $userId, $options );
       	  	    break;
       	    default:
       	  	    $res           = $m_productOrder->getUserOrders( $userId, $options );
       	  	    break;
        } 
        
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}