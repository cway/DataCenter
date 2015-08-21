<?php
/**
 * @name ComplaintModel
 * @desc ComplaintModel
 * @author cway
 */
class ComplaintModel extends DWDData_Db {
  
    protected $dbTable           = 'complaint';

    const  FILED_COMMON_TYPE     = 0;

    protected $fieldTypes        = array(
                                       array( 'item_id', 'order_id', 'user_id', 'branch_id', 'saler_id', 'type_id', 'status', 'description', 'from_id', 'category_id', 'mobile', 'created_at', 'updated_at', 'resolved_at' ),
                                   );

    /**
     *获取用户投诉列表
     */
    public function getUserComplaints( $userId, $option = array() ) {
    	 
         $rowNums     = array( ); 
         $rowNums[0]  = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->startPage;
         $rowNums[1]  = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;

         return  $this->where( 'user_id', $userId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
    }

    /**
     *获取用户投诉列表数
     */
    public function getUserComplaintsCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count;
    } 


    /**
     *获取商户投诉列表
     */
    public function getBranchComplaints( $branchId, $option = array() ) {
         
         $rowNums     = array( ); 
         $rowNums[0]  = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->startPage;
         $rowNums[1]  = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;

         return  $this->where( 'branch_id', $branchId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
    }

    /**
     *获取商户投诉列表数
     */
    public function getBranchComplaintsCnt( $branchId ){
         return  $this->where( 'branch_id', $branchId )->count;
    } 
}