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
        $enabled            = $this->getRequest()->getParam("enabled");
        $active             = $this->getRequest()->getParam("active");
        $sort               = $this->getRequest()->getParam("sort");
        $sortType           = $this->getRequest()->getParam("sortType");

        $conditions         = array(); 
        
        if( null != $enabled ){
        	$conditions[]   = array(
        						'field'	 => 'enabled',
        						'value'  => $enabled == DWDData_Const::DISABLED ? DWDData_Const::DISABLED : DWDData_Const::ENABLED,
        						'op'	 => '=', 
        					  );
        }

        if( null != $sort ){
        	$conditions[]   = array(
        						'field'	 => $sort,
        						'type'   => $sortType == DWDData_Const::ORDER_BY_ASC_ID ? DWDData_Const::ORDER_BY_ASC : DWDData_Const::ORDER_BY_DESC,
        						'op'	 => 'order by', 
        					  ); 
        } 

        if( null != $active ){
            $now            = date("Y-m-d H:i:s");
            $conditions[]   = array(
                                'field'  => 'start_date',
                                'value'  => $now,
                                'op'     => $active == DWDData_Const::INACTIVE ? '>=' : '<', 
                              ); 
            $conditions[]   = array(
                                'field'  => 'end_date',
                                'value'  => $now,
                                'op'     => $active == DWDData_Const::INACTIVE ? '<=' : '>', 
                              );  
        } 

        $options            = self::_initQueryOptions();
        $res                = $m_banner->getBanners( $conditions, $options );
               
        $this->renderSuccessJson( array( 'data' => $res ) );
    }
}