<?php

class LPTBroker extends DAO
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    {
        global $wpdb;

        $this->_daStruct['BaseTable'] =  'listing_office';
        $this->_daStruct['PrimaryKey'] = 'Office_ID';
    }
	public function viewAll($arrParams = array(), $addWhere = '', $customSelect = '')
	{
		if(isset($arrParams['broker_name']) && $arrParams['broker_name'] != '')
		{
			$addWhere.= " AND Office_Name LIKE '%".$arrParams['broker_name']."%'";
		}
		if(isset($arrParams['broker_id']) && $arrParams['broker_id'] != '')
		{
			$addWhere.= " AND Office_ID LIKE '".$arrParams['broker_id']."'";
		}

		return parent::viewAll($arrParams,$addWhere,$customSelect);
	}
}
?>