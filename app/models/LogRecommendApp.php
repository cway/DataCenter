<?php
/**
 * @name LogRecommandAppModel
 * @desc LogRecommandAppModel
 * @author cway
 */
class LogRecommendAppModel extends DWDData_Db {
  
    protected $dbTable           = 'log_recommend_app';

    const  FILED_COMMON_TYPE     = 0;

    protected $fieldTypes        = array(
                                       array( 'recommend_user_id', 'user_id', 'created_at' ),
                                   );

    /**
     *获取用户推荐列表
     */
    public function getUserRecommends( $userId, $option = array() ) {
    	
         $res                 = array();
          
         if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->where( 'user_id', $userId )->paginate( $pageNum, $this->fieldTypes[self::FILED_COMMON_TYPE] );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
         } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->where( 'user_id', $userId )->get( $rowNums, $this->fieldTypes[self::FILED_COMMON_TYPE] );
         }
        
         if( null == $res['list'] ){
            $res['list']      = array();
         }
         return $res;
    }

    /**
     *获取用户推荐列表数
     */
    public function getUserRecommendsCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count();
    } 
}