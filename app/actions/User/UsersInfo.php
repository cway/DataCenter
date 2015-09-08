<?php
/**
 * @file    UsersInfo.php
 * @des     获取用户信息
 * @author  caowei
 *
 */
class UsersInfoAction extends DWDData_Action
{
    protected $_isCheckAuth  = false;

    public function _exec()
    {   
        $userIds             = $this->getRequest()->getParam('userIds'); 

        $m_user              = new UserModel; 
        $options             = self::_initQueryOptions();
        $data                = $m_user->getUsers( $userIds, $options );
       
        $usersInfo           = array( 
                                   'list' => array(),
                               );

        foreach ($data as $userInfo) {
            $usersInfo['list'][$userInfo['id']] = $userInfo;
        } 

        $this->renderSuccessJson( array( 'data' => $usersInfo ) );
    }
}