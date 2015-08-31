<?php
/**
 * @file    Complaints.php
 * @des     获取用户投诉信息
 * @author  caowei
 *
 */
class ComplaintsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        $userId             = $this->getRequest()->getParam('userId');
        $m_complaint        = new ComplaintModel;
        $options            = self::_initQueryOptions();
        $res                = $m_complaint->getUserComplaints( $userId, $options );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}