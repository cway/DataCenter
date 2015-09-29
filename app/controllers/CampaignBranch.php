<?php
/**
 * @name CampaignbranchController
 * @author cway
 */
class CampaignbranchController extends DWDData_Base {

	public $actions = array(
                        'offline'	            => 'actions/Campaignbranch/Offline.php', 
                        'branchlist'            => 'actions/Campaignbranch/BranchList.php',
                        'campaignbranchlist'    => 'actions/Campaignbranch/CampaignBranchList.php',
                        'nearlist'				=> 'actions/Campaignbranch/NearList.php',
                      	'toplist'				=> 'actions/Campaignbranch/TopList.php',
                      	'deliverylist'		    => 'actions/Campaignbranch/DeliveryList.php',
                      	'detail'				=> 'actions/Campaignbranch/Detail.php',
                      );
}