<?php
/**
 * @name SalerModel
 * @desc SalerModel
 * @author cway
 */
class SalerModel extends DWDData_Db {
  
    protected $dbTable           = 'saler'; 

    protected $fieldTypes        = array( 
    					               array( 'id', 'zone_id', 'leader_id', 'account_id', 'name',  'enabled', 'is_agent', 'created_at' ),
                                   );

    /**
     *获取区域信息
     */
    public function getSaler( $salerId, $fields = self::FILED_COMMON_TYPE ) {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}

        return  $this->byId( $salerId, $fields );
    }  
}
