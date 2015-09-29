<?php
/**
 * @file    RedeemTel.php
 * @des     获取商户封号信息
 * @author  caowei
 *
 */
class RedeemTelAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        $branchId          = $this->getRequest()->getParam('branchId');
        $m_branchContacter = new BranchContacterModel; 
        $res               = $m_branchContacter->getBranchContacter( $branchId );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}