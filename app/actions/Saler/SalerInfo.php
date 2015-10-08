<?php
/**
 * @file    SalerInfo.php
 * @des     获取销售详情
 * @author  caowei
 *
 */
class SalerInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    			       = false;

    public function _exec()
    {
        
        $salerId                               = $this->getRequest()->getParam('salerId');
        $campaignBranchId                      = $this->getRequest()->getParam('campaignBranchId');
        $branchId                              = $this->getRequest()->getParam('branchId');
        $orderId                               = $this->getRequest()->getParam('orderId');

        if( false == empty( $salerId ) ){
        }
        else if( false == empty( $campaignBranchId ) ){
        	$m_CampaignbranchHasBranches       = new CampaignbranchHasBranchesModel();
        	$campaignBranchInfo                = $m_CampaignbranchHasBranches->getBranchByCampaignBranchId( $campaignBranchId );
        	$salerId					       = $campaignBranchInfo['saler_id'];
        } else if( false == empty( $branchId ) ){
            $m_Branch                          = new BranchModel();
            $branchInfo                        = $m_Branch->getBranch( $branchId );
            $salerId                           = $branchInfo['saler_id'];
        } else if( false == empty( $orderId ) ){
            $m_productOrder                    = new ProductOrderModel();
            $orderInfo                         = $m_productOrder->getOrder( $orderId );
            if( $orderInfo ){
                $campaignBranchId              = $orderInfo['campaign_branch_id'];
                $m_CampaignbranchHasBranches   = new CampaignbranchHasBranchesModel();
                $campaignBranchInfo            = $m_CampaignbranchHasBranches->getBranchByCampaignBranchId( $campaignBranchId );
                $salerId                       = $campaignBranchInfo['saler_id'];
            }
        }

        $m_saler                               = new SalerModel; 
        $res                                   = $m_saler->getSaler( $salerId );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}