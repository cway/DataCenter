<?php
/**
 * @name CampaignbranchController
 * @author cway
 */
class CampaignbranchController extends DWDData_Base {

	public $actions = array(
                        'offline'	            => 'actions/CampaignBranch/Offline.php', 
                        'branchlist'            => 'actions/CampaignBranch/BranchList.php',
                        'campaignbranchlist'    => 'actions/CampaignBranch/CampaignBranchList.php',
                        'nearlist'				=> 'actions/CampaignBranch/NearList.php',
                      );
}