<?php
#=============================================================================================================================
#	File Name		:	Lead.php
#=============================================================================================================================
class Lead extends CustomClass
{

    public static $Instance;

	public static function obj($isPopulateSchema=false)
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self($isPopulateSchema);

		return self::$Instance;
	}

	#=========================================================================================================================
	#	Function Name	:   Lead
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    public function __construct($isPopulateSchema=false)
    {
       	global $config,$asset,$physical_path,$virtual_path;

		# Table name
		$this->Data['TableName']			=	$config['Table_Prefix']. 'lead_master';
		$this->Data['FollowUp']				=	$config['Table_Prefix']. 'lead_followup';
		$this->Data['LeadNotesTable']		=	$config['Table_Prefix']. 'lead_notes';
		$this->Data['UserTable']			=	$config['Table_Prefix']. 'user_master';
		$this->Data['AgentTable']			=	$config['Table_Prefix']. 'agent_roster_master';

		$this->Data['Session_Table']		=	$config['Table_Prefix']. 'session_master';
		$this->Data['Log_Table']			=	$config['Table_Prefix']. 'user_action_log';
		$this->Data['LeadEmailTable']		=	$config['Table_Prefix']. 'lead_email';

		# Module title
		$this->Data['L_Module']				=	'Report Manager';

		# Primary field info
		$this->Data['F_PrimaryKey']			=	'lead_id';
		$this->Data['F_PrimaryField']		=	'lead_type';

		# Help text
		$this->Data['H_Manage']				=	"View all user's lead from the website. Also do search for quick access of any particular user and manage actions of the user for particular lead.";
		$this->Data['H_AddEdit']			=	'Update Lead information and click <b>Save</b> to save the changes.
												 Click <b>Cancel</b> to discard the changes.';

		$this->Data['F_Visibility']			=	'lead_is_deleted';
		# Primary field info
		$this->Data['F_PrimaryKey']			=	'lead_id';
		$this->Data['F_PrimaryField']		=	'lead_name';
//		$this->Data['F_AuthUser']			=	'lead_auth_id';	MS [Saturday, August 31, 2013]

		$this->Data['P_Upload']				=	$physical_path['Upload']. '/lead';
		$this->Data['V_Upload']				=	$virtual_path['Upload']. '/lead';

		# Custom Sorting Headres
		$this->arrCustomHeaderSort 			= array('first_login_date','last_login_date','re_hwc','lo_hwc','recieve_date');

		$this->Data['arrLead_Type'] 		= array("ContactUs" 				=>	"Contact Us",
													"Registration"				=>	"New Registration",
													"ScheduleShowing"			=>	"Schedule Showing",
													"PropertyInquiry"		    =>  "Property Inquiry",
													"Inquiry"					=>	"Inquiry",
                                                    "DevelopmentInquiry"        =>  "DevelopmentInquiry",
													//"FranchiseRequest"			=>	"Franchise Request",
													//"MaintenanceRequest"		=>	"Maintenance Request",
													//"PropertyManagementQuote"	=>	"Property Management Quote",
													//"PropertyValuation"			=>	"Property Valuation Request",
                                                   LEAD_NEWSLETTER                  =>  "Newsletter",
                                                    //SELLERREQUEST               =>  "Seller Request",
                                                    //HOMEVALUEREQUEST            =>  "Home Valuation Request",
                                                  /* LEAD_SELLERINQUIRY					=>	"Seller Inquiry",
                                                   LEAD_BUYERINQUIRY					=>	"Buyer Inquiry",
                                                   LEAD_CAREERINQUIRY					=>	"Career Inquiry",*/

													);

		$this->Data['arrLead_Method'] 		= array("No preference" 	=>	"No Preference",
													"Phone"				=>	"Phone",
													"Email"				=>	"Email",
													);

		# Field information, keys are NOT database field
		$this->Data['F_HeaderItem']				=
			array(
					'lead_fullname'				=>	array(	TITLE	=>	'User Name',
															WIDTH	=>	'15%',
															IS_INFO	=>	true,
														),
					'agent_name'				=>	array(	TITLE	=>	'Agent',
															WIDTH	=>	'15%',
														),
					'lead_email'				=>	array(	TITLE	=>	'Contact Info',
															WIDTH	=>	'25%',
															IS_INFO	=>	true,
														),
					'lead_type'					=>	array(	TITLE	=>	'Lead Type',
															WIDTH	=>	'25%',
														),
					'lead_created_date'			=>	array(	TITLE	=>	'Received From / Date',
															WIDTH	=>	'15%',
														),
				);



		# Field Information
		$this->Data['F_FieldInfo']				=
			array(
					'LeadManagementInformation'	=>	array(	GROUP_TITLE		=>	'Lead Management Information'),
					'lead_type'					=>	array(	TITLE			=>	'Lead Type',
															CNT_TYPE		=>	C_COMBOBOX,
															OPTION			=>	$this->Data['arrLead_Type'],
														),
					'lead_first_name'					=>	array(	TITLE	=>	'First Name',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
															VALIDATE		=>	true,
															VAL_TYPE		=>	V_EMPTY,
														),
					'lead_last_name'					=>	array(	TITLE	=>	'Last Name',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
															VALIDATE		=>	true,
															VAL_TYPE		=>	V_EMPTY,
														),
					'lead_company_name'			=>	array(	TITLE			=>	'Company Name',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	100,
														),
					'lead_department'			=>	array(	TITLE			=>	'Department',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	100,
														),
					'lead_address'				=>	array(	TITLE			=>	'Address',
															CNT_TYPE		=>	C_TEXTAREA,
														),
					'lead_zipcode'				=>	array(	TITLE			=>	'Zipcode',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	150,
														),
					'lead_city_state'			=>	array(	TITLE			=>	'City, State',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	150,
														),
					'lead_city'					=>	array(	TITLE	=>	'City',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'lead_state'					=>	array(	TITLE	=>	'State',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,

														),
					'lead_county'					=>	array(	TITLE	=>	'County',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,

														),
					'lead_home_phone'				=>	array(	TITLE			=>	'Home Phone',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
														),

					'lead_work_phone'				=>	array(	TITLE			=>	'Work Phone',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
														),
					 'lead_mobile'				=>	array(	TITLE			=>	'Mobile',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
														),
					 'lead_fax'				=>	array(	TITLE			=>	'Fax',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
														),
					'lead_email'				=>	array(	TITLE			=>	'Email',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
															VALIDATE		=>	true,
															VAL_TYPE		=>	V_EMPTY|V_EMAIL,
														),
					'lead_preferred_contact_method'		=> array(	TITLE	=>	'Contact Method',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),
					'lead_contact_loc'					=>	array(	TITLE	=>	'Contact Location',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),
					'lead_bst_time_to_call'					=>	array(	TITLE	=>	'Best Time To Call',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),
					'lead_preferred_date'		=>	array(	TITLE			=>	'Preferred Date',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),
					'lead_preferred_time'		=>	array(	TITLE			=>	'Preferred Time',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),
					'lead_preferred_method'		=>	array(	TITLE			=>	'Preferred Method',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),
					'lead_preferred_language'		=>	array(	TITLE			=>	'Preferred Language',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),

					'lead_comment'				=>	array(	TITLE			=>	'Comment',
															CNT_TYPE		=>	C_TEXTAREA,
														),
					'lead_ListingID_MLS_ID'		=>	array(	CNT_TYPE		=>	C_HIDDEN,
														),
					'lead_listing_type'			=>	array(	CNT_TYPE		=>	C_HIDDEN,
														),
					'lead_auth_id'				=>	array(	CNT_TYPE		=>	C_HIDDEN,
														),
					'lead_user_id'				=>	array(	CNT_TYPE		=>	C_HIDDEN,
														),
					'lead_created_by'			=>	array(	CNT_TYPE		=>	C_HIDDEN,
															DEF_VAL			=>	ADMIN,
														),
					'lead_created_date'			=>	array(	CNT_TYPE		=>	C_HIDDEN,
															DEF_VAL			=>	date('Y-m-d'),
														),
					'lead_note_desc'					=>	array(	TITLE	=>	'Lead Note',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	30,
															CNT_MAXLEN		=>	50,
														),
					'lead_mlsp_id'						=> array( CNT_TYPE => HIDDEN),
					'lead_listing_Id'					=> array( CNT_TYPE => HIDDEN),

					'lead_prop_beds'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_size'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_budget'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_address'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_unit'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_type'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_city'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_state'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_zipcode'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_builtyear'				=> array( CNT_TYPE => HIDDEN),
					'lead_is_onsite_manager'			=> array( CNT_TYPE => HIDDEN),
					'lead_gross_income'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_related_document'		=> array( CNT_TYPE => C_FILE),
					'lead_prop_baths'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_parking'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_condition'				=> array( CNT_TYPE => HIDDEN),
					'lead_prop_parking_spaces'			=> array( CNT_TYPE => HIDDEN),
					'lead_prop_lotsize'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_status'					=> array( CNT_TYPE => HIDDEN),
					'lead_prop_approx_sqft'				=> array( CNT_TYPE => HIDDEN),
					'lead_prop_plan_to_sell'			=> array( CNT_TYPE => HIDDEN),
					'lead_prop_basement'				=> array( CNT_TYPE => HIDDEN),
					'lead_free_report_type'				=> array( CNT_TYPE => HIDDEN),

					'lead_agent_id'						=> array( CNT_TYPE => HIDDEN),
                    'lead_employee_id'					=> array( CNT_TYPE => HIDDEN),
					'lead_from_site'					=> array( CNT_TYPE => HIDDEN),

				);

		# delete from these tables when lead is deleted
		$this->delete_relation	 = array(
										 'lead_followup' 		=> 	'ldfollow_lead_id',
									    );

		# Intialize parent class
		parent::__construct();
	}

	#====================================================================================================
	#	Function Name	:   getSearchFilter
	#	Purpose			:	Provide filter criteria data
	#	Return			:	None
	#----------------------------------------------------------------------------------------------------
    public function getSearchFilter()
    {

		# Date Period fields
		$this->Data['DatePeriod']	=	array(	''			=>	'All dates',
												'Month'		=>	'This month',
												'Week'		=>	'This week',
												'Today'		=>	'Today',
												'Period'	=>	'Specify the period below',
											);

		$this->Data['FilterData']	=
			array(
					'lead_type'			=>	$this->Data['arrLead_Type'],
					'lead_date_period'	=>  $this->Data['DatePeriod'],
				);


		return $this->Data['FilterData'];
	}

	#====================================================================================================
	#	Function Name	:   getQueryParameters
	#	Purpose			:	Get Parameters
	#	Return			:	return default order status with status id
	#----------------------------------------------------------------------------------------------------
    public function getQueryParameters()
	{
		global $usrInfo;
		$Parameters	 =	'';
		//Utility::pre($this->filter);
		if($this->filter)
		{
			# User ID
			# -----------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['user_id']) && $this->filter['user_id'] != '')
				$Parameters	 .=	" AND lead_user_id IN('". $this->filter['user_id']."')";

			# Laed Name
			# --------------------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['lead_name']) && $this->filter['lead_name'] != '')
			{
                $arrKeyword = str_replace(', ',' ', $this->filter['lead_name']);

                $leadname = explode(" ", $this->filter['lead_name']);

                $searchFields = array();
                $searchFields[] = 'lead_first_name';
                $searchFields[] = 'lead_last_name';

                $fieldsToSearch = implode(", ", $searchFields);

                $Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$arrKeyword."%'";

				/*$Parameters	.=	" AND (lead_first_name LIKE '%". $this->filter['lead_name']."%'"
							.	" OR lead_last_name LIKE '%". $this->filter['lead_name']."%' )";*/
			}

			# Lead Type
			# --------------------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['lead_type']) && $this->filter['lead_type'] !='')
				$Parameters	 .=	" AND lead_type = '". $this->filter['lead_type']."'";


			# User Name
			# -----------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['user_name']) && $this->filter['user_name'] != '')
			{
				$Parameters	 .=	" AND ((user_first_name LIKE '". $this->filter['user_name']."%' OR user_last_name LIKE '". $this->filter['user_name']."%')
								   OR (lead_first_name LIKE '". $this->filter['user_name']."%' OR lead_last_name LIKE '". $this->filter['user_name']."%'))";

			}
			# User Email
			# -----------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['user_email']) && $this->filter['user_email'] != '')
			{
				$Parameters	 .=	" AND (user_email LIKE '%". $this->filter['user_email']."%' OR lead_email LIKE '%". $this->filter['user_email']."%')";
			}

			# Lead Listing Type
			#------------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['lead_listing_type']) && $this->filter['lead_listing_type'] != '')
				$Parameters	 .=	" AND lead_listing_type = '". $this->filter['lead_listing_type']."'";

			# User Type
			#------------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['user_type']) && $this->filter['user_type'] != 'All' && $this->filter['user_type'] != '')
				$Parameters	 .=	" AND user_type = '".$this->filter['user_type']."'";


			# Agent ID
			# -----------------------------------------------------------------------------------------------------------------
			if(isset($this->filter['agent_id']) && $this->filter['agent_id'] != '')
				$Parameters	 .=	" AND lead_agent_id IN('". $this->filter['agent_id']."')";

			/*# Market
			#------------------------------------------------------------------------------------------------------------------
			if($this->filter['market_type'])
			{
				//$Parameters	 .=	" AND lead_mlsp_id = '". $this->filter['market_type']."'";
				$this->filter['market_type'] = str_replace(",", "','", $this->filter['market_type']);
				$Parameters	 .=	" AND user_mls_id IN('". $this->filter['market_type']."')"; //  Added on 13 May 2010
			}
			*/
			# ======================================================================================================
			#
			# ------------------------------------------------------------------------------------------------------
			# Date period
            if(isset($this->filter['lead_date_period']))
            {
    			switch($this->filter['lead_date_period'])
    			{
    				# --------------------------------------------------------------------------------------------------
    				# Get for this month
    				# --------------------------------------------------------------------------------------------------
    				case 'Month';
    					$Parameters	 .=	" AND (MONTH(lead_created_date) = ".date("m"). ") ";
    					break;
    				# --------------------------------------------------------------------------------------------------
    				# Get for this week
    				# --------------------------------------------------------------------------------------------------
    				case 'Week';
    					$Parameters	 .=	" AND (WEEK(lead_created_date) = WEEK('". date('Y-m-d')."'))";
    					break;
    				# --------------------------------------------------------------------------------------------------
    				# Get for this today
    				# --------------------------------------------------------------------------------------------------
    				case 'Today';
    					$Parameters	 .=	" AND (DATE(lead_created_date) = '". date("Y-m-d")."') ";
    					break;
    				# --------------------------------------------------------------------------------------------------
    				# Get for given dates
    				# --------------------------------------------------------------------------------------------------
    				case 'Period';
    					//$FromDate = $this->filter['user_from_date_year']."-".$this->filter['user_from_date_month']."-".$this->filter['user_from_date_day'];
    					//$ToDate = $this->filter['user_to_date_year']."-".$this->filter['user_to_date_month']."-".$this->filter['user_to_date_day'];
                        if(isset($this->filter['lead_from_date']) && $this->filter['lead_from_date'] !="" && isset($this->filter['lead_to_date']) && $this->filter['lead_to_date'] !="")
                        {
        					$FromDate 	= date('Y-m-d', strtotime(str_replace(",", "",  $this->filter['lead_from_date'])));
        					$ToDate 	= date('Y-m-d', strtotime(str_replace(",", "",  $this->filter['lead_to_date'])));

        					$Parameters	 .=	" AND DATE(lead_created_date) BETWEEN '".$FromDate."' AND '".$ToDate."'";
                        }
    					break;
    			}
			}
			# Show debug info
			if(DEBUG)
				$this->__debugMessage($Parameters);

		}
		else
		{
			### Show by default and user with hwc positive
			//$Parameters .= " AND user_type = 'Registered'";

		}

        //$addParams = "(user_added_by_id = '".AuthUser::obj()->UserID."' AND user_added_by_type = '".AuthUser::obj()->User_Perm."')";

        /*if(AuthUser::obj()->User_Perm == AGENT)
            $Parameters .= " AND (user_agent_id = '".AuthUser::obj()->UserID."' OR $addParams)";*/

		return $Parameters;
	}
	#====================================================================================================
	#	Function Name	:   getQueryParameters
	#	Purpose			:	Get Parameters
	#	Return			:	return default order status with status id
	#----------------------------------------------------------------------------------------------------
    public function __getQueryParameters()
	{
		global $usrInfo;
		$Parameters	 =	'';

		if($this->filter)
		{
			# User ID
			# -----------------------------------------------------------------------------------------------------------------
			if($this->filter['user_id'] != '')
				$Parameters	 .=	" AND lead_user_id IN('". $this->filter['user_id']."')";

			# Laed Name
			# --------------------------------------------------------------------------------------------------------------------------
			if($this->filter['lead_name'])
			{
				$Parameters	.=	" AND (lead_first_name LIKE '%". $this->filter['lead_name']."%'"
							.	" OR lead_last_name LIKE '%". $this->filter['lead_name']."%' )";
			}

			# Lead Type
			# --------------------------------------------------------------------------------------------------------------------------
			if($this->filter['lead_type'])
				$Parameters	 .=	" AND lead_type = '". $this->filter['lead_type']."'";


			# User Name
			# -----------------------------------------------------------------------------------------------------------------
			if($this->filter['user_name'])
			{
				$Parameters	 .=	" AND ((user_first_name LIKE '". $this->filter['user_name']."%' OR user_last_name LIKE '". $this->filter['user_name']."%')
								   OR (lead_first_name LIKE '". $this->filter['user_name']."%' OR lead_last_name LIKE '". $this->filter['user_name']."%'))";

			}
			# User Email
			# -----------------------------------------------------------------------------------------------------------------
			if($this->filter['user_email'])
			{
				$Parameters	 .=	" AND (user_email LIKE '%". $this->filter['user_email']."%' OR lead_email LIKE '%". $this->filter['user_email']."%'";
			}

			# Lead Listing Type
			#------------------------------------------------------------------------------------------------------------------
			if($this->filter['lead_listing_type'])
				$Parameters	 .=	" AND lead_listing_type = '". $this->filter['lead_listing_type']."'";

			# User Type
			#------------------------------------------------------------------------------------------------------------------
			if($this->filter['user_type'])
			{
				if($this->filter['user_type'] == 'Registered')
					$Parameters	 .=	" AND (lead_user_id != '' AND lead_user_id != '0')";
				elseif($this->filter['user_type'] == 'Non-Registered')
					$Parameters	 .=	" AND (lead_user_id = '' AND lead_user_id = '0')";
			}

			# Market
			#------------------------------------------------------------------------------------------------------------------
			if($this->filter['market_type'])
			{
				$Parameters	 .=	" AND lead_mlsp_id = '". $this->filter['market_type']."'";
			}
			# ======================================================================================================
			#
			# ------------------------------------------------------------------------------------------------------
			# Date period
			switch($this->filter['lead_date_period'])
			{
				# --------------------------------------------------------------------------------------------------
				# Get for this month
				# --------------------------------------------------------------------------------------------------
				case 'Month';
					$Parameters	 .=	" AND (MONTH(lead_created_date) = ".date("m"). ") ";
					break;
				# --------------------------------------------------------------------------------------------------
				# Get for this week
				# --------------------------------------------------------------------------------------------------
				case 'Week';
					$Parameters	 .=	" AND (WEEK(lead_created_date) = ". date('W').") ";
					break;
				# --------------------------------------------------------------------------------------------------
				# Get for this today
				# --------------------------------------------------------------------------------------------------
				case 'Today';
					$Parameters	 .=	" AND (DATE(lead_created_date) = '". date("Y-m-d")."') ";
					break;
				# --------------------------------------------------------------------------------------------------
				# Get for given dates
				# --------------------------------------------------------------------------------------------------
				case 'Period';
					//$FromDate = $this->filter['user_from_date_year']."-".$this->filter['user_from_date_month']."-".$this->filter['user_from_date_day'];
					//$ToDate = $this->filter['user_to_date_year']."-".$this->filter['user_to_date_month']."-".$this->filter['user_to_date_day'];

					$FromDate 	= date('Y-m-d', strtotime(str_replace(",", "",  $this->filter['lead_from_date'])));
					$ToDate 	= date('Y-m-d', strtotime(str_replace(",", "",  $this->filter['lead_to_date'])));

					$Parameters	 .=	" AND DATE(lead_created_date) BETWEEN '".$FromDate."' AND '".$ToDate."'";

					break;
			}

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($Parameters);

		}
		else
		{

		}

		return $Parameters;
	}

	// MS [Saturday, August 31, 2013]
