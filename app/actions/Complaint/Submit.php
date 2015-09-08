<?php
/**
 * @file    Submit.php
 * @des     获添加投诉记录
 * @author  caowei
 *
 */
class SubmitAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    { 
    	$itemId                = $this->getRequest()->getParam('itemId');
        $itemName              = $this->getRequest()->getParam('itemName');
        $orderId               = $this->getRequest()->getParam('orderId'); 
        $branchId              = $this->getRequest()->getParam('branchId');
        $branchName            = $this->getRequest()->getParam('branchName');
        $salerId               = $this->getRequest()->getParam('salerId');
        $typeId                = $this->getRequest()->getParam('typeId');
        $status                = $this->getRequest()->getParam('status');
        $description           = $this->getRequest()->getParam('description');
        $categoryId            = $this->getRequest()->getParam('categoryId');
        $mobile                = $this->getRequest()->getParam('mobile');
        $params                = $this->getRequest()->allParams();
        $tags                  = $this->getRequest()->getParam('tags');
        $m_complaint           = new ComplaintModel; 
        $complaintId           = $m_complaint->addComplaint( $params );
        if( false == $complaintId ){
            $this->renderErrorJson( array( 'data' => 'failed', 'errno' => DWDData_ErrorCode::INSERT_ERROR, 'errmsg' => DWDData_ErrorCode::INSERT_ERROR_MSG ) );
            return ;
        }

        $m_complaintTags       = new ComplaintTagsModel;
        $tags                  = explode(',', $tags);

        foreach ($tags  as  $tagId) {
            $param             = array(
                                    'complaintId'    => $complaintId,
                                    'complaintTagId' => $tagId,
                                 );
            $m_complaintTags->addComplaintTags( $param );
        }

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}