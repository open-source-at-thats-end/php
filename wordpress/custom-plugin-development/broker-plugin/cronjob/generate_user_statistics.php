<?php

#=============================================================================================================================
#	File Name		:	generate_community_statistic.php
#=============================================================================================================================
define('IN_CRON', 	true);

ini_set("memory_limit","512M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

ob_start();

# Store start time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_start = $mtime;

echo "\n================================================";
echo "\n	File Name:		generate_market_statistic.php 			";
echo "\n	Execution Date:  " . date("D M j G:i:s T Y");
echo "\n==============================================\n";

print("Process Start =============================== \n");

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');

$arrPhysicalPath['UserBase'] 	= $arrPhysicalPath['Base']. 'front' . DS;

$Data = LPTUserActionLog::getInstance()->getCronUser();
LPTUserActionLog::getInstance()->truncate_table();
foreach($Data as $Record)
{
 
   $log_data =  LPTUserActionLog::getInstance()->getRecordByRefId($Record['log_ref_id']);
   
   $stats = array();
   $stats['ref_id'] = $Record['log_ref_id'];
   
   
   /* Price Calculation */
   $price = array_column($log_data, 'log_price');
   $totNo = count($price);
   if($totNo > 0)
        {
            if (is_float($totNo/2))
            {

                //echo "<pre>--1".$rs[(($totNo + 1)/2)-1];
                $price_val = round($price[(($totNo + 1)/2)-1]);
            }
            else
            {

                $arrPos1 = ($totNo/2)-1;
                $arrPos2 = $arrPos1 + 1;

                $Price1 = $price[$arrPos1];
                $Price2 = $price[$arrPos2];
                $price_val = round(($Price1+$Price2)/2);
            }
        }
        else
            $price_val = 0;

    
   
   
   $stats['price'] = $price_val;
   
   
   /* City Calculation */
   $city = array_column($log_data, 'log_city');
   $frequancy_city = array_count_values($city);
   $percenatage = 100/count($city);
   $max = max($frequancy_city);
   //echo "<pre>";print_r($max);die;
   
   $stats['city_name'] = array_keys($frequancy_city,$max)[0];
   $stats['city_per'] = floor( $max * $percenatage);
   
   
    /* ZipCode Calculation */
   $zip = array_column($log_data, 'log_zip');
   $frequancy_zip = array_count_values($zip);
   $percenatage = 100/count($zip);
   $max = max($frequancy_zip);
   
   $stats['zip_name'] = array_keys($frequancy_zip,$max)[0];
    $stats['zip_per'] = floor( $max * $percenatage);
  
  
   
   /* Property Type Calculation */
   $ptype = array_column($log_data, 'log_ptype');
   $frequancy_ptype = array_count_values($ptype);
   $percenatage = 100/count($ptype);
   $max = max($frequancy_ptype);

   $stats['ptype_name'] = array_keys($frequancy_ptype,$max)[0];
   $stats['ptype_per'] = floor( $max * $percenatage);
   $stats['save_search'] = "No";

   $insert = LPTUserActionLog::getInstance()->InsertStatstics($stats);
   
   
}




?>