<?php
/**
 * @file    BrandInfo.php
 * @des     获取品牌详情
 * @author  caowei
 *
 */
class BrandInfoAction extends DWDData_Action
{
    protected $_isCheckAuth    = false;

    public function _exec()
    { 
        $brandId           = $this->getRequest()->getParam('brandId');
        $m_brand           = new BrandModel; 
        $res               = $m_brand->getBrand( $brandId );
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}