<?php
/**
 * @file    Offline.php
 * @des     活动下线
 * @author  caowei
 *
 */
class OfflineAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    const OFFLINE_STATUS       = 0;
    const TAKEN_STATUS         = 1;

    private function _singleCampaignbranchOfflice( $campaignBranchId ){
        $m_campaignBranch      = new CampaignBranchModel;

        $campaignBranch        = $m_campaignBranch->getCampaignBranch( $campaignBranchId );
        if( empty( $campaignBranch ) ){
          $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::CAMPAIGN_BRANCH_NOT_FOUND, 'errmsg' => DWDData_ErrorCode::CAMPAIGN_BRANCH_NOT_FOUND_MSG ) );
            return ;
        }

        $m_campaignBranch->startTransaction();

        $updates               = array(
                                  'id'    => $campaignBranchId,
                                  'enabled' => self::OFFLINE_STATUS,
                                 );
        $res                   = $m_campaignBranch->updateCampaignBranch( $updates );

        if( false == $res ){
          $m_campaignBranch->rollback();
          $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED, 'errmsg' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED_MSG ) );
            return ;
        }

        $campaignBranch['enabled'] = self::OFFLINE_STATUS;
        $m_shakePoolModel          = new ShakePoolModel();
        $conditions                = array(
                                        array(
                                           'field'  => 'campaign_branch_id',
                                           'value'  =>  $campaignBranchId,
                                           'op'     => '=',
                                        ),
                                        array(  
                                           'field'  => 'is_taken',
                                           'value'  =>  self::TAKEN_STATUS,
                                           'op'     => '!=',  
                                        )
                                     );
        $updates                   = array(
                                       'is_taken'   =>  self::TAKEN_STATUS,
                                     );
        $res                       = $m_shakePoolModel->updateShakeInfos( $conditions, $updates );
        if( false == $res ){
          $m_campaignBranch->rollback();
          $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED, 'errmsg' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED_MSG ) );
            return ;
        }

        $m_campaignBranch->commit();
        $this->renderSuccessJson( array( 'data' => 'success' ) ); 
    }

    private function _multiCampaignbranchOfflice( $campaignBranchIds )
    {
        $m_campaignBranch      = new CampaignBranchModel;

        $m_campaignBranch->startTransaction();

        $conditions            = array(
                                     array(
                                           'field'   => 'id',
                                           'values'  =>  $campaignBranchIds,
                                           'op'      => 'IN',
                                        ),
                                 );

        $updates               = array( 
                                  'enabled' => self::OFFLINE_STATUS,
                                 );
        $res                   = $m_campaignBranch->updateCampaignBranchs( $conditions, $updates );

        if( false == $res ){
          $m_campaignBranch->rollback();
          $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED, 'errmsg' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED_MSG ) );
            return ;
        }

        $m_shakePoolModel          = new ShakePoolModel();
        $conditions                = array(
                                        array(
                                           'field'   => 'campaign_branch_id',
                                           'values'  =>  $campaignBranchIds,
                                           'op'      => 'IN',
                                        ),
                                        array(  
                                           'field'   => 'is_taken',
                                           'value'   =>  self::TAKEN_STATUS,
                                           'op'      => '!=',  
                                        )
                                     );
        $updates                   = array(
                                       'is_taken'   =>  self::TAKEN_STATUS,
                                     );
        $res                       = $m_shakePoolModel->updateShakeInfos( $conditions, $updates );
        if( false == $res ){
          $m_campaignBranch->rollback();
          $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED, 'errmsg' => DWDData_ErrorCode::CAMPAIGN_BRANCH_OFFLINE_FAILED_MSG ) );
          return ;
        }

        $m_campaignBranch->commit();
        $this->renderSuccessJson( array( 'data' => 'success' ) ); 
    }

    public function _exec()
    { 
        $campaignBranchId                = $this->getRequest()->getParam('campaignBranchId');
        $branchId                        = $this->getRequest()->getParam('branchId');

        if( false == empty( $campaignBranchId ) ){
            $this->_singleCampaignbranchOfflice( $campaignBranchId );
        } else if( false == empty( $branchId ) ){
            $m_CampaignbranchHasBranches = new CampaignbranchHasBranchesModel();
            $branchs                     = $m_CampaignbranchHasBranches->getCampaignBranchIdsByBranch( $branchId );
            $campaignBranchIds           = array();

            foreach( $branchs as $branch ){
                $campaignBranchIds[]     = $branch['campaignbranch_id'];
            }
            $this->_multiCampaignbranchOfflice( $campaignBranchIds );
        }
    }
}