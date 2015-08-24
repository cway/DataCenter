<?php
/**
 * @name LogCoinBalanceModel
 * @desc LogCoinBalanceModel
 * @author cway
 */
class LogCoinBalanceModel extends DWDData_Db {
  
    protected $dbTable                = 'log_coin_balance';

    const  FILED_COMMON_TYPE          = 0;

    CONST TYPE_ALL                    = 0;       // 0：所有记录
    CONST TYPE_DAILY_LOGIN            = 1;       // 1：每日签到
    CONST TYPE_RECOMMEND              = 2;       // 2：推荐好友
    CONST TYPE_ORDER_COMMENT          = 3;       // 3：订单评论
    CONST TYPE_GIFT_CARD              = 4;       // 4：活动赠送
    CONST TYPE_BALANCE_EXCHANGE       = 5;       // 5：余额兑换
    CONST TYPE_TOPUP                  = 6;       // 6: 金币充值
    CONST TYPE_ORDER_AWARD            = 7;       // 7: 下单奖励
    CONST TYPE_ORDER_CANCELED         = 8;       // 8: 取消订单补偿
    CONST TYPE_ORDER_FEEDBACK_CORRECT = 9;       // 9: 订单纠错通过奖励

    protected $fieldTypes             = array(
                                            array( 'user_id', 'type', 'amount', 'created_at', 'current_balance' ),
                                        );

    /**
     *获取用户金币记录
     */
    public function getUserCoinRecords( $userId, $option = array() ) {
    	 
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
     *获取用户金币记录数
     */
    public function getUserCoinRecordsCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count();
    }


    /**
     * 根据条件获取金币记录列表
     */
    public function getCoinRecordsByConditions( $conditions, $option = array(), $fields = self::FILED_COMMON_TYPE ){
     
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
    public function getCoinRecordsCntByCondition( $condition ){
 
        return self::getListCntByConditions( $conditions );
    }
}