<?php
/**
 * @name ItemModel
 * @desc ItemModel
 * @author cway
 */
class ItemModel extends DWDData_Db {

	protected $dbTable           = 'item'; 
    const MAX_TAGS               = 100;

    /**
     *获取单品信息
     */
    public function getItemInfo( $itemId ) {
    	 
        return $this->byId( $itemId );
    }
}