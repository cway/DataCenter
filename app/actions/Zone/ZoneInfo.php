<?php
/**
 * @file    ZoneInfo.php
 * @des     获取区域详情
 * @author  caowei
 *
 */
class ZoneInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $zoneId           = $this->getRequest()->getParam('zoneId');
        $m_zone           = new ZoneModel; 
        $res              = $m_zone->getZone( $zoneId );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}