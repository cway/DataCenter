<?php

class User_UsersInfo_Request extends DWDData_Request
{
	const MAX_BRANCH_CNT       = 100;
    const MIN_BRANCH_CNT       = 0;

    public function checkParams()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {

            throw new DWDData_Exception(DWDData_ErrorCode::REQUEST_METHOD_ERROR_MSG, DWDData_ErrorCode::REQUEST_METHOD_ERROR);
        }

        if ($this->getParam('userIds') == null ){

            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        } 

        $userIds      = explode(",", $this->getParam('userIds'));
        $idsCnt       = count( $userIds );
        if( $idsCnt > self::MAX_BRANCH_CNT || $idsCnt < self::MIN_BRANCH_CNT ){
            throw new DWDData_Exception(DWDData_ErrorCode::PARAMS_ERROR_MSG, DWDData_ErrorCode::PARAMS_ERROR);
        }

        $this->setParam( 'userIds', $userIds );
        $this->setParam( 'pageNum', 0 );
        $this->setParam( 'pageLimit', $idsCnt );

        return parent::checkParams();
    }
}