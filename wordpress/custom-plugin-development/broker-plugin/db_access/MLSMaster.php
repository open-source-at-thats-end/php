<?php
#=============================================================================================================================
#	File Name		:	MLSMaster.php
#=============================================================================================================================
# Include data
//require_once(dirname(__FILE__) . '/MLSMasterData.php');

class MLSMaster extends CustomClass
{
    public static $Instance;

	public static function obj()
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self();

		return self::$Instance;
	}
    #=========================================================================================================================
	#	Function Name	:   MLSMasterData
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
		global $physical_path, $virtual_path, $asset, $config;

		# Initialize all default data

		# Table name
		$this->Data['TableName']			=	$config['Table_Prefix']. 'mls_master';
		$this->Data['GeoState']				=	$config['Table_Prefix']. 'geo_state';
		$this->Data['GeoCity']				=	$config['Table_Prefix']. 'geo_city';

		# Module title
		$this->Data['L_Module']				=	'MLS Market';

		# Help text
		$this->Data['H_Manage']				=	'Manage MLS information and data download configuration';
		$this->Data['H_AddEdit']			=	'Update MLS information and click <b>Save</b> to save the changes.
												Click <b>Cancel</b> to discard the changes.';
		# Command list
		if($_SESSION['SHOW_ADMIN_SETTING'])
			$this->Data['C_CommandList']		=	array(A_EDIT, A_VIEW, A_METADATA, A_MLSSETTING, A_APISETTING, A_MLSUTILITY, A_VISIBILITY, A_ADD);
		else
			$this->Data['C_CommandList']		=	array(A_EDIT, A_VIEW);

		# Primary field info
		$this->Data['F_PrimaryKey']			=	'mlsp_id';
		$this->Data['F_PrimaryField']		=	'mls_market_title';
		$this->Data['F_Visibility']			=	'mls_market_active';

		# Upload location
		$this->Data['P_Upload']				=	$physical_path['Upload']. '/mls';
		$this->Data['V_Upload']				=	$virtual_path['Upload']. '/mls';

		# Field information
		$this->Data['F_HeaderItem']				=
			array(
					'mls_market_name'			=>	array(	TITLE	=>	'Name',
															WIDTH	=>	'25%',
														),
					'mls_market_title'			=>	array(	TITLE	=>	'Provider',
															WIDTH	=>	'30%',
														),
					'mls_is_API'                =>	array(	TITLE	=>	'Is API?',
					                                            WIDTH	=>	'10%',
														),
					'mls_active'				=>	array(	TITLE	=>	'Provider Active?',
															WIDTH	=>	'10%',
														),
					/*'mls_market_active'			=>	array(	TITLE	=>	'Market Active?',
															WIDTH	=>	'10%',
														),*/
				);

		# Field information
		$this->Data['F_FieldInfo']				=
			array(
					'mls_MasterInfo'			=>	array(	GROUP_TITLE		=>	'MLS Information',
															LAYT_COLS		=>	4,
														),
					'mls_market_name'			=>	array(	TITLE			=>	'Name',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	50,
															CNT_MAXLEN		=>	50,
															COLS_SPAN		=>	true,
															VALIDATE		=>	true,
															VAL_TYPE		=>	V_EMPTY,
														),
					'mls_market_title'			=>	array(	TITLE			=>	'Provider',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	80,
															CNT_MAXLEN		=>	100,
															COLS_SPAN		=>	true,
															VALIDATE		=>	true,
															VAL_TYPE		=>	V_EMPTY,
														),

					'MarketArea'				=>	array(	GROUP_TITLE		=>	'RETS / FTP Access Details',
															LAYT_COLS		=>	4,
														),
					'mls_host'					=>	array(	TITLE			=>	'Host',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	50,
															CNT_MAXLEN		=>	255,
															COLS_SPAN		=>	true,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'mls_user'					=>	array(	TITLE			=>	'User',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	15,
															CNT_MAXLEN		=>	50,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'mls_passwd'				=>	array(	TITLE			=>	'Password',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	15,
															CNT_MAXLEN		=>	50,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'mls_rets_user_agent'		=>	array(	TITLE			=>	'User Agent',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'mls_rets_user_agent_pwd'=>	array(	TITLE			=>	'User Agent Password',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'mls_is_API'				=>	array(	TITLE			=>	'IS API? ',
					                                            OPTION			=>	$asset['OL_YesNo'],
					                                            CNT_TYPE		=>	C_COMBOBOX,
					),
					'mls_client_id'             =>	array(	TITLE			=>	'API Client ID',
					                                            CNT_TYPE		=>	C_TEXT,
					                                            CNT_SIZE		=>	50,
					                                            //CNT_MAXLEN		=>	50,
					                                            //VALIDATE		=>	true,
					                                            //VAL_TYPE		=>	V_EMPTY,
					),
					'mls_client_secret'         =>	array(	TITLE			=>	'API Client Secret',
					                                            CNT_TYPE		=>	C_TEXT,
					                                            CNT_SIZE		=>	50,
					                                            //VALIDATE		=>	true,
					                                            //VAL_TYPE		=>	V_EMPTY,
					),
					'mls_server_token'          =>	array(	TITLE			=>	'API Server Token',
					                                            CNT_TYPE		=>	C_TEXT,
					                                            CNT_SIZE		=>	50,
					                                            //VALIDATE		=>	true,
					                                            //VAL_TYPE		=>	V_EMPTY,
					),
					'mls_browser_token'         =>	array(	TITLE			=>	'API Browser Token',
					                                            CNT_TYPE		=>	C_TEXT,
					                                            CNT_SIZE		=>	50,
					                                            COLS_SPAN     =>  true,
					                                            //VALIDATE		=>	true,
					                                            //VAL_TYPE		=>	V_EMPTY,
					),
					'mls_rets_version'			=>	array(	TITLE			=>	'Version',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'mls_format'				=>	array(	TITLE			=>	'Format',
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	20,
															CNT_MAXLEN		=>	50,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'mls_active'				=>	array(	TITLE			=>	'Active? ',
															OPTION			=>	$asset['OL_YesNo'],
															CNT_TYPE		=>	C_COMBOBOX,
														),
					'mls_is_pic_url_supported'	=>	array(	TITLE			=>	'Is Picture Url Suppoerted ?',
															OPTION			=>	$asset['OL_YesNo'],
															CNT_TYPE		=>	C_COMBOBOX,
														),
					'MLSDisclaimer'				=>	array(	GROUP_TITLE		=>	'MLS Disclaimer',
															LAYT_COLS		=>	4,
															DESC			=>	'Shown with Free MLS Search listing and full view details',
														),
					/*'mls_disclaimer_icon'		=>	array(	TITLE			=>	'Icon Image',
														  	DESC			=>	'Shown with each listing information, Valid file format: '. str_replace("|", ", ", $config['valid_pic_format']),
															COLS_SPAN		=>	true,
															CNT_TYPE		=>	C_PICFILE,
															CNT_SIZE		=>	30,
															VALIDATE		=>	true,
															VAL_TYPE		=>	V_EXTENTION,
															VAL_EXT			=>	$config['valid_pic_format'],
															CREATE_THUMB	=> 	false,
														),
					'mls_disclaimer_short'		=> array (	TITLE 			=> 	'Disclaimer',
														  	DESC			=>	'Shown on property listing page',
															COLS_SPAN		=>	true,
															CNT_TYPE		=>	C_TEXT,
															CNT_SIZE		=>	100,
															VALIDATE		=>	true,
															VAL_TYPE		=>	V_MAXLEN,
															VAL_MAXLEN		=>	255,
														 ),*/
					'mls_disclaimer_big'		=>	array(	TITLE			=>	'Disclaimer',
														  	//DESC			=>	'Shown on property full detail page',
															COLS_SPAN		=>	true,
															CNT_TYPE		=>	C_TEXTAREA,
															CNT_ROW			=>	8,
															CNT_COLS		=>	120,
															//VALIDATE		=>	true,
															//VAL_TYPE		=>	V_EMPTY,
														),
					'JobSettings'				=>	array(	GROUP_TITLE		=>	'Job Settings',
															LAYT_COLS		=>	4,
														),
					'mls_prop_data_download'	=>	array(	TITLE			=>	'Listing Data Download',
															OPTION			=>	$asset['OL_JOB_DATA'],
															CNT_TYPE		=>	C_COMBOBOX,
														),
					'mls_agent_data_download'	=>	array(	TITLE			=>	'Agent Data Download',
															OPTION			=>	$asset['OL_JOB_DATA'],
															CNT_TYPE		=>	C_COMBOBOX,
														),
					'mls_office_data_download'	=>	array(	TITLE			=>	'Office Data Download',
															OPTION			=>	$asset['OL_JOB_DATA'],
															CNT_TYPE		=>	C_COMBOBOX,
														),
					'mls_pic_data_download'		=>	array(	TITLE			=>	'Listing Picture Download',
															OPTION			=>	$asset['OL_JOB_PIC'],
															CNT_TYPE		=>	C_COMBOBOX,
														),
				);

		# Intialize parent class
		parent::__construct();
	}
	#=========================================================================================================================
	#	Function Name		:	UpdateJobInfo
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateJobInfo($mlsp_id, $field_name, $field_value)
	{
		global $db;

		$sql = " UPDATE ". $this->Data['TableName']
			 . " SET ".$field_name."	= '". $field_value. "' "
			 . " WHERE mlsp_id 	= '". $mlsp_id. "' ";

		$db->query($sql);

		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   getLastIncrementedDate
	#-------------------------------------------------------------------------------------------------------------------------
	public function getLastIncrementedDate($mlsp_id, $field_name, $interval='1')
	{
		global $db;

		$sql =	" SELECT DATE_FORMAT(DATE_SUB(".$field_name.", INTERVAL ".$interval." DAY), '%Y-%m-%d %H:%i:%s') AS LastDate ".
				" FROM ". $this->Data['TableName'].
				" WHERE mlsp_id = '". $mlsp_id. "' ";

		# Show debug info
		if(DEBUG)
			parent::__debugMessage($sql);

		$rs = $db->query($sql);
		$rs->next_record();

		return ($rs->f('LastDate'));
	}

	#=========================================================================================================================
	#	Function Name	:   getInActiveRETS
	#-------------------------------------------------------------------------------------------------------------------------
	public function getInActiveMLS()
	{
		$rs = parent::getAll(" AND ".$this->Data['F_Visibility']." = 'No' ");

		$rsInfo = $rs->fetch_array();
		$retStr = "";
		foreach ($rsInfo as $key => $valArr)
			$retStr .= $valArr['mlsp_id']." , ";

		$retStr = substr($retStr,0,strlen($retStr)-2);

		return $retStr;
	}
	#=========================================================================================================================
	#	Function Name	:   getAllMLSDisclaimer
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAllMLSDisclaimer($mlsp_id='')
	{
		$params = '';

		$params .= " AND ".$this->Data['F_Visibility']." = 'Yes' ";

		if($mlsp_id)
			$params .= " AND mlsp_id IN('".str_replace(",", "','", $mlsp_id)."')";

		$rs = parent::getAll($params, 'mlsp_id, mls_disclaimer_big, mls_disclaimer_short, mls_disclaimer_icon');

		return $rs->fetch_array(MYSQLI_ASSOC, $this->Data['F_PrimaryKey']);
	}

	#=========================================================================================================================
	#	Function Name	:   getAllMLSDisclaimer
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAllMLSDisclaimerWithPic($mlsp_id='0')
	{
		$params = '';

		$params .= " AND ".$this->Data['F_Visibility']." = 'Yes' ";

		if($mlsp_id > 0)
			$params .= " AND mlsp_id IN('".str_replace(",", "','", $mlsp_id)."')";

		$rs = parent::getAll($params, 'mlsp_id, mls_disclaimer_short, mls_disclaimer_big, mls_disclaimer_icon');

		$arrData = $rs->fetch_array(MYSQLI_ASSOC, $this->Data['F_PrimaryKey']);

		foreach($arrData as $key => $val)
		{
			$arrData[$key]['icon_path'] = '/pictures/market/'.$key.'/';
		}

		return $arrData;
	}
	#=========================================================================================================================
	#	Function Name	:   getAllMLSDisclaimer
	#-------------------------------------------------------------------------------------------------------------------------
	public function getMLSDisclaimerById($mlsp_id)
	{
		return parent::getInfoById($mlsp_id, 'mlsp_id, mls_disclaimer_big, mls_disclaimer_icon');
	}

	#=========================================================================================================================
	#	Function Name	:   getAllForeclosureDisclaimer
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAllForeclosureDisclaimer()
	{
		$rs = parent::getAll(" AND ".$this->Data['F_Visibility']." = 'Yes' ", 'mlsp_id, mls_all_foreclosure_disc, mls_bank_foreclosure_disc, mls_pre_foreclosure_disc');

		return $rs->fetch_array(MYSQLI_ASSOC, $this->Data['F_PrimaryKey']);
	}

	#=========================================================================================================================
	#	Function Name	:   getMLSInfo
	#-------------------------------------------------------------------------------------------------------------------------
	public function getMLSInfo($mlsp_id)
	{
		global $db;

		$sql =	" SELECT *, GC.city_name, GS.state_code ".
				" FROM ". $this->Data['TableName']. ' AS MM '.
				"	LEFT JOIN ". $this->Data['GeoCity']. ' AS GC ON MM.mls_market_city = GC.city_id AND MM.mls_market_state = GC.city_state_id '.
				"	LEFT JOIN ". $this->Data['GeoState']. ' AS GS ON MM.mls_market_state = GS.state_id '.
				" WHERE mlsp_id = '". $mlsp_id. "' ";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}

	#=========================================================================================================================
	#	Function Name	:   getAllVisibleMarket
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAllVisibleMarket()
	{
		global $db;

		$sql =	" SELECT mlsp_id, mls_market_name, mls_market_active FROM ". $this->Data['TableName']. " AS MM ".
				" WHERE mls_market_active = 'Yes'".
				" ORDER BY mls_market_name ";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		return $db->query($sql);
	}

	#=========================================================================================================================
	#	Function Name	:   getAllMarketByState
	#	Use				:   Under foreclosure browse listing
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAllMarketByState($state)
	{
		global $db;

		$sql =	" SELECT  mlsp_id, mls_market_name FROM ". $this->Data['TableName']. " AS MM ".
				" WHERE mls_market_active = 'Yes'".
				"	AND mls_market_state = '". $state. "'".
				" ORDER BY mls_market_name ";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		return $db->query($sql);
	}

	#=========================================================================================================================
	#	Function Name	:   getMLSInfo
	#-------------------------------------------------------------------------------------------------------------------------
	public function getMarketKeyValueArray($All=false, $postfix='', $POST='')
	{
		global $db;

		$param = '';

		if(!$All)
			$param .= " AND mls_market_active = 'Yes'";

		if(isset($POST['State']) && $POST['State'] != '')
			$param .= " AND mls_market_state = '".$POST['State']."'";

		if(isset($POST['mlsp_id']) && $POST['mlsp_id'] != '')
		{
			$POST['mlsp_id'] = str_replace(",", "','", $POST['mlsp_id']);
			$param .= " AND mlsp_id IN('".$POST['mlsp_id']."')";
		}

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$param .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql =	" SELECT mlsp_id, mls_market_name, mls_market_active FROM ". $this->Data['TableName']. " AS MM ".
				" WHERE mls_market_name != '' ".$param."".
				" ORDER BY mls_market_name";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr 	= array();

		while($rs->next_record())
		{
			if($postfix)
				$arr[$rs->f('mlsp_id').'_'.$rs->f('mls_market_active')]  = $rs->f('mls_market_name');
			else
				$arr[$rs->f('mlsp_id')]  = $rs->f('mls_market_name');
		}

		return $arr;
	}

	#====================================================================================================
	#	Function Name	:   getStateKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getStateKeyValueArray()
    {
		global $db;

		$sql	= " SELECT DISTINCT(mls_market_state)"
				. " FROM ". $this->Data['TableName']
				. " WHERE mls_market_state != '' "
//				. "		AND mls_market_active = 'Yes' "
				. " ORDER BY mls_market_state";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('mls_market_state')]  = $rs->f('mls_market_state');
		}

		return ($arr);
	}

	#====================================================================================================
	#	Function Name	:   getInfoByMarketName
	#----------------------------------------------------------------------------------------------------
	public function getInfoByMarketName($name)
    {
		return parent::getInfoByParam(" mls_market_name = '". str_replace('-', ' ', $name). "'");
	}

	#====================================================================================================
	#	Function Name	:   getInfoByMarketName
	#----------------------------------------------------------------------------------------------------
	public function getMarketInfoById($mlsp_id)
	{
		$fields = 'mls_market_name';

		return parent::getInfoById($mlsp_id, $fields);
	}
}
?>