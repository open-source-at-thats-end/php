<?php
set_time_limit(1000); 
class LPTLeadMaster extends DAO
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

		$this->_daStruct['BaseTable'] =  'lead_master';
		$this->_daStruct['UserFav'] =  'user_favorite_property';
		$this->_daStruct['UserTable'] =  $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'user_action_log';
		$this->_daStruct['UserStats'] =  $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'user_stats';
        $this->_daStruct['wp_users']  = $wpdb->prefix . 'users';
		$this->_daStruct['LeadEmail'] =  'lead_email';
		$this->_daStruct['PrimaryKey'] = 'lead_id';
		$this->_daStruct['FieldInfo']				=
			array(
				'lead_type'               =>  array(
					'title'     =>  'Type',
					'c_type'    =>  'text',
				),

				'lead_user_id'               =>  array(
					'title'     =>  'User ID',
					'c_type'    =>  'text',
				),
				'lead_first_name'               =>  array(
					'title'     =>  'First Name',
					'c_type'    =>  'text',
				),
				'lead_last_name'                =>  array(
					'title'     =>  'Last Name',
					'c_type'    =>  'text',
				),
				'lead_home_phone'                    =>  array(
					'title'     =>  'Home Phone',
					'c_type'    =>  'text',
				),
				'lead_work_phone'                    =>  array(
					'title'     =>  'Work Phone',
					'c_type'    =>  'text',
				),
				'lead_mobile'                    =>  array(
					'title'     =>  'Mobile',
					'c_type'    =>  'text',
				),
				'lead_email'                    =>  array(
					'title'     =>  'Email',
					'c_type'    =>  'text',
				),
				'lead_cc_email'                    =>  array(
					'title'     =>  'CC Email',
					'c_type'    =>  'text',
				),
				'lead_comment'                    =>  array(
					'title'     =>  'Comment',
					'c_type'    =>  'textarea',
				),
				'lead_time_frame'                    =>  array(
					'title'     =>  'Time Frame',
					'c_type'    =>  'text',
				),
				'lead_note_desc'                    =>  array(
					'title'     =>  'Note Description',
					'c_type'    =>  'text',
				),
				'lead_pre_qualified'                    =>  array(
					'title'     =>  'Pre Qualified?',
					'c_type'    =>  'text',
				),
				'lead_source'                    =>  array(
					'title'     =>  'Source',
					'c_type'    =>  'text',
				),
				'lead_ip_address'                    =>  array(
					'title'     =>  'IP Address',
					'c_type'    =>  'text',
				),
				'lead_subs'                    =>  array(
					'title'     =>  'Subscription',
					'c_type'    =>  'text',
				),
				'lead_ListingID_MLS_ID'                    =>  array(
					'title'     =>  'Listing MLSP ID',
					'c_type'    =>  'text',
				),
				'lead_listing_Id'                    =>  array(
					'title'     =>  'Listing ID',
					'c_type'    =>  'text',
				),
				'lead_mlsp_id'                    =>  array(
					'title'     =>  'MLSP ID',
					'c_type'    =>  'text',
				),
				'lead_ref_id'                    =>  array(

					'c_type'    =>  'hidden',
				),
				'lead_listing_type'                    =>  array(
					'title'     =>  'Listing Type',
					'c_type'    =>  'text',
				),
				'lead_created_by'                    =>  array(
					'title'     =>  'Created By',
					'c_type'    =>  'text',
				),
				'lead_created_date'                    =>  array(
					'title'     =>  'Created Date',
					'c_type'    =>  'text',
				),
                'lead_additional_info'                    =>  array(
                    'c_type'    =>  'hidden',
                ),
			);
		parent::__construct();
	}

    public function getQueryParameters($POST)
    {
        global $config, $asset;

        $Parameters	 =	'';

        # FirstName
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_fname']) && $POST['csearch_fname'] != '' )
            $Parameters	 .=	" AND lead_first_name LIKE '%". $POST['csearch_fname']. "%' ";

        # LastName
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_lname']) && $POST['csearch_lname'] != '' )
            $Parameters	 .=	" AND lead_last_name LIKE '%". $POST['csearch_lname']. "%' ";

        # City
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_area_city']) && $POST['csearch_area_city'] != '' )
            $Parameters	 .=	" AND statstic_city_name LIKE '%". $POST['csearch_area_city']. "%' ";

        # ZipCode
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_zipcode']) && $POST['csearch_zipcode'] != '' )
        {
            $ret = preg_match_all("/[0-9-]+/", $POST['csearch_zipcode'], $keywords);

            if(count($keywords[0]) > 0)
            {
                $condition 	 = implode("%' OR statstic_zipcode LIKE '%", $keywords[0]);

                $Parameters	 .=	" AND ( statstic_zipcode LIKE '%". $condition. "%')";
            }
        }

        # LeadType
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_lead_type']) && $POST['csearch_lead_type'] != '' )
            $Parameters	 .=	" AND lead_type LIKE '%". $POST['csearch_lead_type']. "%' ";

        # Price Range
        # -----------------------------------------------------------------------------
        if (isset($POST['csearch_min_price']) && ($POST['csearch_min_price'] != '' && $POST['csearch_min_price'] != 'Any'))
                $Parameters .= " AND statstic_price >= ". $POST['csearch_min_price'];

        if (isset($POST['csearch_max_price']) && ($POST['csearch_max_price'] != '' && $POST['csearch_max_price'] != 'Any'))
                $Parameters .= " AND statstic_price <= ". $POST['csearch_max_price'];

        # PropertyType
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_ptype']) && $POST['csearch_ptype'] != '' )
            $Parameters	 .=	" AND statstic_ptype LIKE '%". $POST['csearch_ptype']. "%' ";

        # Source
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_source']) && $POST['csearch_source'] != '' )
            $Parameters	 .=	" AND lead_source LIKE '%". $POST['csearch_source']. "%' ";

        # TimeFrame
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['csearch_timeframe']) && $POST['csearch_timeframe'] != '' )
            $Parameters	 .=	" AND lead_time_frame LIKE '%". $POST['csearch_timeframe']. "%' ";

        # Tags
        #-----------------------------------------------------------------------------------------------------------------
        if($POST['csearch_tags'] != '')
        {
            $arrParams = array();

            $arrTags = explode(', ', $POST['csearch_tags']);

            $condition = implode("%' OR lead_subs LIKE '%", $arrTags);
            $strSearch	 =	" ( lead_subs LIKE '%". $condition. "%' ) ";

            array_push($arrParams, $strSearch);

            if(count($arrParams) > 0)
                $Parameters	 .=	" AND (".implode(" OR ", $arrParams).")";
        }

        #keyword
	    #-----------------------------------------------------------------------------------------------------------------
	    if(isset($POST['kword']) && trim($POST['kword']) != '')
	    {

		    $ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['kword'], $keywords);

		    $kword = explode(',',$POST['kword']);

		    $searchFields = array();

		    $searchFields[] = 'lead_first_name';
		    $searchFields[] = 'lead_last_name';
		    $searchFields[] = 'statstic_city_name';
		    $searchFields[] = 'statstic_zipcode';
		    $searchFields[] = 'lead_type';
		    $searchFields[] = 'lead_source';
		    $searchFields[] = 'statstic_ptype';
		    $searchFields[] = 'lead_subs';


		    $fieldsToSearch = implode(", ", $searchFields);

		    $arrMlsNum = array();

		    $arrAddKeyword = array();

		    $arrParams = array();

		    for($i=0; $i<count($kword); $i++)
		    {
			    $word = $kword[$i];

			    array_push($arrAddKeyword, $word);
		    }

		    if(count($arrAddKeyword) > 0)
		    {
			    // Street
			    $fieldsToSearch = implode(", ", $searchFields);

			    $strSearch      = implode("%' OR CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '%", $arrAddKeyword);
			    $strSearch  = " CONCAT_WS(', ',". $fieldsToSearch. ")  LIKE '%". $strSearch."%'";

			    array_push($arrParams, $strSearch);

		    }

		    if(count($arrParams) > 0)
			    $Parameters	 .=	" AND (".implode(" OR ", $arrParams).")";
	    }

        # PropertyType
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['type']) && $POST['type'] != '' )
            $Parameters	 .=	" AND lead_subs LIKE '%". $POST['type']. "%' ";

        # Email Subject
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['usearch_subject']) && $POST['usearch_subject'] != '' )
            $Parameters	 .=	" AND ldemail_subject LIKE '%". $POST['usearch_subject']. "%' ";

        # Email Date
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['usearch_date']) && $POST['usearch_date'] != '' )
            $Parameters	 .=	" AND ldemail_datetime LIKE '". $POST['usearch_date']. "%' ";

        return $Parameters;
    }

	public function InsertRegistration($POST){

		$POST['lead_type'] = 'Registration';

		if (!isset($POST['lead_created_by']))
			$POST['lead_created_by'] = 'Site';

		$POST['lead_created_date'] = date('Y-m-d H:i:s');
		$POST['lead_home_phone']  = isset($POST['user_phone']) ? $POST['user_phone']:'';
		$POST['lead_work_phone']  = isset($POST['user_work_phone']) ? $POST['user_work_phone']:'';
		$POST['lead_mobile']	  = isset($POST['user_mobile']) ? $POST['user_mobile'] : '';
		$POST['lead_first_name']  = $POST['user_first_name'];
		$POST['lead_last_name']   = $POST['user_last_name'];
		$POST['lead_email']       = $POST['user_email'];
		$POST['lead_agent_id']    = isset($POST['user_agent_id']) ? $POST['user_agent_id'] : 0;
		$POST['lead_ref_id']      = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : 0;

		$POST['lead_from_site']    = 2;

		# Make parent call for data insert
		return parent::Insert($POST);

	}

	public function InsertScheduleShowing($POST)
	{
		$POST['lead_type'] = 'ScheduleShowing';

		if (!isset($POST['lead_created_by']))
			$POST['lead_created_by'] = 'Site';

		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		$POST['lead_from_site']    = 2;

		# Make parent call for data insert
		return parent::Insert($POST);
	}

	public function getRegisterAndUnregisterUser($POST)
	{

		$addWhere = " AND lead_email != '' GROUP BY lead_email ";

		return parent::ViewAll($POST, $addWhere);
	}

	public function getUserById($user_id)
	{
		$addWhere = " AND lead_user_id = '".$user_id."'";
		return parent::getInfoByParam($addWhere, '', MYSQLI_FETCH_SINGLE);
	}
    public function getUserByRefId($user_ref_id)
    {
        $addWhere = " AND lead_ref_id = '".$user_ref_id."'";
        return parent::getInfoByParam($addWhere, '', MYSQLI_FETCH_SINGLE);
    }
	public function getAllUser($POST)
	{
		global $objDB;

        $addWhere ='';

        $addWhere .= $this->getQueryParameters($POST);

		$arrReturn = array();
		$arrPageSize = StaticArray::arrPageSize();
		$POST['page_size'] = $POST['page_size'] ? $POST['page_size'] : $arrPageSize[2];	//RESULT_PAGESIZE;
		$startRecord 			= ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

		$sql =	" SELECT count(*) as cnt ".
			" FROM ". $this->_daStruct['BaseTable']." AS M ".
            " LEFT JOIN ".$this->_daStruct['UserTable']." AS U ON M.lead_ref_id = U.log_ref_id";

		$sql .= " WHERE 1 ". $addWhere." GROUP BY lead_ref_id";

		# Debug sql
		if (WP_DEBUG)
			echo '<br><br>'. $sql;

		# Execute query
		$rs = $objDB->query($sql);
		$rs->next_record();


		//$arrReturn['totalRecord'] = $rs->f("cnt");
		$arrReturn['totalRecord'] = $rs->TotalRow;
		$rs->free();

		if (!$POST['allRecord'])
		{
			if($startRecord >= $arrReturn['totalRecord'] || $POST['page_size'] >= $arrReturn['totalRecord'] || !isset($startRecord))
				$startRecord = 0;
		}
		//$sql = " SELECT * FROM ".$this->_daStruct['BaseTable']." AS M LEFT JOIN ".$this->_daStruct['UserTable']." AS U ON M.lead_ref_id = U.log_ref_id AND  U.log_datetime = (SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id) OR (M.lead_created_by = 'Admin') WHERE 1 ". $addWhere." GROUP BY M.lead_ref_id";
		$sql = " SELECT * FROM ".$this->_daStruct['BaseTable']." AS M LEFT JOIN ".$this->_daStruct['UserTable']." AS U ON (M.lead_ref_id = U.log_ref_id AND  U.log_datetime = (SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id)) WHERE 1 ";

		$sql .= $addWhere." GROUP BY M.lead_ref_id";

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $startRecord. ", ". $POST['page_size'];

		$rs = $objDB->query($sql);

		$arrReturn['rsData'] = $objDB->query($sql);
		$arrReturn['totalFetched'] = $arrReturn['rsData']->TotalRow;
		$arrReturn['startRecord'] = $startRecord;

		return $arrReturn;
	}
	public function getUsers($POST)
	{
	    global $objDB;

        $addWhere ='';

        $addWhere .= $this->getQueryParameters($POST);

        $arrReturn = array();
		$arrPageSize = StaticArray::arrPageSize();
		$POST['page_size'] = $POST['page_size'] ? $POST['page_size'] : $arrPageSize[2];	//RESULT_PAGESIZE;

		$startRecord 			= ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

		$sql =	" SELECT count(*) as cnt ".
			" FROM ". $this->_daStruct['BaseTable']." AS M ".
            " LEFT JOIN ".$this->_daStruct['UserStats']." AS U ON M.lead_ref_id = U.statstic_ref_id";

		$sql .= " WHERE 1 ". $addWhere;

		# Debug sql
		if (WP_DEBUG)
			echo '<br><br>'. $sql;

		# Execute query
		$rs = $objDB->query($sql);
		$rs->next_record();

	    $arrReturn['totalRecord'] = $rs->f("cnt");

	    	$rs->free();

		if (!$POST['allRecord'])
		{
			if($startRecord >= $arrReturn['totalRecord'] || $POST['page_size'] >= $arrReturn['totalRecord'] || !isset($startRecord))
				$startRecord = 0;
		}
		//$sql = " SELECT * FROM ".$this->_daStruct['BaseTable']." AS M LEFT JOIN ".$this->_daStruct['UserTable']." AS U ON M.lead_ref_id = U.log_ref_id AND  U.log_datetime = (SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id) OR (M.lead_created_by = 'Admin') WHERE 1 ". $addWhere." GROUP BY M.lead_ref_id";
		/*$sql = " SELECT *, 
 				(SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id) as log_datetime, 
 				(SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id AND log_action IN ('Schedule Showing', 'Registration')) as system_datetime,
                (SELECT count(*) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id AND log_action='Full View') as viewed_property

 				FROM ".$this->_daStruct['BaseTable']." AS M LEFT JOIN ".$this->_daStruct['UserStats']." AS U ON M.lead_ref_id = U.statstic_ref_id WHERE 1 ". $addWhere." ORDER BY log_datetime DESC";*/
 				
 	
 		    	$sql = " SELECT *, 
 				IF((SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id) != NULL, (SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id), lead_created_date) as log_datetime, 
 				(SELECT MAX(log_datetime) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id AND log_action IN ('Schedule Showing', 'Registration')) as system_datetime,
                (SELECT count(*) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id AND log_action='Full View') as viewed_property,
                (SELECT COUNT(ldemail_id) FROM ".$this->_daStruct['LeadEmail']." WHERE ldemail_user_id > 0 AND ldemail_user_id = M.lead_user_id) as sent_emails,
                (SELECT COUNT(*) FROM ".$this->_daStruct['LeadEmail']." WHERE ldemail_user_id > 0 AND ldemail_user_id = M.lead_user_id AND ldemail_open_datetime != NULL AND ldemail_open_count > 0) as open_emails,
                (SELECT MAX(ldemail_open_datetime) FROM ".$this->_daStruct['LeadEmail']." WHERE ldemail_user_id > 0 AND ldemail_user_id = M.lead_user_id AND ldemail_open_datetime != NULL AND ldemail_open_count > 0) as open_datetime,
				IF((SELECT COUNT(fav_id) FROM ".$this->_daStruct['UserFav']." WHERE fav_user_id = M.lead_user_id) > 0, (SELECT COUNT(fav_id) FROM ".$this->_daStruct['UserFav']." WHERE fav_user_id = M.lead_user_id), 0) AS total_favorites
 				FROM ".$this->_daStruct['BaseTable']." AS M LEFT JOIN ".$this->_daStruct['UserStats']." AS U ON M.lead_ref_id = U.statstic_ref_id WHERE 1 ". $addWhere." ORDER BY log_datetime DESC";
 		


		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $startRecord. ", ". $POST['page_size'];

		$rs = $objDB->query($sql);

		$arrReturn['rsData'] = $objDB->query($sql);
		$arrReturn['totalFetched'] = $arrReturn['rsData']->TotalRow;
		$arrReturn['startRecord'] = $startRecord;

		return $arrReturn;
	}
    public function DeleteUser($id, $refId)
    {
        global $objDB;
        $where = '';


        # Define query
         if (isset($refId) && $refId != '')
         {
             $sql = " DELETE FROM ". $this->_daStruct['UserTable'].
                 " WHERE log_ref_id = ".$refId;

             $rs = $objDB->query($sql);
             $where .= " AND lead_ref_id = '".$refId."'";
         }
         
         
        $sql = " DELETE FROM ". $this->_daStruct['BaseTable'].
            " WHERE lead_id = ".$id.$where;

        $rs = $objDB->query($sql);

        return true;

        /*$sql = 	" DELETE " . $this->_daStruct['BaseTable'] .','.$this->_daStruct['UserTable'].
            " FROM ". $this->_daStruct['BaseTable'] .
            " INNER JOIN " . $this->_daStruct['UserTable'] . " ON " . $this->_daStruct['BaseTable'].".lead_ref_id = " . $this->_daStruct['UserTable'].".log_ref_id" .
            " WHERE " . $this->_daStruct['BaseTable'].".lead_ref_id = ".$refId;*/
    }
    public function getUsersViewedListings($POST)
    {
        global $objDB;

        $arrReturn      = array();
        $arrPageSize    = StaticArray::arrPageSize();

        $POST['page_size'] = $POST['page_size'] ? $POST['page_size'] : $arrPageSize[2];	//RESULT_PAGESIZE;

        $startRecord 			= ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

        $sql =	" SELECT count(*) as cnt ".
                " FROM ". $this->_daStruct['UserTable']." AS U ".
                " LEFT JOIN ".$this->_daStruct['BaseTable']." AS M ON U.log_ref_id = M.lead_ref_id";

        $sql .= " WHERE U.log_ref_id=".$POST['refId']." AND U.log_action = 'Full View' AND U.log_additional_info != '' ";

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        # Execute query
        $rs = $objDB->query($sql);
        $rs->next_record();

        $arrReturn['totalRecord'] = $rs->f("cnt");

        $rs->free();

        if (!$POST['allRecord'])
        {
            if($startRecord >= $arrReturn['totalRecord'] || $POST['page_size'] >= $arrReturn['totalRecord'] || !isset($startRecord))
                $startRecord = 0;
        }

        $sql =  " SELECT U.log_additional_info, M.lead_first_name, M.lead_last_name FROM ".$this->_daStruct['UserTable']." AS U ".
                " LEFT JOIN ".$this->_daStruct['BaseTable']." AS M ON M.lead_ref_id = U.log_ref_id ".
                " WHERE U.log_ref_id=".$POST['refId']." AND U.log_action = 'Full View' AND U.log_additional_info != '' ORDER BY U.log_datetime DESC";

        if (!$POST['allRecord'])
            $sql .=  " LIMIT ". $startRecord. ", ". $POST['page_size'];

        $rs = $objDB->query($sql);

        $arrReturn['rsData'] = $objDB->query($sql);
        $arrReturn['totalFetched'] = $arrReturn['rsData']->TotalRow;
        $arrReturn['startRecord'] = $startRecord;

        return $arrReturn;
    }
    public function getUserSentEmail($POST)
    {
        global $objDB;

        $addWhere ='';

        $addWhere .= $this->getQueryParameters($POST);

        $arrReturn      = array();
        $arrPageSize    = StaticArray::arrPageSize();

        $POST['page_size'] = $POST['page_size'] ? $POST['page_size'] : $arrPageSize[2];	//RESULT_PAGESIZE;

        $startRecord    = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

        $sql =	" SELECT count(*) as cnt ".
        " FROM ". $this->_daStruct['LeadEmail']." AS LM ";

        $sql .= " WHERE LM.ldemail_user_id=".$POST['userId']." AND LM.ldemail_sent = 'Yes'". $addWhere;

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        # Execute query
        $rs = $objDB->query($sql);
        $rs->next_record();

        $arrReturn['totalRecord'] = $rs->f("cnt");

        $rs->free();

        if (!$POST['allRecord'])
        {
            if($startRecord >= $arrReturn['totalRecord'] || $POST['page_size'] >= $arrReturn['totalRecord'] || !isset($startRecord))
                $startRecord = 0;
        }

        $sql =  " SELECT * FROM ".$this->_daStruct['LeadEmail']." AS LM ".
                " WHERE LM.ldemail_user_id=".$POST['userId']." AND LM.ldemail_sent = 'Yes'".$addWhere." ORDER BY LM.ldemail_datetime DESC";

        if (!$POST['allRecord'])
            $sql .=  " LIMIT ". $startRecord. ", ". $POST['page_size'];

        $rs = $objDB->query($sql);

        $arrReturn['rsData'] = $objDB->query($sql);
        $arrReturn['totalFetched'] = $arrReturn['rsData']->TotalRow;
        $arrReturn['startRecord'] = $startRecord;

        return $arrReturn;
    }

    public function InsertContactFromLeads($POST)
    {
        $POST['lead_type'] = 'ContactForm';

        $POST['lead_created_date'] = date('Y-m-d H:i:s');

        $POST['lead_additional_info'] = serialize($POST);

        if(isset($POST['your-first-name']) && $POST['your-first-name'] != '')
            $POST['lead_first_name'] = $POST['your-first-name'];

        if(isset($POST['your-last-name']) && $POST['your-last-name'] != '')
            $POST['lead_last_name'] = $POST['your-last-name'];

        if(isset($POST['your-phone']) && $POST['your-phone'] != '')
            $POST['lead_mobile'] = $POST['your-phone'];

        if(isset($POST['your-email']) && $POST['your-email'] != '')
            $POST['lead_email'] = $POST['your-email'];

        # Make parent call for data insert
        return parent::Insert($POST);
    }

    public function getAllStatistics()
    {
        global $objDB;

        $sql =  " SELECT US.*, M.lead_user_id, M.lead_ref_id FROM ".$this->_daStruct['UserStats']." AS US "
            . " LEFT JOIN ".$this->_daStruct['BaseTable']." AS M ON M.lead_ref_id = US.statstic_ref_id"
            . " WHERE statstic_save_search = 'No' AND lead_user_id > 0";

        $sql .= " GROUP BY US.statstic_ref_id DESC";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        # Execute query
        $rs = $objDB->query($sql);

        return $rs;
    }

    public function updateStatisticsSaveSearchValue($ref_id)
    {
        global $db;

        $sql = "Update ".$this->_daStruct['UserStats']." SET statstic_save_search = 'Yes' WHERE statstic_ref_id = ".$ref_id;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $db->query($sql);

        return true;
    }

    public function getUserInsightsByRefId($refId)
    {
        global $objDB;

        $sql = " SELECT *,
                (SELECT count(*) FROM ".$this->_daStruct['UserTable']." AS U2 where U2.log_ref_id=M.lead_ref_id AND log_action='Full View') as viewed_property,
                (SELECT COUNT(ldemail_id) FROM ".$this->_daStruct['LeadEmail']." WHERE ldemail_user_ref_id > 0 AND ldemail_user_ref_id = M.lead_user_id) as sent_emails,
                (SELECT COUNT(*) FROM ".$this->_daStruct['LeadEmail']." WHERE ldemail_user_id > 0 AND ldemail_user_id = M.lead_user_id AND ldemail_open_datetime IS NOT NULL AND ldemail_open_count > 0) as open_emails,
				IF((SELECT COUNT(fav_id) FROM ".$this->_daStruct['UserFav']." WHERE fav_user_id = M.lead_user_id) > 0, (SELECT COUNT(fav_id) FROM ".$this->_daStruct['UserFav']." WHERE fav_user_id = M.lead_user_id), 0) AS total_favorites
 				FROM ".$this->_daStruct['BaseTable']." AS M LEFT JOIN ".$this->_daStruct['UserStats']." AS U ON M.lead_ref_id = U.statstic_ref_id WHERE 1 AND M.lead_ref_id=".$refId;

        $rs = $objDB->query($sql);
        $arrReturn['rsData'] = $objDB->query($sql);
        return $arrReturn;
    }
}

?>