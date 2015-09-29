<?php
/**
 * @file    CampaignBranchList.php
 * @des     获取商户活动列表
 * @author  caowei
 *
 */
class CampaignBranchListAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        $branchId              = $this->getRequest()->getParam('branchId');
    	$conditions            = array(
    								 array(
    								 	 'modelName'  => 'CampaignbranchHasBranchesModel',
    							     	 'joinKey'    => 'id',
    							     	 'joinType'   => 'INNER',
    							     	 'op'	      => 'join',
    								 ),
    								 array(
    							     	 'field'      => 'campaignbranch_has_branches.branch_id',
    							     	 'value'      =>  $branchId,
    							     	 'op'	      => '=',
    							     ),
    							     array(
    							     	 'field'      => 'enabled',
    							     	 'value'      => 1,
    							     	 'op'	      => '=',
    							     ),
    							  );

        $m_campaignBranch      = new CampaignBranchModel; 
        $options               = self::_initQueryOptions();
        $res                   = $m_campaignBranch->getBranchCampaigns( $conditions, $options);

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}