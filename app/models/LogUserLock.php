<?php
/**
 * @name LogUserLockModel
 * @desc LogUserLockModel
 * @author cway
 */
class LogUserLockModel extends DWDData_Db {
  
    protected $dbTable           = 'log_user_lock';

    const  FILED_COMMON_TYPE     = 0;

    const LOCK_TYPE              = 1;

    protected $fieldTypes        = array(
                                       array( 'user_id', 'operator_user_id', 'type', 'reason_type' ,'lock_date', 'note' ,'create_at' ),
                                   );

    /**
     *获取用户封号记录
     */
    public function getUserLockedRecords( $userId, $option = array() ) {
    	 
         $res                 = array();
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->where( 'type', self::LOCK_TYPE )->where( 'user_id', $userId )->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->where( 'type', self::LOCK_TYPE )->where( 'user_id', $userId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
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
         return  $this->where( 'type', self::LOCK_TYPE )->where( 'user_id', $userId )->count();
    } 

    /**
     *添加用户封号/解封记录
     */
    public function addLockRecord( $lockInfo ) { 
 
         $this->user_id           = $lockInfo['user_id'];
         $this->operator_user_id  = $lockInfo['op_user_id'];
         $this->type              = $lockInfo['type'];
         $this->lock_date         = $lockInfo['lock_date'];
         $this->note              = $lockInfo['note'];
         $this->create_at         = date('Y-m-d H:i:s');
         $this->reason_type       = $lockInfo['reason_type'];
         return  $this->insert();
    }
}