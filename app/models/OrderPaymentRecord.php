<?php
/**
 * @name OrderPaymentRecord
 * @desc OrderPaymentRecord
 * @author cway
 */
class OrderPaymentRecordModel extends DWDData_Db { 

    protected $dbTable           = 'order_payment_record';

    protected $fieldTypes        = array( 
    					               array( 'id', 'product_order_id', 'payment_method', 'amount', 'is_active', 'created_at', 'updated_at', 'refunded', 'refunded_at', 'refund_status' ),
                                   );
  
    /**
     *获取门店信息
     */
    public function getPaymentInfo( $orderId, $options = array(), $fields = self::FILED_COMMON_TYPE ) {
    	if( false == is_array( $fields ) ){
    		$fields              = intval( $fields );
    		if( $fields < 0 || $fields >= count( $this->fieldTypes ) ){
    			$fields          = self::FILED_COMMON_TYPE;
    		}

    		$fields              = $this->fieldTypes[$fields];
    	}

        $this->where('product_order_id', $orderId);
        if( isset( $options['active'] ) ){
            $this->where('is_active', $options['active']);
        }

        return $this->getOne( $fields );
    }
}
