<?php
/**
 * @name OAtuhModel
 * @desc OAtuhModel
 * @author cway
 */
class OAuthModel extends DWDData_Db {
  
    protected $dbTable           = 'oauth';

    protected $fieldTypes        = array(
                                       array( 'oauth_user_id', 'access_token', 'refresh_token', 'extra_info' ),
                                   );

    /**
     *获取用户OAuth信息列表
     */
    public function getUserOAuthes( $userId, $option = array() ) {
    	
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
            $res['list']                        =  array();
         } else if( is_array( $res['list'] ) ){
            foreach( $res['list'] as $k => $v ){
                $res['list'][$k]['extra_info']  =  json_decode( $v['extra_info'], true );
            }
         }
         return $res;
    }

    /**
     *获取用户OAuth信息列表数
     */
    public function getUserOAuthesCnt( $userId ){
         return  $this->where( 'user_id', $userId )->count();
    } 
}