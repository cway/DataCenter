<?php
/**
 * @name LogUserLockModel
 * @desc LogUserLockModel
 * @author cway
 */
class LogUserDeviceUnbundModel extends DWDData_Db {
  
    protected $dbTable           = 'log_user_device_unbund'; 

    /**
     *添加用户解绑记录
     */
    public function addUnbindRecord( $unbindInfo ) {
    	  
         $this->user_id         = $unbindInfo['user_id'];
         $this->op_user_id      = $unbindInfo['op_user_id'];
         $this->udid            = $unbindInfo['udid'];
         $this->reasonType      = $unbindInfo['reasonType'];
         $this->remark_json     = $unbindInfo['remark_json'];
         $this->remark          = $unbindInfo['remark'];
         $this->created_at      = date('Y-m-d H:i:s');
         return  $this->insert();
    }
}