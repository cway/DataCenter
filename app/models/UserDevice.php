<?php
/**
 * @name LogUserLockModel
 * @desc LogUserLockModel
 * @author cway
 */
class UserDeviceModel extends DWDData_Db {
  
    protected $dbTable           = 'user_device';

    const  FILED_COMMON_TYPE     = 0;

    protected $fieldTypes        = array(
                                       array( 'id', 'user_id', 'udid', 'os', 'app_version', 'created_at', 'updated_at' ),
                                   );

    /**
     *获取用户设备
     */
    public function getUserDevices( $userId, $option = array() ) 
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
     *获取用户设备数
     */
    public function getUserDevicesCnt( $userId )
    {
         return  $this->where( 'user_id', $userId )->count();
    }

    /**
     *解绑用户设备
     */
    public function unBindDevice( $userId )
    {

        $deviceInfo   = $this->where( 'user_id', $userId )->getOne( $this->fieldTypes[self::FILED_COMMON_TYPE] );

        if( empty( $deviceInfo ) ){
            return false;
        }

        $condition    = array(
                          'id' => $deviceInfo['id'],
                        );  
        $res          = $this->where( 'user_id', $userId )->delete();
        return  $res == true ? $deviceInfo : false;
    }
}