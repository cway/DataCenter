<?php
/**
 * @name BannerModel
 * @desc BannerModel
 * @author cway
 */
class BannerModel extends DWDData_Db {
  
    protected $dbTable           = 'banner'; 

    protected $fieldTypes        = array(
                                       array( 'id', 'title', 'url', 'image_key', 'style', 'event_id'),
                                   );

    /**
     *获取Banner列表
     */
    public function getBanners( $option = array() ) {
    	 
         $res                 = array();
          
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
     *获取总Banner数
     */
    public function getBannersCnt( $mobile ){
         return  $this->count();
    } 
}