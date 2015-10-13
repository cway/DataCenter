<?php
/**
 * @name ItemCategoriesModel
 * @desc ItemCategoriesModel
 * @author cway
 */
class ItemCategoriesModel extends DWDData_Db {

	protected $dbTable           = 'item_categories'; 
    const MAX_TAGS               = 100;

    /**
     *获取用户投诉标签
     */
    public function getItemCategories( $itemId ) {
    	 
        $res              = array(); 
        $rowNums          = array( ); 
        $rowNums[0]       = 0;
        $rowNums[1]       = self::MAX_TAGS;
        $res['list']      = $this->where('item_id', $itemId)->get( $rowNums );
        
         if( null == $res['list'] ){
            $res['list']  = array();
         } else {
         	$list         = array();
         	foreach( $res['list'] as $info ){
         		$list[]   = $info['category_id'];
         	}
         	$res['list']  = $list;
         }
         $res['totalCnt'] = count( $res['list'] );
         return $res;
    }
}