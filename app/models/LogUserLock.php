<?php
/**
 * @name LogUserLockModel
 * @desc LogUserLockModel
 * @author cway
 */
class LogUserLockModel extends DWDData_Db {
  
    protected $dbTable           = 'log_user_lock';

    const  FILED_COMMON_TYPE     = 0;

    protected $fieldTypes        = array(
                                       array( 'user_id', 'operator_user_id', 'type', 'lock_date', 'note' ,'create_at' ),
                                   );

    /**
     *获取用户封号记录
     */
    public function getUserLockedRecords( $userId, $option = array() ) {
    	 
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
     *获取用户封号记录数
     */
    public function getUserLockedRecordsCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count();
    } 
}