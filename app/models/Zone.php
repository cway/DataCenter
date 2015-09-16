<?php
/**
 * @name ZoneModel
 * @desc ZoneModel
 * @author cway
 */
class ZoneModel extends DWDData_Db {
  
    protected $dbTable           = 'zone'; 

    protected $fieldTypes        = array( 
    					               array( 'id', 'name', 'address', 'lng', 'lat', 'weight', 'enabled', 'countdown_enabled', 'baidu_city_id', 'amap_city_id' ),
                                   );

    /**
     *获取区域信息
     */
    public function getZone( $zoneId, $fields = self::FILED_COMMON_TYPE ) {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}

        return  $this->byId( $zoneId, $fields );
    }


    /**
     * 获取城市列表
     */
    public function getAll( $enabled = true ){

        if( $enabled ){
            return $this->where('enabled', DWDData_Const::ACTIVE)->get();
        }

        return $this->get();
    }
}
