<?php
/**
 * @name LogOrderModel
 * @desc LogOrderModel
 * @author cway
 */
class LogOrderModel extends DWDData_Db {
  
    protected $dbTable           = 'log_order'; 

    /**
     *添加用户订单操作记录
     */
    public function addLogOrder( $logOrderInfo ) {
    	  
         $this->order_id         = $logOrderInfo['order_id'];
         $this->ip               = $logOrderInfo['ip'];
         $this->status           = $logOrderInfo['status'];
         $this->remark           = $logOrderInfo['remark'];
         $this->created_at       = date('Y-m-d H:i:s');
         $this->op_user_id       = $logOrderInfo['op_user_id'];

         return  $this->insert();
    }
}