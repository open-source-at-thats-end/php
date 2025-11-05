<?php
/**
 * CustomWpPlugin plugin related constants.  These are used in many
 * different classes.
 *
 * @author -
 */
class StaticArray {
	public static function arrPageSize(){

		$arrReturn = array(
			'25' 	=> '25',
			'50' 	=> '50',
			'100' 	=> '100',
			'250' 	=> '250',
			'1000' 	=> '1000',
		);
		return $arrReturn;
	}
	public static function arrListingField()
	{
		return array('MLS_NUM', 'PropertyType', 'StreetNumber', 'StreetName', 'UnitNo', 'ZipCode', 'CityName', 'State', 'County', 'Subdivision', 'StreetDirPrefix', 'Description');
	}
	public static function OL_NON_STATIC_LOOK_UP()
	{
		return array('ajax_in_site', 'action', 'XHR', 'getMapData', 'isBackSearch', 'page_size', 'mz', 'clat', 'clng', 'issorting', 'issavesearch','psearch_tag','psearch_generate_mrktreport','AddressName','isAgentPre','formatURL','isFilter','isHeading','is_map','disclaimer','tabs','sys_name','membership_required','membership_fee');
	}
	public static function arrPriceRange($arrRange=array()){

		$arrPriceRange = array();
		$start = (isset($arrRange['min']) && $arrRange['min'] > 0) ? $arrRange['min'] : 25000;
		$end 	= (isset($arrRange['max']) && $arrRange['max'] > 0) ? $arrRange['max'] : 2000000;
		for($i=$start; $i <= $end; $i = $i+25000)
		{
			$arrPriceRange[$i] = number_format($i, 0);
			$arrPriceRange[$i]  =   '$'.$arrPriceRange[$i];
		}

        return $arrPriceRange;
	}
	public static function arrPriceRangeQuick(){
        $arrPriceRange = array();
        for($i=2000; $i <= 4000; $i = $i+1000)
        {

            $arrPriceRange[$i] = number_format($i, 0);
            $arrPriceRange[$i]  =   '$'.$arrPriceRange[$i];
        }

        $arrPriceRange1 = array();
        for($i=5000; $i <= 20000; $i = $i+5000)
        {

            $arrPriceRange1[$i] = number_format($i, 0);
            $arrPriceRange1[$i]  =   '$'.$arrPriceRange1[$i];
        }

        $arrPriceRange2 = array();
        for($i=25000; $i <= 100000; $i = $i+25000)
        {

            $arrPriceRange2[$i] = number_format($i, 0);
            $arrPriceRange2[$i]  =   '$'.$arrPriceRange2[$i];
        }
        $arrPriceRange3 = array();
        for($i=100000; $i <= 1000000; $i = $i+100000)
        {

            $arrPriceRange3[$i] = number_format($i, 0);
            $arrPriceRange3[$i]  =   '$'.$arrPriceRange3[$i];
        }

        $arrPriceRange4 = array();
		for($i=2000000; $i <= 10000000; $i = $i+1000000)
		{

			$arrPriceRange4[$i] = number_format($i, 0);
			$arrPriceRange4[$i]  =   '$'.$arrPriceRange4[$i];
		}
		
		$arrPriceRange5 = array();
		for($i=10000000; $i <= 25000000; $i = $i+5000000)
		{

			$arrPriceRange5[$i] = number_format($i, 0);
			$arrPriceRange5[$i]  =   '$'.$arrPriceRange5[$i];
		}


        return $arrPriceRange + $arrPriceRange1 + $arrPriceRange2 + $arrPriceRange3 + $arrPriceRange4 + $arrPriceRange5;
    }
	public static function arrPriceRangeAdmin(){
        $arrPriceRange = array();
        for($i=1000; $i <= 4000; $i = $i+1000)
        {

            $arrPriceRange[$i] = number_format($i, 0);
            $arrPriceRange[$i]  =   '$'.$arrPriceRange[$i];
        }

        $arrPriceRange1 = array();
        for($i=5000; $i <= 10000; $i = $i+5000)
        {

            $arrPriceRange1[$i] = number_format($i, 0);
            $arrPriceRange1[$i]  =   '$'.$arrPriceRange1[$i];
        }

        $arrPriceRange2 = array();
        for($i=100000; $i <= 1000000; $i = $i+50000)
        {

            $arrPriceRange2[$i] = number_format($i, 0);
            $arrPriceRange2[$i]  =   '$'.$arrPriceRange2[$i];
        }
        $arrPriceRange3 = array();
        for($i=2000000; $i <= 9000000; $i = $i+1000000)
        {

            $arrPriceRange3[$i] = number_format($i, 0);
            $arrPriceRange3[$i]  =   '$'.$arrPriceRange3[$i];
        }

        return $arrPriceRange + $arrPriceRange1 + array( '25000' => '$'.number_format('25000', 0)) + $arrPriceRange2 + $arrPriceRange3;
    }
	public static function arrSQFTRange($arrRange=array()){
		$arrSqFt = array();
		$start = (isset($arrRange['min']) && $arrRange['min'] > 0) ? $arrRange['min'] : 250;
		$end 	= (isset($arrRange['max']) && $arrRange['max'] > 0) ? $arrRange['max'] : 4000;
		for($i=$start; $i <= $end; $i = $i+250)
		{
			$arrSqFt[$i] = number_format($i, 0);
		}

		return $arrSqFt;
	}
	public static function arrBedRange($arrRange=array()){

		$arrRange1 = array();
		$start = (isset($arrRange['min']) && $arrRange['min'] > 0) ? $arrRange['min'] : 0;
		$end 	= (isset($arrRange['max']) && $arrRange['max'] > 0) ? $arrRange['max'] : 6;

		for($i=$start; $i <= $end; $i++)
		{
			$arrRange1[$i] = $i;
		}

		return $arrRange1;
	}
	public static function arrBathRange($arrRange=array()){

		$arrRange1 = array();
		$start = (isset($arrRange['min']) && $arrRange['min'] > 0) ? $arrRange['min'] : 1;
		$end 	= (isset($arrRange['max']) && $arrRange['max'] > 0) ? $arrRange['max'] : 5;

		for($i=$start; $i <= $end; $i++)
		{
			$arrRange1[$i] = $i."+";
		}

		return $arrRange1;
	}
	public static function arrShowOnly($arrSelected=array()){

		$arrReturn = array(
			'is_shortsale' 	=> 'Short Sale',
			'is_reo' 		=> 'Bank Owned',
			'is_photos' 	=> 'Property With Photos',
		);

		if(count($arrSelected) > 0)
		{
			$arrSelected = array_combine($arrSelected, $arrSelected);

			$arrReturn = array_intersect_key($arrReturn, $arrSelected);
		}

		return $arrReturn;
	}
	public static function arrPropertyTypeLookUp() {
		return array(
			'BusinessOpportunity'   =>  'BusinessOpportunity',
			'CommercialLease'       =>  'CommercialLease',
			'Land'                  =>  'Land',
		);

	}
	public static function arrPropertyStyleLookUp() {
		return array(
			'ClusterHome'   =>  'ClusterHome',
			'GardenHome'    =>  'GardenHome',
			'HighRise'      =>  'HighRise',
			'Ranch'         =>  'Ranch',
			'TriLevel'      =>  'TriLevel',
			'SplitLevel'    =>  'SplitLevel',
		);

	}
	public static function arrCityLookUp() {
		return array(
			'Atlantis'   =>  'Atlantis',
			'Aventura'    =>  'Aventura',
			'Bal Harbour'      =>  'Bal Harbour',
			'Bay Harbor Islands'         =>  'Bay Harbor Islands',
			'Belle Glade'      =>  'Belle Glade',
			'Big Pine'    =>  'Big Pine',
			'Biscayne Park'    =>  'Biscayne Park',
			'Boca Raton'    =>  'Boca Raton',
			'Boynton Beach'    =>  'Boynton Beach',
			'Bulkhead Ridge'    =>  'Bulkhead Ridge',
		);

	}
	public static function arrSortingOption(){
		return array(   //'ListPrice|desc'        =>  'Price',
                        'cosfr|asc'    =>  'Condo - Single Family Home',
                        'pricedef|asc'    =>  'Potential Deals',
                        'pricedefer|desc' =>  'Biggest Price Drops',
                        'dom|asc'         =>  'New Listings',
                        'ppsf|asc'        =>  '$/Square Feet',
                        'lsuc|asc'        =>  'Under Contract',
                        'price|asc'       => 'Price - Low to High',
                        'price|desc'      =>  'Price - High to Low',
                        'bed|desc'        =>  'Beds - Most',
                        'bed|asc'         =>  'Beds - Fewest',
                        'sqft|desc'       =>  'Square Feet - Most',
                        'sqft|asc'        =>  'Square Feet - Least',
                        'updated|desc'    =>  'Date Updated',
		                /*'sold|desc'        =>  'Sold Date',
						'soldprice|desc'        =>  'Sold Price',*/
		                //            'ohdt|asc'              =>  'Open House',//Check in sort by static lookup array
		);

	}
    public static function arrSystemName(){
        return array(
            //'SEFMIAMI' => 'SEFMIAMI',
            // 'FTL' => 'FTL',
            'SEFMIAMI' => 'MAR',
            'FTL' => 'BEACHES',
            'both' => 'Both',
        );
    }
    public static function arr_SName_LookUP(){
        return array(
            //'SEFMIAMI' => 'mar',
            // 'FTL' => 'beaches',

            'mar' => 'SEFMIAMI',
            'beaches' => 'FTL',
            //'both'  =>  'both'
        );

    }
    public static function arrAgentSystemName(){
        return array(
            '1'  => 'MAR/BEACHES',
            '2'  => 'ACTRIS',
        );
    }
    public static function arr_ASName_LookUP(){
        return array(
            '1'    => 'MAR/BEACHES',
            '2'    => 'ACTRIS',
        );
    }
    public static function arrPreQuickSorting(){
        return array(
            'pricedef|asc'    =>  'Potential Deals',
            'lsuc|asc'        =>  'Under Contract',
        );

    }
	public static function arrLotSize(){
		$arrLotSize = array();
		for($i=20000; $i <= 50000; $i = $i+10000)
		{

			$arrLotSize[$i] = number_format($i, 0). ' sq ft';
			//            $arrLotSize[$i] = number_format($i, 2);
		}
		/*$arrLotSize1 = array();
		for($i=1; $i <= 5; $i = $i+1)
		{
		    if($i == 1){
                $arrLotSize1[$i] = number_format($i, 0). ' acre';
            }else{
                $arrLotSize1[$i] = number_format($i, 0). ' acres';
            }

		}*/

		/*$arrLotSize2 = array();
		for($i=10000; $i <= 100000; $i = $i+2000)
		{
			$arrLotSize2[$i] = number_format($i, 0);
		}*/

        /*$arrLotSize = array(
          "0.25" => .25 .' acres',
          "0.5" => .5 . ' acres',
        );
        $arrLotSize2 = array(
            "10" => 10 ." acres",
            "40" => 40 ." acres",
            "100" => 100 ." acres",
        );*/


		return $arrLotSize;
	}
	public static function arrYearBuild($year_t=''){
		### Added for years
		$yearFromArr = array();
		$currentYear = date('Y');
		$currentYear = (int)$currentYear;

		for($i=$currentYear;$i >= $currentYear-60;$i--)
		{
			$yearFromArr[$i] = $i;
		}


		$yearToArr = array();
		for($i=$currentYear+10;$i >= $currentYear-50;$i--)
		{
			$yearToArr[$i] = $i;
		}
		if($year_t == 'from')
		{
			$arrYearBuild['YearFrom']  				=	 $yearFromArr;
		}
		elseif($year_t == 'to')
		{
			$arrYearBuild['YearTo']  				=	 $yearToArr;
		}
		else
		{
			$arrYearBuild['YearFrom']  				=	 $yearFromArr;
			$arrYearBuild['YearTo']  				=	 $yearToArr;
		}

		return $arrYearBuild;
	}
	public static function arrYesNo(){

		return array(
			'Yes' 	=> 'Yes',
			'No' 	=> 'No',
		);
	}
    public static function arrWaterfrontDesc(){

        return array(
            'nofixedbridges' 	=> 'No Fixed Bridge',
            'oceanaccess' 	    => 'Ocean Access',
            'oceanfront' 	    => 'Ocean Front',
        );
    }
    public static function arradminWaterfrontDesc(){

        return array(
            'nofixedbridges' 	=> 'No Fixed Bridge',
            'oceanaccess' 	    => 'Ocean Access',
            'oceanfront' 	    => 'Ocean Front',
            //'gulf' 	    => 'Ocean Gulf',
            'boatdockslip' 	    => 'Boat Slip',
            'waterfront' 	    => 'Waterfront',
        );
    }
    public static function arrWaterfrontDescActris(){

        return array(
            'nofixedbridges' 	=> 'No Fixed Bridge',
            'canalfront' 	    => 'Canal Front',
            'creek' 	        => 'Creek',
            'dockaccess' 	    => 'Dock Access',
            'fixedbridge' 	    => 'Fixed Bridge',
            'lake' 	            => 'Lake',
            'lakefront' 	    => 'Lake Front',
            'lakeprivileges' 	=> 'Lake Privileges',
            'navigablewater' 	=> 'Navigable Water',
            'pier' 	            => 'Pier',
            'pond' 	            => 'Pond',
            'riveraccess' 	    => 'River Access',
            'riverfront' 	    => 'River Front',
            'sailboataccess' 	=> 'Sail Boat Access',
            'stream' 	        => 'Stream',
            'waterfront' 	    => 'Water Front',
        );
    }
    public static function arrSecuritySafety(){

        return array(
            // '' 	=> 'No preference',
            'Gated' 	=> 'Gated',
            'GatedManned' 	=> 'Gated-Manned',
        );

    }
    public static function arrMapSecuritySafety(){

        return array(
            //'' 	=> 'No preference',
            'gated' 	=> 'GatedCommunity',
            'gatedmanned' 	=> array('GatedwithGuard','GatedwithAttendant'),
        );

    }
	public static function arrTrueFalse(){

		return array(
			'1' 	=> 'Yes',
			'0' 	=> 'No',
		);
	}
	public static function arrStatus(){

		return array(
			'all' 	=> 'All',
			'active' => 'For Sale',
			'rental' 	=> 'Rental',
			'pending' 	=> 'Pending',
		);
	}
	public static function arrStatusAdmin(){

		return array(
//			'' 	=> 'All',
			'active' => 'Active',
			'rental' 	=> 'Rental',
			'closed' 	=> 'Sold',
			'pending' 	=> 'Pending',
		);
	}
	public static function arrDayMarket(){
		return array(
			'0'     =>  'New listings (since yesterday)',
			'3-'     => 'Less than 3 days',
			'7-'     => 'Less than 7 days',
			'14-'    => 'Less than 14 days',
			'30-'    => 'Less than 30 days',
			'7+'     => 'More than 7 days',
			'14+'    => 'More than 14 days',
			'30+'    => 'More than 30 days',
			'45+'    => 'More than 45 days',
			'60+'    => 'More than 60 days',
			'90+'    => 'More than 90 days',
			'180+'   => 'More than 180 days',
		);
	}
	public static function arrPasswordKeyword(){
		return array ('service','property','home','listing','dallas',
		              'Documents','Hunter','client','search','lender',
		              'Club','Vehicles','Neo', 'Morpheus', 'Trinity', 'Cypher', 'Tank');
	}
	public static function UserMeta(){
		return array ('user_phone','user_first_name','user_last_name','user_preference','user_time','user_ptype',
		              'user_area','user_price','user_bed','user_approve','user_sell_pre','user_type');
	}
	public static function SearchParameter()
	{
		return array ('minprice','maxprice','city','sdivlist','minlotsize',
		              'maxlotsize','minyear','maxyear','stype','dom','waterfront','pool','petsallowed','minsqft','status','maxsqft','minbed','minbath'
		              ,'zipcode','kword','office','agent','sort_by');
	}
	public static function Email_Notification()
	{
		return array(
			'0' =>	'Immediately',
			'1' =>	'Daily',
			'2' =>	'Weekly',
			'3' =>	'Monthly',
		);
	}
    public static function SEOSubtype()
    {
        return array(
            'SingleFamilyResidence' =>	'home',
            'Condominium' =>	'condo',
            'Townhouse' =>	'townhouse',
        );
    }
    public static function MarketRepoSEOStype()
    {
        return array(
            'SingleFamilyResidence' =>	'homes',
            'Condominium' =>	'condos',
            'Townhouse' =>	'townhouses',
        );
    }
    public static function arrFurnished(){

        return array(
            'Furnished'   => 'Yes',
            'Unfurnished'    => 'No',
        );
    }

    public static function arrPropertyType() {
        return array ('Land','BusinessOpportunity','ResidentialIncome','CommercialLease','CommercialSale');
    }

    public static function arrSubType() {
        return array('Commercial','HotelMotel','Industrial','MultiFamily','BoatSlip','Income','Farm');
    }

}