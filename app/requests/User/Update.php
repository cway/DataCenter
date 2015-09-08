<?php

class User_Update_Request extends DWDData_Request
{
    public function checkParams()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            throw new DWDData_Exception(DWDData_ErrorCode::REQUEST_METHOD_ERROR_MSG, DWDData_ErrorCode::REQUEST_METHOD_ERROR);
        }

        $userId     = $this->getParam('userId');  

        if( $userId == null || false == is_numeric( $userId ) ){
            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }
 

        return parent::checkParams();
    }
}