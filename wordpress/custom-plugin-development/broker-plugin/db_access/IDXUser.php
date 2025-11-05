<?php

require_once(dirname(__FILE__) . '/CustomClass.php');

class IDXUser extends CustomClass
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

        $this->Data['TableName']			        =	'user_master';
        $this->Data['wp_users']			            =	'wp_users';
	    $this->Data['UserFavoriteProperty']		    =	'user_favorite_property';
	    $this->Data['UserSavedSearches']		    =	'user_saved_searches';
        $this->Data['SendSavedSearches']		    =	'send_saved_searches';
        $this->Data['UserFavoriteCondo']		    =	'user_favorite_condo';
        $this->Data['F_PrimaryKey']                 =   'user_id';
        $this->Data['F_FieldInfo']				    =
            array(
                'user_agent_id'                     =>	array(	'title'			=>	'Agent Id',
                    'c_type'		=>	'text',
                ),
                'user_first_name'                     =>	array(	'title'			=>	'First Name',
                    'c_type'		=>	'text',
                ),
                'user_last_name'                     =>	array(	'title'			=>	'Last Name',
                    'c_type'		=>	'text',
                ),
                'user_address'               =>	array(	'title'			=>	'Address',
                    'c_type'		=>	'TextArea',
                ),
                'user_zipcode'                     =>	array(	'title'			=>	'Zipcode',
                    'c_type'		=>	'text',
                ),
                'user_city'                     =>	array(	'title'			=>	'City',
                    'c_type'		=>	'text',
                ),
                'user_state'                     =>	array(	'title'			=>	'State',
                    'c_type'		=>	'text',
                ),
                'user_phone'                     =>	array(	'title'			=>	'Phone',
                    'c_type'		=>	'text',
                ),
                'user_email'                     =>	array(	'title'			=>	'Email',
                    'c_type'		=>	'text',
                ),
                'user_added_by'                     =>	array(	'title'			=>	'Added By',
                    'c_type'		=>	'text',
                ),
                'user_type'                     =>	array(	'title'			=>	'User Type',
                    'c_type'		=>	'text',
                ),
                'user_added_by_type'                     =>	array(	'title'			=>	'Added Type',
                    'c_type'		=>	'text',
                ),
                'user_added_by_id'                     =>	array(	'title'			=>	'Added Id',
                    'c_type'		=>	'text',
                ),
                'user_wp_id'                     =>	array(	'title'			=>	'User WP ID',
                    'c_type'		=>	'text',
                ),
            );
        parent::__construct();
    }
    public function getUser($POST)
    {
        $result = array();
        if(!isset($POST['page_size'])){
            $POST['page_size'] = 0;
        }
        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

        $param = "ORDER BY user_id ASC LIMIT ". $startRecord .",".$POST['page_size'];
        $rsUser = parent::getAll($param);

        $result['rsUser'] = $rsUser->fetch_array();
        $totalFetched = parent::ViewAll('', true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }
    public function UpdateRegistration($POST)
    {
        global $db;
        $this->Data['F_PrimaryKey']                 =   'user_wp_id';
        $pk = $POST['user_wp_id'];
        parent::Update($pk, $POST);
    }
	public function UpdateFavorites($user_id,	$MLSNo, $Action,$Notes='')
	{
		global $db, $usrInfo;

		$arrTemp 	= explode("-",$MLSNo);
		//$fav_mls_num = $arrTemp[0].'-'.$arrTemp[1]; /* MS : 2014-02-28 In query we are concating these 2, so why here joining this, */
		$fav_mls_num = $arrTemp[0];
		$fav_mlsp_id = $arrTemp[1];
		$fav_user_id = $user_id;
		$fav_date_time = date('Y-m-d H:i:s');

		if ($Action==A_ADD)
		{
			$sql = "INSERT INTO ".$this->Data['UserFavoriteProperty']." 
					(fav_user_id, fav_mlsp_id, fav_mls_num,fav_date_time) 
					VALUES ('".$fav_user_id."','".$fav_mlsp_id."','".$fav_mls_num."', '".$fav_date_time."') 
					ON DUPLICATE KEY UPDATE fav_mls_num='".$fav_mls_num."',
					fav_date_time = '".$fav_date_time."'";

			//return $sql;
			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			/* Execute query */
			$db->query($sql);
		}
		elseif ($Action=='Remove')
		{
			$sql = "DELETE FROM ".$this->Data['UserFavoriteProperty']." WHERE fav_user_id = '".$fav_user_id."' AND fav_mls_num = '".$fav_mls_num."'";

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			/* Execute query */
			$db->query($sql);
		}
	}
	#=========================================================================================================================
	#	Function Name	:   getUserFav
	#	Purpose			:	Update the information
	#-------------------------------------------------------------------------------------------------------------------------
	public function getUserFav($user_id)
	{
		global $db;

		$arrRet = array();

		$addParams = "";
		// TODO : 2014-01-09 : If agenet logged in then display favs. added by user or the agent him self


		$sql	= "SELECT CONCAT(fav_mls_num, '-', fav_mlsp_id) AS ListingID_MLS, fav_mls_num FROM ". $this->Data['UserFavoriteProperty']. " WHERE fav_user_id = '". $user_id."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arrRes = $rs->fetch_array(MYSQLI_ASSOC, 'ListingID_MLS');

		$arrRet['arrIds'] = $arrRes;
		$arrRet['strIds'] = implode(",", array_keys($arrRes));

		return $arrRet;
	}
	public function InsertUnregisterUser($POST)
	{

		global $db, $arrAgent;

		//$POST['unregusr_email'] = 'jscolaro67@sbcglobal.net';
		$sql = "SELECT user_id,user_email FROM ".$this->Data['TableName']." WHERE user_email = '".$POST['user_email']."'";

		$rs2 = $db->query($sql);

		$rs = $rs2->fetch_array(MYSQLI_FETCH_SINGLE);

		if($rs['user_id'])
		{
			return $rs['user_id'];
		}
		else
		{
			if(defined('IN_AGENT'))
			{
				$POST['user_agent_id'] = $arrAgent['agent_id'];
			}
			$inserted_id = parent::Insert($POST);

			return $inserted_id;
		}

	}
	#=========================================================================================================================
	#	Function Name	:   getInfoByEmail
	#	Purpose			:	Get the information
	#	Return			:	Return info
	#-------------------------------------------------------------------------------------------------------------------------
	public function getInfoByEmail($user_email)
	{
		global $db;

		/*$sql	= " SELECT * "
			. " FROM ". $this->Data['TableName']
			. " WHERE user_email IN ('". $user_email. "') ";*/

		$sql	= " SELECT * "
			. " FROM ". $this->Data['wp_users']
			. " WHERE user_email IN ('". $user_email. "') ";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return ($rs->fetch_array(is_array($user_email)?'':MYSQLI_FETCH_SINGLE));
	}
	#=========================================================================================================================
	#	Function Name	:   IsUsernameExists
	#	Purpose			:	Check username already exists or not
	#	Return			:	Return status
	#-------------------------------------------------------------------------------------------------------------------------
	public function getUnregUserIdByEmail($user_email)
	{
		global $db;

		$sql =  " SELECT * "
			.  " FROM ". $this->Data['TableName']
			. 	" WHERE user_email = '". $user_email. "' ";

		/* Show debug info */
		if(DEBUG)
			$this->__debugMessage($sql);

		/* Execute query */
		$rs = $db->query($sql);
		$rs = $rs->fetch_array(MYSQLI_FETCH_SINGLE);
		if($rs['user_id'])
			return $rs['user_id'];

		return false;
	}
	public function Insert($POST)
	{


		$POST['user_signup_date'] 	= date('Y-m-d H:i:s');

		# Check if user is in user_master table or not
		$rsUnregUserId = $this->getUnregUserIdByEmail($POST['user_email']);

		# If availbale then get the id and update user id
		if($rsUnregUserId)
		{

			$POST['lead_user_id'] = $rsUnregUserId;
			$POST['user_type'] = 'Registered';

			$affected_row = parent::Update($rsUnregUserId,$POST);

			if($affected_row > 0){
				$userId = $rsUnregUserId;
			}
			else{
				$userId = $affected_row;
			}
		}
		else
		{


			$userId = parent::Insert($POST);

			$POST['lead_user_id'] = $userId;
		}


		//Insert into Lead Manage
		Lead::obj()->InsertRegistration($POST);

		# Make parent call for data insert
		return $userId;
	}
    #=========================================================================================================================
    #	Function Name	:   getInfoByEmail
    #	Purpose			:	Get the information
    #	Return			:	Return info
    #-------------------------------------------------------------------------------------------------------------------------
    public function InsertUserSaveSearch($POST)
    {
        global $db;

        $user_id = $POST['user_id'];
        $Item = $POST['search_crieteria'];
        $result_count = $POST['result_count'];
        $search_title = $POST['search_title'];
        $url = $POST['url'];
        $search_alert_type = 1;
        $listing_lastupdatedate = $POST['listing_lastupdatedate'];
        $search_saved_main_url = $POST['search_saved_main_url'];
        $search_site_agent = $POST['search_site_agent'];
        $search_saved_site = $POST['search_saved_site'];
        $search_page_slug = $POST['search_page_slug'];
        $search_added_by_type = 'User';

        $sql	= "INSERT INTO ". $this->Data['UserSavedSearches']
            . " ("
            . "search_user_id,"
            . "search_criteria,"
            . "search_resultcount,"
            . "search_title,"
            . "search_url,"
            . "search_lastrun,"
            . "search_alert_type,"
            . "search_send_till_lastupdatedate,search_added_by_id, search_added_by_type, search_site_agent, search_saved_main_url, search_saved_site, search_page_slug"
            . ") VALUES ("
            . "'".	$user_id.	"',"
            . "'".	serialize($Item).			"',"
            . "'".	$result_count.		"',"
            . "'".	$search_title.				"',"
            . "'".	$url.				        "',"
            . "'".	time().						"',"
            . "'".	$search_alert_type.						"',"
            . "'".	$listing_lastupdatedate.						"',"
            . "'".	$user_id.						"',"
            . "'".	$search_added_by_type.						"',"
            . "'".	$search_site_agent.						"',"
            . "'".	$search_saved_main_url.						"',"
            . "'".	$search_saved_site.						"',"
            . "'".	$search_page_slug.			"')";


        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        /* Execute query */
        $db->query($sql);

        return ($db->sql_inserted_id());
    }
	#=========================================================================================================================
	#	Function Name	:   getUserSearches
	#-------------------------------------------------------------------------------------------------------------------------
	public function getSearches($user_id = '')
	{
		global $db, $physical_path;

		if($user_id != '')
			$search_user_id = $user_id;
		else
			return false;


		$addParams = "";

		$sql = 	" SELECT * FROM ". $this->Data['UserSavedSearches']
			.	" WHERE search_user_id	= '". $search_user_id. "'".$addParams . 'ORDER BY search_id DESC';

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$rs = $db->query($sql);

		//$rs = $rsp->fetch_array();

		$arrRet = array();

		$i = 0;

		while($rs->next_record())
			//for($i=0; $i < count($rs); $i++)
		{
			$arrRet[$i] = $rs->Record;
			$arrRet[$i]['search_criteria'] 	= unserialize($rs->f('search_criteria'));
			$arrRet[$i]['current_count']	= IDXListing::obj()->getListingCountByParam($arrRet[$i]['search_criteria']);

			$i++;
		}

		$this->total_record = count($arrRet);

		return $arrRet;
	}
	#=========================================================================================================================
	#	Function Name	:   getSavedSearchById
	#-------------------------------------------------------------------------------------------------------------------------
	public function getSavedSearchById($id)
	{
		global $db;

		$sql = 	" SELECT * FROM ". $this->Data['UserSavedSearches']
			.	" WHERE search_id	= '". $id. "' ";

		# Execute query
		$rsp = $db->query($sql);

		return $rsp->fetch_array(MYSQLI_FETCH_SINGLE);
	}
	#=========================================================================================================================
	#	Function Name	:   DeleteSearch
	#-------------------------------------------------------------------------------------------------------------------------
	public function DeleteSearch($Search_ID)
	{
		global $db;

		$sql	= " DELETE FROM ". $this->Data['UserSavedSearches']
			. " WHERE search_id	= '". $Search_ID. "'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		return $db->query($sql);
	}
	public function getAllForSearchAlert()
    {
        global $db;

        $sql	= " SELECT S.*,ID, user_nicename,display_name,user_email FROM ". $this->Data['UserSavedSearches']
            . " AS S LEFT JOIN ". $this->Data['wp_users']. " AS U ON ID = search_user_id"
            . " WHERE search_alert_type != '0' AND 
					((search_alert_type = '1')) OR 
					((search_alert_type = '2') AND (DAYOFWEEK(CURDATE())=6)) OR 
					((search_alert_type = '3') AND (DAYOFMONTH(CURDATE())=4))  ";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        # Execute Query
        $rs = $db->query($sql);

        return $rs;
    }
    #=========================================================================================================================
    #	Function Name	:   Insert
    #-------------------------------------------------------------------------------------------------------------------------
    public function SaveUpdatedSearch($searchId, $criteria)
    {
        global $db;

        $Item['search_datetime']	= time();

        $sql	= "INSERT INTO ". $this->Data['SendSavedSearches']
            . " (user_search_id, user_usearch_criteria) VALUES ('".	$searchId ."', '". serialize($criteria)."')";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $db->query($sql);

        return ($db->sql_inserted_id());
    }
    #=========================================================================================================================
    #	Function Name	:   UpdateSentSearchEmailId
    #-------------------------------------------------------------------------------------------------------------------------
    public function UpdateSentSearchEmailId($search_id ,$email_id)
    {
        global $db;

        $sql = "UPDATE ".$this->Data['SendSavedSearches']." SET sent_email_id = '".$email_id."' WHERE user_usearch_id='".$search_id."'";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        # Execute Query
        $db->query($sql);
    }
    #=========================================================================================================================
    #	Function Name	:   UpdateSearchRunDate
    #-------------------------------------------------------------------------------------------------------------------------
    public function UpdateSearchRunDate($Search_ID, $listing_lastupdatedate='')
    {
        global $db;

        $Item['search_datetime']	= time();

        $sql	= " UPDATE ". $this->Data['UserSavedSearches']
            . " SET search_lastrun					= '".	time().						"', "
            . "		search_send_till_lastupdatedate	= '".	$listing_lastupdatedate.	"'"
            . " WHERE search_id	= '". $Search_ID.	"'  ";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $db->query($sql);

        return true;
    }
    #=========================================================================================================================
    #	Function Name	:   UpdateSavedSearchEmailAlert
    #-------------------------------------------------------------------------------------------------------------------------
    public function UpdateSavedSearchEmailAlert($email_alertid, $search_id)
    {
        global $db;
        $sql = "UPDATE ".$this->Data['UserSavedSearches']." SET search_alert_type = '".$email_alertid."' WHERE search_id='".$search_id."'";

        # Show debug info
        /*if(DEBUG == true);
            $this->__debugMessage($sql);*/

        # Execute Query
        $db->query($sql);

        return $db->affected_rows();
    }
    #=========================================================================================================================
    #	Function Name	:   getUserFavCondo
    #	Purpose			:	Update the information
    #-------------------------------------------------------------------------------------------------------------------------
    public function getUserFavCondo($user_id)
    {
        global $db;

        $arrRet = array();

        $addParams = "";

        $sql	= "SELECT fav_condo_id as CondoID FROM ". $this->Data['UserFavoriteCondo']. " WHERE fav_user_id = '". $user_id."'";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arrRes = $rs->fetch_array(MYSQLI_ASSOC, 'CondoID');

        $arrRet['arrIds'] = $arrRes;
        $arrRet['strIds'] = implode(",", array_keys($arrRes));

        return $arrRet;
    }
}
?>