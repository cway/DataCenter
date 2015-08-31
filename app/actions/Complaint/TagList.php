<?php
/**
 * @file    TagList.php
 * @des     获取投诉标签列表
 * @author  caowei
 *
 */
class TagListAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    { 
        $m_complaintTag        = new ComplaintTagModel; 
        $res                   = $m_complaintTag->getComplaintTags();
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}