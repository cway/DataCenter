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
                                       array( 'user_id', 'udid', 'os', 'app_version', 'created_at', 'updated_at' ),
                                   );

    /**
     *获取用户设备
     */
    public function getUserDevices( $userId, $option = array() ) {
    	 
         $rowNums     = array( );
         $rowNums[0]  = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->startPage;
         $rowNums[1]  = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
 
         return  $this->where( 'user_id', $userId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
    }

    /**
     *获取用户设备数
     */
    public function getUserDevicesCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count;
    }

    /**
     *解绑用户设备
     */
    public function unBindDevice( $userId, $udid ){

        $condition    = array(
                          'user_id' => $userId,
                          'udid'    => $udid,
                        );
        $deviceInfo   = $this->where( $condition )->getOne();
        $condition    = array(
                          'id' => $deviceInfo['id'],
                        );  
        $this->where( $condition )->delete();
        return   $deviceInfo;
    }
}