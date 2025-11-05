<?php
class LPTUserActionLog extends DAO
{
	private static $instance;

	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}
	protected function __construct()
	{
		global $wpdb;

		$this->_daStruct['BaseTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'user_action_log';
		$this->_daStruct['StatsTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'user_stats';
		$this->_daStruct['F_PrimaryKey']				=	'log_id';
		$this->_daStruct['F_PrimaryField']			=	'log_action';
		$this->_daStruct['FieldInfo']       =   array(
			'log_action'				=>	array ('c_type'		=>	'hidden',
			),
			'log_user_id'				=> array ('c_type'		=>	'hidden',
			),
			'log_session_id'			=> array ('c_type'		=>	'hidden',
			),
			'log_ref_id'				=> array ('c_type'		=>	'hidden',
			),
			'log_datetime'				=>  array ('c_type'		=>	'hidden',
			),
			'log_ipaddress'				=>  array ('c_type'		=>	'hidden',
			),
			'log_city'					=> array ('c_type'		=>	'hidden',
			),
			'log_state'					=>  array ('c_type'		=>	'hidden',
			),
			'log_community'				=>  array ('c_type'		=>	'hidden',
			),
			'log_country'				=> array ('c_type'		=>	'hidden',
			),
			'log_price'				    => array ('c_type'		=>	'hidden',
			),
			'log_ptype'				    => array ('c_type'		=>	'hidden',
			),
			'log_bed'				    => array ('c_type'		=>	'hidden',
			),
			'log_zip'				    => array ('c_type'		=>	'hidden',
			),
			'log_listing_id'			=>  array ('c_type'		=>	'hidden',
			),
			'log_mlsp_id'				=> array ('c_type'		=>	'hidden',
			),
			'log_listing_type'			=> array ('c_type'		=>	'hidden',
			),
			'log_additional_info'		=> array ('c_type'		=>	'hidden',
			),
			'log_created_from'		    => array ('c_type'		=>	'hidden',
			),
		);
	}

	#====================================================================================================
	#	Function Name	:   InsertLog
	#	Purpose			:	Insert Log Details
	#	Return			:	return insert id
	#----------------------------------------------------------------------------------------------------
	public function InsertLog($log_action, $POST = array(), $userId = '0')
	{
		global $current_user;
		// Crawler logged in ? no need to insert log

		if(!is_array($POST))
			$POST = array();

		$POST['log_action']  	= $log_action;
		$POST['log_ipaddress']	= $_SERVER['REMOTE_ADDR'];

		if(is_object($current_user) && isset($current_user->ID))
		{
			$POST['log_user_id'] = $current_user->ID;
		}
		else
			$POST['log_user_id'] = $userId;

		$POST['log_ref_id'] 	= isset($POST['log_ref_id']) ? $POST['log_ref_id'] : 0;
		$POST['log_session_id'] =  $_SESSION['session_id'];
		$POST['log_datetime']	= date("Y-m-d H:i:s");

		# Check if log already inserted for today

		/*if(isset($POST['CheckAndInsert']))
		{
			$retVal = $this->IsLogExist($log_action, $POST['log_user_id'], $POST['log_ref_id'], $POST['log_listing_id']);

			// Not Exist ? Insert
			if(!$retVal)
			{
				# Make parent call for data insert
				return parent::Insert($POST);
			}
		}
		// Allow multiple entry for User Login, Listing Email To Friend, Schedule Showing, add/remove favourite/watch
		else
		{*/
			return parent::Insert($POST);

		/*}*/

	}
	public function getCronUser()
    {
        global $objDB;
        $sql = 'SELECT DISTINCT(log_ref_id) FROM '.$this->_daStruct['BaseTable'].' WHERE 1';


        $rs = $objDB->query($sql);
        return $rs->fetch_array();


    }
    public function getRecordByRefId($id)
    {
        global $objDB;
        $sql = 'SELECT * FROM '.$this->_daStruct['BaseTable'].' WHERE 1 AND log_action = "Full View" AND log_ref_id = "'.$id.'"';

        $rs = $objDB->query($sql);
        return $rs->fetch_array();



    }
    public function InsertStatstics($record)
    {
        global $objDB;
        $sql = "INSERT INTO ".$this->_daStruct['StatsTable']." VALUES ('". implode("','",$record)."')";
        //echo $sql;die;
        $rs = $objDB->query($sql);
    }
	public function truncate_table()
	{
		global $objDB;

		$sql = "TRUNCATE TABLE `".$this->_daStruct['StatsTable']."`";
		$rs = $objDB->query($sql);
		return $rs;
	}
}
?>