<?php
/**
 * @file    Detail.php
 * @des     获取活动详情
 * @author  caowei
 *
 */
class DetailAction extends DWDData_Action
{
    protected $_isCheckAuth            = false;  

    public function _exec()
    { 
        $campaignBranchId              = $this->getRequest()->getParam('campaignBranchId');
        $enabled                       = $this->getRequest()->getParam("enabled");
        $m_campaignbranch              = new CampaignBranchModel;
        $data                          = $m_campaignbranch->getCampaignBranch( $campaignBranchId );
 
        $this->renderSuccessJson( array( 'data' => $data ) );
    }
}