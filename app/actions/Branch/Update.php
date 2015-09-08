<?php
/**
 * @file    Update.php
 * @des     获取商户封号信息
 * @author  caowei
 *
 */
class UpdateAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        $branchId          = $this->getRequest()->getParam('branchId');
        $m_branch          = new BranchModel;
        $params            = $this->getRequest()->allParams();
        $res               = $m_branch->updateBranchInfo( $branchId, $params );

        $res ? $this->renderSuccessJson( array( 'data' => $res ) ) : $this->renderErrorJson( array( 'data' => $res, 'errno' => DWDData_ErrorCode::UPDATE_ERROR , 'errmsg' => DWDData_ErrorCode::UPDATE_ERROR_MSG ) );
    }
}