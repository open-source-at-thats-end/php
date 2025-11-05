<?php

#=============================================================================================================================
#	File Name		:	insert_user_save_search.php
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
echo "\n	File Name:		insert_user_save_search.php 			";
echo "\n	Execution Date:  " . date("D M j G:i:s T Y");
echo "\n==============================================\n";

print("Process Start =============================== \n");

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');

$arrStatistics = LPTLeadMaster::getInstance()->getAllStatistics();

$cntTotal = 0;

while($arrStatistics->next_record())
{
    $listing_lastupdatedate = $objAPI->getListingLastUpdateDate();

    $opt=get_option('lpt_config');
    $post_title=get_the_title($opt['page-config']['page-search-result']);

    $statisticsCriteria = array();
    $statisticsCriteria['city']      = $arrStatistics->f('statstic_city_name');
    $statisticsCriteria['zipcode']  .= $arrStatistics->f('statstic_zipcode');
    $statisticsCriteria['ptype']    .= $arrStatistics->f('statstic_ptype');

    $arrsearchParam = Utility::GetSearchParamAndURL(false, $statisticsCriteria);

    $POST['search_title']               = 'Recomended For You';
    $POST['search_crieteria']           = $statisticsCriteria;

    $result_count                       = $objAPI->getCountbyParam($statisticsCriteria);
    $POST['result_count']               = $result_count;
    $POST['url']                        = $arrsearchParam['url'];
    $POST['listing_lastupdatedate']     = $listing_lastupdatedate;
    $POST['user_id']                    = $arrStatistics->f('lead_user_id');
    $POST['search_saved_from']          = (isset($arrStatistics->f['pid']) && $arrStatistics->f['pid'] != '' ? 2 : 1);
    $POST['search_ref_id']              = $arrStatistics->f('statstic_ref_id');
    $POST['search_saved_main_url']      = get_home_url();
    $POST['search_saved_site']          = $_SERVER['HTTP_HOST'];
    $POST['search_page_slug']           = $post_title;
    $POST['search_added_by_type']       = 'Cron';

    $search_Id = LPTUserSavedSearches::getInstance()->InsertUserSaveSearch($POST);

    if($search_Id != '' && $search_Id > 0)
        LPTLeadMaster::getInstance()->updateStatisticsSaveSearchValue($arrStatistics->f('statstic_ref_id'));

    $cntTotal++;
}

print("\nTotal Insert User Save Search: $cntTotal \n");
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

/*if(strtotime($curtime) >= strtotime($periodFrom)  && strtotime($curtime) <= strtotime($periodTo))
    @mail(CRON_EMAIL_ADD, 'Insert User Save Search', $msg);*/
?>