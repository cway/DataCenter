<?php
/**
 * @file    TopList.php
 * @des     获取置顶活动信息
 * @author  caowei
 */
class TopListAction extends DWDData_Action
{
    protected $_isCheckAuth            = false; 

    public function _exec()
    { 
        $zoneId                        = $this->getRequest()->getParam('zoneId');
        $conditions                    = array(
                                            'zone_id'  => intval( $zoneId ),
                                            'weight'   => array(
                                                            '$gt'   => 0,
                                                          ),
                                         );
 
        $mongo                         =  MongoObject::getInstance();
        $collection                    =  $mongo->getCollection('online_campaigns');
        $options                       =  self::_initQueryOptions();
       
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