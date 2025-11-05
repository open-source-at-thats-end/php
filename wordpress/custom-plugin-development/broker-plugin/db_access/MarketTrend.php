<?php

require_once(dirname(__FILE__) . '/CustomClass.php');

class MarketTrend extends CustomClass {

    private static $instance;

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
    public function __construct()
    {
        global $config;

        $this->Data['TableName'] 				= $config['Table_Prefix'].'listing_statistic';
        $this->Data['Market_Reports'] 		    = $config['Table_Prefix'].'market_reports';
        $this->Data['Listing_Table'] 			= $config['Table_Prefix'].'listing_master';
        $this->Data['Listing_Address']			= $config['Table_Prefix'].'listing_address';
        $this->Data['listing_Additional_Info']  = $config['Table_Prefix'].'listing_additional_info';

        $this->Data['Field_Prifix'] = "statistic_";
    }

    public function getQueryParametersForStatistic($POST)
    {
        global $asset;

        $Parameters = '';

        //City
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
            else
            {
                $Parameters	 .=	" AND A.CityName = '". $POST['city']. "'";
            }
        }

        //Status
        if(isset($POST['status']) && is_array($POST['status']))
        {
            $Parameters .= " AND ListingStatus IN ('". implode("','",$POST['status'])."')  ";
        }
        elseif(isset($POST['status']) && $POST['status'] != '' )
        {
            $POST['status'] = str_replace(",", "','", $POST['status']);
            $Parameters .= " AND ListingStatus IN ('".$POST['status']."')";
        }

        $Parameters .= " AND is_mark_for_deletion = 'N' ";

