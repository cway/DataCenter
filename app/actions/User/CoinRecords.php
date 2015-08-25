<?php
/**
 * @file    CoinRecords.php
 * @des     获取用户封号信息
 * @author  caowei
 *
 */
class CoinRecordsAction extends DWDData_Action
{
    protected $_isCheckAuth                 = false;

    const TYPE_RECOMMEND                    = 2;
    const TYPE_ONLY_RECOMMEND_AMOUT_SUM     = 3;
    const TYPE_WITH_RECOMMEND_AMOUT_SUM     = 23;

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
       	    	  $res        = self::_getRecommendCoinRecords( $m_logCoinBalance, $userId, $options );
       	  	    break;
            case self::TYPE_ONLY_RECOMMEND_AMOUT_SUM:
                $res        = $m_logCoinBalance->getUserCoinAmountByType( $userId, LogCoinBalanceModel::TYPE_RECOMMEND );
                break;
            case self::TYPE_WITH_RECOMMEND_AMOUT_SUM:
                $res1       = self::_getRecommendCoinRecords( $m_logCoinBalance, $userId, $options );
                $res2       = $m_logCoinBalance->getUserCoinAmountByType( $userId, LogCoinBalanceModel::TYPE_RECOMMEND );
                $res        = array_merge( $res1, $res2 );
                break;
       	    default:
       	  	    $res        = $m_logCoinBalance->getUserCoinRecords( $userId, $options );
       	  	    break;
        } 
         
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}