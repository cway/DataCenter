<?php
/**
 * @file    BranchList.php
 * @des     获取门店信息
 * @author  caowei
 *
 */
class BranchListAction extends DWDData_Action
{
    protected $_isCheckAuth           = false; 

    public function _exec()
    { 
        $campaignBranchIds            = $this->getRequest()->getParam('campaignBranchIds');
        $m_campaignbranchHasBranches  = new CampaignbranchHasBranchesModel;
        $data                         = $m_campaignbranchHasBranches->getBranchsByCampaignBranchIds( $campaignBranchIds );
        
        $branchs                      = array( 
                                           'list' => array(),
                                        );

        foreach ($data['list'] as $branchInfo) {
            $campaignBranchId         = $branchInfo['campaignbranch_id'];
            unset( $branchInfo['campaignbranch_id'] );
            unset( $branchInfo['branch_id'] );
            $branchs['list'][$campaignBranchId]  = $branchInfo;
        }

        $this->renderSuccessJson( array( 'data' => $branchs ) );
    }
}