<?php
/**
 * @name UserModel
 * @desc UserModel
 * @author cway
 */
class ProductOrderModel extends DWDData_Db {
  
    protected $dbTable           = 'product_order';

    const FILED_COMMON_TYPE      = 0;

    protected $fieldTypes        = array(
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
         
        // $data  = $this->where( 'user_id', 55 )->paginate(5, $this->fieldTypes[self::FILED_COMMON_TYPE]);
         $rowNums     = array( ); 
         $rowNums[0]  = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->startPage;
         $rowNums[1]  = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
 
         return  $this->where( 'user_id', $userId )->withTotalCount()->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
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
         
         $rowNums     = array( ); 
         $rowNums[0]  = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->startPage;
         $rowNums[1]  = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
 
         return  $this->where( 'campaign_branch_id', $branchId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
    }

    /**
     *获取商户订单数
     */
    public function getBranchOrdersCnt( $branchId, $option = array() ) {
         
         return $this->where( 'campaign_branch_id', $branchId )->count();
    }
}
