<?php
/**
 * @name ComplaintTagModel
 * @desc ComplaintTagModel
 * @author cway
 */
class ComplaintTagModel extends DWDData_Db {
  
    protected $dbTable           = 'complaint_tag'; 
    const MAX_TAGS               = 100;

    /**
     *获取用户投诉标签
     */
    public function getComplaintTags() {
    	 
        $res              = array(); 
        $rowNums          = array( ); 
        $rowNums[0]       = 0;
        $rowNums[1]       = self::MAX_TAGS;
        $res['list']      = $this->get( $rowNums );
        
         if( null == $res['list'] ){
            $res['list']  = array();
         }
         $res['totalCnt'] = count( $res['list'] );
         return $res;
    } 
}