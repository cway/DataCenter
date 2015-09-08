<?php

class User_UserInfo_Request extends DWDData_Request
{
    public function checkParams()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {

            throw new DWDData_Exception(DWDData_ErrorCode::REQUEST_METHOD_ERROR_MSG, DWDData_ErrorCode::REQUEST_METHOD_ERROR);
        }

        $userId        = $this->getParam('userId');
        $mobile        = $this->getParam('mobile');
        $redeemNumber  = $this->getParam('redeemNumber');

        if ($userId == null && $mobile == null && $redeemNumber == null ){

            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }

        if( $userId != null && false == is_numeric( $userId ) ){
            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }

        if( $mobile != null && false == is_numeric( $mobile ) ){
            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }


        return parent::checkParams();
    }
} 