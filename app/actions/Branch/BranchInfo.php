<?php
/**
 * @file    BranchInfo.php
 * @des     获取商户详情
 * @author  caowei
 *
 */
class BranchInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $branchId           = $this->getRequest()->getParam('branchId');
        $redeemNumber       = $this->getRequest()->getParam('redeemNumber');
 
        $res                = array();
        if( false == empty( $branchId ) ){
        	$m_branch       = new BranchModel; 
        	$res            = $m_branch->getBranch( $branchId );
        }
        else if( false == empty( $redeemNumber ) ){

            $m_productOrder = new ProductOrderModel;
            $orderInfo      = $m_productOrder->getOrderByRedeemNumber( $redeemNumber );
          
            if( false == empty( $orderInfo ) ){
            	$m_campaignbranchHasBranches  = new CampaignbranchHasBranchesModel;
                $res        = $m_campaignbranchHasBranches->getBranchByCampaignBranchId( $orderInfo['campaign_branch_id'] );
            }
        }
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}