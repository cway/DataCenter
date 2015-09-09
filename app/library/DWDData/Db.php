<?php
/**
 * 数据库连接
 * author caowei
 */
class DWDData_Db extends dbObject
{ 
	public $returnType           = 'Array';

	public $pageLimit            = 10;

	public $startPage            = 1;

	public $defaultOffset        = 0;

    const  FILED_COMMON_TYPE     = 0;

	public function __construct() { 
		$config      = Yaf_Registry::get("config");
		$db          = new MysqliDb( $config->database->config->toArray() );
		parent::__construct();
	}

    protected function _initConditions( $conditions )
    {
        foreach( $conditions as $condition ){
            switch ( $condition['op'] ) {
                case 'IN':
                case 'in':
                case 'NOT IN':
                case 'not in':
                case 'BETWEEN':
                case 'between':
                case 'NOT BETWEEN':
                case 'not between':
                    $this->where( $condition['field'], $condition['values'], $condition['op'] );
                    break;
                case '>=':
                case '>':
                case '<=':
                case '<': 
                case '<=>':
                case '!=':
                    $this->where( $condition['field'], $condition['value'], $condition['op'] );
                    break;
                case '=':
                case 'eq':
                case 'EQ':
                    $this->where( $condition['field'], $condition['value'] );
                    break;
                case 'col_eq':
                case 'COL_EQ':
                    $this->where( $condition['field'] . ' = ' . $condition['value'] );
                    break;    
                case 'join':
                case 'JOIN':
                    $this->join( $condition['modelName'], $condition['joinKey'], $condition['joinType'] ); 
                    break; 
                case 'group':
                case 'GROUP':
                    $this->groupBy( $condition['field'] ); 
                    break;  
                case 'ORDER BY':
                case 'order by':
                    $this->orderBy( $condition['field'], $condition['type'] );
                    break;
                default:
                    break;
            }
        }
    }

	/**
     * 根据条件获取列表
     */
    public function getListByConditions( $conditions, $option = array(), $fields = array('id') ){
         
        self::_initConditions( $conditions );
        $res                  = array();

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

        self::_initConditions( $conditions );

        return $this->count();
    }
}