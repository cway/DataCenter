<?php
/**
 * @file    BannerList.php
 * @des     获取Banner列表
 * @author  caowei
 */
class BannerListAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    { 
        $m_banner           = new BannerModel;
        $options            = self::_initQueryOptions();
        $res                = $m_banner->getBanners( $options );
               
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}