<?php
/**
 * @name LogUserLockModel
 * @desc LogUserLockModel
 * @author cway
 */
class LogUserDeviceUnbundModel extends DWDData_Db {
  
    protected $dbTable           = 'log_user_device_unbund';

    const  FILED_COMMON_TYPE     = 0;

    protected $fieldTypes        = array(
                                       array( 'user_id', 'udid', 'os', 'app_version', 'created_at', 'updated_at' ),
                                   );

    /**
     *添加用户解绑记录
     */
    public function addUnbindRecord( $unbindInfo ) {
    	 
         return  $this->insert( $unbindInfo );
    }
}