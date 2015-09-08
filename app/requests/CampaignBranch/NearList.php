<?php

class Campaignbranch_NearList_Request extends DWDData_Request
{
    const MAX_BRANCH_CNT       = 100;
    const MIN_BRANCH_CNT       = 0;

    public function checkParams()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {

            throw new DWDData_Exception(DWDData_ErrorCode::REQUEST_METHOD_ERROR_MSG, DWDData_ErrorCode::REQUEST_METHOD_ERROR);
        }

        if ($this->getParam('lat') == null || $this->getParam('lng') == null ){

            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }  

        $this->setParam('lat', floatval( $this->getParam('lat') ) );
        $this->setParam('lng', floatval( $this->getParam('lng') ) );
 
        if( $this->getParam('categoryId') ){
            $this->setParam('categoryId', intval( $this->getParam('categoryId') ) );
        }

        if( $this->getParam('zoneId') ){
            $this->setParam('zoneId', intval( $this->getParam('zoneId') ) );
        }
 
        return parent::checkParams();
    }
}