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
        $conditions                    = array(
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
 
        $mongo                         =  MongoObject::getInstance();
        $collection                    =  $mongo->getCollection('online_campaigns');
        $options                       =  self::_initQueryOptions();
        $options['sort']               =  'd_weight';
        $options['sortType']           =  DWDData_Const::ORDER_BY_DESC_ID;        
        $campaignBranchs               =  $mongo->find(  $conditions, $options );
        $totalCnt                      =  $mongo->count( $conditions );
        $totalPage                     =  ceil( $totalCnt / $options['limit'] ); 

        $res                           =  array(
                                              'list'      => array(),
                                              'ids'       => array(),
                                              'totalCnt'  => $totalCnt,
                                              'totalPage' => $totalPage,
                                          );

        foreach( $campaignBranchs as $campaignBranch  ){
            unset( $campaignBranch['_id'] );
            $res['list'][]             = $campaignBranch;
            $res['ids'][]              = $campaignBranch['id'];
        }

        $mongo->close();

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}