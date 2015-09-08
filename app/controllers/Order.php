<?php
/**
 * @name OrderController
 * @author cway
 */
class OrderController extends DWDData_Base {

	public $actions = array(
                        'orderinfo'         => 'actions/Order/OrderInfo.php',
                        'redeem'			=> 'actions/Order/Redeem.php',
                        'feedback'			=> 'actions/Order/Feedback.php',
                        'orderlog'			=> 'actions/Order/OrderLog.php',
                      );
}