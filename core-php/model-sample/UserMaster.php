<?php
/**
 * @file /db_access/UserMaster.php
 *
 */
class UserMaster extends DB_Custom
{
    public static $Instance;

    public $User_ID;
	public $AuthId;
	public $ID;
	public $UserName;
	public $Email;
	public $Profile;
	public $User_Phone;
	public $AvailableOCoin;
    public $IsVerified;

	public static function obj($isPopulateSchema=false, $user_id=false, $user_auth_id=false)
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self($isPopulateSchema, $user_id, $user_auth_id);

		return self::$Instance;
	}
    public function __construct($isPopulateSchema=false, $user_id=false, $user_auth_id=false)
    {
        global  $config, $physical_path, $virtual_path;

        # Set Database Connection
        $this->DBC   =   &DBc::$obj;

        # Table name
		$this->Data[TABLE_NAME]			=	$config[TABLE_PREFIX]. 'user_master';

        # Field Prefix
        $this->Data[FIELD_PREFIX]       =   'um_';

        # Primary field info
		$this->Data[F_P_KEY]			=	$this->Data[FIELD_PREFIX].'id';
        $this->Data[F_F_KEY]			=	$this->Data[FIELD_PREFIX].AuthUser::obj()->Data[F_P_KEY];
        $this->Data[F_P_FIELD]          =   $this->Data[FIELD_PREFIX].'firstname';
        $this->Data[F_U_FIELD]          =   array($this->Data[F_F_KEY],$this->Data[FIELD_PREFIX].'email',$this->Data[FIELD_PREFIX].'mobile');
        $this->Data[F_ACTIVE]           =   $this->Data[FIELD_PREFIX].'is_active';
        $this->Data[F_VIRTUAL_DELETE]   =   $this->Data[FIELD_PREFIX].'is_deleted';
        $this->Data[F_ADDED_DATETIME]   =   $this->Data[FIELD_PREFIX].'dt_signup';


        $this->Data[P_UP]               =   $physical_path['Upload'].'/user';
        $this->Data[V_UP]               =   $virtual_path['Upload'].'/user';
        $this->Data[F_UP_FOLDER_NAME]   =   $this->Data[F_P_KEY];

	    $this->Data[F_D_FIELD]          =   array(
		                                            array($this->Data[FIELD_PREFIX].'image_file', true),
	                                            );
        $this->Data['ScriptName']       =   'user-master.html';

        $this->Data[IMG_RW_URL]         =   "/album/user";
	    $this->Data['USER_ACCOUNT_RW_URL']     =   "/mya";

	    # Set auth details if user logged-in
	    if($user_auth_id != false && !empty($user_auth_id))
            $this->SetAuthDetail($user_auth_id);
        elseif($user_id != false && is_numeric($user_id))
            $this->SetUserId($user_id);

        # Is need to populate schema data
		if($isPopulateSchema) $this->populateSchema();

        # initialize parent class
		parent::__construct();
    }
    public function populateSchema()
    {
        global $asset, $config;

        #Module Title
        $this->Data[L_MODULE]               =   'User Master';

        #Help Text
        $this->Data[H_MANAGE]               =   'Manage User Information';
        $this->Data[H_ADD_EDIT]             =   'Profile';/*'Update User Information and click <b>Save</b> to save Changes.
                                                            Other Wise click <b>Cancle</b> to Discard';*/

        #Field Information
        $this->Data[F_H_ITEM]               =
            array();

        # Field Information
		$this->Data[F_F_INFO] 				    =
			array();

                #User Password Information
                $this->Data['FFI_1']            =
                    array();
    }
	/**
	 * UserMaster::SetUserId()
	 *
	 * @param int $user_id = numeric ID of user
	 * @return none
	 *
	 * @SetUserId set user id as a public and also set upload path and other required initialization
	 */
	public function SetUserId($user_id)
	{
		if(is_numeric($user_id))
		{
			$this->User_ID = $user_id;

			$info = $this->getInfoById($user_id);
            $this->SetBasicInfo($info);
		}
	}
    public function EncodeDecodeUserId($type, $user_id)
	{
		$prefix =   'TEU';
		$add    =   596;

		if($type == 'E')
			return Ocrypt::encodeNumber($user_id,$prefix,$add);
		elseif($type == 'D')
			return Ocrypt::decodeNumber($user_id,$prefix,$add);
		else
			return false;
	}
	public function SetAuthDetail($user_auth_id)
	{
		if($user_auth_id != false)
		{
			$this->AuthId	=	$user_auth_id;
			$info           =   $this->getInfoByAuthId($this->AuthId);

			$this->SetBasicInfo($info);
		}
	}
    public function SetBasicInfo($user_info)
    {
        if(is_array($user_info))
        {
            $this->ID           =   $user_info[$this->Data[F_P_KEY]];
            $this->User_ID      =   $this->ID;
            $this->UserName     =   $user_info[$this->Data[F_P_FIELD]] . ' ' . $user_info[$this->Data[FIELD_PREFIX].'lastname'];
            $this->Email        =   $user_info[$this->Data[FIELD_PREFIX].'email'];
            $this->User_Phone   =   $user_info[$this->Data[FIELD_PREFIX].'mobile'];
            $this->IsVerified   =   $user_info[$this->Data[FIELD_PREFIX].'is_verified'];

            # Get user main address info
            $addInfo = UserAddressBook::obj()->GetUserMainAddress($this->ID);
            if(is_array($addInfo))
                $user_info = array_merge($user_info,$addInfo);

            $this->Profile  =   $user_info;

            # Set upload path for user
            $url                =   Utility::obj()->DateTimeBasedUploadLocation("__UPPATH__", $user_info[$this->Data[F_ADDED_DATETIME]], $user_info[$this->Data[F_UP_FOLDER_NAME]], false);
            $this->Data[P_UP]   =   str_replace("__UPPATH__", $this->Data[P_UP], $url);
            $this->Data[V_UP]   =   str_replace("__UPPATH__", $this->Data[V_UP], $url);
        }
    }
	public function getInfoByAuthId($auth_id = '')
	{
		if(empty($auth_id))
			$auth_id	=	$this->AuthId;

		$F_CustomSelect = "MTBL.*,
                        UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."address AS ".$this->Data[FIELD_PREFIX]."address,
                        UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."zipcode AS ".$this->Data[FIELD_PREFIX]."zipcode,
                        UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."region AS ".$this->Data[FIELD_PREFIX]."region,
                        UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoCountry::obj()->Data[F_P_KEY]." AS ".$this->Data[FIELD_PREFIX].GeoCountry::obj()->Data[F_P_KEY].",
                        UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoState::obj()->Data[F_P_KEY]." AS ".$this->Data[FIELD_PREFIX].GeoState::obj()->Data[F_P_KEY].",
                        UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoCity::obj()->Data[F_P_KEY]." AS ".$this->Data[FIELD_PREFIX].GeoCity::obj()->Data[F_P_KEY].",
                        GC.".GeoCity::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX]."city_name,
                        GS.".GeoState::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX]."state_name,
                        GCO.".GeoCountry::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX]."country_name";

		$param = $this->Data[FIELD_PREFIX].AuthUser::obj()->Data[F_P_KEY]." = ? ";
		$value[] = $auth_id;


        $Join = " LEFT JOIN ".UserAddressBook::obj()->Data[TABLE_NAME]. " UA ON UA.".UserAddressBook::obj()->Data[F_F_KEY]." =  MTBL.".$this->Data[F_P_KEY]." AND UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."is_main = '".YES."'";
		$Join .= " LEFT JOIN ".GeoCity::obj()->Data[TABLE_NAME]." GC ON GC.".GeoCity::obj()->Data[F_P_KEY]." = UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoCity::obj()->Data[F_P_KEY];
		$Join .= " LEFT JOIN ".GeoState::obj()->Data[TABLE_NAME]." GS ON GS.".GeoState::obj()->Data[F_P_KEY]." = UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoState::obj()->Data[F_P_KEY];
		$Join .= " LEFT JOIN ".GeoCountry::obj()->Data[TABLE_NAME]." GCO ON GCO.".GeoCountry::obj()->Data[F_P_KEY]." = UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoCountry::obj()->Data[F_P_KEY];

		return parent::getInfoByParam($param, $value, $F_CustomSelect, $Join);
    }
    public function getSearchFilter()
    {
        # Date Period fields
        $this->Data['PeriodChoice']	=	array(
            ''			=>	'All &nbsp;',
            'Month'		=>	'This Month',
            'Week'		=>	'This Week',
            'Today'		=>	'For Today',
            'Specify'	=>	'Specify Period',
        );

        # filter data
        $this->Data['FilterData']	=
            array(  'PeriodChoice'      =>  $this->Data['PeriodChoice'],
                    'IsDateTime'		=>  true);

        return $this->Data['FilterData'];
    }
    public function getQueryParameters($POST=false)
    {
        $Parameters	 =	'';
        $value       =  array();

        if(is_array($POST))
            $this->filter = $POST;

        if(defined('IN_ADMIN') && isset($this->filter['id']) && !empty($this->filter['id']))
        {
            $all_id = explode(',',$this->filter['id']);
            foreach($all_id as $key => $num)
            {
                $num = strtoupper(trim($num));
                $num = is_numeric($num)?$num:$this->EncodeDecodeUserId('D', $num);

                if(is_numeric($num))
                    $id_list[] = $num;
            }
            $Parameters .=  " AND MTBL.".$this->Data[F_P_KEY]." IN (".implode(',',$id_list).")";

            //$Parameters .=  " AND MTBL.".$this->Data[F_P_KEY]." = ? ";
            //$value[]    =   is_numeric($this->filter['id'])?$this->filter['id']:$this->EncodeDecodeOrderId('D', $this->filter['id']);
        }
        if(defined('IN_ADMIN') && isset($this->filter['refer_id']) && !empty($this->filter['refer_id']))
		{
			$Parameters .=  " AND ".$this->Data[FIELD_PREFIX]."refer_id = ? ";

            if(is_numeric($this->filter['refer_id']))
                $value[] = trim($this->filter['refer_id']);
            else
                $value[] = trim($this->EncodeDecodeUserId('D', $this->filter['refer_id']));
		}

        if(isset($this->filter['username']) && !empty($this->filter['username']))
        {
            $keywords = explode(' ',trim($this->filter['username']));
            $searchFields = array($this->Data[F_P_FIELD],$this->Data[FIELD_PREFIX].'lastname');

    		$fieldsToSearch = implode(",", $searchFields);

    		$strSearch = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords);
    		$Parameters .= " AND ( CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]". $strSearch. "') ";

           	//$Parameters	 .=	" AND (".$this->Data[F_P_FIELD]." LIKE '". $this->filter['username']."%' OR ".$this->Data[FIELD_PREFIX]."lastname LIKE '". $this->filter['username']."%')";
        }

        if(isset($this->filter['email']) && !empty($this->filter['email']))
        {
            $Parameters .=  " AND ".$this->Data[FIELD_PREFIX]."email LIKE ?";
            $value[]    =   "%".$this->filter['email']."%";
        }
        if(isset($this->filter['ac_connect_using']) && !empty($this->filter['ac_connect_using']))
        {
            $Parameters .=  " AND UAC.ac_connect_using  = ? ";
            $value[]    =   $this->filter['ac_connect_using'];
        }
        if(isset($this->filter['mobile_ccode']) && !empty($this->filter['mobile_ccode']))
        {
            $Parameters .=  " AND ".$this->Data[FIELD_PREFIX]."mobile_ccode = ? ";
            $value[]    =   $this->filter['mobile_ccode'];
        }
        if(isset($this->filter['mobileno']) && !empty($this->filter['mobileno']))
        {
            $Parameters .=  " AND ".$this->Data[FIELD_PREFIX]."mobile LIKE ?";
            $value[]    =   "%".$this->filter['mobileno']."%";
        }

        if(isset($this->filter['zipcode']) && !empty($this->filter['zipcode']))
        {
            $Parameters .=  " AND UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."zipcode LIKE ?";
            $value[]    =   "%".$this->filter['zipcode']."%";
        }

        if(isset($this->filter[GeoCountry::obj()->Data[F_P_KEY]]) && !empty($this->filter[GeoCountry::obj()->Data[F_P_KEY]]))
        {
            $Parameters .=  " AND UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoCountry::obj()->Data[F_P_KEY]." = ?";
            $value[]    =   Ocrypt::dec($this->filter[GeoCountry::obj()->Data[F_P_KEY]]);
        }

        if(isset($this->filter[GeoState::obj()->Data[F_P_KEY]]) && !empty($this->filter[GeoState::obj()->Data[F_P_KEY]]))
        {
            $Parameters .=  " AND UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoState::obj()->Data[F_P_KEY]." = ?";
            $value[]    =   Ocrypt::dec($this->filter[GeoState::obj()->Data[F_P_KEY]]);
        }

        if(isset($this->filter[GeoCity::obj()->Data[F_P_KEY]]) && !empty($this->filter[GeoCity::obj()->Data[F_P_KEY]]))
        {
            $Parameters .=  " AND UA.".UserAddressBook::obj()->Data[FIELD_PREFIX].GeoCity::obj()->Data[F_P_KEY]." = ?";
            $value[]    =   Ocrypt::dec($this->filter[GeoCity::obj()->Data[F_P_KEY]]);
        }

        if(isset($this->filter['is_active']) && !empty($this->filter['is_active']))
        {
            $Parameters .=  " AND ".$this->Data[F_ACTIVE]." = ?";
            $value[]    =   $this->filter['is_active'];
        }

        if(isset($this->filter['status']) && !empty($this->filter['status']))
        {
            $Parameters .=  " AND AU.".AuthUser::obj()->Data[FIELD_PREFIX]."status = ?";
            $value[]    =   $this->filter['status'];
        }

        if(isset($this->filter['is_verified']) && !empty($this->filter['is_verified']))
        {
            $Parameters .=  " AND ".$this->Data[FIELD_PREFIX]."is_verified = ?";
            $value[]    =   $this->filter['is_verified'];
        }

        if(isset($this->filter['is_deleted']) && !empty($this->filter['is_deleted']))
        {
            $Parameters .=  " AND ".$this->Data[F_VIRTUAL_DELETE]." = ?";
            $value[]    =   $this->filter['is_deleted'];
        }
        if(isset($this->filter['is_seller']) && !empty($this->filter['is_seller']))
        {
            $Parameters .=  " AND ".$this->Data[FIELD_PREFIX]."is_seller = ?";
            $value[]    =   $this->filter['is_seller'];
        }

        # Date period range as per Session Start
        $Parameters .=  $this->getPeriodRangeQuery($this->Data[F_ADDED_DATETIME],$this->getSearchFilter(),'sd','sd_from','sd_to');

        # Date period range as per Session Time
        $Parameters .=  $this->getPeriodRangeQuery($this->Data[FIELD_PREFIX].'dt_updated',$this->getSearchFilter(),'ud','ud_from','ud_to');

        $Parameters .=  $this->getPeriodRangeQuery('AU.'.AuthUser::obj()->Data[FIELD_PREFIX].'currentlogin',$this->getSearchFilter(),'cld','cld_from','cld_to');
        $Parameters .=  $this->getPeriodRangeQuery('AU.'.AuthUser::obj()->Data[FIELD_PREFIX].'lastlogin',$this->getSearchFilter(),'lld','lld_from','lld_to');

        return array('sql'=>$Parameters,'value'=>$value);
    }
    public function _ViewAll($addParameters=false, $value=false, $Join=false, $Custom_Param=false, $allRecord=false)
    {
        $pamars	        =	$this->getQueryParameters();
        $addParameters  .=  $pamars['sql'];

        if(is_array($value) && is_array($pamars['value']))
            $value = array_merge($value,$pamars['value']);
        elseif(is_array($pamars['value']))
            $value =   $pamars['value'];

        $Custom_Param[F_B_SELECT] = "
            MTBL.*,UA.*,
            (
                SELECT CONCAT(".$this->Data[F_P_FIELD].",' ',".$this->Data[FIELD_PREFIX]."lastname)
                FROM ".$this->Data[TABLE_NAME]." SUM
                WHERE SUM.".$this->Data[F_P_KEY]." = MTBL.".$this->Data[FIELD_PREFIX]."refer_id
            ) AS ".$this->Data[FIELD_PREFIX]."refer_name,
            UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."zipcode AS ".$this->Data[FIELD_PREFIX]."zipcode,
            GR.region_name AS ".$this->Data[FIELD_PREFIX]."region,
            GC.city_name AS ".$this->Data[FIELD_PREFIX]."city_name,
            GS.state_name AS ".$this->Data[FIELD_PREFIX]."state_name,
            GCO.country_name AS ".$this->Data[FIELD_PREFIX]."country_name,
            au_status AS ".$this->Data[FIELD_PREFIX]."au_status,
            au_lastlogin AS ".$this->Data[FIELD_PREFIX]."au_lastlogin,
            au_currentlogin AS ".$this->Data[FIELD_PREFIX]."au_currentlogin,
            (
                SELECT GROUP_CONCAT(AC.ac_connect_using)
                FROM ".AuthConnect::obj()->Data[TABLE_NAME]." AC
                WHERE AC.".AuthConnect::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_F_KEY]."
            ) AS ".$this->Data[FIELD_PREFIX]."ac_connect_using ,
            CONCAT('".$this->Data[IMG_RW_URL]."/',".$this->Data[F_P_KEY].") AS ".$this->Data[FIELD_PREFIX]."photo";


        $Join = " LEFT JOIN ".UserAddressBook::obj()->Data[TABLE_NAME]. " UA ON UA.".UserAddressBook::obj()->Data[F_F_KEY]." =  MTBL.".$this->Data[F_P_KEY]." AND UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."is_main = '".YES."' ";
	    $Join .= " LEFT JOIN ".GeoState::obj()->Data[TABLE_NAME]. " GS ON GS.".GeoState::obj()->Data[F_P_KEY]." =  UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."state_id";
        $Join .= " LEFT JOIN ".GeoCity::obj()->Data[TABLE_NAME]. " GC ON GC.".GeoCity::obj()->Data[F_P_KEY]." =  UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."city_id";
        $Join .= " LEFT JOIN ".GeoRegion::obj()->Data[TABLE_NAME]. " GR ON GR.".GeoRegion::obj()->Data[F_P_KEY]." =  UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."region";
        $Join .= " LEFT JOIN ".GeoCountry::obj()->Data[TABLE_NAME]. " GCO ON GCO.".GeoCountry::obj()->Data[F_P_KEY]." =  UA.".UserAddressBook::obj()->Data[FIELD_PREFIX]."country_id";
        $Join .= " LEFT JOIN ".AuthUser::obj()->Data[TABLE_NAME]. " AU ON AU.".AuthUser::obj()->Data[F_P_KEY]." = MTBL.".$this->Data[F_F_KEY];

        # If searching for auth connect then set join for that table to set search parameter
        if(isset($this->filter['ac_connect_using']) && !empty($this->filter['ac_connect_using']))
            $Join .= " LEFT JOIN ".AuthConnect::obj()->Data[TABLE_NAME]." UAC ON UAC.".AuthConnect::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_F_KEY];

        if(!isset($_GET[SO]))
		{
			$_GET[SO] = 'dt_signup';
			$_GET[SD] = 'desc';
		}

        return parent::ViewAll($addParameters, $value, $Join, $Custom_Param, $allRecord);
    }
	public function EncodeDecodeUserIdForFriendRefer($type, $user_id)
	{
		return Ocrypt::ED($type, $user_id);
	}
    public function _Insert($POST)
	{
        global $config;

		$POST['firstname']  =   ucfirst(strtolower($POST['firstname']));
		$POST['lastname']   =   ucfirst(strtolower($POST['lastname']));
		$POST['email']      =   strtolower($POST['email']);

		if(!Utility::obj()->IsBlockedEmail($POST['email']) && AuthUser::obj()->IsAuthIdExists($POST['email'],USER) == false)
		{
            if(isset($POST['password']) && !empty($POST['password']))
                $password = $POST['password'];
            else
                $password = Utility::obj()->generatePassword(array($POST['firstname'],$POST['lastname']));

            # Insert auth detail for user. User email to generate auth id for requested user
			$auth_id = AuthUser::obj()->_InsertNewAuth($POST['email'],$password,USER);

            if($auth_id == md5($POST['email']))
			{
			    # Set auth id in post
				$POST[AuthUser::obj()->Data[F_P_KEY]]    =   $auth_id;

                # Insert auth connect info
				$auth_connect = AuthConnect::obj(true)->Insert($POST);

                if(is_numeric($auth_connect))
				{
				    # If gender not found then unset it from field info
                    if(!isset($POST['gender']))
                        unset($this->Data[F_F_INFO]['gender']);

                    # Set field info and other details to add data in user master
					$this->Data[F_F_INFO][AuthUser::obj()->Data[F_P_KEY]][CNT_TYPE] = C_HIDDEN;
					$this->Data[F_F_INFO]['dt_signup'][CNT_TYPE] = C_DATE_TIME_PICKER;

                    $POST['dt_signup'] = date('Y-m-d H:i:s');
                    $POST['dt_updated'] = date('Y-m-d H:i:s');

                    if(!isset($POST[LeadSource::obj()->Data[F_P_KEY]]) && empty($POST[LeadSource::obj()->Data[F_P_KEY]]))
                        $POST[LeadSource::obj()->Data[F_P_KEY]] = 1;

                    /*
                    # If login id is not posted then generate it and set post
                    if(!isset($POST['login_id']) && empty($POST['login_id']))
                    {
                        $temp = explode('@',$POST['email']);
                        $POST['login_id'] = $temp[0].rand();
                    }
                    */

                    /*if(isset($POST['country_id']) && !is_numeric($POST['country_id']))
			             $POST['country_id'] = Ocrypt::dec($POST['country_id']);

                    if((isset($POST['country_id']) && is_numeric($POST['country_id'])) && (isset($POST['state']) && !empty($POST['state'])) && (isset($POST['city']) && !empty($POST['city'])) )
					{
                        $state_info = GeoState::obj()->NewStateChecking($POST['country_id'],$POST['state']);

                        $city_info  = GeoCity::obj()->NewCityChecking($POST['country_id'],$state_info[GeoState::obj()->Data[F_P_KEY]],$POST['city']);

                        $POST['state']  = $state_info[GeoState::obj()->Data[F_P_KEY]];
                        $POST['city']   = $city_info[GeoCity::obj()->Data[F_P_KEY]];
                    }
                    else
                    {
                        $POST['state']  = 0;
                        $POST['city']   = 0;
                    }
                    */
                    $POST['is_active'] = YES;
                    # Insert user basic details
                    $user_id = parent::Insert($POST);

                    if(is_numeric($user_id))
					{
                        $POST[$this->Data[F_P_KEY]] = $user_id;

                        # Insert into subscribers table
                        Subscribers::obj(true)->_Insert($POST);

                        # Add sign up log
						$POST[$this->Data[F_F_KEY]] = $auth_id;
						UserLog::obj()->AddUserActionLog(ULOG_ACTION_SIGNUP,$POST,$user_id);

                        # Send welcome email
						if(isset($POST['send_welcome_email']) && $POST['send_welcome_email'] == YES)
						{
						  	if($this->SendWelComeEmail($user_id, $password) === true)
                            {
                                return $user_id;
                            }
                            else
							{
								$this->Error[E_DESC] = "Successfully completed sign up but unable to send you confirmation email. Please contact support department with your email id or other valid information.";
								return false;
							}
						}
						else
							return $user_id;
					}
					else
					{
						# Failed to add user master details so delete its auth
						AuthUser::obj()->Delete($auth_id);
						return false;
					}
				}
				else
				{
					# Failed to add auth connet details so delete its auth al
					$this->Error[E_DESC] = AuthConnect::obj()->Error[E_DESC];
					AuthUser::obj()->Delete($auth_id);
					return false;
				}
			}
			else
			{
				$this->Error[E_DESC] = AuthUser::obj()->Error[E_DESC];
				return false;
			}
		}
		else
		{
			$this->Error[E_DESC] = "User is already registered. Please try another email.";
			return false;
		}
	}
	public function _Update($pkValue, $POST)
	{

        $POST['firstname']  =   ucfirst(strtolower($POST['firstname']));
		$POST['lastname']   =   ucfirst(strtolower($POST['lastname']));

        $POST[LeadSource::obj()->Data[F_P_KEY]]    =   isset($POST[LeadSource::obj()->Data[F_P_KEY]])?$POST[LeadSource::obj()->Data[F_P_KEY]]:1;

        /*if(isset($POST['country_id']) && !is_numeric($POST['country_id']))
            $POST['country_id'] = Ocrypt::dec($POST['country_id']);

        if((isset($POST['country_id']) && is_numeric($POST['country_id'])) && (isset($POST['state']) && !empty($POST['state'])) && (isset($POST['city']) && !empty($POST['city'])) )
		{
            $state_info = GeoState::obj()->NewStateChecking($POST['country_id'],$POST['state']);

            $city_info = GeoCity::obj()->NewCityChecking($POST['country_id'],$state_info[GeoState::obj()->Data[F_P_KEY]],$POST['city']);

            $POST['state'] = $state_info[GeoState::obj()->Data[F_P_KEY]];
            $POST['city'] = $city_info[GeoCity::obj()->Data[F_P_KEY]];
        }

        if(!isset($POST['state']) || isset($POST['state']) && empty($POST['state']))
        {
            $POST['state'] = 0;
            $POST['city'] = 0;
        }*/

        # Set date time
        $POST['dt_updated'] = date('Y-m-d H:i:s');

		# Get auth ID of user from user id
        $auth_id = $this->getAuthIdByPk($pkValue);

        # Get user info from user id
        $user_info = $this->getInfoById($pkValue);

        if(isset($POST['email']) && $auth_id != AuthUser::obj()->encAuthId($POST['email']))
            $change_auth_id = true;

         # Change username if new entered at here email will be used to generat auth id
		if(isset($change_auth_id) && $change_auth_id === true)
		{
			$new_auth_id = AuthUser::obj()->ChangeAuthId($POST['email'],$auth_id);

			if($new_auth_id != md5($POST['email']))
			{
			 	$this->Error[E_DESC] = AuthUser::obj()->Error[E_DESC];
				return false;
            }
		}
        return parent::Update($pkValue, $POST);


	}
    /*public function MoveUploadedImage($user_id)
    {
        global $physical_path;

        if(!is_numeric($user_id))
            return false;

        # get user photo name by user_id
        $info = parent::getInfoById($user_id,$this->Data[FIELD_PREFIX].'image_file');

        # If user photo name found then copy from user folder to user_id folder
        if(is_array($info) && count($info) > 0 && !empty($info[$this->Data[FIELD_PREFIX].'image_file']))
        {
            $source = $physical_path['Upload'].'/user/'.$info[$this->Data[FIELD_PREFIX].'image_file'];
            $destination = $this->Data[P_UP]."/".$info[$this->Data[FIELD_PREFIX].'image_file'];

            # Copy image from user folder to user_id folder and remove from user folder
            if(copy($source,$destination))
                unlink($source);
        }
    }*/
	public function WebUserSignUp($POST)
	{
        if(is_array($POST) &&  Utility::obj()->ValidateEmail($POST['email']) === true)
		{
			if(isset($POST['tnc_pp']) && $POST['tnc_pp'] === YES)
			{
			    if($this->IsUserVirtualDeleted(false,AuthUser::obj()->encAuthId($POST['email'])) === false)
                {
                    $user_id = $this->_Insert($POST);

                    if(is_numeric($user_id))
					   	return $user_id;
					else
						return false;
                }
                else
                {
					$this->Error[E_DESC] = 'Sorry, unable to sign up. Please try again with another email id.';
                    return false;
			    }
			}
			else
			{
				$this->Error[E_DESC] = "You did not agree with the terms of use & privacy policy.";
				return false;
			}
		}
		else
		{
			$this->Error[E_DESC] = "Please, check all your input(s). Make sure you have entered all valid information.";
			return false;
		}
	}
    public function WebUserLogin($username, $password, $third_party=false,$keep_logged=false)
    {
        $info = AuthUser::obj()->AuthenticateValidLogin($username,$password,USER,$third_party);

        if(($info['STATUS'] == '1' || $info['STATUS'] == '2') && is_array($info['INFO']))
        {
            $arrUser = $info['INFO'];

            # Create succesfull login for user
            AuthUser::obj()->doLoginByAuth($arrUser[$this->Data[F_F_KEY]], $arrUser[$this->Data[FIELD_PREFIX].'email'],$keep_logged);

            # Update user last and current visit
            AuthUser::obj()->updateCurrentVisit($arrUser[$this->Data[F_F_KEY]]);

            # Delete other session for current logged user
            AuthUser::obj()->InactiveOtherSession($arrUser[$this->Data[F_F_KEY]]);

            # User Log Insert as logged in to his account
            UserLog::obj()->AddUserActionLog(ULOG_ACTION_USERLOGIN,$arrUser,$arrUser[$this->Data[F_P_KEY]]);

            # Update login status as online now
            AuthUser::obj()->UpdateCurrentStatus(STATUS_ONLINE, $arrUser[$this->Data[F_F_KEY]]);

            # Save users recently visited products to his account
            UserRecentlyVisitedProduct::obj()->InsertRecentlyVisitedProductInfo($arrUser[$this->Data[F_P_KEY]]);

            # Save users wish list to his account
            UserWishlist::obj()->InsertMyWishList($arrUser[$this->Data[F_P_KEY]]);

			return true;
        }
        else
        {
            $this->Error[E_DESC] = $info['MSG'];
            return false;
        }
    }
    /*
     * Created new methode instead of this
     * Remove it in future
    public function WebUserLogin($username, $password, $third_party=false,$keep_logged=false)
	{
        if(empty($password) && empty($third_party))
		{
            $this->Error[E_DESC] = 'Sorry, not enough infomation found for login.';
            return false;
		}

	   if(!empty($username))
	   {
            $arrUser = UserMaster::obj()->GetInfoByUserName($username);
            if (is_array($arrUser))
            {
                if($arrUser[$this->Data[F_ACTIVE]] == YES && $arrUser[$this->Data[FIELD_PREFIX].'is_verified'] == YES)
                {
                    $result = AuthUser::obj()->IsValidLogin($arrUser[$this->Data[FIELD_PREFIX].'email'],$password,USER,$third_party);

                    # auth is not active
                    if($result == '1')
                        $this->Error[E_DESC] = 'Your profile is inactive. Please contact administrative.';
                    # Password does not match
                    elseif($result == '2')
                        $this->Error[E_DESC] =  'Invalid Username / Password.';
                    # Reset password request
                    elseif($result == '3')
                        AuthUser::obj()->UpdateForgetPassword($arrUser[$this->Data[F_F_KEY]], $password);

                    # All correct
                    elseif($result == '4')
                    {
                        AuthUser::obj()->doLoginByAuth($arrUser[$this->Data[F_F_KEY]], $arrUser[$this->Data[FIELD_PREFIX].'email'],$keep_logged);

	                    # Update user last and current visit
	                    AuthUser::obj()->updateCurrentVisit(AuthUser::obj()->encAuthId($arrUser[$this->Data[FIELD_PREFIX].'email']));

                        # Delete other session for current logged user
                        AuthUser::obj()->InactiveOtherSession($arrUser[$this->Data[F_F_KEY]]);

                        # User Log Insert
                        UserLog::obj()->AddUserActionLog(ULOG_ACTION_USERLOGIN,$arrUser,$arrUser[UserMaster::obj()->Data[F_P_KEY]]);

	                    # Update login status
	                    AuthUser::obj()->UpdateCurrentStatus(STATUS_ONLINE, $arrUser[$this->Data[F_F_KEY]]);


    					return true;
                    }
                    else
                        $this->Error[E_DESC] = 'Invalid Username / Password.';
                }
                else
                    $this->Error[E_DESC] = 'Sorry, your account is locked or may be not verified.';
            }
            else
                $this->Error[E_DESC] = 'Invalid Username / Password.';
        }
        else
            $this->Error[E_DESC] = 'Please, check all your input(s). Make sure you have entered all valid information.';

		return false;
    }*/
	public function ActivateUserAccount($user_id, $user_email, $POST=false)
	{
		$Auth_Info  =   AuthUser::obj()->getInfoById(AuthUser::obj()->encAuthId($user_email));
		$User_Info  =   $this->getInfoById($user_id);

		if(count($Auth_Info) > 0 && count($User_Info) > 0 && $Auth_Info[AuthUser::obj()->Data[F_P_KEY]] === $User_Info[$this->Data[F_F_KEY]])
		{
			if($Auth_Info['au_perm'] === USER && $User_Info[$this->Data[FIELD_PREFIX].'is_verified'] === NO)
			{
                if($POST != false)
				{
                    # Update User Info
                    $User = $this->UpdateUserInfoToActivateAccount($User_Info[$this->Data[F_P_KEY]],$POST);
                }

                # Set email confirmation flag
				$e = $this->SetEmailConfirmationStatus(YES,$User_Info[$this->Data[F_P_KEY]], $Auth_Info[AuthUser::obj()->Data[F_P_KEY]]);

				# Set activation flag
				//$a = $this->SetActiveInactiveStatus(YES,$User_Info[$this->Data[F_P_KEY]], $Auth_Info[AuthUser::obj()->Data[F_P_KEY]]);


				# User Log Insert
				$log = array(
					$this->Data[F_F_KEY]               =>  $Auth_Info[AuthUser::obj()->Data[F_P_KEY]],
					$this->Data[F_P_KEY]               =>  $user_id,
					$this->Data[FIELD_PREFIX].'email'  =>  $user_email,
				);

				UserLog::obj()->AddUserActionLog(ULOG_ACTION_ACCOUNTACTIVATION,$log,$User_Info[$this->Data[F_P_KEY]],($e),$User_Info);

				return true;
			}
			else
				return false;
		}
		else
			return false;
	}
	public function SetEmailConfirmationStatus($status, $user_id=false, $auth_id=false)
	{
		if($user_id == false && $auth_id == false)
			return false;

		$field_sets		=	$this->Data[FIELD_PREFIX]."is_verified = ?";
		$value[]        =   $status;

		$where_condition = '';
		if($user_id != false)
		{
			$where_condition .=	$this->Data[F_P_KEY]." = ? ";
			$value[] = $user_id;
		}
		if($auth_id != false)
		{
			$where_condition .=	(($user_id != false)?' AND ':'').$this->Data[F_F_KEY]." = ? ";
			$value[] = $auth_id;
		}

		return $this->UpdateFieldByParam($field_sets, $where_condition, $value);
	}
	public function SetActiveInactiveStatus($status, $user_id=false, $auth_id=false)
	{
		if($user_id == false && $auth_id == false)
			return false;

		$field_sets		=	$this->Data[F_ACTIVE]." = ?";
		$value[]        =   $status;

		$where_condition = '';
		if($user_id != false)
		{
			$where_condition .=	$this->Data[F_P_KEY]." = ? ";
			$value[] = $user_id;
		}
		if($auth_id != false)
		{
			$where_condition .=	(($user_id != false)?' AND ':'').$this->Data[F_F_KEY]." = ? ";
			$value[] = $auth_id;
		}

		return $this->UpdateFieldByParam($field_sets, $where_condition, $value);
	}
	public function GenerateUserAccountActivationLink($user_id, $user_email)
	{
		global $virtual_path;

		if(!is_numeric($user_id))
			return false;

		$code = serialize(array($user_email,$user_id));
		$code = Ocrypt::ED('E', $code);

        $url = $virtual_path['Main_Host_Url'].'/activation/?account='.$code;

		return $url;
	}
    public function SendWelComeEmail($user_id, $password = false)
    {
        global $config, $asset, $virtual_path, $physical_path;

        if(!is_numeric($user_id))
	        return false;

        # Set user id
		$this->SetUserId($user_id);
        $UserInfo = $this->Profile;
        //$UserInfo = $this->getInfoById($this->User_ID);

        # Create email temple object
        EmailTemplateMaster::obj(true);

		# For Sending Mail To User Fetch Email Template
		$arrTemplate = EmailTemplateMaster::obj()->getInfoById(EMAIL_WELCOME);

        # Is Active Template ?
		if($arrTemplate[EmailTemplateMaster::obj()->Data[F_ACTIVE]] == YES)
		{
			$user_name = $UserInfo[$this->Data[F_P_FIELD]]." ".$UserInfo[$this->Data[FIELD_PREFIX].'lastname'];

            $Site_Link	=	'<a target="_blank" href="'.$config['site_url'].'/?lg=1">'.$config['site_domain'].'</a>';

            $ActivationLink    =   $this->GenerateUserAccountActivationLink($user_id, $UserInfo[$this->Data[FIELD_PREFIX].'email']);

            $arrReplaceWith = array($config['site_title'], $config['site_url'], $config['site_domain'],$Site_Link, $user_name, $UserInfo[$this->Data[FIELD_PREFIX].'email'], $ActivationLink);

            $Email_Subject = str_replace($asset['SYSTEM_CONTENT_VARIABLE']['Email_Template_User_Registration'], $arrReplaceWith, $arrTemplate[EmailTemplateMaster::obj()->Data[FIELD_PREFIX].'subject']);

            $mail = '';

            require_once($physical_path['Libs']. '/Mail/htmlMimeMail.php');
            $mail = new htmlMimeMail();

			$mail->setFrom($config['email_registration_title']. " <".$config['email_registration'].">");
			$mail->setSubject($Email_Subject);

            $email_body = $arrTemplate[EmailTemplateMaster::obj()->Data[FIELD_PREFIX].'body_content'];

            $Email_Body = str_replace($asset['SYSTEM_CONTENT_VARIABLE']['Email_Template_User_Registration'], $arrReplaceWith, $email_body);

			st::$obj->assign(array(
                                "Email_Header"		=>	'email_header'. $config[TPL_EX],
								"isContent"			=>	true,
								"Email_Body"		=>	$Email_Body. '<br /><br />'. $config['email_sign'],
								"Email_Footer"		=>	'email_footer'. $config[TPL_EX],
								"EmailSendFrom"		=>	$config['email_registration'],
                                "Use_HeaderFooter"  =>  $arrTemplate[EmailTemplateMaster::obj()->Data[FIELD_PREFIX].'use_header_footer'],
								));

			//print(st::$obj->fetch('email_layout'.$config['tplEx'])); exit();
			//file_put_contents('verify_email_test.html', st::$obj->fetch('email_layout'.$config[TPL_EX]));

            $email_layout = st::$obj->fetch('email_layout'.$config[TPL_EX]);
            $mail->setHtml($email_layout);

			# Set Bcc
			$strBcc = Utility::obj()->GenerateBccString();

			if($strBcc != '')
				$mail->setBcc($strBcc);

			$mail->send(array($user_name.' <'.$UserInfo[$this->Data[FIELD_PREFIX].'email'].'>'));

            # Insert lead email entry
            $post[$this->Data[F_P_KEY]] =   $user_id;
            $post['type']               =   LETYPE_SIGNUP;
            $post['to_name']            =   $UserInfo[$this->Data[F_P_FIELD]];
            $post['to_email']           =   $UserInfo[$this->Data[FIELD_PREFIX].'email'];
            $post['from_name']          =   $config['email_registration_title'];
            $post['from_email']         =   $config['email_registration'];
            $post['subject']            =   $Email_Subject;
            $post['bcc']                =   $strBcc;
            $post['main_content']       =   $Email_Body;
            $post['sign']               =   $config['email_sign'];
            $post['sent']               =   YES;
            $post['sent_datetime']      =   date('Y-m-d H:i:s');

			LeadEmail::obj(true)->_Insert($post);

            return true;
		}
        else
            return true;
    }
    /*public function Delete($id, $retField='')
    {
        $this->Error[E_DESC] = "Sorry, due to some technical limitation user delete is not allowed at this time.";
        return false;
    }*/
	public function _Delete($id, $retField='')
	{
		$auth_id = $this->getAuthIdByPk($id);

		if(is_array($auth_id))
		{
			foreach ($auth_id as $key => $value)
				$ids[] = $value[$this->Data[F_F_KEY]];
		}
		else
			$ids = $auth_id;

		$return =  AuthUser::obj()->Delete($ids);

        $p_up = $this->Data[P_UP];
        if(is_array($id))
        {
            foreach ($id as $key => $pk)
            {
                $this->Data[P_UP] = $p_up.'/'.$pk;
                Utility::obj()->deleteDirectory($this->Data[P_UP]);
            }
        }
        else
        {
            $this->Data[P_UP] = $p_up.'/'.$id;
            Utility::obj()->deleteDirectory($this->Data[P_UP]);
        }
        return $return;
	}
	public function getAuthIdByPk($pk)
	{
		$info   =   $this->getInfoById($pk,$this->Data[F_F_KEY]);

        if(is_array($info))
		{
			if(count($info) == 1)
				return $info[$this->Data[F_F_KEY]];
			else
				return $info;
		}
		else
			return false;
	}
    public function UpdateUserPasswordFromAdmin($pk, $POST)
    {
	    global $asset;

	    UserLog::obj(true);

        # get auth id
        $auth_id = $this->getAuthIdByPk($pk);

        # update password for user
        $affected_row = AuthUser::obj()->UpdateAuthPassword($auth_id, $POST['password']);

        # Send email to user for
        if(isset($POST['send_forgotpassword_email']))
            $this->SendPasswordResetEmail($pk, $POST['password']);

	    $POST[$this->Data[F_F_KEY]] = $auth_id;
        # User Log Insert
	    if($this->ActionLog === true)
	        UserLog::obj()->AddUserActionLog(ULOG_ACTION_FORGOTPASSWORD,$POST,$pk,$affected_row, false,array('NewPassword' => $POST['password']));

	    # Add admin user action log
	    if($this->ActionLog === true && !in_array($this->Data[TABLE_NAME], $asset['Table_NotAllowActionLog_Add']))
		    AdminLog::obj()->AddActionLog(A_CHANGE_USER_PASSWORD,$pk,$POST,$affected_row, false, array('NewPassword' => $POST['password']));

	    return $affected_row;
    }
    public function SendPasswordResetEmail($user_id, $password)
    {
        global $config, $asset, $virtual_path, $physical_path;

        if(is_numeric($user_id))
	    {
			# Set User
			$this->SetUserId($user_id);
            $UserInfo = $this->getInfoById($this->User_ID);

            # Create email temple object
            EmailTemplateMaster::obj(true);

			# For Sending Mail To User Fetch Email Template
			$recTemplate = EmailTemplateMaster::obj()->getInfoById(EMAIL_FORGOT_PASSWORD);

            # Is Active Template ?
			if($recTemplate[EmailTemplateMaster::obj()->Data[F_ACTIVE]] == YES)
			{
				$user_name = $UserInfo[$this->Data[F_P_FIELD]]." ".$UserInfo[$this->Data[FIELD_PREFIX].'lastname'];

                $arrReplaceWith = array($config['site_title'], $config['site_url'], $config['site_domain'],$user_name,$UserInfo[$this->Data[FIELD_PREFIX].'email'],$password);
                $Email_Subject = str_replace($asset['SYSTEM_CONTENT_VARIABLE']['Email_Template_Forgot_Password'], $arrReplaceWith, $recTemplate[EmailTemplateMaster::obj()->Data[FIELD_PREFIX].'subject']);

                require_once($physical_path['Libs']. '/Mail/htmlMimeMail.php');
                $mail = '';
				$mail = new htmlMimeMail();

                $sentFrom = $config['email_webmaster_title']. " <".$config['email_webmaster'].">";
				$mail->setFrom($sentFrom);
				/*$mail->setHeader("Reply-To","ODeveloper <odeveloper@oequal.com>");*/
				$mail->setSubject($Email_Subject);

				#Assign all variables
				/*st::$obj->assign(array(
                                    $this->Data[FIELD_PREFIX].'name'        =>	$user_name,
                                    $this->Data[FIELD_PREFIX].'login_id'    => 	$UserInfo[$this->Data[FIELD_PREFIX].'email'],
                                    $this->Data[FIELD_PREFIX]'password'     =>	($password != false)?$password:'Login is not allowed.',
                                    'Site_Title'                            =>	$config['site_title'],
                                    'Site_Url'                              =>	$config['site_url'],
                                    'Site_Domain'                           =>	$config['site_domain'],
                                    'Site_Link'                             =>	'<a target="_blank" href="'.$config['site_url'].'/?lg=1">'.$config['site_domain'].'</a>',
                                    'ActivationLink'                        =>  $virtual_path['Host_Url'].'/user/activate-account/?email-verification='.Ocrypt::encode($UserInfo[$this->Data[FIELD_PREFIX].'email']),
						));*/

                //$email_body = st::$obj->fetch('email_template:'. EMAIL_FORGOT_PASSWORD);
                $email_body = $recTemplate[EmailTemplateMaster::obj()->Data[FIELD_PREFIX].'body_content'];

                $Email_Body = str_replace($asset['SYSTEM_CONTENT_VARIABLE']['Email_Template_Forgot_Password'], $arrReplaceWith, $email_body);

				st::$obj->assign(array(
                                    "Email_Header"		=>	'email_header'. $config['tplEx'],
									"isContent"			=>	true,
									"Email_Body"		=>	$Email_Body. '<br /><br />'. $config['email_sign'],
									"Email_Footer"		=>	'email_footer'. $config['tplEx'],
									"EmailSendFrom"		=>	$config['email_webmaster'],
                                    "Use_HeaderFooter"  =>  $recTemplate[EmailTemplateMaster::obj()->Data[FIELD_PREFIX].'use_header_footer'],
                                    'subscriber_id'     =>  Subscribers::obj()->getSubscriberIdFromEmail($UserInfo[$this->Data[FIELD_PREFIX].'email']),
								));
                //print(st::$obj->fetch('email_layout'.$config['tplEx'])); exit();
				//file_put_contents('forgot_emial_test.html', st::$obj->fetch('email_layout'.$config['tplEx']));

				$email_layout = st::$obj->fetch('email_layout'.$config['tplEx']);
                $mail->setHtml($email_layout);

				# Set Bcc
				$strBcc = Utility::obj()->GenerateBccString();
				if($strBcc != '')
					$mail->setBcc($strBcc);
               	$mail->send(array($user_name.' <'.$UserInfo[$this->Data[FIELD_PREFIX].'email'].'>'));

				# Insert lead email entry
                $post[$this->Data[F_P_KEY]] =   $user_id;
                $post['type']               =   LETYPE_FORGOTPASSWORD;
                $post['to_name']            =   $user_name;
                $post['to_email']           =   $UserInfo[$this->Data[FIELD_PREFIX].'email'];
                $post['from_name']          =   $config['email_webmaster_title'];
                $post['from_email']         =   $config['email_webmaster'];
                $post['subject']            =   $Email_Subject;
                $post['bcc']                =   $strBcc;
				$post['main_content']       =   $Email_Body;
                $post['sign']               =   $config['email_sign'];
                $post['sent']               =   YES;
                $post['use_header_footer']  =   YES;
                $post['sent_datetime']      =   date('Y-m-d H:i:s');
                LeadEmail::obj(true)->_Insert($post);
                //echo LeadEmail::obj()->Error[E_DESC];

                return true;
            }
            else
                return false;
		}
        else
            return false;
    }
    public function _BasicResponseProcess($Action, $POST, $file_name, $objController = false)
    {
        global $msgError, $msgSuccess;

        if(isset($objController->Data[C_COMMAND_LIST]) && in_array($Action, $objController->Data[C_COMMAND_LIST]))
        {

            if($Action == A_CHANGE_USER_PASSWORD && isset($POST['SubmitForm']) && $POST['SubmitForm'] == 'Save')
            {
				$affected_row = $objController->UpdateUserPasswordFromAdmin($POST['pk'], $POST);

				if(is_numeric($affected_row))
				{
					if(defined('IN_XAJAX'))
					{
						$_GET['save-pass'] = 'true';
					}
					else
					{
						$msgSuccess = "Password has been changed.";

                        if(isset($POST['IsRedirect']) && $POST['IsRedirect'] == YES)
                        {
                            header("location: ".$file_name."Action=".A_USER_ACT_PROFILE."&pk=".Ocrypt::enc($POST['pk'])."&save-pass=true");
    						exit();
                        }
					}
				}
				else
					$msgError = $objController->Error[E_DESC];
			}
            elseif($Action == A_ADD_AUTH_CONNECT && isset($_POST['AuthConnectForm']) && $_POST['AuthConnectForm'] == 'Save')
            {
                if(!is_numeric($POST['pk']))
                    $POST['pk'] = Ocrypt::dec($POST['pk']);
                else
                    $POST['pk'] = $POST['pk'];

                # Get email from pk
                $info = $objController->getInfoById($POST['pk'],$this->Data[FIELD_PREFIX]."email");

                $IsExist = AuthConnect::obj()->IsAuthConnectExists($POST['ac_connect_using'],AuthUser::obj()->encAuthId($info[$this->Data[FIELD_PREFIX].'email']));

                if($IsExist == false)
                {
                    $POST[AuthUser::obj()->Data[F_P_KEY]]    =   AuthUser::obj()->encAuthId($info[$this->Data[FIELD_PREFIX].'email']);

                    AuthConnect::obj()->populateSchema(true);

                    $affected_row = AuthConnect::obj()->_Insert($POST);

                    if(is_numeric($affected_row))
                    {
                        if(isset($POST['IsRedirect']) && $POST['IsRedirect'] == YES)
                        {
                            header("location: ".$file_name."Action=".A_USER_ACT_PROFILE."&pk=".Ocrypt::enc($POST['pk'])."&add-auth-con=true");
        					exit();
                        }
                    }
                    else
                    {
                       $msgError = AuthConnect::obj()->Error[E_DESC];
                       //header("location: ".$file_name."Action=".A_USER_ACT_PROFILE."&pk=".Ocrypt::enc($POST['pk'])."&add-auth-con=false");

                    }
                }
                else
                    header("location: ".$file_name."Action=".A_USER_ACT_PROFILE."&pk=".Ocrypt::enc($POST['pk'])."&add-auth-con=false");
            }
        }

        /*if($Action == A_USER_ACT_EDIT && isset($POST['SubmitForm']) && $POST['SubmitForm'] == 'Save')
		{
            $file_name = $this->UM_PadControllerUrl($this->Data['ScriptName']);

            if(method_exists($objController,'_Update'))
				$affected_row = $objController->_Update($POST['pk'], $POST);
			else
				$affected_row = $objController->Update($POST['pk'], $POST);

            if(is_numeric($affected_row))
			{
				if(defined('IN_XAJAX'))
				{
					$_GET['save'] = 'true';
				}
				else
				{
				    $file_name = Utility::obj()->pad_query_string($file_name, "Action=".A_USER_ACT_EDIT);
				    header("location: ".$file_name."&save=true");
					exit();
				}
			}
			else
				$msgError = $objController->Error[E_DESC];
        }*/
    }
    public function GetInfoByUserName($username)
	{
		$param	=	$this->Data[FIELD_PREFIX]."email = :username ";
        return parent::getInfoByParam($param, array(':username'=>$username));
	}
    public function getUserIdByEmail($email)
	{
        $F_CustomSelect = $this->Data[F_P_KEY];
		$param	=	$this->Data[FIELD_PREFIX]."email = :email";
        $info   =  parent::getInfoByParam($param, array(':email'=>$email), $F_CustomSelect);

        if(isset($info[$this->Data[F_P_KEY]]) && is_numeric($info[$this->Data[F_P_KEY]]))
            return $info[$this->Data[F_P_KEY]];
        else
            return false;
	}
    public function ResetFieldInfo($id)
    {
        if($id == 1)
        {
            # Must unset email filed so no one can try to modify it
	        unset($this->Data[F_F_INFO]['email'],$this->Data[F_F_INFO]['mobile_ccode'],$this->Data[F_F_INFO]['mobile'], $this->Data[F_F_INFO]['is_active'],$this->Data[F_F_INFO]['is_verified']);

            /*$additional_info = array(VALIDATE => true, VAL_TYPE => V_EMPTY);

            $this->Data[F_F_INFO]['state']  = array_merge($this->Data[F_F_INFO]['state'] , $additional_info);
            $this->Data[F_F_INFO]['city']   = array_merge($this->Data[F_F_INFO]['city'] , $additional_info);
            $this->Data[F_F_INFO]['region'] = array_merge($this->Data[F_F_INFO]['region'] , $additional_info);
            $this->Data[F_F_INFO]['address']= array_merge($this->Data[F_F_INFO]['address'] , $additional_info);*/

        }
    }
    public function getUserNameById($user_id)
    {
        global $config;

        $F_CustomSelect = "CONCAT(".$this->Data[F_P_FIELD].",' ',".$this->Data[FIELD_PREFIX]."lastname) AS ".$this->Data[FIELD_PREFIX]."fullname, ".$this->Data[F_VIRTUAL_DELETE].", ".$this->Data[F_P_KEY];
        $info = parent::getInfoById($user_id, $F_CustomSelect);

        if(!is_array($info) || count($info) <= 0)
            return false;

        if(defined('IN_SITE'))
            $out =  $info[$this->Data[FIELD_PREFIX].'fullname'];
        elseif(defined('IN_ADMIN'))
        {
            /*st::$obj->assign(array(
                'Record'        =>  $info,
                FIELD_PREFIX    =>  $this->Data[FIELD_PREFIX],
            ));
            $out = st::$obj->fetch('user-fullname'.$config[TPL_EX]);*/
            $out =  $info[$this->Data[FIELD_PREFIX].'fullname']." ( ".$this->EncodeDecodeUserId('E',$info[$this->Data[F_P_KEY]])." | ".$info[$this->Data[F_P_KEY]]." )";
        }
        return $out;
    }
	public function C_CommandList_UserInfo()
	{
		$CommandList['CCList_UserLog']          =   AuthUser::obj()->getUserPermissionByModule('UserLog');
		$CommandList['CCList_LeadEmail']        =   AuthUser::obj()->getUserPermissionByModule('LeadEmail');
		$CommandList['CCList_SessionMaster']    =   AuthUser::obj()->getUserPermissionByModule('SessionMaster');
        $CommandList['CCList_UserMaster']       =   AuthUser::obj()->getUserPermissionByModule('UserMaster');
        $CommandList['CCList_RecentlyVistedCatalog']=   AuthUser::obj()->getUserPermissionByModule('RecentlyVisitedProduct');
		$CommandList['CCList_UserWishlist']       =   AuthUser::obj()->getUserPermissionByModule('UserWishlist');
        $CommandList['CCList_LedaMaster']       =   AuthUser::obj()->getUserPermissionByModule('LeadMaster');
        $CommandList['CCList_OrderMaster']       =   AuthUser::obj()->getUserPermissionByModule('OrderMaster');
        $CommandList['CCList_UserAddressBook']  =   AuthUser::obj()->getUserPermissionByModule('UserAddressBook');
        $CommandList['CCList_DisputeMaster']  =   AuthUser::obj()->getUserPermissionByModule('DisputeMaster');
        $CommandList['CCList_UserSavedSearch']  =   AuthUser::obj()->getUserPermissionByModule('UserSavedSearch');


        $this->Data['C_CommandList_UserInfo']   =   $CommandList;

		return $this->Data['C_CommandList_UserInfo'];
	}
	public function GenerateReferFriendUrlForUser($user_id)
	{
		global $virtual_path, $config;

        $user_name  =   $this->buildURLFriendlyName($this->getUserNameById($user_id));

		$user_id    =   $this->EncodeDecodeUserIdForFriendRefer('E', $user_id);

		$url        =   $virtual_path['Host_Url'].$config['referring_my_friend_url'].$user_name."/".$user_id."/".$virtual_path['Signup_Url'];

		return $url;
	}
    public function UM_PadControllerUrl($file_name)
    {
        if(isset($_GET['UM']))
        {
            if(isset($_GET['UM']))
                $pad = "UM=".$_GET['UM'];

            $file_name = Utility::obj()->pad_query_string($file_name, $pad);
        }

        return $file_name;
    }
	public function GetAuthIDfromUserID($user_id)
    {
        if(!is_numeric($user_id))
            return false;

        //$this->Data[F_B_SELECT] = $this->Data[F_F_KEY];

        $auth_info = parent::getInfoByID($user_id);

        if(is_array($auth_info) && !empty($auth_info))
            return $auth_info[$this->Data[F_F_KEY]];
        else
            return false;
    }
    public function getUserForAccountActivationReminder($limit=0)
    {
        $param = ' AND '.$this->Data[F_ACTIVE].' = ? AND '.$this->Data[FIELD_PREFIX].'is_verified = ? AND NOW() > ADDTIME('.$this->Data[F_ADDED_DATETIME].', "1 0:0:0")';

	    if($limit > 0)
	        $this->Data[SQL_LIMIT] = ' LIMIT 0,'.$limit;

		return parent::getAll($param, array(NO, NO));
    }
    public function  getAllSuggestionUserByName($str, $limit=100,$is_seller=false)
    {
        $addParameters  = '';
        $value          = '';

        if($is_seller != false)
        {
            $addParameters .= " AND  ".$this->Data[FIELD_PREFIX]."is_seller = ? ";
            $value[]        = $is_seller;
        }
        $searchFields   =   array($this->Data[F_P_FIELD], $this->Data[FIELD_PREFIX].'lastname');
        $limit          =   !empty($limit) ? intval($limit) : 100;

	    return parent::getAutoSuggestionRecord($str, $searchFields, $addParameters, $value, $Custom_Param=false, $Join=false, $limit);
    }
    public function IsUserVirtualDeleted($user_id=false, $auth_id=false)
    {
        if(!is_numeric($user_id) && empty($auth_id))
            return false;

        if(is_numeric($user_id))
            $user_info = $this->getInfoById($user_id,$this->Data[F_VIRTUAL_DELETE]);
        elseif(!empty($auth_id))
        {
            if(filter_var($auth_id, FILTER_VALIDATE_EMAIL) == true ||  is_numeric($auth_id) || is_string($auth_id))
                $auth_id = AuthUser::obj()->encAuthId($auth_id);

            $user_info = $this->getInfoByAuthId($auth_id);
        }

        if(is_array($user_info) && $user_info[$this->Data[F_VIRTUAL_DELETE]] == YES)
            return true;
        else
            return false;
    }
    /**
     * Developed By : Krutik Khalasi
     * Date Time : 31 OCT 2014 12:40 PM
     **/
    public function AllUserConformSignUP($limit = 10)
    {
        $addParameters = " AND ". $this->Data[F_ACTIVE]." = ? AND ".$this->Data[FIELD_PREFIX]."is_verified = ? ";
        $Custom_Param[SQL_LIMIT] = " LIMIT 0,".$limit;

        return parent::getAll($addParameters, array(YES, YES), $value=false, $Join=false,$Custom_Param);
    }
    /*public function getReferalIdAllUsers($user_ref_id)
    {
        if(is_numeric($user_ref_id))
		{
			$this->User_ID = $user_ref_id;

			# Set Upload Path For Project
			$this->Data[P_UP] .= '/'.$this->User_ID;
			$this->Data[V_UP] .= '/'.$this->User_ID;
		}
    }*/
    public function IsUserExistOrNot($user_id)
    {
        if(!is_numeric($user_id))
            return false;

        $info = $this->getInfoById($user_id);

        if(isset($info) && is_array($info) && count($info) > 0 && $info[$this->Data[F_P_KEY]] == $user_id)
            return true;
        else
            return false;
    }
    public function CheckUserExistOrNotFromEmailAndName($POST)
    {
        if(!is_array($POST) || (is_array($POST) && count($POST) < 0))
            return false;

        $param = " ".$this->Data[FIELD_PREFIX]."email = ? AND LOWER(".$this->Data[F_P_FIELD].") = ? AND LOWER(".$this->Data[FIELD_PREFIX]."lastname) = ?";
        $value = array($POST['cust_email'],strtolower($POST['cust_bill_firstname']),strtolower($POST['cust_bill_lastname']));

        $info = $this->getInfoByParam($param,$value);

        if(isset($info) && is_array($info) && count($info) > 0)
            return $info[$this->Data[F_P_KEY]];
        else
            return false;
    }
    public function InsertUserInfoFromOrderData($POST)
    {
        if(!is_array($POST) || (is_array($POST) && count($POST) < 0))
            return false;

        # Set post for insert new user
        $post['tnc_pp']     = YES;
        $post['firstname']  = $POST['cust_bill_firstname'];
        $post['lastname']   = $POST['cust_bill_lastname'];
        $post['email']      = $POST['cust_email'];
        $post[LeadSource::obj()->Data[F_P_KEY]]= 1;
        $post['mobile']     = $POST['cust_bill_mobile'];
        $post['mobile_ccode']= $POST['cust_bill_mobile_ccode'];
        $post['type']       =   WEB_UTYPE_REGISTER;
        $post['send_welcome_email']   =   YES;
        $post['connect_using'] = SIGNUP_USING_WEBSITE;

        $this->populateSchema();

        $user_id = $this->WebUserSignUp($post);

        if(is_numeric($user_id))
        {
            #set post for user address book.
            $post[$this->Data[F_P_KEY]] =   $user_id;
            $post['firstname']          =   $POST['cust_bill_firstname'];
            $post['lastname']           =   $POST['cust_bill_lastname'];
            $post['mobile']             =   $POST['cust_bill_mobile'];
            $post['address']            =   $POST['cust_bill_address'];
            $post['zipcode']            =   $POST['cust_bill_zipcode'];
            $post['region']             =   $POST['cust_bill_region'];

            if(!is_numeric($POST['cust_bill_country_id']))
                $post['country_id'] = Ocrypt::dec($POST['cust_bill_country_id']);

            $post['state_id']   = (!is_numeric($POST['cust_bill_state_id']))?Ocrypt::dec($POST['cust_bill_state_id']):$POST['cust_bill_state_id'];
            $post['city_id']    = (!is_numeric($POST['cust_bill_city_id']))?Ocrypt::dec($POST['cust_bill_city_id']):$POST['cust_bill_city_id'];

            if((isset($POST['country_id']) && is_numeric($POST['country_id'])) && (isset($POST['state']) && !empty($POST['state'])) && (isset($POST['city']) && !empty($POST['city'])) )
			{
                $state_info = GeoState::obj()->NewStateChecking($POST['country_id'],$POST['state']);

                $city_info  = GeoCity::obj()->NewCityChecking($POST['country_id'],$state_info[GeoState::obj()->Data[F_P_KEY]],$POST['city']);

                $post['state_id']  = $state_info[GeoState::obj()->Data[F_P_KEY]];
                $post['state_id']   = $city_info[GeoCity::obj()->Data[F_P_KEY]];
            }
            $post['is_main']    = YES;

            UserAddressBook::obj()->populateschema();
            UserAddressBook::obj()->_Insert($post);

            return $user_id;
        }
        return false;
    }
    /*public function GetUserListForNewsletter($param, $start_record=false, $limiit=false)
    {
        # Set soime basic params to get users
        $POST['is_active']      =   YES;
        $POST['is_verified']    =   YES;
        $POST['is_deleted']     =   NO;
        $POST['is_subscribe_for_newsletter'] = YES;

        # Get seach quesy from givne parmatar
        $params = $this->getQueryParameters($POST);

        if(isset($params['sql']) && !empty($params['sql']))
            $addParameters = $params['sql'];

        # Set record limit to get
        if(is_numeric($start_record) && is_numeric($limiit))
            $Custom_Param[SQL_LIMIT]  =   " LIMIT ".$start_record.",".$limiit;

        # Set custom select
        $Custom_Param[F_B_SELECT] = "MTBL.".$this->Data[F_P_KEY].", MTBL.".$this->Data[F_P_FIELD].", MTBL.".$this->Data[FIELD_PREFIX]."lastname, MTBL.".$this->Data[FIELD_PREFIX]."email";

        return $this->getAll($addParameters, $params['value'], $Join=false, $Custom_Param);

    }*/
    public function UpdateUserInfoToActivateAccount($user_id,$POST)
    {
        $state_info = GeoState::obj()->NewStateChecking($POST['country_id'],$POST['state']);

        $city_info = GeoCity::obj()->NewCityChecking($POST['country_id'],$state_info[GeoState::obj()->Data[F_P_KEY]],$POST['city']);

        /*$field_sets = $this->Data[FIELD_PREFIX]."country_id = :country, ".$this->Data[FIELD_PREFIX]."state = :state , ".$this->Data[FIELD_PREFIX]."city = :city";
        $where_condition = $this->Data[F_P_KEY]." = :".$this->Data[F_P_KEY];

        $value[':country'] = $POST['country_id'];
        $value[':state'] = $state_info[GeoState::obj()->Data[F_P_KEY]];
        $value[':city'] = $city_info[GeoCity::obj()->Data[F_P_KEY]];
        $value[':'.$this->Data[F_P_KEY]] = $user_id;

        $id = parent::UpdateFieldByParam($field_sets , $where_condition, $value);*/
        $POST['state_id']           =   $state_info[GeoState::obj()->Data[F_P_KEY]];
        $POST['city_id']            =   $city_info[GeoCity::obj()->Data[F_P_KEY]];
        $POST[$this->Data[F_P_KEY]] =   $user_id;
        $POST['is_main']            =   YES;

        return UserAddressBook::obj()->_Insert($POST);
    }
    public function UpdateUserStatusByUserId($user_id)
    {
        $field_sets = $this->Data[FIELD_PREFIX]."is_verified = ?, ".$this->Data[F_ACTIVE]." = ?";
        $where_condition = $this->Data[F_P_KEY]." = ?";

        return parent::UpdateFieldByParam($field_sets , $where_condition, array(YES,YES,$user_id));
    }
    public function UpdateUserAddressDetails($POST, $user_id)
    {
        if(!is_numeric($user_id))
            return false;

        $field_sets         =   $this->Data[FIELD_PREFIX]."address = :address, ".$this->Data[FIELD_PREFIX]."zipcode = :zipcode , ".$this->Data[FIELD_PREFIX]."region = :region, ".$this->Data[FIELD_PREFIX]."city = :city, ".$this->Data[FIELD_PREFIX]."state = :state, ".$this->Data[FIELD_PREFIX]."country_id = :country_id";
        $where_condition    =   $this->Data[F_P_KEY]." = :".$this->Data[F_P_KEY];

        $value[':address']                  =   $POST['address'];
        $value[':zipcode']                  =   $POST['zipcode'];
        $value[':region']                   =   $POST['region'];
        $value[':city']                     =   $POST[GeoCity::obj()->Data[F_P_KEY]];
        $value[':state']                    =   $POST[GeoState::obj()->Data[F_P_KEY]];
        $value[':country_id']               =   $POST[GeoCountry::obj()->Data[F_P_KEY]];
        $value[':'.$this->Data[F_P_KEY]]    =   $user_id;

        return parent::UpdateFieldByParam($field_sets , $where_condition, $value);
    }
    public function getTodaysTotalRegisteredUser()
    {
       $F_CustomSelect  = " COUNT(*) As Total_Registered_User ";
       $param           = " DATE(".$this->Data[F_ADDED_DATETIME].") = ? ";
       $value           = array(date('Y-m-d'));
       return parent::getInfoByParam($param, $value, $F_CustomSelect);
    }
    public function getAllUserInfo()
    {
        $CustomParam[F_B_SELECT] = $this->Data[F_P_KEY].','.$this->Data[F_P_FIELD].','.$this->Data[FIELD_PREFIX].'lastname';

        $rs = parent::getAll(false,false,false,$CustomParam);

        if($rs->TotalRow > 0)
            return $rs->fetch_record();
        else
            return false;
    }
}
?>