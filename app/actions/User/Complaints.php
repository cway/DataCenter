<?php
/**
 * @file    Complaints.php
 * @des     获取用户封号信息
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
        $records            = $m_complaint->getUserComplaints( $userId, $options );
        $total              = $m_complaint->getUserComplaintsCnt( $userId );
        $res                = array(
                                'list'   => empty( $records ) ? array() : $records,
                                'total'  => $total,
                              );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}