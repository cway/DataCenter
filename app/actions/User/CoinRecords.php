<?php
/**
 * @file    Complaints.php
 * @des     获取用户封号信息
 * @author  caowei
 *
 */
class CoinRecordsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    const TYPE_RECOMMEND    = 2;

    private function _getRecommendCoinRecords( $m_logCoinBalance, $userId, $options )
    {
    	$conditions         = array(
              								 array(
              								 	 'field'  => 'user_id',
              							     	 'value'  => $userId,
              							     	 'op'	  => '=',
              								 ),
              								 array(
              							     	 'field'  => 'type',
              							     	 'value'  =>  LogCoinBalanceModel::TYPE_RECOMMEND,
              							     	 'op'	  => '=',
              							     ), 
                						);

    	return $m_logCoinBalance->getCoinRecordsByConditions( $conditions, $options );
    }

    public function _exec()
    {
        $userId             = $this->getRequest()->getParam('userId');
        $m_logCoinBalance   = new LogCoinBalanceModel;
        $options            = self::_initQueryOptions();
        $type			          = $this->getRequest()->getParam('type');
       
        switch( $type ){
       	    case self::TYPE_RECOMMEND:
       	    	$res          = self::_getRecommendCoinRecords( $m_logCoinBalance, $userId, $options );
       	  	    break;
       	    default:
       	  	    $res        = $m_logCoinBalance->getUserCoinRecords( $userId, $options );
       	  	    break;
        } 
         
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}