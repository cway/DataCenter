<?php
/**
 * @name BranchModel
 * @desc BranchModel
 * @author cway
 */
class BranchModel extends DWDData_Db {
  
    protected $dbTable           = 'branch'; 

    protected $fieldTypes        = array( 
    					               array( 'id', 'name', 'address', 'zone_id', 'redeem_type' ,'brand_id', 'lat', 'lng', 'tel', 'maintainer_id' ,'saler_id', 'created_at', 'updated_at' ),
                                   );

    /**
     *获取门店信息
     */
    public function getBranch( $branchId, $fields = self::FILED_COMMON_TYPE ) {
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
     *更新门店信息
     */
    public function updateBranch( $branch ) {
        return $this->update( $branch );
    }

    /**
     *更新用户信息
     */
    public function updateBranchInfo( $branchId, $updates ) {

        $branch                  = $this->byId( $branchId );
        foreach( $updates as $key => $value ){
            $branch[$key]        = $value;
        }

        return $this->updateBranch( $branch );
    }
}
