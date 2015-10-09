<?php
/**
 * @file    PaymentInfo.php
 * @des     获取支付信息
 * @author  caowei
 *
 */
class PaymentInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $orderId               = $this->getRequest()->getParam('orderId'); 
         
       	$m_orderPaymentRecord  = new OrderPaymentRecordModel;
       	$options               = array();
       	if( !empty( $realPay ) ){
       	    $options['active'] = DWDData_Const::ACTIVE;
       	}
       	$paymentInfo           = $m_orderPaymentRecord->getPaymentInfo( $orderId, $options );
        $this->renderSuccessJson( array( 'data' => $paymentInfo ) );
    }
}