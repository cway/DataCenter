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

    const TYPE_WAIT_REDEEM	   = 2;      //未领用
    const TYPE_REFUND          = 3;      //退款
    const TYPE_EXPIRED         = 4;      //过期
    const TYPE_FINISH          = 5;      //完成
    const TYPE_PROCESSING      = 6;      //需处理
  
    private function _getWaitRedeemOrders( $m_productOrder, $branchId, $options )
    {
    	$conditions            = array(
    								 array(
    								 	 'modelName'  => 'CampaignbranchHasBranchesModel',
    							     	 'joinKey'    => 'campaign_branch_id',
    							     	 'joinType'   => 'INNER',
    							     	 'op'	      => 'join',
    								 ),
    								 array(
    							     	 'field'      => 'campaignbranch_has_branches.branch_id',
    							     	 'value'      =>  $branchId,
    							     	 'op'	      => '=',
    							     ),
    								 array(
    							     	 'field'      => 'expire_date',
    							     	 'value'      =>  time(), //new DateTime(),
    							     	 'op'	      => '>',
    							     ),
    							     array(
    							     	 'field'      => 'status',
    							     	 'values'     => array(
	    							     	 				ProductOrderModel::STATUS_PAID,
	    							     	 				ProductOrderModel::STATUS_WAITING_CONFIRM,
	    							     	 				ProductOrderModel::STATUS_UNKNOW,
	    							     	 			 ),
    							     	 'op'         => 'IN',
    							     ),
    							 );

    	return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    private function _getRefundOrders( $m_productOrder, $branchId, $options )
    {
        $conditions            = array(
                                     array(
    								 	 'modelName'  => 'CampaignbranchHasBranchesModel',
    							     	 'joinKey'    => 'campaign_branch_id',
    							     	 'joinType'   => 'INNER',
    							     	 'op'	      => 'join',
    								 ),
    								 array(
    							     	 'field'      => 'campaignbranch_has_branches.branch_id',
    							     	 'value'      =>  $branchId,
    							     	 'op'	      => '=',
    							     ),
                                     array(
                                         'field'      => 'status',
                                         'value'      =>  ProductOrderModel::STATUS_REFUNDED,
                                         'op'         => '=',
                                     ),
                                 );

        return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    private function _getExpiredOrders( $m_productOrder, $branchId, $options )
    {
        $conditions            = array(
                                     array(
    								 	 'modelName'  => 'CampaignbranchHasBranchesModel',
    							     	 'joinKey'    => 'campaign_branch_id',
    							     	 'joinType'   => 'INNER',
    							     	 'op'	      => 'join',
    								 ),
    								 array(
    							     	 'field'      => 'campaignbranch_has_branches.branch_id',
    							     	 'value'      =>  $branchId,
    							     	 'op'	      => '=',
    							     ),
                                     array(
                                         'field'      => 'expire_date',
                                         'value'      =>  time(),  
                                         'op'         => '<=',
                                     ),
                                 );

        return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    private function _getFinishOrders( $m_productOrder, $branchId, $options )
    {
        $conditions            = array(
                                     array(
    								 	 'modelName'  => 'CampaignbranchHasBranchesModel',
    							     	 'joinKey'    => 'campaign_branch_id',
    							     	 'joinType'   => 'INNER',
    							     	 'op'	      => 'join',
    								 ),
    								 array(
    							     	 'field'      => 'campaignbranch_has_branches.branch_id',
    							     	 'value'      =>  $branchId,
    							     	 'op'	      => '=',
    							     ),
                                     array(
                                         'field'      => 'status',
                                         'value'      =>  ProductOrderModel::STATUS_REDEEMED,
                                         'op'         => '=',
                                     ),
                                 );

        return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    private function _getProcessingOrders( $m_productOrder, $branchId, $options )
    {
        $conditions            = array(
                                     array(
    								 	 'modelName'  => 'CampaignbranchHasBranchesModel',
    							     	 'joinKey'    => 'campaign_branch_id',
    							     	 'joinType'   => 'INNER',
    							     	 'op'	      => 'join',
    								 ),
    								 array(
    							     	 'field'      => 'campaignbranch_has_branches.branch_id',
    							     	 'value'      =>  $branchId,
    							     	 'op'	      => '=',
    							     ),
                                     array(
                                         'field'      => 'status',
                                         'value'      =>  ProductOrderModel::STATUS_REFUND_REQUESTED,
                                         'op'         => '=',
                                     ),
                                 );

        return $m_productOrder->getOrdersByConditions( $conditions, $options );
    }

    public function _exec()
    { 
        $branchId              = $this->getRequest()->getParam('branchId');
        $m_productOrder        = new ProductOrderModel;
        $options               = self::_initQueryOptions();
        $type			       = $this->getRequest()->getParam('type');
        $res 				   = array();

        switch( $type ){
       	    case self::TYPE_WAIT_REDEEM:
       	    	$res           = self::_getWaitRedeemOrders( $m_productOrder, $branchId, $options );
       	  	    break; 
            case self::TYPE_REFUND:
                $res           = self::_getRefundOrders( $m_productOrder, $branchId, $options );
                break;
            case self::TYPE_EXPIRED:
                $res           = self::_getExpiredOrders( $m_productOrder, $branchId, $options );
                break;
            case self::TYPE_FINISH:
                $res           = self::_getFinishOrders( $m_productOrder, $branchId, $options );
                break;
            case self::TYPE_PROCESSING:
                $res           = self::_getProcessingOrders( $m_productOrder, $branchId, $options );
                break;
            default:
       	  	    $res           = $m_productOrder->getBranchOrders( $branchId, $options );
       	  	    break;
        }

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}