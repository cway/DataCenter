<?php

class Branch_OrderList_Request extends DWDData_Request
{
    public function checkParams()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {

            throw new DWDData_Exception(DWDData_ErrorCode::REQUEST_METHOD_ERROR_MSG, DWDData_ErrorCode::REQUEST_METHOD_ERROR);
        }

        if ($this->getParam('branchId') == null ){

            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        } 

        return parent::checkParams();
    }
}