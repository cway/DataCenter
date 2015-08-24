<?php
/**
 * @name LogUserLockModel
 * @desc LogUserLockModel
 * @author cway
 */
class LogSMSModel extends DWDData_Db {
  
    protected $dbTable           = 'log_sms';

    const  FILED_COMMON_TYPE     = 0;

    protected $fieldTypes        = array(
                                       array( 'type', 'content', 'mobile', 'create_at' ),
                                   );

    /**
     *获取用户短信
     */
    public function getUserSMS( $mobile, $option = array() ) {
    	 
         $res                 = array();
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->where( 'mobile', $mobile )->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->where( 'mobile', $mobile )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
         }
        
         if( null == $res['list'] ){
            $res['list']      = array();
         }
         
         return $res;  
    }

    /**
     *获取用户短信数
     */
    public function getUserSMSCnt( $mobile ){
         return  $this->where( 'mobile', $mobile )->count();
    } 
}