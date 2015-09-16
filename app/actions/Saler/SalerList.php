<?php
/**
 * @file    SalerList.php
 * @des     获取销售列表
 * @author  caowei
 *
 */
class SalerListAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $active            = $this->getRequest()->getParam('active', false);
        $m_saler           = new SalerModel; 
        $salerList         = $m_saler->getAll( $active );
        $res  			   = array(
        						'list' => $salerList,
        					 );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}