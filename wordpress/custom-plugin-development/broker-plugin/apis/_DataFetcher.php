<?php

define('IN_API', 	true);

ini_set("memory_limit","700M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

@set_time_limit(60*10);
if (!defined('IN_SECURE') )
{
    /* Need to save dubug info */
    if (isset($_POST['debug']) && $_POST['debug'] == 'true') {
        # Store start time
        $t_start = 0;
        list($usec, $sec) = explode(" ", microtime());
        $t_start = ((float)$usec + (float)$sec);
    }

    include_once(dirname(dirname(__FILE__)). "/includes/common.php");
    $config['api_flag'] = false;
}

if(isset($_GET['test']))
    $_POST = $_GET;

$Filter = unserialize(base64_decode($_POST['filter']));

//file_put_contents('post.txt', print_r($_POST, true));

$cache_path = $physical_path['Site_Root']."/cache-api";
$cache_filename = md5(serialize($_POST));

$curHour = date('G');
if($curHour >= 5)
{
    $cache_time 		= mktime(5,0,0, date('n'), date('j')+1, date('Y'));
    $last_cache_time 	= mktime(5,0,0, date('n'), date('j'), date('Y'));
}
else
{
    $cache_time 		= mktime(5,0,0, date('n'), date('j'), date('Y'));
    $last_cache_time 	= mktime(5,0,0, date('n'), date('j')-1, date('Y'));
}

if (file_exists($cache_path. '/'. $cache_filename) && $config['site_api_cache_enable'] == 'Yes')
{
    $lastModifiedTime = filemtime($cache_path. '/'. $cache_filename);

    /* Check for valid cache */
    //if (@(strtotime("now") - $lastModifiedTime) <= $cache_time) {
    if (($curHour >= 5 && $lastModifiedTime > $last_cache_time) || ($curHour < 5 && $lastModifiedTime <= $cache_time && $lastModifiedTime > $last_cache_time))
    {
        /* Read request file */
        $returnData = file_get_contents($cache_path. '/'. $cache_filename);

        //$objLog->Insert($_SERVER['HTTP_REFERER'], $returnData);

        /* Return data */
        if ($config['api_flag']=== true)
        {
            echo $returnData;
        }
        else
        {
            return unserialize($returnData);
        }

        exit(0);
    }
}


if(isset($_POST['agent']) && is_array($_POST['agent']) && $_POST['type'] != 'getWebsiteAgent' && $_POST['type'] != 'activateAgent'){

  $checkagent = AgentRosterMaster::getInstance()->GetAgentByParam($_POST['agent']);

  if(!is_array($checkagent) && empty($checkagent)){
      return false;
  }

}

/* Prepare output base on command */
switch($_POST['cmd'])
{
    # Shortcode Request
    # ---------------------------------------------------------
    case 'shortcode':

        /*include_once($physical_path['DB_Access']. '/ShortCodeMaster.php');
        $obShortcode = ShortCodeMaster::getInstance();*/

        switch($_POST['type'])
        {
            case 'add':
                $returnData = ShortCodeMaster::getInstance()->addShortcode($Filter);
                break;
            case 'get':
                $returnData = ShortCodeMaster::getInstance()->getShortcode($Filter);
                break;
            case 'getByid':
                $returnData = ShortCodeMaster::getInstance()->getShortcodeById($Filter);
                break;
            case 'update':
                $returnData = ShortCodeMaster::getInstance()->updateShortcode($Filter);
                break;
            case 'delete':
                $returnData = ShortCodeMaster::getInstance()->deleteShortcode($Filter);
                break;
            case 'viewall':
                $returnData = ShortCodeMaster::getInstance()->viewAllShortcode();
                break;

        }
    break;
    case 'predefine':

        /*include_once($physical_path['DB_Access']. '/PredefinedSearch.php');
        $obPredefine = PredefinedSearch::getInstance();*/

        switch($_POST['type'])
        {
            case 'add':
                $returnData = PredefinedSearch::getInstance()->addPredefinedSearch($Filter);
                break;
            case 'get':
                $returnData = PredefinedSearch::getInstance()->getPredefined($Filter);
                break;
            case 'getByid':
                $returnData = PredefinedSearch::getInstance()->getPredefinedSearchById($Filter);
                break;
            case 'update':
                $returnData = PredefinedSearch::getInstance()->updatePredefinedSearch($Filter);
                break;
            case 'delete':
                $returnData = PredefinedSearch::getInstance()->deletePredefinedSearch($Filter);
                break;
            case 'viewall':
                $returnData = PredefinedSearch::getInstance()->viewAllShortcode();
                break;
            case 'getcount':
                $returnData = PredefinedSearch::getInstance()->getPredefinedSearchCountById($Filter);
                break;
            case 'getlisting':
                $returnData = PredefinedSearch::getInstance()->getListingByPreSearch($Filter);
                break;

        }
        break;
    case 'address':
        /*include_once($physical_path['DB_Access']. '/IDXListing.php');
        $obIDXListing = new IDXListing();*/

        switch($_POST['type'])
        {
            case 'allcity':
                $returnData = IDXListing::obj()->getCityKeyValueArray($Filter);
                break;

        }
    break;
    case 'user':
        /*include_once($physical_path['DB_Access']. '/IDXUser.php');
        $obIDXUser = IDXUser::getInstance();*/

        switch($_POST['type'])
        {
            case 'get':
                $returnData = IDXUser::getInstance()->getUser($Filter);
                break;
	        case 'updatefav':
	        	$user_id = $Filter['UserId'];
		        $MLSNo = $Filter['mls_no'];
		        $Action = $Filter['favaction'];
		        $returnData = IDXUser::getInstance()->UpdateFavorites($user_id,	$MLSNo, $Action);
		        break;
	        case 'getfav':
	        	$returnData = IDXUser::getInstance()->getUserFav($Filter);
		        break;
	        case 'registration':
	        	$returnData = IDXUser::getInstance()->Insert($Filter);
	        	break;
	        case 'UpdateRegistration':
	        	$returnData = IDXUser::getInstance()->UpdateRegistration($Filter);
	        	break;
		    case 'insertSaveSearch':
	        	$returnData = IDXUser::getInstance()->InsertUserSaveSearch($Filter);
		        break;
	        case 'getSaveSearch':
	        	$returnData = IDXUser::getInstance()->getSearches($Filter);
		        break;
	        case 'searchById':
	        	$returnData = IDXUser::getInstance()->getSavedSearchById($Filter);
		        break;
	        case 'delete':
	        	$returnData = IDXUser::getInstance()->DeleteSearch($Filter);
		        break;
		    case 'updatesavesearchemailalert':
                $newId = $Filter['newid'];
                $searchId = $Filter['search_id'];
	        	$returnData = IDXUser::getInstance()->UpdateSavedSearchEmailAlert($newId, $searchId);
		        break;

        }
    break;
    case 'property':
       /* include_once($physical_path['DB_Access']. '/IDXListing.php');
        $obIDXListing = IDXListing::obj();*/

        switch($_POST['type'])
        {
            case 'pic':
                $NoPicPath = $physical_path['Upload']."/pictures/";

                if($_GET['MlsNum'] == 'no-photo')
                {
                    $destFileFullPath = $NoPicPath. 'no-img.jpg';
                }
                else
                {
                    $Listing_MLS_ID = $_GET['MlsNum'];
                    $arrID = explode("-",$Listing_MLS_ID);

                    $Pic_No = $_GET['pic_no'];

                    $ListingID	= $arrID[0];//.'-'.$arrID[1];
                    $MLS_ID		= $arrID[1];

                    if (strlen($ListingID)>2)
                        $folderName = substr($ListingID,-2);
                    else
                        $folderName = $ListingID;

                    $pic_Path = $physical_path['Upload']. "/pictures/".IDXListing::obj()->picPath['MLS_Pic_Folder'][$MLS_ID]."/".$folderName."/";
                    $pic_Path .= $ListingID."/";

                    if ($_GET['cpic'])
                        $pic_Path .= "custom/";


                    if($ListingID)
                    {
                        $destFileFullPath = $pic_Path. $ListingID. '_'. $Pic_No.'.jpg';
                        //					echo $destFileFullPath; die;
                        if(!file_exists($destFileFullPath))
                            $destFileFullPath = $NoPicPath. 'no-img.png';

                        if (($Pic_No!=0) && ($_GET['graypic']))
                            $destFileFullPath = $NoPicPath. 'small_image_grey.gif';
                    }
                    else
                        $destFileFullPath = $NoPicPath. 'no-img.png';

                }

                /* Output content HTTP header already set by Thumbnail class */

                /* Setup browser/proxy level cache header */
                $offset = 60 * 60 * 24 * 30;	/* calc an offset of 30 days */
                //$offset = 60 * 60;		/* calc an offset of 1 hour */
                $lastModifiedTime = filemtime($destFileFullPath);
                $Etag = md5_file($destFileFullPath);

                /* Set cache age */
                header("Pragma: cache");
                header("Cache-Control: max-age=". $offset);

                /* calc the string in GMT, not localtime  and set expries and last modified time */
                header("Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT");
                header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModifiedTime)." GMT");
                /* Set Etag */
                header("Etag: ". $Etag);

                /* Check for valid cache */
                if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModifiedTime ||
                    @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $Etag) {
                    header("HTTP/1.1 304 Not Modified");
                    exit(0);
                }
                # Make thumb
                $thumb = new Thumbnail();

                # Make thumb
                $thumb->image($destFileFullPath);
                $thumb->jpeg_quality(100);

                if ($_GET['width'] && $_GET['height'] && isset($_GET['v']) && $_GET['v'] == 2)
                    $thumb->size_smart_v2($_GET['width'], $_GET['height']);
                elseif ($_GET['width'] && $_GET['height'] && isset($_GET['v']) && $_GET['v'] == 'f')
                    $thumb->size_fix($_GET['width'], $_GET['height']);
                elseif ($_GET['width'] && $_GET['height'])
                {
                    if($_GET['v'] == 'g' && ($_GET['width'] > $thumb->src_width() && $_GET['height'] > $thumb->src_height()))
                        $thumb->size_fix($thumb->src_width(),$thumb->src_height());
                    else
                        $thumb->size_smart($_GET['width'], $_GET['height']);
                }
                elseif ($_GET['width'])
                    $thumb->size_width($_GET['width']);
                elseif ($_GET['height'])
                    $thumb->size_width($_GET['height']);
                elseif (isset($_GET['thumb']) && $_GET['thumb'])
                    $thumb->size_auto(100);
                else
                    $thumb->size_fix($thumb->src_width(),$thumb->src_height());

                $thumb->show();
                exit(0);
                break;
            case 'getMeta':

               /*include_once($physical_path['DB_Access']. '/Metadata.php');
                $objMetadata = new Metadata();*/

                $returnData = array();

                foreach($Filter as $key => $val)
                {
                    // PropType
                    if($val == 'PropertyType')
                    {
                        $returnData['PropertyType'] = IDXListing::obj()->getPropTypeKeyValueArray($Filter);
                    }
                    // PropStyle
                    elseif($val == 'PropertyStyle')
                    {
                        $returnData['PropertyStyle'] = $asset['OL_PropertyStyle'];
                        //$returnData['PropertyStyle'] = Metadata::obj()->getMetadataValue('PropertyStyle','',$Filter);
                    }
                    // Sub Type
                    elseif($val == 'SubType')
                    {
                      $returnData['SubType'] = $asset['OL_SubType'];
                        //$returnData['SubType'] = $obIDXListing->getSubTypeKeyValueArray($Filter);
                    }
                    // Elementary School
                    elseif($val == 'ElementarySchool')
                    {
                        $returnData['ElementarySchool'] = IDXListing::obj()->getEleSchoolKeyValueArray($Filter);
                    }
                    // Middle_School
                    elseif($val == 'MiddleSchool')
                    {
                        $returnData['MiddleSchool'] = IDXListing::obj()->getMidSchoolKeyValueArray($Filter);
                    }
                    // High_School
                    elseif($val == 'HighSchool')
                    {
                        $returnData['HighSchool'] = IDXListing::obj()->getHighSchoolKeyValueArray($Filter);
                    }
                    // City
                    elseif($val == 'City')
                    {
                        $returnData['City'] = IDXListing::obj()->getCityKeyValueArray($Filter);
                    }
                    // County
                    elseif($val == 'County')
                    {
                        $returnData['County'] = IDXListing::obj()->getCountyKeyValueArray($Filter);
                    }
                    // Subdivision
                    elseif($val == 'Subdivision')
                    {
                        $returnData['Subdivision'] = IDXListing::obj()->getSubdivisionKeyValueArray($Filter);
                    }
                    // CityWiseZip
                    elseif($val == 'CityWiseZip')
                    {
                        $returnData['CityWiseZip'] = IDXListing::obj()->getCityWiseZipKeyValueArray($Filter);
                    }

                    // Area
                    elseif($val == 'Area')
                    {
                        $returnData['Area'] = IDXListing::obj()->getAreaKeyValueArray($Filter);
                    }
                    // LotDescription
                    elseif($val == 'LotDescription')
                    {
                        $returnData['LotDescription'] = Metadata::obj()->getMetadataValue('LotDescription','',$Filter);
                    }
                    // Elementary School
                    elseif($val == 'Stories')
                    {
                        $returnData['Stories'] = Metadata::obj()->getMetadataValue('Stories','',$Filter);
                    }
                    // Heating
                    elseif($val == 'Heating')
                    {
                        $returnData['Heating'] = Metadata::obj()->getMetadataValue('Heating','',$Filter);
                    }
                    // Cooling
                    elseif($val == 'Cooling')
                    {
                        $returnData['Cooling'] = Metadata::obj()->getMetadataValue('Cooling','',$Filter);
                    }
                    // Basement
                    elseif($val == 'Basement')
                    {
                        $returnData['Basement'] = Metadata::obj()->getMetadataValue('Basement','',$Filter);
                    }
                    elseif((string)$key == 'ResSubType' || (string)$key == 'MultiSubType' || (string)$key == 'LeaseSubType' || (string)$key == 'LotSubType' || (string)$key == 'ComSubType')
                    {
                        $returnData[(string)$key] = Metadata::obj()->getMetadataValue('Subtype', $val);
                    }
                    // Book section
                    elseif($val == 'BookSection')
                    {
                        $returnData['BookSection'] = Metadata::obj()->getMetadataValue('BookSection','',$Filter);
                    }
                    // Garage
                    elseif($val == 'Garage')
                    {
                        $returnData['Garage'] = Metadata::obj()->getMetadataValue('Garage','',$Filter);
                    }
                    // Get MetaData
                    elseif(/*$val == 'PropertyStyle' || $val == 'SubType' || $val == 'Heating' || $val == 'Cooling' || $val == 'Basement' || $val == 'Garage' || $val == 'Stories' || */$val == 'PropertyStyleCOM' || $val == 'View' || $val == 'WaterfrontDesc')
                    {
                        $returnData[$val] = Metadata::obj()->getMetadataValue($val,'',$Filter);
                    }
                    elseif($val == 'StyleForSale')
                    {
                        $returnData['StyleForSale'] = $asset['OL_Style_ForSale'];
                    }
                    elseif($val == 'StyleForLease')
                    {
                        $returnData['StyleForLease'] = $asset['OL_Style_ForLease'];
                    }
                    elseif($val == 'SaleType')
                    {
                        $returnData['SaleType'] = $asset['OL_SaleType'];
                    }
                    elseif($val == 'ListingStatus')
                    {
                        $returnData['ListingStatus'] = $asset['OL_Listing_Status'];
                    }
                    elseif($val == 'ListingType')
                    {
                        $returnData['ListingType'] = $asset['OL_Listing_Type'];
                    }
                }

            break;
            case 'count';
                $returnData = IDXListing::obj()->getListingCountByParam($Filter);
            break;
            case 'data';
                $returnData = IDXListing::obj()->getListingByParam($Filter);
                break;
            case 'fullData';
                $returnData = IDXListing::obj()->getListingByID($Filter);
                break;
	        case 'RandomData';
		        $returnData = IDXListing::obj()->getRandomListingByMLSNum($Filter);
		        break;
            case 'ListingLastUpdateDate';
                $returnData = IDXListing::obj()->getListingLastUpdateDate();
                break;
            case 'deletedListing';
                $returnData = IDXListing::obj()->GetDeletedListing($Filter);
                break;
            case 'SaveSearchdata';
                $returnData = IDXListing::obj()->getListingByParamforSaveSearch($Filter);
                break;


        }
        break;
    case 'market':

        /*include_once($physical_path['DB_Access']. '/MarketReportsMaster.php');
        $objMarket = MarketReportsMaster::getInstance();*/

        switch($_POST['type'])
        {
            case 'add':
                $returnData = MarketReportsMaster::getInstance()->InsertMarketReports($Filter);
                break;
            case 'getbyParam':
                $returnData = MarketReportsMaster::getInstance()->getMarketReportsByParam($Filter);
                break;
            case 'get':
                $returnData = MarketReportsMaster::getInstance()->getMarketReports($Filter);
                break;
            case 'getByid':
                $returnData = MarketReportsMaster::getInstance()->getMarketReportsById($Filter);
                break;
            case 'update':
                $returnData = MarketReportsMaster::getInstance()->updateMarketReports($Filter);
                break;
            case 'delete':
                $returnData = MarketReportsMaster::getInstance()->deleteMarketReports($Filter);
                break;
            case 'viewall':
                $returnData = MarketReportsMaster::getInstance()->viewAllMarketReports();
                break;

        }
    break;
    case 'agent':

        /*include_once($physical_path['DB_Access']. '/AgentRosterMaster.php');
        $objAgentMaster = AgentRosterMaster::getInstance();*/

        switch($_POST['type'])
        {
            case 'add':
                $returnData = AgentRosterMaster::getInstance()->addAgent($Filter);
                break;
            case 'get':
                $returnData = AgentRosterMaster::getInstance()->getAgent($Filter);
                break;
            case 'getByid':
                $returnData = AgentRosterMaster::getInstance()->getAgentById($Filter);
                break;
            case 'update':
                $returnData = AgentRosterMaster::getInstance()->updateAgent($Filter);
                break;
            case 'delete':
                $returnData = AgentRosterMaster::getInstance()->deleteAgent($Filter);
                break;
            case 'viewall':
                $returnData = AgentRosterMaster::getInstance()->viewAllMarketReports();
                break;
            case 'getInfoByWebsite':
                $returnData = AgentRosterMaster::getInstance()->getInfoByWebsite($Filter);
                break;
            case 'getWebsiteAgent':
                $returnData = AgentRosterMaster::getInstance()->GetAgentByWebsite($Filter);
                break;
            case 'addDefaultAgent':
                $returnData = AgentRosterMaster::getInstance()->addDefaultAgent($Filter);
                break;
            case 'activateAgent':
                $returnData = AgentRosterMaster::getInstance()->ActivateAgentByKey($Filter);
                break;

        }
        break;

	case 'predefine-search':
		switch($_POST['type'])
		{
			case 'getbytitle':
				$returnData = PredefinedSearch::getInstance()->getPredefinedSearchByTitle($Filter);
				break;
			case 'get-statistic':
				$returnData = PredefinedSearch::getInstance()->getPreDefineStatisticById($Filter);
				break;


		}
		break;
	case 'lead':
		 switch($_POST['type'])
		 {
			 case 'schedule':
			 	$returnData = Lead::obj(true)->InsertScheduleShowing($Filter['post'],$Filter['record']);
			 	break;
			 case 'inquiry':
				 $returnData = Lead::obj(true)->InsertPropertyInquiry($Filter['post'],$Filter['record']);
				 break;
             case 'registration':
                 $returnData = Lead::obj(true)->InsertRegistration($Filter);
                 break;
             case 'getuserlead':
                 $returnData = Lead::obj(true)->getRegisterAndUnregisterUser($Filter);
                 break;

		 }
}


# Write Cache File
# --------------------------------------------------------------------
if($config['site_api_cache_enable'] == 'Yes')
    file_put_contents($cache_path. '/'. $cache_filename, serialize($returnData));

//$objLog->Insert($_SERVER['HTTP_REFERER'], serialize($returnData));

/* Return data */
if ($config['api_flag']=== true)
{
    $output 				= array();
    // $returnData['Server']   = $_SERVER;
    $output["Result"] 		= $returnData;

    /* save dubug info */
    if ($_POST['debug'] == 'true') {
        # Check end time
        $t_end 	= 0;
        list($usec, $sec) = explode(" ", microtime());
        $t_end = ((float)$usec + (float)$sec);
        $eTime = $t_end - $t_start;

        $output["Debug_Info"] 	= array('ExecTime'	=>	$eTime,
            'ReqTime'	=>	date('Y-M-d H:i:s'),
        );
    }

    $db->db_close();

    echo serialize($output);
}
else
{

    unset($_POST['cmd']);
    unset($_POST['type']);
    unset($_POST['filter']);

    echo json_encode($returnData);
}
?>