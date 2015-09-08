<?php
/**
 * @file    NearList.php
 * @des     获取门店信息
 * @author  caowei
 *
 */
class NearListAction extends DWDData_Action
{
    protected $_isCheckAuth            = false; 

    public function _exec()
    { 
        $lat                           = $this->getRequest()->getParam('lat');
        $lng                           = $this->getRequest()->getParam('lng');
        $zoneId                        = $this->getRequest()->getParam('zoneId');
        $categoryId                    = $this->getRequest()->getParam('categoryId');

        $conditions                    =  array( 'loc'        => array( 
                                                                    '$near' => array(
                                                                                  $lat,
                                                                                  $lng,
                                                                               )
                                                                 ),
                                                'update_time' => array(
                                                                   '$gt'    => strtotime( date("Y-m-d 00:00:00") ),
                                                                 ),
                                          );
                                         
        if( $categoryId != null ){
            $conditions['categories']  = $categoryId;
        }

        if( $zoneId != null ){
            $conditions['zone_id']     = $zoneId;
        }

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