//	#=========================================================================================================================
//	#	Function Name	:   getInfoByAuthId
//	#	Purpose			:	Get the information
//	#	Return			:	Return recordset with info
//	#-------------------------------------------------------------------------------------------------------------------------
//    function getInfoByAuthId($AuthId='')
//    {
//		if (trim($AuthId)!='')
//			return parent::getInfoByParam("lead_auth_id = '". $AuthId. "'");
//		else
//			return parent::getInfoByParam("lead_auth_id = '". $this->AuthId. "'");
//	}

	#=========================================================================================================================
	#	Function Name	:   getInfoByAuthId
	#	Purpose			:	Get the information
	#	Return			:	Return recordset with info
	#-------------------------------------------------------------------------------------------------------------------------
    public function getInfoByUserId($user_Id='')
    {
		global $db;

		$addParameters = ' AND U.user_id='.$user_Id;

		// TODO : 2014-01-09 : If agenet logged in then display lead received to him only
		if(defined('IN_ADMIN') && AuthUser::obj()->User_Perm != ADMIN)
		{
			$addParameters .= " AND lead_agent_id = '".AuthUser::obj()->UserID."'";
		}

		$sql	=	"SELECT LM.*, U.user_id, CONCAT(AG.agent_first_name,' ', AG.agent_last_name) as agent_name"
				.	" FROM ". $this->Data['TableName']. " AS LM"
				.	" 	LEFT JOIN ". $this->Data['UserTable']." AS U ON U.user_id = LM.lead_user_id"
				.	" 	LEFT JOIN ". $this->Data['AgentTable']." AS AG ON AG.agent_id = LM.lead_agent_id"
				.   " WHERE 1".$addParameters;

		$sql	.= " ORDER BY ".(isset($sort) ? $sort : 'lead_created_date')." ".(isset($dir) ? $dir : 'DESC')
				.	" LIMIT ". $_SESSION[S_RECORD]. ", ". $_SESSION[P_SIZE];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs;

	}
	#====================================================================================================
	#	Function Name	:   ViewAll
	#	Purpose			:	Get All records
	#	Return			:	return default order status with status id
	#----------------------------------------------------------------------------------------------------
    public function ViewAll($Listing_MLS_ID = '', $allRecord=false)
	{
		global $db,$usrInfo;

		parent::setSortingOptions();

        $addParameters = '';
		$addParameters	 .=	$this->getQueryParameters();

        if(defined('IN_ADMIN') && AuthUser::obj()->User_Perm != ADMIN)
        {
            $addParameters .= " AND lead_agent_id = '".AuthUser::obj()->UserID."'";
        }

		if ($Listing_MLS_ID!='')
			$addParameters	 .=	" AND (lead_ListingID_MLS_ID IN ('".$Listing_MLS_ID."')";

		$sql	=	"SELECT count(*) as cnt "
				.	" FROM ". $this->Data['TableName']. " AS LM"
				.	" 	LEFT JOIN ". $this->Data['UserTable']
				.	" 		AS U ON U.user_id = LM.lead_user_id"
				.   " WHERE 1".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs->next_record();

		$this->total_record = $rs->f("cnt");
		$rs->free();

		# Reset the start record if required
		if($_SESSION[S_RECORD] >= $this->total_record || $_SESSION[P_SIZE] >= $this->total_record )
			$_SESSION[S_RECORD] = 0;

		# Get all caller
		$sql	=	"SELECT LM.*, U.*, CONCAT_WS(' ', LM.lead_first_name, LM.lead_last_name) as lead_fullname, CONCAT_WS(' ', A.agent_first_name, A.agent_last_name) as agent_name, CONCAT(lead_listing_Id,'-',lead_mlsp_id) AS ListingID_MLS"
				.	" FROM ". $this->Data['TableName']. " AS LM"
				.	" 	LEFT JOIN ". $this->Data['UserTable']
				.	" 		AS U ON U.user_id = LM.lead_user_id"
				.	" 	LEFT JOIN ". $this->Data['AgentTable']
				.	" 		AS A ON A.agent_id = LM.lead_agent_id"
				.   " WHERE 1".$addParameters;
		//echo $addParameters;die;
		# Set Sorting Options
		/*
        $sort 	= $this->arrayKeyExists($this->so, $this->Data['F_HeaderItem']);
		$dir 	= $this->arrayKeyExists($this->sd, array('asc'=>'asc', 'desc'=>'desc'));
        */
		$sort 	= $this->so;
		$dir 	= $this->sd;

        $sort	= empty($sort) ? 'lead_created_date' : $sort;
		$dir	= empty($dir) ? 'desc' : $dir;

		$sql	.= " ORDER BY ".$sort." ".$dir
				.	" LIMIT ". $_SESSION[S_RECORD]. ", ". $_SESSION[P_SIZE];

		//echo $sql;die;
		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs;
	}

	#====================================================================================================
	#	Function Name	:   getLeadDataById
	#	Purpose			:	Get All records
	#	Return			:	return default order status with status id
	#----------------------------------------------------------------------------------------------------
    public function getLeadDataById($user_id = '',$lead_id = '')
	{
		global $db;

		$sql = "SELECT *, CONCAT(lead_listing_Id,'-',lead_mlsp_id) AS ListingID_MLS FROM ".$this->Data['TableName']." AS M"
				." LEFT JOIN ".$this->Data['UserTable']." AS UM ON M.lead_user_id = UM.user_id"
				." WHERE 1";

		if($user_id)
		{
			$sql .= " AND M.lead_user_id =".$user_id;
		}
		elseif($lead_id)
		{
			$sql .= " AND M.lead_id = ".$lead_id;
		}
		else
		{
			return false;
		}

		$rs = $db->query($sql);

		return($rs->fetch_array(MYSQLI_FETCH_SINGLE));
	}


	#====================================================================================================
	#	Function Name	:   getAssociateLeadData
	#	Purpose			:	Get All records
	#	Return			:	return default order status with status id
	#----------------------------------------------------------------------------------------------------
    public function getAssociateLeadData($lead_id,$rs)
	{
		global $db;

		switch ($rs['lead_type'])
		{
			case "1":
				break;

			default :
				$tableName = $this->Data['TableName'];
				$fieldName = 'lead_id';
				break;
		}

		$sql = "SELECT * FROM ".$tableName.""
				." WHERE 1 AND $fieldName = $lead_id";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return($rs->fetch_array(MYSQLI_FETCH_SINGLE));
	}

	#====================================================================================================
	#	Function Name	:   Delete
	#	Purpose			:	Delete the information
	#	Return			:	Return delete status
	#----------------------------------------------------------------------------------------------------
    public function Delete($pkValue, $retField='')
	{
		global $physical_path;

		$retField = parent::Delete($pkValue, $this->Data['F_PrimaryKey']);

		# Delete Lead Followup Information
		LeadFollowup::obj()->DeleteByLeadID($retField);

		return true;
	}
	#====================================================================================================
	#	Function Name	:   VirtualDelete
	#	Purpose			:	Virtual Delete the information
	#	Return			:	Return delete status
	#----------------------------------------------------------------------------------------------------
    public function VirtualDelete($pkValue)
	{
		global $db;

		$POST['lead_is_deleted'] 		= 'Yes';
		$POST['lead_deleted_by_id'] 	= AuthUser::obj()->UserID;
		$POST['lead_deleted_by_type']   = AuthUser::obj()->User_Perm;
		$POST['lead_deleted_datetime']  = date('Y-m-d H:i:s');

		$sql = "UPDATE ".$this->Data['TableName']." SET "
		       . " lead_is_deleted 			='".$POST['lead_is_deleted']."',"
			   . " lead_deleted_by_id 		='".$POST['lead_deleted_by_id']."',"
			   . " lead_deleted_by_type 	='".$POST['lead_deleted_by_type']."',"
			   . " lead_deleted_datetime 	='".$POST['lead_deleted_datetime']."'"
			   . " WHERE lead_id 			='".$pkValue."'" ;

		# Update
		$rs = $db->query($sql);

		return $rs;
	}

	#====================================================================================================
	#	Function Name	:   RestoreDelete
	#	Purpose			:	Restore the virtually deleted information
	#	Return			:	Return delete status
	#----------------------------------------------------------------------------------------------------
    public function RestoreDelete($pkValue)
	{
		global $db;

		$POST['lead_is_deleted'] 		= 'No';
		$POST['lead_deleted_by_id'] 	= AuthUser::obj()->UserID;
		$POST['lead_deleted_by_type']   = AuthUser::obj()->User_Perm;
		$POST['lead_deleted_datetime']  = date('Y-m-d H:i:s');

		$sql = "UPDATE ".$this->Data['TableName']." SET "
		       . " lead_is_deleted 			='".$POST['lead_is_deleted']."',"
			   . " lead_deleted_by_id 		='".$POST['lead_deleted_by_id']."',"
			   . " lead_deleted_by_type 	='".$POST['lead_deleted_by_type']."',"
			   . " lead_deleted_datetime 	='".$POST['lead_deleted_datetime']."'"
			   . " WHERE lead_id 			='".$pkValue."'" ;

		# Update
		$rs = $db->query($sql);

		return $rs;
	}

	#====================================================================================================
	#	Function Name	:   DeleteByUserId
	#	Purpose			:	Delete the information
	#	Return			:	Return delete status
	#----------------------------------------------------------------------------------------------------
    public function DeleteByUserId($userId)
	{
		global $physical_path;

		if(!$userId)
			return false;

		if(is_array($userId))
			$idList = implode("','", $userId);
		else
			$idList	= $userId;

		$addParameters = " AND lead_user_id IN ('". $idList. "') ";

		$retField = parent::DeleteByParam($addParameters, $this->Data['F_PrimaryKey']);

		# Delete Lead Followup Information
		LeadFollowup::obj()->DeleteByLeadID('', $retField);

		return true;
	}

	#====================================================================================================
	#	Function Name	:   VirtualDeleteByUserId
	#	Purpose			:	Virtual Delete the information
	#	Return			:	Return delete status
	#----------------------------------------------------------------------------------------------------
    public function VirtualDeleteByUserId($userId)
	{
		global $db;

		if(!$userId)
			return false;

		if(is_array($userId))
			$idList = implode("','", $userId);
		else
			$idList	= $userId;


		$POST['lead_is_deleted'] 		= 'Yes';
		$POST['lead_deleted_by_id'] 	= AuthUser::obj()->UserID;
		$POST['lead_deleted_by_type']   = AuthUser::obj()->User_Perm;
		$POST['lead_deleted_datetime']  = date('Y-m-d H:i:s');

		$sql = "UPDATE ".$this->Data['TableName']." SET "
		       . " lead_is_deleted 			='".$POST['lead_is_deleted']."',"
			   . " lead_deleted_by_id 		='".$POST['lead_deleted_by_id']."',"
			   . " lead_deleted_by_type 	='".$POST['lead_deleted_by_type']."',"
			   . " lead_deleted_datetime 	='".$POST['lead_deleted_datetime']."'"
			   . " WHERE lead_user_id 		='".$idList."'" ;

		# Update
		$rs = $db->query($sql);

		return $rs;
	}

	#====================================================================================================
	#	Function Name	:   RestoredDeleteByUserId
	#	Purpose			:	Restore the virtually deleted information
	#	Return			:	Return delete status
	#----------------------------------------------------------------------------------------------------
    public function RestoredDeleteByUserId($userId)
	{
		global $db;

		if(!$userId)
			return false;

		if(is_array($userId))
			$idList = implode("','", $userId);
		else
			$idList	= $userId;


		$POST['lead_is_deleted'] 		= 'No';
		$POST['lead_deleted_by_id'] 	= AuthUser::obj()->UserID;
		$POST['lead_deleted_by_type']   = AuthUser::obj()->User_Perm;
		$POST['lead_deleted_datetime']  = date('Y-m-d H:i:s');

		$sql = "UPDATE ".$this->Data['TableName']." SET "
		       . " lead_is_deleted 			='".$POST['lead_is_deleted']."',"
			   . " lead_deleted_by_id 		='".$POST['lead_deleted_by_id']."',"
			   . " lead_deleted_by_type 	='".$POST['lead_deleted_by_type']."',"
			   . " lead_deleted_datetime 	='".$POST['lead_deleted_datetime']."'"
			   . " WHERE lead_user_id 		='".$idList."'" ;

		# Update
		$rs = $db->query($sql);

		return $rs;
	}

	#=========================================================================================================================
	#	Function Name	:   InsertContactUs
	#	Purpose			:	Insert new information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertContactUs($POST)
	{
		global $usrInfo,$physical_path;

		if(AuthUser::obj()->User_Logged && AuthUser::obj()->User_Perm == USER)
		{
			$POST['lead_user_id'] = $usrInfo->Profile['user_id'];
		}
		else
		{
			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);
			if($user_id)
			{
				$POST['lead_user_id'] = $user_id;
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= $POST['lead_last_name'];
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				$UnregUserPost['user_preferred_contact_method'] = isset($POST['lead_preferred_contact_method'])?$POST['lead_preferred_contact_method']:' ';

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::obj()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;
			}
		}
		if (!isset($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_type'] = "ContactUs";
		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		// To identify lead comes from which site
		$lead_from_site = 1;
		if(defined('IN_AGENT'))
			$lead_from_site = 2;
		elseif(defined('IN_MOBILE'))
			$lead_from_site = 3;

		$POST['lead_from_site']    = $lead_from_site;

		# Make parent call for data insert
		return parent::Insert($POST);
	}
	#=========================================================================================================================
	#	Function Name	:   InsertPropertyInquiry
	#	Purpose			:	Insert new information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertPropertyInquiry($POST, $Record)
	{
		global $db,$usrInfo, $physical_path;
		$arruser = IDXUser::getInstance()->getInfoByEmail($POST['lead_email']);

		if(!isset($POST['lead_user_id']) || isset($POST['lead_user_id']) && $POST['lead_user_id'] == '')
		{
			if(is_array($arruser) && !empty($arruser))
			{
//				$POST['lead_user_id'] = $user_id;
				$POST['lead_user_id'] = $arruser['user_id'];

                $POST['user_type'] = $arruser['user_type'];

			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= isset($POST['lead_last_name']) ? $POST['lead_last_name'] : ' ';
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				$UnregUserPost['user_preferred_contact_method'] = isset($POST['lead_preferred_contact_method']) ? $POST['lead_preferred_contact_method'] : ' ';

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::getInstance()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;
                $POST['user_type'] = $UnregUserPost['user_type'];
                $POST['visitors_user'] = "yes";

			}
		}
		else{
			$POST['lead_user_id'] = $arruser['user_id'];
		}

		$POST['inquiry_type'] = 'Property Inquiry';
		$POST['tags'] = '["askhomeform"]';

		if (!isset($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_ListingID_MLS_ID'] = $POST['ListingID_MLS'];
        $POST['lead_type'] = 'PropertyInquiry';
        $POST['lead_created_date'] = date('Y-m-d H:i:s');

		// Save agent_id, in user master as a last agent, if any
		if(isset($POST['lead_agent_id']) && $POST['lead_agent_id'] > 0)
		{
			$set 	= "user_agent_id = '".$POST['lead_agent_id']."'";
			$where 	= "user_id = '".$POST['lead_user_id']."'";

			IDXUser::getInstance()->UpdateFieldByParam($set, $where);
		}


		// To identify lead comes from which site
		$lead_from_site = 1;

		$POST['lead_from_site']    = $lead_from_site;

		$res = parent::Insert($POST);
		# Make parent call for data insert
		return $res;
	}

	#=========================================================================================================================
	#	Function Name	:   InsertScheduleShowing
	#	Purpose			:	Insert new information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertScheduleShowing($POST, $Record)
	{
		global $db,$usrInfo, $physical_path;

		$arruser = IDXUser::getInstance()->getInfoByEmail($POST['lead_email']);
		if(!isset($POST['lead_user_id']) || isset($POST['lead_user_id']) && $POST['lead_user_id'] == '')
		{


//			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);

//			if($user_id)

            if(is_array($arruser) && !empty($arruser))
            {
//				$POST['lead_user_id'] = $user_id;
                $POST['lead_user_id'] = $arruser['ID'];
                //$POST['lead_user_id'] = $arruser['user_id'];

                //$POST['user_type'] = $arruser['user_type'];
                $POST['user_type'] = 'registered';
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= isset($POST['lead_last_name'])?$POST['lead_last_name'] :' ';
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				$UnregUserPost['user_preferred_contact_method'] = isset($POST['lead_preferred_contact_method'])? $POST['lead_preferred_contact_method'] :' ';

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				//$unreguser_id = IDXUser::getInstance()->InsertUnregisterUser($UnregUserPost);

				//$POST['lead_user_id'] = $unreguser_id;
                $POST['user_type'] = $UnregUserPost['user_type'];

			}
		}
		else{
			$POST['lead_user_id'] = $arruser['ID'];
		}

        $POST['inquiry_type'] = 'Showing Inquiry';
        $POST['tags'] = '["scheduleform"]';


		if (!isset($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_type'] = 'ScheduleShowing';
		$POST['lead_created_date'] = date('Y-m-d H:i:s');


		$POST['lead_ListingID_MLS_ID'] 	= $POST['ListingID_MLS'];

		// Save agent_id, in user master as a last agent, if any
		if(isset($POST['lead_agent_id']) && $POST['lead_agent_id'] > 0)
		{
			$set 	= "user_agent_id = '".$POST['lead_agent_id']."'";
			$where 	= "user_id = '".$POST['lead_user_id']."'";

			IDXUser::getInstance()->UpdateFieldByParam($set, $where);
		}

		// To identify lead comes from which site
		$lead_from_site = 1;

		$POST['lead_from_site']    = $lead_from_site;

		$res = parent::Insert($POST);

		# Make parent call for data insert
		return $res;
	}


	#=========================================================================================================================
	#	Function Name	:   InsertSellerRequest
	#	Purpose			:	Insert new information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertSellerRequest($POST)
	{
		global $usrInfo,$physical_path;

		if(AuthUser::obj()->User_Logged && AuthUser::obj()->User_Perm == USER)
		{
			$POST['lead_user_id'] = $usrInfo->Profile['user_id'];
		}
		else
		{
			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);
			if($user_id)
			{
				$POST['lead_user_id'] = $user_id;
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= $POST['lead_last_name'];
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				$UnregUserPost['user_preferred_contact_method'] = $POST['lead_preferred_contact_method'];

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::obj()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;
			}
		}
		if (!($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_type'] = SELLERREQUEST;
		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		// To identify lead comes from which site
		$lead_from_site = 1;
		if(defined('IN_AGENT'))
			$lead_from_site = 2;
		elseif(defined('IN_MOBILE'))
			$lead_from_site = 3;

		$POST['lead_from_site']    = $lead_from_site;

		# Make parent call for data insert
		return parent::Insert($POST);
	}
    public function InsertHomeValueRequest($POST)
	{
		global $usrInfo,$physical_path;

		if(AuthUser::obj()->User_Logged && AuthUser::obj()->User_Perm == USER)
		{
			$POST['lead_user_id'] = $usrInfo->Profile['user_id'];
		}
		else
		{
			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);
			if($user_id)
			{
				$POST['lead_user_id'] = $user_id;
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= $POST['lead_last_name'];
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				$UnregUserPost['user_preferred_contact_method'] = $POST['lead_preferred_contact_method'];

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::obj()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;
			}
		}
		if (!($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_type'] = HOMEVALUEREQUEST;
		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		// To identify lead comes from which site
		$lead_from_site = 1;
		if(defined('IN_AGENT'))
			$lead_from_site = 2;
		elseif(defined('IN_MOBILE'))
			$lead_from_site = 3;

		$POST['lead_from_site']    = $lead_from_site;

		# Make parent call for data insert
		return parent::Insert($POST);
	}
	#=========================================================================================================================
	#	Function Name	:   UpdateScheduleShowing
	#	Purpose			:	Update Schedule Showing information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateScheduleShowing($lead_Id,$POST)
	{
		global $db,$usrInfo;

		# Set Time
		if(isset($POST['lead_preferred_meridian']) && $POST['lead_preferred_meridian'] == 'pm')
			$hour = $POST['lead_preferred_hour'] + 12;
		else
			$hour = $POST['lead_preferred_hour'];

		$POST['lead_preferred_time'] 	= $hour.":".$POST['lead_preferred_minute'].":00";
		$POST['lead_preferred_date'] 	= date('Y-m-d', strtotime(str_replace(",", "", $POST['lead_preferred_date'])));

		# Make parent call for data insert
		return parent::Update($lead_Id,$POST);
	}
	#=========================================================================================================================
	#	Function Name	:   InsertRegistration
	#	Purpose			:	Insert new information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertRegistration($POST)
	{
		global $db,$usrInfo;





		$POST['lead_type'] = 'Registration';

		if (!isset($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		$POST['lead_home_phone']  = isset($POST['user_phone']) ? $POST['user_phone']:'';
		$POST['lead_work_phone']  = isset($POST['user_work_phone']) ? $POST['user_work_phone']:'';
		$POST['lead_mobile']	  = isset($POST['user_mobile']) ? $POST['user_mobile'] : '';
		$POST['lead_first_name']  = $POST['user_first_name'];
		$POST['lead_last_name']   = $POST['user_last_name'];
		$POST['lead_address']     = $POST['user_address'];
		$POST['lead_zipcode']     = isset($POST['user_zip']) ? $POST['user_zip'] : '';
		$POST['lead_email']       = $POST['user_email'];
		$POST['lead_agent_id']    = isset($POST['user_agent_id']) ? $POST['user_agent_id'] : 0;

		$POST['lead_preferred_contact_method']	  = $POST['user_preferred_contact_method'];

		// To identify lead comes from which site
		$lead_from_site = 1;
		if(defined('IN_AGENT'))
			$lead_from_site = 2;
		elseif(defined('IN_MOBILE'))
			$lead_from_site = 3;

		$POST['lead_from_site']    = $lead_from_site;

		# Make parent call for data insert
		return parent::Insert($POST);
	}
	#=========================================================================================================================
	#	Function Name	:   InsertInquiry
	#	Purpose			:	Insert new inquiry details
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertInquiry($POST)
	{
		global $db,$usrInfo, $physical_path;

		if(AuthUser::obj()->User_Logged && AuthUser::obj()->User_Perm == USER)
		{
			$POST['lead_user_id'] = $usrInfo->Profile['user_id'];
		}
		else
		{
			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);
			if($user_id)
			{
				$POST['lead_user_id'] = $user_id;
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= $POST['lead_last_name'];
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				//$UnregUserPost['user_preferred_contact_method'] = $POST['lead_preferred_contact_method'];

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::obj()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;
			}
		}
		if (!($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_type'] = 'Inquiry';
		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		# Make parent call for data insert
		return parent::Insert($POST);
	}
	#=========================================================================================================================
	#	Function Name	:   InsertPropertyValuationRequest
	#	Purpose			:	Insert new inquiry details
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertPropertyValuationRequest($POST)
	{
		global $db,$usrInfo, $physical_path;

		if(AuthUser::obj()->User_Logged && AuthUser::obj()->User_Perm == USER)
		{
			$POST['lead_user_id'] = $usrInfo->Profile['user_id'];
		}
		else
		{
			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);
			if($user_id)
			{
				$POST['lead_user_id'] = $user_id;
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= $POST['lead_last_name'];
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				$UnregUserPost['user_preferred_contact_method'] = $POST['lead_preferred_contact_method'];

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::obj()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;
			}
		}
		if (!($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_type'] = 'PropertyValuation';
		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		# Make parent call for data insert
		return parent::Insert($POST);
	}
	#=========================================================================================================================
	#	Function Name	:   InsertFreeReportRequest
	#	Purpose			:	Insert Free Report request
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertFreeReportRequest($POST)
	{
		global $db,$usrInfo, $physical_path;

		if(AuthUser::obj()->User_Logged && AuthUser::obj()->User_Perm == USER)
		{
			$POST['lead_user_id'] = $usrInfo->Profile['user_id'];
		}
		else
		{
			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);
			if($user_id)
			{
				$POST['lead_user_id'] = $user_id;
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= $POST['lead_last_name'];
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = $POST['lead_home_phone'];
				$UnregUserPost['user_preferred_contact_method'] = $POST['lead_preferred_contact_method'];

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::obj()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;
			}
		}
		if (!($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		if(is_array($POST['lead_report_type']))
			$POST['lead_free_report_type'] = implode(',', $POST['lead_report_type']);
		else
			$POST['lead_free_report_type'] = $POST['lead_report_type'];

		$POST['lead_type'] = 'FreeReportRequest';
		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		# Make parent call for data insert
		return parent::Insert($POST);
	}
	#=========================================================================================================================
	#	Function Name	:   UpdateNote
	#	Purpose			:	Update the information
	#	Return			:	Return update status
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateNote($pkValue, $POST)
	{
		global $db;

		# Define query
		 $sql = " UPDATE " . $this->Data['TableName'] .
		 		" SET lead_note_desc = IF(lead_note_desc IS NULL,'".date('M d, Y H:i')."\n".$POST['lead_note']."\n',CONCAT(lead_note_desc, '".date('M d, Y H:i')."\n".$POST['lead_note']."\n')) " .
			    " WHERE ". $this->Data['F_PrimaryKey']." = '".$pkValue."' ";

		if(DEBUG)
		$this->__debugMessage($sql);

		# Execute query
		$db->query($sql);

		return $db->affected_rows();
	}

	#=========================================================================================================================
	#	Function Name	:   getLeadCount
	#	Purpose			:	Get Count
	#	Return			:	Return Count
	#-------------------------------------------------------------------------------------------------------------------------
	public function getLeadCount($Type='', $ListingID_RETS='')
	{
		global $db;

		$sql = "SELECT lead_type, count(*) as 'lead_count' FROM ". $this->Data['TableName'];

		$sql .= " WHERE 1 ";

		if($Type == 'Monthly')
			$sql .= "AND MONTH(lead_created_date) = MONTH(CURDATE()) ";

		if($Type == 'Daily')
			$sql .= "AND lead_created_date = CURDATE() ";

		if($Type == 'Yearly')
			$sql .= "AND YEAR(lead_created_date) = YEAR(CURDATE()) ";

		if($Type == 'LastYear')
			$sql .= "AND YEAR(lead_created_date) = (YEAR(CURDATE()) - 1) ";

		if($ListingID_RETS != '')
			$sql .= "AND lead_ListingID_MLS_ID IN ('".$ListingID_RETS."') ";

		$sql .= " group by lead_type";

		if(DEBUG)
			$this->__debugMessage($sql);

		$db->query($sql);

		$rs = $db->fetch_array();

		$retArr = array();
		foreach($rs as $key=>$valArr)
			$retArr[$valArr['lead_type']] = $valArr['lead_count'];

		return ($retArr);
	}
	##### PROPERTY REPORT FUNCTION ##########
	#=========================================================================================================================
	#	Function Name	:   getPropertyReportHeader
	#	Purpose			:	Return the property report header
	#	Return			:	Return report header
	#-------------------------------------------------------------------------------------------------------------------------
	public function getPropertyReportHeader()
	{
		global $asset, $config;

		# Field information, keys are NOT database field
			$arrHeader	=
			array(

					'first_name'				=>	array(	TITLE			=>	'Name',
															WIDTH			=>	'10%',
														),
					'agent_name'				=>	array(	TITLE			=>	'Agent',
															WIDTH			=>	'10%',
														),
					/*'city_state'				=>	array(	TITLE			=>	'City, State',
															WIDTH			=>	'10%',
														),	*/
					'phone'						=>	array(	TITLE			=>	'Phone',
															WIDTH			=>	'8%',
														),
					'email'						=>	array(	TITLE			=>	'Email',
															WIDTH			=>	'15%',
														),
					'listing_info'					=>	array(
														  	TITLE			=>	'Listing Info',
															WIDTH			=>	'15%',
															IS_INFO			=>	true,
															'Tmpl'			=>	'listing_info'.$config[TPL_EX] ,
														),
					'lead_comment'				=>	array(
														  	TITLE			=>	'Comment',
															WIDTH			=>	'15%',
														),
					'recieve_date'				=>	array(
															TITLE			=>	'Received Date',
															WIDTH			=>	'14%',
															IS_DATE			=>	true,
															'Tmpl'			=>	'lead_source_info'.$config[TPL_EX] ,
														),
				);


			return $arrHeader;
	}

	#====================================================================================================
	#	Function Name	:   ViewPropertyInquiryReport
	#	Purpose			:	To Get All Property Report
	#	Return			:	return recordset
	#----------------------------------------------------------------------------------------------------
    public function ViewPropertyInquiryReport($POST='', $addParameters='')
    {
		global $db,$usrInfo;

		# Set Cookies/Values Used For Sorting
		parent::setSortingOptions();

		$addParameters	 .=	$this->getQueryParameters();

		$addParameters   .= " AND lead_type = 'PropertyInquiry'";

		$sql = "SELECT count(*) as cnt FROM " . $this->Data['TableName']." AS M"
			 . " LEFT JOIN ".$this->Data['UserTable']." AS UM ON UM.user_id = M.lead_user_id"
			 . " WHERE 1".$addParameters;
//Utility::pre($Debug);
		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs->next_record();

		$this->total_record = $rs->f("cnt");
		$rs->free();

		# Reset the start record if required
		if($_SESSION[S_RECORD] >= $this->total_record || $_SESSION[P_SIZE] >= $this->total_record )
			$_SESSION[S_RECORD] = 0;


		# Get all caller
		$sql	= "SELECT M.*,UM.*, "
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_first_name, UM.user_first_name ) AS first_name,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_last_name, UM.user_last_name )   AS last_name,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_city_state, UM.user_city_state ) AS city_state,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_home_phone, UM.user_phone ) AS phone,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_email, UM.user_email ) AS email,"
				. " CONCAT('MLS #', M.lead_listing_Id) AS listing_info,"
				. " M.lead_created_date AS recieve_date, CONCAT_WS(' ', A.agent_first_name, A.agent_last_name) as agent_name, CONCAT(lead_listing_Id,'-',lead_mlsp_id) AS ListingID_MLS"
				. " FROM ". $this->Data['TableName']. " AS M"
				.	" 	LEFT JOIN ". $this->Data['AgentTable']
				.	" 		AS A ON A.agent_id = M.lead_agent_id"
				. " LEFT JOIN ".$this->Data['UserTable']." AS UM ON UM.user_id = M.lead_user_id";

		$sql	.= " WHERE 1".$addParameters;

		# Set Sorting Options
		/*
        $sort 	= $this->arrayKeyExists($this->so, $this->getPropertyReportHeader());
		$dir 	= $this->arrayKeyExists($this->sd, array('asc'=>'asc', 'desc'=>'desc'));
		*/
		$sort 	= $this->so;
		$dir 	= $this->sd;

        $sort	= empty($sort) ? 'recieve_date' : $sort;
		$dir	= empty($dir) ? 'desc' : $dir;

		$sql	.= " ORDER BY ".$sort." ".$dir
				.	" LIMIT ". $_SESSION[S_RECORD]. ", ". $_SESSION[P_SIZE];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs;
	}

	##### SCHEDULE SHOWING REPORT FUNCTION ##########

	#=========================================================================================================================
	#	Function Name	:   getScheduleShowingReportHeader
	#	Purpose			:	Return the Schedule Showing header
	#	Return			:	Return report header
	#-------------------------------------------------------------------------------------------------------------------------
	public function getScheduleShowingReportHeader()
	{
		global $config;

		# Field information, keys are NOT database field
			$arrHeader	=
			array(

					'first_name'				=>	array(	TITLE			=>	'Name',
															WIDTH			=>	'10%',
														),
					'agent_name'				=>	array(	TITLE			=>	'Agent',
															WIDTH			=>	'10%',
														),
					/*'city_state'				=>	array(	TITLE			=>	'City, State',
															WIDTH			=>	'10%',
														),	*/
					'phone'						=>	array(	TITLE			=>	'Phone',
															WIDTH			=>	'8%',
														),
					'email'						=>	array(	TITLE			=>	'Email',
															WIDTH			=>	'15%',
														),
					'listing_info'					=>	array(
														  	TITLE			=>	'Listing Info',
															WIDTH			=>	'15%',
															IS_INFO			=>	true,
															'Tmpl'			=>	'listing_info'.$config[TPL_EX] ,
														),
					'lead_comment'				=>	array(
														  	TITLE			=>	'Comment',
															WIDTH			=>	'15%',
														),
					'recieve_date'				=>	array(
															TITLE			=>	'Received Date',
															WIDTH			=>	'14%',
															IS_DATE			=>	true,
															'Tmpl'			=>	'lead_source_info'.$config[TPL_EX] ,
														),
				);


			return $arrHeader;
	}

	#====================================================================================================
	#	Function Name	:   ViewScheduleShowingReport
	#	Purpose			:	To Get All Property Report
	#	Return			:	return recordset
	#----------------------------------------------------------------------------------------------------
    public function ViewScheduleShowingReport($POST='')
    {
		global $db, $usrInfo;

		# Set Cookies/Values Used For Sorting
		parent::setSortingOptions();
		$addParameters = '';
		$addParameters	 .=	$this->getQueryParameters();
		$addParameters   .= " AND lead_type = 'ScheduleShowing'";

		$sql = "SELECT count(*) as cnt FROM " . $this->Data['TableName']." AS M"
			 . " LEFT JOIN ".$this->Data['UserTable']." AS UM ON UM.user_id = M.lead_user_id"
			 . " WHERE 1".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs->next_record();

		$this->total_record = $rs->f("cnt");
		$rs->free();

		# Reset the start record if required
		if($_SESSION[S_RECORD] >= $this->total_record || $_SESSION[P_SIZE] >= $this->total_record )
			$_SESSION[S_RECORD] = 0;

		//
		# Get all caller
		$sql	= "SELECT M.*,UM.*, "
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_first_name, UM.user_first_name ) AS first_name,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_last_name, UM.user_last_name )   AS last_name,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_city_state, UM.user_city_state ) AS city_state,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_home_phone, UM.user_phone ) AS phone,"
				. " IF(M.lead_user_id = '0' OR M.lead_user_id = '', M.lead_email, UM.user_email ) AS email,"
				. " CONCAT(DATE_FORMAT(M.lead_preferred_date,'%d %b, %Y'),' ',DATE_FORMAT(M.lead_preferred_time,'%h:%i %p')) AS scheduledatetime,"
				. " CONCAT('MLS# ',M.lead_listing_Id) AS listing_info,"
				. " M.lead_created_date AS recieve_date, CONCAT_WS(' ', A.agent_first_name, A.agent_last_name) as agent_name, CONCAT(lead_listing_Id,'-',lead_mlsp_id) AS ListingID_MLS"
				. " FROM ". $this->Data['TableName']. " AS M"
				.	" 	LEFT JOIN ". $this->Data['AgentTable']
				.	" 		AS A ON A.agent_id = M.lead_agent_id"
				. " LEFT JOIN ".$this->Data['UserTable']." AS UM ON UM.user_id = M.lead_user_id";

		$sql	.= " WHERE 1".$addParameters;

		# Set Sorting Options
		/*
        $sort 	= $this->arrayKeyExists($this->so, $this->getScheduleShowingReportHeader());
		$dir 	= $this->arrayKeyExists($this->sd, array('asc'=>'asc', 'desc'=>'desc'));
		*/
		$sort 	= $this->so;
		$dir 	= $this->sd;

        $sort	= empty($sort) ? 'recieve_date' : $sort;
		$dir	= empty($dir) ? 'desc' : $dir;

		$sql	.= " ORDER BY ".$sort." ".$dir
				.	" LIMIT ". $_SESSION[S_RECORD]. ", ". $_SESSION[P_SIZE];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs;
	}
	#=========================================================================================================================
	#	Function Name	:   UpdateLeadUserId
	#	Purpose			:	Updates the loan officer HWC
	#	Return			:	Return affected_rows status
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateLeadUserId($leadId,$userId)
	{
		global $db;

		$sql	=	"UPDATE " .  $this->Data['TableName']
				.	" SET lead_user_id = '".$userId."'"
				.	" WHERE lead_id = '".$leadId."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute Query
		$db->query($sql);

		return $db->affected_rows();
	}
	#====================================================================================================
	#	Function Name	:   getUnRegisteredUser
	#	Purpose			:	Provide distinct list of UnRegisterd User
	#	Return			:	return recordset
	#----------------------------------------------------------------------------------------------------
    public function getUnRegisteredUser()
    {
		global $db;

		# Query
		$sql	= "SELECT lead_id, lead_first_name, lead_last_name, lead_email FROM ". $this->Data['TableName']
				." WHERE lead_user_id = 0 AND lead_email != ''"
				." GROUP BY lead_email";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs;
	}
	#====================================================================================================
	#	Function Name	:   getAllByParams
	#	Purpose			:	Provide list of Lead information for geiven parameters
	#	Return			:	return recordset
	#----------------------------------------------------------------------------------------------------
	public function getAllByParams($POST='')
	{
		$addParams = '';

		if($POST['lead_id'])
			$params = " AND lead_id IN(".$POST['lead_id'].")";

		$customSelect = 'lead_id, lead_first_name, lead_last_name, lead_email';

		$rs = parent::getAll($params, $customSelect);

		return $rs->fetch_array();

	}
	#====================================================================================================
	#	Function Name		:   getLeadRegisterUser
	#	Purpose			:	Provide list of Lead register user
	#	Return			:	return recordset
	#----------------------------------------------------------------------------------------------------
	public function getLeadRegisterUser()
	{
		global $db;

		$sql = "SELECT distinct(lead_email)  FROM ".$this->Data['TableName']." AS LM "
			. " LEFT JOIN ".$this->Data['UserTable']." AS UM ON UM.user_email = LM.lead_email"
			. " AND LM.lead_user_id = 0";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs;
	}
	#====================================================================================================
	#	Function Name		:   getLeadDistinctUser
	#	Purpose			:	Provide distinct list of Lead user information whose lead_user_id is 0
	#	Return			:	return recordset
	#----------------------------------------------------------------------------------------------------
	public function getLeadDistinctUser()
	{
		global $db;

		$sql = "SELECT distinct(lead_email),lead_first_name,lead_last_name,lead_home_phone,lead_work_phone,lead_mobile,lead_preferred_contact_method,lead_id"
			. " FROM ".$this->Data['TableName']." AS LM "
			. " WHERE LM.lead_user_id = 0";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs;
	}
#====================================================================================================
#	Following functions are used for unreg user set up cron, remove them if not needed after running crom  on server
#----------------------------------------------------------------------------------------------------
	#====================================================================================================
	#	Function Name		:   InsertUnregisterUser
	#	Purpose			:	Insert Lead unregister user into new table
	#	Return			:
	#----------------------------------------------------------------------------------------------------
	public function InsertUnregisterUser($rsDistUser)
	{
		global $db;

		while($rsDistUser->next_record())
		{
			if($rsDistUser->f('lead_email') !='')
			{
				$sql = "SELECT user_email FROM ".$this->Data['UserTable']." WHERE user_email = '".$rsDistUser->f('lead_email')."'";
				$rs = $db->query($sql);
				if($rs->TotalRow < 1)
				{

					$sql = "INSERT INTO ".$this->Data['UserTable']." (user_auth_id,user_mls_id,user_first_name,
																	user_last_name,
																	user_phone,
																	user_work_phone,
																	user_mobile,
																	user_email,
																	user_preferred_contact_method,
																	user_type) VALUES 
																	('','1',
																	'".$rsDistUser->f('lead_first_name')."',
																	'".$rsDistUser->f('lead_last_name')."',
																	'".(strlen($rsDistUser->f('lead_home_phone')) > 12 ? "" : $rsDistUser->f('lead_home_phone'))."',
																	'".(strlen($rsDistUser->f('lead_work_phone')) > 12 ? "" : $rsDistUser->f('lead_work_phone'))."',
																	'".(strlen($rsDistUser->f('lead_mobile')) > 12 ? "" : $rsDistUser->f('lead_mobile'))."',
																	'".$rsDistUser->f('lead_email')."',
																	'".$rsDistUser->f('lead_preferred_contact_method')."',
																	'UnRegistered')";

					# Show debug info
					if(DEBUG)
						$this->__debugMessage($sql);

					$db->query($sql);
					$inserted_id = $db->sql_inserted_id();

					$sql	=	"UPDATE " .  $this->Data['TableName']
						.	" SET lead_user_id = '".$inserted_id."'"
						.	" WHERE lead_email = '".$rsDistUser->f('lead_email')."'";

					# Show debug info
					if(DEBUG)
						$this->__debugMessage($sql);

					# Execute Query
					$db->query($sql);

					//return $db->affected_rows();

				}
			}
		}

	}
	#=========================================================================================================================
	#	Function Name	:   UpdateLeadUserId
	#	Purpose			:	Updates the loan officer HWC
	#	Return			:	Return affected_rows status
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateLeadUserIdByEmail($user_email,$userId)
	{
		global $db;

		$sql	=	"UPDATE " .  $this->Data['TableName']
				.	" SET lead_user_id = '".$userId."'"
				.	" WHERE lead_email = '".$user_email."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute Query
		$db->query($sql);

		return $db->affected_rows();
	}

#====================================================================================================
#	Functions Related To Charts Used On "HOME PAGE"
#====================================================================================================
	#====================================================================================================
	#	Function Name	:   getLogbyType
		// For charts on homepage
	#----------------------------------------------------------------------------------------------------
	public function getLogByType()
	{
		global $db;


			$logForMonth = mktime(0, 0, 0, date('n')-11, 1, date('Y'));
			$monthName   = date('Y-m', $logForMonth);
			$curMonth    = date('Y-m',mktime(0, 0, 0, date('n'), 1, date('Y')));

			$temp="";
			$firstMonth = $monthName;
			while($monthName < $curMonth)
			{
		  		$monthTime = strtotime(date('Y-m', strtotime($monthName)) . '+1 month');
				$monthName = date("Y-m",$monthTime);
			 	$temp = $temp."UNION SELECT '".$monthName."', '".date("M Y",$monthTime)."' ";
			}

			$sql = "SELECT * FROM (SELECT 'ContactUs' AS lead_type "
				  ."UNION SELECT 'PropertyInquiry' "
				  ."UNION SELECT 'ScheduleShowing' ) AS MT "
			 	  ."JOIN (SELECT '".$firstMonth."' AS lead_created_date, '". date("M Y",$logForMonth)."' AS Log_month "
				  .$temp.") AS MT2 LEFT JOIN (SELECT DATE_FORMAT(lead_created_date, '%Y-%m') AS record_date, lead_type as record_action, count(*) AS total_view "
			  	  ."FROM lead_master "
				  ." GROUP BY DATE_FORMAT(lead_created_date, '%Y%m') , lead_type "
				  .") AS ST ON MT.lead_type = ST.record_action "
				  ."AND MT2.lead_created_date = ST.record_date"
				  ." ORDER BY MT2.lead_created_date, MT.lead_type";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$rs = $db->query($sql);

		return $rs;
	}

	#====================================================================================================
	#	Function Name	:   getDailyLead
	#----------------------------------------------------------------------------------------------------
	public function getDailyLead()
	{
		global $db;

			$logForDay = mktime(0, 0, 0, date('n'), date('d')-30, date('Y'));
			$dayName   = date('Y-m-d', $logForDay);
			$curDay    = date('Y-m-d',mktime(0, 0, 0, date('n'), date('d'), date('Y')));

			$temp="";
			$firstDay = $dayName;
			while($dayName < $curDay)
			{
		  		$dayTime = strtotime(date('Y-m-d', strtotime($dayName)) . '+1 day');
				$dayName = date("Y-m-d",$dayTime);
			 	$temp = $temp."UNION SELECT '".$dayName."', '".date("d M",$dayTime)."' ";
			}

			$sql = "SELECT * FROM (SELECT 'ContactUs' AS lead_type "
				  ."UNION SELECT 'PropertyInquiry' "
				  ."UNION SELECT 'ScheduleShowing' ) AS MT "
			 	  ."JOIN (SELECT '".$firstDay."' AS lead_created_date, '". date("d M",$logForDay)."' AS Log_day "
				  .$temp.") AS MT2 LEFT JOIN (SELECT DATE_FORMAT(lead_created_date, '%Y-%m-%d') AS record_date, lead_type as record_action, count(*) AS total_view "
			  	  ."FROM lead_master "
				  ." GROUP BY DATE_FORMAT(lead_created_date, '%Y%m%d') , lead_type "
				  .") AS ST ON MT.lead_type = ST.record_action "
				  ."AND MT2.lead_created_date = ST.record_date"
				  ." ORDER BY MT2.lead_created_date, MT.lead_type";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute query
		$rs = $db->query($sql);
		return $rs;
	}
    #=========================================================================================================================
	#	Function Name	:   InsertGeneralLead
	#	Purpose			:	Insert Lead Information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertGeneralLead($POST, $type="Inquiry")
	{
		global $usrInfo,$physical_path;
		if(AuthUser::obj()->User_Logged && AuthUser::obj()->User_Perm == USER)
		{
			$POST['lead_user_id'] = $usrInfo->Profile['user_id'];

			if($type == 'SellerInquiry'){
            }
			//$POST['lead_mlsp_id'] = $usrInfo->Profile['user_mls_id'];
		}
		else
		{
            IDXUser::obj('',true);

//			$user_id = IDXUser::obj()->geUserIdByEmail($POST['lead_email']);
            $arruser = IDXUser::obj()->getInfoByEmail($POST['lead_email']);
//			if($user_id)
            if(is_array($arruser) && !empty($arruser))
            {
				$POST['lead_user_id'] = $arruser['user_id'];
				if($type == 'SellerInquiry'){


                    $POST['user_type'] = $arruser['user_type'];
                }
			}
			else
			{
				$UnregUserPost['user_first_name']	= $POST['lead_first_name'];
				$UnregUserPost['user_last_name']	= isset($POST['lead_last_name']) ? $POST['lead_last_name'] : '';
				$UnregUserPost['user_email'] = $POST['lead_email'];

				$UnregUserPost['user_phone'] = isset($POST['lead_home_phone']) ? $POST['lead_home_phone'] : '';
				$UnregUserPost['user_preferred_contact_method'] = 'Email';

				$UnregUserPost['user_last_update_date'] = date('Y-m-d');
				$UnregUserPost['user_type'] = 'UnRegistered';
				$UnregUserPost['user_auth_id'] = '';

				$unreguser_id = IDXUser::obj()->InsertUnregisterUser($UnregUserPost);

				$POST['lead_user_id'] = $unreguser_id;

				if($type == 'SellerInquiry'){
                    $POST['user_type'] = $UnregUserPost['user_type'];

                }
			}
		}
        if($type == 'SellerInquiry'){
            /*$extra_tag = '';
            if($POST['user_type'] && $POST['user_type'] == 'UnRegistered')
            {
                $extra_tag = '"'.$POST['lead_preferred_language'].'"';
            }*/

            $POST['inquiry_type'] = 'Seller Inquiry';
            if(isset($POST['visitors_user']) && $POST['visitors_user'] == 'yes')
            {
                $POST['tags'] = '["sellerform", "'.$POST['lead_preferred_language'].'"]';
            }else{
                $POST['tags'] = '["sellerform"]';
            }

        }
        # If don't want to insert lead
        if (isset($POST['lead_insert']) && $POST['lead_insert'] == 'No')
            return;

		if (!isset($POST['lead_created_by']))
			$POST['lead_created_by'] = LDSOURCE_SITE;

		$POST['lead_type'] = $type;
		$POST['lead_created_date'] = date('Y-m-d H:i:s');

		// To identify lead comes from which site
		$lead_from_site = 1;
		if(defined('IN_AGENT'))
			$lead_from_site = 2;
		elseif(defined('IN_MOBILE'))
			$lead_from_site = 3;

		$POST['lead_from_site']    = $lead_from_site;

		$res = parent::Insert($POST);
		if($res)
		{
			$return['user_id'] = $POST['lead_user_id'];
		}
		# Make parent call for data insert
		return $return['user_id'];
	}

	#=========================================================================================================================
	#	Function Name	:   UpdateLeadAgentId
	#	Purpose			:	Updates lead agent
	#	Return			:	Return affected_rows status
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateLeadAgentId($leadId, $agentId)
	{
		global $db;

		$sql	=	"UPDATE " .  $this->Data['TableName']
				.	" SET lead_agent_id = '".$agentId."'"
				.	" WHERE lead_id = '".$leadId."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute Query
		$db->query($sql);

		return $db->affected_rows();
	}
    #====================================================================================================
	#	Function Name	:   getAllScheduleTourByUser
	#	Purpose			:	Provide list of Lead information for given user with some additional details
	#	Return			:	return recordset
	#----------------------------------------------------------------------------------------------------
	public function getAllByUser($POST='')
	{
	   global $db;

		$addParams = '';

		if($POST['lead_user_id'])
			$addParams .= " AND lead_user_id IN('".$POST['lead_user_id']."')";

        if($POST['lead_type'])
			$addParams .= " AND lead_type IN('".$POST['lead_type']."')";

        $addParams .= " AND lead_preferred_date >= CURDATE()";

		$customSelect = 'lead_id, lead_first_name, lead_last_name, lead_email, lead_preferred_date, lead_preferred_time, lead_ListingID_MLS_ID AS mls_num';

		$rs = parent::getAll($addParams, $customSelect);

        $ret = array();
        $ret['rsLead'] = $rs->fetch_array();


        // Grab MLS NUMS
        $sql = "SELECT GROUP_CONCAT(DISTINCT lead_ListingID_MLS_ID) AS mls_num_list FROM ". $this->Data['TableName']
             . " WHERE 1".$addParams." GROUP BY lead_user_id";

        $rs = $db->query($sql);
        $rs->next_record();

        $ret['mls_num_list'] = $rs->f('mls_num_list');

        return $ret;
	}
    public function GetUserUpdatesForDashboard($limit=5)
    {
        global $db;

        $user_param = "";
        $Lead_param = "";

        if(AuthUser::obj()->User_Perm == AGENT)
        {
            $user_param .= " AND (user_agent_id = '".AuthUser::obj()->UserID."')";
            $Lead_param .=  " AND (lead_agent_id = '".AuthUser::obj()->UserID."')";
        }

        $sql = " SELECT lead_type AS user_updates, lead_user_id AS user_id, CONCAT_WS(' ', lead_first_name, lead_last_name) AS user_name, lead_listing_Id AS MLS_NUM, lead_ListingID_MLS_ID AS lead_ListingID, 0 AS log_search_id, '' AS search_url, '' AS search_title,
                lead_created_date AS log_date FROM ".$this->Data['TableName']." WHERE 1 AND lead_type IN ('PropertyInquiry', 'Registration', 'ScheduleShowing') ".$Lead_param."
                UNION 
                (SELECT log_action AS user_updates, log_user_id AS user_id, CONCAT(UM.user_first_name, ' ', UM.user_last_name) AS user_name, log_listing_id AS MLS_NUM, log_listing_id AS lead_ListingID, log_ref_id AS log_search_id, log_additional_info AS search_url, US.search_title AS search_title,
                log_datetime AS log_date FROM ".$this->Data['Log_Table']." UL 
                LEFT JOIN user_saved_searches US ON UL.log_ref_id = US.search_id AND log_action = 'Save Search'
                LEFT JOIN ".$this->Data['UserTable']." UM ON UL.log_user_id = UM.user_id AND UM.user_id NOT IN ('".str_replace(",", "','", str_replace(", ", ",",TEST_USER_ID))."') 
                WHERE log_user_id != 0 AND log_user_id NOT IN ('".str_replace(",", "','", str_replace(", ", ",",TEST_USER_ID))."')
                AND log_action IN ('Add Block Listing', 'Add Favourite', 'Email Friend', 'Save Search') ".$user_param.") ";
        $order_by = " ORDER BY log_date DESC LIMIT 0, ".$limit;

        $sql .= $order_by;

        $rs = $db->query($sql);
        return $rs;
    }
    public function getRegisterAndUnregisterUser($POST)
    {

        if(!isset($POST['page_size'])){
            $POST['page_size'] = 0;
        }
        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

        $param = "GROUP BY lead_email ASC LIMIT ". $startRecord .",".$POST['page_size'];
        $rsUser = parent::getAll($param);

        $result['rsUser'] = $rsUser->fetch_array();
        $totalFetched = parent::ViewAll('', true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }
}
?>