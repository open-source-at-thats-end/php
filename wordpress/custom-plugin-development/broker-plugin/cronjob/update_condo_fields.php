<?php

#=============================================================================================================================
#	File Name		:	update_condo_fields.php
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
echo "\n	File Name:		update_condo_fields.php 			";
echo "\n	Execution Date:  " . date("D M j G:i:s T Y");
echo "\n==============================================\n";

print("Process Start =============================== \n");
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');
$condoMinMaxSearch =[];
$condoSearches = CondoSearch::getInstance()->getCondoSearch();

foreach ($condoSearches as $condos) {
    $condoMinMaxSearch = CondoSearch::getInstance()->getCondoMinMaxFields($condos['csearch_id'], $condos['csearch_criteria']);
}

echo "<pre>"; print_r($condoMinMaxSearch);die;

print("Process End =============================== \n");

# Check end time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_end 	= $mtime;

echo "\nResponse Time ". number_format($t_end-$t_start,2)." sec \n";
echo "\n==============================================\n";

$msg = ob_get_contents();
ob_end_clean();
echo $msg;

# Mail Time : Between 4:00:00 To 4:40:00
$periodFrom = date('G:i:s', mktime(4,0,0, date('n'), date('j'), date('Y')));
$curtime 	= date("G:i:s");
$periodTo 	= date('G:i:s', mktime(4,15,0, date('n'), date('j'), date('Y')));
?>