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
        $enabled            = $this->getRequest()->getParam("enabled");
        $sort               = $this->getRequest()->getParam("sort");
        $sortType           = $this->getRequest()->getParam("sortType");

        $conditions         = array(); 
        
        if( null != $enabled ){
        	$conditions[]   = array(
        						'field'	 => 'enabled',
        						'value'  => $enabled == DWDData_Const::DISABLED ? DWDData_Const::DISABLED : DWDData_Const::ENABLED,
        						'op'	 => '=', 
        					  );
        }

        if( null != $sort ){
        	$conditions[]   = array(
        						'field'	 => $sort,
        						'type'   => $sortType == DWDData_Const::ORDER_BY_ASC_ID ? DWDData_Const::ORDER_BY_ASC : DWDData_Const::ORDER_BY_DESC,
        						'op'	 => 'order by', 
        					  ); 
        } 

        $options            = self::_initQueryOptions();
        $res                = $m_discovery->getDiscoveries( $conditions, $options );
               
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}