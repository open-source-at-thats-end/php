<?php

#=============================================================================================================================
#	File Name		:	send_search_alert.php
#=============================================================================================================================
define('IN_CRON', true);
define('CRON_EMAIL_ADD', '');

ini_set("memory_limit","512M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

ob_start();

# Store start time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_start = $mtime;

/* Setup WordPress environment */
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');

$arrPhysicalPath['UserBase'] 	= $arrPhysicalPath['Base']. 'front' . DS;
$arrPhysicalPath['TemplateBase']		= $arrPhysicalPath['UserBase']. 'templates' . DS;
$arrPhysicalPath['EmailTemplate']		=	$arrPhysicalPath['Base']. 'email_templates'. DS;

$objAPI = IDXAPI::getInstance();

# Get the smarty and create global object
include_once $arrPhysicalPath['Libs']. 'Smarty/Smarty.class.php';

$objTmpl = new Smarty();

$objTmpl->template_dir 	= array($arrPhysicalPath['TemplateBase'], $arrPhysicalPath['EmailTemplate']);
$objTmpl->compile_dir 	= $arrPhysicalPath['UserBase']. 'templates_c';

//include_once $arrPhysicalPath['Base']. 'cronjob/cron_common.php';

$rsSearch = LPTUserSavedSearches::getInstance()->getAllForSearchAlert();

$cntTotal = 0;
$cntNotification = 0;

while($rsSearch->next_record()) {

    $recSearch = $rsSearch->Record;

    $search_criteria	= unserialize($recSearch['search_criteria']);
    unset($search_criteria['clat'],$search_criteria['clng']);

    $PropAfterDate = $recSearch['search_send_till_lastupdatedate'];
    $totalCount		 = $objAPI->getCountbyParam($search_criteria);

    // Search Params
    $search_criteria = array_merge($search_criteria, array('newpropafterdate' => $PropAfterDate));

    // Get Count
    $count_new		 = $objAPI->getCountbyParam($search_criteria);

    echo '<br>User : '. $recSearch['search_user_id']. ' | New Count : '. $count_new;

    # Prop Available, let send email
    if($count_new > 0)
    {

        $arrConfig = get_option(Constants::OPTIONS);
        $ldemail_from_name = $arrConfig['Agent']['agent_name'];
        $ldemail_from_email = $arrConfig['Agent']['agent_email'];

        $post_title=get_the_title($arrConfig['page-config']['page-search-result']);

        // Insert Criteria for sending in email
        $inserted_id = LPTUserSavedSearches::getInstance()->SaveUpdatedSearch($recSearch['search_id'], $search_criteria);

        $listing_lastupdatedate = $objAPI->getListingLastUpdateDate();
        //echo $listing_lastupdatedate;

        # Get listing for current search
        $search_criteria['page_size']  =   5;
        $search_criteria['sort_order_list'] = array('LastUpdateDate' => 'DESC');

        $arrListing =   $objAPI->getListingByParamforSaveSearch($search_criteria);
        $host_url = get_home_url();
        $login_url = $host_url.'?hash='.base64_encode($recSearch['user_email']);

        $wordpress_upload_dir = wp_upload_dir();
        $uploadPath = $wordpress_upload_dir['baseurl'].'/';

        $template_directory_uri   = get_template_directory_uri();
        $logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && ! empty( $user_logo )
            ? $user_logo
            : $template_directory_uri . '/images/logo.png';




        if($arrListing['total_record'] > 0)
        {
            $objTmpl->assign(array(
                "logo"=>$logo,
                "arrListing"    =>  $arrListing,
                //"recAgentInfo"  =>  $recAgentInfo,
                "PhotoBaseUrl"   =>  $arrListing['PhotoBaseUrl'],
                "recSearch"      =>  $recSearch,
                //"sendByType"     =>  $sendByType,
                "host_url"     =>  $host_url,
                "login_url"     =>  $login_url,
                "currency"     =>  '$',
                "countNew"     =>  $totalCount,
                //"user_name"     =>  $recSearch['user_first_name'].' '.$recSearch['user_last_name'],
                "user_name"     =>  $recSearch['display_name'],
                'AgentInfo'       => $arrConfig['Agent'],
                'arrConfig'       => $arrConfig,
                'AgentImgUrl'    => $uploadPath,
                'pageSlug'      => $post_title
            ));

            $EmailSubject = "Saved Search Property Alert";

            $EmailContents =   $objTmpl->fetch("email_search_notify.tpl");

            // Insert Email Details
            $POST = array();
            $POST['ldemail_user_id']		= $recSearch['ID'];
            $POST['ldemail_type']			= 'Search Agent';
            $POST['ldemail_ref_id']			= $inserted_id;
            //$POST['ldemail_added_by_id']  	= $sendById;
            //$POST['ldemail_added_by_type']  = $sendByType;
            //$POST['ldemail_send_by_id'] 	= $sendById;
            //$POST['ldemail_send_by_type'] 	= $sendByType;
            $POST['ldemail_subject'] 		= $EmailSubject;
//    			$POST['ldemail_content'] 		= $EmailContents['Email_Content'].'<br /><br />'.$Link_To_Unsubscribe;
            $POST['ldemail_content'] 		= $EmailContents;
            $POST['ldemail_sign']	 		= "";//$config['email_sign'];
            $POST['ldemail_datetime']		= date('Y-m-d H:i:s');
            $POST['ldemail_bcc']			= '';
            $POST['ldemail_cc']				= $recSearch['user_secondary_emails'];
            $POST['ldemail_sent']			= 'No';
            $POST['ldemail_to_name']		= str_replace('_', ' ', $recSearch['display_name']);
            $POST['ldemail_to_email']		= $recSearch['user_email'];
            $POST['ldemail_from_name']		= $ldemail_from_name;
            $POST['ldemail_from_email']		= $ldemail_from_email;
            $POST['ldemail_use_header_footer']		= "No";

            //echo"<pre>";print_r($POST);
            $emailId = LPTLeadEmail::getInstance()->Insert($POST);

            $cntTotal++;
            // Use Inserted Email Id as Ref.. in sent saved search table
            LPTUserSavedSearches::getInstance()->UpdateSentSearchEmailId($inserted_id, $emailId);

            LPTUserSavedSearches::getInstance()->UpdateSearchRunDate($recSearch['search_id'], $listing_lastupdatedate);

        }

    }

}
print("\nTotal Notification Sent: $cntNotification \n");
print("\nTotal Email Sent: $cntTotal \n");
print("\nEmail Sending Finish =============================== \n");

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

if(strtotime($curtime) >= strtotime($periodFrom)  && strtotime($curtime) <= strtotime($periodTo))
    @mail(CRON_EMAIL_ADD, 'Send Search Alert', $msg);


?>