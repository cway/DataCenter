<?php
/**
 * @name BrandModel
 * @desc BrandModel
 * @author cway
 */
class BrandModel extends DWDData_Db {
  
    protected $dbTable           = 'brand'; 

    protected $fieldTypes        = array( 
    					               array( 'id', 'name', 'company_name', 'description', 'address', 'tel', 'enabled', 'logo', 'created_at' ),
                                   );

    /**
     *获取品牌信息
     */
    public function getBrand( $branchId, $fields = self::FILED_COMMON_TYPE ) {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}

        return  $this->byId( $branchId, $fields );
    } 
    /**
     *更新品牌信息
     */
    public function updateBrand( $brand ) {
        return $this->update( $brand );
    }

    /**
     *更新品牌信息
     */
    public function updateBrandInfo( $brandId, $updates ) {

        $brand                  = $this->byId( $brandId );
        foreach( $updates as $key => $value ){
            $brand[$key]        = $value;
        }

        return $this->updateBrand( $brand );
    }
}
