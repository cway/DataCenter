<?php
/**
 * 数据库连接
 * author caowei
 */
class DWDData_Db extends dbObject
{ 
	public $returnType    = 'Array';

	public $pageLimit     = 10;

	public $startPage     = 1;

	public $defaultOffset = 0;

	public function __construct() { 
		$config      = Yaf_Registry::get("config");
		$db          = new Mysqlidb( $config->database->config->toArray() );
		parent::__construct();
	}

	/**
     * 根据条件获取列表
     */
    public function getListByConditions( $conditions, $option = array(), $fields = array('id') ){
        foreach( $conditions as $condition ){
            switch ( $condition['op'] ) {
                case 'IN':
                case 'NOT IN':
                case 'BETWEEN':
                case 'NOT BWTWEEN':
                    $this->where( $condition['field'], $condition['values'], $condition['op'] );
                    break;
                case '>=':
                case '>':
                case '<=':
                case '<': 
                case '<=>':
                    $this->where( $condition['field'], $condition['value'], $condition['op'] );
                    break;
                case '=':
                case 'eq':
                    $this->where( $condition['field'], $condition['value'] );
                    break;
                case 'col_eq':
                    $this->where( $condition['field'] . ' = ' . $condition['value'] );
                    break;    
                default:
                    break;
            }
        }
  
        $res                     = array();

        if( isset( $option['needPagination'] ) && true == $option['needPagination'] ){
            $this->pageLimit  = isset( $option['limit'] )   ? intval( $option['limit'] )   : $this->pageLimit;
            $pageNum          = isset( $option['pageNum'] ) ? intval( $option['pageNum'] ) : $this->startPage;
            $res['list']      = $this->paginate( $pageNum, $fields );
            $res['totalPage'] = $this->totalPages;
            $res['totalCnt']  = intval( $this->totalCount );
        } else {
            $rowNums          = array( ); 
            $rowNums[0]       = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
            $rowNums[1]       = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
            $res['list']      = $this->get( $rowNums, $fields );
        }

        if( null == $res['list'] ){
            $res['list']      = array();
        }
        return $res;
    }

    /**
     * 根据条件获取列表数量
     */
    public function getListCntByConditions( $conditions ){

        foreach( $conditions as $condition ){
            switch ( $condition['op'] ) {
                case 'IN':
                case 'NOT IN':
                case 'BETWEEN':
                case 'NOT BWTWEEN':
                    $this->where( $condition['field'], $condition['values'], $condition['op'] );
                    break;
                case '>=':
                case '>':
                case '<=':
                case '<': 
                case '<=>':
                    $this->where( $condition['field'], $condition['value'], $condition['op'] );
                    break;
                case '=':
                case 'eq':
                    $this->where( $condition['field'], $condition['value'] );
                    break;
                case 'col_eq':
                    $this->where( $condition['field'] . ' = ' . $condition['value'] );
                    break;    
                default:
                    break;
            }
        }

        return $this->count();
    }
}