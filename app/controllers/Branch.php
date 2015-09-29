<?php
/**
 * @name BranchController
 * @author cway
 */
class BranchController extends DWDData_Base {

	public $actions = array(
                        'orderlist'	  	     => 'actions/Branch/OrderList.php',
                        'complaints'   	     => 'actions/Branch/Complaints.php',
                        'branchinfo' 	     => 'actions/Branch/BranchInfo.php',
                        'update'	   		 => 'actions/Branch/Update.php',
                        'redeemtel'   	     => 'actions/Branch/RedeemTel.php',
                        'campaignbranchlist' => 'actions/Branch/CampaignBranchList.php',
                        'accountinfo'        => 'actions/Branch/AccountInfo.php',
                        'addredeemtels'		 => 'actions/Branch/AddRedeemTels.php',
                        'branchlist'         => 'actions/Branch/BranchList.php',
                      );
}