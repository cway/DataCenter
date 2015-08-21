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
        try
        { 
            $userId            = $this->getRequest()->getParam('userId');
            $m_complaint       = new ComplaintModel;
            $records           = $m_complaint->getUserComplaints( $userId );
            $total             = $m_complaint->getUserComplaintsCnt( $userId );
            $res               = array(
                                    'list'   => $records,
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