        return $Parameters;

    }
    public function InsertCityWiseStatistic($arr)
    {

        $city = $arr['city'];
        $ref_id = $arr['ref_id'];
        if (isset($city) && $city != ''){

            $arrStatistic = array();

            $post['city'] = $city;

            //sold listing
            $post['mstatus'] = 'Closed';

            $arr_Solddata = $this->getAvgSoldData($post);
            $sold_medPrice    =   $this->getMedianPrice($post);
            $sold_medPrice_SQFT    =   $this->getMedianPricePerSQFT($post);

            $arr_sold_sixmonth_data = $this->getLastSixMonthSoldData($post);

            $post['mstatus'] = 'active';
            $arr_ActiveData = $this->getAvgActiveData($post);
            $Active_medPrice    =   $this->getMedianPrice($post);
            $Active_medPrice_SQFT    =   $this->getMedianPricePerSQFT($post);

            $arrStatistic['type']                   =   'City';
            $arrStatistic['ref_id']                 =   $ref_id;
            $arrStatistic['median_sold_price']      =   $sold_medPrice;
            $arrStatistic['median_sold_price_sqft'] =   $sold_medPrice_SQFT;
            $arrStatistic['median_active_price']           =   $Active_medPrice;
            $arrStatistic['median_active_price_sqft']      =   $Active_medPrice_SQFT;

            $arrStatistic = array_merge($arrStatistic, $arr_Solddata, $arr_ActiveData);

            if(is_array($arr_sold_sixmonth_data) && count($arr_sold_sixmonth_data) > 0)
            {
                $arrStatistic = array_merge($arrStatistic, $arr_sold_sixmonth_data);
            }

            $this->insertStatistic($arrStatistic);

        }
    }
    public function InsertSearchCriteriaWiseStatistic($arr)
    {
        $searchParam = unserialize($arr['psearch_criteria']);
        $ref_id = $arr['ref_id'];

        if(is_array($searchParam))
        {
            $post = $searchParam;

            if(isset($post['status']) && is_array($post['status']))
            {
                if(in_array('active', $post['status']) || in_array('pending', $post['status']) && !in_array('rental', $post['status']))
                {
                    $post['notptype'] = 'ResidentialLease';
                }
                elseif (in_array('rental', $post['status']) && !in_array('active', $post['status']))
                {
                    $post['stype'] = 'ResidentialLease';
                }
            }

            $post['status'] = 'Closed';

            $arr_Solddata = $this->getAvgSoldData($post);
            $sold_medPrice    =   $this->getMedianPrice($post);
            $sold_medPrice_SQFT    =   $this->getMedianPricePerSQFT($post);

            $arr_sold_sixmonth_data = $this->getLastSixMonthSoldData($post);

            $post['status'] = 'pending';
            $arr_PendingData = $this->getAvgPendingData($post);
            $Pending_medPrice    =   $this->getMedianPrice($post);
            $Pending_medPrice_SQFT    =   $this->getMedianPricePerSQFT($post);

            if(isset($post['notptype'])){
                unset($post['notptype']);
            }
            if(isset($post['stype'])){
                unset($post['stype']);
            }

            $post = $searchParam;
            $post['status'] = 'active';
            $arr_ActiveData = $this->getAvgActiveData($post);
            $Active_medPrice    =   $this->getMedianPrice($post);
            $Active_medPrice_SQFT    =   $this->getMedianPricePerSQFT($post);

            $post['status']             = 'pending';
            $arr_UnderContractdata    = $this->getAvgUnderContractData($post);

            $post['status']             = 'rental';
            $arr_RentalData    = $this->getAvgRentalData($post);

            # Largest Price Reduction
            $post['status']         = 'active';
            $post['pricereduce']    = true;
            $post['maxpricedef']    = '-60';

            $arr_LargestPriceReduction = $this->getLargestPriceReduction($post);
            // echo "<pre> largest price reduction"; print_r($arr_LargestPriceReduction);
            if (!is_array($arr_LargestPriceReduction))
                $arr_LargestPriceReduction['largest_price_reduction'] = 0;

            unset($post['pricereduce']);
            $post['status']         = 'Closed';
            $arr_SoldLargestPriceReduction = $this->getLargestPriceReduction($post);
            // echo "<pre> largest sold price reduction"; print_r($arr_SoldLargestPriceReduction);
            $post['status']         = 'pending';
            $arr_PendingLargestPriceReduction = $this->getLargestPriceReduction($post);
            // echo "<pre> largest pending price reduction"; print_r($arr_PendingLargestPriceReduction);die;

             # Largest Price Increase
             $post['status']         = 'active';
             $post['priceincrease']    = true;
             //unset ($post['maxpricedef']);
             //$post['maxpricedef']    = '60';
 
             $arr_LargestPriceIncrease = $this->getLargestPriceIncrease($post);
             file_put_contents('static-data-price-increase.txt',print_r($arr_LargestPriceIncrease,true), FILE_APPEND);
 
             
             if (!is_array($arr_LargestPriceIncrease))
                 $arr_LargestPriceIncrease['largest_price_increase'] = 0;
 
         
 
             $post['status']         = 'pending';
             $arr_PendingLargestPriceIncrease = $this->getLargestPriceIncrease($post);
 
             unset($post['priceincrease']);
             $post['status']         = 'Closed';
             $arr_SoldLargestPriceIncrease = $this->getLargestPriceIncrease($post);

            $arrStatistic['type']                                   =   'Market';
            $arrStatistic['ref_id']                                 =   $ref_id;
            $arrStatistic['median_sold_price']                      =   $sold_medPrice;
            $arrStatistic['median_sold_price_sqft']                 =   $sold_medPrice_SQFT;
            $arrStatistic['median_active_price']                    =   $Active_medPrice;
            $arrStatistic['median_active_price_sqft']               =   $Active_medPrice_SQFT;
            $arrStatistic['median_pending_price']                   =   $Pending_medPrice;
            $arrStatistic['median_pending_price_sqft']              =   $Pending_medPrice_SQFT;
            $arrStatistic['six_month_sold_largest_price_reduction'] =   $arr_SoldLargestPriceReduction['largest_price_reduction'];
            $arrStatistic['pending_largest_price_reduction']        =   $arr_PendingLargestPriceReduction['largest_price_reduction'];
            $arrStatistic['largest_price_diff']                     =   $arr_LargestPriceReduction['largest_price_diff'];
            $arrStatistic['largest_pending_price_diff']             =   $arr_PendingLargestPriceReduction['largest_price_diff'];
            $arrStatistic['largest_sold_price_diff']                =   $arr_SoldLargestPriceReduction['largest_price_diff'];

            $arrStatistic['six_month_sold_largest_price_increase']      =   $arr_SoldLargestPriceIncrease['largest_price_increase'];
            $arrStatistic['pending_largest_price_increase']             =   $arr_PendingLargestPriceIncrease['largest_price_increase'];

            $arrStatistic['largest_price_diff_increase']                =   $arr_LargestPriceIncrease['largest_price_diff_increase'];
            $arrStatistic['largest_pending_price_diff_increase']        =   $arr_PendingLargestPriceIncrease['largest_price_diff_increase'];
            $arrStatistic['largest_sold_price_diff_increase']           =   $arr_SoldLargestPriceIncrease['largest_price_diff_increase'];
            /*if (isset($post['psearch_monthwise_report']) && $post['psearch_monthwise_report'] == 'Yes' ) {
                $arrStatistic['property_type_cnt'] = serialize($arr_Listing_Cnt);
                $arrStatistic['monthly_property_data'] = serialize($arr_Monthly_data);
                $arrStatistic['comparision_data'] = serialize($arr_Comp_data);
            }*/

            $arrStatistic = array_merge($arrStatistic, $arr_Solddata, $arr_ActiveData, $arr_PendingData, $arr_UnderContractdata, $arr_RentalData, $arr_LargestPriceReduction, $arr_LargestPriceIncrease);

            if(is_array($arr_sold_sixmonth_data) && count($arr_sold_sixmonth_data) > 0)
            {
                $arrStatistic = array_merge($arrStatistic, $arr_sold_sixmonth_data);
            }

            $this->insertStatistic($arrStatistic);
        }
    }
    public function getAvgSoldData($post='')
    {
        global $db;

        //        $param = $this->getQueryParametersForStatistic($post);
        $param = IDXListing::obj()->getQueryParameters($post);

        /*$sql =	" SELECT COUNT(*) AS total_sold_listing, round(AVG(AI.Sold_Price)) AS avg_sold_price,  round(AVG(AI.Sold_Price/M.SQFT)) AS avg_sold_price_sqft, round(AVG((DATEDIFF(CURRENT_DATE(), ListingDate)))) AS avg_sold_dom".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND AI.Sold_Price > 0 ".$param;*/

        $sql =	" SELECT COUNT(*) AS total_sold_listing, round(AVG(AI.Sold_Price)) AS avg_sold_price, round(AVG(AI.Sold_Price/M.SQFT)) AS avg_sold_price_sqft, round(AVG((DATEDIFF(CURRENT_DATE(), ListingDate)))) AS avg_sold_dom".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND AI.Sold_Price > 0 ".$param;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_Solddata = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_Solddata;
    }
    #=========================================================================================================================
    #	Function Name	:   getMedianPrice
    #	Purpose			:	Simple constructor
    #-------------------------------------------------------------------------------------------------------------------------
    function getMedianPrice($post)
    {
        global $db;

        //        $addParameters = $this->getQueryParametersForStatistic($post);
        $addParameters = IDXListing::obj()->getQueryParameters($post);

        $lastsold= '';
        if($post['status'] == 'Closed')
        {
            $select = " AI.Sold_Price ";

            if(date("d") == date("d", strtotime("last day of this month")))
            {
                $date = date("Y-m-d");
            }
            else
            {
                $date = date("Y-m-d", strtotime("last month"));
            }

            $temp_date = date("Y-m-01", strtotime($date));
            $before_six_month = date("Y-m-d", strtotime($temp_date." -5 Month"));

            $lastsold = " AND AI.Sold_Date >= '".$before_six_month."'";

            //$addParameters .= " ORDER BY Price" ;
        }
        else{

            $select = " M.ListPrice ";
            $lastsold = '';
            $addParameters .= " ORDER BY Price" ;
        }
        //$lastsold= '';

        $sql =  " SELECT DISTINCT (".$select.") AS Price ".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 ".$lastsold." AND ".$select." > 0 ".$addParameters;

        if(DEBUG)
            $this->__debugMessage($sql);

        $rs1 = $db->query($sql);
        $rs  = $rs1->fetch_array();

        //$arrprice = array_column($rs,'Price');

        /*        if (count($rs) >= 10){
                    sort($rs);
                    $rs = array_slice($rs, 5);
                    rsort($rs);
                    $rs = array_slice($rs, 5);
                }
        */

        //unset($rs[array_search(min($rs),$rs)]);
        //unset($rs[array_search(max($rs),$rs)]);


        $totNo = count($rs);
        //echo"<pre>";print_r($rs);
        //echo "-------------------";
        $rs = array_column($rs,'Price');

        sort($rs);
        //echo"--------";
        //echo"<pre>";print_r($totNo);
        if($totNo > 0)
        {
            if (is_float($totNo/2))
            {

                //echo "<pre>--1".$rs[(($totNo + 1)/2)-1];
                return round($rs[(($totNo + 1)/2)-1]);
            }
            else
            {

                $arrPos1 = ($totNo/2)-1;
                $arrPos2 = $arrPos1 + 1;

                $Price1 = $rs[$arrPos1];
                $Price2 = $rs[$arrPos2];
            //echo "<pre>--2".(($Price1+$Price2)/2);
                return round(($Price1+$Price2)/2);
            }
        }
        else
            return 0;

    }
    function getMedianPricePerSQFT($post='')
    {
        global $db;

        //        $addParameters = $this->getQueryParametersForStatistic($post);
        $addParameters = IDXListing::obj()->getQueryParameters($post);

        if($post['status'] == 'Closed')
        {
            $select = " AI.Sold_Price ";

            if(date("d") == date("d", strtotime("last day of this month")))
            {
                $date = date("Y-m-d");
            }
            else
            {
                $date = date("Y-m-d", strtotime("last month"));
            }

            $temp_date = date("Y-m-01", strtotime($date));
            $before_six_month = date("Y-m-d", strtotime($temp_date." -5 Month"));

            $lastsold = " AND AI.Sold_Date >= '".$before_six_month."'";

            //$lastsold = '';
        }
        else{
            $select = " M.ListPrice ";
            $lastsold = '';

        }

        $sql =  " SELECT DISTINCT (".$select."/M.SQFT) AS PricePerSQFT ".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 ".$lastsold. " AND ".$select." > 0 ".$addParameters.
            " AND M.SQFT > 0 ";

        if(DEBUG)
            $this->__debugMessage($sql);

        $rs1 = $db->query($sql);
        $rs  = $rs1->fetch_array();

        //unset($rs[array_search(min($rs),$rs)]);
        //unset($rs[array_search(max($rs),$rs)]);
        /*	if (count($rs) >= 10){
                sort($rs);
                $rs = array_slice($rs, 5);
                rsort($rs);
                $rs = array_slice($rs, 5);
            }*/

        $totNo = count($rs);
        $rs = array_column($rs,'PricePerSQFT');
        sort($rs);
        //$rs  = array_values(array_filter($rs));

        if($totNo > 0)
        {
            if(is_float($totNo / 2))
            {

                return round($rs[(($totNo + 1) / 2) - 1]);
            }
            else
            {

                $arrPos1 = ($totNo / 2) - 1;
                $arrPos2 = $arrPos1 + 1;

                $Price1 = $rs[$arrPos1];
                $Price2 = $rs[$arrPos2];


                return round(($Price1 + $Price2) / 2);
            }
        }
        else
            return 0;
    }
    public function getLastSixMonthSoldData($post='')
    {
        global $db;

        if(date("d") == date("d", strtotime("last day of this month")))
        {
            $date = date("Y-m-d");
        }
        else
        {
            $date = date("Y-m-d", strtotime("last month"));
        }

        $temp_date = date("Y-m-01", strtotime($date));
        $before_six_month = date("Y-m-d", strtotime($temp_date." -5 Month"));

        //        $param = $this->getQueryParametersForStatistic($post);
        $param = IDXListing::obj()->getQueryParameters($post);

        /*$sql =	" SELECT COUNT(*) AS sixmon_tot_sold_listing, round(AVG(AI.Sold_Price)) AS sixmon_avg_sold_price,  round(AVG(AI.Sold_Price/M.SQFT)) AS sixmon_avg_sold_price_sqft, round(AVG((DATEDIFF(CURRENT_DATE(), ListingDate)))) AS sixmon_avg_sold_dom".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND AI.Sold_Price > 0 AND AI.Sold_Date >= '".$before_six_month."' ".$param;*/

        $sql =	" SELECT COUNT(*) AS sixmon_tot_sold_listing, round(AVG(AI.Sold_Price)) AS six_month_avg_sold_price, round(AVG(AI.Sold_Price/M.SQFT)) AS six_month_avg_sold_price_sqft, round(AVG((DATEDIFF(CURRENT_DATE(), ListingDate)))) AS six_month_avg_sold_dom".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND AI.Sold_Price > 0 AND AI.Sold_Date >= '".$before_six_month."' ".$param;

        //echo $sql; exit;
        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_Solddata = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_Solddata;

    }
    public function getAvgActiveData($post='')
    {
        global $db;

        //        $param = $this->getQueryParametersForStatistic($post);
        $param = IDXListing::obj()->getQueryParameters($post);

        //Utility::prE($param);
        $sql =	" SELECT COUNT(*) AS total_active_listing, round(AVG(M.ListPrice)) AS avg_active_price, round(AVG(M.ListPrice/M.SQFT)) AS avg_active_price_sqft, round(AVG((DATEDIFF(CURRENT_DATE(), ListingDate)))) AS avg_active_dom".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND M.ListPrice > 0 ".$param;

        //	echo $sql; exit;
        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_ActiveData = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_ActiveData;
    }
    public function getAvgPendingData($post='')
    {
        global $db;

        $param = IDXListing::obj()->getQueryParameters($post);

        $sql =	" SELECT COUNT(*) AS total_pending_listing, round(AVG(M.ListPrice)) AS avg_pending_price, round(AVG(M.ListPrice/M.SQFT)) AS avg_pending_price_sqft, round(AVG((DATEDIFF(CURRENT_DATE(), ListingDate)))) AS avg_pending_dom".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND M.ListPrice > 0 ".$param;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_PendingData = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_PendingData;
    }
    public function insertStatistic($statistics)
    {
        global $db;

        $statistics = array_filter($statistics);

        $array_Field = array_keys($statistics);

        $Field_list = $this->Data['Field_Prifix'] .implode(', '.$this->Data['Field_Prifix'], $array_Field);

        $array_values = array_values($statistics);

        $values = "'".implode("', '", $array_values)."'";

        $sql = " REPLACE INTO ".$this->Data['TableName'].
            " ( ". $Field_list .") ".
            "VALUES ( ".$values.")";

        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

    }
    public function DeleteStatistic($type, $ref_id)
    {
        global $db, $physical_path;

        $params = '';

        # Set Market
        # Type [Market/City/Community]

        if(empty($type) || empty($ref_id) || (is_array($ref_id) && count($ref_id) <= 0))
        {
            return false;
        }

        $params .= " AND statistic_type = '".$type."'";

        if(is_array($ref_id) && count($ref_id) > 0)
        {
            $params .= " AND statistic_ref_id IN ('".implode("','", $ref_id)."')";
        }
        else
        {
            $params .= " AND statistic_ref_id = '".$ref_id."'";
        }


        $sql = " DELETE FROM ". $this->Data['TableName'].
            " WHERE 1 ".$params;

        $db->query($sql);
    }
    public function getAvgUnderContractData($post='')
    {
        global $db;

        $param = IDXListing::obj()->getQueryParameters($post);

        $sql =	" SELECT COUNT(*) AS total_under_contract_listing".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND M.ListPrice > 0 ".$param;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_UnderContractdata = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_UnderContractdata;
    }
    public function getAvgRentalData($post=''){

        global $db;

        $param = IDXListing::obj()->getQueryParameters($post);

        $sql =	" SELECT COUNT(*) AS total_rental_listing".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND M.ListPrice > 0 ".$param;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_RentalData = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_RentalData;
    }
    public function getLargestPriceReduction($post=''){

        global $db;

        $lastsold = '';

        $param = IDXListing::obj()->getQueryParameters($post);

        if (isset($post['status']) && $post['status'] != '' && $post['status'] == 'Closed')
        {
            $fields = ' M.ListPrice - AI.Sold_Price ';
            $field =  ' (M.ListPrice - AI.Sold_Price)*100*(-1)/M.ListPrice ';
            // $orderBy =  ' ORDER BY largest_price_diff ';
            $orderBy =  ' ORDER BY M.ListPrice - AI.Sold_Price DESC';

            if (isset($post['market_report']) && $post['market_report'] == 'YES' ){
                $limit_period = ' AND '.$post['time'];
            }
            /*if(isset($post['page']) && $post['page'] == 'CondoPage' && $post['page'] != '')
                $orderBy =  ' ORDER BY AI.Sold_Date desc ';
            else
                $orderBy =  ' ORDER BY largest_price_diff ';*/

            if(date("d") == date("d", strtotime("last day of this month")))
            {
                $date = date("Y-m-d");
            }
            else
            {
                $date = date("Y-m-d", strtotime("last month"));
            }

            $temp_date = date("Y-m-01", strtotime($date));
            $before_six_month = date("Y-m-d", strtotime($temp_date." -5 Month"));

            $lastsold = " AND AI.Sold_Price > 0 AND AI.Sold_Date >= '".$before_six_month."'";
        }
        else
        {
            $fields =  'M.OriginalListPrice - M.ListPrice';
            $field =  'M.Price_Diff';
            // $orderBy =  ' ORDER BY M.Price_Diff ';
            $orderBy =  'ORDER BY M.OriginalListPrice - M.ListPrice DESC';

            if (isset($post['market_report']) && $post['market_report'] == 'YES' ){
                $limit_period = ' AND '.$post['time'];
            }
        }

        $sql =	" SELECT ".$fields." AS largest_price_reduction,".$field." As largest_price_diff".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            // " WHERE 1 " . $lastsold . $param . $orderBy ." LIMIT 0,1";
            " WHERE 1  AND M.OriginalListPrice > 0 " ;
        $sql .= isset($post['market_report'])?$limit_period:'';
        $sql .= $lastsold . $param . $orderBy . " LIMIT 0,1";
        
        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_LargestPriceReduction = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_LargestPriceReduction;
    }
    public function InsertCondoWiseStatistic($arr){

        $searchCriteria = unserialize($arr['csearch_criteria']);

        $searchParam['add']             = $searchCriteria['add'];
        $searchParam['city']            = $searchCriteria['city'];
        $searchParam['zipcode']         = $searchCriteria['zipcode'];
        $searchParam['stype']           = $searchCriteria['stype'];
        $searchParam['sys_name']        = $searchCriteria['sys_name'];
        $searchParam['page']            = 'CondoPage';

        if(isset($searchCriteria['sdivlist']) && $searchCriteria['sdivlist'] != '')
            $searchParam['sdivlist']        = $searchCriteria['sdivlist'];

        if(isset($searchCriteria['minprice']) && $searchCriteria['minprice'] != '')
            $searchParam['minprice']        = $searchCriteria['minprice'];

        if(isset($searchCriteria['maxprice']) && $searchCriteria['maxprice'] != '')
            $searchParam['maxprice']        = $searchCriteria['maxprice'];

        if(isset($searchCriteria['minyear']) && $searchCriteria['minyear'] != '')
            $searchParam['minyear']         = $searchCriteria['minyear'];

        if(isset($searchCriteria['maxyear']) && $searchCriteria['maxyear'] != '')
            $searchParam['maxyear']         = $searchCriteria['maxyear'];

        if(isset($searchCriteria['waterfront']) && $searchCriteria['waterfront'] != '')
            $searchParam['waterfront']      = $searchCriteria['waterfront'];

        if(isset($searchCriteria['petsallowed']) && $searchCriteria['petsallowed'] != '')
            $searchParam['petsallowed']     = $searchCriteria['petsallowed'];

        $ref_id = $arr['ref_id'];

        if(is_array($searchParam))
        {
            $post = $searchParam;

            if(isset($post['status']) && is_array($post['status']))
            {
                if(in_array('active', $post['status']) || in_array('pending', $post['status']) && !in_array('rental', $post['status']))
                {
                    $post['notptype'] = 'ResidentialLease';
                }
                elseif (in_array('rental', $post['status']) && !in_array('active', $post['status']))
                {
                    $post['stype'] = 'ResidentialLease';
                }
            }

            $post = $searchParam;
            $post['status'] = 'active';
            $arr_ActiveData = $this->getAvgActiveData($post);

            $post['status'] = 'Closed';
            $arr_Solddata   = $this->getAvgSoldData($post);
            $arr_sold_sixmonth_data = $this->getLastSixMonthSoldData($post);

            $post['status']     = 'pending';
            $arr_PendingData    = $this->getAvgPendingData($post);

            $post['status']         = 'pending';
            $arr_UnderContractdata  = $this->getAvgUnderContractData($post);

            $post['status'] = 'rental';
            $arr_RentalData = $this->getAvgRentalData($post);

            unset($post['status']);
            $arr_AverageDom = $this->getAvgDom($post);
            $arr_AvgListPriceSqftData = $this->getAvgListPriceSqftData($post);

            # Biggest Price Change
            $post['status']         = array('active','pending');
            $post['pricereduce']    = true;
            $post['maxpricedef']    = '-60';
            $post['so']             = 'pricedef';
            $post['sd']             = 'desc';
            $arr_BiggestPriceChange = $this->getBiggestPriceChange($post);

            if (!is_array($arr_BiggestPriceChange))
                $arr_BiggestPriceChange['biggest_price_change'] = 0;

            # Largest Price Reduction
            //$post['status']         = array('active','pending');
            $post['status']         = 'active';
            $post['pricereduce']    = true;
            $post['maxpricedef']    = '-60';

            $arr_LargestPriceReduction = $this->getLargestPriceReduction($post);
            // echo "<pre> largest price reduction"; print_r($arr_LargestPriceReduction);die;
            $post['status']         = 'pending';
            $arr_PendingLargestPriceReduction = $this->getLargestPriceReduction($post);

            unset($post['pricereduce']);
            $post['status']         = 'Closed';
            $arr_SoldLargestPriceReduction = $this->getLargestPriceReduction($post);

            if (!is_array($arr_LargestPriceReduction))
                $arr_LargestPriceReduction['largest_price_reduction'] = 0;

            if (!is_array($arr_AvgListPriceSqftData))
                $arr_AvgListPriceSqftData['avg_price_sqft'] = 0;

            if (!is_array($arr_AverageDom))
                $arr_AverageDom['avg_dom'] = 0;

            $arrStatistic['type']   =   'Condo';
            $arrStatistic['ref_id'] =   $ref_id;
            $arrStatistic['six_month_sold_largest_price_reduction'] =   $arr_SoldLargestPriceReduction['largest_price_reduction'];
            $arrStatistic['pending_largest_price_reduction']        =   $arr_PendingLargestPriceReduction['largest_price_reduction'];
            $arrStatistic['largest_price_diff']                     =   $arr_LargestPriceReduction['largest_price_diff'];
            $arrStatistic['largest_pending_price_diff']             =   $arr_PendingLargestPriceReduction['largest_price_diff'];
            $arrStatistic['largest_sold_price_diff']                =   $arr_SoldLargestPriceReduction['largest_price_diff'];

            $arrStatistic = array_merge($arrStatistic, $arr_Solddata, $arr_ActiveData, $arr_PendingData, $arr_UnderContractdata, $arr_RentalData, $arr_BiggestPriceChange, $arr_AvgListPriceSqftData, $arr_AverageDom, $arr_LargestPriceReduction);

            if(is_array($arr_sold_sixmonth_data) && count($arr_sold_sixmonth_data) > 0)
            {
                $arrStatistic = array_merge($arrStatistic, $arr_sold_sixmonth_data);
            }

            $this->insertStatistic($arrStatistic);
        }
    }
    public function getAvgDom($post='')
    {
        global $db;

        $param = IDXListing::obj()->getQueryParameters($post);

        $sql =	" SELECT round(AVG(DATEDIFF(CURRENT_DATE(), ListingDate))) AS avg_dom".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND M.ListPrice > 0 ".$param;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_AvgDom = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_AvgDom;
    }
    public function getAvgListPriceSqftData($post='')
    {
        global $db;

        $param = IDXListing::obj()->getQueryParameters($post);

        $sql =	" SELECT round(AVG(M.ListPrice/M.SQFT)) AS avg_price_sqft".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 AND M.ListPrice > 0 ".$param;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_AvgListPriceSqft = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_AvgListPriceSqft;
    }
    public function getBiggestPriceChange($post=''){

        global $db;

        $param = IDXListing::obj()->getQueryParameters($post);

        $sql =	" SELECT M.Price_Diff AS biggest_price_change".
            " FROM ". $this->Data['Listing_Table']." AS M ".
            " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
            " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
            " WHERE 1 ".$param." ORDER BY M.Price_Diff LIMIT 0,1";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        $arr_BiggestPriceChange = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_BiggestPriceChange;
    }
    public function getLargestPriceIncrease($post='')
    {        
        global $db;
        $lastsold = '';
        $param = IDXListing::obj()->getQueryParameters($post);
        
        if (isset($post['status']) && $post['status'] != '' && $post['status'] == 'Closed')
        {
            $fields = 'AI.Sold_Price - M.OriginalListPrice'; 
            $field =  '(AI.Sold_Price - M.OriginalListPrice)*100/M.OriginalListPrice';
            //$orderBy =  ' ORDER BY largest_price_diff ';
            $orderBy =  ' ORDER BY AI.Sold_Price- M.OriginalListPrice DESC';

            if (isset($post['market_report']) && $post['market_report'] == 'YES' ){
                $limit_period = ' AND '.$post['time'];
            }

            if(date("d") == date("d", strtotime("last day of this month")))
            {
                $date = date("Y-m-d");
            }
            else
            {
                $date = date("Y-m-d", strtotime("last month"));
            }

            $temp_date = date("Y-m-01", strtotime($date));
            $before_six_month = date("Y-m-d", strtotime($temp_date." -5 Month"));

            $lastsold = " AND AI.Sold_Price > 0 AND AI.Sold_Date >= '".$before_six_month."'";
            
        }
        else
        {
            //$fields =  'M.OriginalListPrice - M.ListPrice';
            $fields =  'M.ListPrice - M.OriginalListPrice';
            $field =  'M.Price_Diff';
            //$orderBy =  'ORDER BY M.Price_Diff';
            $orderBy =  'ORDER BY M.ListPrice - M.OriginalListPrice DESC';

            if (isset($post['market_report']) && $post['market_report'] == 'YES' ){
                $limit_period = ' AND '.$post['time'];
            }
        }

        $sql =	" SELECT ".$fields." AS largest_price_increase,".$field." As largest_price_diff_increase".
                " FROM ". $this->Data['Listing_Table']." AS M ".
                " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
                " LEFT JOIN ". $this->Data['listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
                //" WHERE 1 " . $lastsold . $param . $orderBy . " LIMIT 0,1";
                " WHERE 1  AND M.OriginalListPrice > 0 " ;
        $sql .= isset($post['market_report'])?$limit_period:'';
        $sql .= $lastsold . $param . $orderBy . " LIMIT 0,1";
        
        file_put_contents('static-data-price-increase-sql.txt',print_r($sql,true), FILE_APPEND);
        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);
        file_put_contents('static-data-price-increase-rs.txt',print_r($rs,true), FILE_APPEND);
        
        $arr_LargestPriceIncrease = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

        return $arr_LargestPriceIncrease;
    }
}