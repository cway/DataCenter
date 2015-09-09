<?php
/**
 * @name DiscoveryModel
 * @desc DiscoveryModel
 * @author cway
 */
class DiscoveryModel extends DWDData_Db {
  
    protected $dbTable           = 'discovery'; 

    protected $fieldTypes        = array(
                                       array( 'id', 'url', 'title', 'image_key', 'type', 'need_login'),
                                   );
    const ACTIVE                 = 1;
    /**
     *获取Discovery列表
     */
    public function getDiscoveries( $conditions = array(), $option = array() ) {
    	 
         $res                 = array();

         $this->_initConditions( $conditions );
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
         }
        
         if( null == $res['list'] ){
            $res['list']      = array();
         }
         
         return $res;  
    }

    /**
     *获取总Discovery数
     */
    public function getDiscoveriesCnt( $mobile ){
         return  $this->count();
    } 
}