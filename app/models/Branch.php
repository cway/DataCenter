<?php
/**
 * @name BranchModel
 * @desc BranchModel
 * @author cway
 */
class BranchModel extends DWDData_Db { 

    protected $dbTable           = 'branch';

    protected $fieldTypes        = array( 
    					               array( 'id', 'name', 'address', 'zone_id', 'redeem_type', 'redeem_time' ,'brand_id', 'lat', 'lng', 'tel', 'maintainer_id' ,'saler_id', 'enabled','created_at', 'updated_at' ),
                                   );
    protected $dbFields          = array(
                                     'id'          => array( 'int', 'required' ),
                                     'name'        => array( 'text' ),
                                     'address'     => array( 'text' ),
                                     'redeem_type' => array(  ),
                                     'redeem_time' => array( 'text' ),
                                     'tel'         => array(  ),
                                     'lat'         => array(  ),
                                     'lng'         => array(  ),
                                     'enabled'     => array(  ),
                                     'updated_at'  => array(  ),
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
     * 获取门店信息
     */
    public function getBranchs( $branchIds, $option = array(), $fields = self::FILED_COMMON_TYPE )
    {
        if( false == is_array( $fields ) ){
            $fields              = intval( $fields );
            if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
                $fields          = self::FILED_COMMON_TYPE;
            }

            $fields              = $this->fieldTypes[$fields];
        }
        $rowNums          = array( ); 
        $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
        $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
 
        return $this->where( 'id', $branchIds, 'in' )->get( $rowNums, $fields );
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
                                     'id' =>$branchId,
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
