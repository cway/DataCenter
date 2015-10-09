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
    	$type                  = $this->getRequest()->getParam('type');
        $m_complaintTag        = new ComplaintTagModel; 
        $res                   = $m_complaintTag->getComplaintTags();
        
        if( !empty( $type ) ){
	        foreach ($res['list'] as $key => $tagInfo) {
	          if( !($tagInfo['type'] & $type) ){
	          	 unset( $res['list'][$key] );
	          }
	        }
	    }
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}