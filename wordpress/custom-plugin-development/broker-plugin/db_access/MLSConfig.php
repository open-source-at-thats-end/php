<?php
#=============================================================================================================================
#	File Name		:	MLSConfig.php
#=============================================================================================================================
class MLSConfig extends CustomClass
{
    public static $Instance;
	public static function obj($isPopulateSchema=false)
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self($isPopulateSchema);
		return self::$Instance;
	}
    #=========================================================================================================================
	#	Function Name	:   RETS_Setting
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    public function __construct($isPopulateSchema=false)
    {
		global $physical_path, $virtual_path, $asset, $config;
		$this->arrFieldList['ActiveAgent'] 	= array(  "None"					=>	"===========",
													"Agent_ID"				=>	"Agent ID",
													"Agent_Office_ID"		=>	"Office ID",
													"Agent_FName"			=>	"First Name",
													"Agent_LName"			=>	"Last Name",
													"Agent_Email"			=>	"Email",
													"Agent_Mobile"			=>	"Mobile",
													"Agent_HomePhone"		=>	"Home Phone",
													"Agent_Fax"				=>	"Fax",
                                                    "Agent_ShortID"			=>	"Agent Short ID",
										);
		$this->arrFieldList['Office'] 	= array(	"None"					=>	"===========",
													"Office_ID"				=>	"Office ID",
													"Office_Name"			=>	"Office Name",
													"Office_Phone"			=>	"Office Phone",
													"Office_Email"			=>	"Office Email",
													"Office_LastUpdatedDate"=>	"Last Updated",
                                                    "Office_ShortID"        =>  "Office Short ID",
										);
		// From CRRMove [MFRRETS]
		/*$this->arrFieldList['Property'] = array(
													"Acreage"				=>	"Acreage",
													"Area"				=>	"Area",
													"BathsFull"				=>	"# Full Baths",
													"BathsHalf"				=>	"# Half Baths",
													"Beds"					=>	"# Bedrooms",
													"Baths"					=>	"# Baths",
													"PropertyType"			=>	"Property Type",
													"CityName"				=>	"City",
													"County"				=>	"County",
													"LastUpdateDate"		=>	"Last Modified",
													"Elementary_School"		=>	"Elementary School",
													"ExteriorFeatures"		=>	"Exterior Features",
													"TotalParking"			=>	"# Parking",
													"TotalGarage"			=>	"# Garage",
													"LotDescription"		=>	"Lot Description",
													"MiscExterior"			=>	"Misc. Exterior",
													"NewOwned"				=>	"New/Owned",
													"Rooms"					=>	"Rooms",
													"Stories"				=>	"# Stories",
													"PropertyStyle"			=>	"Property Style",
													"GroundLevelYN"			=>	"Ground Level?",
													"Agent_ID"				=>	"Agent ID",
													"Agent_Phone"			=>	"Agent Phone",
													"Agent_Name"			=>	"Agent Name",
													"CoAgent_ID"			=>	"Co-Agent ID",
													"ListPrice"				=>	"List Price",
													"OriginalListPrice"		=>	"Original List Price",
													"OfficeID"				=>	"Office ID",
													"Office_Name"			=>	"Office Name",
													"Office_Phone"			=>	"Office Phone",
													"CoOfficeID"			=>	"Co-Office ID",
													"Middle_School"			=>	"Middle School",
													"High_School"			=>	"High School",
													"MLS_NUM"				=>	"Listing Number",
													"TotalPhotos"			=>	"# Photos",
													"SQFT"					=>	"SQFT",
													"PropertyStatus"		=>	"Status",
													"StreetDirection"		=>	"Street Direction",
													"StreetName"			=>	"Street Name",
													"StreetNumber"			=>	"Street Number",
													"StreetSuffix"			=>	"Street Suffix",
													"Subdivision"			=>	"Subdivision",
													//"Subsection"			=>	"Subsection",
													"UnitNo"				=>	"Unit Number",
													//"NumberofLots"			=>	"Number of Lots",
													//"RoadFrontage"			=>	"Road Frontage",
													"YearBuilt"				=>	"Year Built",
													"ZipCode"				=>	"Zip",
													"Zoning"				=>	"Zoning",
													"RentType"				=>	"Rent Type",
													"WeeklyRate"			=>	"Weekly Rate",
													"Furnished"				=>	"Furnished",
													"State"					=>	"State",
													"SubType"				=>	"Sub Type",
													"TaxMapNumber"			=>	"Tax Map Number",
													"PropertyName"			=>	"Property Name",
													"PropertyDesc"			=>	"Property Description",
													"Utilities"				=>	"Utilities",
													"LotDimensions"			=>	"Lot Dimensions",
													//"AuctionType"			=>	"Auction Type",
													//"AuctionYN"				=>	"Auction Y/N",
													"Cooling"				=>	"Cooling",
													"Fireplace"				=>	"# Fireplace",
													"Heating"				=>	"Heating",
													"Roof"					=>	"Roofing",
													"Water"					=>	"Water",
													"Sewer"					=>	"Sewer",
													"DisplayAddress"		=>	"Display Address Y/N",

													"Latitude"				=>	"Latitude",
													"Longitude"				=>	"Longitude",
													"DrivingDirections"		=>	"Driving Directions",
													"ParkingType"			=>	"Parking Type",
													"ParkingFeatures"		=>	"Parking Features",


													"WaterHeaterFeatures"	=>	"WaterHeater Features",
													"Levels"				=>	"Levels",
													"SecuritySafety"		=>	"Security Safety",
													"KitchenFeatures"		=>	"Kitchen Features",
													"InteriorFeatures"		=>	"Interior Features",
													"FireplaceFeatures"		=>	"FireplaceFeatures",
													"Appliances"			=>	"Appliances",
													"SchoolDistrict"		=>	"SchoolDistrict",
													"OwnersName"			=>	"OwnersName",

													"ListingKey"			=>	"Listing Key",
													"LastPhotoDate"			=>	"LastPhotoDate",
													"ListingDate"			=>	"Listing Date",
													"View"					=>	"View",

													"Basement"				=>	"Basement",
													"Flooring"				=>	"Flooring",
													"Kitchen"				=>	"Kitchen",
													"LaundryRoom"			=>	"Laundry Room",
													"LivingRoom"			=>	"Living/Great Rm",
													"MasterBedroom"			=>	"Master Bedroom",
													"StudyRoom"				=>	"Study(Lib/Den)",

													"Garage"				=>	"Garage Features",
													"PetsAllowed"			=>	"Pets Allowed ?",

													// Will added to master table
													"TotalRooms"			=>	"# Rooms",
													"TotalUnits"			=>	"# Units",
													"Buildings"				=>	"# Buildings",
													"Age"					=>	"Age",
													"Tax"					=>	"Taxes",
													"IsNew"					=>	"New Construction ?",
													"HOAFee"				=>	"HOA Amount",
													"HOAInclude"			=>	"HOA Includes",
                                                    "HOAFrequency"          =>  "HOA Frequency",
													"IsAuction"				=>	"Auction",
													"DOM"					=>	"Day On Market",
													"OccupantName"			=>	"Occupant Name",

													// Address field
													"StreetNumberModifier"	=>	"Street Number Modifier",

													// Virtual Tour
													"VirtualTourUrl"		=>	"Virtual Tour Url",

													"TaxRemarks"			=>	"Tax Remarks",	// vc 25
													"TaxYear"				=>	"Tax Year",

													"Bed1_Area"			=>	"Bed1 Area",

													"Bed2_Area"			=>	"Bed2 Area",

													"Bed3_Area"			=>	"Bed3 Area",

													"Bed4_Area"			=>	"Bed4 Area",

													"DiningRm_Area"			=>	"DiningRm Area",

													"FamilyRm_Area"			=>	"FamilyRm Area",

													"Kitchen_Area"			=>	"Kitchen Area",

													"LivingRm_Area"			=>	"LivingRm Area",

													"UtilityRm_Area"			=>	"UtilityRm Area",
													"MasterBedRm_Area"			=>	"MasterBedRm Area",


													"Den_Area"				=>	"Den Area",

													"Porch_Area"			=>	"Porch Area",

													"Bed5_Area"				=>	"Bed5 Area",

													"GuestRm_Area"			=>	"GuestRm Area",

													"BalconyRm_Area"		=>	"BalconyRm Area",

													"LaundryRm_Area"		=>	"LaundryRm Area",

													"Legal"					=>	"Legal",

													"Construction"			=>	"Construction",
													"Gas"					=>	"Gas",
													"Electricity"			=>	"Electricity",
													"Specials"				=>	"Specials",
													"Is_Waterfront"			=>	"Waterfront ?",
													"WaterfrontDesc"		=>	"Waterfront",
													"Is_Pool"				=>	"Pool ?",
													"Is_ShortSale"			=>	"Short Sale ?",
													"Amenities"				=>	"Amenities",
													"Is_REO"				=>	"REO ?",

													"PoolDesc" 				=> "Pool Description",
													"AirConditioning" 		=> "Air Conditioning",
													"Address"				=>	"Address",

														/*"ADOM" => "ADOM",
"ClosingDate" => "ClosingDate",
"DevelopmentName" => "DevelopmentName",
"EntryDate" => "EntryDate",
"FrontExposure" => "FrontExposure",
"GeographicArea" => "GeographicArea",
"Is_IDX" => "Is_IDX",
"ParkingRestrictions" => "ParkingRestrictions",
"PetRestrictions" => "PetRestrictions",
"Restrictions" => "Restrictions",
"SalePrice" => "SalePrice",
"PropertySqFt" => "PropertySqFt",
"WaterAccess" => "WaterAccess",
															"MaintenanceCharge_Month" => "MaintenanceCharge_Month",
"UnitView" => "UnitView",
															"ComplexweName" => "ComplexweName",
"INumber" => "INumber",
"RenewableRental" => "RenewableRental",
"RentalDepositIncludes" => "RentalDepositIncludes",
"RentalPaymentIncludes" => "RentalPaymentIncludes",
															"RentPeriod"	=>	"RentPeriod",
															"Floors"				=>	"# Floors",
															"PropertyDesc2"	=>	"Property Description [Small]",
															"StatusChangeDate" => "Status Change Date"*/
									/*	);*/
		// Flex MlS
		$this->arrFieldList['Property'] = array(
													"Acreage"				=>	"Acreage",
													"Area"				=>	"Area",
													"BathsFull"				=>	"# Full Baths",
													"BathsHalf"				=>	"# Half Baths",
													"Beds"					=>	"# Bedrooms",
													"Baths"					=>	"# Baths",
													"PropertyType"			=>	"Property Type",
													"CityName"				=>	"City",
													"County"				=>	"County",
													"LastUpdateDate"		=>	"Last Modified",
													"Elementary_School"		=>	"Elementary School",
													"ExteriorFeatures"		=>	"Exterior Features",
													"TotalParking"			=>	"# Parking",
													"TotalGarage"			=>	"# Garage",
													"LotDescription"		=>	"Lot Description",
													"MiscExterior"			=>	"Misc. Exterior",
													"NewOwned"				=>	"New/Owned",
													"Rooms"					=>	"Rooms",
                                                    "Stories"				=>	"# Stories",
													"TotalFloor"			=>	"# Floors",
													"PropertyStyle"			=>	"Property Style",
													"GroundLevelYN"			=>	"Ground Level?",
													"Agent_ID"				=>	"Agent ID",
													"CoAgent_ID"			=>	"Co-Agent ID",
													"BuyAgent_ID"			=>	"Buy Agent ID",
													"CoBuyAgent_ID"			=>	"Co-Buy Agent ID",
													"ListPrice"				=>	"List Price",
													"OriginalListPrice"		=>	"Original List Price",
													"OfficeID"				=>	"Office ID",
													"CoOfficeID"			=>	"Co-Office ID",
													"Middle_School"			=>	"Middle School",
													"High_School"			=>	"High School",
													"MLS_NUM"				=>	"Listing Number",
													"TotalPhotos"			=>	"# Photos",
													"SQFT"					=>	"SQFT",
													"PropertyStatus"		=>	"Status",
													"StreetDirection"		=>	"Street Direction",
													"StreetName"			=>	"Street Name",
													"StreetNumber"			=>	"Street Number",
													"StreetSuffix"			=>	"Street Suffix",
                                                    "StreetDirPrefix"       =>  "Street DirPrefix",
                                                    "StreetDirSuffix"       =>  "Street DirSuffix",
													"Subdivision"			=>	"Subdivision",
													//"Subsection"			=>	"Subsection",
													"UnitNo"				=>	"Unit Number",
													//"NumberofLots"			=>	"Number of Lots",
													//"RoadFrontage"			=>	"Road Frontage",
													"YearBuilt"				=>	"Year Built",
													"ZipCode"				=>	"Zip",
													"Zoning"				=>	"Zoning",
													"RentType"				=>	"Rent Type",
													"WeeklyRate"			=>	"Weekly Rate",
													//"Furnished"				=>	"Furnished",
													"State"					=>	"State",
													"SubType"				=>	"Sub Type",
													"TaxMapNumber"			=>	"Tax Map Number",
													"PropertyName"			=>	"Property Name",
													"PropertyDesc"			=>	"Property Description",
													"Utilities"				=>	"Utilities",
													"LotDimensions"			=>	"Lot Dimensions",
													//"AuctionType"			=>	"Auction Type",
													//"AuctionYN"				=>	"Auction Y/N",
													"Cooling"				=>	"Cooling",
													"Fireplace"				=>	"# Fireplace",
													"Heating"				=>	"Heating",
													"Roof"					=>	"Roofing",
													"Water"					=>	"Water",
													"Sewer"					=>	"Sewer",
													"DisplayAddress"		=>	"Display Address Y/N",
													"Amenities"				=>	"Amenities",

													"Latitude"				=>	"Latitude",
													"Longitude"				=>	"Longitude",
													"DrivingDirections"		=>	"Driving Directions",
													"ParkingType"			=>	"Parking Type",
													"ParkingFeatures"		=>	"Parking Features",


													"WaterHeaterFeatures"	=>	"WaterHeater Features",
													"Levels"				=>	"Levels",
													"SecuritySafety"		=>	"Security Safety",
													"KitchenFeatures"		=>	"Kitchen Features",
													"InteriorFeatures"		=>	"Interior Features",
													"FireplaceFeatures"		=>	"FireplaceFeatures",
													"Appliances"			=>	"Appliances",
													"SchoolDistrict"		=>	"SchoolDistrict",
													"Owner"					=>	"Owner Name",

													"ListingKey"			=>	"Listing Key",
													"LastPhotoDate"			=>	"LastPhotoDate",
													"ListingDate"			=>	"Listing Date",
													"View"					=>	"View",

                                                    "Furnished"             =>  "Furnished",
													"Basement"				=>	"Basement",
													"Flooring"				=>	"Flooring",
													"Kitchen"				=>	"Kitchen",
													"LaundryRoom"			=>	"Laundry Room",
													"LivingRoom"			=>	"Living/Great Rm",
													"MasterBedroom"			=>	"Master Bedroom",
													"StudyRoom"				=>	"Study(Lib/Den)",

													"Garage"				=>	"Garage Features",
													"PetsAllowed"			=>	"Pets Allowed ?",

													// Will added to master table
													"TotalRooms"			=>	"# Rooms",
													"TotalUnits"			=>	"# Units",
													"Buildings"				=>	"# Buildings",
													"Age"					=>	"Age",
													"Tax"					=>	"Taxes",
													"IsNew"					=>	"New Construction ?",
													"HOAFee"				=>	"HOA Amount",
													"HOAInclude"			=>	"HOA Includes",
                                                    "HOAFrequency"          =>  "HOA Frequency",
													"IsAuction"				=>	"Auction",
													"DOM"					=>	"Day On Market",
													"OccupantName"			=>	"Occupant Name",

													// Address field
													"Suburb"				=>	"Suburb",
													"StreetNumberModifier"	=>	"Street Number Modifier",

													// Virtual Tour
													"VirtualTourUrl"		=>	"Virtual Tour Url",

													"TaxRemarks"			=>	"Tax Remarks",	// vc 25
													"TaxYear"				=>	"Tax Year",

													"Bed1_Length"			=>	"Bed1 Length",
													"Bed1_Width"			=>	"Bed1 Width",
													"Bed1_Remark"			=>	"Bed1 Remarks",
													"Bed2_Length"			=>	"Bed2 Length",
													"Bed2_Width"			=>	"Bed2 Width",
													"Bed2_Remark"			=>	"Bed2 Remarks",
													"Bed3_Length"			=>	"Bed3 Length",
													"Bed3_Width"			=>	"Bed3 Width",
													"Bed3_Remark"			=>	"Bed3 Remarks",
													"Bed4_Length"			=>	"Bed4 Length",
													"Bed4_Width"			=>	"Bed4 Width",
													"Bed4_Remark"			=>	"Bed4 Remarks",
													"DiningRm_Length"			=>	"DiningRm Length",
													"DiningRm_Width"			=>	"DiningRm Width",
													"DiningRm_Remark"			=>	"DiningRm Remarks",
													"FamilyRm_Length"			=>	"FamilyRm Length",
													"FamilyRm_Width"			=>	"FamilyRm Width",
													"FamilyRm_Remark"			=>	"FamilyRm Remarks",
													"Kitchen_Length"			=>	"Kitchen Length",
													"Kitchen_Width"			=>	"Kitchen Width",
													"Kitchen_Remark"			=>	"Kitchen Remarks",
													"LivingRm_Length"			=>	"LivingRm Length",
													"LivingRm_Width"			=>	"LivingRm Width",
													"LivingRm_Remark"			=>	"LivingRm Remarks",
													/*"SunRm_Length"			=>	"SunRm Length",
													"SunRm_Width"			=>	"SunRm Width",
													"SunRm_Remark"			=>	"SunRm Remarks",
													"UtilityRm_Length"			=>	"UtilityRm Length",
													"UtilityRm_Width"			=>	"UtilityRm Width",
													"UtilityRm_Remark"			=>	"UtilityRm Remarks",
													*/
													"Den_Length"			=>	"Den Length",
													"Den_Width"				=>	"Den Width",
													"Den_Remark"			=>	"Den Remarks",
													"Porch_Length"			=>	"Porch Length",
													"Porch_Width"			=>	"Porch Width",
													"Porch_Remark"			=>	"Porch Remarks",

													/*"GuestRm_Length"			=>	"GuestRm Length",
													"GuestRm_Width"				=>	"GuestRm Width",
													"GuestRm_Remark"			=>	"GuestRm Remarks",

													"BalconyRm_Length"			=>	"BalconyRm Length",
													"BalconyRm_Width"			=>	"BalconyRm Width",
													"BalconyRm_Remark"			=>	"BalconyRm Remarks",
													"LaundryRm_Length"			=>	"LaundryRm Length",
													"LaundryRm_Width"			=>	"LaundryRm Width",
													"LaundryRm_Remark"			=>	"LaundryRm Remarks",*/
													"Legal"						=>	"Legal",
													"Construction"				=>	"Construction",
													"PrivateRemarks"       		=> 	"Private Remarks",

													// Add new
													"PatioRm_Length"		=>	"PatioRm Length",
													"PatioRm_Width"			=>	"PatioRm Width",
													"PatioRm_Remark"		=>	"PatioRm Remarks",
													"Is_Waterfront"			=>	"Waterfront ?",
													"WaterfrontDesc"		=>	"Waterfront",
													"Is_Pool"				=>	"Pool ?",
													"PoolDesc" 				=>  "Pool Description",

													"PropertyStatus2"		=>	"Property Status [REO/Short Sale etc]",

                                                    // Added for Flexmls [Dytona Feed]
                                                    "Office_Name"			 =>	"Office Name",
                                                    "Office_Email"			 =>	"Office Email",
                                                    "Office_Phone"			 =>	"Office Phone",
                                                    "Office_ShortID"		=>	"Office Short ID",
                                                    "Agent_Name"			=>	"Agent Name",
                                                    "Agent_FName"			=>	"Agent First Name",
                                                    "Agent_LName"			=>	"Agent Last Name",

                                                    "Agent_Mobile"			=>	"Agent Mobile",
                                                    "Agent_HomePhone"	    =>	"Agent Home Phone",
                                                    "Agent_Fax"	            =>	"Agent Fax",
                                                    "Agent_LicenseNumber"	 =>	"Agent LicenseNumber",
                                                    "Agent_ShortID"	        =>	"Agent Short Number",
													"Bed1_Area"			     =>	"Bed1 Area",

													"Bed2_Area"			     =>	"Bed2 Area",

													"Bed3_Area"			     =>	"Bed3 Area",

													"Bed4_Area"			     =>	"Bed4 Area",

													"DiningRm_Area"			 =>	"DiningRm Area",

													"FamilyRm_Area"			 =>	"FamilyRm Area",

													"Kitchen_Area"			 =>	"Kitchen Area",

													"LivingRm_Area"			 =>	"LivingRm Area",

													"UtilityRm_Area"		 =>	"UtilityRm Area",
													"MasterBedRm_Area"		 =>	"MasterBedRm Area",


													"Den_Area"			     =>	"Den Area",

													"Porch_Area"		     =>	"Porch Area",

                                                    // 16th August 2017
                                                    "AirConditioning" 		=> "Air Conditioning",
													"Address"				=>	"Address",
                                                    //'IDXOptInYN'            =>  'IDX Opt In YN',
                                                    'NetOperatingIncome'	=>	'NetOperating Income',
                                                    'GrossOperatingIncome'	=>	'Gross Operating Income',
												    'CommunityFeatures'     =>  'Community Features',
                                                    'Fencing'               => 'Fencing',
                                                    'FoundationDetails'     => 'FoundationDetails',
                                                    "Miscellaneous"         =>  "Miscellaneous",
                                                    "StateName"             =>  "State Name",

                                                    // RETSIQ
                                                    'LotSize'               =>  "Lot Size",
                                                    'BedDescription'        =>  "Bed Description",
                                                    "Gas"					=>	"Gas",
                                                    "Is_Pool"				=>	"Pool ?",
													"Is_ShortSale"			=>	"Short Sale ?",
													"Is_REO"				=>	"REO ?",
                                                    'SpaYN'                 =>  'Spa YN',
                                                    'FireplaceYN'           =>  'Fireplace YN',
                                                    "Temp_PropertyType"     =>  "Temp Property Type",
                                                    "Dining"                =>  "Dining",
                                                    "Specials"				=>	"Specials",
		                                            'YearBuiltDescription'         =>  "YearBuilt Description ",
		                                            "PetRestrictions"       =>  "Pet Restrictions",
		                                            "Folio"                 =>  "#Folio",
		                                            "Design"                =>  "Design",
		                                            "DesignDescription"     =>  "Design Description",
		                                            "SubdivisionInfo"       =>  "Subdivision Information",
		                                            "DevelopmentName"       =>  "Development Name",



													"BridgeModificationTimestamp"   =>  "BridgeModificationTimestamp",
													"BuilderName"           =>  "BuilderName",
													"BuildingFeatures"      =>  "BuildingFeatures",
													"Agent_Email"            =>  "Agent_Email",
													"ParcelNumber"          =>  "ParcelNumber",
													"SpaFeatures"           =>  "SpaFeatures",
													"StatusChange_DateTime" =>  "StatusChange_DateTime",
													"StoriesFeature"        =>  "StoriesFeature",
													"IS_HOA"                =>  "HOA ?",
													"BuildingName"          =>  "Building Name",
													"Sold_Date"             =>  "Sold Date",
													"Sold_Price"            =>  "Sold Price",
													"ParcelsDescription"    =>  "Parcels Description",
													"LandLeaseAmount"       =>  "LandLeaseAmount",
													"LeaseExpiration"       =>  "LeaseExpiration",
													"LeaseTerm"             =>  "LeaseTerm",
													"Location"              =>  "Location",
													"MaintenanceExpense"    =>  "Maintenance Expense",
													"PatioAndPorchFeatures" =>  "Patio And PorchFeatures",
													"Possession"            =>  "Possession",
													"Section"               =>  "Section",
													"TotalActualRent"       =>  "TotalActualRent",
													"Township"              =>  "Township",
													"UnitTypeType"          =>  "Unit Type",
													"PreviousListPrice"     =>  "Previous List Price",
													"PriceChangeTimestamp"  =>  "Price Change Date",
													"ListPriceLow"          =>  "List Price Low",
										"WindowFeatures"        =>  "Window Features",
													"ZoningDescription"        =>  "Zoning Description",
													"DirectionFaces"        =>  "Direction Faces",
													"FrontageLength"        =>  "Frontage Length",
													"LotSizeArea"           =>  "LotSize Area",			
                                        "LotSizeSQFT"           =>  "LotSize SQFT",

										);
		asort($this->arrFieldList['Property']);
		$this->arrFieldList['Property'] = array_merge(array("None"	=>	"==========="), $this->arrFieldList['Property']);
		// Open House
		$this->arrFieldList['OpenHouse'] = array(
													"None"				=>	"===========",
													"MLS_NUM"  			=> "Listing Number",
													"OH_Begins"  		=> "OH_Begins",
													"OH_Close"  		=> "OH_Close",
													"OH_DisplayTime"  	=> "OH_DisplayTime",
													"OH_Date"  			=> "OH_Date",
                                                    ""
													//"OH_ItemNumber"  	=> "OH_ItemNumber",
													//"OH_Key"  			=> "OH_Key",
													/*"OH_ModificationTimestamp"  => "OH_ModificationTimestamp",
													"OH_RefreshmentOffers"  	=> "OH_RefreshmentOffers",
													"OH_Remarks"  				=> "OH_Remarks",
													"OH_ShowingAgentFirstName"  => "OH_ShowingAgentFirstName",
													"OH_ShowingAgentID"  		=> "OH_ShowingAgentID",
													"OH_ShowingAgentLastName"  	=> "OH_ShowingAgentLastName",
													"OH_CreatedDate"  			=> "OH_CreatedDate",
													"OH_SourceCreatedBy"  		=> "OH_SourceCreatedBy",
													"OH_LastModified"  			=> "OH_LastModified",
													"OH_Type"					=>	"OH_Type",		*/
										);
		// Media
		$this->arrFieldList['Media'] =	array(
													"None"					=>	"===========",
													"ListingKey"			=>	"ListingKey",
													"Media_Type"			=>	"Media_Type",
													"Media_ItemNumber"		=>	"Media_ItemNumber",
													"Media_DisplayOrder"	=>	"Media_DisplayOrder",
													"Media_Caption"			=>	"Media_Caption",
													"Media_Description"		=>	"Media_Description",
													"Media_URL"				=>	"Media_URL",
													"Media_LastUpdate"		=>	"Media_LastUpdate",
													"MLS_NUM"				=>	"ListingID"
												);

	    $this->arrFieldList['PropertyUnitTypes'] 	= array(	"None"					=>	"===========",

	                                                            "ListingKey"			=>	"ListingKey",
	                                                            "UnitTypeType"			=>	"Unit Type",
	                                                            "UnitTypeActualRent"	=>	"Actual Rent",
	                                                            "UnitTypeGarageSpaces"	=>	"Garage Spaces",
	                                                            "UnitTypeBedsTotal"		=>	"Beds Total",
	                                                            "UnitTypeBathsTotal"	=>	"Baths Total",
	                                                            "UnitTypeProForma"		=>	"ProForma",
	                                                            "MLS_NUM"				=>	"ListingID",
	                                                            "UnitTypeDescription"   =>	"Unit Description"
	    );
		# Table name
		$this->Data['TableName']			=	$config['Table_Prefix']. 'mls_config';
		/* Is need to populate schema data */
		if($isPopulateSchema) $this->populateSchema();
		# Intialize parent class
		parent::__construct();
	}
	/**
	 * Populate Data variable with schema information and other require variable by management modules
	 */
	public function populateSchema()
	{
		global $asset, $config;
		# Keep both unique
		$this->Data['ModuleName']			=	'Configuration';
		# Module title
		$this->Data['L_Module']				=	'MLS Configuration';
		# Help text
		$this->Data['H_Manage']				=	'Manage MLS Configuration';
		# Field information
		$this->Data['F_HeaderItem']				=	'';
		# Field information
		$this->Data['F_FieldInfo']				=	'';
	}
	#=========================================================================================================================
	#	Function Name	:   getAll
	#-------------------------------------------------------------------------------------------------------------------------
    public function getAll($params='', $F_CustomSelect = '',$limit='')
    {
		# Set data through parent call
		$rs = parent::getAll($params, $F_CustomSelect);
		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getAllbyRETS
	#-------------------------------------------------------------------------------------------------------------------------
    public function getAllbyRETS($mlsp_id)
    {
		# Set data through parent call
		$rs = parent::getAll(" AND mlsp_id = '".$mlsp_id."' ");
		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getAllbyParam
	#-------------------------------------------------------------------------------------------------------------------------
    public function getAllbyParam($mlsp_id, $Resource = '', $Class = '')
    {
		# Set data through parent call
		$params = " AND mlsp_id = '".$mlsp_id."'";
		if($Resource != '')
			$params .= " AND Resource = '".$Resource."'";
		if($Class != '')
			$params .= " AND Class IN ('".str_replace(",", "','", $Class)."')";
		$rs = parent::getAll($params);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getInfobyParam
	#-------------------------------------------------------------------------------------------------------------------------
    public function _getInfobyParam($mlsp_id, $Resource, $Class)
    {
		# Set data through parent call
		$params = " AND mlsp_id = '".$mlsp_id."'";
		if($Resource != '')
			$params .= " AND Resource = '".$Resource."'";
		if($Class != '')
			$params .= " AND Class = '".$Class."'";
		$rec = parent::getInfoByParam($params);
		return $rec;
	}
	#=========================================================================================================================
	#	Function Name	:   getKeyValueCustom
	#-------------------------------------------------------------------------------------------------------------------------
	public function getKeyValueCustom($mlsp_id, $Resource, $Class, $keydisp, $valdisp)
	{
		$rs 	= $this->getAllbyParam($mlsp_id, $Resource, $Class);
		$arr 	= array();
		foreach($rs as $key => $row)
		{
			$temp 	= array();
			$temp_1 = explode(",",$row[$keydisp]);
			$temp_2 = explode(",",$row[$valdisp]);
			if (count($temp_1)==count($temp_2))
				$temp = array_combine($temp_1,$temp_2);
			$newtemp[$row['Resource'].'_'.$row['Class']] = $temp;
			$arr = array_merge($arr,$newtemp);
		}
		return ($arr);
	}
	#=========================================================================================================================
	#	Function Name	:   getKeyValueClass
	#-------------------------------------------------------------------------------------------------------------------------
	public function getKeyValueClass($mlsp_id, $keydisp='Class')
	{
		global $db;
		$sql	= " SELECT Distinct Resource FROM ". $this->Data['TableName']." WHERE mlsp_id = '".$mlsp_id."' ";
		$rs 	= $db->query($sql);
		$rs 	= $rs->fetch_array();
		$arr 	= array();
		foreach($rs as $key => $row)
		{
			$sql1 = "SELECT * FROM ". $this->Data['TableName']." WHERE Resource = '".$row['Resource']."' AND mlsp_id = '".$mlsp_id."' ";
			$rsSub = $db->query($sql1);
			$rsSub = $rsSub->fetch_array();
			$temp 	= array();
			foreach($rsSub as $key => $Record)
			{
				array_push($temp, $Record[$keydisp]);
			}
			$temp = array_combine($temp,$temp);
			$newtemp[$row['Resource']] = $temp;
			$arr = array_merge($arr,$newtemp);
		}
		return ($arr);
	}
	#=========================================================================================================================
	#	Function Name	:   Insert
	#	Purpose			:	Insert new information
	#	Return			:	Return insert status
	#-------------------------------------------------------------------------------------------------------------------------
	public function _Insert($mlsp_id, $POST)
	{
		global $db;
		if ($POST['Step']=='Class')
		{
			foreach($POST['Resourse'] as $key => $Resourse)
			{
				if ($POST['Step']=='Class')
				{
					if (is_array($POST[$Resourse]))
					{
						foreach($POST[$Resourse] as $keyC => $Class)
						{
							$sql = "INSERT INTO ". $this->Data['TableName'] ." (mlsp_id, Resource, Class) VALUES ('".$mlsp_id."', '".$Resourse."', '".$Class."') ON DUPLICATE KEY UPDATE mlsp_id = VALUES(mlsp_id), Resource = VALUES(Resource), Class = VALUES(Class) ";
							$db->query($sql);
						}
						$sql = " DELETE FROM ". $this->Data['TableName']. " WHERE mlsp_id = '". $mlsp_id ."' AND Resource = '". $Resourse ."' AND Class NOT IN ('". implode("','",$POST[$Resourse]) ."')";
						$db->query($sql);
					}
				}
			}
			$sql = " DELETE FROM ". $this->Data['TableName']. " WHERE mlsp_id = '". $mlsp_id ."' AND Resource NOT IN ('".implode("','",$POST['Resourse']) ."')";
			$db->query($sql);
		}
		elseif ($POST['Step']=='SelectQuery')
		{
			$Record = $this->getAllbyRETS($mlsp_id);
			/*print "<pre>";
			print_r($Record);
			print "====";
			print_r($POST);*/
			foreach ($Record as $key => $recArr)
			{
				if (is_array($POST[$recArr['Resource'].'_'.$recArr['Class']]))
				{
					$sql = "UPDATE ". $this->Data['TableName'] ." SET SelectQuery = '".implode(',',$POST[$recArr['Resource'].'_'.$recArr['Class']])."' WHERE mlsp_id = '". $mlsp_id ."' AND Resource = '".$recArr['Resource']."' AND Class = '".$recArr['Class']."' ";
					//print $sql."<br>";
					$db->query($sql);
				}
			}
			//exit;
		}
		elseif ($POST['Step']=='Mapping')
		{
			$Record = $this->getAllbyRETS($mlsp_id);
			foreach ($Record as $key => $recArr)
			{
				if (is_array($POST[$recArr['Resource'].'_'.$recArr['Class']]))
				{
					$SelectQuery = implode(',',$POST[$recArr['Resource'].'_'.$recArr['Class']]);
					$FieldList = implode(',',$POST['cmd_'.$recArr['Resource'].'_'.$recArr['Class']]);
					$LookupList = '';
					$LookupFieldList = '';
					if (is_array($POST['chk'.$recArr['Resource'].'_'.$recArr['Class']]))
					{
						$LookupList = implode(',',$POST['chk'.$recArr['Resource'].'_'.$recArr['Class']]);
						$LookupFieldList = implode(',',array_keys($POST['chk'.$recArr['Resource'].'_'.$recArr['Class']]));
					}
					// Make key - value array of RETS Field and Database field
					$arrMappedField = array_combine($POST[$recArr['Resource'].'_'.$recArr['Class']], $POST['cmd_'.$recArr['Resource'].'_'.$recArr['Class']]);
					$sql =	" UPDATE ". $this->Data['TableName'] .
							" SET     SelectQuery = '".$SelectQuery."', ".
									" FieldList = '".$FieldList."', ".
									" LookupList = '".$LookupList."', ".
									" LookupFieldList = '".$LookupFieldList."', ".
									" MappedList = '".serialize($arrMappedField)."' ".
							" WHERE mlsp_id = '". $mlsp_id ."' AND Resource = '".$recArr['Resource']."' AND Class = '".$recArr['Class']."' ";
					$db->query($sql);
				}
			}
		}
		//exit;
		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   getXMLDataArr
	#-------------------------------------------------------------------------------------------------------------------------
    public function getXMLDataArr($xml_data, $setKey, $dispArr)
    {
		$xmlData = simplexml_load_string($xml_data);
		foreach($xmlData->attributes() as $a => $b)
		{
			if (($a=='ReplyCode') && ($b=='0'))
				break(1);
		}
		$arrData = array();
		foreach ($xmlData->children() as $xml_Table)
		{
			$col_list = str_replace("\t",",", trim($xml_Table->COLUMNS));
			array_push($arrData,explode(",",$col_list));
			foreach($xml_Table->DATA as $key => $data)
			{
				$data_list = str_replace("\t",",", trim($data));
				array_push($arrData,explode(",",$data_list));
			}
		}
		$get_Data = array();
		foreach($arrData as $key => $data)
		{
			if ($key==0)
			{
				$keyIndex = array_search($setKey, $data);
				if (!is_array($dispArr))
					$keyValIndex = array_search($dispArr, $data);
				else
				{
					$arrKeyValIndex = array();
					foreach($dispArr as $dispKey => $dispVal)
						array_push($arrKeyValIndex, array_search($dispVal, $data));
				}
			}
			else
			{
				if (!is_array($dispArr))
					$get_Data[$data[$keyIndex]] = $data[$keyValIndex];
				else
				{
					foreach($arrKeyValIndex as $Key1 => $Val1)
						$get_Data[$data[$keyIndex]] = $get_Data[$data[$keyIndex]]==''? $data[$Val1]: $get_Data[$data[$keyIndex]]." [".$data[$Val1]."] ";
				}
			}
		}
		return $get_Data;
	}
	#=========================================================================================================================
	#	Function Name	:   arrClassFromRETS
	#-------------------------------------------------------------------------------------------------------------------------
    public function arrClassFromRETS($objRETS, $ResourceID)
    {
		$response = $objRETS->getMetadata($Format = 'COMPACT', $id=$ResourceID, $type = 'METADATA-CLASS');
		return $this->getXMLDataArr($response, 'ClassName', 'Description');
	}
	#=========================================================================================================================
	#	Function Name	:   arrResourceFromRETS
	#-------------------------------------------------------------------------------------------------------------------------
    public function arrResourceFromRETS($objRETS, $ResourceID)
    {
		$response = $objRETS->getMetadata($format = 'COMPACT', $id=$ResourceID, $type = 'METADATA-RESOURCE' );
		return $this->getXMLDataArr($response, 'ResourceID', 'Description');
	}
	#=========================================================================================================================
	#	Function Name	:   arrTableFromRETS
	#-------------------------------------------------------------------------------------------------------------------------
    public function arrTableFromRETS($objRETS, $ResourceID, &$arr_Data, &$lookup_Data)
    {
		$response = $objRETS->getMetadata($format = 'COMPACT', $id=$ResourceID, $type = 'METADATA-TABLE' );
		$retArr = array();
		array_push($retArr, 'LongName', 'DataType', 'MaximumLength');//, 'Precision'  , 'LookupName'
		$arr_Data = $this->getXMLDataArr($response, 'SystemName', $retArr);
		$lookup_Data = $this->getXMLDataArr($response, 'SystemName', 'LookupName');
	}
#=========================================================================================================================
#	PHRETS
#-------------------------------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   arrResourceFromRETS
	#-------------------------------------------------------------------------------------------------------------------------
    public function arrResourceFromRETS2($objRETS, $ResourceID)
    {
		$response = $objRETS->GetMetadataResources($id=$ResourceID);
		//return $response;
		//return $this->getXMLDataArr($response, 'ResourceID', 'Description');
		return $this->prepareDataArr($response, 'ResourceID', array('Description'));
	}
	#=========================================================================================================================
	#	Function Name	:   arrClassFromRETS
	#-------------------------------------------------------------------------------------------------------------------------
    public function arrClassFromRETS2($objRETS, $ResourceID)
    {
		$response = $objRETS->GetMetadataClasses($id=$ResourceID);
		//return $response;
		//return $this->getXMLDataArr($response, 'ClassName', 'Description');
		return $this->prepareDataArr($response, 'ClassName', array('VisibleName','ClassName'));
	}
	#=========================================================================================================================
	#	Function Name	:   arrTableFromRETS
	#-------------------------------------------------------------------------------------------------------------------------
    public function arrTableFromRETS2($objRETS, $ResourceID, $Class, &$arr_Data, &$lookup_Data)
    {
		$response = $objRETS->GetMetadataTable($ResourceID, $Class);
		//$arr_Data = $response;
		$retArr = array();
		array_push($retArr, 'LongName', 'DataType', 'MaximumLength');//, 'Precision'  , 'LookupName'
		$arr_Data = $this->prepareDataArr($response, 'SystemName', $retArr);
		//print "<pre>";print_r($response);exit;
		$lookup_Data = $this->prepareDataArr($response, 'SystemName', array('LookupName'));
	}
	#=========================================================================================================================
	#	Function Name	:   prepareDataArr
	#-------------------------------------------------------------------------------------------------------------------------
    public function prepareDataArr($arrData, $setKey, $dispArr)
    {
		/*$xmlData = simplexml_load_string($xml_data);
		foreach($xmlData->attributes() as $a => $b)
		{
			if (($a=='ReplyCode') && ($b=='0'))
				break(1);
		}
		$arrData = array();
		foreach ($xmlData->children() as $xml_Table)
		{
			$col_list = str_replace("\t",",", trim($xml_Table->COLUMNS));
			array_push($arrData,explode(",",$col_list));
			foreach($xml_Table->DATA as $key => $data)
			{
				$data_list = str_replace("\t",",", trim($data));
				array_push($arrData,explode(",",$data_list));
			}
		}
		*/
		$get_Data = array();
		foreach($arrData as $key => $data)
		{
			$arrDispItem = array();
			foreach($dispArr as $dispKey => $dispVal)
			{
				if(isset($data[$dispVal]))
				{
					if($dispKey > 0)
						array_push($arrDispItem, "[".$data[$dispVal]."]");
					else
						array_push($arrDispItem, $data[$dispVal]);
				}
			}
			$get_Data[$data[$setKey]] = implode(' ', $arrDispItem);
			/*if ($key==0)
			{
				$keyIndex = array_search($setKey, $data);
				if (!is_array($dispArr))
					$keyValIndex = array_search($dispArr, $data);
				else
				{
					$arrKeyValIndex = array();
					foreach($dispArr as $dispKey => $dispVal)
						array_push($arrKeyValIndex, array_search($dispVal, $data));
				}
			}
			else
			{
				if (!is_array($dispArr))
					$get_Data[$data[$keyIndex]] = $data[$keyValIndex];
				else
				{
					foreach($arrKeyValIndex as $Key1 => $Val1)
						$get_Data[$data[$keyIndex]] = $get_Data[$data[$keyIndex]]==''? $data[$Val1]: $get_Data[$data[$keyIndex]]." [".$data[$Val1]."] ";
				}
			}*/
			//exit;
		}
		return $get_Data;
	}
}
?>