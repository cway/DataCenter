<?php
/**
 * @file    RecommendRecord.php
 * @des     获取用户推荐信息
 * @author  caowei
 *
 */
class RecommendRecordsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
        $userId             = $this->getRequest()->getParam('userId');
        $m_logRecommendApp  = new LogRecommendAppModel;
        $options            = self::_initQueryOptions();
        $records            = $m_logRecommendApp->getUserRecommends( $userId, $options );
        $total              = $m_logRecommendApp->getUserRecommendsCnt( $userId );
        $res                = array(
                                 'list'   => empty( $records ) ? array() : $records,
                                 'total'  => $total,
                              );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}