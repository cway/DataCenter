<?php
/**
 * @file    UserInfo.php
 * @des     更新购物车
 * @author  leixiong monday41
 *
 */
class UserInfoAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        try
        { 
            $this->renderSuccessJson( array( 'data' => 'halo world!' ) ); 
        }
        catch (Tee_Exception $e)
        {
            $this->renderErrorJson( array( 'errno' => $e->getCode(), 'errmsg' => $e->getMessage() ) );
        }
    }
}
