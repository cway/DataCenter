<?php
/**
 * @name CampaignbranchHasBranchesModel
 * @desc CampaignbranchHasBranchesModel
 * @author cway
 */
class CampaignbranchHasBranchesModel extends DWDData_Db {
  
    protected $dbTable           = 'campaignbranch_has_branches'; 

    protected $primaryKey        = 'campaignbranch_id';

    /**
     * 根据活动id获取门店信息
     */
    public function getBranchByCampaignBranchId( $campaignBranchId ){
        $conditions = array( 
                             array(
                                 'modelName'  => 'BranchModel',
                                 'joinKey'    => 'branch_id',
                                 'joinType'   => 'RIGHT',
                                 'op'         => 'join',
                             ),
                             array(
                                 'field'      => 'campaignbranch_has_branches.campaignbranch_id',
                                 'value'      =>  $campaignBranchId,
                                 'op'         => '=',
                             ),
                      ); 
        $m_banner      = new BannerModel;
        $fields        = $m_banner->fieldTypes[BannerModel::FILED_COMMON_TYPE];
        $option        = array();
        $branchs       = self::getListByConditions( $conditions, $option, $fields );
        $brachInfo     = array();
   		if( !empty( $branchs['list'] ) ){
   			$brachInfo = $branchs['list'][0];
   		}

   		return $brachInfo;
    }

    /**
     * 根据活动id批量获取门店信息
     */
    public function getBranchsByCampaignBranchIds( $campaignBranchIds ){

        $conditions = array( 
                             array(
                                 'modelName'  => 'BranchModel',
                                 'joinKey'    => 'branch_id',
                                 'joinType'   => 'LEFT',
                                 'op'         => 'join',
                             ),
                             array(
                                 'field'      => 'campaignbranch_has_branches.campaignbranch_id',
                                 'values'     =>  $campaignBranchIds,
                                 'op'         => 'in',
                             ),
                      ); 
        $m_banner      = new BannerModel;
        $fields        = $m_banner->fieldTypes[BannerModel::FILED_COMMON_TYPE];
        $option        = array();

        $res = self::getListByConditions( $conditions, $option, $fields );
        
      
        return $res;
    }
 
}
