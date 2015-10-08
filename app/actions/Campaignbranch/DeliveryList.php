<?php
/**
 * @file    DeliveryList.php
 * @des     获取快递到家列表
 * @author  caowei
 */
class DeliveryListAction extends DWDData_Action
{
    protected $_isCheckAuth            = false; 

    public function _exec()
    { 
        $zoneId                        = $this->getRequest()->getParam('zoneId');
        $sort                          = $this->getRequest()->getParam('sort', 'd_weight');
        $sortType                      = $this->getRequest()->getParam('sortType', DWDData_Const::ORDER_BY_DESC_ID);
         
 
        $mongo                         =  MongoObject::getInstance();
        $collection                    =  $mongo->getCollection('online_campaigns');
        $options                       =  self::_initQueryOptions();
        $options['sort']               =  $sort;
        $options['sortType']           =  $sortType;   

        $campaignBranchs               =  array();
        $totalCnt                      =  0;
        $totalPage                     =  0;
        $res                           =  array(
                                              'list'      => array(),
                                              'ids'       => array(),
                                          );

        if( $options['sort'] == 'd_weight' ){
          $conditions                  =  array(
                                            'zone_id'         => intval( $zoneId ),
                                            '$or'             => array(
                                                                     array(
                                                                        'delivery_type'  => 2,
                                                                      ),
                                                                      array(
                                                                        'delivery_type'  => 3,
                                                                      ),  
                                                                 ), 
                                          );
          $campaignBranchs             =  $mongo->find(  $conditions, $options );
          $totalCnt                    =  $mongo->count( $conditions );
          foreach( $campaignBranchs as $campaignBranch  ){
              unset( $campaignBranch['_id'] );
              $res['list'][]           =  $campaignBranch;
              $res['ids'][]            =  $campaignBranch['id'];
          }
        } else {
          $conditions                  =  array( 
                                              array(
                                                   'field'      => $sort,
                                                   'type'       => intval( $sortType ) == DWDData_Const::ORDER_BY_ASC_ID ? DWDData_Const::ORDER_BY_ASC : DWDData_Const::ORDER_BY_DESC,
                                                   'op'         => 'order by', 
                                              ), 
                                              array(
                                                   'joinTable'  => 'campaignbranch_has_branches',
                                                   'joinLKey'   => 'campaignbranch_has_branches.campaignbranch_id',
                                                   'joinRKey'   => 'campaign_branch.id',
                                                   'joinType'   => 'INNER',
                                                   'op'         => 'custom_join',
                                              ),
                                              array(
                                                   'joinTable'  => 'branch',
                                                   'joinLKey'   => 'branch.id',
                                                   'joinRKey'   => 'campaignbranch_has_branches.branch_id',
                                                   'joinType'   => 'INNER',
                                                   'op'         => 'custom_join',
                                              ),
                                              array(
                                                   'field'      => 'branch.zone_id',
                                                   'value'      => intval( $zoneId ),
                                                   'op'         => '=',
                                              ),
                                              array(
                                                   'field'      => 'campaign_branch.enabled',
                                                   'value'      => DWDData_Const::ENABLED,
                                                   'op'         => '=',
                                              ),
                                              array(
                                                   'field'      => 'delivery_type',
                                                   'values'     => array( 2, 3 ), //快递到家类型
                                                   'op'         => 'in', 
                                              ),
                                          );

          $m_campaignBranch            = new CampaignBranchModel;  
          $campaignBranchs             = $m_campaignBranch->getCampaignBranchsByConditions( $conditions, $options, CampaignBranchModel::FILED_ONLY_ID_TYPE);
          $campaignBranchs             = $campaignBranchs['list'];
          $totalCnt                    = $m_campaignBranch->getCampaignBranchsCntByConditions( $conditions, $options, CampaignBranchModel::FILED_ONLY_ID_TYPE);
          foreach ($campaignBranchs as $campaignBranch) {
              $res['ids'][]            =  $campaignBranch['id'];
          } 

          if( !empty( $res['ids'] ) ){
            $campaignBranchs           =  $mongo->find( array('id' => array( '$in' => $res['ids'] ) ) );
            $campaignBranchs           =  iterator_to_array( $campaignBranchs );
            foreach( $res['ids'] as $campaignBranchId ){
                foreach ($campaignBranchs as $key => $campaignBranch) {
                    if( $campaignBranch['id'] == $campaignBranchId ){
                        unset( $campaignBranch['_id'] );
                        $res['list'][] =  $campaignBranch;
                        unset( $campaignBranchs[$key] );
                        break;
                    }
                }
            }
          }
          
        }

        $mongo->close();
        $totalPage                     =  ceil( $totalCnt / $options['limit'] ); 
        $res['totalCnt']               =  $totalCnt;
        $res['totalPage']              =  $totalPage;

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}