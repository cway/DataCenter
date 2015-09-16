<?php
/**
 * @file    ZoneList.php
 * @des     获取城市列表
 * @author  caowei
 *
 */
class ZoneListAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $active           = $this->getRequest()->getParam('active', false);
        $m_zone           = new ZoneModel; 
        $zoneList         = $m_zone->getAll( $active );
        $res  			  = array(
        						'list' => $zoneList,
        					);
        
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}