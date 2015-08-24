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
    						           array( 'username', 'zone_id', 'email', 'enabled', 'mobile', 'balance', 'coin', 'created_at', 'updated_at' ),
    					           );


    /**
     *获取用户信息
     */
    public function getUser( $userId, $fields = self::FILED_COMMON_TYPE ) {
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
     *根据电话获取用户信息
     */
    public function getUserByMobile( $userId, $fields = self::FILED_COMMON_TYPE ) {
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
        return $this->update( $user );
    }

    /**
     *更新用户信息
     */
    public function updateUser( $userId, $updates ) {

        $user                    = $this->byId( $userId );
        foreach( $updates as $key => $value ){
            $user[$key]          = $value;
        }

        return $this->updateUser( $user );
    }
}
