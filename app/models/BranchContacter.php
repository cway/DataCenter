<?php
/**
 * @name BranchContacterModel
 * @desc BranchContacterModel
 * @author cway
 */
class BranchContacterModel extends DWDData_Db {
  
    protected $dbTable           = 'branch_contacter'; 
    const MAX_TAGS               = 100;
    const ACTIVE                 = 1;

    /**
     *获取门店验证电话
     */
    public function getBranchContacter( $branchId ) {
    	 
        $res              = array(); 
        $rowNums          = array( ); 
        $rowNums[0]       = 0;
        $rowNums[1]       = self::MAX_TAGS;
        $res['list']      = $this->where('branch_id', $branchId)->get( $rowNums );
        
         if( null == $res['list'] ){
            $res['list']  = array();
         }
         $res['totalCnt'] = count( $res['list'] );
         
         return $res;
    } 

    /**
     *添加门店验证电话
     */
    public function addBranchContacter( $param ) {
         
        $this->branch_id       = $param['branchId'];
        $this->name            = '';
        $this->tel             = $param['tel'];
        $this->enabled         = self::ACTIVE;
        $this->is_binding      = self::ACTIVE;
        $this->created_at      = date("Y-m-d H:i:s");
        $this->updated_at      = date("Y-m-d H:i:s");
        return  $this->insert();
    }

    /**
     *删除门店验证电话
     */
    public function delBranchContacters( $ids ) {
        return $this->where( 'id', $ids, 'IN' )->delete();
    }
}