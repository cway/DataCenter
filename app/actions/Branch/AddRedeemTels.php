<?php
/**
 * @file    AddRedeemTels.php
 * @des     帐号信息
 * @author  caowei
 *
 */
class AddRedeemTelsAction extends DWDData_Action
{
    protected $_isCheckAuth = false;

    public function _exec()
    {
       $branchId           = $this->getRequest()->getParam('branchId');
       $redeemTelsStr      = $this->getRequest()->getParam('redeemTels');
       $redeemTels         = explode(",", $redeemTelsStr);

       $m_BranchContacter  = new BranchContacterModel();
       $existsRedeemTels   = $m_BranchContacter->getBranchContacter( $branchId );

       $deleteIds          = array(); 
       $existsList         = array(); 
       foreach( $existsRedeemTels['list'] as $existsRedeemTel ){
       	 if( false == in_array( $existsRedeemTel['tel'], $redeemTels ) ){
       	 	$deleteIds[]   = $existsRedeemTel['id'];
       	 }
       	 $existsList[]     = $existsRedeemTel['tel'];
       } 

       if( false == empty( $deleteIds ) ){ 
       	 $m_BranchContacter->delBranchContacters( $deleteIds );
       }
        
       foreach( $redeemTels as $redeemTel ){ 
       	 if( false == in_array( $redeemTel, $existsList ) ){
       	 	$param             = array(
	       	 						'branchId' => $branchId,
	       	 						'tel'	   => $redeemTel,
	       	 					 );
       	 	$m_BranchContacter = new $m_BranchContacter(); 
       	 	$res               = $m_BranchContacter->addBranchContacter( $param );
       	 }
       } 
       
       $this->renderSuccessJson( array( 'data' => true ) );
    }
}