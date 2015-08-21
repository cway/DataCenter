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
        try
        { 
            $branchId          = $this->getRequest()->getParam('branchId');
            $m_complaint       = new ComplaintModel;
            $records           = $m_complaint->getUserComplaints( $branchId );
            $total             = $m_complaint->getUserComplaintsCnt( $branchId );
            $res               = array(
                                    'list'   => empty( $records ) ? array() : $records,
                                    'total'  => $total,
                                 );
            $this->renderSuccessJson( array( 'data' => $res ) );
        }
        catch (Tee_Exception $e)
        {
            $this->renderErrorJson( array( 'errno' => $e->getCode(), 'errmsg' => $e->getMessage() ) );
        }
    }
}