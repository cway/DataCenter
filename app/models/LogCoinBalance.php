<?php
/**
 * @name LogCoinBalanceModel
 * @desc LogCoinBalanceModel
 * @author cway
 */
class LogCoinBalanceModel extends DWDData_Db {
  
    protected $dbTable           = 'log_coin_balance';

    const  FILED_COMMON_TYPE     = 0;

    protected $fieldTypes        = array(
                                       array( 'user_id', 'type', 'amount', 'created_at', 'current_balance' ),
                                   );

    /**
     *获取用户金币记录
     */
    public function getUserCoinRecords( $userId, $option = array() ) {
    	 
         $rowNums     = array();
         $rowNums[0]  = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->startPage;
         $rowNums[1]  = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;

         return  $this->where( 'user_id', $userId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
    }

    /**
     *获取用户金币记录数
     */
    public function getUserCoinRecordsCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count;
    } 
}