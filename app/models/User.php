<?php
/**
 * @name UserModel
 * @desc UserModel
 * @author cway
 */
class UserModel extends DWDData_Db {
  
    protected $dbTable           = 'user';

    const FILED_COMMON_TYPE      = 0;

    protected $fieldTypes        = array(
    						          // array( 'username', 'zone_id', 'email', 'enabled', 'mobile', 'balance', 'coin', 'created_at', 'updated_at' ),
    					               array( 'id', 'username', 'email', 'enabled', 'last_login', 'locked', 'expired', 'credentials_expired', 'mobile', 'avatar', 'balance', 'coin', 'coin_total_gain', 'coin_rank_percent', 'share_code', 'openim_account', 'created_at', 'updated_at' ),
                                   );
    protected $dbFields          = array(
                                     'id'          => array( 'int', 'required' ),
                                     'username'    => array( 'text' ),
                                     'updated_at'  => array( 'datetime' ),
                                     'locked'      => array( 'int' ),
                                     'locked_at'   => array( 'datetime' ),
                                     'lock_date'   => array( 'datetime' ),
                                   );//array( 'id', 'username', 'email', 'enabled', 'last_login', 'locked', 'expired', 'credentials_expired', 'locked_at', 'lock_date' ,'mobile', 'avatar', 'balance', 'coin', 'coin_total_gain', 'coin_rank_percent', 'share_code', 'openim_account', 'created_at', 'updated_at' );

    /**
     *获取用户信息
     */
    public function getUser( $userId, $fields = self::FILED_COMMON_TYPE ) 
    {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}

        return  $this->byId( $userId, $fields );
    }

    /**
     *获取商户用户
     */
    public function getBranchUser( $branchId, $fields = self::FILED_COMMON_TYPE )
    { 
       return $this->join( 'BranchUsersModel', 'id', 'inner' )->where( 'branch_users.branch_id', $branchId, '=' )->getOne();
    }

    /**
     *获取用户信息
     */
    public function getUsers( $userIds,  $option = array(), $fields = self::FILED_COMMON_TYPE ) 
    {
        if( false == is_array( $fields ) ){
            $fields              = intval( $fields );
            if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
                $fields          = self::FILED_COMMON_TYPE;
            }

            $fields              = $this->fieldTypes[$fields];
        }
 
        $rowNums                 = array( ); 
        $rowNums[0]              = isset( $option['offset'] ) ? intval( $option['offset'] ) : $this->defaultOffset;
        $rowNums[1]              = isset( $option['limit'] )  ? intval( $option['limit'] )  : $this->pageLimit;
 
        return $this->where( 'id', $userIds, 'in' )->get( $rowNums, $fields ); 
    }
        
    /**
     *根据电话获取用户信息
     */
    public function getUserByMobile( $mobile, $fields = self::FILED_COMMON_TYPE ) {
        if( false == is_array( $fields ) ){
            $fields              = intval( $fields );
            if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
                $fields          = self::FILED_COMMON_TYPE;
            }

            $fields              = $this->fieldTypes[$fields];
        }

        return  $this->where( 'mobile', $mobile )->getOne( $fields );
    }

    /**
     *更新用户信息
     */
    public function updateUser( $user ) {

        $user['updated_at']      = date('Y-m-d H:i:s');
        return $this->update( $user );
    }

    /**
     *更新用户信息
     */
    public function updateUserInfo( $userId, $updates ) {

        $userINfo                = $this->byId( $userId );
        $data                    = array(
                                     'id' => $userId,
                                   );
        foreach( $this->dbFields as  $key => $value ){
            if( isset( $updates[$key] ) ){
               $data[$key]       = $updates[$key];     
            } 
        } 
        $data['updated_at']      = date('Y-m-d H:i:s');
 
        $res                     = $this->update( $data ); 
        return $res;
    }
}
