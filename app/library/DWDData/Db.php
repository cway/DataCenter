<?php
/**
 * 数据库连接
 * author caowei
 */
class DWDData_Db extends dbObject
{ 
	public $returnType   = 'Array';

	public $pageLimit = 10;

	public $startPage = 0;

	public function __construct() { 
		$config      = Yaf_Registry::get("config");
		$db          = new Mysqlidb( $config->database->config->toArray() );
		parent::__construct();
	}
}