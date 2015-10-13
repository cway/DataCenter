
<?php
/**
 * @file    ItemInfo.php
 * @des     获取活动单品详情
 * @author  caowei
 *
 */
class ItemInfoAction extends DWDData_Action
{
    protected $_isCheckAuth            = false;  

    public function _exec()
    { 
        $campaignBranchId              = $this->getRequest()->getParam('campaignBranchId');

        $m_campaignBranch              = new CampaignBranchModel;
        $campaignBranch                = $m_campaignBranch->getCampaignBranch( $campaignBranchId );

        if(  empty( $campaignBranch ) ){
        	$this->renderSuccessJson( array( 'data' => array() ) );
        	return ;
        }

        $campaignId                    = $campaignBranch['campaign_id'];
        $m_campaign                    = new CampaignModel;
        $campaign 					   = $m_campaign->getCampaign( $campaignId );

   		if(  empty( $campaign ) ){
        	$this->renderSuccessJson( array( 'data' => array() ) );
        	return ;
        }     

        $itemId 					   = $campaign['item_id'];                     
        $m_item                        = new ItemModel;
        $categories                    = $m_item->getItemInfo( $itemId );
 
        $this->renderSuccessJson( array( 'data' => $categories ) );
    }
}