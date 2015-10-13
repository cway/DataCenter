<?php
/**
 * @name CampaignModel
 * @desc CampaignModel
 * @author cway
 */
class CampaignModel extends DWDData_Db {
  
    protected $dbTable           = 'campaign';

    const FILED_COMMON_TYPE      = 0;

    protected $fieldTypes        = array( 
                                      array( 'id', 'brand_id', 'campaign_ad_id', 'item_id', 'type' ),
                                   );
 
    /**
     *获取单品信息
     */
    public function getCampaign( $campaignId, $fields = self::FILED_COMMON_TYPE ) 
    {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}

        return  $this->byId( $campaignId, $fields );
    }
}
