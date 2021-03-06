<?php
/**
 * @name CampaignBranchModel
 * @desc CampaignBranchModel
 * @author cway
 */
class CampaignBranchModel extends DWDData_Db {
  
    protected $dbTable                 = 'campaign_branch';
 	
    const FILED_ONLY_ID_TYPE           = 1; 

    protected $fieldTypes              = array(
					                        array( 'id', 'campaign_id', 'start_time', 'end_time', 'type', 'redeem_start_time', 'redeem_end_time', 'countdown_start_time', 'countdown_continue', 'start_price', 'floor_price', 'market_price', 'unlock_price', 'current_price', 'bargain_range', 'stock', '`left`', 'is_new', 'redeem_period', 'freeze_period', 'need_book',  'allow_take_out', 'refund_type', 'tips', 'like_count', 'week', 'enabled', 'created_at', 'updated_at' ),
				                            array( 'campaign_branch.id'),
                                         );
    protected $dbFields                = array( 'id', 'campaign_id', 'start_time', 'end_time', 'type', 'redeem_start_time', 'redeem_end_time', 'countdown_start_time', 'countdown_continue', 'start_price', 'floor_price', 'market_price', 'unlock_price', 'current_price', 'bargain_range', 'stock', 'left', 'is_new', 'redeem_period', 'freeze_period', 'need_book',  'allow_take_out', 'refund_type', 'tips', 'like_count', 'enabled', 'created_at', 'updated_at' );

    /**
     * 获取活动
     */
    public function getCampaignBranch( $campaignBranchId, $fields = self::FILED_COMMON_TYPE )
    {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}
 
        return  $this->byId( $campaignBranchId, $fields );
    }

 	/**
     *更新活动
     */
    public function updateCampaignBranch( $campaignBranch )
    {

        $campaignBranch['updated_at']  = date('Y-m-d, H:i:s');
        return $this->update( $campaignBranch );
    }

    /**
     *批量更新活动
     */
    public function updateCampaignBranchs( $conditions, $updates ){
        $updates['updated_at']  = date('Y-m-d, H:i:s');
        self::_initConditions( $conditions );
        return $this->getDB()->update( $this->dbTable, $updates );
    }

    /**
     * 获取活动
     */
    public function getCampaignBranchs( $campaignBranchIds, $option = array(), $fields = self::FILED_COMMON_TYPE )
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
 
        return $this->where( 'id', $campaignBranchIds, 'in' )->get( $rowNums, $fields );
    }

    /**
     * 根据条件获取活动
     */
    public function getCampaignBranchsByConditions( $conditions, $option = array(), $fields = self::FILED_COMMON_TYPE )
    {
        if( false == is_array( $fields ) ){
            $fields              = intval( $fields );
            if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
                $fields          = self::FILED_COMMON_TYPE;
            }

            $fields              = $this->fieldTypes[$fields];
        }
        
        return self::getListByConditions( $conditions, $option, $fields ); 
    }

    /**
     * 根据条件获取活动数量
     */
    public function getCampaignBranchsCntByConditions( $conditions, $option = array(), $fields = self::FILED_COMMON_TYPE )
    {
        if( false == is_array( $fields ) ){
            $fields              = intval( $fields );
            if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
                $fields          = self::FILED_COMMON_TYPE;
            }

            $fields              = $this->fieldTypes[$fields];
        }
        
        return self::getListCntByConditions( $conditions, $option, $fields ); 
    }
 
}
