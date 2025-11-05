<?php

#=============================================================================================================================
#	File Name		:	generate_sitemap.php
#=============================================================================================================================
define('IN_CRON', 	true);

ini_set("memory_limit","-1");  //set memory to 50Meg
ini_set("max_execution_time", 34400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

ob_start();

# Store start time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_start = $mtime;

echo "\n================================================";
echo "\n	File Name:		generate_sitemap.php 			";
echo "\n	Execution Date:  " . date("D M j G:i:s T Y");
echo "\n==============================================\n";

print("Process Start =============================== \n");

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');

$arrPhysicalPath['UserBase']            = $arrPhysicalPath['Base']. 'front' . DS;
$arrPhysicalPath['TemplateBase']		= $arrPhysicalPath['UserBase']. 'templates' . DS;

# Get the smarty and create global object
include_once $arrPhysicalPath['Libs']. 'Smarty/Smarty.class.php';

$objTmpl = new Smarty();

$objTmpl->template_dir 	= $arrPhysicalPath['TemplateBase'];
$objTmpl->compile_dir 	= $arrPhysicalPath['UserBase']. 'templates_c';



# Get Count For Total Listing
$arrParam = array();
$arrParam['sitemap'] = 'Yes';
//$totalListing = $objAPI->getCountbyParam($arrParam);
//$totalListing = IDXListing::obj()->getListingCountByParam($arrParam);

//echo "totalListing : =======". $totalListing. "========\n";



$arrParam['page_size'] = 1000;

$arrParam['so'] = 'updated';
$arrParam['sd']	= 'desc';
$arrParam[V_TYPE]	= VT_SITE_MAP;

$objTmpl->assign(array(
    'Site_Root'         =>  get_home_url(),
    'currency'          =>  '$',
));
$_SESSION['start_record'] = 0;

//$rsListing = $objAPI->getIDXListingByParam($arrParam, false, VT_SITE_MAP);
$rsListing = IDXListing::obj()->getIDXListingByParam($arrParam, false, VT_SITE_MAP);



$db->db_close();


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

//@mail(CRON_EMAIL_ADD, $config['site_title'].': Sitemap For Listing Generated', $msg);

?>