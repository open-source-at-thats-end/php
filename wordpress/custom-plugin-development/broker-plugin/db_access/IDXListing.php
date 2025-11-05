<?php
require_once(dirname(__FILE__) . '/CustomClass.php');
require_once(dirname(dirname(__FILE__)). "/libs/aws/aws-autoloader.php");

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\CredentialProvider;
#=============================================================================================================================
#	File Name		:	IDX.php
#=============================================================================================================================
## Remove space
if(!function_exists('TrimArray'))
{
	function TrimArray($Input)
	{
		return trim($Input);
	}
}

class IDXListing extends CustomClass
{

	public static $Instance;

	public static function obj($isPopulateSchema=false)
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self($isPopulateSchema);

		return self::$Instance;
	}
	#=========================================================================================================================
	#	Function Name	:   IDX
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
	public function __construct($isPopulateSchema=false)
	{

		global $physical_path, $virtual_path, $config,$arrConfig;

		//RETS Master Detail
		/*include_once($physical_path['DB_Access']. '/MLSMaster.php');
		$this->objMLSMaster = new MLSMaster();

		$this->picPath['InActive_MLS_ID']		= $this->objMLSMaster->getInActiveMLS();*/

		//print $this->picPath['InActive_MLS_ID'];exit;
		$this->picPath['MLS_Pic_Folder']		= array(
			"0"	=>	"other",
			"1" =>  "trestle",
			"2" =>  "actris",
		);

		# Table name
		$this->Data['Agent_Table']				=	$config['Table_Prefix']. 'listing_agent';
		$this->Data['Office_Table']				=	$config['Table_Prefix']. 'listing_office';
		$this->Data['Metadata_Table']			=	$config['Table_Prefix']. 'listing_metadata';

		$this->Data['TableName']				=	$config['Table_Prefix']. 'listing_master';
		$this->Data['Listing_Address']			=	$config['Table_Prefix']. 'listing_address';
		$this->Data['Listing_Additional_Info']	=	$config['Table_Prefix']. 'listing_additional_info';
		$this->Data['Statistic_Table']			=	$config['Table_Prefix']. 'listing_statistic';
		$this->Data['MLS_Open_House_Table'] 	= 	$config['Table_Prefix']. 'listing_open_house';
		$this->Data['MLS_Photo_Table'] 			= 	$config['Table_Prefix']. 'listing_photos';
		$this->Data['MLS_Virtual_Tour_Table'] 	= 	$config['Table_Prefix']. 'listing_virtual_tours';
		$this->Data['Listing_Price_Log']		=	$config['Table_Prefix']. 'listing_price_log';
		$this->Data['Listing_Deleted']          =   $config['Table_Prefix']. 'listing_deleted';
		$this->Data['Listing_Room_Info']		=	$config['Table_Prefix']. 'listing_room_info';
		$this->Data['UserFavoriteProperty']		=	$config['Table_Prefix']. 'user_favorite_property';

		$this->Data['MLS_Master']				=	$config['Table_Prefix']. 'mls_master';
		$this->Data['Listing_Unit_Info']		=	$config['Table_Prefix']. 'listing_unit_info';

		$this->Data['PriceWatch_Table']			=	$config['Table_Prefix']. 'listing_price_watch_list';

		$this->Data['Listing_School']			=	$config['Table_Prefix']. 'listing_schools';
		$this->Data['GeoState']					=	$config['Table_Prefix']. 'geo_state';

		$this->Data['TriggerSearchByMapsearch']=   $config['Table_Prefix']. 'trigger_search_by_mapsearch';

		# Field Information
		$this->Data['F_OfficeHeader']			=
			array(
				'Office_Name'				=>	array(	TITLE	=>	'Office Name',
				                                             WIDTH	=>	'35%',
				),
				'Office_City'				=>	array(	TITLE	=>	'City',
				                                             WIDTH	=>	'18%',
				),
				'Office_State'				=>	array(	TITLE	=>	'State',
				                                              WIDTH	=>	'10%',
				),
				'Office_Zip'				=>	array(	TITLE	=>	'Zip Code',
				                                            WIDTH	=>	'10%',
				),
				'Office_Phone'				=>	array(	TITLE	=>	'Phone',
				                                              WIDTH	=>	'20%',
				),
			);

		# Field information
		$this->Data['F_OfficeFieldInfo']				=
			array(
				'OfficeInformation'			=>	array(	GROUP_TITLE		=>	'Office Information'),
				'Office_Name'				=>	array(	TITLE			=>	'Name :',
				                                             CNT_TYPE		=>	C_TEXT,
				),
				'Office_Address1'			=>	array(	TITLE			=>	'Address 1 :',
				                                             CNT_TYPE		=>	C_TEXT,
				),
				'Office_Address2'			=>	array(	TITLE			=>	'Address 2 :',
				                                             CNT_TYPE		=>	C_TEXT,
				),
				'Office_City'				=>	array(	TITLE			=>	'City :',
				                                             CNT_TYPE		=>	C_TEXT,
				),
				'Office_State'				=>	array(	TITLE			=>	'State :',
				                                              CNT_TYPE		=>	C_TEXT,
				),
				'Office_Zip'				=>	array(	TITLE			=>	'Zip Code :',
				                                            CNT_TYPE		=>	C_TEXT,
				),
				'Office_Phone'				=>	array(	TITLE			=>	'Phone :',
				                                              CNT_TYPE		=>	C_TEXT,
				),
				'Office_Email'				=>	array(	TITLE			=>	'Email :',
				                                              CNT_TYPE		=>	C_TEXT,
				),
				'Office_Web'				=>	array(	TITLE			=>	'Web :',
				                                            CNT_TYPE		=>	C_TEXT,
				),
				'Office_Fax'				=>	array(	TITLE			=>	'Fax :',
				                                            CNT_TYPE		=>	C_TEXT,
				),
			);

		//        $this->Pic_Path						=	$virtual_path['MDN_Url'].'/pictures/property';
		//$this->Pic_Path						=	'http://CustomWpPlugin-api.project:'.$_SERVER['SERVER_PORT'].'/pictures/property';
		$this->Pic_Path						=	'https://CustomWpPlugincloud.com/pictures/property';
		//$this->Pic_Path						=	$virtual_path['Assets_Url'].'/pictures/property/';
		//$this->Pic_Path				=	$arrConfig['pic_path'];

		$this->Pic_Path_Trestle		=	S3_BUCKET_URL.'/'.S3_BUCKET_FOLDER_TRESTLE;
		$this->Pic_Path_Actris		=	S3_BUCKET_URL.'/'.S3_BUCKET_FOLDER_ACTRIS;

		//echo '<pre>';print_r($this->Pic_Path);exit();

		# Include Module Data
		if($isPopulateSchema) $this->populateSchema();

		# Intialize parent class
		parent::__construct();

	}

	public function populateSchema()
	{

		global $physical_path, $config;

		$arrMetadataValue = Metadata::obj()->getAllMetadataValue();
		$arrOfficeParam['ActiveOfficeFlag'] = true;

		# Field information
		$this->Data['F_FieldInfo']				=
			array(
				'GeneralInformation'		=>	array(	GROUP_TITLE		=>	'General'),
				'MainPicData'				=>	array(	TITLE			=>	'Main Picture',
				                                             CNT_TYPE		=>	C_PICFILE,
				                                             CNT_MAXLEN		=>	255,
				                                             DESC			=>	"Valid Picture Format: ". $config['valid_pic_format'],
				                                             CREATE_THUMB	=>	false,
				                                             VALIDATE		=>	true,
				                                             VAL_TYPE		=>	V_EXTENTION,
				                                             VAL_EXT			=>	$config['valid_pic_format'],
				),
				'ListingID'					=>	array(	TITLE			=>	'Listing ID',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               CNT_SIZE		=>	20,
				                                               CNT_MAXLEN		=>	20,
				                                               TABLE_PK_ID		=>	true,
				                                               CNT_READONLY	=>  true,
				),
				'Agent_ID'					=>	array(	TITLE			=>	'Agent',
				                                              CNT_TYPE		=>	C_COMBOBOX,
				                                              IS_NUMBER		=>  true,
				                                              OPTION			=>	$this->getAgentKeyValueArray(),
				                                              DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'OfficeID'					=>	array(	TITLE			=>	'Office',
				                                              CNT_TYPE		=>	C_COMBOBOX,
				                                              IS_NUMBER		=>  true,
				                                              OPTION			=>	$this->getOfficeKeyValueArray($arrOfficeParam),
				                                              DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'PropertyType'				=>	array(	TITLE			=>	'Property Type',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              VALIDATE		=>	true,
				                                              VAL_TYPE		=>	V_EMPTY,
				                                              CNT_SIZE		=>	30,
				                                              CNT_MAXLEN		=>	25,
				),
				'PropertyStyle'				=>	array(	TITLE			=>	'Property Style',
				                                               CNT_TYPE		=>	C_CHECKBOX,
				                                               CNT_COL			=>  3,
				                                               OPTION			=>	$arrMetadataValue['PropertyStyle'],
				                                               CONV_STR		=>	true,
				),
				'SubType'					=>	array(	TITLE			=>	'Sub Type',
				                                             CNT_TYPE		=>	C_COMBOBOX,
				                                             OPTION			=>	$arrMetadataValue['SubType'],
				                                             DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'ListType'					=>	array(	TITLE			=>	'List Type',
				                                              CNT_TYPE		=>	C_COMBOBOX,
				                                              OPTION			=>	$arrMetadataValue['ListType'],
				                                              DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'RentalType'				=>	array(	TITLE			=>	'Rental Type',
				                                            CNT_TYPE		=>	C_COMBOBOX,
				                                            OPTION			=>	$arrMetadataValue['RentalType'],
				                                            DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'BusinessType'				=>	array(	TITLE			=>	'Business Type',
				                                              CNT_TYPE		=>	C_CHECKBOX,
				                                              CNT_COL			=>  3,
				                                              OPTION			=>	$arrMetadataValue['BusinessType'],
				                                              CONV_STR		=>	true,
				),
				'SubBusinessType'			=>	array(	TITLE			=>	'Sub Business Type',
				                                             CNT_TYPE		=>	C_TEXT,
				                                             CNT_SIZE		=>	50,
				                                             CNT_MAXLEN		=>	25,
				),
				'BathsFull'					=>	array(	TITLE			=>	'Baths Full',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               IS_NUMBER		=>  true,
				                                               CNT_SIZE		=>	15,
				                                               CNT_MAXLEN		=>	3,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_INT,
				),
				'BathsHalf'					=>	array(	TITLE			=>	'Baths Half',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               IS_NUMBER		=>  true,
				                                               CNT_SIZE		=>	3,
				                                               CNT_MAXLEN		=>	15,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_INT,
				),
				'Beds'						=>	array(	TITLE			=>	'Beds',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              IS_NUMBER		=>  true,
				                                              CNT_SIZE		=>	3,
				                                              CNT_MAXLEN		=>	15,
				                                              VALIDATE		=>	true,
				                                              VAL_TYPE		=>	V_INT,
				),
				'Acres'						=>	array(	TITLE			=>	'Acres',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               IS_NUMBER		=>  true,
				                                               CNT_SIZE		=>	30,
				                                               CNT_MAXLEN		=>	100,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_FLOAT,
				),
				'ListPrice'					=>	array(	TITLE			=>	'List Price',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               IS_NUMBER		=>  true,
				                                               CNT_SIZE		=>	30,
				                                               CNT_MAXLEN		=>	10,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_INT,
				),
				'ListPriceOriginal'			=>	array(	TITLE			=>	'List Price Original',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               IS_NUMBER		=>  true,
				                                               CNT_SIZE		=>	30,
				                                               CNT_MAXLEN		=>	11,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_INT,
				),
				'SQFT'					=>	array(	TITLE			=>	'SQFT Total',
				                                          CNT_TYPE		=>	C_TEXT,
				                                          IS_NUMBER		=>  true,
				                                          CNT_SIZE		=>	10,
				                                          CNT_MAXLEN		=>	20,
				                                          VALIDATE		=>	true,
				                                          VAL_TYPE		=>	V_FLOAT,
				),
				'SQFTLand'					=>	array(	TITLE			=>	'SQFT Land',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              IS_NUMBER		=>  true,
				                                              CNT_SIZE		=>	10,
				                                              CNT_MAXLEN		=>	20,
				                                              VALIDATE		=>	true,
				                                              VAL_TYPE		=>	V_FLOAT,
				),
				'YearBuilt'					=>	array(	TITLE			=>	'Year Built',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               CNT_SIZE		=>	10,
				                                               CNT_MAXLEN		=>	4,
				),
				'LocationInformation'		=>	array(	GROUP_TITLE		=>	'Location'),
				'StreetNumber'				=>	array(	TITLE			=>	'Street Number',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              CNT_SIZE		=>	20,
				                                              CNT_MAXLEN		=>	8,
				                                              TABLE_NAME		=>  $this->Data['Sub_TableName'],
				),
				'StreetName'				=>	array(	TITLE			=>	'Street Name',
				                                            CNT_TYPE		=>	C_TEXT,
				                                            CNT_SIZE		=>	50,
				                                            CNT_MAXLEN		=>	25,
				                                            VALIDATE		=>	true,
				                                            VAL_TYPE		=>	V_EMPTY,
				                                            TABLE_NAME		=>  $this->Data['Sub_TableName'],
				),
				'StreetDirection'			=>	array(	TITLE			=>	'Street Direction',
				                                             CNT_TYPE		=>	C_COMBOBOX,
				                                             OPTION			=>	$arrMetadataValue['StreetDirection'],
				                                             DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				                                             TABLE_NAME		=>  $this->Data['Sub_TableName'],
				),
				'ZipCode'					=>	array(	TITLE			=>	'Zip Code',
				                                             CNT_TYPE		=>	C_TEXT,
				                                             CNT_SIZE		=>	20,
				                                             CNT_MAXLEN		=>	10,
				                                             TABLE_NAME		=>  $this->Data['Sub_TableName'],
				),
				'CityName'					=>	array(	TITLE			=>	'City Name',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              CNT_SIZE		=>	50,
				                                              CNT_MAXLEN		=>	25,
				                                              VALIDATE		=>	true,
				                                              VAL_TYPE		=>	V_EMPTY,
				                                              TABLE_NAME		=>  $this->Data['Sub_TableName'],
				),
				'State'						=>	array(	TITLE			=>	'State',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               CNT_SIZE		=>	20,
				                                               CNT_MAXLEN		=>	2,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_EMPTY,
				                                               TABLE_NAME		=>  $this->Data['Sub_TableName'],
				),
				'Location'					=>	array(	TITLE			=>	'Location',
				                                              OPTION			=>	$arrMetadataValue['Location'],
				                                              CNT_TYPE		=>	C_CHECKBOX,
				                                              CNT_COL			=>  3,
				                                              TABLE_NAME		=>  $this->Data['Sub_TableName'],
				                                              CONV_STR		=>	true,
				),
				'Neighborhood'				=>	array(	TITLE			=>	'Neighborhood',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              CNT_SIZE		=>	50,
				                                              CNT_MAXLEN		=>	255,
				                                              TABLE_NAME		=>  $this->Data['Sub_TableName'],
				),
				'Latitude'					=>	array(	TITLE			=>	'Latitude',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              IS_NUMBER		=>	true,
				                                              CNT_SIZE		=>	30,
				                                              CNT_MAXLEN		=>	35,
				                                              TABLE_NAME		=>  $this->Data['Sub_TableName'],
				                                              VALIDATE		=>	true,
				                                              VAL_TYPE		=>	V_FLOAT,
				),
				'Longitude'					=>	array(	TITLE			=>	'Longitude',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               IS_NUMBER		=>	true,
				                                               CNT_SIZE		=>	30,
				                                               CNT_MAXLEN		=>	35,
				                                               TABLE_NAME		=>  $this->Data['Sub_TableName'],
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_FLOAT,
				),
				'ListingFeatureInformation'	=>	array(	GROUP_TITLE		=>	'Listing Info.'),
				'UnitNo'					=>	array(	TITLE			=>	'Unit No',
				                                            CNT_TYPE		=>	C_TEXT,
				                                            CNT_SIZE		=>	30,
				                                            CNT_MAXLEN		=>	25,
				),
				'ListingDate'				=>	array(	TITLE			=>	'Listing Date',
				                                             CNT_TYPE		=>	C_DATEPICKER,
				                                             CNT_SIZE		=>	50,
				                                             CNT_MAXLEN		=>	20,
				),
				'PhotoDate'					=>	array(	TITLE			=>	'Photo Date',
				                                               CNT_TYPE		=>	C_DATEPICKER,
				                                               CNT_SIZE		=>	50,
				                                               CNT_MAXLEN		=>	20,
				),
				'Disclosures'				=>	array(	TITLE			=>	'Disclosures',
				                                             OPTION			=>	$arrMetadataValue['Disclosures'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'Region'					=>	array(	TITLE			=>	'Region',
				                                            CNT_TYPE		=>	C_COMBOBOX,
				                                            OPTION			=>	$arrMetadataValue['Region'],
				                                            DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'Parking'				=>	array(	TITLE			=>	'Number of Parking',
				                                         CNT_TYPE		=>	C_TEXT,
				                                         IS_NUMBER		=>	true,
				                                         CNT_SIZE		=>	30,
				                                         CNT_MAXLEN		=>	11,
				                                         VALIDATE		=>	true,
				                                         VAL_TYPE		=>	V_INT,
				),
				'Furnished'					=>	array(	TITLE			=>	'Furnished',
				                                               CNT_TYPE		=>	C_COMBOBOX,
				                                               OPTION			=>	$arrMetadataValue['Furnished'],
				                                               DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'Roofing'					=>	array(	TITLE			=>	'Roofing',
				                                             OPTION			=>	$arrMetadataValue['Roofing'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'RoadFrontage'				=>	array(	TITLE			=>	'Road Frontage',
				                                              OPTION			=>	$arrMetadataValue['RoadFrontage'],
				                                              CNT_TYPE		=>	C_CHECKBOX,
				                                              CNT_COL			=>  3,
				                                              CONV_STR		=>	true,
				),
				'PropertyFrontage'			=>	array(	TITLE			=>	'Property Frontage',
				                                              OPTION			=>	$arrMetadataValue['PropertyFrontage'],
				                                              CNT_TYPE		=>	C_CHECKBOX,
				                                              CNT_COL			=>  3,
				                                              CONV_STR		=>	true,
				),
				'ExpensesInclude'			=>	array(	TITLE			=>	'Expenses Include',
				                                             OPTION			=>	$arrMetadataValue['ExpensesInclude'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'GarageArea'				=>	array(	TITLE			=>	'Garage Area',
				                                            CNT_TYPE		=>	C_TEXT,
				                                            IS_NUMBER		=>  true,
				                                            CNT_SIZE		=>	30,
				                                            CNT_MAXLEN		=>	10,
				                                            VALIDATE		=>	true,
				                                            VAL_TYPE		=>	V_INT,
				),
				'Zoning'					=>	array(	TITLE			=>	'Zoning',
				                                            CNT_TYPE		=>	C_COMBOBOX,
				                                            OPTION			=>	$arrMetadataValue['Zoning'],
				                                            DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'Showing'					=>	array(	TITLE			=>	'Showing',
				                                             OPTION			=>	$arrMetadataValue['Showing'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'Pool'						=>	array(	TITLE			=>	'Pool',
				                                              OPTION			=>	$arrMetadataValue['Pool'],
				                                              CNT_TYPE		=>	C_CHECKBOX,
				                                              CNT_COL			=>  3,
				                                              CONV_STR		=>	true,
				),
				'FloorCovering'				=>	array(	TITLE			=>	'FloorCovering',
				                                               OPTION			=>	$arrMetadataValue['FloorCovering'],
				                                               CNT_TYPE		=>	C_CHECKBOX,
				                                               CNT_COL			=>  3,
				                                               CONV_STR		=>	true,
				),
				'PetsYN'					=>	array(	TITLE			=>	'Pets?',
				                                            CNT_TYPE		=>	C_COMBOBOX,
				                                            OPTION			=>	array('Y' => 'Yes', 'N' => 'No'),
				),
				'Stories'					=>	array(	TITLE			=>	'Stories',
				                                             CNT_TYPE		=>	C_TEXT,
				                                             CNT_SIZE		=>	50,
				                                             CNT_MAXLEN		=>	255,
				),
				'Occupancy'					=>	array(	TITLE			=>	'Occupancy',
				                                               OPTION			=>	$arrMetadataValue['Occupancy'],
				                                               CNT_TYPE		=>	C_CHECKBOX,
				                                               CNT_COL			=>  3,
				                                               CONV_STR		=>	true,
				),
				'DescriptionInformation'	=>	array(	GROUP_TITLE		=>	'Description'),
				'Amenities'					=>	array(	TITLE			=>	'Amenities',
				                                               OPTION			=>	$arrMetadataValue['Amenities'],
				                                               CNT_TYPE		=>	C_CHECKBOX,
				                                               CNT_COL			=>  3,
				                                               CONV_STR		=>	true,
				),
				'Parking'					=>	array(	TITLE			=>	'Parking',
				                                             OPTION			=>	$arrMetadataValue['Parking'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'Utilities'					=>	array(	TITLE			=>	'Utilities',
				                                               OPTION			=>	$arrMetadataValue['Utilities'],
				                                               CNT_TYPE		=>	C_CHECKBOX,
				                                               CNT_COL			=>  3,
				                                               CONV_STR		=>	true,
				),
				'UnitFeatures'				=>	array(	TITLE			=>	'Unit Features',
				                                              OPTION			=>	$arrMetadataValue['UnitFeatures'],
				                                              CNT_TYPE		=>	C_CHECKBOX,
				                                              CNT_COL			=>  3,
				                                              CONV_STR		=>	true,
				),
				'AdditionalRooms'			=>	array(	TITLE			=>	'Additional Rooms',
				                                             OPTION			=>	$arrMetadataValue['AdditionalRooms'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'CommunityAssociation'		=>	array(	TITLE			=>	'Community Association',
				                                              CNT_TYPE		=>	C_TEXT,
				                                              CNT_SIZE		=>	50,
				                                              CNT_MAXLEN		=>	100,
				),
				'LotsDescription'			=>	array(	TITLE			=>	'Lots Description',
				                                             OPTION			=>	$arrMetadataValue['LotsDescription'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'DivisionDesc'				=>	array(	TITLE			=>	'Division Description',
				                                              CNT_TYPE		=>	C_COMBOBOX,
				                                              OPTION			=>	$arrMetadataValue['DivisionDesc'],
				                                              DEF_OPTION		=>	array('value' => '', 'text' => 'Select'),
				),
				'BuildingUse'				=>	array(	TITLE			=>	'Building Use',
				                                             OPTION			=>	$arrMetadataValue['BuildingUse'],
				                                             CNT_TYPE		=>	C_CHECKBOX,
				                                             CNT_COL			=>  3,
				                                             CONV_STR		=>	true,
				),
				'PublicRemarks'				=>	array(	TITLE			=>	'Public Remarks ',
				                                               DESC			=>	'<font color="#FF0000">* * Maximum 255 characters</font>',
				                                               CNT_TYPE		=>	C_TEXTAREA,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_LEN|V_MAX,
				                                               VAL_MAX			=>	'255',
				                                               VAL_MSG			=>	'Maximum 255 characters allowed!!',
				),

				'SellerRemarks'				=>	array(	TITLE			=>	'SellerRemarks ',
				                                               DESC			=>	'<font color="#FF0000">* * Maximum 255 characters</font>',
				                                               CNT_TYPE		=>	C_TEXTAREA,
				                                               VALIDATE		=>	true,
				                                               VAL_TYPE		=>	V_LEN|V_MAX,
				                                               VAL_MAX			=>	'255',
				                                               VAL_MSG			=>	'Maximum 255 characters allowed!!',
				),
				'ShowingRemarks'			=>	array(	TITLE			=>	'Showing Remarks ',
				                                            DESC			=>	'<font color="#FF0000">* * Maximum 255 characters</font>',
				                                            CNT_TYPE		=>	C_TEXTAREA,
				                                            VALIDATE		=>	true,
				                                            VAL_TYPE		=>	V_LEN|V_MAX,
				                                            VAL_MAX			=>	'255',
				                                            VAL_MSG			=>	'Maximum 255 characters allowed!!',
				),
				'listing_description'		=>	array(	TITLE			=>	'Description ',
				                                             DESC			=>	'<font color="#FF0000">* * Maximum 255 characters</font>',
				                                             CNT_TYPE		=>	C_TEXTAREA,
				                                             VALIDATE		=>	true,
				                                             VAL_TYPE		=>	V_LEN|V_MAX,
				                                             VAL_MAX			=>	'255',
				                                             VAL_MSG			=>	'Maximum 255 characters allowed!!',
				),
				'listing_extra_features'	=>	array(	TITLE			=>	'Extra Features ',
				                                            DESC			=>	'<font color="#FF0000">* * Maximum 255 characters</font>',
				                                            CNT_TYPE		=>	C_TEXTAREA,
				                                            VALIDATE		=>	true,
				                                            VAL_TYPE		=>	V_LEN|V_MAX,
				                                            VAL_MAX			=>	'255',
				                                            VAL_MSG			=>	'Maximum 255 characters allowed!!',
				),
				'SchoolInfo'				=>	array(	GROUP_TITLE		=>	'School'),
				'Elementary_School'			=>	array(	TITLE			=>	'Elementary School',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               CNT_SIZE		=>	50,
				                                               CNT_MAXLEN		=>	25,
				),
				'High_School'				=>	array(	TITLE			=>	'High School',
				                                             CNT_TYPE		=>	C_TEXT,
				                                             CNT_SIZE		=>	50,
				                                             CNT_MAXLEN		=>	25,
				),
				'Middle_School'				=>	array(	TITLE			=>	'Middle School',
				                                               CNT_TYPE		=>	C_TEXT,
				                                               CNT_SIZE		=>	50,
				                                               CNT_MAXLEN		=>	25,
				),
				'listing_user_auth_id'		=>	array(	CNT_TYPE		=>	C_HIDDEN,
				),
				'Show_Listing_Flag'			=>	array(	CNT_TYPE		=>	C_HIDDEN,
				),
			);

	}
	#=========================================================================================================================
	#	Function Name	:   getQueryParameters
	#-------------------------------------------------------------------------------------------------------------------------
	public function getQueryParameters($POST)
	{
	    //echo '<pre>';print_r($POST);exit();
		global $config, $asset;

		$Parameters	 =	''; $agent_param = array();

		if(isset($POST['kword']) && trim($POST['kword']) != '')
		{

			$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['kword'], $keywords);

			$kword = explode(',',$POST['kword']);

			$searchFields = array();

			$searchFields[] = 'Description';
			$searchFields[] = 'ExteriorFeatures';
			$searchFields[] = 'BuildingFeatures';
			$searchFields[] = 'PoolDesc';
			$searchFields[] = 'PropertyStyle';
			$searchFields[] = 'Construction';
			$searchFields[] = 'Sewer';
			$searchFields[] = 'Water';
			$searchFields[] = 'Zoning';
			$searchFields[] = 'Legal';
			$searchFields[] = 'FireplaceFeatures';
			$searchFields[] = 'Amenities';
			$searchFields[] = 'Cooling';
			$searchFields[] = 'Appliances';
			$searchFields[] = 'Flooring';
			$searchFields[] = 'Heating';
			$searchFields[] = 'InteriorFeatures';
			$searchFields[] = 'Roof';
			$searchFields[] = 'SpaFeatures';
			$searchFields[] = 'CommunityFeatures';
			$searchFields[] = 'ParkingFeatures';
			//$searchFields[] = 'SystemName';

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

		## Quick Search
		if(isset($POST['kword']) && isset($POST['quicksearch'])&& trim($POST['quicksearch']) != '')
		{
			$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['quicksearch'], $keywords);

			$searchFields = array();
			$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetName';
			$searchFields[] = 'Address';

			$fieldsToSearch = implode(", ", $searchFields);

			$arrMlsNum = array();
			$arrAddKeyword = array();
			$arrParams = array();
			for($i=0; $i<count($keywords[0]); $i++)
			{
				$word = $keywords[0][$i];

				array_push($arrAddKeyword, $word);
			}

			if(count($arrAddKeyword) > 0)
			{
				// Street
				$strSearch = " CONCAT_WS(' ',". $fieldsToSearch. ") LIKE '%". implode(" ", $arrAddKeyword). "%' ";
				array_push($arrParams, $strSearch);

				// City Name
				$condition 	 = implode("%' OR CityName LIKE '%", $arrAddKeyword);
				$strSearch	 =	" ( CityName LIKE '%". $condition. "%' ) ";

				array_push($arrParams, $strSearch);
			}

			if(count($arrParams) > 0)
				$Parameters	 .=	" AND (".implode(" OR ", $arrParams).")";
		}

		## Address + Mls num Search
		if(isset($POST['add']) && $POST['add'] != '')
		{

			if(is_array($POST['add']) && count($POST['add']) > 0)
			{
				$address = $POST['add'];
			}
			else{
				$address = explode(',', $POST['add']);
			}

			$temp = array();
			foreach($address as $Key=>$val){

				$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['add'], $keywords);

				$arrKeyword = str_replace(', ',' ', $val);

				if($ret == '2')
				{
					$searchFields = array();
					$searchFields[] = 'StreetNumber';
					$searchFields[] = 'StreetName';
					$searchFields[] = 'Address';

					$fieldsToSearch = implode(", ", $searchFields);

					$temp[] = " CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$arrKeyword."%'";
				}
				elseif($ret == '3')
				{
					$searchFields = array();
					$searchFields[] = 'StreetNumber';
					$searchFields[] = 'StreetName';
					$searchFields[] = 'StreetSuffix';
					$searchFields[] = 'Address';

					$fieldsToSearch = implode(", ", $searchFields);

					$temp[] = " (CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$arrKeyword."%' OR CONCAT_WS(' ',StreetNumber, StreetName) LIKE '%".$arrKeyword."%')";

				}
				else
				{

					$searchFields = array();
					$searchFields[] = 'StreetNumber';
					$searchFields[] = 'StreetDirection';
					$searchFields[] = 'StreetName';
					$searchFields[] = 'StreetSuffix';
					$searchFields[] = 'Address';
					$fieldsToSearch = implode(", ", $searchFields);

					$temp[] = " (CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$arrKeyword."%' OR CONCAT_WS(' ',StreetNumber, StreetName, StreetSuffix,Address) LIKE '%".$arrKeyword."%')";

				}

			}
			$temp_q = implode(' OR ',$temp);
			$Parameters .=  " AND (".$temp_q.")";
		}

		if((isset($POST['addtype']) && $POST['addtype'] != '' && $POST['addtype'] != 'all' && $POST['addval']!=''))
		{
			if($POST['addtype'] == ASTYPE_ADD)
			{
				$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['addval'], $keywords);

				$arrKeyword = str_replace(', ',' ', $POST['addval']);
				//				echo $arrKeyword;exit;
				if($ret == '2')
				{
					$searchFields = array();
					$searchFields[] = 'CityName';
					$searchFields[] = 'State';

					$fieldsToSearch = implode(", ", $searchFields);

					$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";
				}
				elseif($ret == '3')
				{
					$searchFields = array();
					$searchFields[] = 'StreetNumber';
					$searchFields[] = 'StreetName';
					$searchFields[] = 'StreetSuffix';

					$fieldsToSearch = implode(", ", $searchFields);

					$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";

				}
				elseif($ret == '4')
				{
					$searchFields = array();

					$searchFields[] = 'StreetNumber';
					$searchFields[] = 'StreetDirection';
					$searchFields[] = 'StreetName';
					$searchFields[] = 'StreetSuffix';

					$fieldsToSearch = implode(", ", $searchFields);

					$Parameters .= " AND (CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."' OR CONCAT_WS(' ',StreetNumber,StreetName,StreetSuffix) LIKE '".$arrKeyword."')";

				}
				else
				{
					$searchFields = array();
					$searchFields[] = 'Address';
					$searchFields[] = 'CityName';
					$searchFields[] = 'State';

					$fieldsToSearch = implode(", ", $searchFields);

					$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";
				}
			}
			elseif($POST['addtype'] == ASTYPE_AREA && (!isset($POST['poly']) || empty($POST['poly'])))
			{
				$Parameters .= " AND (Area LIKE '".$POST['addval']."')";
			}
			elseif($POST['addtype'] == ASTYPE_SUB && (!isset($POST['poly']) ||  empty($POST['poly'])))
			{
				$Parameters .= " AND FIND_IN_SET('".addslashes($POST['addval'])."',Subdivision) ";
			}
			elseif($POST['addtype'] == ASTYPE_CITYSTATE && (!isset($POST['poly']) ||  empty($POST['poly'])))
			{
				$arrKeyword = str_replace(', ',' ', $POST['addval']);
				$searchFields = array();
				$searchFields[] = 'CityName';
				$searchFields[] = 'State';

				$fieldsToSearch = implode(", ", $searchFields);

				$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";
			}
			elseif($POST['addtype'] == ASTYPE_CITY)
			{
				$Parameters	 .=	" AND ( CityName LIKE '".$POST['addval']."' ) ";
			}
			elseif($POST['addtype'] == ASTYPE_ZIP)
			{
				$Parameters	 .=	" AND ( ZipCode LIKE '".$POST['addval']."' ) ";
			}
			elseif($POST['addtype'] == ASTYPE_MLS)
			{
				$Parameters	 .=	" AND ( M.MLS_NUM LIKE '".$POST['addval']."' ) ";
			}
			elseif($POST['addtype'] == ASTYPE_COUNTY)
			{
				$arrKeyword = str_replace(', ',' ', $POST['addval']);

				$searchFields = array();
				$searchFields[] = 'County';
				$searchFields[] = 'State';

				$fieldsToSearch = implode(", ", $searchFields);

				$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$arrKeyword."%'";
			}
			elseif($POST['addtype'] == ASTYPE_SCHOOL)
			{
				$searchFields = array();
				$searchFields[] = 'Elementary_School';
				$searchFields[] = 'High_School';
				$searchFields[] = 'Middle_School';

				$fieldsToSearch = implode(", ", $searchFields);
				$Parameters .=  " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$POST['addval']."%'";
			}
		}
		# Address type is empty when value is not selected from dropdown

		if(isset($POST['addval']) && is_array($POST['addval']) && count($POST['addval']) > 0 && ($POST['addtype'] == 'all' || !isset($POST['addtype'])))
		{

			$searchFields = array();
			$searchFields[] = 'UnitNo';
			$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetDirection';
			$searchFields[] = 'StreetDirPrefix';
			$searchFields[] = 'StreetName';
			$searchFields[] = 'StreetSuffix';
			$searchFields[] = 'StreetSuffix_Short_code';
			$searchFields[] = 'StreetDirSuffix';
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';
			$searchFields[] = 'StateName';
			$searchFields[] = 'ZipCode';

			$fieldsToSearch = implode(", ", $searchFields);


			foreach($POST['addval'] as $key => $info)
			{
				if(!empty($info))
				{
					$info = preg_replace('/\bpv\b/i', 'paradise valley', $info);
					$find_d = array('/\beast\b/i', '/\bwest\b/i', '/\bnorth\b/i', '/\bsouth\b/i');
					$replace_d = array('E','W', 'N', 'S');
					$info = preg_replace($find_d, $replace_d, $info);
					$arrKeyword = preg_replace("/[^a-zA-Z0-9-\/#&]/"," ",$info);
					$Keyword = trim($arrKeyword);

					$arr_Parameters[] = " CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".str_replace(' ','%',$Keyword)."%'";

				}
			}

			if(is_array($arr_Parameters))
			{
				$Parameters .= " AND ( ";

				$Parameters .= implode(" OR ",$arr_Parameters);

				$Parameters .= " ) ";
			}

			/*$MLS_Keyword = implode("', '",$POST['addval']);
            $Parameters .= " OR ( M.MLS_NUM IN ('".$MLS_Keyword."') ) ";*/

		}
		elseif(isset($POST['addval']) && $POST['addval'] != '' && ((isset($POST['addtype'] ) && $POST['addtype'] == 'all') || !isset($POST['addtype'])))
		{  // file_put_contents('lptPost.txt',print_r($POST,true));
			$POST['addval'] = preg_replace('/\bpv\b/i', 'paradise valley', $POST['addval']);
			$find_d = array('/\beast\b/i', '/\bwest\b/i', '/\bnorth\b/i', '/\bsouth\b/i');
			$replace_d = array('E','W', 'N', 'S');
			$POST['addval'] = preg_replace($find_d, $replace_d, $POST['addval']);
			$arrKeyword = preg_replace("/[^a-zA-Z0-9-\/#&]/"," ",$POST['addval']);

			$Keyword = trim($arrKeyword);
			$Parameters.= " AND (";

			$searchFields = array();
			$searchFields[] = 'UnitNo';
			$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetDirection';
			$searchFields[] = 'StreetName';
			$searchFields[] = 'StreetSuffix';
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';
			$searchFields[] = 'ZipCode';

			$fieldsToSearch = implode(", ", $searchFields);
            //file_put_contents('lptPost3.txt',print_r($fieldsToSearch,true));
			$Parameters .= " CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".str_replace(' ','%',$Keyword)."%'";
			//$Parameters .= " CONCAT_WS(' ',". $fieldsToSearch.") IN ( '%".implode(' ','%',$Keyword)."%'";


			$searchFields = array();
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';
			$fieldsToSearch = implode(", ", $searchFields);
			$Parameters .= " OR CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".str_replace(' ','%',$Keyword)."%'";

			$Parameters .= " OR ( ZipCode LIKE '%".$Keyword."%' )";
			$Parameters .= " OR FIND_IN_SET('".addslashes($Keyword)."',Subdivision)";

			/*$MLS_Keyword = str_replace("MLS# ",'',$arrKeyword);
            $Parameters .= " OR ( M.MLS_NUM LIKE '".$MLS_Keyword."'  ) ";*/

            $MLS_Keyword = str_replace(",","','",$POST['addval']);
            $Parameters .= " OR ( M.MLS_NUM IN ('".$MLS_Keyword."')  ) ";

			$Parameters .= " OR ( M.Description LIKE '%".str_replace(' ','%',$Keyword)."%'  ) ";

			$Parameters .= " )";
            //file_put_contents('lptNew.txt',print_r($Parameters,true));


		}
        #SystemName
        #-------------------
        /*if(isset($POST['sys_name']) && ($POST['sys_name'] != 'both'))
        {
            $Parameters	 .=	" AND M.SystemName ="."'". $POST['sys_name']."'";

            // $Parameters .= " AND (A.Area LIKE '".$POST['sys_name']."')";
        }*/

       /* elseif (isset($POST['sys_name']) && $POST['sys_name'] != '' && ($POST['sys_name'] == 'all') || !isset($POST['sys_name']))
        {
            $Parameters	 .=	" AND M.SystemName =". $POST['sys_name'] ;

        }*/
		/*if (isset($POST['sys_name']) && $POST['sys_name'] != Constants::MLS_ACTRIS)
		{*/
			if(isset($POST['sys_name']) && ($POST['sys_name'] != 'both'))
			{
				$Parameters	 .=	" AND M.SystemName ="."'". $POST['sys_name']."'";
			}
		/*}*/
		/*if (isset($POST['sys_name']) && $POST['sys_name'] == Constants::MLS_ACTRIS)
		{
			$Parameters	 .=	" AND M.MLSP_ID = ".Constants::ACTRIS;
		}*/
		/*else
		{
			$Parameters	 .=	" AND M.MLSP_ID = ".Constants::MARBEACHES;
		}*/
		if(!isset($POST['sitemap']))
		{
			$Parameters .= " AND M.MLSP_ID = " . Constants::MARBEACHES;
		}

        #---------------------------------

		# StreetNumber
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['streetnumbegin']) && $POST['streetnumbegin']!='')
			$Parameters	 .=	" AND StreetNumber >= ". intval($POST['streetnumbegin']). "";

		if (isset($POST['streetnumend']) && $POST['streetnumend']!='')
			$Parameters	 .=	" AND StreetNumber <= ". intval($POST['streetnumend']). "";

		# StreetName
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['streetname']) && $POST['streetname']!='')
			$Parameters	 .=	" AND StreetName LIKE '%". $POST['streetname']. "%' ";

		# remarks search
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['remarks']) && $POST['remarks']!='')
			$Parameters	 .=	" AND (PrivateRemarks LIKE '%". $POST['remarks']. "%' "."OR Description LIKE '%". $POST['remarks']. "%' " . " OR Legal LIKE '%". $POST['remarks']. "%') ";

		# Multiple StreetName
		#-----------------------------------------------------------------------------------------------------------------
		if(isset($POST['streetlist']) && trim($POST['streetlist'])!='')
		{
			$POST['streetlist'] = preg_replace("/ +/", "%", $POST['streetlist']); // Replace multiple/single space with %

			$arrKeyword = explode(",", trim($POST['streetlist'], ",")); // Remove comma(,) from the beginning and end of a string
			$arrKeyword = explode(",", trim($POST['streetlist'], ",")); // Remove comma(,) from the beginning and end of a string

			$condition 	 = implode("%' OR StreetName LIKE '%", $arrKeyword);

			$Parameters	 .=	" AND ( StreetName LIKE '%". $condition. "%' ) ";
		}


		# Zip Code
		#-----------------------------------------------------------------------------------------------------------------
		if(isset($POST['ziplist']) && trim($POST['ziplist']) != '')
		{
			//$POST['ziplist'] = preg_replace("/ +/", "", $POST['ziplist']); // Replace multiple/single space with none, we have no space in zipcode field

			$arrKeyword = explode(",", trim($POST['ziplist'], ",")); // Remove comma(,) from the beginning and end of a string

			$arrKeyword = array_map('trim',$arrKeyword);

			$condition 	 = implode("%' OR ZipCode LIKE '", $arrKeyword);

			$Parameters	 .=	" AND ( ZipCode LIKE '". $condition. "%' ) ";
		}
		elseif (isset($POST['zipcode']) && $POST['zipcode']!='')
		{
			if(is_array($POST['zipcode']) && count($POST['zipcode']) > 0)
			{
				$POST['zipcode'] = implode(',',$POST['zipcode']);
			}
			$ret = preg_match_all("/[0-9-]+/", $POST['zipcode'], $keywords);

			if(count($keywords[0]) > 0)
			{
				$condition 	 = implode("%' OR ZipCode LIKE '%", $keywords[0]);

				$Parameters	 .=	" AND ( ZipCode LIKE '%". $condition. "%')";
			}
		}

		# State Name
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['state']))
			$Parameters	 .=	" AND State = '". $POST['state']. "'";

		# County Name
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['county']) && is_array($POST['county']))
		{
			$POST['county'] = array_filter($POST['county']);

			if(count($POST['county']) > 0)
			{
				$condition 	 = implode('" OR County = "', $POST['county']);

				$Parameters	 .=	' AND ( County = "'. $condition. '" ) ';
			}

		}
		elseif(isset($POST['county']) && $POST['county'] != '')
			$Parameters .= " AND County = '". $POST['county'] ."' ";

		/*	MS
			Saturday, November 03, 2012
			Predefine search using checkbox with name City
		 */
		if(isset($POST['City']) && $POST['City'] != '')
			$POST['city'] = $POST['City'];

		# City Name
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['city']) && is_array($POST['city']))
		{
			$POST['city'] = array_filter($POST['city']);

			if(count($POST['city']) > 0)
			{
				$condition 	 = implode('" OR CityName = "', $POST['city']);

				$Parameters	 .=	' AND ( CityName = "'. $condition. '" ) ';
			}

		}
		elseif(isset($POST['city']))
		{

			if(strpos($POST['city'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['city']);

				$Parameters .= " AND CityName LIKE '".$cityName."'";
			}
			elseif(strpos($POST['city'], ','))
			{
				$cityName = explode(", ", $POST['city']);

				$Parameters .= " AND CityName LIKE '".$cityName[0]."'";
			}
			else
			{
				$Parameters	.=	" AND CityName = '". $POST['city']. "'";
			}
		}

		# Subdivision
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['sdiv']) && is_array($POST['sdiv']))
		{
			$POST['sdiv'] = array_filter($POST['sdiv']);

			if(count($POST['sdiv']) > 0)
			{
				$temp = array();

				foreach($POST['sdiv'] as $Key=>$val)
					$temp[] = " FIND_IN_SET('".addslashes($val)."',Subdivision) ";

				$temp_q = implode(' OR ',$temp);
				$Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif (isset($POST['sdiv']) && $POST['sdiv'] != '')
		{
			$Parameters .= " AND FIND_IN_SET('".addslashes($POST['sdiv'])."',Subdivision)";
		}
		elseif (isset($POST['sdivlist']) && $POST['sdivlist'] != '')
		{


			if(is_array($POST['sdivlist']) && count($POST['sdivlist']) > 0)
			{
				$POST['sdivlist'] = implode(',',$POST['sdivlist']);
			}

			$sub = explode(',', $POST['sdivlist']);

			$temp = array();
			foreach($sub as $Key=>$val){
				$temp[] = " Subdivision LIKE '%".$val."%' ";
			}

			$temp_q = implode(' OR ',$temp);
			$Parameters .=  " AND (".$temp_q.")";
		}

		# Area
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['area']) && is_array($POST['area']))
		{
			$POST['area'] = array_filter($POST['area']);

			if(count($POST['area']) > 0)
			{
				$condition 	 = implode("', '", $POST['area']);

				$Parameters	 .=	" AND Area IN('". $condition. "')";
			}
		}
		elseif (isset($POST['area']) && $POST['area']!='' && $POST['area']!='Any')
		{
			if(strpos($POST['area'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['area']);

				$Parameters .= " AND Area LIKE '".$cityName."'";
			}
			else
			{
				$str = str_replace(",", "','", $POST['area']);
				$Parameters	 .=	" AND Area IN('".$str. "')";
			}

		}
		elseif (isset($POST['mlsarea']) && $POST['mlsarea']!='')
		{
			if(strpos($POST['mlsarea'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['mlsarea']);

				$Parameters .= " AND Area LIKE '".$cityName."'";
			}
			else
			{
				$str = str_replace(",", "','", $POST['mlsarea']);
				$Parameters	 .=	" AND Area IN('".$str. "')";
			}

		}
		# Listing ID
		#-----------------------------------------------------------------------------------------------------------------
		if(isset($POST['notlistingidmls']) && is_array($POST['notlistingidmls']))
		{
			$arr_ret = array_map("TrimArray", $POST['notlistingidmls']);

			if(isset($POST['notblklist']))
			{
				$Parameters	 .=	" AND CONCAT(M.MLS_NUM,'-',M.MLSP_ID) IN ('". implode("','",$arr_ret). "') ";
			}
			else
			{
				$Parameters	 .=	" AND CONCAT(M.MLS_NUM,'-',M.MLSP_ID) NOT IN ('". implode("','",$arr_ret). "') ";
			}
		}

		# Listing ID [Not IN]
		if(isset($POST['notmlsnum']))
			$Parameters	 .=	" AND M.MLS_NUM NOT IN ('". $POST['notmlsnum']. "') ";

		# MLS No
		#-----------------------------------------------------------------------------------------------------------------
		if(isset($POST['mlsnum']) && is_array($POST['mlsnum']))
			$Parameters	 .=	" AND M.MLS_NUM IN ('". implode("','",$POST['mlsnum']). "') ";
		elseif(isset($POST['mlsnum']) && $POST['mlsnum'] != '')
		{
			$POST['mlsnum'] = str_replace(",", "','", trim($POST['mlsnum']));
			$Parameters	 .=	" AND M.MLS_NUM IN ('". $POST['mlsnum'] ."') ";
		}

		if(isset($POST['mlslist']) && trim($POST['mlslist'])!='')
		{
			$POST['mlslist'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['mlslist'])));
			$Parameters	 .=	" AND M.MLS_NUM IN ('". $POST['mlslist']. "') ";
		}
		// MLS-MARKETID
		if(isset($POST['mlsnowithmarket']) && trim($POST['mlsnowithmarket'])!='')
		{
			$POST['mlsnowithmarket'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['mlsnowithmarket'])));
			$Parameters	 .=	" AND CONCAT(M.MLS_NUM,'-',M.MLSP_ID) IN ('". $POST['mlsnowithmarket']. "') ";
		}

		if(isset($POST['mlsno']) && trim($POST['mlsno'])!='')
		{
			$Parameters	 .= " AND M.MLS_NUM LIKE '". trim($POST['mlsno']). "%'";

		}


		# MLSP_ID
		#-----------------------------------------------------------------------------------------------------------------
		if((isset($POST['mlspid']) && $POST['mlspid'] != '0' && $POST['mlspid'] != ''))
		{
			if(strpos($POST['mlspid'], "','") == false)
				$POST['mlspid'] = str_replace(",", "','", $POST['mlspid']);

			$Parameters	 .=	" AND M.MLSP_ID IN('".$POST['mlspid']."')";
            //file_put_contents('lpx.tx',print_r($Parameters,true));
		}
		if(isset($POST['notmlspid']) && $POST['notmlspid'] != '')
			$Parameters	 .=	" AND M.MLSP_ID != ".$POST['notmlspid'];

		if(isset($POST['activelistingflag']))
		{
			if(isset($this->picPath['InActive_MLSP_ID']) && $this->picPath['InActive_MLSP_ID'] != '')
				$Parameters	 .=	" AND M.MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";
		}

		# Property Feature
		#=================================================================================================================

		# Propert Style
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['pstyle']) && is_array($POST['pstyle']))
		{
			$POST['pstyle'] = array_filter($POST['pstyle']);

			if(count($POST['pstyle']) > 0)
			{
				//$Parameters	 .=	" AND FIND_IN_SET(PropertyStyle, '".implode(",",$POST['pstyle']). "')";
				$temp = array();
				foreach($POST['pstyle'] AS $key => $val)
				{
					$val = str_replace(URL_SEPARATORPIPE,URL_SEPARATORBACKSLASE, $val);

					$temp[] = " FIND_IN_SET('".$val."',PropertyStyle) ";
				}
				$temp_q = implode(' OR ',$temp);
				$Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif (isset($POST['pstyle']) && $POST['pstyle']!='')
		{
			$Parameters	 .=	" AND PropertyStyle = '".$POST['pstyle']. "'";
		}
		# Sale Type
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['sale']) && is_array($POST['sale']))
		{
			$POST['sale'] = array_filter($POST['sale']);
			if(count($POST['sale']) > 0)
			{
				$temp = array();
				foreach($POST['sale'] AS $key => $val)
				{
					$arr_val = explode(",", $val);
					foreach($arr_val AS $skey => $sval)
					{
						$temp[] = " FIND_IN_SET('".$asset['OL_SALE_TYPE'][$sval]."',SaleType) ";
					}

				}
				$temp_q = implode(' OR ',$temp);
				$Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif (isset($POST['sale']) && $POST['sale']!='')
		{
			$Parameters	 .=	" AND SaleType = '".$asset['OL_SALE_TYPE'][$POST['sale']]. "'";
		}
		# Property Condition
		#-------------------------------------------------------------------------------------------------------------------
		if (isset($POST['pcond']) && is_array($POST['pcond']))
		{
			if(count($POST['pcond']) > 0)
			{
				$temp = array();

				foreach($POST['pcond'] as $Key=>$val)
					$temp[] = " FIND_IN_SET('".$asset['OL_STRU_CONDITION'][$val]."',StructuralCondition) ";

				$temp_q = implode(' OR ',$temp);
				$Parameters .=  " AND (".$temp_q.")";
			}
		}
		# Propert Type
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['ptype']) && is_array($POST['ptype']))
		{
			$POST['ptype'] = array_filter($POST['ptype']);

			if(count($POST['ptype']) > 0)
			{
				$temp = array();

				foreach($POST['ptype'] as $Key=>$val)
				{
					$temp[] = " FIND_IN_SET('".$val."',PropertyType) ";
				}

				$temp_q = implode(' OR ',$temp);
				$Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif (isset($POST['ptype']) && $POST['ptype']!='' && $POST['ptype'] != 'Any')
		{
			// is it sub type ?
			if(strpos($POST['ptype'], 'PST|') !== false)
			{
				$POST['ptype'] = str_replace('PST|', '', $POST['ptype']);

				$Parameters	 .=	" AND FIND_IN_SET('".$POST['ptype']."', SubType)";
			}
			else
				$Parameters	 .=	" AND PropertyType = '".$POST['ptype']. "'";
		}
		# Stories Description
		#------------------------------------------------------------------------------------------------------------------
		if (isset($POST['sdesc']) && is_array($POST['sdesc']))
		{
			if(count($POST['sdesc']) > 0)
			{
				$temp = array();

				foreach($POST['sdesc'] as $Key=>$val)
					$temp[] = " FIND_IN_SET('".$asset['OL_STORIES_DESC'][$val]."',StoriesDescription) ";

				$temp_q = implode(' OR ',$temp);
				$Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif (isset($POST['sdesc']) && $POST['sdesc']!='')
		{
			$Parameters	 .=	" AND StoriesDescription = '".$POST['sdesc']. "'";
		}

		if (isset($POST['notptype']) && $POST['notptype'] != '')
		{
			$POST['notptype'] = str_replace(",", "','", $POST['notptype']);

			$Parameters	 .=	" AND PropertyType NOT IN('".$POST['notptype']."')";
		}
		# Propert Sub Type
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['stype']) && is_array($POST['stype']))
		{
			$POST['stype'] = array_filter($POST['stype']);

			if(count($POST['stype']) > 0)
			{
				$temp = array();
				$temp1 = array();
				foreach($POST['stype'] as $Key=>$val)
				{

					if(is_numeric(strpos($asset['OL_SubType_LOOKUP'][$val],'|')))
					{
						$stype = explode('|',$asset['OL_SubType_LOOKUP'][$val]);
						foreach($stype as $sKey=>$sval)
						{
							if(in_array($sval,$asset['OL_PropType_LOOKUP_ARRAY']))
							{
								$temp[] =  " PropertyType IN ('".$sval."')";
							}
							else
							{
								$temp[] =  " SubType IN ('".$sval."')";
							}
						}

					}
					elseif(in_array($asset['OL_SubType_LOOKUP'][$val],$asset['OL_PropType_LOOKUP_ARRAY']))
					{
						$temp[] = " FIND_IN_SET('".$asset['OL_SubType_LOOKUP'][$val]."',PropertyType) ";
					}
					else{
						$temp[] = " FIND_IN_SET('".$asset['OL_SubType_LOOKUP'][$val]."',SubType) ";
					}
				}

				$temp_q = implode(' OR ',$temp);
				$Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif (isset($POST['stype']) && $POST['stype']!='')
		{
			$val = $POST['stype'];
			if(is_numeric(strpos($asset['OL_SubType_LOOKUP'][$val],'|')))
			{
				$stype = explode('|',$asset['OL_SubType_LOOKUP'][$val]);
				foreach($stype as $sKey=>$sval)
				{
					if(in_array($sval,$asset['OL_PropType_LOOKUP_ARRAY']))
					{
						$temp[] =  " PropertyType IN ('".$sval."')";
					}
					else
					{
						$temp[] =  " SubType IN ('".$sval."')";
					}
				}

			}
			elseif(in_array($asset['OL_SubType_LOOKUP'][$val],$asset['OL_PropType_LOOKUP_ARRAY']))
			{
				$temp[] = " FIND_IN_SET('".$asset['OL_SubType_LOOKUP'][$val]."',PropertyType) ";
			}
			else{
				$temp[] = " FIND_IN_SET('".$asset['OL_SubType_LOOKUP'][$val]."',SubType) ";
			}

			$temp_q = implode(' OR ',$temp);
			$Parameters .=  " AND (".$temp_q.")";
		}
		# Propert Category
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['pstatus']) && $POST['pstatus']!='')
			$Parameters	 .=	" AND Category = '".$POST['pstatus']. "'";
		# Price Range
		# -----------------------------------------------------------------------------
		if (isset($POST['minprice']) && ($POST['minprice'] != '' && $POST['minprice']!='Any'))
		{
			if(strpos($POST['minprice'],',') == true)
			{
				$minPrice = str_replace(",", "", $POST['minprice']);

				$Parameters .= " AND M.ListPrice >= ". $minPrice;
			}
			else
			{
				$Parameters .= " AND M.ListPrice >= ". $POST['minprice'];
			}
		}
		//$Parameters .= " AND M.ListPrice >= ". $POST['minprice'];
		if (isset($POST['maxprice']) && ($POST['maxprice']!='' && $POST['maxprice']!='Any'))
		{
			if(strpos($POST['maxprice'],',') == true)
			{
				$maxPrice = str_replace(",", "", $POST['maxprice']);

				$Parameters .= " AND M.ListPrice >= ". $maxPrice;
			}
			else
			{
				$Parameters .= " AND M.ListPrice <= ". $POST['maxprice'];
			}
		}
		// Range given ex : $15000 - $2500000
		if (isset($POST['prange']) && $POST['prange'] != '' && $POST['prange'] != 'Any')
		{
			$arrTemp = explode("-", preg_replace("/[^0-9-]/",	"", 	$POST['prange']));

			if($arrTemp[0] > 0)
				$Parameters .= " AND M.ListPrice >= '". $arrTemp[0] ."'";

			if($arrTemp[1] != $POST['maxprice'])
				$Parameters .= " AND M.ListPrice <= '". $arrTemp[1] ."'";
		}

		# BedRooms Range
		# -----------------------------------------------------------------------------
		if(isset($POST['minbed']) && $POST['minbed'] > 0)
			$Parameters .= " AND M.Beds >= ". intval($POST['minbed']);

		if(isset($POST['maxbed']) && $POST['maxbed'] > 0)
			$Parameters .= " AND M.Beds <= ". intval($POST['maxbed']);

		// Range given
		if (isset($POST['bedrange']) && $POST['bedrange'] != '')
		{
			$arrTemp = explode("-", preg_replace("/[^0-9-]/",	"", 	$POST['bedrange']));

			if($arrTemp[0] > 0)
				$Parameters .= " AND M.Beds >= '". $arrTemp[0] ."'";

			if($arrTemp[1] != $POST['maxbed'])
				$Parameters .= " AND M.Beds <= '". $arrTemp[1] ."'";
		}

		if (isset($POST['beds']) && ($POST['beds']!= 'Any' && $POST['beds'] != '' && $POST['beds'] != 0))
		{
			$Parameters .= " AND M.Beds = '". $POST['beds'] ."'";
		}
		# BathRoms Range
		# -----------------------------------------------------------------------------
		if(isset($POST['minbath']) && $POST['minbath'] > 0)
			$Parameters .= " AND M.BathsFull >= ". intval($POST['minbath']);

		if(isset($POST['maxbath']) && $POST['maxbath'] > 0)
			$Parameters .= " AND M.BathsFull <= ". intval($POST['maxbath']);
		if (isset($POST['baths']) && ($POST['baths'] != 'Any' && $POST['baths'] != '' && $POST['baths'] != 0))
		{
			$Parameters .= " AND M.Baths >= '". round($POST['baths']) ."'";
		}
		# Garage Range
		# -----------------------------------------------------------------------------
		if(isset($POST['mingarage']) && $POST['mingarage'] > 0)
			$Parameters .= " AND M.Garage >= ". intval($POST['mingarage']);

		if(isset($POST['maxgarage']) && $POST['maxgarage'] > 0)
			$Parameters .= " AND M.Garage <= ". intval($POST['maxgarage']);

		# Min Square Feet
		# -----------------------------------------------------------------------------
		if(isset($POST['minsqft']) && $POST['minsqft'] > 0)
			$Parameters .= " AND M.SQFT >= ". $POST['minsqft'];

		if(isset($POST['maxsqft']) && $POST['maxsqft'] > 0)
			$Parameters .= " AND M.SQFT <= ". $POST['maxsqft'];

		// Range given ex : 150 - 1000
		if (isset($POST['srange']) && $POST['srange'] != '')
		{
			$arrTemp = explode("-", preg_replace("/[^0-9-]/",	"", 	$POST['srange']));
			if($arrTemp[0] > 0)
				$Parameters .= " AND M.SQFT >= '". $arrTemp[0] ."'";

			if(isset($POST['maxsqft']) && ($arrTemp[1] != $POST['maxsqft']))
				$Parameters .= " AND M.SQFT <= '". $arrTemp[1] ."'";
		}

		# Garage Range
		# -----------------------------------------------------------------------------
		if(isset($POST['minstories']) && $POST['minstories'] > 0)
			$Parameters .= " AND M.Stories >= ". intval($POST['minstories']);

		if(isset($POST['maxstories']) && $POST['maxstories'] > 0)
			$Parameters .= " AND M.Stories <= ". intval($POST['maxstories']);

		# Stories
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['stories']) && is_array($POST['stories']))
		{
			$POST['stories'] = array_filter($POST['stories']);

			if(count($POST['stories']) > 0)
			{
				$condition 	 = implode("%' OR Stories LIKE '%", $POST['stories']);

				$Parameters	 .=	" AND ( Stories LIKE '%". $condition. "%' ) ";
			}
		}
		elseif (isset($POST['stories']) && ($POST['stories'] != '' && $POST['stories'] != 'Any'))
			$Parameters	 .=	" AND Stories LIKE '%". $POST['stories']. "%'";

		#Parking
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['park']) && ($POST['park']!= 'Any' && $POST['park'] != '' && $POST['park'] != 0))
		{
			$Parameters .= " AND M.Parking >= '". $POST['park'] ."'";
		}
		#Total Unit
		#-----------------------------------------------------------------------------------------------------------------
		if(isset($POST['unit']) && $POST['unit'] != '' && $POST['unit'] != 'Any')
		{
			$Parameters	 .=	" AND TotalUnits >= '". $POST['unit']. "'";
		}
		# TotalAcreage
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['minacreage']) && $POST['minacreage']!='')
			$Parameters	 .=	" AND TotalAcreage >= '". $POST['minacreage']. "'";

		if (isset($POST['maxacreage']) && $POST['maxacreage']!='')
			$Parameters	 .=	" AND TotalAcreage <= '". $POST['maxacreage']. "'";

		# Loat Size (Sqft)
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['minlotsize']) && $POST['minlotsize']!='' && $POST['minlotsize']!='Any')
			$Parameters	 .=	" AND LotSize >= '". $POST['minlotsize']. "'";

		if (isset($POST['maxlotsize']) && $POST['maxlotsize']!='' && $POST['maxlotsize']!='Any')
			$Parameters	 .=	" AND LotSize <= '". $POST['maxlotsize']. "'";

		if (isset($POST['minlotsizesqft']) && $POST['minlotsizesqft']!='' && $POST['minlotsizesqft']!='Any')
			$Parameters	 .=	" AND LotSizeSQFT >= '". $POST['minlotsizesqft']. "'";

		if (isset($POST['maxlotsizesqft']) && $POST['maxlotsizesqft']!='' && $POST['maxlotsizesqft']!='Any')
			$Parameters	 .=	" AND LotSizeSQFT <= '". $POST['maxlotsizesqft']. "'";

		# Propert Age
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['minage']) && $POST['minage']!='' && $POST['minage']!='Any')
			$Parameters	 .=	" AND Age >= ". $POST['minage']. "";

		if (isset($POST['maxage']) && $POST['maxage']!='' && $POST['maxage']!='Any')
			$Parameters	 .=	" AND Age <= ". $POST['maxage']. "";

		# Year Range
		# -----------------------------------------------------------------------------
		if (isset($POST['minyear']) && $POST['minyear']!='' && $POST['minyear'] > 0)
			$Parameters .= " AND M.YearBuilt >= ". $POST['minyear'] ."";

		if (isset($POST['maxyear']) && $POST['maxyear']!='' && $POST['maxyear'] > 0)
			$Parameters .= " AND M.YearBuilt <= ". $POST['maxyear'] ."";

		if (isset($POST['yearbuilt']) && $POST['yearbuilt']!='')
			$Parameters .= " AND M.YearBuilt = '". $POST['yearbuilt'] ."'";

		# Tax
		# -----------------------------------------------------------------------------
		if (isset($POST['taxmin']) && $POST['taxmin']!='')
			$Parameters .= " AND M.Tax >= ". $POST['taxmin'];

		if (isset($POST['taxmax']) && $POST['taxmax']!='')
		{
			$Parameters .= " AND M.Tax <= ". $POST['taxmax'];
		}

		# Photos only
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['photos']) && $POST['photos'] == '1')
			$Parameters	 .=	" AND TotalPhotos > 0 AND pic_download_flag = 'Y'";
		# New Property After given Date
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['newpropafterdate']) && $POST['newpropafterdate'] != '')
		{
			$Parameters	 .=	" AND  UNIX_TIMESTAMP(ListingDate) > UNIX_TIMESTAMP('". $POST['newpropafterdate']. "')";
		}

		# New Property within day,//NewPropertyWithinDay
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['newpropwithinday']) && $POST['newpropwithinday'] != '')
		{
			$Parameters	 .=	" AND DATEDIFF(CURDATE(), Begin_Date) <= '". intval($POST['newpropwithinday']). "'";
		}

		# Property To Be Expire
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['expireday']) && $POST['expireday'] != '')
		{
			$Parameters	 .=	" AND DATEDIFF(End_Date, CURDATE()) <= '". intval($POST['expireday']). "'";
		}

		# School
		#-----------------------------------------------------------------------------------------------------------------
		if(isset($POST['schl']) && is_array($POST['schl']))
		{
			$temp = array();
			foreach($POST['schl'] AS $key => $val)
			{
				$temp[] = " (Elementary_School LIKE '%". $val. "%' OR High_School LIKE '%". $val. "%' OR Middle_School LIKE '%". $val. "%') ";
			}
			$temp_q = implode(' OR ',$temp);
			$Parameters .=  " AND (".$temp_q.")";
		}
		elseif (isset($POST['schl']) && $POST['schl']!='')
			$Parameters	 .=	" AND (Elementary_School LIKE '%". $POST['schl']. "%' OR High_School LIKE '%". $POST['schl']. "%' OR Middle_School LIKE '%". $POST['schl']. "%') ";

		# Elemantary School
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['elemschl']) && is_array($POST['elemschl']))
		{
			$POST['elemschl'] = array_filter($POST['elemschl']);

			if(count($POST['elemschl']) > 0)
			{
				$condition 	 = implode("' OR Elementary_School = '", $POST['elemschl']);

				$Parameters	 .=	" AND ( Elementary_School = '". $condition. "' ) ";
			}
		}
		elseif (isset($POST['elemschl']) && $POST['elemschl']!='')
			$Parameters .= " AND Elementary_School = '". $POST['elemschl']."'";

		// Middle School
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['midschl']) && is_array($POST['midschl']))
		{
			$POST['midschl'] = array_filter($POST['midschl']);

			if(count($POST['midschl']) > 0)
			{
				$condition 	 = implode("' OR Middle_School = '", $POST['midschl']);

				$Parameters	 .=	" AND ( Middle_School = '". $condition. "' ) ";
			}
		}
		elseif (isset($POST['midschl']) && $POST['midschl']!='')
			$Parameters .= " AND M.Middle_School = '". $POST['midschl']."'";

		// High School
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['highschl']) && is_array($POST['highschl']))
		{
			$POST['highschl'] = array_filter($POST['highschl']);

			if(count($POST['highschl']) > 0)
			{
				$condition 	 = implode("' OR High_School = '", $POST['highschl']);

				$Parameters	 .=	" AND ( High_School = '". $condition. "' ) ";
			}
		}
		elseif (isset($POST['highschl']) && $POST['highschl']!='')
			$Parameters .= " AND M.High_School = '". $POST['highschl']."'";

		// School District
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['sdist']) && is_array($POST['sdist']))
		{
			$POST['sdist'] = array_filter($POST['sdist']);

			if(count($POST['sdist']) > 0)
			{
				$condition 	 = implode("' OR School_District = '", $POST['sdist']);

				$Parameters	 .=	" AND ( School_District = '". $condition. "' ) ";
			}
		}
		elseif (isset($POST['sdist']) && $POST['sdist']!='')
		{
			$str = str_replace(",", "','", $POST['sdist']);

			$Parameters .= " AND M.School_District IN ('". $str."')";
		}

		// Lot Description
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['lotdesc']) && is_array($POST['lotdesc']))
		{
			$POST['lotdesc'] = array_filter($POST['lotdesc']);

			if(count($POST['lotdesc']) > 0)
			{
				$condition 	 = implode("' OR LotDescription = '", $POST['lotdesc']);

				$Parameters	 .=	" AND ( LotDescription = '". $condition. "' ) ";
			}
		}
		elseif (isset($POST['lotdesc']) && $POST['lotdesc']!='')
			$Parameters .= " AND LotDescription LIKE '%". $POST['lotdesc']."%'";

		# Office ID
		if (isset($POST['office']) && $POST['office']!='')
		{
			if(isset($POST['office']) && is_array($POST['office']) && count($POST['office']) > 0)
			{
				$POST['office'] = implode(',',$POST['office']);
			}
			$POST['office'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['office'])));

			$Parameters .= " AND (M.OfficeID IN('". $POST['office']."') OR M.CoOfficeID IN('". $POST['office']."'))";
		}
		# Agent ID
		if(isset($POST['agent']) && is_array($POST['agent']) && count($POST['agent']) > 0)
		{
			$Agent_Id_List = implode(",",$POST['agent']);
			$POST['agent'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $Agent_Id_List)));
			if(isset($POST['status']) && ( strtolower($POST['status']) == 'closed'  || is_array($POST['status']) && in_array('closed',$POST['status'])))
			{
				$Parameters .= " AND ( M.Agent_ID IN('". $POST['agent']."') OR M.BuyAgent_ID IN ('".$POST['agent']."') OR M.CoAgent_ID IN ('".$POST['agent']."'))";
			}
			else{
				$Parameters .= " AND ( M.Agent_ID IN('". $POST['agent']."') OR M.CoAgent_ID IN ('".$POST['agent']."'))";
			}

		}
		elseif (isset($POST['agent']) && $POST['agent']!='')
		{
			$POST['agent'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['agent'])));
			//$Parameters .= " AND ( M.Agent_ID IN('". $POST['agent']."') OR M.BuyAgent_ID IN ('".$POST['agent']."'))";
			if(isset($POST['status']) && ( ($POST['status']) == 'closed'  || is_array($POST['status']) && in_array('closed',$POST['status'])))
			{
				$Parameters .= " AND ( M.Agent_ID IN('". $POST['agent']."') OR M.BuyAgent_ID IN ('".$POST['agent']."') OR M.CoAgent_ID IN ('".$POST['agent']."'))";
			}
			else{
				$Parameters .= " AND ( M.Agent_ID IN('". $POST['agent']."') OR M.CoAgent_ID IN ('".$POST['agent']."'))";
			}
		}
		# Agent Name
		if (isset($POST['agentname']) && $POST['agentname']!='')
		{
			$Parameters .= " AND (AG.Agent_FName LIKE '%". $POST['agentname']."%' OR AG.Agent_LName LIKE '%". $POST['agentname']."%'".
				" AG2.Agent_FName LIKE '%". $POST['agentname']."%' OR AG2.Agent_LName LIKE '%". $POST['agentname']."%')";
		}

		# Open House
		if (isset($POST['oh']))
		{
			$Parameters .=" AND Is_OpenHouse = 'Y'";
			if(!defined("IN_ADMIN") && !empty($config['exclude_openhouse_by_officeId']))
				$Parameters .= " AND M.OfficeID NOT IN('".str_replace(',',"','",$config['exclude_openhouse_by_officeId'])."')";
		}

		# Book Section
		if (isset($POST['booksec']) && is_array($POST['booksec']))
		{
			$POST['booksec'] = array_filter($POST['booksec']);

			if(count($POST['booksec']) > 0)
			{
				$condition 	 = implode("','", $POST['booksec']);

				$Parameters	 .=	" AND BookSection IN ('". $condition. "')";
			}
		}
		elseif (isset($POST['booksec']) && $POST['booksec'] != '')
		{
			$Parameters	 .=	" AND BookSection = '". $POST['booksec']. "'";
		}

		# Find Radious
		if (isset($POST['latitude']) && ($POST['latitude']!='') && ($POST['longitude']!=''))
			$Parameters .= " AND ( 6378.7 * ACOS( SIN( Latitude / 57.2958 ) * SIN( ".$POST['latitude']." / 57.2958 ) + COS( Latitude / 57.2958 ) * COS( ".$POST['latitude']." / 57.2958 ) * COS( ".$POST['longitude']." / 57.2958 - ( Longitude ) / 57.2958 ) ) ) < ".(isset($POST['miles']) ? $POST['miles'] : "5");

		# GeoCoded Properties only ?
		if(isset($POST['Is_GeoCoded']))
		{
			$Parameters .= " AND (Latitude != '' AND Longitude != '' AND Latitude != 0 AND Longitude != 0)";
		}

		# New Construction
		if(isset($POST['new']))
		{
			$Parameters	 .=	" AND (YearBuilt > 0 AND (date_format( curdate( ) , '%Y' ) - YearBuilt) <= 2)";
		}

		# Short Sale
		if(isset($POST['shortsale']))
		{
			$Parameters	 .=	" AND Description LIKE '%short sale%'";
		}

		# Owner
		if(isset($POST['owner']))
		{
			$Parameters	 .=	" AND Owner LIKE '%".$POST['owner']."%'";
		}

		# Quick Search Type Received ?
		if(isset($POST['searchType']))
		{
			switch($POST['searchType'])
			{
				# New Property within day
				case "new-property":
					$Parameters	 .=	" AND DATEDIFF(CURDATE(), ListingDate) <= 7";
					break;

				# New Construction
				case "new-constructed-property":
					$Parameters	 .=	" AND (YearBuilt > 0 AND (date_format( curdate( ) , '%Y' ) - YearBuilt) <= 2)";
					break;

				# Open House
				case "open-houses":
					$Parameters .=" AND Is_OpenHouse = 'Y'";
					if(!defined("IN_ADMIN"))
						$Parameters .= " AND M.OfficeID NOT IN('".str_replace(',',"','",$config['exclude_openhouse_by_officeId'])."')";
					break;

				case "price-reduced-property":
					$Parameters .= " AND Price_Diff < 0";
					break;

				case "price-increased-property":
					$Parameters .= " AND Price_Diff > 0";
					break;
				# Short sale
				case "short-sale-property":
					$Parameters	 .=	" AND Description LIKE '%short sale%'";
					break;
			}
		}

		# Basement
		#---------------------------------------------------------------------------------------------------------
		if (isset($POST['basement']) && is_array($POST['basement']))
		{
			$POST['basement'] = array_filter($POST['basement']);

			if(count($POST['basement']) > 0)
			{
				$condition 	 = implode("' OR Basement = '", $POST['basement']);

				$Parameters	 .=	" AND ( Basement = '". $condition. "' ) ";
			}
		}
		elseif (isset($POST['basement']) && $POST['basement']!='')
			$Parameters .= " AND Basement = '". $POST['basement']."'";

		if(isset($POST['view']) && $POST['view'] != 'Any')
		{
			if($POST['view'] == 'Yes' || $POST['view'] == 'yes')
				$Parameters .= " AND ViewYN = '1'";
			elseif($POST['view'] == 'No' || $POST['view'] == 'no')
				$Parameters .= " AND ViewYN = '0'";
		}
		# WaterFront desc ?
		if(isset($POST['waterfrontdesc']) && is_array($POST['waterfrontdesc']))
		{
			$condition = implode("', WaterfrontDesc) OR FIND_IN_SET('", $POST['waterfrontdesc']);
			$Parameters .= " AND (FIND_IN_SET('".$condition."', WaterfrontDesc))";
		}
		elseif(isset($POST['waterfrontdesc']) && $POST['waterfrontdesc'] != '')
		{
			//$Parameters .= " AND WaterfrontDesc = '". $POST['waterfrontdesc']. "'";
			$Parameters .= " AND (FIND_IN_SET('".$POST['waterfrontdesc']."', WaterfrontDesc))";
		}

		# Short Sale
		if(isset($POST['shortsale']))
		{
			$Parameters	 .=	" AND Is_ShortSale = '".$POST['shortsale']."'";
		}

		# Short Sale
		if(isset($POST['waterfront']) && $POST['waterfront'] != 'Any' && $POST['waterfront'] != '')
		{
			$Parameters	 .=	" AND Is_Waterfront = '".$POST['waterfront']."'";
		}
		# Days On Market
		# ---------------------------------------------------------------------------------
		if(isset($POST['dom']) && ($POST['dom'] != '' && $POST['dom'] != 'Any'))
		{

			if(strpos($POST['dom'],'-') == true)
				$Parameters .= " AND (DATEDIFF(CURRENT_DATE(), ListingDate)) <= SUBSTRING_INDEX('".$POST['dom']."','-','1')";
			elseif(strpos($POST['dom'],'+') == true)
				$Parameters .= " AND (DATEDIFF(CURRENT_DATE(), ListingDate)) >= SUBSTRING_INDEX('".$POST['dom']."','+','1')";
			else
				$Parameters .= " AND (DATEDIFF(CURRENT_DATE(), ListingDate)) <= '".$POST['dom']."'";
		}

		# REO
		if(isset($POST['reo']))
		{
			$Parameters	 .=	" AND Is_REO = '".$POST['reo']."'";
		}
		# HOA
		if(isset($POST['ishoa']) && $POST['ishoa'] != 'Any' && $POST['ishoa'] != '')
		{
			$Parameters	 .=	" AND IS_HOA = '".$POST['ishoa']."'";
		}
		# HOA
		if(isset($POST['isnew']) && $POST['isnew'] != 'Any' && $POST['isnew'] != '')
		{
			$Parameters	 .=	" AND Is_New = '".$POST['isnew']."'";
		}

		# Price Reduce
		if(isset($POST['pricereduce']))
		{
			$Parameters .= " AND Price_Diff < 0";
		}

		# Pool ?
		if(isset($POST['pool']) && ($POST['pool'] != '' && $POST['pool']!= 'Any'))
		{
			if($POST['pool'] == 'Yes' || $POST['pool'] == 'yes')
				$Parameters .= " AND FIND_IN_SET('Pool',PoolDesc) ";
			elseif($POST['pool'] == 'No' || $POST['pool'] == 'no')
				$Parameters .= " AND !FIND_IN_SET('Pool',PoolDesc) ";
		}
		# Pets ?
		if(isset($POST['petsallowed']) && $POST['petsallowed'] !='' && $POST['petsallowed'] != 'Any')
		{
			if(strtolower($POST['petsallowed']) == 'yes')
			{
				$Parameters .= " AND PetsAllowed != 'No'";
			}else{
				$Parameters .= " AND PetsAllowed = 'No'";
			}

		}
		if(isset($POST['map']) && !empty($POST['map']))
		{
			if(!is_array($POST['map']))
			{
				$POST['map'] = explode(',', $POST['map']);
			}
			$south 	= str_replace(',', '.', $POST['map'][0]);
			$west 	= str_replace(',', '.', $POST['map'][1]);
			$north 	= str_replace(',', '.', $POST['map'][2]);
			$east 	= str_replace(',', '.', $POST['map'][3]);

			if($west > $east)
				$Parameters .= " AND ((Latitude BETWEEN $south AND $north) AND ((Longitude BETWEEN -180 AND $east) OR (Longitude BETWEEN $west AND 180)))";
			else
				$Parameters .= " AND ((Latitude BETWEEN $south AND $north) AND (Longitude BETWEEN $west AND $east))";
		}
		if(isset($POST['poly']) && !empty($POST['poly'])/* && $POST['isPolygonSearch'] == 1*/)
		{
			$poly = trim($POST['poly'], "~");
			$point = explode('~',$poly);
			array_push($point,$point[0]);
			$Polygon = implode(",", $point);

			$Parameters .= " AND st_contains(GeomFromText('POLYGON((".$Polygon."))'), point(Latitude, Longitude))";
		}
		//MBRContains
		# Find listing in give polygon
		if(isset($POST['area_geo_points_xy']) && $POST['area_geo_points_xy'] != '')
		{
			$sql = "SELECT * from listing_address where MBRContains('".$POST['area_geo_points_xy']."','Point(Latitude,Longitude)')";
		}
		if(isset($POST['cir']) && !empty($POST['cir'])/* && $POST['isCircleSearch'] == 1*/)
		{
			$circle_param = explode('~',$POST['cir']);

			$radius = $circle_param['0'];
			$cenLat = $circle_param['1'];
			$cenLng = $circle_param['2'];

			$Parameters .= " AND SQRT(POW(".$cenLat." - Latitude , 2) + POW(".$cenLng." - Longitude, 2)) * 100 < (".$radius."/1000)";

		}
		if(isset($POST['upcomeoh']) && $POST['upcomeoh'] == 'Yes')
		{
			$Parameters .= " AND (SELECT COUNT(*) AS open_house_cnt FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1)";
		}

		if(isset($POST['last_sold']) && $POST['last_sold'] !== ''){
            $Parameters .= " AND Sold_Date >= '" . $POST['last_sold'] . "'";
        }

        if(isset($POST['furnished']) && $POST['furnished'] != 'Any' && $POST['furnished'] != '')
        {
            $Parameters	 .=	" AND Furnished = '".$POST['furnished']."'";
        }

		if(isset($POST['status']) && is_array($POST['status']))
		{

			if(count($POST['status']) > 0)
			{

				if((in_array('active', $POST['status']) || in_array('pending', $POST['status'])) && !in_array('rental', $POST['status']))
				{
					$Parameters .= "  AND PropertyType NOT IN ('ResidentialLease')";
				}
				elseif(in_array('rental', $POST['status']) && !in_array('active', $POST['status']) && !in_array('pending', $POST['status']))
				{
                    $Parameters .= " AND ListingStatus IN ('Active')";
					$Parameters .= " AND PropertyType IN ('ResidentialLease')";
				}

				if(in_array('rental',$POST['status']) )
				{
					$status_param[] = " ( ListingStatus IN ('Active') AND PropertyType IN ('ResidentialLease') )";
				}
				if(in_array('closed',$POST['status']) )
				{
					$status_param[] = " ( ListingStatus IN ('Closed') AND PropertyType NOT IN ('ResidentialLease') )";
				}
                if(in_array('undercontract',$POST['status']) )
                {
                    $status_param[] = " ( ListingStatus IN ('ActiveUnderContract','Pending') AND PropertyType NOT IN ('ResidentialLease') )";
                }
				//if(in_array('active', $POST['status']) || in_array('rental', $POST['status']))
				if(in_array('active', $POST['status']))
				{
					$status_param[] = " ( ListingStatus IN ('Active','ActiveUnderContract','ComingSoon','Pending') AND PropertyType NOT IN ('ResidentialLease') )";
				}
				if(in_array('pending',$POST['status']) )
				{
					$status_param[] = " ( ListingStatus IN ('ActiveUnderContract', 'Pending') AND PropertyType NOT IN ('ResidentialLease') ) ";
				}
			}
			if(!in_array('closed',$POST['status']))
			{
				$Parameters .= " AND ListPrice > 0 ";
			}
		}
		elseif(isset($POST['status']) && $POST['status'] == 'active')
		{
			if(isset($POST['market_report']) && $POST['market_report'] == 'YES')
				$Parameters .= " AND ListingStatus IN ('Active')";
			else
				$Parameters .= " AND ListingStatus IN ('Active','ActiveUnderContract','ComingSoon','Pending')";
			$Parameters .= "  AND PropertyType NOT IN ('ResidentialLease')";

			$Parameters .= " AND ListPrice > 0 ";
		}
		elseif(isset($POST['status']) && $POST['status'] == 'pending')
		{
			$Parameters .= " AND ListingStatus IN ('ActiveUnderContract', 'Pending')";
			$Parameters .= "  AND PropertyType NOT IN ('ResidentialLease')";

			$Parameters .= " AND ListPrice > 0 ";
		}
		elseif(isset($POST['status']) && $POST['status'] == 'rental'){
			//$Parameters .= " AND ListingStatus IN ('Active','ActiveUnderContract','ComingSoon', 'Pending')";
			$Parameters .= " AND ListingStatus IN ('Active')";
			$Parameters .= " AND PropertyType IN ('ResidentialLease')";

			$Parameters .= " AND ListPrice > 0 ";
		}elseif(isset($POST['status']) && strtolower($POST['status']) == 'closed')
		{
			$Parameters .= " AND ListingStatus IN ('Closed')";
            $Parameters .= " AND PropertyType NOT IN ('ResidentialLease')";
		}
        elseif(isset($POST['status']) && $POST['status'] == 'undercontract')
        {
            $Parameters .= " AND ListingStatus IN ('ActiveUnderContract','Pending')";
            $Parameters .= "  AND PropertyType NOT IN ('ResidentialLease')";

            $Parameters .= " AND ListPrice > 0 ";
        }
		else{
			$Parameters .= " AND ListingStatus IN ('Active','ActiveUnderContract','ComingSoon','Pending')";
			$Parameters .= " AND ListPrice > 0 ";
		}

		if(isset($POST['maxpricedef']) && $POST['maxpricedef'] != ''){
			$Parameters .= " AND Price_Diff >= '".$POST['maxpricedef']."'";
		}

		# Is Mark for deletion
		$Parameters .= " AND M.is_mark_for_deletion = 'N'";

		#ListPrice above 0
		if(is_array($status_param) && count($status_param) > 0)
		{
			$temp_q = '';

			$temp_q = implode(' OR ',$status_param);
			$Parameters .= " AND ( ".$temp_q." ) ";

		}
		# Horse Amenities

		/*if(isset($POST['horse_amenities']) && $POST['horse_amenities'] != '')
		{
			$Parameters	 .=	" AND HorseAmenities LIKE '%". $POST['horse_amenities']. "%' ";
		}*/

		#HorseYN or Is Horse?
		if(isset($POST['horse_yn']) && $POST['horse_yn'] != '')
		{
			$Parameters	 .=	" AND HorseYN = '". $POST['horse_yn']. "' AND  HorseAmenities != '' ";
		}

		# Security Safety
		if(isset($POST['security_safety'])) {

			$security_sefety = StaticArray::arrMapSecuritySafety()[$POST['security_safety']];

			if (is_array($security_sefety)) {
				$condition = implode("', SecuritySafety) OR FIND_IN_SET('", $security_sefety);
				$Parameters .= " AND (FIND_IN_SET('" . $condition . "', SecuritySafety))";
			} elseif ($security_sefety != '') {
				//$Parameters .= " AND WaterfrontDesc = '". $POST['waterfrontdesc']. "'";
				$Parameters .= " AND (FIND_IN_SET('" . $security_sefety . "', SecuritySafety))";
			}
		}

		# Membership Required YN
		if(isset($POST['membership_required']) && $POST['membership_required'] != 'Any' && $POST['membership_required'] != '')
		{
			$Parameters	 .=	" AND MembershipRequiredYN = '".$POST['membership_required']."'";
		}

		# Membership Fee
		if(isset($POST['membership_fee']) && $POST['membership_fee'] != '')
		{
			$Parameters .= " AND MembershipFee = '".$POST['membership_fee']."'";
		}

		# Date Range
		if (isset($POST['mindate']) && $POST['mindate'] != '' && isset($POST['maxdate']) && $POST['maxdate'] != '')
		{
			$mindate = DateTime::createFromFormat("m-d-Y" , $POST['mindate']);
			$maxdate = DateTime::createFromFormat("m-d-Y" , $POST['maxdate']);
			$Parameters	 .=	" AND CAST(LastUpdateDate AS date) between '".$mindate->format('Y-m-d')."' and '".$maxdate->format('Y-m-d')." '";
		}
		elseif (isset($POST['mindate']) && $POST['mindate'] != '')
		{
			$mindate = DateTime::createFromFormat("m-d-Y" , $POST['mindate']);
			$Parameters	 .= " AND '".$mindate->format('Y-m-d') ."' <= CAST(LastUpdateDate AS date) ";

		}elseif(isset($POST['maxdate']) && $POST['maxdate'] != '')
		{
			$maxdate = DateTime::createFromFormat("m-d-Y" , $POST['maxdate']);
			$Parameters	 .= " AND '".$maxdate->format('Y-m-d') ."' >= CAST(LastUpdateDate AS date) ";
		}

		return $Parameters;
	}
	#=========================================================================================================================
	#	Function Name	:   getIDXListingByParam
	#-------------------------------------------------------------------------------------------------------------------------
	public function getIDXListingByParam($POST)
	{
		//echo '<pre>';print_r($POST);exit();
		global $db, $asset;

		$addParameters = $this->getQueryParameters($POST);

		$POST[P_SIZE] = isset($POST[P_SIZE]) ? $POST[P_SIZE] : RESULT_PAGESIZE;

		$sql = " SELECT count(*) as cnt "." FROM ".$this->Data['TriggerSearchByMapsearch']." AS M "." WHERE 1 ".$addParameters;

		$rs = $db->query($sql);
		$rs->next_record();

		$this->total_record = $rs->f("cnt");
		$rs->free();

		if (!isset($POST['allRecord']))
		{
			if((isset($POST[S_RECORD]) && $POST[S_RECORD] >= $this->total_record) || $POST[P_SIZE] >= $this->total_record || !isset($POST[S_RECORD]))
				$POST[S_RECORD] = 0;
		}

		if(isset($POST[V_TYPE]) && $POST[V_TYPE] == VT_LIST)
		{
			$sql = " SELECT M.* ";

			if(isset($POST['ShowMiles']) && $POST['ShowMiles'] && $POST['latitude'])
				$sql .= ",( 6378.7 * ACOS( SIN( Latitude / 57.2958 ) * SIN( ".$POST['latitude']." / 57.2958 ) + COS( Latitude / 57.2958 ) * COS( ".$POST['latitude']." / 57.2958 ) * COS( ".$POST['longitude']." / 57.2958 - ( Longitude ) / 57.2958 ) ) ) AS Miles";
		}
		elseif(isset($POST[V_TYPE]) && $POST[V_TYPE] == VT_MAP)
		{
			$sql = " SELECT M.* ";
		}
		elseif(isset($POST[V_TYPE]) && $POST[V_TYPE] == VT_SITE_MAP)
		{
			$sql =  " SELECT M.MLS_NUM, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, M.PropertyType, LastUpdateDate,M.SystemName, M.Beds,M.Baths,M.ListPrice, M.SQFT, M.Main_Photo_Url, Category, mls_is_pic_url_supported,".
				" StreetNumber, StreetName, Address, StreetDirection, StreetDirPrefix, StreetSuffix, StreetDirSuffix, Area, CityName, State, County, ZipCode, UnitNo, DisplayAddress ";
		}
		else
		{
			$sql = " SELECT M.* ";
		}

		if(isset($POST[V_TYPE]) && $POST[V_TYPE] != VT_SITE_MAP)
		{
			if($POST[SO] == 'ppsf')
			{
				$sql.= " ,(ListPrice/SQFT) AS PPSF";
			}
			if($POST[SO] == 'lsuc')
			{
				$sql.= " , ( CASE
					WHEN M.`ListingStatus` = 'ActiveUnderContract' THEN 0
					WHEN M.`ListingStatus` = 'Pending' THEN 1
					ELSE 2
						END) AS LSUC";
			}
			if($POST[SO] == 'cosfr')
			{
				$sql.= " , ( CASE
					WHEN M.`SubType` = 'Condominium' THEN 0
					WHEN M.`SubType` = 'SingleFamilyResidence' THEN 0
					WHEN M.`SubType` = 'UnimprovedLand' THEN 1
					ELSE 2
						END) AS COSFR";
			}
		}


		$sql .= " FROM ".$this->Data['TriggerSearchByMapsearch']." AS M WHERE 1 ".$addParameters;

		if (isset($POST['sort_order_list']) && count($POST['sort_order_list']) > 0)
		{
			$field_order='';
			foreach ($POST['sort_order_list'] as $field => $order)
			{
				$field_order .= $field." ".$order.",";
			}

			$field_order = rtrim($field_order,",");

			$sql .= " ORDER BY ".$field_order;
		}
		else
		{
			if(defined("IN_ADMIN"))
			{

				$sql .=	" ORDER BY ". ((isset($POST[SO]) && $POST[SO] != '')? $POST[SO] :'Subdivision').' '.((isset($POST[SD]) && $POST[SD] != '')? $POST[SD] :'DESC');

			}
			else
			{
				$param = '';
				$sql .=	' ORDER BY '. $param .(isset($POST[SO]) && $POST[SO] != ''? ($POST[SO] == 'location' ? 'StreetName' : $asset['OL_SORTBY_LOOKUP_ARRAY'][$POST[SO]]) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.(isset($POST[SD]) && $POST[SD] != ''? $POST[SD] :DEFAULT_SD);

				if($POST[SO] == 'cosfr'){
					$sql .=  ' ,ListPrice DESC';
				}
			}
		}

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST[S_RECORD]. ", ". $POST[P_SIZE];
		//echo $sql;exit();

		# Show debug in fo
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		$arr['rs'] = array();
		$arr['map-data'] = array();
		$asset['mlsPhotoType'] = array();
		$asset['mlsPhotoType']		= 	array	( 'large' 	=>	'Hi-resolution Photo',
		);

		# To Get creadential for image loading from amzon s3.
		$s3 = AWS_S3::obj()->aws_s3_get_credential();
		while($rs->next_record())
		{
			$row = $rs->Record;

			if($row['mls_is_pic_url_supported'] == 'Yes')
			{
				foreach ($asset['mlsPhotoType'] as $phototype=>$des){
					$row['MainPicture'][$phototype]['url'] = $row['Main_Photo_Url'];
				}
				if(!isset($row['MainPicture']['thumb']) && isset($row['MainPicture']['large'])){
					$row['MainPicture']['thumb'] = $row['MainPicture']['large'];
				}
				//				$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
			}
			else
			{
				$pic_no = $row['Main_Photo']-1;

				$MLS_NUM = $row['MLS_NUM'];
				$pic_url = $MLS_NUM.'_'.$pic_no.'.jpg';

				$row['MainPicture'] = $this->Pic_Path.'/'.$row['ListingID_MLS']."/".$pic_no."";
				//echo $row['MainPicture'];exit();

				/*if (strlen($MLS_NUM)>2)
					$aws_folder_path = substr($MLS_NUM,-2);
				else
					$aws_folder_path = $MLS_NUM;

				if($row['MLSP_ID'] == 2)
				{
					$row['MainPicture'] = $this->Pic_Path_Actris.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
					$MLSFolder = S3_BUCKET_FOLDER_ACTRIS;
				}
				else
				{
					$row['MainPicture'] = $this->Pic_Path_Trestle.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
					$MLSFolder = S3_BUCKET_FOLDER_TRESTLE;
				}

				# Checking exist image on amzon s3 using curl
				//$url_response = Utility::getInstance()->amazon_s3_url_exists($a);

				# Checking exist image on amazon s3 using aws sdk
				$aws_obj_path = $MLSFolder.'/'.$aws_folder_path.'/'.$MLS_NUM.'/'.$pic_url;
				if(!isset($POST[V_TYPE]) || (isset($POST[V_TYPE]) && $POST[V_TYPE] != VT_SITE_MAP))
				{
					$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_obj_path);
					/*try{
						$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_obj_path);
						//echo '<pre>';print_r($obj_response);exit();
					}
					catch (S3Exception $e){

						//echo $e->getMessage();exit();
						file_put_contents('S3_error.txt',print_r($e->getMessage(),true),FILE_APPEND);
						$obj_response = false;
					}*/

					/*if($obj_response == false)
					{
						$row['MainPicture'] = S3_BUCKET_URL.'/no-photo/no-property-img.jpg';
					}
				}*/



			}




			if(isset($POST['getAllPhoto']))
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$PicArr = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=false);

					$row['PhotoAll'] = $PicArr;
				}
				else
				{
					$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos'],false);
					$row['PhotoAll'] = $PicArr;
				}
			}

			array_push($arr['rs'], $row);
			$row['formatURL'] = $POST['formatURL'];
			$PhotoBaseUrl = $this->Pic_Path;
			/*if($row['mls_is_pic_url_supported'] == 'Yes')
			{
				$PhotoBaseUrl = $this->Pic_Path;
			}
			elseif($row['mls_is_pic_url_supported'] == 'No')
			{
				if($row['MLSP_ID'] == 2)
					$PhotoBaseUrl = $this->Pic_Path_Actris;
				else
					$PhotoBaseUrl = $this->Pic_Path_Trestle;
			}
			else
			{
				$PhotoBaseUrl = S3_BUCKET_URL;
			}*/

			if(isset($POST['getMapData'])/* && $row['Latitude'] > 0*/)
			{
				$rsAttributes = Utility::getInstance()->generateListingAttributes($row);

				$arrTemp = array();
				$arrTemp['Key'] 		= $row['ListingID_MLS'];
				$arrTemp['MLS'] 		= $row['MLS_NUM'];
				$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
				$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
				$arrTemp['AddressSort'] = $rsAttributes['AddressSort'];
				$arrTemp['Desc'] 	    = $row['Description'];
				$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
				$arrTemp['Lat'] 		= $row['Latitude'];
				$arrTemp['Long'] 		= $row['Longitude'];
				$arrTemp['CityName'] 	= $row['CityName'];
				$arrTemp['State'] 		= $row['State'];
				$arrTemp['ZipCode'] 	= $row['ZipCode'];
				$arrTemp['Price'] 		= $row['ListPrice'];
				$arrTemp['Price_Diff_per'] 		= $row['Price_Diff'];
				$arrTemp['OriginalListPrice'] = $row['OriginalListPrice'];
				$arrTemp['PriceDiffValue'] =  $row['ListPrice'] - $row['OriginalListPrice'];
				$arrTemp['SoldPrice'] 	= $row['Sold_Price'];
				$arrTemp['Type']        = $row['PropertyType'];
				$arrTemp['SubType']     = $row['SubType'];
				$arrTemp['Bed'] 		= $row['Beds'];
				$arrTemp['Bath'] 		= rtrim(rtrim($row['Baths'],'0'),'.');
				$arrTemp['Sqft'] 		= $row['SQFT'];
				$arrTemp['BathsFull'] 	= $row['BathsFull'];
				$arrTemp['Year']        = $row['YearBuilt'];
				$arrTemp['Pic'] 		= $row['MainPicture'];
				$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];
				$arrTemp['OfficeName']	= $row['Office_Name'];
				$arrTemp['PhotoBaseUrl']= $PhotoBaseUrl;
				$arrTemp['TotalPhotos']	= $row['TotalPhotos'];
				$arrTemp['Photos'] 		= isset($row['PhotoAll'])?$row['PhotoAll']:'';
				$arrTemp['status']      = $row['ListingStatus'];
				$arrTemp['DOM']         = $row['DOM'];
				$arrTemp['UnitNo']         = $row['UnitNo'];
				$arrTemp['StreetName']   = $row['StreetName'];
				$arrTemp['StreetSuffix'] = $row['StreetSuffix'];
				$arrTemp['Parking']     = $row['Parking'];
				$arrTemp['subdiv']     = $row['Subdivision'];
				$arrTemp['virtual_tour_url']     = $row['VirtualTourUrl'];

				array_push($arr['map-data'], $arrTemp);
			}
		}
		//echo '<pre>';print_r($arrTemp);exit();
		if(count($arr['map-data']) > 0)
		{
			$arr['map-data'] = base64_encode(gzencode(json_encode($arr['map-data'])));
		}
		else
		{
			$arr['map-data'] = '';
		}

		$arr['total_record'] = $this->total_record;
		$arr['PhotoBaseUrl'] = $this->Pic_Path;

		if(!isset($POST['sitemap']))
			$arr['MLS_last_update_date'] = MLS_TRESTLE::obj()->mlsRecord['mls_prop_last_run_date'];

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByParam
	#-------------------------------------------------------------------------------------------------------------------------
	function getListingByParam($POST)
	{
        //echo '<pre>';print_r($POST);exit();
		global $db, $virtual_path, $config, $asset;

		/*$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);

		if (!isset($POST['isAjax']))
		{
			if (isset($POST['pk']) && $POST['pk'] != '')
			{
				$cacheQuery = $redis->get('ps_'.$POST['pk']);
			}
		}

		if($cacheQuery)
		{
			return unserialize($cacheQuery);
		}
		else
		{*/
			$addParameters = $this->getQueryParameters($POST);

			$POST[P_SIZE] = isset($POST[P_SIZE]) ? $POST[P_SIZE] : RESULT_PAGESIZE;

			$sql =	" SELECT count(*) as cnt ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" INNER JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

			$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

			$sql .= " WHERE 1 AND MM.mls_active = 'Yes' ".$addParameters;
			//file_put_contents('lpt_predefine_listing.txt',print_r($sql,true));
			//echo $sql;exit();
			$rs = $db->query($sql);
			$rs->next_record();

			$this->total_record = $rs->f("cnt");
			$rs->free();

			if (!isset($POST['allRecord']))
			{
				if((isset($POST[S_RECORD]) && $POST[S_RECORD] >= $this->total_record) || $POST[P_SIZE] >= $this->total_record || !isset($POST[S_RECORD]))
					$POST[S_RECORD] = 0;
			}

			if (isset($POST[V_TYPE]) && $POST[V_TYPE]==VT_LIST)
			{
				$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported,M.SystemName, M.ListPrice, M.PropertyType, M.SubType, M.Beds,M.Baths,M.BathsFull,M.BathsHalf,M.Garage,M.Main_Photo,M.Main_Photo_Url, ".
					" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, LastUpdateDate,  M.OriginalListPrice, M.Price_Diff,".
					" M.YearBuilt, TotalPhotos,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, AI.Sold_Price, AI.Sold_Date,AI.VirtualTourUrl,".
					" A.StreetNumber, M.ListingStatus, A.StreetName, A.Area, A.CityName, A.State, ZipCode, DisplayAddress,".
					" O.Office_Name,M.TotalAcreage, ".
					" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude ";


				if($POST[SO] == 'ppsf')
				{
					$sql.= " ,(ListPrice/SQFT) AS PPSF";
				}
				if($POST[SO] == 'lsuc')
				{
					$sql.= " , ( CASE
					WHEN M.`ListingStatus` = 'ActiveUnderContract' THEN 0
					WHEN M.`ListingStatus` = 'Pending' THEN 1
					ELSE 2
						END) AS LSUC";
				}
				if($POST[SO] == 'cosfr')
				{
					$sql.= " , ( CASE
					WHEN M.`SubType` = 'Condominium' THEN 0
					WHEN M.`SubType` = 'SingleFamilyResidence' THEN 1
					ELSE 2
						END) AS COSFR";
				}
				if(isset($POST['ShowMiles']) && $POST['ShowMiles'] && $POST['latitude'])
					$sql .= ",( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['latitude']." / 57.2958 ) * COS( ".$POST['longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) AS Miles";
			}
			elseif (isset($POST[V_TYPE]) && $POST[V_TYPE]==VT_MAP)
			{

				$sql =  " SELECT M.MLS_NUM,  ListingKey, mls_is_pic_url_supported, M.ListPrice, M.PropertyType, M.SubType, M.Beds,M.Baths,M.BathsFull,M.BathsHalf,M.Main_Photo, M.Pic_Download_Flag2,M.Main_Photo_Url, ".
					" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, LastUpdateDate, M.ListingDate, M.PriceChangeDate, M.OriginalListPrice, M.Price_Diff, ".
					" M.YearBuilt,A.Subdivision,M.ListingStatus,M.SystemName,TotalPhotos,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, AI.Sold_Price, AI.Sold_Date,AI.VirtualTourUrl,".
					" A.StreetNumber, A.StreetName, A.Area, A.CityName,A.County, A.State, ZipCode, DisplayAddress,Address,".
					" O.Office_Name, M.TotalAcreage,Category,Garage,".
					" A.StreetDirection, StreetSuffix, StreetDirPrefix,UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude ";

				if($POST[SO] == 'ppsf')
				{
					$sql.= " ,(ListPrice/SQFT) AS PPSF";
				}
				if($POST[SO] == 'lsuc')
				{
					$sql.= " , ( CASE
					WHEN M.`ListingStatus` = 'ActiveUnderContract' THEN 0
					WHEN M.`ListingStatus` = 'Pending' THEN 1
					ELSE 2
						END) AS LSUC";
				}
				if($POST[SO] == 'cosfr')
				{
					$sql.= " , ( CASE
					WHEN M.`SubType` = 'Condominium' THEN 0
					WHEN M.`SubType` = 'SingleFamilyResidence' THEN 1
					ELSE 2
						END) AS COSFR";
				}

			}
			elseif (isset($POST[V_TYPE]) && $POST[V_TYPE]==VT_SITE_MAP)
			{
				$sql =  " SELECT M.MLS_NUM, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, M.PropertyType, LastUpdateDate,M.SystemName, M.Beds,M.Baths,M.ListPrice, M.SQFT, M.Main_Photo_Url, Category, mls_is_pic_url_supported, IF(M.`PropertyType` = 'Land and Lots', 1, 0) AS PT, IF(M.`ListingStatus` = 'ActiveUnderContract', 0, IF(M.`ListingStatus` = 'Pending', 1,2)) AS LSUC, ".
					" A.StreetNumber, A.StreetName, Address, A.StreetDirection, StreetDirPrefix,A.Area, A.CityName, A.State, A.County, ZipCode, UnitNo, DisplayAddress ";
			}
			else
			{
				$sql =  " SELECT M.*, mls_is_pic_url_supported, M.PropertyType, M.Description,M.SystemName, M.SubType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM,".
					" Parking, Garage, A.StreetNumber, A.StreetName, Address, A.Area, A.CityName, A.County, A.State, ZipCode,AI.Sold_Price, AI.Sold_Date, A.Subdivision, AI.VirtualTourUrl,".
					" A.StreetDirection,  StreetSuffix, UnitNo, StreetDirPrefix,A.Latitude, A.Longitude, Main_Photo, Category, O.Office_Name ";

				if($POST[SO] == 'ppsf')
				{
					$sql.= " ,(ListPrice/SQFT) AS PPSF";
				}
				if($POST[SO] == 'lsuc')
				{
					$sql.= " , ( CASE
					WHEN M.`ListingStatus` = 'ActiveUnderContract' THEN 0
					WHEN M.`ListingStatus` = 'Pending' THEN 1
					ELSE 2
						END) AS LSUC";
				}
			}

			$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
				" INNER JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

			$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

			$sql .= " WHERE 1 AND MM.mls_active = 'Yes' ".$addParameters;

			if (isset($POST['sort_order_list']) && count($POST['sort_order_list']) > 0)
			{
				$field_order='';
				foreach ($POST['sort_order_list'] as $field => $order)
				{
					$field_order .= $field." ".$order.",";
				}

				$field_order = rtrim($field_order,",");

				$sql .= " ORDER BY ".$field_order;
			}
			else
			{
				if(defined("IN_ADMIN"))
				{
					$sql .=	" ORDER BY ". ((isset($POST[SO]) && $POST[SO] != '')? $POST[SO] :'Subdivision').' '.((isset($POST[SD]) && $POST[SD] != '')? $POST[SD] :'DESC');

				}
				else
				{
					$param = '';
					$sql .=	' ORDER BY '. $param .(isset($POST[SO]) && $POST[SO] != ''? ($POST[SO] == 'location' ? 'StreetName' : $asset['OL_SORTBY_LOOKUP_ARRAY'][$POST[SO]]) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.(isset($POST[SD]) && $POST[SD] != ''? $POST[SD] :DEFAULT_SD);
				}
			}


			if (!$POST['allRecord'])
				$sql .=  " LIMIT ". $POST[S_RECORD]. ", ". $POST[P_SIZE];

			if(isset($_GET['print']) && $_GET['print'] == true)
			{
				echo $sql; exit;
			}

			//echo '<pre>';echo '<pre>';
			//echo $sql;
	//		file_put_contents('query.txt',print_r($sql,true));

			# Show debug in fo
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			$arr = array();
			$arr['rs'] = array();
			$arr['map-data'] = array();
			$asset['mlsPhotoType'] = array();
			$asset['mlsPhotoType']		= 	array	( 'large' 	=>	'Hi-resolution Photo',
			);

			# To Get creadential for image loading from amzon s3.
			$s3 = AWS_S3::obj()->aws_s3_get_credential();
			while($rs->next_record())
			{
				$row = $rs->Record;

				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					foreach ($asset['mlsPhotoType'] as $phototype=>$des){
						$row['MainPicture'][$phototype]['url'] = $row['Main_Photo_Url'];
					}
					if(!isset($row['MainPicture']['thumb']) && isset($row['MainPicture']['large'])){
						$row['MainPicture']['thumb'] = $row['MainPicture']['large'];
					}
	//				$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
				}
				else
				{
					$pic_no = $row['Main_Photo']-1;

					$MLS_NUM = $row['MLS_NUM'];
					$pic_url = $MLS_NUM.'_'.$pic_no.'.jpg';

					$row['MainPicture'] = $this->Pic_Path.'/'.$row['ListingID_MLS']."/".$pic_no."/";
					//echo $row['MainPicture'];exit();

					if (strlen($MLS_NUM)>2)
						$aws_folder_path = substr($MLS_NUM,-2);
					else
						$aws_folder_path = $MLS_NUM;

					if($row['MLSP_ID'] == 2)
					{
						$row['MainPicture'] = $this->Pic_Path_Actris.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
						$MLSFolder = S3_BUCKET_FOLDER_ACTRIS;
					}
					else
					{
						$row['MainPicture'] = $this->Pic_Path_Trestle.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
						$MLSFolder = S3_BUCKET_FOLDER_TRESTLE;
					}

					# Checking exist image on amzon s3 using curl
					//$url_response = Utility::getInstance()->amazon_s3_url_exists($a);

					# Checking exist image on amazon s3 using aws sdk
					$aws_obj_path = $MLSFolder.'/'.$aws_folder_path.'/'.$MLS_NUM.'/'.$pic_url;
					$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_obj_path);

					if($obj_response == false)
					{
						$row['MainPicture'] = S3_BUCKET_URL.'/no-photo/no-property-img.jpg';
					}

				}

				if(isset($POST['getAllPhoto']))
				{
					if($row['mls_is_pic_url_supported'] == 'Yes')
					{
						$PicArr = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=false);

						$row['PhotoAll'] = $PicArr;
					}
					else
					{
						$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos'],false);
						$row['PhotoAll'] = $PicArr;
					}
				}
				/*if(isset($row['open_house_data']) && !empty($row['open_house_data']))
				{
					$arr_open = explode(',', $row['open_house_data']);
					$row['OpenHouse_Date'] = $arr_open[0];
					$row['OpenHouse_Begin'] = $arr_open[1];
					$row['OpenHouse_Close'] = $arr_open[2];
				}*/

				array_push($arr['rs'], $row);
				$row['formatURL'] = $POST['formatURL'];

				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$PhotoBaseUrl = $this->Pic_Path;
				}
				elseif($row['mls_is_pic_url_supported'] == 'No')
				{
					if($row['MLSP_ID'] == 2)
						$PhotoBaseUrl = $this->Pic_Path_Actris;
					else
						$PhotoBaseUrl = $this->Pic_Path_Trestle;
				}
				else
				{
					$PhotoBaseUrl = S3_BUCKET_URL;
				}

				if(isset($POST['getMapData'])/* && $row['Latitude'] > 0*/)
				{
					$rsAttributes = Utility::getInstance()->generateListingAttributes($row);

					$arrTemp = array();
					$arrTemp['Key'] 		= $row['ListingID_MLS'];
					$arrTemp['MLS'] 		= $row['MLS_NUM'];
					$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
					$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
					$arrTemp['AddressSort'] = $rsAttributes['AddressSort'];
					$arrTemp['Desc'] 	    = $row['Description'];
					$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
					$arrTemp['Lat'] 		= $row['Latitude'];
					$arrTemp['Long'] 		= $row['Longitude'];
					$arrTemp['CityName'] 	= $row['CityName'];
					$arrTemp['State'] 		= $row['State'];
					$arrTemp['ZipCode'] 	= $row['ZipCode'];
					$arrTemp['Price'] 		= $row['ListPrice'];
					$arrTemp['Price_Diff_per'] 		= $row['Price_Diff'];
					$arrTemp['OriginalListPrice'] = $row['OriginalListPrice'];
					$arrTemp['PriceDiffValue'] =  $row['ListPrice'] - $row['OriginalListPrice'];
					$arrTemp['SoldPrice'] 	= $row['Sold_Price'];
					$arrTemp['Type']        = $row['PropertyType'];
					$arrTemp['SubType']     = $row['SubType'];
					$arrTemp['Bed'] 		= $row['Beds'];
					$arrTemp['Bath'] 		= rtrim(rtrim($row['Baths'],'0'),'.');
					$arrTemp['Sqft'] 		= $row['SQFT'];
					$arrTemp['BathsFull'] 	= $row['BathsFull'];
					$arrTemp['Year']        = $row['YearBuilt'];
					$arrTemp['Pic'] 		= $row['MainPicture'];

					$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];
					$arrTemp['OfficeName']	= $row['Office_Name'];
					$arrTemp['PhotoBaseUrl']= $PhotoBaseUrl;
					$arrTemp['TotalPhotos']	= $row['TotalPhotos'];
					$arrTemp['Photos'] 		= isset($row['PhotoAll'])?$row['PhotoAll']:'';
					$arrTemp['status']      = $row['ListingStatus'];
					$arrTemp['DOM']         = $row['DOM'];
					$arrTemp['UnitNo']         = $row['UnitNo'];
					$arrTemp['StreetName']   = $row['StreetName'];
					$arrTemp['StreetSuffix'] = $row['StreetSuffix'];
					$arrTemp['Parking']     = $row['Parking'];
					$arrTemp['subdiv']     = $row['Subdivision'];
					$arrTemp['virtual_tour_url']     = $row['VirtualTourUrl'];

					array_push($arr['map-data'], $arrTemp);
				}
			}

			if(count($arr['map-data']) > 0)
			{
				$arr['map-data'] = base64_encode(gzencode(json_encode($arr['map-data'])));
			}
			else
			{
				$arr['map-data'] = '';
			}


			$arr['total_record'] = $this->total_record;
			$arr['PhotoBaseUrl'] = $this->Pic_Path;

			/*if(isset($POST['sys_name']) && $POST['sys_name'] == Constants::MLS_ACTRIS)
				$arr['MLS_last_update_date'] = MLS_ACTRIS::obj()->mlsRecord['mls_prop_last_run_date'];
			else*/
				$arr['MLS_last_update_date'] = MLS_TRESTLE::obj()->mlsRecord['mls_prop_last_run_date'];

			/*if (!isset($POST['isAjax']))
			{
				if (isset($POST['pk']) && $POST['pk'] != '')
				{
					$redis->set('ps_' . $POST['pk'], serialize($arr));
					$redis->expire('ps_' . $POST['pk'], 3600);
				}

			}*/

			return $arr;
		/*}*/
	}

	#=========================================================================================================================
	#	Function Name	:   getListingByParamforSaveSearch
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingByParamforSaveSearch($POST)
	{
		global $db, $virtual_path, $config, $asset;

		$addParameters = $this->getQueryParameters($POST);

		if(isset($POST['IsnewOrPriceChange']) && $POST['IsnewOrPriceChange'] == true)
		{
			$addParameters .= " AND ( M.ListingDate = CURRENT_DATE() OR ( ( M.Price_Diff != '' OR M.Price_Diff != 0) AND M.ListPrice != M.Old_Price) )";
		}
		$POST[P_SIZE] = $POST[P_SIZE] ? $POST[P_SIZE] : RESULT_PAGESIZE;

		$sql =	" SELECT count(*) as cnt ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

		$sql .= " WHERE ( 1 ".$addParameters.")";

		$rs = $db->query($sql);
		$rs->next_record();

		$this->total_record = $rs->f("cnt") ;
		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST[S_RECORD] >= $this->total_record || $POST[P_SIZE] >= $this->total_record || !isset($POST[S_RECORD]))
				$POST[S_RECORD] = 0;
		}

		$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.PropertyType, M.SubType, M.Beds,M.Baths,M.Main_Photo,M.Old_Price,M.Price_Diff,M.Main_Photo_Url,".
			" M.BathsFull, M.BathsHalf, M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,M.ListingDate, ".
			" M.YearBuilt, Subdivision, M.Description, TotalPhotos, Parking,M.Is_OpenHouse,M.Is_ShortSale,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, ".
			" A.StreetNumber, M.ListingStatus, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix, A.CityName, A.State, ZipCode, DisplayAddress,".
			" O.Office_Name,M.TotalAcreage,  IF(M.`PropertyType` = 'Land and Lots', 1, 0) AS PT, ".
			" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName, CONCAT(AG2.Agent_FName, ' ', AG2.Agent_LName) AS CoAgent_FullName, MM.mls_disclaimer_big";
		if(isset($POST['ShowMiles']) && $POST['latitude'])
			$sql .= ",( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['latitude']." / 57.2958 ) * COS( ".$POST['longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) AS Miles";

		$sql .=
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";
		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ".
			" LEFT JOIN ". $this->Data['Agent_Table']." AS AG2 ON M.CoAgent_ID  = AG2.Agent_ID  AND M.MLSP_ID = AG2.Agent_MLSP_ID ";

		$sql .= " WHERE ( 1 ".$addParameters.") ";

		if (is_countable($POST['sort_order_list']) && count($POST['sort_order_list']) > 0 )
		{
			$field_order='';
			foreach ($POST['sort_order_list'] as $field => $order)
			{
				$field_order .= $field." ".$order.",";
			}

			$field_order = rtrim($field_order,",");

			$sql .= " ORDER BY ".$field_order;
		}
		else
		{
			if(defined("IN_ADMIN"))
			{
				$sql .=	" ORDER BY ". ($POST[SO] != ''? $POST[SO] :'Subdivision').' '.($POST[SD] != ''? $POST[SD] :'DESC');
			}
			else
			{
				$sql .= 'ORDER BY PT ASC, ';
				$sql .=	($POST[SO] != ''? ($POST[SO] == 'location' ? 'Subdivision' : $asset['OL_SORTBY_LOOKUP_ARRAY'][$POST[SO]]) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.($POST[SD] != ''? $POST[SD] :DEFAULT_SD);
			}
		}


		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST[S_RECORD]. ", ". $POST[P_SIZE];


		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$arr = array();
		$arr['rs'] = array();
		$asset['mlsPhotoType'] = array();
		$asset['mlsPhotoType']		= 	array	( 'large' 	=>	'Hi-resolution Photo',
		);
		$s3 = AWS_S3::obj()->aws_s3_get_credential();
		while($rs->next_record())
		{
			$row = $rs->Record;

			if($POST[V_TYPE] != VT_SITE_MAP)
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
                    foreach ($asset['mlsPhotoType'] as $phototype=>$des){
                        $row['MainPicture'][$phototype]['url'] = $row['Main_Photo_Url'];
                    }
                    if(!isset($row['MainPicture']['thumb']) && isset($row['MainPicture']['large'])){
                        $row['MainPicture']['thumb'] = $row['MainPicture']['large'];
                    }
//					$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
				}
				else
				{
					$pic_no = $row['Main_Photo']-1;
					//$row['MainPicture'] = $this->Pic_Path."/".$row['ListingID_MLS']."/".array_search($row['SubType'],$asset['OL_PROPERTY_TYPE_LOOKUP']).'/'.$pic_no."/";

					$MLS_NUM = $row['MLS_NUM'];
					$pic_url = $MLS_NUM.'_'.$pic_no.'.jpg';


					if (strlen($MLS_NUM)>2)
						$aws_folder_path = substr($MLS_NUM,-2);
					else
						$aws_folder_path = $MLS_NUM;

					if($row['MLSP_ID'] == 2)
					{
						$row['MainPicture'] = $this->Pic_Path_Actris.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
						$MLSFolder = S3_BUCKET_FOLDER_ACTRIS;
					}
					else
					{
						$row['MainPicture'] = $this->Pic_Path_Trestle.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
						$MLSFolder = S3_BUCKET_FOLDER_TRESTLE;
					}

					# Checking exist image on amazon s3 using aws sdk
					$aws_obj_path = $MLSFolder.'/'.$aws_folder_path.'/'.$MLS_NUM.'/'.$pic_url;
					$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_obj_path);

					if($obj_response == false)
					{
						$row['MainPicture'] = S3_BUCKET_URL.'/no-photo/no-property-img.jpg';
					}
				}
			}

			array_push($arr['rs'], $row);
		}

		$arr['total_record'] = $this->total_record;
		$arr['PhotoBaseUrl'] = $this->Pic_Path;

		return $arr;
	}

	#=========================================================================================================================
	#	Function Name	:   getListingForReport
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingForReport($POST)
	{
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$sql =	" SELECT count(DISTINCT M.MLS_NUM) as cnt ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		$rs = $db->query($sql);

		$rs->next_record();

		$this->total_record = $rs->f("cnt") ;

		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST[S_RECORD] >= $this->total_record || $POST[P_SIZE] >= $this->total_record || !isset($POST[S_RECORD]))
				$POST[S_RECORD] = 0;
		}

		$sql = " SELECT M.*, PropertyType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, Category,"
			. " Parking, Garage, A.StreetName, Address, A.StreetNumber, A.StreetDirection, StreetSuffix, UnitNo, ZipCode, A.CityName, A.County, A.State,"
			. " A.Latitude, A.Longitude, O.Office_Name, AG.Agent_FName, AG.Agent_LName";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID ".
			" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Order By
		$sql .= " ORDER BY ". ($POST[SO] != ''? $POST[SO] :DEFAULT_SO).' '.($POST[SD] != ''? $POST[SD] :DEFAULT_SD);

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST[S_RECORD]. ", ". $POST[P_SIZE];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql, true);

		$arr = array();

		$arr['rs'] = $rs->fetch_array();

		foreach($arr['rs'] as $key => $row)
		{
			$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos']);

			$arr['rs'][$key]['PictureArr'] 		= $PicArr;
			$arr['rs'][$key]['PrintPictureArr'] = $PicArr;

			# Set String in Proper Case
			if(isset($row['StreetName']) && $row['StreetName'] != '')
				$arr['rs'][$key]['StreetName'] = ucwords(strtolower($row['StreetName']));
		}

		$arr['total_record'] = $this->total_record;

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByParam
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingByParam2($POST)
	{
		global $db, $virtual_path,$config;

		$sql = '';
		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.MLS_NUM, mls_is_pic_url_supported, M.ListPrice, M.ListPrice, Subdivision,  M.PropertyType, M.PropertyStyle, M.Beds, M.BathsFull,".
			" M.BathsHalf, M.SQFT, M.TotalAcreage, Main_Photo, M.Main_Photo_Url, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, Category, Parking, Garage,".
			" round(M.ListPrice*100/M.ListPrice) AS LP_Over_OP,".
			" round(M.ListPrice/M.SQFT) AS Price_Per_Sqft,".
			" A.StreetNumber, A.StreetName, Address, A.CityName, A.County, A.State, ZipCode, DisplayAddress,".
			" A.StreetDirection, StreetSuffix, UnitNo, M.YearBuilt, M.Description, DATEDIFF(CURDATE(), LastUpdateDate) AS DayOnMarket,".
			" Price_Diff, Is_OpenHouse,DATEDIFF(CURDATE(), ListingDate) AS ListedBefore, (DATE_FORMAT(CURDATE(), '%Y')-YearBuilt) AS YearDiff".

			$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Set Order
		if(isset($POST['order_by']))
			$sql .= " ORDER BY ".$POST['order_by'];

		# Set Limit
		if(isset($POST['limit']))
			$sql .= " LIMIT 0, ".$POST['limit'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		$arr['rs'] = array();

		while($rs->next_record())
		{
			$row = $rs->Record;

			if($row['mls_is_pic_url_supported'] == 'Yes')
			{
				$row['MainPicture'] = $row['Main_Photo_Url'];
//				$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=true);
			}
			else
			{
				$pic_no = $row['Main_Photo']-1;
				//$row['MainPicture'] = $virtual_path['Data_MDN_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
				$row['MainPicture'] = $this->Pic_Path."/".$row['ListingID_MLS']."/".$pic_no;

			}

			if(isset($POST['Is_KeyValueArray']))
				$arr['rs'][$row['ListingID_MLS']] = $row;
			else
				array_push($arr['rs'], $row);
		}

		$arr['PhotoBaseUrl'] = $this->Pic_Path;

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingForWatchAlert
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingForWatchAlert($POST)
	{
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.MLS_NUM, M.ListPrice, lpwatch_price, M.PropertyType, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,".
			" Subdivision, Main_Photo, Category, Parking, Garage,".
			" A.StreetNumber, A.StreetName, Address, A.StreetDirection, A.CityName, A.County, A.State, ZipCode, DisplayAddress".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['PriceWatch_Table']." AS PW ON M.MLS_NUM = PW.lpwatch_mls_num AND M.MLSP_ID = PW.lpwatch_mlsp_id AND lpwatch_user_id = '".$POST['user_id']."'".
			" WHERE lpwatch_price != ListPrice ".$addParameters;

		# Order By
		$sql .= " ORDER BY ListPrice DESC";


		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql, true);

		$arr = array();

		$arr['rs'] = $rs->fetch_array();

		foreach($arr['rs'] as $key => $row)
		{
			$pic_no = $row['Main_Photo']-1;
			$arr['rs'][$key]['MainPicture'] = $virtual_path['Data_MDN_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;

			# Set String in Proper Case
			if(isset($row['StreetName']) && $row['StreetName'] != '')
				$arr['rs'][$key]['StreetName'] = ucwords(strtolower($row['StreetName']));
		}

		$arr['total_record'] = count($arr['rs']);

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingForWatchList
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingForWatchList($POST)
	{
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.*, lpwatch_price, lpwatch_date_time, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,".
			" Subdivision, A.StreetNumber, A.StreetName, Address, A.StreetDirection, A.CityName, A.County, A.State, ZipCode,".
			" Price_Diff, Is_OpenHouse, DATEDIFF(CURDATE(), ListingDate) AS ListedBefore, (DATE_FORMAT(CURDATE(), '%Y')-YearBuilt) AS YearDiff".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['PriceWatch_Table']." AS PW ON M.MLS_NUM = PW.lpwatch_mls_num AND M.MLSP_ID = PW.lpwatch_mlsp_id AND lpwatch_user_id = '".$POST['user_id']."'".
			" WHERE 1".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);


		$rs = $db->query($sql, true);

		$arr = array();

		$arr['rs'] = $rs->fetch_array();

		foreach($arr['rs'] as $key => $row)
		{
			$pic_no = $row['Main_Photo']-1;
			$arr['rs'][$key]['MainPicture'] = $virtual_path['Data_MDN_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;

			# Set String in Proper Case
			if(isset($row['StreetName']) && $row['StreetName'] != '')
				$arr['rs'][$key]['StreetName'] = ucwords(strtolower($row['StreetName']));
		}

		$arr['total_record'] = count($arr['rs']);

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getMlsNoByParam
	#-------------------------------------------------------------------------------------------------------------------------
	public function getMlsNoByParam($POST)
	{

		global $db;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.MLS_NUM, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, ListPrice";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getDistinctMarketIdByParam
	#-------------------------------------------------------------------------------------------------------------------------
	public function getDistinctMarketIdByParam($POST)
	{
		global $db;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT DISTINCT(M.MLSP_ID)".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arrIds = array();

		while($rs->next_record())
		{
			array_push($arrIds, $rs->f('MLSP_ID'));
		}

		$strIds = implode(',', $arrIds);

		return $strIds;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingStatisticByParam
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingStatisticByParam($POST)
	{
		global $db;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT MIN(M.Beds) As MinBeds, MAX(M.Beds) As MaxBeds, round(AVG(M.Beds)) As AvgBeds,".
			" MIN(M.BathsFull) As MinBathsFull, MAX(M.BathsFull) As MaxBathsFull, round(AVG(M.BathsFull)) As AvgBathsFull,".
			" MIN(M.BathsHalf) As MinBathsHalf, MAX(M.BathsHalf) As MaxBathsHalf, round(AVG(M.BathsHalf)) As AvgBathsHalf,".
			" MIN(M.Parking) As MinParking, MAX(M.Parking) As MaxParking, round(AVG(M.Parking)) As AvgParking,".
			" MIN(M.SQFT) As MinSQFT, MAX(M.SQFT) As MaxSQFT, round(AVG(M.SQFT)) As AvgSQFT,".
			" MIN(M.TotalAcreage) As MinTotalAcreage, MAX(M.TotalAcreage) As MaxTotalAcreage, round(AVG(M.TotalAcreage)) As AvgTotalAcreage,".
			" MIN(M.YearBuilt) As MinYearBuilt, MAX(M.YearBuilt) As MaxYearBuilt, round(AVG(M.YearBuilt)) As AvgYearBuilt,".
			" MIN(M.ListPrice) As MinListPrice, MAX(M.ListPrice) As MaxListPrice, round(AVG(M.ListPrice)) As AvgListPrice,".
			" MIN(round(M.ListPrice/M.SQFT)) As MinPrice_Per_Sqft, MAX(round(M.ListPrice/M.SQFT)) As MaxPrice_Per_Sqft, round(AVG(M.ListPrice/M.SQFT)) As AvgPrice_Per_Sqft,".
			" MIN(M.ListPrice) As MinListPrice, MAX(M.ListPrice) As MaxListPrice, round(AVG(M.ListPrice)) As AvgListPrice";
		//" MIN(round(M.ListPrice*100/M.ListPrice)) As MinLP_Over_OP, MAX(round(M.ListPrice*100/M.ListPrice)) As MaxLP_Over_OP, round(AVG(round(M.ListPrice*100/M.ListPrice))) As AvgLP_Over_OP";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByID
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingByID($POST)
	{
		global $db, $virtual_path,$config, $asset;

		/*$redis = new Redis();
		$redis->connect('127.0.0.1');
		$cacheResponse = $redis->get('mls_'.$POST['ListingID_MLS']);

		if($cacheResponse)
		{
			return unserialize($cacheResponse);
		}
		else
		{*/
			if (!isset($POST['ListingID_MLS']) || (isset($POST['ListingID_MLS']) && $POST['ListingID_MLS'] == ''))
				return true;

		$arrMLS = explode("-",$POST['ListingID_MLS']);

		$sql = " SELECT M.*, AI.*, mls_is_pic_url_supported, mls_disclaimer_big, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,"
			. " A.Area, A.StreetName, Address, A.StreetNumber, A.StreetDirection, A.StreetDirPrefix, StreetSuffix, UnitNo, A.ZipCode, A.CityName, A.County, A.State, A.Subdivision,"
			. " A.Latitude, A.Longitude, O.Office_Name, O.Office_Phone,"
			. " CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName,"
			. " Price_Diff, DATEDIFF(CURDATE(), ListingDate) AS ListedBefore, (DATE_FORMAT(CURDATE(), '%Y')-YearBuilt) AS YearDiff,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, MM.mls_prop_last_run_date ";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" INNER JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" INNER JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ".
			" INNER JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
			" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ";

		$sql .= " WHERE M.is_mark_for_deletion = 'N' AND M.MLS_NUM = '".$arrMLS[0]. "' AND M.MLSP_ID = '".$arrMLS[1]."' ";
        //file_put_contents('lpt.txt',print_r($sql,true));

		if(isset($POST['ActiveListingFlag']))
		{
			if(isset($this->picPath['InActive_MLSP_ID']) && $this->picPath['InActive_MLSP_ID'] != '')
				$sql	 .=	" AND M.MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";
		}
        //file_put_contents($sql);exit();

		$rec = $db->query($sql);

		$rs = array();

		if($rec->TotalRow > 0)
		{
			$rs = $rec->fetch_array(MYSQLI_FETCH_SINGLE);
		}

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$asset['mlsPhotoType']		= 	array	( 'large' 	=>	'Hi-resolution Photo',
		);
		if(is_array($rs) && count($rs)>0)
		{
			if(!isset($POST['PicArr']) || (isset($POST['PicArr']) && $POST['PicArr'] !== false))
			{
				if($rs['mls_is_pic_url_supported'] == 'Yes')
				{
					$PicArr = $this->getPicArray2($rs['ListingKey'], $rs['MLSP_ID']);
					$rs['PictureArr'] = $PicArr;
				}
				else
				{
					$PicArr = $this->getPicArray($rs['ListingID_MLS'], $rs['TotalPhotos'], false);
					$rs['PictureArr'] = $PicArr;
				}
			}
			else
			{
				if($rs['mls_is_pic_url_supported'] == 'Yes')
				{
                    foreach ($asset['mlsPhotoType'] as $phototype=>$des){
                        $rs['MainPicture'][$phototype]['url'] = $rs['Main_Photo_Url'];
                    }
                    if(!isset($rs['MainPicture']['thumb']) && isset($rs['MainPicture']['large'])){
                        $rs['MainPicture']['thumb'] = $rs['MainPicture']['large'];
                    }
//					$rs['MainPicture'] = $this->getPicArray2($rs['ListingKey'], $rs['MLSP_ID'], $getMainPic=true);
				}
				else
					//$rs['MainPicture'] = $virtual_path['Data_MDN_Url']."/pictures/property/".$rs['ListingID_MLS']."/0";
					$PicArr = $this->getPicArray($rs['ListingID_MLS'], $rs['TotalPhotos'], false);
					$rs['PictureArr'] = $PicArr;

			}

			$rs['PhotoBaseUrl'] = $this->Pic_Path;
			/*if($rs['mls_is_pic_url_supported'] == 'Yes')
			{
				$rs['PhotoBaseUrl'] = $this->Pic_Path;
			}
			elseif($rs['mls_is_pic_url_supported'] == 'No' && is_array($rs['PictureArr']) && count($rs['PictureArr']) > 0)
			{
				if($rs['MLSP_ID'] == 2)
					$rs['PhotoBaseUrl'] = $this->Pic_Path_Actris;
				else
					$rs['PhotoBaseUrl'] = $this->Pic_Path_Trestle;
			}
			else
			{
				$rs['PhotoBaseUrl'] = S3_BUCKET_URL;
			}*/

			if(isset($rs['Is_OpenHouse']) && $rs['Is_OpenHouse'] == 'Y')
			{
				// Get Open House Detail
				$arrOpenHouse = $this->getOpenHouseData($rs['ListingID_MLS'],'', 3);

				if(is_array($arrOpenHouse))
				{
					$rs['arrOpenHouse'] = $arrOpenHouse;
				}
			}

			}
			//file_put_contents('lpt.txt',print_r($sql,true));

			/*$redis->set('mls_' . $POST['ListingID_MLS'], serialize($rs));
			$redis->expire('mls_' . $POST['ListingID_MLS'], 60);*/

			return $rs;
		/*}*/
	}
	public function getPropertyHistory($mls_no, $mlsp_no=1)
	{
		global $db, $config;

		$addParameters = " AND lplog_mls_num = '".$mls_no."' AND lplog_mlsp_id = ".$mlsp_no;
		$sql = "SELECT * FROM ".$this->Data['Listing_Price_Log']." PL WHERE 1 ".$addParameters;

		$sql .= " ORDER BY lplog_date desc";

		if(DEBUG)
			$this->__debugMessage($sql);

		$rec = $db->query($sql);

		$rs = $rec->fetch_array(MYSQLI_ASSOC);

		return $rs;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByMlsNum
	#-------------------------------------------------------------------------------------------------------------------------
	public function getRandomListingByMLSNum($POST)
	{
		global $db, $physical_path, $virtual_path, $asset;

		$addParameters = $this->getQueryParameters($POST);

		$param = '';
		$param .= $addParameters;

		if(isset($POST['MLS_NUM']) && $POST['MLS_NUM'] != '')
			$param .= " AND M.MLS_NUM IN('". $POST['MLS_NUM']. "') ";


		## Need Random Data, do it using PHP function, not by mysql // Added On 12 Aug 2010
		$start = 0;
		if($POST['Limit'] > 0 && $POST['OrderBy'] == '')
		{
			# Get Count
			/*$sql = " SELECT M.MLS_NUM".
				" FROM ". $this->Data['TableName']." AS M ".
				" INNER JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" WHERE 1 ".$param."";*/

			$sql = " SELECT count(*) as cnt "." FROM ".$this->Data['TriggerSearchByMapsearch']." AS M "." WHERE 1 ".$param;

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			$recCount = $rs->TotalRow;

			$rs->free();

			# If Count Of Matching Records more than given limit, set new start
			if($recCount > $POST['Limit'])
			{
				# Get Random no.
				$randNo = rand(1, $recCount);

				# Set Start For Limit
				$start = $recCount - $randNo;

				if(($start + $POST['Limit']) > $recCount)
				{
					$overCount = ($start + $POST['Limit']) - $recCount;

					$start = $start - $overCount;
				}
			}
		}

		/*$sql = " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.MLSP_ID, ListPrice, Beds, M.SubType,M.PropertyType,M.Baths,M.BathsFull,M.BathsHalf, M.Parking, M.Main_Photo_Url, ".
			" SQFT, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, DisplayAddress, ".
			" A.StreetName, Address, A.StreetNumber, A.StreetDirection, StreetSuffix, UnitNo, ZipCode, O.Office_Name, A.CityName, A.County, A.State, (DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, ".
			"ListingStatus, YearBuilt, A.Latitude, A.Longitude, Main_Photo ";*/

		$sql = " SELECT M.* ";

		if($POST['ShowMiles'] && $POST['latitude'])
			$sql .= ",( 6378.7 * ACOS( SIN( Latitude / 57.2958 ) * SIN( ".$POST['latitude']." / 57.2958 ) + COS( Latitude / 57.2958 ) * COS( ".$POST['latitude']." / 57.2958 ) * COS( ".$POST['longitude']." / 57.2958 - ( Longitude ) / 57.2958 ) ) ) AS Miles";

		$sql .= " FROM ".$this->Data['TriggerSearchByMapsearch']." AS M WHERE 1 ".$param;

		/*$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" INNER JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" INNER JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID";
		$sql .=	   " WHERE 1 ".$param."";*/

		if($POST['OrderBy'] != '')
			$sql .= " ORDER BY ".$POST['OrderBy']." LIMIT 0,".$POST['Limit'];
		elseif($POST['Limit'] != '')
			$sql .= " LIMIT $start,".$POST['Limit'];

		if(isset($_GET['print']) && $_GET['print'] == true)
		{
			echo $sql; exit;
		}
		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		$arr['rs'] = array();
		$asset['mlsPhotoType'] = array();
		$asset['mlsPhotoType']		= 	array	( 'large' 	=>	'Hi-resolution Photo',
		);
		$s3 = AWS_S3::obj()->aws_s3_get_credential();
		while($rs->next_record())
		{
			$row = $rs->Record;
			if(!isset($POST['pic_flag']) || $POST['pic_flag'] !== false)
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
                    foreach ($asset['mlsPhotoType'] as $phototype=>$des){
                        $row['MainPicture'][$phototype]['url'] = $row['Main_Photo_Url'];
                    }
                    if(!isset($row['MainPicture']['thumb']) && isset($row['MainPicture']['large'])){
                        $row['MainPicture']['thumb'] = $row['MainPicture']['large'];
                    }
//					$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);

				}
				else
				{
					$pic_no = $row['Main_Photo']-1;

					$MLS_NUM = $row['MLS_NUM'];
					$pic_url = $MLS_NUM.'_'.$pic_no.'.jpg';
					$row['MainPicture'] = $this->Pic_Path."/".$row['ListingID_MLS']."/".$pic_no."/";

					/*if (strlen($MLS_NUM)>2)
						$aws_folder_path = substr($MLS_NUM,-2);
					else
						$aws_folder_path = $MLS_NUM;

					if($row['MLSP_ID'] == 2)
					{
						$row['MainPicture'] = $this->Pic_Path_Actris.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
						$MLSFolder = S3_BUCKET_FOLDER_ACTRIS;
					}
					else
					{
						$row['MainPicture'] = $this->Pic_Path_Trestle.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
						$MLSFolder = S3_BUCKET_FOLDER_TRESTLE;
					}

					# Checking exist image on amazon s3 using aws sdk
					$aws_obj_path = $MLSFolder.'/'.$aws_folder_path.'/'.$MLS_NUM.'/'.$pic_url;
					$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_obj_path);

					if($obj_response == false)
					{
						$row['MainPicture'] = S3_BUCKET_URL.'/no-photo/no-property-img.jpg';
					}*/
				}

			}

			if(isset($row['Is_OpenHouse']) && $row['Is_OpenHouse'] == 'Y')
			{
				// Get Open House Detail
				$arrOpenHouse = $this->getOpenHouseData($row['ListingID_MLS']);

				if(is_array($arrOpenHouse))
				{
					$row['arrOpenHouse'] = $arrOpenHouse;
				}
			}

			array_push($arr['rs'], $row);
		}

		$arr['PhotoBaseUrl'] = $this->Pic_Path;
		return $arr;
	}
	/**
	 * IDXListing::GetDeletedListing()
	 *
	 * @param array $POST = required arguments in array format
	 * @return array of record
	 *
	 * It will get record for given arguments from deleted listing
	 * return that record in array format
	 */
	public function GetDeletedListing($POST)
	{
		global $db;

		if ($POST['ListingID_MLS']=='')
			return true;

		$sql = "SELECT * FROM ".$this->Data['Listing_Deleted']." LD
                WHERE UPPER(CONCAT(LD.MLS_NUM,'-',LD.MLSP_ID)) = '". strtoupper($POST['ListingID_MLS']). "'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rec = $db->query($sql);

		$rs = $rec->fetch_array(MYSQLI_FETCH_SINGLE);

		return $rs;
	}
	#=========================================================================================================================
	#	Function Name	:   _getPicArray
	#-------------------------------------------------------------------------------------------------------------------------
	public function _getPicArray($ListingID_MLS, $TotalPhotos, $printFlag=false,$pType='')
	{
		global $physical_path, $virtual_path, $config,$asset;
		$s3 = AWS_S3::obj()->aws_s3_get_credential();

		$retArr = array();
		$objArr = array();

		$arrID = explode("-",$ListingID_MLS);
		//echo print_r($arrID);
		$MLS_NUM	= $arrID[0];
		$MLSP_ID		= $arrID[1];

		if (strlen($MLS_NUM)>2)
			$folderName = substr($MLS_NUM,-2);
		else
			$folderName = $MLS_NUM;

		if(strpos($_SERVER['SERVER_NAME'],'.project') !== false)
		{
			$upload_path = $physical_path['Upload'];
		}else{
			$upload_path = $physical_path['Property_Upload'];
		}

		if($pType != ''){
			$pic_Path = $this->Pic_Path_Trestle."/".$folderName."/".array_search($pType,$asset['OL_PROPERTY_TYPE_LOOKUP'])."/". $MLS_NUM."/";

		}
		else{
			//$pic_Path = $upload_path.$this->picPath['MLS_Pic_Folder'][$MLSP_ID]."/".$folderName."/". $MLS_NUM."/";
			$pic_Path = $this->Pic_Path_Trestle."/".$folderName."/". $MLS_NUM."/";
			// print_r($pic_Path);exit();
		}
		# In for loop we need to check whether image is exist on s3 or not

		for($i=0; $i<$TotalPhotos; $i++)
		{
			//exit($TotalPhotos);
			;			$picFilePath = $pic_Path. $MLS_NUM. '_'. $i.'.jpg';
			$pic_url = $MLS_NUM. '_'. $i.'.jpg';

			if($pType != '')
			{
				//array_push($retArr, $this->Pic_Path_Trestle."/"."$folderName"."/".$MLS_NUM."/".array_search($pType,$asset['OL_PROPERTY_TYPE_LOOKUP'])."/".$pic_url."/");
				array_push($retArr, $pic_Path.array_search($pType,$asset['OL_PROPERTY_TYPE_LOOKUP'])."/".$pic_url."/");
				//echo '<pre>';print_r($retArr);exit('if');

			}
			else
			{$pic_url = $MLS_NUM. '_'. $i.'.jpg';
				array_push($objArr,S3_BUCKET_FOLDER_TRESTLE.'/'.$folderName.'/'.$MLS_NUM.'/'.$pic_url);
				// $aws_obj_path = S3_BUCKET_FOLDER_TRESTLE.'/'.$folderName.'/'.$MLS_NUM.'/'.$pic_url;

				$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$objArr[$i]);
				//var_dump($obj_response);exit();

				if($obj_response === false)
				{
					unset($objArr[$i]);
				}
			}
		}

		if(count($objArr) == 0)
		{
			$pic_Path= S3_BUCKET_URL.'/no-photo/no-property-img.jpg';
			array_push($retArr, $pic_Path);
		}
		else
		{
			array_push($retArr, $pic_Path.$pic_url);
		}
		return $retArr;
	}
	#====================================================================================================
	#	Picture Function
	#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   getPicArray
	#-------------------------------------------------------------------------------------------------------------------------
	public function getPicArray($ListingID_MLS, $TotalPhotos, $printFlag=false,$pType='')
	{
		global $physical_path, $virtual_path, $config,$asset;

		$retArr = array();

		$arrID = explode("-",$ListingID_MLS);
		//echo print_r($arrID);
		$MLS_NUM	= $arrID[0];
		$MLSP_ID		= $arrID[1];

		if (strlen($MLS_NUM)>2)
			$folderName = substr($MLS_NUM,-2);
		else
			$folderName = $MLS_NUM;

		if(strpos($_SERVER['SERVER_NAME'],'.project') !== false)
		{
			$upload_path = $physical_path['Upload'];
		}else{
			$upload_path = $physical_path['Property_Upload'];
		}

		if($pType != ''){
            $pic_Path = $upload_path. "/pictures/".$this->picPath['MLS_Pic_Folder'][$MLSP_ID]."/".$folderName."/".array_search($pType,$asset['OL_PROPERTY_TYPE_LOOKUP'])."/". $MLS_NUM."/";

        }
		else{
            $pic_Path = $upload_path. "/pictures/".$this->picPath['MLS_Pic_Folder'][$MLSP_ID]."/".$folderName."/". $MLS_NUM."/";
        }



		for($i=0; $i<$TotalPhotos; $i++)
		{
			$picFilePath = $pic_Path. $MLS_NUM. '_'. $i.'.jpg';
			if($pType != '')
				array_push($retArr, $this->Pic_Path."/".$ListingID_MLS."/".array_search($pType,$asset['OL_PROPERTY_TYPE_LOOKUP'])."/".$i."/");
			else
				array_push($retArr, $this->Pic_Path."/".$ListingID_MLS."/".$i."/");

		}

		return $retArr;
	}
	public function getPicArray__($ListingID_MLS, $TotalPhotos, $printFlag=false)
	{
		//echo $this->Pic_Path_Trestle;die;
		global $physical_path, $virtual_path, $config,$asset;

		$retArr = array();
		$s3     = AWS_S3::obj()->aws_s3_get_credential();
		$arrID  = explode("-",$ListingID_MLS);

		$MLS_NUM    = $arrID[0];
		$MLSP_ID	= $arrID[1];

		if (strlen($MLS_NUM)>2)
			$folderName = substr($MLS_NUM,-2);
		else
			$folderName = $MLS_NUM;

		if ($MLSP_ID == 2)
		{
			$path = $this->Pic_Path_Actris;
			$MLSFolder = S3_BUCKET_FOLDER_ACTRIS;
		}
		else
		{
			$path = $this->Pic_Path_Trestle;
			$MLSFolder = S3_BUCKET_FOLDER_TRESTLE;
		}


		for($i=0; $i<$TotalPhotos; $i++)
		{
			$pic        =   $MLS_NUM. '_'. $i.'.jpg';
			$pic_url    =   $path.'/'.$folderName.'/'.$MLS_NUM.'/'.$pic;
			$s3_obj     =   $MLSFolder.'/'.$folderName.'/'.$MLS_NUM.'/'.$pic;

			# Check object is exist or not
			$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$s3_obj);

			if($obj_response === true)
				array_push($retArr,$pic_url);
		}

		# Check if is there no photo available on s3 so set coming soon photo in array
//		 if(count($retArr) <= 0)
//         {
//             $no_pic_url    =   S3_BUCKET_URL.'/no-photo/no-property-img.jpg';
//             $retArr = array($no_pic_url);
//         }

		return $retArr;
	}
	#=========================================================================================================================
	#	Function Name	:   getPicArray2
	#-------------------------------------------------------------------------------------------------------------------------
	public function getPicArray2($MLS_NUM, $MLSP_ID, $getMainPic=false)
	{
		global $db, $asset;

		$arrReturn = array();

		foreach($asset['mlsPhotoType'] as $photoType=>$desc){

			$sql =	" SELECT photo_url as 'url' ".		// photo_caption as 'caption', photo_desc as 'desc',
				" FROM ". $this->Data['MLS_Photo_Table']." AS PH ".
				" WHERE MLS_NUM = '".$MLS_NUM."' ".
				"	AND MLSP_ID = '".$MLSP_ID."' ".
				"	AND photo_type = '".$photoType."' ".
				" ORDER BY photo_display_order ASC";

			if($getMainPic)
				$sql .= " LIMIT 0,1";

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			if($rs->num_rows() > 0)
			{
				$arrReturn[$photoType] = array();

				if($getMainPic)
				{
					$rs->next_record();
					$rs->Record['url'] = str_replace('&', '&amp;', $rs->Record['url']);
					$arrReturn[$photoType] = $rs->Record;
				}
				else
				{
					while($rs->next_record())
					{
						$rs->Record['url'] = str_replace('&', '&amp;', $rs->Record['url']);
						array_push($arrReturn[$photoType], $rs->Record);
					}
				}
			}
		}
		if(!isset($arrReturn['thumb']) && isset($arrReturn['large']))
			$arrReturn['thumb'] = $arrReturn['large'];

		return $arrReturn;
	}
	#=========================================================================================================================
	#	Function Name	:   getActivePicNo
	#	Purpose			:	Check MLS_NUM already exists or not
	#-------------------------------------------------------------------------------------------------------------------------
	public function getActivePicNo($ListingID_MLS, $TotalPhotos, &$pic_no, &$cpic)
	{
		global $physical_path, $config;

		$arrID = explode("-",$ListingID_MLS);

		$MLS_NUM	= $arrID[0];
		$MLSP_ID	= $arrID[1];

		if (strlen($MLS_NUM)>2)
			$folderName = substr($MLS_NUM,-2);
		else
			$folderName = $MLS_NUM;

		$pic_Path = $physical_path['Upload']. "/pictures/".$this->picPath['MLS_Pic_Folder'][$MLSP_ID]."/".$folderName."/". $MLS_NUM."/";

		if ((is_dir($pic_Path."custom/")) && ($MLSP_ID==0))
		{
			chdir($pic_Path."custom/");
			if (count(glob("*.*"))>0)
			{
				$pic_Path .= "custom/";
				$cpic = 1;
				$pic_no = 0;
			}
		}
		elseif (is_dir($pic_Path))
		{
			chdir($pic_Path);
			if (count(glob("*.*"))>0)
			{
				$picFilePath = $pic_Path. $MLS_NUM. '_'. $pic_no.'.jpg';
				if(!file_exists($picFilePath))
				{
					for($i=$pic_no; $i<=$TotalPhotos; $i++)
					{
						$picFilePath = $pic_Path. $MLS_NUM. '_'. $i.'.jpg';
						if(file_exists($picFilePath))
						{
							$pic_no = $i;
							break;
						}
					}
				}
			}
		}
	}

	#=========================================================================================================================
	#	Function Name	:   getListingCountByParam
	#	Purpose			:	Used by saved searches
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingCountByParam($POST)
	{


		global $db;

		$addParameters = '';
		$addParameters .= $this->getQueryParameters($POST);

		$sql =	" SELECT count(M.MLS_NUM) as cnt ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM".
			" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID AND M.MLSP_ID = AG.Agent_MLSP_ID".
			" LEFT JOIN ". $this->Data['Agent_Table']." AS AG2 ON M.CoAgent_ID  = AG2.Agent_ID AND M.MLSP_ID = AG2.Agent_MLSP_ID";
		//" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID";

		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";
		$sql .= " WHERE 1".$addParameters;

		//echo $sql;exit();

        //file_put_contents('lpt.txt',print_r($sql,true));
		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$rs->next_record();

		return $rs->f("cnt");
	}
	#====================================================================================================
	#	Function Name	:   getPropTypeKeyValueArray // Added on D : 8, Apr 2010
	#----------------------------------------------------------------------------------------------------
	public function getPropTypeKeyValueArray($POST='')
	{
		global $db;

		$addParams = '';

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParams .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if(isset($POST['ForSale']) && $POST['ForSale'])
			$addParams .= " AND PropertyType != 'Residential Lease'";

		$sql =	" SELECT Distinct PropertyType".
			" FROM ". $this->Data['TableName']." AS M ".
			" WHERE 1".$addParams.
			" ORDER BY PropertyType";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arrArea = array();

		while($rs->next_record())
		{
			$arrArea[$rs->f('PropertyType')] = $rs->f('PropertyType');
		}

		return $arrArea;
	}
	#====================================================================================================
	#	Function Name	:   getEleSchoolKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getEleSchoolKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(Elementary_School)"
			. " FROM ". $this->Data['TableName']
			. " WHERE Elementary_School != ''".$addParameters
			. " ORDER BY Elementary_School";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('Elementary_School')]  = ucwords(strtolower($rs->f('Elementary_School')));
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getMidSchoolKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getMidSchoolKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(Middle_School)"
			. " FROM ". $this->Data['TableName']
			. " WHERE Middle_School != ''".$addParameters
			. " ORDER BY Middle_School";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('Middle_School')]  = ucwords(strtolower($rs->f('Middle_School')));
		}

		// To exclude some inappropriate values
		$arr = array_slice($arr, 5);

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getHighSchoolKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getHighSchoolKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(High_School)"
			. " FROM ". $this->Data['TableName']
			. " WHERE High_School != ''".$addParameters
			. " ORDER BY High_School";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('High_School')]  = ucwords(strtolower($rs->f('High_School')));
		}

		// To exclude some inappropriate values
		$arr = array_slice($arr, 24);

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getSchoolDistrictKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getSchoolDistrictKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if(isset( $POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(School_District)"
			. " FROM ". $this->Data['TableName']
			. " WHERE School_District != ''".$addParameters
			. " ORDER BY School_District";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('School_District')]  = $rs->f('School_District');
		}

		// To exclude some inappropriate values
		$arr = array_slice($arr, 24);

		return ($arr);
	}
	#====================================================================================================
	#	Agent Function
	#----------------------------------------------------------------------------------------------------
	#====================================================================================================
	#	Function Name	:   getAgentKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getAgentKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		// Office Id
		if(isset($POST['OfficeID']) && $POST['OfficeID'] != '')
		{
			$addParameters .= " AND Agent_Office_ID IN ('".str_replace(",", "','", $POST['OfficeID'])."')";
		}

		$sql	= " SELECT Agent_ID, Agent_FName, Agent_LName"
			. " FROM ". $this->Data['Agent_Table']
			. " WHERE 1 ".$addParameters
			. " ORDER BY Agent_FName";

		if(isset($this->picPath['InActive_MLSP_ID']) && $this->picPath['InActive_MLSP_ID'] != '')
			$sql .=	" AND Agent_MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";

		# Show debug info
		if(DEBUG)

			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs = $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
			$arr[$row['Agent_ID']]  = $row['Agent_FName'].' '.$row['Agent_LName'].' ['.$row['Agent_ID'].']' ;

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getAgentShortIDKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getAgentShortIDKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		// Office Id
		if(isset($POST['OfficeID']) && $POST['OfficeID'] != '')
		{
			$addParameters .= " AND Agent_Office_ID IN ('".str_replace(",", "','", $POST['OfficeID'])."')";
		}

		$sql	= " SELECT Agent_ID, Agent_FName, Agent_LName, Agent_ShortID"
			. " FROM ". $this->Data['Agent_Table']
			. " WHERE Agent_ShortID != '' ".$addParameters
			. " ORDER BY Agent_FName";

		if($this->picPath['InActive_MLSP_ID'] != '')
			$sql .=	" AND Agent_MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";

		# Show debug info
		if(DEBUG)

			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs = $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
			$arr[$row['Agent_ShortID']]  = $row['Agent_FName'].' '.$row['Agent_LName'].' ['.$row['Agent_ID'].']'.' ['.$row['Agent_ShortID'].']';

		return ($arr);
	}
	#=========================================================================================================================
	#	Function Name	:   getAgentInfoByID
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAgentInfoByID($POST)
	{
		global $db;

		$sql = " SELECT * FROM ".$this->Data['Agent_Table']." "
			. " WHERE CONCAT(Agent_ID,'_',Agent_MLSP_ID) = '".$POST['Agent_MLSP_ID']."' ";

		$db->query($sql);

		return $db->fetch_array(MYSQLI_FETCH_SINGLE);
	}

	#====================================================================================================
	#	Office Function
	#----------------------------------------------------------------------------------------------------
	#====================================================================================================
	#	Function Name	:   getOfficeKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getOfficeKeyValueArray($POST)
	{
		global $db;

		$arrOfficeID = '';
		if ($POST['OfficeList'])
			$arrOfficeID = $POST['OfficeList'];

		$sql	= " SELECT Office_ID, Office_Name "
			. " FROM ". $this->Data['Office_Table']
			. " WHERE 1 ";

		if (is_array($arrOfficeID))
			$sql .= " AND CONCAT(Office_ID,'_',Office_MLSP_ID) IN ('". implode("','", $arrOfficeID) ."')";

		if($POST['ActiveOfficeFlag'])
		{
			if($this->picPath['InActive_MLSP_ID'] != '')
				$sql .=	" AND Office_MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";
		}

		$sql	.= " ORDER BY Office_Name";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs = $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
			$arr[$row['Office_ID']]  = $row['Office_Name'];

		return ($arr);
	}
	#====================================================================================================
	#	Address Function
	#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   FetchStateKeyValueArray
	#	Purpose			:	Fetch Distinct State
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	public function FetchStateKeyValueArray($POST='')
	{
		global $db;

		$params = '';

		if(isset($POST['State']) && $POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		# Define query
		if(isset($POST['StateName']))
		{
			$sql = " SELECT DISTINCT State, state_name FROM ". $this->Data['Listing_Address']." AS A"
				. " LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State"
				. " WHERE 1".$params
				. " ORDER BY state_name";
		}
		else
		{
			$sql = " SELECT DISTINCT State FROM ". $this->Data['Listing_Address']
				. " WHERE 1".$params
				. " ORDER BY State";
		}

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arrRet = array();
		while($rs->next_record())
		{
			if(isset($POST['StateName']))
				$arrRet[$rs->f('State')] = $rs->f('state_name');
			else
				$arrRet[$rs->f('State')] = $rs->f('State');
		}

		return $arrRet;
	}
	#====================================================================================================
	#	Function Name	:   getOfficeKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getCityKeyValueArray($POST='')
	{
		global $db, $asset;

		$addParameters = '';


		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		/* State */
		if(isset($POST['StateCode']) && $POST['StateCode'])
			$addParameters .= " AND State = '".$POST['StateCode']."'";
		elseif(isset($POST['State']) && $POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		/* County */
		if(isset($POST['County']) && $POST['County'] != '')
			$addParameters .= " AND County = '". $POST['County'] ."' ";
		/* NoCounty */
		if(isset($POST['NoCounty']) && $POST['NoCounty'])
			$addParameters .= " AND County = '' ";

		if(isset($asset['Not_Include_City']) && $asset['Not_Include_City'] != '')
		{
			$city = implode("','",$asset['Not_Include_City']);
			$addParameters .= " AND CityName NOT IN('".$city."')";
		}


		if(isset($POST['CityStartWith']) && $POST['CityStartWith'] != '')
			$addParameters .= " AND CityName LIKE '".$POST['CityStartWith']."%'";

		$sql	= " SELECT DISTINCT(CityName), MLSP_ID"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE CityName != ''". $addParameters
			. " ORDER BY CityName";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			if($rs->f('MLSP_ID') == 1)
			{
				$arr['MIAMI/BEACHES'][ucwords(strtolower($rs->f('CityName')))]  = ucwords(strtolower($rs->f('CityName')));
			}
			elseif($rs->f('MLSP_ID') == 2)
			{
				$arr['ACTRIS'][ucwords(strtolower($rs->f('CityName')))]  = ucwords(strtolower($rs->f('CityName')));
			}
			//$arr[ucwords(strtolower($rs->f('CityName')))]  = ucwords(strtolower($rs->f('CityName')));
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getCityStateKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getCityStateKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';


		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		/* State */
		if(isset($POST['StateCode']) && $POST['StateCode'] != '')
			$addParameters .= " AND State = '".$POST['StateCode']."'";
		elseif(isset($POST['State']) && $POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		/* County */
		if(isset($POST['County']) && $POST['County'] != '')
			$addParameters .= " AND County = '". $POST['County'] ."' ";
		/* NoCounty */
		if(isset($POST['NoCounty']) && $POST['NoCounty'] != '')
			$addParameters .= " AND County = '' ";

		if(isset($POST['CityStartWith']) && $POST['CityStartWith'] != '')
			$addParameters .= " AND CityName LIKE '".$POST['CityStartWith']."%'";

		$sql	= " SELECT DISTINCT(CityName),State,MLSP_ID"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE CityName != ''". $addParameters
			. " ORDER BY CityName";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			if($rs->f('MLSP_ID') == 1)
			{
				$arr['MIAMI/BEACHES'][ucwords(strtolower($rs->f('CityName'))).", ".strtoupper($rs->f('State'))]  = ucwords(strtolower($rs->f('CityName'))).", ".strtoupper($rs->f('State'));
			}
			elseif($rs->f('MLSP_ID') == 2)
			{
				$arr['ACTRIS'][ucwords(strtolower($rs->f('CityName'))).", ".strtoupper($rs->f('State'))]  = ucwords(strtolower($rs->f('CityName'))).", ".strtoupper($rs->f('State'));
			}
			//$arr[ucwords(strtolower($rs->f('CityName')))]  = ucwords(strtolower($rs->f('CityName')));
		}

		/*while($rs->next_record())
		{
			$arr[ucwords(strtolower($rs->f('CityName'))).", ".strtoupper($rs->f('State'))]  = ucwords(strtolower($rs->f('CityName'))).", ".strtoupper($rs->f('State'));
		}*/

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getCityWiseZipKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getCityWiseZipKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		$sql	= " SELECT DISTINCT(CityName)"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE CityName != ''". $addParameters
			. " ORDER BY CityName";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$cityName = ucwords(strtolower($rs->f('CityName')));

			$arr[$cityName]  = $this->getZipKeyValueArray($cityName);
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   FetchCityWiseZipKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function FetchCityWiseZipKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if($POST['State'] != '')
			$addParameters .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if ($POST['PropertyType']!='')
			$addParameters	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$addParameters	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$addParameters .=" AND Is_OpenHouse = 'Y'";

		$sql	= " SELECT DISTINCT(CityName), State, state_name, ZipCode"
			. " FROM ". $this->Data['TableName']." AS M "
			. " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
			. " LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State"
			. " WHERE CityName != ''". $addParameters
			. " GROUP BY CityName, ZipCode"
			. " ORDER BY CityName";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getCityWiseListingCount
	#	Purpose			:	Fetch Distinct City with listing count
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	public function getCityWiseListingCount($POST='')
	{
		global $db,$config;

		$params = '';

		if($POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if($POST['CityStartWith'] != '')
			$params .= " AND CityName LIKE '".$POST['CityStartWith']."%'";

		if ($POST['PropertyType']!='')
			$params	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$params	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$params .=" AND Is_OpenHouse = 'Y'";

		# Define query
		$sql =	" SELECT CityName, State, COUNT(M.MLS_NUM) as listing_cnt, state_name ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
			" LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State";

		$sql .=	" WHERE M.is_mark_for_deletion = 'N'".$params;

		$sql .=	" GROUP BY CityName HAVING COUNT( M.MLS_NUM ) > 0 ORDER BY CityName";

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getCityWiseListingCount
	#	Purpose			:	Fetch Distinct City with listing count
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	public function getDistinctCity($POST='')
	{
		global $db;

		$params = '';

		if($POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if ($POST['PropertyType']!='')
			$params	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$params	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$params .=" AND Is_OpenHouse = 'Y'";

		if($POST['MLSP_ID'] != '')
			$params .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		# Define query
		$sql =	" SELECT CityName, State, state_name ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
			" LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State".
			" WHERE CityName != ''".$params.
			" GROUP BY CityName ORDER BY CityName";

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#====================================================================================================
	#	Function Name	:   getDistinctCity // Added on D : 8, Apr 2010
	#----------------------------------------------------------------------------------------------------
	public function getRandomCityList($POST)
	{
		global $db;

		$addParameters = '';
		$skipRandomLogic = false;

		if($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		if($POST['CityName'] != '')
		{
			$str = str_replace(",", "','", $POST['CityName']);
			$addParameters	 .=	" AND CityName IN('".$str. "')";
			//$addParameters .= " AND CityName = '".$POST['CityName']."'";

			$skipRandomLogic = true;
		}

		## Need Random Data, do it using PHP function, not by mysql // Added On 12 Aug 2010
		$start = 0;
		if($POST['Limit'] > 0 && $skipRandomLogic === false)
		{
			# Get Count
			$sql = " SELECT COUNT(Distinct CityName) as cnt".
				" FROM ". $this->Data['Listing_Address'].
				" WHERE CityName != ''".$addParameters;

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			$rs->next_record();

			# Total Record
			$recCount = $rs->f('cnt');

			$rs->free();

			# If Count Of Matching Records more than given limit, set new start
			if($recCount > $POST['Limit'])
			{
				# Get Random no.
				$randNo = rand(1, $recCount);

				# Set Start For Limit
				$start = $recCount - $randNo;

				if(($start + $POST['Limit']) > $recCount)
				{
					$overCount = ($start + $POST['Limit']) - $recCount;

					$start = $start - $overCount;
				}
			}

		}

		$sql =	" SELECT Distinct CityName, State".
			" FROM ". $this->Data['Listing_Address'].
			" WHERE CityName != ''".$addParameters.
			" ORDER BY CityName";

		if($skipRandomLogic === true)
			$sql .= " LIMIT 0,".$POST['Limit'];
		elseif($POST['Limit'] != '')
			$sql .= " LIMIT $start,".$POST['Limit'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#====================================================================================================
	#	Function Name	:   FetchCityName
	#----------------------------------------------------------------------------------------------------
	public function FetchCityName($POST='')
	{
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if($POST['CityName'] != '')
		{
			if(strpos($POST['CityName'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['CityName']);

				$addParameters .= " AND CityName LIKE '".$cityName."'";
			}
		}

		$sql	= " SELECT CityName"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE CityName != ''". $addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$rs->next_record();

		$arr['CityName'] = $rs->f('CityName');

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getCountyKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getCountyKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		$sql	= " SELECT DISTINCT(County)"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE County != ''".$addParameters
			. " ORDER BY County";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('County')]  = ucwords(strtolower($rs->f('County')));
		}

		return ($arr);
	}

	#====================================================================================================
	#	Function Name	:   getCountyKeyValue2
	#----------------------------------------------------------------------------------------------------
	public function getCountyKeyValue2($POST='')
	{
		global $db;

		$addParameters = '';

		if($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		$sql	= " SELECT DISTINCT(County)"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE County != ''".$addParameters
			. " ORDER BY County";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('County')]  = ucwords(strtolower($rs->f('County')));
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getSubdivisionKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getSubdivisionKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		/* State */
		if(isset($POST['StateCode']) && $POST['StateCode'])
			$addParameters .= " AND State = '".$POST['StateCode']."'";
		elseif(isset($POST['State']) && $POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		/* County */
		if(isset($POST['County']) && $POST['County'] != '')
			$addParameters .= " AND County = '". $POST['County'] ."' ";
		/* NoCounty */
		if(isset($POST['NoCounty']) && $POST['NoCounty'])
			$addParameters .= " AND County = '' ";

		if(isset($POST['StartWith']) && $POST['StartWith'])
			$addParameters .= " AND Subdivision LIKE '".$POST['StartWith']."%'";

		if(isset($POST['Subdivision']) && $POST['Subdivision'])
			$addParameters .= " AND Subdivision LIKE '%".$POST['Subdivision']."%'";

		$sql	= " SELECT DISTINCT(Subdivision)"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE Subdivision != '' AND Subdivision != '0'". $addParameters
			. " ORDER BY Subdivision";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[ucwords(strtolower($rs->f('Subdivision')))]  = ucwords(strtolower($rs->f('Subdivision')));
		}

		return ($arr);
	}	#====================================================================================================
	#	Function Name	:   getAreaKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getAreaKeyValueArray($POST='')
	{
		global $db;

		$addParameters = '';

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if(isset($POST['State']) && $POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		$sql	= " SELECT DISTINCT(Area) AreaName, Area"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE Area != ''".$addParameters
			. " GROUP BY Area"
			. " ORDER BY Area";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('Area')]  = ucwords(strtolower($rs->f('AreaName')));
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getZipKeyValueArray
	#----------------------------------------------------------------------------------------------------
	public function getZipKeyValueArray($cityName='')
	{
		global $db;

		$addParameters = '';

		if($cityName != '')
			$addParameters .= " AND CityName = '". $cityName ."'";

		$sql =	" SELECT Distinct(ZipCode) AS ZipCode".
			" FROM ". $this->Data['Listing_Address']." AS A ".
			" WHERE ZipCode != '' AND ZipCode > 0".$addParameters." ORDER BY ZipCode ASC";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$cityName.'|'.$rs->f('ZipCode')]  = $rs->f('ZipCode');
		}

		return ($arr);
	}
	#=========================================================================================================================
	#	Function Name	:   getCityWiseListingCount
	#	Purpose			:	Fetch Distinct City with listing count
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	public function getZipWiseListingCount($POST='')
	{
		global $db;

		$params = '';

		if($POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if($POST['City'] != '')
			$params .= " AND CityName = '".$POST['City']."'";

		if ($POST['PropertyType']!='')
			$params	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$params	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$params .=" AND Is_OpenHouse = 'Y'";

		# Define query
		$sql =	" SELECT ZipCode, CityName, State, COUNT(M.MLS_NUM) as listing_cnt, state_name ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
			" LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State".
			" WHERE is_mark_for_deletion = 'N'".$params.
			" GROUP BY ZipCode HAVING COUNT( M.MLS_NUM ) > 0 ORDER BY ZipCode";

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#====================================================================================================
	#	Function Name	:   getOpenHouseData
	#----------------------------------------------------------------------------------------------------
	public function getOpenHouseData($ListingID_MLS, $days='', $limit='')
	{
		global $db,$config;

		$addParams = '';

		if($days > 0)
		{
			$addParams .= ' AND OH_Date <= DATE_ADD(CURDATE(), INTERVAL '.$days.' DAY)';
		}

		$sql =	" SELECT OH_Begins, OH_Close, OH_DisplayTime, OH_Date".
			" FROM ". $this->Data['MLS_Open_House_Table']." AS OP ".
			" WHERE CONCAT(MLS_NUM,'-',MLSP_ID) = '".$ListingID_MLS."' AND OH_Date >= CURDATE()".$addParams.
			" ORDER BY OH_Date ASC";
		if($limit > 0)
			$sql .= " LIMIT 0, ".$limit;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getCurrentWeakOpenHouses
	#-------------------------------------------------------------------------------------------------------------------------
	public function getCurrentWeakOpenHouses($POST)
	{
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		if(isset($POST['CountOnly']))
		{
			$sql =  "SELECT M.MLS_NUM";
		}
		else
		{
			$sql =  " SELECT M.MLS_NUM, mls_is_pic_url_supported, M.ListPrice, Subdivision,  M.PropertyType, M.PropertyStyle, M.Beds, M.BathsFull,".
				" M.BathsHalf, M.SQFT, M.TotalAcreage, Main_Photo, M.Main_Photo_Url, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, Category, Parking, Garage,O.Office_Name,".
				" A.StreetNumber, A.StreetName, Address, A.CityName, A.County, A.State, ZipCode, DisplayAddress,".
				" A.StreetDirection, StreetSuffix, UnitNo, M.YearBuilt, M.Description, Price_Diff, ".
				" CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path, OP.*";
		}

		# To exclude open house details by office ID
		if(!defined("IN_ADMIN"))
			$sql .= ", IF(FIND_IN_SET(M.OfficeID,'".$config['exclude_openhouse_by_officeId']."'), 'N', Is_OpenHouse) AS Is_OpenHouse ";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID ".
			" LEFT JOIN ". $this->Data['MLS_Open_House_Table']." AS OP ON M.MLSP_ID = OP.MLSP_ID AND M.MLS_NUM = OP.MLS_NUM";


		$sql .= " WHERE Is_OpenHouse = 'Y' ";

		# Set Order
		$sql .= " GROUP BY M.MLS_NUM ORDER BY OH_Date ASC ";

		# Set Limit
		if($POST['limit'])
			$sql .= " LIMIT 0, ".$POST['limit'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		if(isset($POST['CountOnly']))
		{
			$arr['total'] = $rs->TotalRow;
		}
		else
		{
			$arr['rs'] = array();

			while($rs->next_record())
			{
				$row = $rs->Record;

				# Shreyansh 05/20/2013
				# To exclude open house details by office ID
				if($row['Is_OpenHouse'] == 'Y')
				{
					if($row['mls_is_pic_url_supported'] == 'Yes')
					{
						$row['MainPicture'] = $row['Main_Photo_Url'];
//						$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=true);
					}
					else
					{
						$pic_no = $row['Main_Photo']-1;
						//$row['MainPicture'] = $virtual_path['Data_MDN_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
						$row['MainPicture'] = $this->Pic_Path."/".$row['ListingID_MLS']."/".$pic_no;
					}

					// Get Open House Detail
					$arrOpenHouse = $this->getOpenHouseData($row['ListingID_MLS'], $days=7);

					if(is_array($arrOpenHouse))
					{
						$row['arrOpenHouse'] = $arrOpenHouse;
					}

					array_push($arr['rs'], $row);
				}
			}
		}

		return $arr;
	}
	#====================================================================================================
	#	Function Name	:   getOpenHouseData
	#----------------------------------------------------------------------------------------------------
	public function getVirtualTourData($ListingID_MLS)
	{
		global $db;

		$sql =	" SELECT tour_url".
			" FROM ". $this->Data['MLS_Virtual_Tour_Table']." AS VT ".
			" WHERE CONCAT(MLS_NUM,'-',MLSP_ID) = '".$ListingID_MLS."' ORDER BY tour_last_modified DESC LIMIT 0,1";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}

	#====================================================================================================
	#	Function Name	:   getRoomData
	#----------------------------------------------------------------------------------------------------
	public function getRoomData($ListingKey, $MLSP_ID)
	{
		global $db;

		$sql =	" SELECT *".
			" FROM ". $this->Data['Listing_Room_Info']." AS R ".
			" WHERE ListingKey = '".$ListingKey."' AND MLSP_ID = '".$MLSP_ID."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}

	public function getListingLastUpdateDate()
	{
		global $db;

		$sql =	" SELECT MAX(LastUpdateDate) AS LastUpdateDate ".
			" FROM ". $this->Data['TableName'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$arr = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

		return $arr['LastUpdateDate'];
	}

	#=========================================================================================================================
	#	Function Name	:   getListingForMap
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingForMap($POST)
	{
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$POST[P_SIZE] = $POST[P_SIZE] ? $POST[P_SIZE] : RESULT_PAGESIZE;

		$sql =  " SELECT M.MLS_NUM, mls_is_pic_url_supported, M.ListPrice, M.Beds, M.Baths, M.Main_Photo_Url,".
			" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,".
			" A.StreetName, Address, A.StreetNumber, A.StreetDirection, StreetSuffix, UnitNo, A.Area, A.CityName, A.County, A.State, ZipCode,".
			" A.Latitude, A.Longitude, CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
			" WHERE 1 ".$addParameters;

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST[S_RECORD]. ", ". $POST[P_SIZE];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		$arr['map-data'] = array();

		while($rs->next_record())
		{
			$row = $rs->Record;

			if($row['mls_is_pic_url_supported'] == 'Yes')
			{
				$row['MainPicture'] = $row['Main_Photo_Url'];
//				$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $getMainPic=true);
			}
			else
			{
				$pic_no = $row['Main_Photo']-1;
				$row['MainPicture'] = $this->Pic_Path."/".$row['ListingID_MLS']."/".$pic_no;
			}
			if($row['Latitude'] > 0)
			{
				$rsAttributes = Utility::getInstance()->generateListingAttributes($row);

				$arrTemp = array();
				$arrTemp['Key'] 		= $row['ListingID_MLS'];
				$arrTemp['MLS'] 		= $row['MLS_NUM'];
				$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
				$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
				$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
				$arrTemp['Lat'] 		= $row['Latitude'];
				$arrTemp['Long'] 		= $row['Longitude'];
				$arrTemp['Price'] 		= ($row['ListPrice'] > 0 ? $row['ListPrice'] : 'Email Us for Pricing');
				$arrTemp['Bed'] 		= ($row['Beds'] > 0 ? $row['Beds'] : 'N/A');
				$arrTemp['Bath'] 		= ($row['Baths'] > 0 ? $row['Baths'] : 'N/A');
				$arrTemp['Sqft'] 		= ($row['SQFT'] > 0 ? $row['SQFT'] : 'N/A');
				$arrTemp['Pic'] 		= $row['MainPicture'];
				$arrTemp['Pic_Path'] 	= $row['Pic_Path'];
				$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];

				array_push($arr['map-data'], $arrTemp);
			}
		}

		if(count($arr['map-data']) > 0)
		{
			$arr['map-data'] = base64_encode(gzencode(json_encode($arr['map-data'])));
		}

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getSchoolSuggestion
	#-------------------------------------------------------------------------------------------------------------------------
	public function getSchoolSuggestion($POST)
	{
		global $config, $db;

		$Parameters	 =	'';

		$arr = array();

		## Quick Search
		if(trim($POST['keywords']) != '')
		{
			$POST['keywords'] = trim($POST['keywords']);

			$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $POST['keywords'], $keywords);

			#---------------------------------------------------------------------------------------
			# SCHOOL SEARCH
			$searchFields   = array();
			$searchFields[] = 'Elementary_School';
			$searchFields[] = 'High_School';
			$searchFields[] = 'Middle_School';

			$fieldsToSearch = implode(", ", $searchFields);

			$strSearch      = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
			$sql            = " SELECT DISTINCT Elementary_School AS Schools FROM ". $this->Data['TableName']." WHERE Elementary_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND Elementary_School LIKE '%".$strSearch."%' UNION 
                              SELECT DISTINCT High_School AS Schools FROM ". $this->Data['TableName']." WHERE High_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND High_School LIKE '%".$strSearch."%' UNION
                              SELECT DISTINCT Middle_School AS Schools FROM ". $this->Data['TableName']." WHERE Middle_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND Middle_School LIKE '%".$strSearch."%' ORDER BY Schools";

			if($POST['Limit'] > 0)
				$sql    .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arraddress = $rs->f('Schools');
				$strReplace = str_replace(', ,', ',', $arraddress);

				$arr[]  =  array('type' => ASTYPE_SCHOOL, 'title' => $strReplace);

			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
		}

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getAddressSuggestion
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAddressSuggestion1($POST)
	{
		global $config, $db;

		$Parameters	 =	'';

		$arr = array();

		## Quick Search
		if(trim($POST['keywords']) != '')
		{

			$POST['keywords'] = trim($POST['keywords']);

			$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $POST['keywords'], $keywords);
			# ----------------------------------------------------------------------------------
			# CITY SEARCH
			$searchFields    = array();
			$searchFields[]  = 'CityName';

			$fieldsToSearch  = implode(", ", $searchFields);

			$addParameters   = " AND  ". $fieldsToSearch. " LIKE '%".$POST['keywords'] . "%' ";
			$sql             = "SELECT DISTINCT(CONCAT_WS(', ', CityName, State)) AS CityName "
				. " FROM ". $this->Data['TableName']." AS M"
				. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
				. " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus IN ('Active','ActiveUnderContract','ComingSoon')". $addParameters
				. " ORDER BY CityName";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];


			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_CITYSTATE, 'title' => $rs->f('CityName'));
			}
			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}

			# ---------------------------------------------------------------------------------
			# SubDivision
			$searchFields    = array();
			$searchFields[]  = 'Subdivision';

			$fieldsToSearch  = implode(", ", $searchFields);

			$addParameters   = " AND ". $fieldsToSearch. " LIKE '%".$POST['keywords'] . "%' ";

			$sql             = "SELECT DISTINCT(Subdivision) AS Subdivision "
				. " FROM ". $this->Data['TableName']." AS M"
				. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
				. " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus IN ('Active','ActiveUnderContract','ComingSoon')". $addParameters
				. " ORDER BY Subdivision";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_SUB, 'title' => $rs->f('Subdivision'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}

			#---------------------------------------------------------------------------------------
			# ADDRESS SEARCH
			$searchFields   = array();
			$searchFields[] = 'UnitNo';
			$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetName';

			$fieldsToSearch = implode(", ", $searchFields);

			$strSearch      = implode("%' OR CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '", $keywords[0]);

			$addParameters  = " AND ( CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '". $strSearch. "%') ";

			$sql            = "SELECT DISTINCT(CONCAT_WS(', ', Address, CityName, State)) AS address, CONCAT(M.MLS_NUM, '-', M.MLSP_ID) AS ListingID_MLS"
				. " FROM ". $this->Data['TableName']." AS M"
				. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
				. " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus IN ('Active','ActiveUnderContract','ComingSoon')" . $addParameters
				. " ORDER BY address";

			if($POST['Limit'] > 0)
				$sql    .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arraddress = $rs->f('address');
				$strReplace = str_replace(', ,', ',', $arraddress);
				$MLS = $rs->f('ListingID_MLS');
				$arr[]  =  array('type' => ASTYPE_ADD, 'title' => $strReplace, 'ListingID_MLS' => $MLS);

			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}

			#-------------------------------------------------------------------------------
			# ZipCode SEARCH
			$searchFields    = array();
			$searchFields[]  = 'ZipCode';

			$fieldsToSearch  = implode(", ", $searchFields);

			$addParameters   = " AND ( ". $fieldsToSearch. " LIKE '%". $POST['keywords']. "%' ) ";

			$sql             = " SELECT DISTINCT(ZipCode) AS ZipCode"
				. " FROM ". $this->Data['TableName']." AS M"
				. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
				. " WHERE ZipCode != '' AND is_mark_for_deletion = 'N' AND M.ListingStatus IN ('Active','ActiveUnderContract','ComingSoon') ". $addParameters
				. " ORDER BY ZipCode";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_ZIP, 'title' => $rs->f('ZipCode'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
			# ----------------------------------------------------------------------------------
			# MLS SEARCH
			$strSearch       = implode("%' OR M.MLS_NUM LIKE '", $keywords[0]);
			$addParameters   = " AND ( M.MLS_NUM LIKE '". $strSearch. "%' ) ";

			$sql             = " SELECT DISTINCT(MLS_NUM) AS MLS_NUM, CONCAT(M.MLS_NUM, '-', M.MLSP_ID) AS ListingID_MLS"
				. " FROM ". $this->Data['TableName']." AS M"
				. " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus IN ('Active','ActiveUnderContract','ComingSoon')". $addParameters
				. " ORDER BY MLS_NUM";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_MLS, 'title' => $rs->f('MLS_NUM'),'ListingID_MLS' => $rs->f('ListingID_MLS'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
		}

		return $arr;
	}

	#=========================================================================================================================
	#	Function Name	:   getAddressSuggestion
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAddressSuggestion($POST)
	{
		global $config, $db;

		$Parameters	 =	'';

		$arr = array();

		## Quick Search
		if(trim($POST['keywords']) != '')
		{

			$POST['keywords'] = trim($POST['keywords']);

			$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $POST['keywords'], $keywords);


			if($POST['type'] == 'Cities' || $POST['type'] == '')
			{

				$addParameters   = " AND `city_state` LIKE '%".$POST['keywords']."%'";



				$sql    =   "SELECT DISTINCT(`city_state`) AS CityName FROM trigger_search_by_city WHERE 1 ".$addParameters." ORDER BY `city_state` ASC LIMIT 0,".$POST['Limit'];


				$rs     =   $db->quick_query($sql);
				$ars    =   $rs->quick_fetch_all();
				foreach($ars as $k=>$v)
					$arr[]  = array('type' => ASTYPE_CITYSTATE, 'title' => $v['CityName']);

				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0){
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0){
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}


			# ---------------------------------------------------------------------------------
			# SubDivision
			if($POST['type'] == 'Subdivision' || $POST['type'] == '')
			{

				$addParameters = " AND `subdivision` LIKE '%" . $POST['keywords'] . "%'";
				$sql = "SELECT DISTINCT(`subdivision`) AS Subdivision FROM trigger_search_by_subdivision WHERE 1 ".$addParameters." ORDER BY `subdivision` LIMIT 0," . $POST['Limit'];
				$rs = $db->quick_query($sql);
				$ars = $rs->quick_fetch_all();
				foreach ($ars as $k => $v) {
					$arr[] = array('type' => ASTYPE_SUB, 'title' => $v['Subdivision']);
				}

				if (($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0) {
					return $arr;
				} elseif (($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0) {
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}


	        #---------------------------------------------------------------------------------------
			# ADDRESS SEARCH
			if($POST['type'] == 'Address' || $POST['type'] == '')
			{

				$addParameters = " AND `address` LIKE '" . $POST['keywords'] . "%'";
				$sql = "SELECT DISTINCT(`address`) AS address, '' AS ListingID_MLS, '' AS ListingStatus FROM trigger_search_by_address WHERE 1 ".$addParameters." ORDER BY `address` LIMIT 0," . $POST['Limit'];
				$rs = $db->quick_query($sql);
				$ars = $rs->quick_fetch_all();
				foreach ($ars as $k => $v) {
					$arraddress = $v['address'];
					$strReplace = str_replace(', ,', ',', $arraddress);
					$MLS = $v['ListingID_MLS'];
					$status = $v['ListingStatus'];
					$arr[] = array('type' => ASTYPE_ADD, 'title' => $strReplace, 'ListingID_MLS' => $MLS, 'Status' => $status);
				}

				if (($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0) {
					return $arr;
				} elseif (($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0) {
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}

			#-------------------------------------------------------------------------------
			# ZipCode SEARCH
			if($POST['type'] == 'Zip' || $POST['type'] == '')
			{

				$addParameters   = " AND `zip_code` LIKE '".$POST['keywords']."%'";
				$sql    =   "SELECT DISTINCT(`zip_code`) AS ZipCode FROM trigger_search_by_zipcode WHERE 1 ".$addParameters." ORDER BY `zip_code` ASC LIMIT 0,".$POST['Limit'];

				$rs = $db->quick_query($sql);
				$ars = $rs->quick_fetch_all();
				foreach($ars as $k=>$v)
					$arr[]  = array('type' => ASTYPE_ZIP, 'title' => $v['ZipCode']);


				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0){
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0){
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}

            # ----------------------------------------------------------------------------------
			# MLS SEARCH
			if($POST['type'] == 'MLS' || $POST['type'] == '')
			{

				$addParameters = " AND `mls_num` LIKE '" . $POST['keywords'] . "%'";
				$sql = "SELECT DISTINCT(`mls_num`) AS MLS_NUM, `listing_status` AS ListingStatus, CONCAT(mls_num, '-', MLSP_ID) AS ListingID_MLS FROM trigger_search_by_mls WHERE 1 ".$addParameters." ORDER BY `mls_num` ASC LIMIT 0," . $POST['Limit'];

				$rs = $db->quick_query($sql);
				$ars = $rs->quick_fetch_all();
				foreach ($ars as $k => $v)
					$arr[] = array('type' => ASTYPE_MLS, 'title' => $v['MLS_NUM'], 'Status' => $v['ListingStatus'],'ListingID_MLS' =>  $v['ListingID_MLS']);

				if (($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0) {
					return $arr;
				} elseif (($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0) {
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}
		}

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByParam
	#-------------------------------------------------------------------------------------------------------------------------
	public function getListingByParamForHome($POST)
	{
		global $db, $virtual_path, $config, $asset;

		$addParameters = $this->getQueryParameters($POST);

		$POST[P_SIZE] = $POST[P_SIZE] ? $POST[P_SIZE] : RESULT_PAGESIZE;

		$sql =	" SELECT count(*) as cnt ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;
		$rs = $db->query($sql);
		$rs->next_record();

		$this->total_record = $rs->f("cnt") ;
		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST[S_RECORD] >= $this->total_record || $POST[P_SIZE] >= $this->total_record || !isset($POST[S_RECORD]))
				$POST[S_RECORD] = 0;
		}

		if ($POST[V_TYPE]==VT_LIST)
		{
			$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.Beds,M.Baths,M.Main_Photo, M.Main_Photo_Url,".
				" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, ".
				" TotalPhotos, Is_OpenHouse, ListingDate, ListingStatus, ".
				" A.StreetNumber, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix, A.CityName, A.State, ZipCode, DisplayAddress,".
				" O.Office_Name,CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName, ".
				" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, ".
				"(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date, ".
				"(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";
			if(isset($POST['ShowMiles']) && ($POST['latitude']))
				$sql .= ",( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['latitude']." / 57.2958 ) * COS( ".$POST['longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) AS Miles";
		}
		elseif ($POST[V_TYPE]==VT_MAP)
		{
			$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.Beds,M.Baths,M.Main_Photo,M.Main_Photo_Url, ".
				" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,Listing_Created_Date, ListingDate,M.Old_Price, ".
				" TotalPhotos, Is_OpenHouse, M.Pic_Download_Flag2,ListingStatus, ".
				" A.StreetNumber, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix, A.CityName, A.State, ZipCode, DisplayAddress, A.Subdivision, ".
				" O.Office_Name, CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, ".
				" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, ".
				"(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date, ".
				"(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";
		}
		elseif ($POST[V_TYPE]==VT_SITE_MAP)
		{
			$sql =  " SELECT M.MLS_NUM, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, M.PropertyType, M.Main_Photo_Url, LastUpdateDate, Listing_Created_Date, ListingDate, (DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM,".
				" A.StreetNumber, A.StreetName, Address, A.StreetDirection, A.CityName, A.State, A.County, ZipCode, A.Subdivision ";
		}
		else
		{
			$sql =  " SELECT M.*, mls_is_pic_url_supported, M.PropertyType, M.SubType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,ListingDate, (DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM,M.Old_Price,".
				" Parking, Garage, A.StreetNumber, A.StreetName, Address, A.CityName, A.County, A.State, ZipCode, M.Pic_Download_Flag2, ".
				" A.StreetDirection, StreetSuffix, UnitNo, A.Latitude, A.Longitude, Main_Photo, Category, IF(M.Agent_ID = '".$config['agent_code']."', 0, 1) AS agent_listing, O.Office_Name, ".
				"(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date, ".
				"(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";
		}

		$sql .=
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
			" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		if (count($POST['sort_order_list']) > 0)
		{
			$field_order='';
			foreach ($POST['sort_order_list'] as $field => $order)
			{
				$field_order .= $field." ".$order.",";
			}

			$field_order = rtrim($field_order,",");

			$sql .= " ORDER BY ".$field_order;
		}
		else
		{
			$sql .=	" ORDER BY ". ($POST[SO] != ''? ($POST[SO] == 'location' ? 'Subdivision' : $asset['OL_SORTBY_LOOKUP_ARRAY'][$POST[SO]]) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.($POST[SD] != ''? $POST[SD] :DEFAULT_SD);
		}

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST[S_RECORD]. ", ". $POST[P_SIZE];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$arr = array();
		$arr['rs'] = array();
		$arr['map-data'] = array();
		if(!defined('IN_AGENT'))
		{
			$asset['mlsPhotoType'] = array();
			$asset['mlsPhotoType']		= 	array	( 'thumb'		=>	'Thumbnail Size Photo',
			);
		}

		while($rs->next_record())
		{
			$row = $rs->Record;
			if($POST[V_TYPE] != VT_SITE_MAP)
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
                    foreach ($asset['mlsPhotoType'] as $phototype=>$des){
                        $row['MainPicture'][$phototype]['url'] = $row['Main_Photo_Url'];
                    }
                    if(!isset($row['MainPicture']['thumb']) && isset($row['MainPicture']['large'])){
                        $row['MainPicture']['thumb'] = $row['MainPicture']['large'];
                    }
//					$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=true);
				}
				else
				{
					$pic_no = $row['Main_Photo']-1;
					$row['MainPicture'] = $this->Pic_Path."/".$row['ListingID_MLS']."/".$pic_no;
				}
			}

			if(isset($POST['getAllPhoto']))
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$PicArr = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=false);

					$row['PhotoAll'] = $PicArr;
				}
				else
				{
					$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos']);

					$row['PhotoAll'] = $PicArr;
				}
			}
			if(isset($row['open_house_data']) && !empty($row['open_house_data']))
			{
				$arr_open = explode(',', $row['open_house_data']);
				$row['OpenHouse_Date'] = $arr_open[0];
				$row['OpenHouse_Begin'] = $arr_open[1];
				$row['OpenHouse_Close'] = $arr_open[2];
			}

			array_push($arr['rs'], $row);
			if(isset($POST['getMapData'])/* && $row['Latitude'] > 0*/)
			{
				$rsAttributes = Utility::generateListingAttributes($row);

				$arrTemp = array();
				$arrTemp['Key'] 		= $row['ListingID_MLS'];
				$arrTemp['MLS'] 		= $row['MLS_NUM'];
				$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
				$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
				$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
				$arrTemp['Lat'] 		= $row['Latitude'];
				$arrTemp['Long'] 		= $row['Longitude'];
				$arrTemp['CityName'] 	= $row['CityName'];
				$arrTemp['State'] 		= $row['State'];
				$arrTemp['ZipCode'] 	= $row['ZipCode'];
				$arrTemp['Price'] 		= $row['ListPrice'];
				$arrTemp['Type']        = $row['PropertyType'];
				$arrTemp['SubType']     = $row['SubType'];
				$arrTemp['Bed'] 		= $row['Beds'];
				$arrTemp['Bath'] 		= $row['Baths'];
				$arrTemp['Sqft'] 		= $row['SQFT'];
				$arrTemp['Year']        = $row['YearBuilt'];
				$arrTemp['Pic'] 		= $row['MainPicture'];
				$arrTemp['Pic_Path'] 	= $row['Pic_Path'];
				$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];
				$arrTemp['OfficeName']	= $row['Office_Name'];
				$arrTemp['PhotoBaseUrl']= $this->Pic_Path;
				$arrTemp['TotalPhotos']	= $row['TotalPhotos'];
				$arrTemp['Photos'] 		= $row['PhotoAll'];
				$arrTemp['PictureArr']  = $row['PhotoAll']['thumb'];
				$arrTemp['sub']         = $row['Subdivision'];
				$arrTemp['HOA']         = $row['HOA_Fee'];
				$arrTemp['status']      = $row['ListingStatus'];
				$arrTemp['DOM']         = $row['DOM'];
				$arrTemp['lotSize']     = $row['LotSize'];
				$arrTemp['subdiv']     = $row['Subdivision'];

				array_push($arr['map-data'], $arrTemp);
			}
		}

		if(count($arr['map-data']) > 0)
		{
			$arr['map-data'] = base64_encode(gzencode(json_encode($arr['map-data'])));
		}
		else
		{
			$arr['map-data'] = '';
		}

		$arr['total_record'] = $this->total_record;
		$arr['PhotoBaseUrl'] = $this->Pic_Path;

		return $arr;
	}
	public function getPropertyStatisticForDashboard()
	{
		global $db, $config, $usrInfo;

		$Join = '';
		$param = '';
		$Join .= " LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";
		if(isset($config['mls_office_ids']) && $config['mls_office_ids'] != '')
		{
			$param .= " AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."'))";
		}
		$sql = " SELECT COUNT(M.MLS_NUM) AS total_listing FROM ".$this->Data['TableName']." M WHERE 1 AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active'";


		$sql .= $param;

		$rs = $db->query($sql);

		$rs->next_record();
		$arr['total_listing'] = $rs->f('total_listing');


		$rs->free();


		$sql = " SELECT COUNT(M.MLS_NUM) AS today_total_listing FROM ".$this->Data['TableName']." M ".
			$Join.
			" WHERE 1 AND ( YEAR(ListingDate) = YEAR(CURRENT_DATE()) AND WEEK(ListingDate) = WEEK(CURRENT_DATE())) AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active'";

		$sql .= $param;
		$rs = $db->query($sql);
		$rs->next_record();
		$arr['today_listing']     =   $rs->f('today_total_listing');
		$rs->free();

		return $arr;
	}
	public function getStatisticForChart($agent_code = '')
	{
		global $db, $config, $usrInfo;

		$param = '';
		if(isset($config['mls_office_ids']) && $config['mls_office_ids'] != '')
		{
			$param .= " AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."'))";
		}

		$sql = "SELECT COUNT(MLS_NUM) AS listing_count, MONTH(`ListingDate`) AS month, YEAR (`ListingDate`) AS year, (SELECT DATE_SUB( CURRENT_DATE , INTERVAL 11 MONTH )) AS start_month FROM "
			.$this->Data['TableName']." M WHERE 1 AND ListingDate >= DATE_SUB(CURRENT_DATE(), INTERVAL 11 MONTH) AND ListingStatus = 'Active' 
                AND is_mark_for_deletion = 'N'";

		$Group_By = " GROUP BY MONTH(`ListingDate`),YEAR(`ListingDate`) ";
		$Order_By = "ORDER BY year,month";

		$sql .= $param;
		$sql .= $Group_By;
		$sql .= $Order_By;


		$rs = $db->query($sql);

		while($rs->next_record())
		{
			$arr['listing'][$rs->f('month')] = $rs->f('listing_count');
			$start_month = date("n", strtotime($rs->f('start_month')));
		}

		$rs->free();

		$cur_month = date('n');

		# Php has issue while its february month as start month. So select it from mysql
		$month_list=array(); $temp=array();
		for($i=$start_month; $i<=12; $i++)
		{
			$month_list[] = $i;

		}

		if($start_month > 1){
			for($i=$cur_month; $i>=1; $i--)
			{
				$temp[] = $i;
			}
		}

		if(count($temp) > 0)
		{
			$month_list = array_merge($month_list,array_reverse($temp));
		}

		foreach($month_list as $k=>$m)
		{
			$data[] = array("m" => date('M',mktime(0, 0, 0, $m, 1)), "l" => ((isset($arr['listing'][$m]) && $arr['listing'][$m] > 0) ? $arr['listing'][$m] : 0)/*, "s" => ((isset($arr['sold'][$i]) && $arr['sold'][$i] > 0) ? $arr['sold'][$i] : 0)*//*, "p" => ($arr['pending'][$i] > 0 ? $arr['pending'][$i] : 0)*/);
		}

		return $data;
	}
	public function getAreaWisePropertyCount($POST=array())
	{
		global $db, $config, $usrInfo, $asset;

		$Main_param = '';
		if(isset($config['mls_office_ids']) && $config['mls_office_ids'] != '')
		{
			$Main_param .= " AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."'))";
		}

		$temp = array();
		foreach($asset['OL_DashBoard_Area'] as $key => $area)
		{
			$temp[] = " (SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND Area = '".$area."' AND is_mark_for_deletion = 'N' ".$Main_param." ) AS ".$key." ";
		}
		$temp[] = " (SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND Area NOT IN ('".implode("','",$asset['OL_DashBoard_Area'])."') AND is_mark_for_deletion = 'N' ".$Main_param." ) AS Other ";

		$temp_sql = implode(',',$temp);
		$sql = " SELECT COUNT(M.MLS_NUM) AS total, ";

		$sql .= $temp_sql;
		$sql .= " FROM ".$this->Data['TableName']." M WHERE 1 AND is_mark_for_deletion = 'N'";

		$sql .= $Main_param;

		$rs = $db->query($sql);
		$rs->next_record();
		$arr = $rs->Record;
		return $arr;
	}
	public function getCityWisePropertyCount($POST=array())
	{
		global $db, $config, $usrInfo, $asset;

		$Main_param = '';
		if(isset($config['mls_office_ids']) && $config['mls_office_ids'] != '')
		{
			$Main_param .= " AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."'))";
		}
		$temp = array();
		foreach($asset['OL_DashBoard_City'] as $key => $city)
		{
			$temp[] = "(SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND CityName = '".$city."' AND is_mark_for_deletion = 'N' ".$Main_param." ) AS ".$key;
		}
		$temp[] = "(SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND CityName NOT IN ('".implode("','",$asset['OL_DashBoard_City'])."') AND is_mark_for_deletion = 'N' ".$Main_param." ) AS Other";

		$temp_sql = implode(',',$temp);
		$sql = " SELECT COUNT(M.MLS_NUM) AS total, ";

		$sql .= $temp_sql;
		$sql .= " FROM ".$this->Data['TableName']." M WHERE 1 AND is_mark_for_deletion = 'N'";

		$sql .= $Main_param;

		$rs = $db->query($sql);
		$rs->next_record();
		$arr = $rs->Record;
		return $arr;
	}

	public function getPropertyLatestUpdatesforHome($POST="")
	{
		global $db, $virtual_path, $config, $asset,$Utility;

		if(is_array($POST) && count($POST) > 0 )
		{
			$addParameters = $this->getQueryParameters($POST);
		}
		if(isset($POST['day']) && $POST['day'] >= 0)
			$day = $POST['day'];
		else
			$day = 2;

		$POST[P_SIZE] = $POST[P_SIZE] ? $POST[P_SIZE] : RESULT_PAGESIZE;
		$sql =	" SELECT count(*) as cnt ".
			" FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

		$sql .= " WHERE 1 
                AND ( CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) AND ListingStatus = 'Active') THEN 'New Listing' 
                WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) AND ListingStatus = 'Pending') THEN 'Sale Pending' 
                WHEN DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) THEN (CASE WHEN ListingStatus = 'Closed' THEN 'Sold' 
                WHEN ( Price_Diff < 0 AND ListingStatus != 'Closed' ) THEN 'Price Drop' WHEN ( Price_Diff > 0 AND ListingStatus != 'Closed') THEN 'Price Increase' END) END) != ''
                ".$addParameters;

		$rs = $db->query($sql);
		$rs->next_record();

		$this->total_record = $rs->f("cnt") ;
		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST[S_RECORD] >= $this->total_record || $POST[P_SIZE] >= $this->total_record || !isset($POST[S_RECORD]))
				$POST[S_RECORD] = 0;
		}

		$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.Beds,M.Baths,M.Main_Photo,M.LastUpdateDate,M.ListingStatus,M.Main_Photo_Url, ".
			" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,Listing_Created_Date, ListingDate,M.Old_Price,LastUpdateDate,M.Price_Diff, ".
			" TotalPhotos,M.Pic_Download_Flag2, ".
			" A.StreetNumber, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix, A.CityName, A.State, ZipCode, DisplayAddress, A.Subdivision, ".
			" (DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, ".
			" A.StreetDirection, StreetSuffix, UnitNo, M.YearBuilt, A.Latitude, A.Longitude, ".
			" ( CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) AND ListingStatus = 'Active') THEN 'New Listing' 
                WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) AND ListingStatus = 'Pending') THEN 'Sale Pending' 
                WHEN DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) THEN (CASE WHEN ListingStatus = 'Closed' THEN 'Sold' WHEN ( Price_Diff < 0 AND ListingStatus != 'Closed' ) THEN 'Price Drop' WHEN ( Price_Diff > 0 AND ListingStatus != 'Closed') THEN 'Price Increase' END) END) AS prop_update ";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
			" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

		$sql .= " WHERE 1 
                AND ( CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) AND ListingStatus = 'Active') THEN 'New Listing' 
                WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) AND ListingStatus = 'Pending') THEN 'Sale Pending' 
                WHEN DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL ".$day." DAY) THEN (CASE WHEN ListingStatus = 'Closed' THEN 'Sold' 
                WHEN ( Price_Diff < 0 AND ListingStatus != 'Closed' ) THEN 'Price Drop' WHEN ( Price_Diff > 0 AND ListingStatus != 'Closed') THEN 'Price Increase' END) END) != ''
                ".$addParameters;

		if (count($POST['sort_order_list']) > 0)
		{
			$field_order='';
			foreach ($POST['sort_order_list'] as $field => $order)
			{
				$field_order .= $field." ".$order.",";
			}

			$field_order = rtrim($field_order,",");

			$sql .= " ORDER BY ".$field_order;
		}
		else
		{
			if(defined("IN_ADMIN"))
			{
				$sql .=	" ORDER BY ". ($POST[SO] != ''? $POST[SO] :'Subdivision').' '.($POST[SD] != ''? $POST[SD] :'DESC');
			}
			else
			{
				$sql .= 'ORDER BY ';
				$sql .=	($POST[SO] != ''? ($POST[SO] == 'location' ? 'Subdivision' : $asset['OL_SORTBY_LOOKUP_ARRAY'][$POST[SO]]) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.($POST[SD] != ''? $POST[SD] :DEFAULT_SD);
			}
		}
		//echo "<br />=================".$sql."==============================<br />";
		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST[S_RECORD]. ", ". $POST[P_SIZE];

		if(isset($_GET['print']) && $_GET['print'] == true)
		{
			echo $sql; exit;
		}
		//echo $sql;exit;
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		$arr['rs'] = array();
		$arr['map-data'] = array();
		$arr['map-data']['data'] = array();
		$asset['mlsPhotoType'] = array();
		$asset['mlsPhotoType']		= 	array	( 'thumb'		=>	'Thumbnail Size Photo',
		);

		$New_Listing = 0;$Sale_pending=0;$Sold=0;$Price_drop=0;$Price_increase=0;

		while($rs->next_record())
		{
			$row = $rs->Record;
			if($POST[V_TYPE] != VT_SITE_MAP)
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
                    foreach ($asset['mlsPhotoType'] as $phototype=>$des){
                        $row['MainPicture'][$phototype]['url'] = $row['Main_Photo_Url'];
                    }
                    if(!isset($row['MainPicture']['thumb']) && isset($row['MainPicture']['large'])){
                        $row['MainPicture']['thumb'] = $row['MainPicture']['large'];
                    }
//					$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=true);
				}
				else
				{
					$pic_no = $row['Main_Photo']-1;
					$row['MainPicture'] = $this->Pic_Path."/".$row['ListingID_MLS']."/".$pic_no;
				}
			}

			if($POST['getAllPhoto'])
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$PicArr = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=false);

					$row['PhotoAll'] = $PicArr;
				}
				else
				{
					$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos']);

					$row['PhotoAll'] = $PicArr;
				}
			}
			$row['datetime_diff'] = $Utility->DateTimeStringFormate($row['LastUpdateDate']);

			if($row['Price_Diff'] < 0)
			{
				$row['p_diff'] = $row['Old_Price'] - $row['ListPrice'];
			}
			elseif($row['Price_Diff'] > 0)
			{
				$row['p_diff'] = $row['ListPrice'] - $row['Old_Price'];
			}
			array_push($arr['rs'], $row);

			if($row['prop_update'] == 'New Listing')
			{
				$New_Listing++;
			}
			elseif($row['prop_update'] == 'Sale Pending')
			{
				$Sale_pending++;
			}
			elseif($row['prop_update'] == 'Sold')
			{
				$Sold++;
			}
			elseif($row['prop_update'] == 'Price Drop')
			{
				$Price_drop++;
			}
			elseif($row['prop_update'] == 'Price Increase')
			{
				$Price_increase++;
			}

			if($POST['getMapData'])
			{
				$rsAttributes = Utility::generateListingAttributes($row);

				$arrTemp = array();
				$arrTemp['Key'] 		= $row['ListingID_MLS'];
				$arrTemp['MLS'] 		= $row['MLS_NUM'];
				$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
				$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
				$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
				$arrTemp['Lat'] 		= $row['Latitude'];
				$arrTemp['Long'] 		= $row['Longitude'];
				$arrTemp['CityName'] 	= $row['CityName'];
				$arrTemp['State'] 		= $row['State'];
				$arrTemp['ZipCode'] 	= $row['ZipCode'];
				$arrTemp['Price'] 		= $row['ListPrice'];
				$arrTemp['pupdate'] 	= $row['prop_update'];
				$arrTemp['Bed'] 		= $row['Beds'];
				$arrTemp['Bath'] 		= rtrim(rtrim($row['Baths'],'0'),'.');
				$arrTemp['Sqft'] 		= $row['SQFT'];
				$arrTemp['Year']        = $row['YearBuilt'];
				$arrTemp['Pic'] 		= $row['MainPicture'];
				$arrTemp['Pic_Path'] 	= $row['Pic_Path'];
				$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];
				$arrTemp['PhotoBaseUrl']= $this->Pic_Path;
				$arrTemp['TotalPhotos']	= $row['TotalPhotos'];
				$arrTemp['Photos'] 		= $row['PhotoAll'];
				$arrTemp['sub']         = $row['Subdivision'];
				$arrTemp['status']      = $row['ListingStatus'];
				$arrTemp['DOM']         = $row['DOM'];
				$arrTemp['datetime_diff']   = $row['datetime_diff'];
				$arrTemp['p_diff']      =   $row['p_diff'];
				$arrTemp['subdiv']     = $row['Subdivision'];
				array_push($arr['map-data']['data'], $arrTemp);
			}
		}
		$arr['map-data']['stat']['cnt_new_listing'] = $New_Listing;
		$arr['map-data']['stat']['cnt_sale_pending'] = $Sale_pending;
		$arr['map-data']['stat']['cnt_sold'] = $Sold;
		$arr['map-data']['stat']['cnt_price_drop'] = $Price_drop;
		$arr['map-data']['stat']['cnt_price_increase'] = $Price_increase;

		$arr['map-data'] = base64_encode(gzencode(json_encode(array($arr['map-data']))));

		$arr['total_record'] = $this->total_record;
		$arr['PhotoBaseUrl'] = $this->Pic_Path;

		return $arr;
	}
	public function UpdatePropertySentStatus($Listing_Id, $Status)
	{
		global $db;

		$sql = " UPDATE listing_master M SET M.is_sent_to_user = '".$Status."' WHERE 1 AND UPPER(CONCAT(M.MLS_NUM,'-',M.MLSP_ID)) = '". strtoupper($Listing_Id). "'";

		$db->query($sql);
		return $db->affected_rows();
	}
	public function InsertUpdateSchoolData($school_data)
	{
		global $db;

		if(is_array($school_data) && count($school_data) > 0)
		{
			$values = implode("), (", $school_data);
			$sql = " REPLACE INTO ".$this->Data['Listing_School']." 
            ( ls_gsid, ls_name, ls_type, ls_graderange, ls_enrollment, ls_gsrating, ls_parentrating, ls_city, ls_state, ls_districtid, ls_district, ls_district_nces_id, ls_address, ls_phone, ls_fax, ls_website, ls_nces_id, ls_latitude, ls_longitude, ls_overviewlink, ls_ratingslink, ls_reviewslink, ls_schoolstatslink)
            VALUES (".$values.") ";

			$db->query($sql);
		}
	}
	public function getGreatSchoolData($POST=array())
	{
		global $db;

		$Parameters = "";
		if(isset($POST['ls_city']) && $POST['ls_city'] != '')
			$Parameters .= " AND ls_city = '".$POST['ls_city']."'";
		if(isset($POST['ls_state']) && $POST['ls_state'] != '')
			$Parameters .= " AND ls_state = '".$POST['ls_state']."'";
		$sql = " SELECT LS.* ";
		$sql .= ",( 6378.7 * ACOS( SIN( LS.ls_latitude / 57.2958 ) * SIN( ".$POST['ls_latitude']." / 57.2958 ) + COS( LS.ls_latitude / 57.2958 ) * COS( ".$POST['ls_latitude']." / 57.2958 ) * COS( ".$POST['ls_longitude']." / 57.2958 - ( LS.ls_longitude ) / 57.2958 ) ) ) AS ls_Miles";

		$sql .= " FROM ".$this->Data['Listing_School']." LS WHERE 1 ".$Parameters;

		$sql .= " ORDER BY ls_Miles ";

		if(isset($POST['limit']) && $POST['limit'] > 0)
			$sql .= " LIMIT 0, ".$POST['limit'];

		$rs = $db->query($sql);

		return $rs;
	}

	public function getImageurlById($id)
	{
		global $db, $virtual_path, $config, $asset;
		// echo "<pre>"; print_r($id);
		$sql = " SELECT * FROM ".$this->Data['TriggerSearchByMapsearch']."  WHERE".' MLS_NUM'.' = '."'".$id."'";

		$rs = $db->query($sql);
		$row = $rs->fetch_array();

		# To Get creadential for image loading from amzon s3.
		$s3 = AWS_S3::obj()->aws_s3_get_credential();
		
		if($row['mls_is_pic_url_supported'] == 'Yes')
		{
			foreach ($asset['mlsPhotoType'] as $phototype=>$des){
				$row['MainPicture'][$phototype]['url'] = $row['Main_Photo_Url'];
			}
			if(!isset($row['MainPicture']['thumb']) && isset($row['MainPicture']['large'])){
				$row['MainPicture']['thumb'] = $row['MainPicture']['large'];
			}
	//				$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
		}
		else
		{
			$pic_no = $row[0]['Main_Photo']-1;
			$MLS_NUM = $row[0]['MLS_NUM'];
			$pic_url = $MLS_NUM.'_'.$pic_no.'.jpg';

			$row['MainPicture'] = $this->Pic_Path.'/'.$row[0]['ListingID_MLS']."/".$pic_no."/";

			if (strlen($MLS_NUM)>2)
				$aws_folder_path = substr($MLS_NUM,-2);
			else
				$aws_folder_path = $MLS_NUM;


			if($row[0]['MLSP_ID'] == 2)
			{
				$row['MainPicture'] = $this->Pic_Path_Actris.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
				$MLSFolder = S3_BUCKET_FOLDER_ACTRIS;
			}
			else
			{
				$row['MainPicture'] = $this->Pic_Path_Trestle.'/'.$aws_folder_path."/".$MLS_NUM.'/'.$pic_url;
				$MLSFolder = S3_BUCKET_FOLDER_TRESTLE;
			}
			// echo "<pre>"; print_r($MLSFolder);die;

			# Checking exist image on amzon s3 using curl
			//$url_response = Utility::getInstance()->amazon_s3_url_exists($a);

			# Checking exist image on amazon s3 using aws sdk
			$aws_obj_path = $MLSFolder.'/'.$aws_folder_path.'/'.$MLS_NUM.'/'.$pic_url;
			// echo "<pre>"; print_r($aws_obj_path);

			$obj_response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_obj_path);
			// echo "<pre>"; print_r($obj_response);

			if($obj_response == false)
			{
				$row['MainPicture'] = S3_BUCKET_URL.'/no-photo/no-property-img.jpg';
			}
			// echo "<pre>"; print_r($row);
		}
		return $row;
	}
}
?>