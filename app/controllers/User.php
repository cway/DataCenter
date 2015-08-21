<?php
/**
 * @name UserController
 * @author cway
 */
class UserController extends DWDData_Base {

	public $actions = array(
                        'userinfo'         => 'actions/User/UserInfo.php',
                        'lockedrecords'	   => 'actions/User/LockedRecords.php',
                        'recommendrecords' => 'actions/User/RecommendRecords.php',
                        'smsrecords'	   => 'actions/User/SMSRecords.php',
                        'complaints'	   => 'actions/User/Complaints.php',
                        'coinrecords'	   => 'actions/User/CoinRecords.php',
                        'balancerecords'   => 'actions/User/BalanceRecords.php',
                      );
}