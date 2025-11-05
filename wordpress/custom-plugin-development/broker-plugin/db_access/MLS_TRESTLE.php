<?php
/**
 * Created by PhpStorm.
 * User: opm1
 * Date: 26/09/19
 * Time: 2:55 PM
 */
class MLS_TRESTLE extends MLSProvider
{
	public $MLSP_ID = 1;
	public $Config = array();

	public static $Instance;

	public static function obj()
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self();

		return self::$Instance;
	}
	#=========================================================================================================================
	#	Function Name	:   MLS_MFRRETS
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
	public function __construct($isPopulateSchema=false)
	{
		global $config;

		$this->mlsRecord 					= MLSMaster::obj()->getInfoById($this->MLSP_ID);
		# Table Info
		$this->Data['MLS_Listing'] 			= $config['Table_Prefix']. 'mls_listing';
		// Temp Tables
		$this->Data['MLS_Listing_ID']		= $config['Table_Prefix']. 'mls_listing_id';
		$this->Data['MLS_Open_House']		= $config['Table_Prefix']. 'mls_open_house';

		$this->Data['MLS_Listing_Sold'] 	= $config['Table_Prefix']. 'mls_listing_sold';
		$this->Data['MLS_Listing_Sold_ID'] 	= $config['Table_Prefix']. 'mls_listing_sold_id';
		$this->Data['MLS_Provider']			= $this->mlsRecord['mls_market_title'] ;
		$this->Config['MLS_Host'] 			= $this->mlsRecord['mls_host'];
		$this->Config['MLS_User'] 			= $this->mlsRecord['mls_user'];
		$this->Config['MLS_Passwd'] 		= $this->mlsRecord['mls_passwd'];
		$this->Config['MLS_User_Agent'] 	= $this->mlsRecord['mls_rets_user_agent'];
		$this->Config['MLS_User_Agent_Passwd'] 	= $this->mlsRecord['mls_rets_user_agent_pwd'];
		$this->Config['MLS_Version'] 		= $this->mlsRecord['mls_rets_version'];
		$this->Config['MLS_Format'] 		= $this->mlsRecord['mls_format'];
		$this->Config['MLS_IS_API'] 		= $this->mlsRecord['mls_is_API'];
		$this->Config['MLS_Client_ID'] 		= $this->mlsRecord['mls_client_id'];
		$this->Config['MLS_Token_URL'] 		= $this->mlsRecord['mls_token_url'];
		$this->Config['MLS_Token_Expire_Time'] = $this->mlsRecord['mls_token_expire_time'];
		$this->Config['MLS_Client_Secret'] 		= $this->mlsRecord['mls_client_secret'];
		$this->Config['MLS_Server_Token'] 		= $this->mlsRecord['mls_server_token'];
		$this->Config['MLS_Browser_Token'] 		= $this->mlsRecord['mls_browser_token'];

		# Make call to parent constructor
		parent::__construct();
	}

	#=========================================================================================================================
	#	Function Name	:   Insert
	#	Purpose			:	Insert new information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function Insert($mlsp_id, $Resource, $Class, $LookupVal, $LookupField, $Field_Name, $arrData)
	{
		global $db;
		$sql =	" DELETE FROM ". $this->Data['Metadata_Table'] .
			" WHERE MLSP_ID = '".$mlsp_id."' AND Resource = '".$Resource."' AND Lookup_Name = '".$LookupVal."' ";
		$db->query($sql);
		foreach($arrData as $key => $valArr)
		{
			$sql =	" INSERT INTO ". $this->Data['Metadata_Table'] .
				" (MLSP_ID, Resource, Class, Lookup_Name, Lookup_Field, Field_Name, LongValue, ShortValue, IDValue) ".
				" VALUES (".
				" '".$mlsp_id."', ".
				" '".$Resource."', ".
				" '".$Class."', ".
				" '".$LookupVal."', ".
				" '".$LookupField."', ".
				" '".$Field_Name."', ".
				" '".addslashes($valArr['LongValue'])."', ".
				" '".addslashes($valArr['ShortValue'])."', ".
				" '".addslashes($valArr['Value'])."') ".
				" ON DUPLICATE KEY UPDATE ".
				" MLSP_ID = VALUES(MLSP_ID), ".
				" Resource = VALUES(Resource), ".
				" Class = VALUES(Class), ".
				" Lookup_Name = VALUES(Lookup_Name),".
				" Lookup_Field = VALUES(Lookup_Field), ".
				" Field_Name = VALUES(Field_Name), ".
				" IDValue = VALUES(IDValue) ";
			$db->query($sql);
		}
		return true;
	}
	public function doDataTransfer_RETS2Table_API($retsResource, $retsClass, $retsSelect, $FieldList, $TableName, $property_data, $extra_field='', $extra_value='')
	{
		global $db;

		if(count($property_data) > 0)
		{
			$sqlFields = '';
			$rec_no	= 25;
			$cnt	= 0;
			$sql 	= '';

			//$arr_select_query = array_flip(explode(",",$retsSelect));
			$arr_select_query = explode(",",$retsSelect);

			$arr_select_query = array_fill_keys($arr_select_query, '');



			//echo"<pre>";print_r($retsSelect);die;
			foreach($property_data as $key => $data)
			{
				//$arr_select_query = array_flip(explode(",",$retsSelect));

				if(is_array($data) && count($data) > 0)
				{
					if(isset($data['Media']) && is_array($data['Media']))
					{
						$Media = $data['Media'];
					}

					$listing = array_intersect_key($data,$arr_select_query);

					$a_diff = array_diff_key($arr_select_query, $listing);

					if(is_array($a_diff) && count($a_diff) > 0)
					{
						$listing = $listing + $a_diff;
					}
				}
				else
				{
					echo "================= ERROR :- Field count mis match ============================ \n";
					//echo"<prE>";print_r($data);
					exit();
				}

				//Utility::prE($data);
				// Create sql field list if not prepared yet
				if($sqlFields == '')
				{
					$temp_1 = explode(",",$retsSelect);
					$temp_2 = explode(",",$FieldList);

					$temp = array_combine($temp_1,$temp_2);

					// FALSE ?
					if($temp === false)
					{
						print("Not able to create sql fields list \n\n");

						return false;
					}

					// Get RETS Fields Name array from listin array, get all keys
					$arrRetsField = array_keys($listing);



					foreach($arrRetsField as $key => $val)
					{
						$sqlFields .= $temp[$val].', ';
					}
					//Utility::pre($sqlFields);
					// Remove additional comma
					$sqlFields = trim($sqlFields, ', ');

					if(!empty($sqlFields))
					{
						if ($extra_field=='')
							$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields . ") VALUES ";
						else
							$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields .", ".$extra_field. ") VALUES ";
					}
					else{
						echo "  ERROR =========== MISSING SQL FIELDS  \n";
						//print_r($property_data);
						exit;
					}
				}

				$arrValues = array_values($listing);

				array_walk($arrValues, function(&$a){

					if(is_array($a))
					{
						$a = implode(",",$a);
					}
					else
					{
						$a= $a;
					}
				});

				if($extra_field == 'media')
				{
					$extra_value = serialize($Media);
				}

				$extra_value = addslashes($extra_value);
				$arrValues = array_map( 'addslashes', $arrValues );

				if ($extra_field=='')
					$sql .= "('" . implode("', '", $arrValues) . "'), ";
				else
					$sql .= "('" . implode("', '", $arrValues) . "', '".$extra_value."'), ";


				$cnt++;

				if ($cnt==$rec_no)
				{
					//Insert Data
					$sql = substr($sql,0,strlen($sql)-2);


					# Show debug info
					if(DEBUG)
						$this->__debugMessage($sql);

					$db->db_close();

					$db->reconnect();

					$db->reset_database();

					$db->query($sql);

					$sql = "";

					if ($extra_field=='')
						$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields . ") VALUES ";
					else
						$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields .", ".$extra_field. ") VALUES ";


					$cnt = 0;
				}
			}

			if ($extra_field=='')
				$chksql = "REPLACE INTO ".$TableName." (" . $sqlFields . ") VALUES ";
			else
				$chksql = "REPLACE INTO ".$TableName." (" . $sqlFields .", ".$extra_field. ") VALUES ";



			if ($sql!=$chksql)
			{
				//Insert Data
				$sql = substr($sql,0,strlen($sql)-2);

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);


				$db->query($sql);
			}

		}

	}
	#=========================================================================================================================
	#	Function Name	:   TransferListingToMst
	#	Purpose			:	data insert from temp table to main table
	#-------------------------------------------------------------------------------------------------------------------------
	function TransferListingToMst()
	{
		global $db;

		// Get total count
		$sql =	" SELECT COUNT(*) AS TotalListing FROM ".$this->Data['MLS_Listing'];

		$rs = $db->query($sql);

		$rs->next_record();

		$TotalListing = $rs->f('TotalListing');

		$page_size = 10000;

		if($TotalListing > 0)
		{
			// Delete invalid data
			$sql =	" DELETE FROM ".$this->Data['MLS_Listing']." WHERE StreetName LIKE '%testing%'";
			$rs = $db->query($sql);

			$sql =	" DELETE FROM ".$this->Data['MLS_Listing']." WHERE StateName LIKE '%Other%'";
			$rs = $db->query($sql);

			$sql =	" DELETE FROM ".$this->Data['MLS_Listing']." WHERE CityName LIKE '%other%' OR CityName = '' OR CityName IS NULL";
			$rs = $db->query($sql);

			//$sql =	" DELETE FROM ".$this->Data['MLS_Listing']." WHERE PropertyStatus NOT IN ('Active', 'Hold', 'Pending')";
			//$rs = $db->query($sql);

			// Lets add actual state name in database
			/*$sql =	" UPDATE ".$this->Data['MLS_Listing']." AS T LEFT JOIN geo_state AS S ON T.StateName = S.state_name SET T.State = S.state_code WHERE S.state_name IS NOT NULL";
			$rs = $db->query($sql);*/

			//Update Property Type from actule to desired.
			/*$sql =	" UPDATE ".$this->Data['MLS_Listing']." SET PropertyType = CASE
                        WHEN Temp_PropertyType = 'Commercial Sale' THEN 'Commercial'
                        WHEN Temp_PropertyType = 'Residential Income' THEN 'Income'
                        WHEN Temp_PropertyType = 'Residential Lease' THEN 'Rental'
                        WHEN Temp_PropertyType = 'Residential' THEN 'Residential'
                        WHEN ( Temp_PropertyType = 'Farm' OR Temp_PropertyType = 'Land' ) THEN 'Vacant Land'
                        ELSE Temp_PropertyType END ";*/
			//$rs = $db->query($sql);
		}

		for($i=0; $i<=$TotalListing; $i=$i+$page_size)
		{
			// Master Data Transfer
			$sql =	" INSERT INTO ".$this->Data['TableName'].
				" (MLSP_ID, MLS_NUM, Agent_ID, Agent_ShortID, OfficeID, CoAgent_ID, CoOfficeID, CoAgent_ShortID, SellAgent_ShortID,BuyAgent_ID,CoBuyAgent_ID, ListingKey, 
                    PropertyType, PropertyStyle, ListingStatus, SubType, ".
				" BathsFull, BathsHalf, Beds, TotalAcreage, ListPrice, OriginalListPrice, SQFT, YearBuilt, TotalPhotos,Old_Price,PriceChangeDate,Price_Diff,".
				" Baths, Parking, Garage, Description, Stories, Levels, LastPhotoDate, ListingDate, Category, DisplayAddress,".
				" TotalUnits, TotalRooms, Buildings, Tax, Elementary_School, High_School, Middle_School, School_District, LastUpdateDate, Listing_Created_Date, is_mark_for_deletion, Is_ShortSale, Is_REO)".
				" SELECT ".$this->MLSP_ID.", MLS_NUM, Agent_ID, '', OfficeID, CoAgent_ID, '', '', '',BuyAgent_ID,CoBuyAgent_ID, ListingKey,".
				" PropertyType, PropertyStyle, PropertyStatus, SubType,".
				" IF(BathsFull > 0, BathsFull, 0), IF(BathsHalf > 0, BathsHalf, 0), IF(Beds > 0, Beds, 0), IF( Acreage >0, Acreage, 0), IF(REPLACE(ListPrice,',','') > 0, REPLACE(ListPrice,',',''), 0), OriginalListPrice, IF(SQFT > 0, SQFT, 0), YearBuilt, IF(TotalPhotos > 0,TotalPhotos,0),IF(REPLACE(PreviousListPrice,',','') > 0, REPLACE(PreviousListPrice,',',''), 0),PriceChangeTimestamp, IF(OriginalListPrice > 0, (OriginalListPrice-ListPrice)*100*(-1)/OriginalListPrice, 0),".
				" IF(Baths > 0, Baths, 0), IF(TotalParking > 0, TotalParking, 0), IF(TotalGarage > 0, TotalGarage, 0), PropertyDesc, IF(Stories > 0, Stories, 0), '', LastPhotoDate, ListingDate, '', IF(DisplayAddress = 1, 'Y', 'N'),".
				" IF(TotalUnits > 0, TotalUnits, 0), IF(TotalRooms > 0, TotalRooms, 0), IF(Buildings > 0, Buildings, 0), Tax, Elementary_School, High_School, Middle_School, '', LastUpdateDate, NOW(), 'N', IF(Is_ShortSale = 1, 'Yes', 'No'), IF(Is_REO = 1, 'Yes', 'No')".
				" FROM ".$this->Data['MLS_Listing'].
				" LIMIT ".$i.", ".$page_size.
				" ON DUPLICATE KEY UPDATE Agent_ID = VALUES(Agent_ID), Agent_ShortID = VALUES(Agent_ShortID), BuyAgent_ID = VALUES(BuyAgent_ID),CoBuyAgent_ID = VALUES(CoBuyAgent_ID),ListingKey = VALUES(ListingKey), ".
				" OfficeID = VALUES(OfficeID), PropertyType = VALUES(PropertyType), PropertyStyle = VALUES(PropertyStyle), ".
				" CoAgent_ID = VALUES(CoAgent_ID), CoOfficeID = VALUES(CoOfficeID), CoAgent_ShortID = VALUES(CoAgent_ShortID), SellAgent_ShortID = VALUES(SellAgent_ShortID),".
				" ListingStatus = VALUES(ListingStatus), SubType = VALUES(SubType),".
				" BathsFull = VALUES(BathsFull), BathsHalf = VALUES(BathsHalf), DisplayAddress = VALUES(DisplayAddress),".
				" Beds = VALUES(Beds), TotalAcreage = VALUES(TotalAcreage), ListPrice = VALUES(ListPrice), OriginalListPrice = VALUES(OriginalListPrice), ".
				" SQFT = VALUES(SQFT), YearBuilt = VALUES(YearBuilt), TotalPhotos = VALUES(TotalPhotos), Old_Price = VALUES(Old_Price), PriceChangeDate = VALUES(PriceChangeDate), Price_Diff = VALUES(Price_Diff), School_District = VALUES(School_District),".
				" Parking = VALUES(Parking), Stories = VALUES(Stories), Description = VALUES(Description), Levels = VALUES(Levels),".
				" Elementary_School = VALUES(Elementary_School), High_School = VALUES(High_School), Middle_School = VALUES(Middle_School),".
				" Tax = VALUES(Tax), TotalUnits = VALUES(TotalUnits), TotalRooms = VALUES(TotalRooms), Buildings = VALUES(Buildings), ListingDate = VALUES(ListingDate),".
				" Baths = VALUES(Baths), LastUpdateDate = VALUES(LastUpdateDate), LastPhotoDate = VALUES(LastPhotoDate), is_mark_for_deletion = VALUES(is_mark_for_deletion), Is_ShortSale = VALUES(Is_ShortSale), Is_REO = VALUES(Is_REO)";
			$db->query($sql);

			// Address
			$sql =	" INSERT INTO ".$this->Data['Listing_Address'].
				" (MLS_NUM, Area, StreetNumber, StreetName, StreetDirection, StreetSuffix, StreetSuffix_Short_code, StreetDirPrefix, StreetDirSuffix, UnitNo, UnitNo_2, ZipCode, CityName, Address, ".
				" State, StateName, County, Subdivision, StreetNumberModifier, StreetSuffixModifier, process_flag, entry_date, MLSP_ID)".
				" SELECT MLS_NUM, Area, StreetNumber, StreetName, '', '', '', StreetDirPrefix, StreetDirSuffix, UnitNo, 0, SUBSTRING(ZipCode, 1, 5), CityName, Address, ".
				" State, '', County, REPLACE(Subdivision,'&#xA4;',''), '', '', 'N', UNIX_TIMESTAMP( ), ".$this->MLSP_ID.
				" FROM ".$this->Data['MLS_Listing'].
				" LIMIT ".$i.", ".$page_size.
				" ON DUPLICATE KEY UPDATE Area = VALUES(Area), ".
				" StreetNumber = VALUES(StreetNumber), StreetName = VALUES(StreetName), ".
				" StreetDirection = VALUES(StreetDirection), ZipCode = VALUES(ZipCode), ".
				" StreetSuffix = VALUES(StreetSuffix), StreetSuffix_Short_code = VALUES(StreetSuffix_Short_code), UnitNo = VALUES(UnitNo), StreetDirPrefix = VALUES(StreetDirPrefix), StreetDirSuffix = VALUES(StreetDirSuffix), CityName = VALUES(CityName), Address = VALUES(Address), State = VALUES(State), StateName = VALUES(StateName), County = VALUES(County), Subdivision = VALUES(Subdivision), StreetNumberModifier = VALUES(StreetNumberModifier), StreetSuffixModifier = VALUES(StreetSuffixModifier), UnitNo_2 = VALUES(UnitNo_2)";
			$db->query($sql);

			// Additional Details

			$sql =	" INSERT INTO ".$this->Data['Listing_Additional_Info'].
				" (MLSP_ID, MLS_NUM, Amenities, Construction, Cooling, DrivingDirections, ExteriorFeatures, Flooring, Gas, HOAFee, HOAFrequency, Heating, InteriorFeatures, Is_Pool, Legal, LotDescription, NetOperatingIncome, ParkingFeatures, PetsAllowed, PoolDesc, Roof,  Sewer, SpaYN, TaxYear, View, VirtualTourUrl, Water, WaterfrontDesc, Zoning, Specials, Is_Waterfront, Utilities, SecuritySafety, Appliances, HOAInclude, Basement, BuilderName, BuildingFeatures, CommunityFeatures, Fencing, FireplaceFeatures, FoundationDetails, ParcelNumber, SpaFeatures,StatusChange_DateTime, StoriesFeature, IS_HOA, BuildingName, Sold_Date, Sold_Price, LotSize,ParcelsDescription,LandLeaseAmount,LeaseExpiration,LeaseTerm,Location,MaintenanceExpense,PatioAndPorchFeatures,Possession,Section,TotalActualRent,Township,UnitTypeType,Is_New,Zoning_Description,Window_Features,Direction_Faces,Frontage_Length,LotSize_Area,LotSizeSQFT, Furnished)".
				" SELECT ".$this->MLSP_ID.", MLS_NUM, Amenities, Construction, Cooling, DrivingDirections, ExteriorFeatures, Flooring, Gas, HOAFee, HOAFrequency, Heating, InteriorFeatures, IF(Is_Pool = 1, 'Yes','No'), Legal, LotDescription, NetOperatingIncome, ParkingFeatures, IF(PetsAllowed != '', PetsAllowed, 'No'), PoolDesc, Roof, Sewer, IF(SpaYN = 1, 'Yes','No'), TaxYear, View, VirtualTourUrl, Water, WaterfrontDesc, Zoning, Specials, IF(Is_Waterfront = 1, 'Yes', 'No'), Utilities, SecuritySafety,  Appliances, HOAInclude, Basement, BuilderName, BuildingFeatures, CommunityFeatures, Fencing, FireplaceFeatures, FoundationDetails, ParcelNumber, SpaFeatures,StatusChange_DateTime, StoriesFeature,  IF(IS_HOA = 1, 'Yes', 'No'), BuildingName, Sold_Date, Sold_Price, LotSize,ParcelsDescription,LandLeaseAmount,LeaseExpiration,LeaseTerm,Location,MaintenanceExpense,PatioAndPorchFeatures,Possession,Section,TotalActualRent,Township,UnitTypeType,IsNew, ZoningDescription, WindowFeatures, DirectionFaces, FrontageLength, LotSizeArea, LotSizeSQFT, Furnished".
				" FROM ".$this->Data['MLS_Listing'].
				" LIMIT ".$i.", ".$page_size.
				" ON DUPLICATE KEY UPDATE ".
				" Amenities = VALUES(Amenities), Construction = VALUES(Construction), Cooling = VALUES(Cooling), DrivingDirections = VALUES(DrivingDirections), ExteriorFeatures = VALUES(ExteriorFeatures), Flooring = VALUES(Flooring), Gas = VALUES(Gas), HOAFee = VALUES(HOAFee), HOAFrequency = VALUES(HOAFrequency), Heating = VALUES(Heating), InteriorFeatures = VALUES(InteriorFeatures), Is_Pool = VALUES(Is_Pool), Legal = VALUES(Legal), LotDescription = VALUES(LotDescription), NetOperatingIncome = VALUES(NetOperatingIncome), ParkingFeatures = VALUES(ParkingFeatures), PetsAllowed = VALUES(PetsAllowed), PoolDesc = VALUES(PoolDesc), Roof = VALUES(Roof), Sewer = VALUES(Sewer), SpaYN = VALUES(SpaYN), TaxYear = VALUES(TaxYear),  View = VALUES(View), VirtualTourUrl = VALUES(VirtualTourUrl), Water = VALUES(Water), WaterfrontDesc = VALUES(WaterfrontDesc), Zoning = VALUES(Zoning), Is_Waterfront = VALUES(Is_Waterfront), Specials = VALUES(Specials), Utilities = VALUES(Utilities), SecuritySafety = VALUES(SecuritySafety), 
					 Appliances = VALUES(Appliances), HOAInclude = VALUES(HOAInclude), Basement = VALUES(Basement), BuilderName = VALUES(BuilderName), BuildingFeatures = VALUES(BuildingFeatures), CommunityFeatures = VALUES(CommunityFeatures), Fencing = VALUES(Fencing), FireplaceFeatures = VALUES(FireplaceFeatures), FoundationDetails = VALUES(FoundationDetails), ParcelNumber = VALUES(ParcelNumber), SpaFeatures = VALUES(SpaFeatures), StatusChange_DateTime = VALUES(StatusChange_DateTime), StoriesFeature = VALUES(StoriesFeature),  IS_HOA = VALUES(IS_HOA), BuildingName = VALUES(BuildingName), Sold_Date = VALUES(Sold_Date), Sold_Price = VALUES(Sold_Price),LotSize = VALUES(LotSize), ParcelsDescription = VALUES(ParcelsDescription), LandLeaseAmount = VALUES(LandLeaseAmount), LeaseExpiration = VALUES(LeaseExpiration),LeaseTerm = VALUES(LeaseTerm),Location = VALUES(Location),MaintenanceExpense = VALUES(MaintenanceExpense),PatioAndPorchFeatures = VALUES(PatioAndPorchFeatures),Possession = VALUES(Possession),Section = VALUES(Section),TotalActualRent = VALUES(TotalActualRent),Township = VALUES(Township),UnitTypeType = VALUES(UnitTypeType),Is_New = VALUES(Is_New),Zoning_Description = VALUES(Zoning_Description), Window_Features = VALUES(Window_Features),Direction_Faces = VALUES(Direction_Faces),Frontage_Length = VALUES(Frontage_Length), LotSize_Area = VALUES(LotSize_Area),LotSizeSQFT = VALUES(LotSizeSQFT), Furnished = VALUES(Furnished)";
			$db->query($sql);

			if($TotalListing > 0)
			{
				// Office Data Transfer
				$sql =	" INSERT INTO ".$this->Data['Office_Table'].
					" (Office_ID, Office_MLSP_ID, Office_Name, Office_Phone, Office_ShortID, Office_Email)".
					" SELECT OfficeID, '".$this->MLSP_ID."', Office_Name, Office_Phone, Office_ShortID, Office_Email".
					" FROM ".$this->Data['MLS_Listing']." WHERE OfficeID != '' GROUP BY OfficeID".
					//" LIMIT ".$i.", ".$page_size.
					" ON DUPLICATE KEY UPDATE Office_Name = VALUES(Office_Name), Office_Phone = VALUES(Office_Phone), Office_ShortID = VALUES(Office_ShortID), Office_Email = VALUES(Office_Email)";
				$db->query($sql);
				// Agent Data Transfer
				$sql =	" INSERT INTO ".$this->Data['Agent_Table'].
					" (Agent_ID, Agent_MLSP_ID, Agent_Office_ID, Agent_FName, Agent_LName, Agent_Mobile, Agent_LicenseNumber, Agent_ShortID, Agent_Email, Agent_HomePhone)".
					" SELECT Agent_ID, '".$this->MLSP_ID."', OfficeID, Agent_FName, Agent_LName, Agent_Mobile, Agent_LicenseNumber, Agent_ShortID, Agent_Email, Agent_HomePhone".
					" FROM ".$this->Data['MLS_Listing']." WHERE Agent_ID != '' GROUP BY Agent_ID".
					//	" LIMIT ".$i.", ".$page_size.
					" ON DUPLICATE KEY UPDATE Agent_Office_ID = VALUES(Agent_Office_ID), Agent_FName = VALUES(Agent_FName), Agent_LName = VALUES(Agent_LName), Agent_Mobile = VALUES(Agent_Mobile), Agent_ShortID = VALUES(Agent_ShortID), Agent_Email = VALUES(Agent_Email), Agent_HomePhone = VALUES(Agent_HomePhone)";
				$db->query($sql);
			}
		}

		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   UpdateListingLog
	#	Use				:	Maintain listing history like New listing or price updated or deleted listing or status changed
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateListingLog($MLSP_ID, $log_last_update_date)
	{
		global $db;

		$sql =	" INSERT INTO ".$this->Data['Listing_Log'].
			" (lslog_mls_num, lslog_mlsp_id, lslog_status, lslog_actual_status, lslog_old_status, lslog_price, lslog_price_per_sqft, lslog_old_price, lslog_price_diff, lslog_source, lslog_ref_date, lslog_date)".

			" SELECT LM.MLS_NUM, LM.MLSP_ID,".
			" CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') = CURDATE()) THEN 'Listed' WHEN (ListingStatus != lslog_actual_status AND LM.is_mark_for_deletion = 'N' ) THEN 'Status Change' WHEN (ListPrice != lslog_price) THEN 'Price Change' WHEN (LM.is_mark_for_deletion = 'Y' AND DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') = CURDATE()) THEN 'Listing Removed' END,".
			" ListingStatus, lslog_actual_status, ListPrice, IF(SQFT > 0, ListPrice/SQFT, 0), lslog_price, IF(lslog_price > 0, (lslog_price-ListPrice)*100*(-1)/lslog_price, 0), Office_Name, ".
			" CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') = CURDATE() AND ListingStatus = 'Active' ) THEN DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') WHEN (ListingStatus = 'Active with Contract') THEN DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') ELSE CURDATE() END,".
			" CURDATE()".
			" FROM ".$this->Data['TableName']." AS LM".
			" LEFT JOIN ". $this->Data['Office_Table']." AS O ON LM.OfficeID = O.Office_ID AND LM.MLSP_ID = O.Office_MLSP_ID ".
			" LEFT JOIN ".$this->Data['Listing_Log']." AS PL ON PL.lslog_mls_num = LM.MLS_NUM AND PL.lslog_mlsp_id = LM.MLSP_ID".
			" AND lslog_datetime = (SELECT lslog_datetime FROM ".$this->Data['Listing_Log']." WHERE lslog_mls_num = PL.lslog_mls_num AND lslog_mlsp_id = PL.lslog_mlsp_id ORDER BY lslog_datetime DESC LIMIT 1)".

			" WHERE ListingStatus IN ('Active','Active with Contract') AND (Listing_Created_Date >= '$log_last_update_date' OR LastUpdateDate >= '$log_last_update_date') AND (".
			" (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') = CURDATE())". 		// New Listing
			" OR (ListPrice != lslog_price)". 					// Price Changed
			" OR (LM.is_mark_for_deletion = 'Y' AND DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') = CURDATE())".
			" ) AND LENGTH(SUBSTRING_INDEX((lslog_price-ListPrice)*100*(-1)/lslog_price, '.',1)) <= 4 ". // Listing Removed

			" ON DUPLICATE KEY UPDATE lslog_mls_num = VALUES(lslog_mls_num), lslog_price_per_sqft = VALUES(lslog_price_per_sqft)";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$db->query($sql);
	}
	#=========================================================================================================================
	#	Function Name	:   downloadMetaData
	#	Use				:	Download metadata for selected fields to use them with search form
	#-------------------------------------------------------------------------------------------------------------------------
	public function downloadMetaData($MLSP_ID)
	{
		global $db, $physical_path;

		// check for errors
		if (MLS_TRESTLE::obj()->Config['MLS_IS_API'] == 'Yes' && !empty(MLS_TRESTLE::obj()->Config['MLS_Client_ID']) && !empty(MLS_TRESTLE::obj()->Config['MLS_Client_Secret'])  && !empty(MLS_TRESTLE::obj()->Config['MLS_Browser_Token'])) {
			echo "  + Connected<br>\n";
		}
		else {
			echo "  + Not connected:<br>\n";
			echo " Missing Data";
			//print_r($rets->Error());
			exit;
		}

		//$Base_Url = MLS_BRIDGE::obj()->Config['MLS_Host']."/$metadata?";

		// API path
		$url = 'https://api-prod.corelogic.com/trestle/odata/$metadata';

		// Lets call API & get XML
		$result = Utility::readUrl($url, '', '', '', MLS_TRESTLE::obj()->Config['MLS_Browser_Token']);

		//MLS_BRIDGE::obj()->MLSP_ID
		// Save response to XML file
		$xmlFile = $physical_path['Cronjob'].'/'.$this->picPath['MLS_Pic_Folder'][MLS_TRESTLE::obj()->MLSP_ID].'/metadata.xml';

		file_put_contents($xmlFile, $result["Result"]);

		if(file_exists($xmlFile))
		{
			$xmlData = file_get_contents($xmlFile);

			$xmlData = $this->html_compress($xmlData);

			// We are getting all lookvalues in <EnumType></EnumType> tags, so find all those tags from xml file
			preg_match_all('#<EnumType[^>]*Name="([^"]*?)"[^>]*[^/]>(.*?)</EnumType>#is', $xmlData, $parsedData);

			$arrMeta = array();

			if(count($parsedData) > 0 && is_array($parsedData[1]) && is_array($parsedData[2]))
			{


				for($i=0; $i<count($parsedData[1]); $i++)
				{
					$arrMeta[$parsedData[1][$i]] = array();

					// Lets collect look values
					//preg_match_all('#<Member[^>]*Name="([^"]*?)"/>#is', $parsedData[2][$i], $parsedLookVals);
					preg_match_all('/<[\s]*Member[\s]*(?:name|property)="?' . '([^>"]*)"?[\s]*' . 'value="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $parsedData[2][$i], $parsedLookVals);

					if(count($parsedLookVals) > 0 && is_array($parsedLookVals[1]))
					{
						for($j=0; $j<count($parsedLookVals[1]); $j++)
						{
							array_push($arrMeta[$parsedData[1][$i]], $parsedLookVals[1][$j]);
						}
					}

				}
			}

			// Now we have array with fieldname & their lookup values
			if(count($arrMeta) > 0)
			{
				$Record = MLSConfig::obj()->getAllbyParam($this->MLSP_ID);

				foreach ($Record as $key => $recArr)
				{
					$arrLookup = explode(',',$recArr['LookupList']);
					$arrLookup = array_filter($arrLookup);
					$arrLookupField = explode(',',$recArr['LookupFieldList']);
					$arrLookupField = array_filter($arrLookupField);
					$arrFieldList = explode(',',$recArr['FieldList']);
					$arrFieldList = array_filter($arrFieldList);
					$arrSelectQuery = explode(',',$recArr['SelectQuery']);
					$arrSelectQuery = array_filter($arrSelectQuery);
					$arrFieldName = array();
					if ((count($arrSelectQuery)==count($arrFieldList)) && (count($arrSelectQuery) > 0 && count($arrFieldList) > 0))
						$arrFieldName = array_combine($arrSelectQuery,$arrFieldList);


					if (count($arrLookup)>0)
					{
						foreach ($arrLookup as $Lookupkey => $LookupVal)
						{

							if(array_key_exists($LookupVal, $arrMeta) !== false)
							{
								$arr_Data = $arrMeta[$LookupVal];

								if(count($arr_Data) > 0)
								{
									$ret = $this->InsertMetaData($this->MLSP_ID, $recArr['Resource'], $recArr['Class'], $LookupVal, $arrLookupField[$Lookupkey], $arrFieldName[$arrLookupField[$Lookupkey]], $arr_Data);
								}
							}
						}
					}
				}

				print "\n\nMetadata has been downloaded successfully\n\n";
			}
			else
			{
				print "\n\nDid not able to parse XML properly!\n\n";
			}
		}
	}
	#=========================================================================================================================
	#	Function Name	:   InsertMetaData
	#	Purpose			:	Insert New Meta & cleaup old ones
	#-------------------------------------------------------------------------------------------------------------------------
	public function InsertMetaData($mlsp_id, $Resource, $Class, $LookupVal, $LookupField, $Field_Name, $arrData)
	{
		global $db;

		$sql =	" DELETE FROM ". $this->Data['Metadata_Table'] .
			" WHERE MLSP_ID = '".$mlsp_id."' AND Resource = '".$Resource."' AND Lookup_Name = '".$LookupVal."' ";
		$db->query($sql);

		$sqlValues = array();

		foreach($arrData as $key => $val)
		{
			array_push($sqlValues, " ('".$mlsp_id."', ".
			                     " '".$Resource."', ".
			                     " '".$Class."', ".
			                     " '".$LookupVal."', ".
			                     " '".$LookupField."', ".
			                     " '".$Field_Name."', ".
			                     " '".addslashes($val)."', ".
			                     " '".addslashes($val)."', ".
			                     " '".addslashes($val)."')");

		}

		if(count($sqlValues) > 0)
		{
			$sql =	" INSERT INTO ". $this->Data['Metadata_Table'] .
				" (MLSP_ID, Resource, Class, Lookup_Name, Lookup_Field, Field_Name, LongValue, ShortValue, IDValue) ".
				" VALUES ".implode(",", $sqlValues);

			$db->query($sql);
		}

		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   html_compress
	#	Use				:	Cleanup given html by removing extra spaces, lines, tabs etc...
	#-------------------------------------------------------------------------------------------------------------------------
	function html_compress($html)
	{
		//preg_match_all('!(<(?:code|pre).*>[^<]+</(?:code|pre)>)!',$html,$pre);#exclude pre or code tags

		//$html = preg_replace('!<(?:code|pre).*>[^<]+</(?:code|pre)>!', '#pre#', $html);#removing all pre or code tags

		$html = preg_replace('#<!�[^\[].+�>#', '', $html);#removing HTML comments

		$html = preg_replace('/[\r\n\t]+/', ' ', $html);#remove new lines, spaces, tabs

		$html = preg_replace('/>[\s]+</', '><', $html);#strip whitespaces after/before tags, except space

		$html = preg_replace('/[\s]+/', ' ', $html);#strip multiple whitespaces

		return $html;
	}

	#=========================================================================================================================

	#	Function Name	:   InsertPhotoData

	#	Purpose			:	data insert from temp table to photo table

	#-------------------------------------------------------------------------------------------------------------------------

	function InsertPhotoData($strListingIds='')

	{

		global $db;



		if($strListingIds != '')

		{

			$strListingIds = str_replace(",", "','", $strListingIds);



			// Delete Old entries from phoros table if any

			$sql =	" DELETE FROM ".$this->Data['MLS_Photo_Table'].

				" WHERE ListingKey IN('".$strListingIds."')";



			$db->query($sql);



			/*// Delete Old entries from virtual table if any

			$sql =	" DELETE FROM ".$this->Data['MLS_Virtual_Tour_Table'].

					" WHERE MLS_NUM IN('".$strListingIds."')";



			$db->query($sql);		*/



		}



		/*$sql =	" UPDATE ".$this->Data['MLS_Tmp_Photo_Data'].

			" SET Media_URL = REPLACE(Media_URL, 'http://', 'https://')";*/

		//" WHERE Media_Type = 'Photo'";



		//$db->query($sql);

		// Photo Data Transfer

		$sql =	" INSERT INTO ".$this->Data['MLS_Photo_Table'].

			" SELECT ListingKey, ".$this->MLSP_ID.", ListingKey, 'large', Media_Caption, Media_Description, Media_DisplayOrder, Media_URL, CURDATE()".

			" FROM ".$this->Data['MLS_Tmp_Photo_Data'];

		//" WHERE Media_Type = 'Photo'";



		$db->query($sql);

		$sql =	" UPDATE ".$this->Data['TableName']." M".
			" INNER JOIN ".$this->Data['MLS_Tmp_Photo_Data']." AS P ON M.ListingKey = P.ListingKey AND M.MLSP_ID = '".$this->MLSP_ID."'".
			" SET Pic_Download_Flag = 'Y', Pic_Updated_Date = NOW() ";

		$db->query($sql);

	}
	#=========================================================================================================================

	#	Function Name	:   InsertMainPhotoData

	#	Purpose			:	insert main photo to master table

	#-------------------------------------------------------------------------------------------------------------------------

    function InsertMainPhotoData($data)

	{

		global $db;

		$sql =	" UPDATE ".$this->Data['TableName']." M".
			" SET Main_Photo_Url = '".$data['MediaURL']."' WHERE ListingKey = '".$data['ResourceRecordKey']. "' AND MLSP_ID = '".$this->MLSP_ID."'";


		$db->query($sql);

	}
	#=========================================================================================================================

	#	Function Name	:   InsertOpenHouseData

	#	Purpose			:	data insert from temp table to open House table

	#-------------------------------------------------------------------------------------------------------------------------
	function InsertOpenHouseData()
	{
		global $db;

		// Delete Information which have close date in past.
		$sql =	" DELETE FROM ".$this->Data['Listing_Open_House'].
			" WHERE DATE(OH_Date) < CURDATE() AND MLSP_ID = '".$this->MLSP_ID."'";

		$db->query($sql);

		// Master Data Transfer
		$sql =	" INSERT INTO ".$this->Data['Listing_Open_House'].
			" SELECT OP.MLS_NUM, ".$this->MLSP_ID.", OH_Begins, OH_Close, OH_DisplayTime, OH_Date, CURDATE()".
			" FROM ".$this->Data['MLS_Open_House']." AS OP".
			" LEFT JOIN ".$this->Data['TableName']." AS M ON M.MLS_NUM = OP.MLS_NUM AND M.MLSP_ID = '".$this->MLSP_ID."'".
			" WHERE M.is_mark_for_deletion = 'N'".
			" ON DUPLICATE KEY UPDATE OH_Begins = VALUES(OH_Begins),OH_Close = VALUES(OH_Close),OH_DisplayTime = VALUES(OH_DisplayTime)";

		$db->query($sql);
	}
}

?>