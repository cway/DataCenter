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
        try
        {
            $userId            = $this->getRequest()->getParam('userId');
            $m_logRecommendApp = new LogRecommendAppModel;
            $records           = $m_logRecommendApp->getUserRecommends( $userId );
            $total             = $m_logRecommendApp->getUserRecommendsCnt( $userId );
            $res               = array(
                                    'list'   => empty( $records ) ? array() : $records,
                                    'total'  => $total,
                                 );

            $this->renderSuccessJson( array( 'data' => $res ) );
        }
        catch (Tee_Exception $e)
        {
            $this->renderErrorJson( array( 'errno' => $e->getCode(), 'errmsg' => $e->getMessage() ) );
        }
    }
}