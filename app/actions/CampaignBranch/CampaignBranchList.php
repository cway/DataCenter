<?php
/**
 * @file    CampaignBranchList.php
 * @des     获取门店信息
 * @author  caowei
 *
 */
class CampaignBranchListAction extends DWDData_Action
{
    protected $_isCheckAuth            = false; 

    public function _exec()
    { 
        $campaignBranchIds             = $this->getRequest()->getParam('campaignBranchIds');
        $m_campaignbranch              = new CampaignBranchModel;
        $options                       = self::_initQueryOptions();
        $data                          = $m_campaignbranch->getCampaignBranchs( $campaignBranchIds, $options );
        
        $campaignBranchs               = array( 
        									'list' => array(),
        								 );

        foreach ($data as $campaignBranchInfo) {
        	$campaignBranchs['list'][$campaignBranchInfo['id']] = $campaignBranchInfo;
        }

        $this->renderSuccessJson( array( 'data' => $campaignBranchs ) );
    }
}