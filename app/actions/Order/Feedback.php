<?php
/**
 * @file    Feedback.php
 * @des     订单反馈
 * @author  caowei
 *
 */
class FeedbackAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    { 
        $orderId           = $this->getRequest()->getParam('OrderId');
        $type              = $this->getRequest()->getParam('type');
        $feedback          = $this->getRequest()->getParam('feedback'); 
        $status            = $this->getRequest()->getParam('status');
        $note              = $this->getRequest()->getParam('note');
        $reviewedAt        = $this->getRequest()->getParam('reviewed_at');
        $m_orderFeedback   = new OrderFeedbackModel;
        $m_productOrder    = new ProductOrderModel;
        $orderInfo         = $m_productOrder->getOrder( $orderId );
        $feedInfo          = array(
                                'user_id'          => $orderInfo['userId'],
                                'product_order_id' => $orderId,
                                'type'             => $type,
                                'feedback'         => $feedback,
                                'status'           => $status,
                                'note'             => $note,
                                'reviewed_at'      => $reviewedAt,
                             );
        $res               = $m_orderFeedback->addFeedback( $feedInfo );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}