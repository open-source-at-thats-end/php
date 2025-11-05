<?php
require_once(dirname(__FILE__) . '/CustomClass.php');
#=============================================================================================================================
#	File Name		:	LeadEmail.php
#=============================================================================================================================
class LeadEmail extends CustomClass
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
	#=========================================================================================================================
	#	Function Name	:   LeadEmail
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
	    global $config;

	    # Table name
	    $this->Data['TableName']				=	$config['Table_Prefix']. 'lead_email';
        $this->Data['wp_users']			        =	'wp_users';
	    $this->Data['ListingEmail_TableName']	=	$config['Table_Prefix']. 'listing_email';
	    $this->Data['AdminTable']				=	$config['Table_Prefix']. 'subadmin_master';
	    $this->Data['AgentTable']				=	$config['Table_Prefix']. 'agent_roster_master';
	    $this->Data['User_Table']				=	$config['Table_Prefix']. 'user_master';
	    # Structure lead_followup

	    # Module title
	    $this->Data['L_Module']				=	'Lead Email Management';

	    # Primary field info
	    $this->Data['F_PrimaryKey']			=	'ldemail_id';
	    $this->Data['F_PrimaryField']		=	'ldemail_to';

	    # Help text
	    $this->Data['H_Manage']				=	'Manage Lead Email Information';
	    $this->Data['H_AddEdit']			=	'Update Lead Email information and click <b>Save</b> to save the changes.
												 Click <b>Cancel</b> to discard the changes.';
	    # Command list
	    $this->Data['C_CommandList']		=	array(A_EMAIL,A_VIEW,A_ADD,A_DELETE);
	    //$this->Data['C_CommandList']		=	array(A_VIEW, A_DELETE);
	    $this->Data['C_PopupSize']			=	'600, 550';

        # Field Information
        $this->Data['F_FieldInfo']				=
            array(
                'LeadEmailInformation'			=>	array(	GROUP_TITLE		=>	'Lead Email Information'),
                'ldemail_lead_id'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_user_id'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_subject'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_content' 				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_datetime'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_added_by_id'			=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_added_by_type'			=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_send_by_id'			=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_send_by_type'			=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_cc'					=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_ccother'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_bcc'					=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_sign'					=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_sent'					=>	array(	CNT_TYPE		=>	C_HIDDEN,
                    DEF_VAL			=>	'No',
                ),
                'ldemail_type'					=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_ref_id'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_to_name'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_to_email'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_from_name'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_from_email'				=>	array(	CNT_TYPE		=>	C_HIDDEN),
                'ldemail_use_header_footer'		=>	array(	CNT_TYPE		=>	C_HIDDEN),
            );

	    # Intialize parent class
	    parent::__construct();

	}

	#====================================================================================================
	#	Function Name	:   getQueryParameters
	#	Purpose			:	Get Parameters
	#----------------------------------------------------------------------------------------------------
    public function getQueryParameters($POST='')
	{
		global $usrInfo, $asset;

		$Parameters	 =	'';

		// IF Param Passed As POST data
		if(is_array($POST))
			$this->filter = $POST;

		if($this->filter)
		{
            # Show debug info
			if(DEBUG)
				$this->__debugMessage($Parameters);
		}
		else
		{

		}

		/* TODO : 2013-12-27 */
		/* Filtering data base on agent, Either lead received OR added by agent */
		if(AuthUser::obj()->User_Perm != ADMIN)
		{
			$Parameters	 .=	" AND (
								   (ldemail_send_by_id = '". AuthUser::obj()->UserID."' AND ldemail_send_by_type = '".AuthUser::obj()->User_Perm."')
								   OR
								   (ldemail_send_by_type = '".ADMIN."')
								   )";
		}

        //echo $Parameters;
		return $Parameters;
	}
	#====================================================================================================
	#	Function Name	:   getEmailCount
	#	Purpose			:	To get Notes counts
	#	Return			:	return Notes counts
	#----------------------------------------------------------------------------------------------------
    public function getEmailCount($user_id = '',$lead_id = '')
    {
		global $db;

		$addParams = $this->getQueryParameters();

		$sql = 	" SELECT count(*) as emailcount FROM ". $this->Data['TableName'] . " WHERE 1 ".$addParams;

		if($user_id)
		{
			$sql .= " AND ldemail_user_id =" . $user_id;
		}
		else
		{
			$sql .= " AND ldemail_lead_id =".$lead_id;
		}

		$sql .= "  ORDER BY ldemail_datetime DESC";
		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$rs = $db->query($sql);
		$rs = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

		return  $rs['emailcount'];
	}
	#=========================================================================================================================
	#	Function Name	:  getLeadEmail
	#	Purpose			:  Get Lead Email
	#	Return			:  None
	#------------------------------------------------------------------------------------------------------------------------
    public function getLeadEmail($user_id = '',$lead_id = '' ,$record,$totalrecords = '')
    {
		global $db;

		$addParams = $this->getQueryParameters();

		$sql = "SELECT * FROM ".$this->Data['TableName']." WHERE 1 ".$addParams;

		if($user_id)
		{
			$sql .= " AND ldemail_user_id =" . $user_id;
		}
		else
		{
			$sql .= " AND ldemail_lead_id =".$lead_id;
		}

		$sql .= "  ORDER BY ldemail_datetime ASC";


		if($record != 'ALL')
		{
			if($totalrecords != '' && $totalrecords > $record)
				$startlimit = $totalrecords - $record;
			else
				$startlimit = 0;

			$sql .= " LIMIT $startlimit,$record";
		}

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		return $db->query($sql);
	}
    public function GetLeadEmailWithLog($user_id = '', $record, $totalrecords = '')
    {
        global $db;

		$addParams = $this->getQueryParameters();

		$sql = "SELECT LE.*, 
				( CASE ldemail_send_by_type 
				 		WHEN '".ADMIN."' THEN CONCAT(admin_firstname,' ', admin_lastname) 
						WHEN '".AGENT."' THEN CONCAT(agent_first_name,' ', agent_last_name) 
					END
				) AS sender_name,
				UCASE( CASE ldemail_send_by_type 
				 		WHEN '".ADMIN."' THEN CONCAT(SUBSTR(admin_firstname,1,1),SUBSTR(admin_lastname,1,1)) 
						WHEN '".AGENT."' THEN CONCAT(SUBSTR(agent_first_name,1,1),SUBSTR(agent_last_name,1,1)) 
					END
				) AS sender_code,
                (
                    SELECT MAX(TEO.trkemail_date_time) 
                    FROM ".$this->Data['Table_Trk_Email_Open']." TEO 
                    WHERE TEO.trkemail_ldemail_id = LE.ldemail_id 
                ) AS trkemail_date_time_last,
                (
                    SELECT COUNT(*) 
                    FROM ".$this->Data['Table_Trk_Email_Open']." TEO 
                    WHERE TEO.trkemail_ldemail_id = LE.ldemail_id 
                ) AS total_email_open,
                (
                    SELECT COUNT(*) 
                    FROM ".$this->Data['Table_Trk_Link_Click']." TLC LEFT JOIN ".$this->Data['Table_Trk_Link_Master']." TLM 
                    ON TLC.trklinkclick_trklink_id = TLM.trklink_id 
                    WHERE TLM.trklink_ldemail_id =  LE.ldemail_id 
                ) AS total_link_click
                FROM  lead_email LE"."
					LEFT JOIN ".$this->Data['AdminTable']." AS A ON LE.ldemail_send_by_id = A.admin_id AND ldemail_send_by_type = '".ADMIN."'
					LEFT JOIN ".$this->Data['AgentTable']." AS AG ON LE.ldemail_send_by_id = AG.agent_id AND ldemail_send_by_type = '".AGENT."'
                WHERE LE.ldemail_user_id =  '".$user_id."'".$addParams."                
                ORDER BY LE.ldemail_datetime ASC ";
				//GROUP BY  LE.ldemail_id

		if($record != 'ALL')
		{
			if($totalrecords != '' && $totalrecords > $record)
				$startlimit = $totalrecords - $record;
			else
				$startlimit = 0;

			$sql .= " LIMIT $startlimit,$record";
		}

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		return $db->query($sql);
    }
	#====================================================================================================
	#	Function Name	:   Insert_ListingEmail
	#	Purpose			:	To Insert The listing email
	#	Return			:	return Notes counts
	#----------------------------------------------------------------------------------------------------
	public function Insert_ListingEmail($POST)
	{
		global $db;

		$sql = "INSERT INTO ".$this->Data['ListingEmail_TableName']."
				(lsemail_listingID,lsemail_sent_by_id,lsemail_sent_by_type,is_full_view_report,is_cma_report,lsemail_search_type) 
				VALUES ('".$POST['listingID']."',
						'".AuthUser::obj()->UserID."',
						'".AuthUser::obj()->User_Perm."',						
						'".(isset($POST['is_full_view_report']) ? $POST['is_full_view_report'] : 'No')."',
						'".(isset($POST['is_cma_report']) ? $POST['is_cma_report'] : 'No')."',
						'".$POST['lsemail_search_type']."')";
		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$db->query($sql);

		$pkId = $db->sql_inserted_id();

		return $pkId;
	}
	#====================================================================================================
	#	Function Name	:   getListingEmailByID
	#	Purpose			:	To get listing email record by id
	#	Return			:	return record
	#----------------------------------------------------------------------------------------------------
	public function getListingEmailByEncodedID($lsemail_id)
	{
		global $db;

		$sql = "SELECT LSE.*, LE.ldemail_user_id, LE.ldemail_id FROM ".$this->Data['ListingEmail_TableName']. " AS LSE"
			 //. " LEFT JOIN ".$this->Data['TableName']. " AS LE ON FIND_IN_SET(lsemail_id, ldemail_ref_id) AND ldemail_type = 'Property Report'"
			 . " LEFT JOIN ".$this->Data['TableName']. " AS LE ON lsemail_sent_id = ldemail_id"
			 . " WHERE MD5(lsemail_id) = '".$lsemail_id."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$rs = $db->query($sql);

		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}
	#=========================================================================================================================
	#	Function Name	:   UpdateSentListingEmailId
	#	Purpose			:	To keep ref. of email sent for this listing
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateSentListingEmailId($pk_id ,$email_id)
	{
		global $db;

		$pk_id = str_replace(",", "','", $pk_id);

		$sql = "UPDATE ".$this->Data['ListingEmail_TableName']." SET lsemail_sent_id = '".$email_id."' WHERE lsemail_id IN('".$pk_id."')";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute Query
		$db->query($sql);
	}
	#====================================================================================================
	#	Function Name	:   GetPendingMail
	#	Purpose			:	Fetch all email which are not sent yet
	#	Return			:	record set
	#----------------------------------------------------------------------------------------------------
	public function GetPendingMail($limit='')
	{
		global $db;

        /*$sql = "SELECT LE.*,CONCAT(U.user_first_name,' ', U.user_last_name) AS ToName, U.user_email AS ToEmail"
            . " FROM ".$this->Data['TableName']." AS LE"
            . " LEFT JOIN ".$this->Data['User_Table']." AS U ON U.user_wp_id = LE.ldemail_user_id"
            . " WHERE ldemail_sent = 'No'";*/

        $sql = "SELECT LE.*,U.display_name AS ToName, U.user_email AS ToEmail"
            . " FROM ".$this->Data['TableName']." AS LE"
            . " LEFT JOIN ".$this->Data['wp_users']." AS U ON U.ID = LE.ldemail_user_id"
            . " WHERE ldemail_sent = 'No'";

		//$sql .= " ORDER BY ldemail_datetime";
		$sql .= " ORDER BY ldemail_id DESC";
		$limit =1;
		if($limit != '')
			$sql .= " LIMIT 0,".$limit;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$rs = $db->query($sql);

		return $rs;
	}

	#====================================================================================================
	#	Function Name	:   UpdateMailStatus
	#	Purpose			:	Update Mail Status
	#	Return			:
	#----------------------------------------------------------------------------------------------------
	public function UpdateMailStatus($pk_id, $status)
	{
		global $db;

		$sql 	= " UPDATE ". $this->Data['TableName'] ." SET "
		 		. " ldemail_sent = '".$status."' WHERE ldemail_id = '". $pk_id ."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$db->query($sql);
	}
    /**
     * LeadEmail::GetUserIDFromLeadEmailID()
     *
     * @param int $ldemail_id = ID of lead email
     * @return user id
     */
    public function GetUserIDFromLeadEmailID($ldemail_id)
    {
        $info   =   $this->getInfoById($ldemail_id);
        return $info['ldemail_user_id'];
    }

	public function getInfoById2($emailId)
	{
		global $db;

		$sql = "SELECT *,
				( CASE ldemail_send_by_type 
				 		WHEN '".ADMIN."' THEN CONCAT(admin_firstname,' ', admin_lastname) 
						WHEN '".AGENT."' THEN CONCAT(agent_first_name,' ', agent_last_name) 
					END
				) AS sender_name,
				UCASE( CASE ldemail_send_by_type 
				 		WHEN '".ADMIN."' THEN CONCAT(SUBSTR(admin_firstname,1,1),SUBSTR(admin_lastname,1,1)) 
						WHEN '".AGENT."' THEN CONCAT(SUBSTR(agent_first_name,1,1),SUBSTR(agent_last_name,1,1)) 
					END
				) AS sender_code 
				FROM ".$this->Data['TableName']." AS N 
					LEFT JOIN ".$this->Data['AdminTable']." AS A ON N.ldemail_send_by_id = A.admin_id AND ldemail_send_by_type = '".ADMIN."'
					LEFT JOIN ".$this->Data['AgentTable']." AS AG ON N.ldemail_send_by_id = AG.agent_id AND ldemail_send_by_type = '".AGENT."'
				WHERE ldemail_id = '".$emailId."'";

		$rs = $db->query($sql);

		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}
}
?>