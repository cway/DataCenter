<?php
/**
 * @name BranchModel
 * @desc BranchModel
 * @author cway
 */
class BranchModel extends DWDData_Db { 

    protected $dbTable           = 'branch';

    protected $fieldTypes        = array( 
    					               array( 'id', 'name', 'address', 'zone_id', 'redeem_type', 'redeem_time' ,'brand_id', 'lat', 'lng', 'tel', 'maintainer_id' ,'saler_id', 'created_at', 'updated_at' ),
                                   );
    protected $dbFields          = array(
                                     'id'          => array( 'int', 'required' ),
                                     'name'        => array( 'text' ),
                                     'address'     => array( 'text' ),
                                     'redeem_type' => array( 'int' ),
                                     'redeem_time' => array( 'text' ),
                                     'lat'         => array(  ),
                                     'lng'         => array(  ),
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
        $branch['updated_at']    = date('Y-m-d, H:i:s');
        return $this->update( $branch );
    }

    /**
     *更新门店信息
     */
    public function updateBranchInfo( $branchId, $updates ) {

        $branchInfo              = $this->byId( $branchId );
        $data                    = array(
                                     'id' => $branchId,
                                   );
        foreach( $this->dbFields as $key => $value ){
            if( isset( $updates[$key] ) ){
               $data[$key]       = $updates[$key];     
            } 
        }
        $data['updated_at']      = date('Y-m-d H:i:s');
        return $this->update( $data );
    }
}
