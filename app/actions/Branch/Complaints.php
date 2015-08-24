<?php
/**
 * @file    Complaints.php
 * @des     获取商户封号信息
 * @author  caowei
 *
 */
class ComplaintsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        $branchId          = $this->getRequest()->getParam('branchId');
        $m_complaint       = new ComplaintModel;
        $options            = self::_initQueryOptions();
        $records           = $m_complaint->getUserComplaints( $branchId, $options );
        $total             = $m_complaint->getUserComplaintsCnt( $branchId );
        $res               = array(
                                'list'   => empty( $records ) ? array() : $records,
                                'total'  => $total,
                             );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}