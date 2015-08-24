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
     *获取用户投诉列表数
     */
    public function getUserComplaintsCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count();
    }


    /**
     *获取商户投诉列表
     */
    public function getBranchComplaints( $branchId, $option = array() ) {
         
         $res                 = array();
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->where( 'branch_id', $branchId )->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->where( 'branch_id', $branchId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
         }
        
         if( null == $res['list'] ){
            $res['list']      = array();
         }
         
         return $res;
    }

    /**
     *获取商户投诉列表数
     */
    public function getBranchComplaintsCnt( $branchId ){
         return  $this->where( 'branch_id', $branchId )->count();
    } 
}