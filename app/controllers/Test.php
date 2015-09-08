<?php
/**
 * @name IndexController
 * @author cway
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class TestController extends DWDData_Base {

 
  public function indexAction() 
  {
     /* $data           = array(
                                    array(
                                        'url'    => 'http://10.0.0.10:12306/user/userInfo',
                                        'data'   => array(
                                                      'userId'         => 289066,
                                                    ),
                                        'method' => 'get',
                                    ),
                                    array(
                                        'url'    => 'http://10.0.0.10:12306/user/orderlist',
                                        'data'   => array(
                                                      'userId'         => 289066,
                                                      'needPagination' => 1,
                                                      'type'           => 2,
                                                      'pageLimit'      => 1,
                                                    ),
                                        'method' => 'get',
                                    ),
                                    array(
                                        'url'    => 'http://10.0.0.10:12306/user/coinrecords',
                                        'data'   => array(
                                                      'userId'         => 289066,
                                                      'type'           => 1,
                                                      'needPagination' => 1,
                                                      'pageLimit'      => 1,
                                                    ),
                                        'method' => 'get',
                                        'key'    => 'a',
                                    ),
                                );

        $res                = DWDData_Http::MutliCall( $data );
        var_dump( $res );exit; */
        $mongo      =  MongoObject::getInstance();
        $collection =  $mongo->getCollection('demo'); //->insert(array('id' => 'abc' ) );
        $data       =  $mongo->find( array('loc' => array(  '$near' =>  array(113.182, 69.111) ) ) );

        $mongo->close();
        var_dump( iterator_to_array( $data ) );
  }
} 
  