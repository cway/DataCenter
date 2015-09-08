 <?php
/**
 * @name OrderFeedbackModel
 * @desc OrderFeedbackModel
 * @author cway
 */
class OrderFeedbackModel extends DWDData_Db {
  
    protected $dbTable           = 'order_feedback'; 

    protected $fieldTypes        = array( 
    					               array( 'user_id', 'product_order_id', 'type', 'feedback', 'created_at', 'updated_at', 'status', 'note', 'reviewed_at' ),
                                   );
    protected $dbFields          = array( 'user_id', 'product_order_id', 'type', 'feedback', 'created_at',  'updated_at', 'status', 'note', 'reviewed_at' );

    /**
     *更新奖池信息
     */
    public function addFeedback( $feedbackInfo ) {
     
         $this->user_id           = $feedbackInfo['user_id'];
         $this->product_order_id  = $feedbackInfo['product_order_id'];
         $this->type              = $feedbackInfo['type'];
         $this->feedback          = $feedbackInfo['feedback'];
         $this->created_at        = date('Y-m-d H:i:s');
         $this->updated_at        = date('Y-m-d H:i:s');
         $this->status            = $feedbackInfo['status'];
         $this->note              = $feedbackInfo['note'];
         $this->reviewed_at       = $feedbackInfo['reviewed_at'];
         return $this->insert(); 
    }
}
