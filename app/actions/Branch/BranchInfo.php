<?php
/**
 * @file    BranchInfo.php
 * @des     获取商户详情
 * @author  caowei
 *
 */
class BranchInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $branchId          = $this->getRequest()->getParam('branchId');
        $m_branch          = new BranchModel; 
        $res               = $m_branch->getBranch( $branchId );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}