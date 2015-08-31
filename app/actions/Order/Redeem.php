<?php
/**
 * @file    Redeem.php
 * @des     验证订单
 * @author  caowei
 *
 */
class RedeemAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $orderId             = $this->getRequest()->getParam('orderId');
        $redeemNumber        = $this->getRequest()->getParam('redeemNumber');
        $opUserId            = $this->getRequest()->getParam('opUserId');

        $m_productOrder      = new ProductOrderModel; 
        $orderInfo           = $m_productOrder->getOrder( $orderId );
        
        if( empty( $orderInfo ) ){
            $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::ORDER_NOT_FOUND, 'errmsg' => DWDData_ErrorCode::ORDER_NOT_FOUND_MSG ) );
            return ;
        }
       
        $now                         = date('Y-m-d H:i:s');

        if( ProductOrderModel::STATUS_PAID != $orderInfo['status'] || $redeemNumber != $orderInfo['redeem_number'] ){
            $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::ORDER_REDEEM_FAILED, 'errmsg' => DWDData_ErrorCode::ORDER_REDEEM_FAILED_MSG ) );
            return ;
        } 

        $orderInfo['status']         = ProductOrderModel::STATUS_REDEEMED;
        $orderInfo['redeem_time']    = $now;
        $orderInfo['redeem_user_id'] = $opUserId;
        $res                         = $m_productOrder->updateOrder( $orderInfo );
 
        if( false == $res ){
            $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::ORDER_REDEEM_FAILED, 'errmsg' => DWDData_ErrorCode::ORDER_REDEEM_FAILED_MSG ) );
            return ;
        }

        $record                      = array(
                                           'order_id'   => $orderId,
                                           'ip'         => DWDData_Util::getClientIp(),
                                           'status'     => ProductOrderModel::STATUS_REDEEMED,
                                           'remark'     => 'redeem',
                                           'created_at' => $now,
                                           'op_user_id' => $opUserId,
                                       );
        $m_logOrderModel             = new LogOrderModel;
        $m_logOrderModel->addLogOrder( $record );

        $this->renderSuccessJson( array( 'data' => $orderInfo ) );
    }
}