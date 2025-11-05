<?php
#=============================================================================================================================
#	File Name		:	static_data.php
#=============================================================================================================================
# Check for hacking attempt


$asset['OL_SubType'] = array(
    'Commercial'            =>  'Commercial',
    'Condominium'           =>  'Condominium',
    'HotelMotel'            =>  'Hotel/Motel',
    'Income'                =>  'Income',
    'Industrial'            =>  'Industrial',
    'ResidentialLease'      =>  'Lease',
    'MultiFamily'           =>  'Multi Family',
    //'Residential'           =>  'Residential',
    'SingleFamilyResidence' =>  'Single Family Residence',
    'Townhouse'             =>  'Townhouse',
    'Villa'                 =>  'Villa',
    'Land'                  =>  'Land',
    'BusinessOpportunity'   =>  'Business Opportunity',
    'BoatSlip'              =>  'Boat Slip',
    'MobileHome'            =>  'Mobile Home',
    'StockCooperative'      =>  'Stock Cooperative',
    'Office'                =>  'Office',
    'Retail'                =>  'Retail',
);

$asset['OL_SubType_Actris'] = array(
    'Agriculture'           =>  'Agriculture',
    'Apartment'             =>  'Apartment',
    'BusinessOpportunity'   =>  'Business Opportunity',
    'BoatSlip'              =>  'Boat Slip',
    'Business'              =>  'Business',
    'Commercial'            =>  'Commercial',
    'Condominium'           =>  'Condominium',
    'CommercialSale'        =>  'Commercial Sale',
    'Farm'                  =>  'Farm',
    'HighRise'              =>  'High Rise',
    'HotelMotel'            =>  'Hotel/Motel',
    'Industrial'            =>  'Industrial',
    'Land'                  =>  'Land',
    'MultiFamily'           =>  'Multi Family',
    'Quadruplex'            =>  'Quadruplex',
    'Retail'                =>  'Retail',
    'Residential'           =>  'Residential',
    'ResidentialIncome'     =>  'Residential Income',
    'Speciality'            =>  'Speciality',
    'SingleFamilyResidence' =>  'Single Family Residence',
    'Townhouse'             =>  'Townhouse',
    'Triplex'               =>  'Triplex',
    'Ranch'                 =>  'Ranch',
    'Warehouse'             =>  'Ware House',
);
$asset['OL_SubType_LOOKUP_ARRAY'] = array('Commercial','Condominium','HotelMotel','Income','Industrial','MultiFamily','Residential','SingleFamilyResidence','Townhouse','Villa','Office','BoatSlip','Retail','MobileHome','StockCooperative','Farm'
);
$asset['OL_SubType_LOOKUP'] = array(
    'Commercial'            =>  'Commercial|BusinessOpportunity|Farm|Land|Industrial|CommercialLease|CommercialSale|ResidentialIncome',
    'Condominium'           =>  'Condominium',
    'HotelMotel'            =>  'HotelMotel',
    'Income'                =>  'Income',
    'Industrial'            =>  'Industrial',
    'ResidentialLease'      =>  'ResidentialLease',
    'MultiFamily'           =>  'MultiFamily|ResidentialIncome',
    'Residential'           =>  'Residential',
    'SingleFamilyResidence' =>  'SingleFamilyResidence',
    'Townhouse'             =>  'Townhouse',
    'Villa'                 =>  'Villa',
    'Land'                  =>  'Land',
    'BusinessOpportunity'   =>  'BusinessOpportunity',
    'BoatSlip'              =>  'BoatSlip',
    'MobileHome'            =>  'MobileHome',
    'StockCooperative'      =>  'StockCooperative',
    'Office'                =>  'Office',
    'Retail'                =>  'Retail',
    'CommercialSale'        =>  'Commercial Sale',
    'Farm'                  =>  'Farm',
    'HighRise'              =>  'HighRise',
    'ResidentialIncome'     =>  'ResidentialIncome',
    'Speciality'            =>  'Speciality',
    'Agriculture'           =>  'Agriculture',
    'Apartment'             =>  'Apartment',
    'Business'              =>  'Business',
    'Quadruplex'            =>  'Quadruplex',
    'Ranch'                 =>  'Ranch',
    'Triplex'               =>  'Triplex',
    'Warehouse'             =>  'Warehouse',
);
$asset['OL_PropType_LOOKUP_ARRAY'] = array('Land','BusinessOpportunity','ResidentialIncome','CommercialLease','ResidentialLease','CommercialSale');
$asset['OL_SORTBY_LOOKUP_ARRAY'] = array(
    'price'     =>  'ListPrice',
    'sqft'      =>  'SQFT',
    'bed'       =>  'Beds',
    'dom'       =>  'DOM',
    'bath'      =>  'Baths',
    'dt'        =>  'YearBuilt',
    'sold'      =>  'Sold_Date',
    'updated'   =>  'LastUpdateDate',
    'soldprice' =>  'Sold_Price',
    'pricedef'  =>  'Price_Diff',
    'ppsf'      =>  'PPSF',
    'lsuc'      =>  'LSUC',
    'cosfr'      =>  'COSFR',
    'pricedefer'      =>  'OriginalListPrice - ListPrice',
    //'domprice'  =>  'DOM,ListPrice',
);$asset['OL_PropertyStyle'] = array(
    'Duplex'      =>  'Duplex',
    'Fourplex'    =>  'Fourplex',
    'MultiFamily' =>  'MultiFamily',
    'Penthouse'   =>  'Penthouse',
    'Triplex'     =>  'Triplex',
);
$asset['Not_Include_City'] = array('Sebastian');
$asset['arrListingField'] = array('MLS_NUM', 'PropertyType', 'StreetNumber', 'StreetName', 'UnitNo', 'ZipCode', 'CityName', 'State', 'County', 'Subdivision', 'StreetDirPrefix', 'Description');
?>