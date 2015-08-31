<?php
/**
 * @name ShakePoolModel
 * @desc ShakePoolModel
 * @author cway
 */
class ShakePoolModel extends DWDData_Db {
  
    protected $dbTable           = 'shake_pool'; 

    protected $fieldTypes        = array( 
    					               array( 'id', 'branch_id', 'user_id', 'campaign_branch_id', 'batch_id',  'locked_at', 'created_at', 'is_taken' ),
                                   );
    protected $dbFields          = array( 'id', 'branch_id', 'user_id', 'campaign_branch_id', 'batch_id',  'locked_at', 'created_at', 'is_taken' );

    /**
     *更新奖池信息
     */
    public function updateShakeInfos( $conditions,  $shakeInfo ) {
    	 
        $this->_initConditions( $conditions ); 
        $shakeInfos['updated_at']     = date('Y-m-d H:i:s');

        return  $this->getDB()->update( $this->dbTable, $shakeInfo );
    }  
}
