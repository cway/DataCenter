<?php
/**
 * @file    DiscoveryList.php
 * @des     获取发现列表
 * @author  caowei
 */
class DiscoveryListAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    { 
        $m_discovery        = new DiscoveryModel;
        $options            = self::_initQueryOptions();
        $res                = $m_discovery->getDiscoveries( $options );
               
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}