<?php
/**
 * @name ComplaintController
 * @author cway
 */
class ComplaintController extends DWDData_Base {

	public $actions = array(
                        'taglist'         => 'actions/Complaint/TagList.php',
                        'history'	      => 'actions/Complaint/History.php'
                      );
}