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
        $res                = $m_logRecommendApp->getUserRecommends( $userId, $options );

        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}