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

    const TYPE_WAIT_REDEEM	   = 2;      //未领用
    const TYPE_REFUND          = 3;      //退款
    const TYPE_EXPIRED         = 4;      //过期
    const TYPE_FINISH          = 5;      //完成
    const TYPE_PROCESSING      = 6;      //需处理


    private function _getWaitRedeemOrders( $m_productOrder, $userId, $options )
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
    							     	 'op'	  => '>',
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

    private function _getRefundOrders( $m_productOrder, $userId, $options )
    {
        $conditions            = array(
                                     array(
                                         'field'  => 'user_id',
                                         'value'  =>  $userId,
                                         'op'     => '=',
                                     ), 
                                     array(
                                         'field'  => 'status',
                                         'value'  =>  ProductOrderModel::STATUS_REFUNDED,
                                         'op'     => '=',
                                     ),
                                 );

        return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    private function _getExpiredOrders( $m_productOrder, $userId, $options )
    {
        $conditions            = array(
                                     array(
                                         'field'  => 'user_id',
                                         'value'  =>  $userId,
                                         'op'     => '=',
                                     ),
                                     array(
                                         'field'  => 'expire_date',
                                         'value'  =>  time(),  
                                         'op'     => '<=',
                                     ),
                                 );

        return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    private function _getFinishOrders( $m_productOrder, $userId, $options )
    {
        $conditions            = array(
                                     array(
                                         'field'  => 'user_id',
                                         'value'  =>  $userId,
                                         'op'     => '=',
                                     ),
                                     array(
                                         'field'  => 'status',
                                         'value'  =>  ProductOrderModel::STATUS_REDEEMED,
                                         'op'     => '=',
                                     ),
                                 );

        return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    private function _getProcessingOrders( $m_productOrder, $userId, $options )
    {
        $conditions            = array(
                                     array(
                                         'field'  => 'user_id',
                                         'value'  =>  $userId,
                                         'op'     => '=',
                                     ),
                                     array(
                                         'field'  => 'status',
                                         'value'  =>  ProductOrderModel::STATUS_REFUND_REQUESTED,
                                         'op'     => '=',
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
        $res                   = array();

        switch( $type ){
       	    case self::TYPE_WAIT_REDEEM:
       	    	$res           = self::_getWaitRedeemOrders( $m_productOrder, $userId, $options );
       	  	    break; 
            case self::TYPE_REFUND:
                $res           = self::_getRefundOrders( $m_productOrder, $userId, $options );
                break;
            case self::TYPE_EXPIRED:
                $res           = self::_getExpiredOrders( $m_productOrder, $userId, $options );
                break;
            case self::TYPE_FINISH:
                $res           = self::_getFinishOrders( $m_productOrder, $userId, $options );
                break;
            case self::TYPE_PROCESSING:
                $res           = self::_getProcessingOrders( $m_productOrder, $userId, $options );
                break;
            default:
       	  	    $res           = $m_productOrder->getUserOrders( $userId, $options );
       	  	    break;
        } 
        
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}