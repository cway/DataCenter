<?php
/**
 * @file    AccountInfo.php
 * @des     帐号信息
 * @author  caowei
 *
 */
class AccountInfoAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
       $branchId           = $this->getRequest()->getParam('branchId');
       $user 			   = new UserModel();
       $res                = $user->getBranchUser( $branchId );

       $this->renderSuccessJson( array( 'data' => $res ) );
    }
}