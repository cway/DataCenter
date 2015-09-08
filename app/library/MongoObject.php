    <?php

    class MongoObject {

        static private  $instance   =  array();     //  数据库连接实例
        static private  $_instance  =  null;   //  当前数据库连接实例

        /**
         * 取得数据库类实例
         * @static
         * @access public
         * @param mixed $config 连接配置
         * @return Object 返回数据库驱动类
         */
        static public function getInstance($config=array()) {
            $config                     =   Yaf_Registry::get("config");
            $config                     =   $config->mongo->config->toArray();

            $config['rand']             =   array(0, 10);
            $md5                        =   md5(serialize($config));
            if(!isset(self::$instance[$md5])) {
                self::$instance[$md5]   =   new MongoDriver($config); 
            }
            self::$_instance            =   self::$instance[$md5];
            return self::$_instance;
        }
    }