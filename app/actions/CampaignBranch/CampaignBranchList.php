<?php
/**
 * @file    CampaignBranchList.php
 * @des     获取活动信息
 * @author  caowei
 *
 */
class CampaignBranchListAction extends DWDData_Action
{
    protected $_isCheckAuth            = false;  

    public function _exec()
    { 
        $campaignBranchIds             = $this->getRequest()->getParam('campaignBranchIds');
        $enabled                       = $this->getRequest()->getParam("enabled");
        $m_campaignbranch              = new CampaignBranchModel;
        $options                       = self::_initQueryOptions();
        $data                          = $m_campaignbranch->getCampaignBranchs( $campaignBranchIds, $options );
        
        $campaignBranchs               = array( 
        									'list' => array(),
        								 );

        foreach ($data as $campaignBranchInfo) { 

            if( DWDData_Const::ENABLED == $enabled  ){
        	    if($campaignBranchInfo['enabled'] == DWDData_Const::ENABLED ){
                    $campaignBranchs['list'][$campaignBranchInfo['id']] = $campaignBranchInfo;
                }
            }
        }

        $this->renderSuccessJson( array( 'data' => $campaignBranchs ) );
    }
}