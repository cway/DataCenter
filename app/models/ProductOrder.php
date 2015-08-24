<?php
/**
 * @name UserModel
 * @desc UserModel
 * @author cway
 */
class ProductOrderModel extends DWDData_Db {
  
    protected $dbTable                      = 'product_order';

    const FILED_COMMON_TYPE                 = 0;

   // 订单状态 处理这个状态的时候要留意想要更改订单列表API的处理
    CONST STATUS_WAITING_PAYMENT            = 1;     // 未支付
    CONST STATUS_PAID                       = 2;     // 已支付
    CONST STATUS_EXPIRED                    = 3;     // 已过期
    CONST STATUS_REDEEMED                   = 4;     // 已使用
    CONST STATUS_CANCELLED                  = 5;     // 已取消
    CONST STATUS_REFUNDED                   = 6;     // 已退款
    CONST STATUS_INSUFFICENT_BALANCE_FAILED = 7;     // 余额不足，支付失败
    CONST STATUS_WAITING_CONFIRM            = 8;     // 等待到账
    CONST STATUS_RECYCLED                   = 9;     // 超时支付被系统回收
    CONST STATUS_UNKNOW                     = 10;    // 客户端没有获取同步通知，服务端也没获得异步通知
    CONST STATUS_REFUND_REQUESTED           = 11;    // 申请退款中


    protected $fieldTypes                   = array(
    						                      array( 'campaign_branch_id', 'redeem_branch_id', 'user_id', 'price', 'status', 'type', 'trade_number', 'created_at', 'updated_at' ),
    					                      );

    /**
     *获取订单信息
     */
    public function getOrder( $orderId, $fields = self::FILED_COMMON_TYPE ) {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}

        return  $this->byId( $orderId, $fields );
    }

    /**
     * 根据条件获取订单列表
     */
    public function getOrdersByConditions( $conditions, $option = array(), $fields = self::FILED_COMMON_TYPE ){
         if( false == is_array( $fields ) ){
            $fields              = intval( $fields );
            if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
                $fields          = self::FILED_COMMON_TYPE;
            }

            $fields              = $this->fieldTypes[$fields];
        }

        return self::getListByConditions( $conditions, $option, $fields );
    }

    /**
     * 根据条件获取订单数量
     */
    public function getOrdersCntByConditions( $conditions ){

        return self::getListCntByConditions( $conditions );
    }

    /**
     *根据兑换码获取订单信息
     */
    public function getOrderByRedeemNumber( $redeemNumber, $fields = self::FILED_COMMON_TYPE ) {

        if( false == is_array( $fields ) ){
            $fields              = intval( $fields );
            if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
                $fields          = self::FILED_COMMON_TYPE;
            }

            $fields              = $this->fieldTypes[$fields];
        }

        return  $this->where( 'redeem_number', $redeemNumber )->getOne( $fields );
    }

    /**
     *获取用户订单
     */
    public function getUserOrders( $userId, $option = array() ) {
         
         $res                 = array();
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->where( 'user_id', $userId )->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->where( 'user_id', $userId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
         }
        
         if( null == $res['list'] ){
            $res['list']      = array();
         }
         return $res;
    }

    /**
     *获取用户订单数
     */
    public function getUserOrdersCnt( $userId, $option = array() ) {
         
         return $this->where( 'user_id', $userId )->count();
    }

    /**
     *获取商户订单
     */
    public function getBranchOrders( $branchId, $option = array() ) {
         
         $res                 = array();
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->where( 'campaign_branch_id', $branchId )->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->where( 'campaign_branch_id', $branchId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
         }

         if( null == $res['list'] ){
            $res['list']      = array();
         } 
         return  $res;
    }

    /**
     *获取商户订单数
     */
    public function getBranchOrdersCnt( $branchId, $option = array() ) {
         
         return $this->where( 'campaign_branch_id', $branchId )->count();
    }
}
