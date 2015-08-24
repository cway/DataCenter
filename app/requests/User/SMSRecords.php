<?php

class User_SMSRecords_Request extends DWDData_Request
{
    public function checkParams()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {

            throw new DWDData_Exception(DWDData_ErrorCode::REQUEST_METHOD_ERROR, DWDData_ErrorCode::REQUEST_METHOD_ERROR_MSG);
        }

        if ($this->getParam('userId') == null && $this->getParam('mobile') == null ){

            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }

        return parent::checkParams(); 
    }
}