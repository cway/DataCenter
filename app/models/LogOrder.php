<?php
/**
 * @name LogOrderModel
 * @desc LogOrderModel
 * @author cway
 */
class LogOrderModel extends DWDData_Db {
  
    protected $dbTable           = 'log_order'; 

    const  MAX_RECORDS           = 100;
    /**
     *添加用户订单操作记录
     */
    public function addLogOrder( $logOrderInfo ) 
    {
    	  
         $this->order_id         = $logOrderInfo['order_id'];
         $this->ip               = $logOrderInfo['ip'];
         $this->status           = $logOrderInfo['status'];
         $this->remark           = $logOrderInfo['remark'];
         $this->created_at       = date('Y-m-d H:i:s');
         $this->op_user_id       = $logOrderInfo['op_user_id'];

         return  $this->insert();
    }
 
    /**
     *获取订单日志记录
     */
    public function getOrderLog( $orderId, $option = array() ) 
    {
         
         $res                 = array();
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->where( 'order_id', $orderId )->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->where( 'order_id', $orderId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
         }
        
         if( null == $res['list'] ){
            $res['list']      = array();
         }
         return $res;
    }
}