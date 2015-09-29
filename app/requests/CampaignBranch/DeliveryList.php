<?php

class Campaignbranch_DeliveryList_Request extends DWDData_Request
{
    const MAX_BRANCH_CNT       = 100;
    const MIN_BRANCH_CNT       = 0;
    static $SORT_ARR             = array( 'd_weight', 'price');

    public function checkParams()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {

            throw new DWDData_Exception(DWDData_ErrorCode::REQUEST_METHOD_ERROR_MSG, DWDData_ErrorCode::REQUEST_METHOD_ERROR);
        }

        if ( $this->getParam('zoneId') == null ){

            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }

        if( $this->getParam('sort') != null ){
            $sort = $this->getParam('sort');

            if( false == in_array( self::SORT_ARR, $sort ) ){
                throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
            }

            if( $this->getParam('sortType') == null || $this->getParam('sortType') != DWDData_Const::ORDER_BY_ASC_ID ){
                $this->setParam('sortType', DWDData_Const::ORDER_BY_DESC_ID);
            }
        }

        return parent::checkParams();
    }
}
