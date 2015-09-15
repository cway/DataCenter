
<?php
/**
 * MongoDriver
 */
class MongoDriver {
    protected $_mongo           =   null; // MongoDb Object
    protected $_collection      =   null; // MongoCollection Object 
    protected $_collectionName  =   ''; // collectionName
    protected $_cursor          =   null; // MongoCursor Object
    protected $comparison       =   array('neq'=>'ne','ne'=>'ne','gt'=>'gt','egt'=>'gte','gte'=>'gte','lt'=>'lt','elt'=>'lte','lte'=>'lte','in'=>'in','not in'=>'nin','nin'=>'nin');
    // PDO操作实例
    protected $PDOStatement = null; 
    // 当前SQL指令
    protected $queryStr   = '';
    protected $modelSql   = array();
    // 最后插入ID
    protected $lastInsID  = null;
    // 返回或者影响记录数
    protected $numRows    = 0;
    // 事务指令数
    protected $transTimes = 0;
    // 错误信息
    protected $error      = '';
    // 数据库连接ID 支持多个连接
    protected $linkID     = array(); 

    // 数据库连接参数配置
    protected $config     = array( 
        'hostname'          =>  '10.0.0.10', // 服务器地址
        'database'          =>  'iqg_prod',          // 数据库名
        'username'          =>  '',      // 用户名
        'password'          =>  '',          // 密码
        'hostport'          =>  '27017',        // 端口     
        'dsn'               =>  '', //     
        'params'            =>  array(), // 数据库连接参数        
        'charset'           =>  'utf8',      // 数据库编码默认采用utf8  
        'prefix'            =>  '',    // 数据库表前缀
        'debug'             =>  false, // 数据库调试模式
        'deploy'            =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'rw_separate'       =>  false,       // 数据库读写是否分离 主从式有效
        'master_num'        =>  1, // 读写分离后 主服务器数量
        'slave_no'          =>  '', // 指定从服务器序号
        'db_like_fields'    =>  '', 
    );
 
    /**
     * 架构函数 读取数据库配置信息
     * @access public
     * @param array $config 数据库配置数组
     */
    public function __construct($config=''){
       
        if(!empty($config)) {
            $this->config           =   array_merge($this->config,$config);
            if(empty($this->config['params'])){
                $this->config['params'] =   array();
            }            
        }
    }

    /**
     * 连接数据库方法
     * @access public
     */
    public function connect($config='',$linkNum=0) {
        if ( !isset($this->linkID[$linkNum]) ) {
            if(empty($config))  $config =   $this->config;
            $host = 'mongodb://'.($config['username']?"{$config['username']}":'').($config['password']?":{$config['password']}@":'').$config['hostname'].($config['hostport']?":{$config['hostport']}":'').'/'.($config['database']?"{$config['database']}":'');
            try{
                $this->linkID[$linkNum] = new \mongoClient( $host,$this->config['params']);
            }catch (\MongoConnectionException $e){
                throw new \MongoConnectionException(); 
            }
        }
        return $this->linkID[$linkNum];
    }

    /**
     * 初始化数据库连接
     * @access protected
     * @param boolean $master 主服务器
     * @return void
     */
    protected function initConnect() {
       $this->_mongo  = $this->connect();
    }
  

    /**
     * 释放查询结果
     * @access public
     */
    public function free() {
        $this->_cursor = null;
    }
 
    /**
     * 获取指定collection
     * @access public
     * @param string $collection  collection 
     * @return void
     */
    public function getCollection($collection){
        // 当前没有连接 则首先进行数据库连接
        if ( !$this->_mongo ){
            $this->initConnect();
        }

        $dbName             = $this->config['database'];
        $this->_collection  = $this->_mongo->$dbName->$collection;
        return $this->_collection;
    }

    public function insert( $data ){
       return  $this->_collection->insert( $data );
    }

    public function find( $condition, $option = array() ){
        
       $offset              = isset( $option['offset'] ) ? intval( $option['offset'] ) : 0;
       $limit               = isset( $option['limit'] )  ? intval( $option['limit'] )  : 20; 
        
       if( isset( $option['sort'] ) ){
            $sort           = array(
                                $option['sort'] => -1,
                              );

            if( isset( $option['sortType'] ) && $option['sortType'] == DWDData_Const::ORDER_BY_ASC_ID ){
                $sort[$option['sort']]   = 1;
            }
            
            return $this->_collection->find( $condition )->sort($sort)->skip( $offset )->limit( $limit );
       }

       return $this->_collection->find( $condition )->skip( $offset )->limit( $limit );
   
    }

    public function count( $condition ){
        
      return $this->_collection->count($condition);
       
    }

    public function findOne( $condition ){
       return  $this->_collection->findOne( $condition );
    }

    /**
     * 关闭数据库
     * @access public
     */
    public function close() {
        if($this->_mongo) {
            $this->_mongo->close(); 
            $this->_mongo      = null;
            $this->_collection =  null;
            $this->_cursor     = null;
        }
    }

}