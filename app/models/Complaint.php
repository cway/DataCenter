<?php
/**
 * @name ComplaintModel
 * @desc ComplaintModel
 * @author cway
 */
class ComplaintModel extends DWDData_Db {
  
    protected $dbTable           = 'complaint';

    const  FILED_COMMON_TYPE     = 0;

    const  MAX_RECORDS           = 100;

    protected $fieldTypes        = array(
                                       array( 'item_id', 'order_id', 'user_id', 'branch_id', 'saler_id', 'type_id', 'status', 'description', 'from_id', 'category_id', 'mobile', 'created_at', 'updated_at', 'resolved_at' ),
                                   );

    /**
     *获取用户投诉列表
     */
    public function getUserComplaints( $userId, $option = array() ) 
    {
    	 
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
    public function getUserComplaintsCnt( $userId )
    {
         return  $this->where( 'user_id', $userId )->count();
    }


    /**
     *获取商户投诉列表
     */
    public function getBranchComplaints( $branchId, $option = array() ) 
    {
         
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
    public function getBranchComplaintsCnt( $branchId )
    {
         return  $this->where( 'branch_id', $branchId )->count();
    } 

    /**
     * 获取订单处理记录
     */
    public function getOrderCamplaints( $orderId, $option = array())
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

    /**
     *添加投诉
     */
    public function addComplaint( $complaintInfo )
    {
        $this->item_id         = $complaintInfo['itemId'];
        $this->item_name       = $complaintInfo['itemName'];
        $this->order_id        = $complaintInfo['orderId']; 
        $this->branch_id       = $complaintInfo['branchId'];
        $this->branch_name     = $complaintInfo['branchName'];
        $this->saler_id        = $complaintInfo['salerId'];
        $this->type_id         = $complaintInfo['typeId'];
        $this->status          = $complaintInfo['status'];
        $this->description     = $complaintInfo['description'];
        $this->category_id     = $complaintInfo['categoryId'];
        $this->mobile          = $complaintInfo['mobile'];
        $this->updated_at      = date('Y-m-d H:i:s');
        $this->created_at      = date('Y-m-d H:i:s');
        $res =  $this->insert(); 
        
        return $res;
    }
}