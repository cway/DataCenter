<?php
/**
 * @name ComplaintTagsModel
 * @desc ComplaintTagsModel
 * @author cway
 */
class ComplaintTagsModel extends DWDData_Db {
  
    protected $dbTable           = 'complaint_tags'; 
    
    /**
     *添加投诉标签关系
     */
    public function addComplaintTags( $param ) {
    	 
        $this->complaint_id    = $param['complaintId']; 
        $this->complainttag_id = $param['complaintTagId'];
        return $this->insert();
    } 
}