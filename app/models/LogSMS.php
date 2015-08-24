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
    	 
         $rowNums     = array( );
         $rowNums[0]  = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->startPage;
         $rowNums[1]  = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
 
         return  $this->where( 'mobile', $mobile )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
    }

    /**
     *获取用户短信数
     */
    public function getUserSMSCnt( $mobile ){
         return  $this->where( 'mobile', $mobile )->count();
    } 
}