<?php
/**
 * @file    SalerInfo.php
 * @des     获取销售详情
 * @author  caowei
 *
 */
class SalerInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $salerId           = $this->getRequest()->getParam('salerId');
        $m_saler           = new SalerModel; 
        $res               = $m_saler->getSaler( $salerId );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}