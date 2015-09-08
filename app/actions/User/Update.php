<?php
/**
 * @file    Update.php
 * @des     获取用户信息
 * @author  caowei
 *
 */
class UpdateAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {   
        $userId          = $this->getRequest()->getParam('userId');
        $m_user          = new UserModel;
        $params          = $this->getRequest()->allParams();
        $res             = $m_user->updateUserInfo( $userId, $params );

        $res ? $this->renderSuccessJson( array( 'data' => $res ) ) : $this->renderErrorJson( array( 'data' => $res, 'errno' => DWDData_ErrorCode::UPDATE_ERROR , 'errmsg' => DWDData_ErrorCode::UPDATE_ERROR_MSG ) );
    }
}