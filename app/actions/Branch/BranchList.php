<?php
/**
 * @file    BranchList.php
 * @des     获取商户列表
 * @author  caowei
 *
 */
class BranchListAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    {
        
        $branchIds          = $this->getRequest()->getParam('branchIds');
 
        $res                = array();
         
    	$m_branch           = new BranchModel; 
    	$res                = $m_branch->getBranchs( $branchIds ); 
      
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}