<?php
/**
 * @file    UserInfo.php
 * @des     获取用户信息
 * @author  caowei
 *
 */
class UserInfoAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        try
        {
            $userId         = $this->getRequest()->getParam('userId');
            $data           = new UserModel;
            $res            = $data->getUser( $userId );
            $this->renderSuccessJson( array( 'data' => $res ) );
        }
        catch (Tee_Exception $e)
        {
            $this->renderErrorJson( array( 'errno' => $e->getCode(), 'errmsg' => $e->getMessage() ) );
        }
    }
}