<?php

if( !class_exists('ListingDetail')) {
    class ListingDetail implements FrontModule {

        private static $instance;
        private $title="Homes For Sale";

        public $type = "single";

        public $browser_title, $meta_keyword, $meta_desc, $og_image;

        public function __construct(){

        }

        public static function getInstance(){
            if( !isset(self::$instance)){
                self::$instance = new ListingDetail();
            }
            return self::$instance;
        }
        public function requestHandler($isAjaxRequest = false, $moduleKey)
        {   global $objAjaxResp;

            if($moduleKey == 'Schedule_Showing')
            {
                $this->ScheduleShowing();
            }
            elseif($moduleKey == 'Inquiry')
            {
                return $this->Inquiry();
            }

        }
        public function getTitle(){
            return $this->title;
        }

        public function getPageTemplate(){
            global $arrOREConfig;
            add_filter('template_include', function($default_template) {

                global $arrPhysicalPath;

                $templatefilename = 'detail_template.php';
                $template = $arrPhysicalPath['Base'] . $templatefilename;
                $default_template = $template;

                // Load new template also fallback if both condition fails load default
                return $default_template;

            }, 9999);

            //return $pageTemplate;
        }

        public function getContent($POST=''){
            global $objTmpl, $arrPhysicalPath, $arrVirtualPath, $arrConfig, $current_user;

            $objAPI     = IDXAPI::getInstance();

            $meta = get_user_meta($current_user->ID);

            $arrParams = array();
            $arrParams['ListingID_MLS'] = get_query_var('mls_no');
            $recProperty = $objAPI->getListingByMLSNum($arrParams);

            /* REDIS */
            /*$redis = new Redis();
            $redis->connect('127.0.0.1');

            $cacheMLSKey = $redis->get($_SERVER['SERVER_NAME'].'_mls_'.$arrParams['ListingID_MLS']);
            if($cacheMLSKey)
            {
                $recProperty = unserialize($cacheMLSKey);
            }
            else
            {
                $recProperty = $objAPI->getListingByMLSNum($arrParams);

                if(isset($recProperty['MLS_NUM']))
                {
                    $redis->set($_SERVER['SERVER_NAME'].'_mls_'.$recProperty['MLS_NUM'], serialize($recProperty));
                    $redis->expire($_SERVER['SERVER_NAME'].'_mls_'.$recProperty['MLS_NUM'], 900);
                }
            }*/

            $isDeleted = false;

            if(!isset($recProperty['MLS_NUM']))
            {

                $isDeleted = true;
                $recDeletedListing =   $objAPI->getDeletedListingByMLSNum($arrParams);
                if (!isset($recDeletedListing['MLS_NUM']))
                {
                    /* TODO : 2013-12-09, Let's see if removing header will affect in googel webmaster tool, for deleted properties */
                    //header("HTTP/1.0 410 Gone");
                }
                else
                {
                    $detail_url = Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $recDeletedListing);
                    $recDeletedListing['address_short'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressShort'], $recDeletedListing);
                    $recDeletedListing['address_full'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressFull'], $recDeletedListing);

                    $recDeletedListing['title'] 			= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_DETAIL], $recDeletedListing);
                    $recProperty['meta_keyword'] 	= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_META_KEYWORD_DETAIL], $recProperty);

                    $objTmpl->assign(array(
                        'recDeletedListing'			=>	$recDeletedListing,
                        'NoIndex'			=>	true, // To stop search-engine from crawling this page

                    ));

                }

                $city = get_query_var('city');
                $slug = $arrConfig['page-config']['page-permalink-text-detail']['slug-1'];
                $slug = str_replace("CityName-", "",$slug);

                $CityName 	= ucwords(str_replace("-".$slug, " ",$city));

                $arrParam['city'] = str_replace('-',' ',$CityName);
                $arrParam['so'] = 'price';
                $arrParam['sd'] = 'asc';
                $arrParam['page_size'] = 12;
                $arrResult = $objAPI->getIDXListingByParam($arrParam);

                $objTmpl->assign(array(
                    'isDeleted'			=>	$isDeleted,
                    'NoIndex'			=>	true, // To stop search-engine from crawling this page
                    "CityName"			=>	$CityName,
                    'currency'          =>  '$',
                    "rsResult"			=>	$arrResult['rs'],
                    "PhotoBaseUrl"		=>	$arrResult['PhotoBaseUrl'],
                    "total_record"		=>	$arrResult['total_record'],
                    'arrConfig'         =>  $arrConfig,

                ));

                if( is_user_logged_in() ){

                    global $current_user;
                    $userFavMLSNo       = $objAPI->getUserFavoritesHomes($current_user->data->ID);

                    $objTmpl->assign(array(
                        'isUserLoggedIn'    =>  true,
                        'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
                        'user_id'    =>  $current_user->data->ID,

                    ));
                }
                else {

                    $objTmpl->assign(array(
                        'isUserLoggedIn'    =>  false,
                    ));
                }

                $content = $objTmpl->fetch('listing/listing-removed.tpl');

                return $content;



            }else{

                if(!isset($_COOKIE['user_id'])){
			$cookie_val = time().mt_rand();
			$expire_time = time() + (50 * 365 * 24 * 60 * 60);
			setcookie('user_id', $cookie_val, $expire_time , "/");
			$POST = array();
			$POST['lead_type']  = 'Visited Website';
			$POST['lead_user_id'] = 0;
			$POST['lead_ref_id'] = $cookie_val;
			$POST['lead_created_date'] = date('Y-m-d H:i:s');
			$POST['lead_created_by'] = 'Site';

			$user = LPTLeadMaster::getInstance()->Insert($POST);
		}
		/*if($_COOKIE['user_id'] != '')
		{
			$logArr  = array();
			$logArr['log_listing_id'] 	   = '';
			$logArr['log_mlsp_id'] 		   = '';
			$logArr['log_listing_type']    = 'Visit';
			$logArr['log_ref_id'] 	= $_COOKIE['user_id'];
			$logAction = 'Visited Page';
			$id = LPTUserActionLog::getInstance()->InsertLog($logAction, $logArr, $_COOKIE['user_id']);
		}*/
                if($_COOKIE['user_id'] != '')
				{
                    $logArr                     	= array();
                    $logArr['log_listing_id']   	= $recProperty['MLS_NUM'];
                    $logArr['log_mlsp_id']      	= $recProperty['MLSP_ID'];
                    $logArr['log_listing_type'] 	= 'MLS';
                    $logArr['log_city']         	= $recProperty['CityName'];
                    $logArr['log_state']        	= $recProperty['State'];
                    $logArr['log_community']    	= $recProperty['Subdivision'];
                    $logArr['log_price']        	= $recProperty['ListPrice'];
                    $logArr['log_ptype']        	= $recProperty['PropertyType'];
                    $logArr['log_bed']          	= $recProperty['Beds'];
                    $logArr['log_zip']          	= $recProperty['ZipCode'];
                    $logArr['log_additional_info']  = serialize($recProperty);

					$logAction            = 'Full View';
					$logArr['log_ref_id'] = $_COOKIE['user_id'];


					$id = LPTUserActionLog::getInstance()->InsertLog($logAction, $logArr, $_COOKIE['user_id']);
				}

                $detail_url = Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $recProperty);
                $recProperty['address_short'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressShort'], $recProperty);
                $recProperty['address_full'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressFull'], $recProperty);

                $recProperty['title'] 			= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_DETAIL], $recProperty);
                $recProperty['meta_keyword'] 	= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_META_KEYWORD_DETAIL], $recProperty);
                $recProperty['meta_desc'] 		= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_META_DESC_DETAIL], $recProperty);

                if(isset($recProperty['title']))
                    $this->title = $recProperty['title'];

                $this->meta_keyword 	= $recProperty['meta_keyword'];
                $this->meta_desc 		= $recProperty['meta_desc'];

                /*if(isset($recProperty['PictureArr']['large'][0]) && $recProperty['PictureArr']['large'][0] != '')
                {
                    $this->og_image 		= $recProperty['PictureArr']['large'][0]['url'];
                }else{
                    $this->og_image 		= $recProperty['PhotoBaseUrl'].'no-photo/0/0/';
                }*/

                if(is_array($recProperty['PictureArr']) && isset($recProperty['PictureArr'][0]) && $recProperty['PictureArr'][0] != '')
                {
                    $this->og_image 		= $recProperty['PictureArr'][0];
                }else{
                    $this->og_image 		= $recProperty['PhotoBaseUrl'].'/no-photo/no-property-img.jpg';
                }


                $agentInfo      =   $arrConfig['Agent'];
                $agentImgUrl    =   $arrVirtualPath['UploadBase']."agent/";

                $arrRelProp                = array();
                $arrRelProp['ptype']       = $recProperty['PropertyType'];
                $arrRelProp['stype']       = $recProperty['SubType'];
                $arrRelProp['city']       = $recProperty['CityName'];
                $arrRelProp['latitude']    = $recProperty['Latitude'];
                $arrRelProp['longitude']   = $recProperty['Longitude'];
                $arrRelProp['notmlsnum']   = $recProperty['MLS_NUM'];
                $arrRelProp['minprice']    = ($recProperty['ListPrice'] - (($recProperty['ListPrice']*10)/100));
                $arrRelProp['maxprice']    = ($recProperty['ListPrice'] + (($recProperty['ListPrice']*10)/100));
                $arrRelProp['OrderBy']     = 'Miles ASC';
                $arrRelProp['miles']       = '1';
                $arrRelProp['Limit']       = 6; // No.of Propety to fetch
                $arrRelProp['ShowMiles']   = true;
//			$arrRelProp['status']   = array('Active');
                $arr_Active_SimilarProp = $objAPI->getRandomListingByMLSNum($arrRelProp);

                /*$cacheRandomMLSKey = $redis->get($_SERVER['SERVER_NAME'].'_random_mls_'.$recProperty['MLS_NUM']);
                if($cacheRandomMLSKey)
                {
                    $arr_Active_SimilarProp = unserialize($cacheRandomMLSKey);
                }
                else
                {
                    $arrRelProp                = array();
                    $arrRelProp['ptype']       = $recProperty['PropertyType'];
                    $arrRelProp['stype']       = $recProperty['SubType'];
                    $arrRelProp['city']       = $recProperty['CityName'];
                    $arrRelProp['latitude']    = $recProperty['Latitude'];
                    $arrRelProp['longitude']   = $recProperty['Longitude'];
                    $arrRelProp['notmlsnum']   = $recProperty['MLS_NUM'];
                    $arrRelProp['minprice']    = ($recProperty['ListPrice'] - (($recProperty['ListPrice']*10)/100));
                    $arrRelProp['maxprice']    = ($recProperty['ListPrice'] + (($recProperty['ListPrice']*10)/100));
                    $arrRelProp['OrderBy']     = 'Miles ASC';
                    $arrRelProp['miles']       = '1';
                    $arrRelProp['Limit']       = 6; // No.of Propety to fetch
                    $arrRelProp['ShowMiles']   = true;

                    $arr_Active_SimilarProp = $objAPI->getRandomListingByMLSNum($arrRelProp);

                    $redis->set($_SERVER['SERVER_NAME'].'_random_mls_'.$recProperty['MLS_NUM'], serialize($arr_Active_SimilarProp));
                    $redis->expire($_SERVER['SERVER_NAME'].'_random_mls_'.$recProperty['MLS_NUM'], 900);
                }*/

                $maxViewedExceed = 'false';

                if (isset($arrConfig['OtherConfig']['login_enable']) && $arrConfig['OtherConfig']['login_enable'] == 'Yes')
                {
                    if (isset($arrConfig['Listing']['signup_required_for_view_property']) && $arrConfig['Listing']['signup_required_for_view_property'] == 'Yes')
                    {

                        //session_start();
                        /*if(!isset($_SESSION['user_view_details_count']))
                        {
                            $_SESSION['user_view_details_count'] = 0;
                        }*/

                        if ($arrConfig['Listing']['site_max_viewed_without_login'] >= 0 && (!is_user_logged_in() == true)) {
                            //$_SESSION['user_view_details_count'] = $_SESSION['user_view_details_count'] + 1;
                            if ($arrConfig['Listing']['site_max_viewed_without_login'] == 0 || ($arrConfig['Listing']['site_max_viewed_without_login'] > 0 && $_COOKIE['user_view_details_count'] >= $arrConfig['Listing']['site_max_viewed_without_login'])) {
                                $maxViewedExceed = true;
                            }
                        }
                    }
                }

                $virtual_url_link = '';
                if($recProperty['VirtualTourUrl'] != '')
                {
                    $url = $recProperty['VirtualTourUrl'];
                    if (strpos($url, 'youtube.com/') !== false) {
                        // Youtube video
                        $videoId = isset(explode("v=",$url)[1]) ? explode("v=",$url)[1] : null;
                        if (strpos($videoId, '&') !== false){
                            $videoId = explode("&",$videoId)[0];
                        }
                        $virtual_url_link ='https://www.youtube.com/embed/'.$videoId;

                    } else if(strpos($url, 'youtu.be/') !== false) {
                        // Youtube  video
                        $parts=parse_url($url);
                        $path_parts=explode('/', $parts['path']);
                        $ID = $path_parts[count($path_parts)-1];
                        $virtual_url_link = 'https://www.youtube.com/embed/'.$ID;

                    }
                    else if(strpos($url, "vimeo.com/") !== false)
                    {
                        $parts=parse_url($url);
                        $path_parts=explode('/', $parts['path']);
                        $ID  = $path_parts[count($path_parts)-1];
                        if(is_numeric(strpos($ID, ".")))
                        {
                            $ID =  substr($ID, 0, strpos($ID, "."));
                        }

                        $virtual_url_link = 'https://player.vimeo.com/video/'.$ID;
                    }
                    else if(strpos($url, "Matterport.com/") !== false){
                        $virtual_url_link = str_replace('http://','https://',$url);
                    }
                }

                if(isset($recProperty['SystemName']) && $recProperty['SystemName'] == Constants::MLS_ACTRIS)
                {
                    $recProperty['mls_prop_last_run_date'] = new DateTimeImmutable($recProperty['mls_prop_last_run_date']);
                    $MLS_date = gmdate('F d, Y', $recProperty['mls_prop_last_run_date'] ->format('U'));
                    $MLS_time = gmdate('h:ia', $recProperty['mls_prop_last_run_date'] ->format('U'));
                    $MLS_last_update_date = $MLS_date." at ".$MLS_time;
                }
                else
                {
                    $recProperty['mls_prop_last_run_date'] = new DateTimeImmutable($recProperty['mls_prop_last_run_date']);
                    $MLS_last_update_date = gmdate('M d, Y', $recProperty['mls_prop_last_run_date'] ->format('U'));
                }

                if(isset($_GET['t']) && $_GET['t'] == 10){
                    echo '<pre>';print_r($recProperty);exit('dfsdfc');
                }

                $text= file_get_contents('https://www.freddiemac.com/pmms/pmmsthick.html');
                $dom = new DomDocument();
                @ $dom->loadHTML($text);

                $child_elements = $dom->getElementsByTagName('tr');
                if (isset($child_elements) && $child_elements->length > 3)
                    $getTd = $child_elements[3]->getElementsByTagName('td');

                $Mortgage_rate = isset($getTd)?$getTd[0]->nodeValue:'6.42';

                $objTmpl->assign(array(
                    'Record'			 =>	$recProperty,
                    'arrPageConfig'     =>  $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],
                    'agentInfo'         => $agentInfo,
                    'current_user'         => $current_user,
                    'agentImgUrl'         => $agentImgUrl,
                    'Templates_Image'	 =>	$arrVirtualPath['TemplateImages'],
                    'MLS_last_update_date'	=>	$MLS_last_update_date,//gmdate('M d, Y', $recProperty['mls_prop_last_run_date'] ->format('U')),
                    'Site_Url'          =>  get_home_url().'/',
                    'backToUrl'         =>  $_SERVER['HTTP_REFERER'],
                    'ListingID_MLS'     =>  $recProperty['ListingID_MLS'],
                    'print_logo'        =>  $arrVirtualPath['UploadBase']."agent/".$arrConfig['Agent']['print_photo'],
                    'currency'          =>  '$',
                    'arrSimilar'        =>  $arr_Active_SimilarProp['rs'],
                    'PhotoBaseUrl'        =>  $arr_Active_SimilarProp['PhotoBaseUrl'],
                    'google_api_key'    =>  'AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',
                    'arrConfig'         =>  $arrConfig,
                    'detail_url'         =>  $detail_url,
                    'meta'         =>  $meta,
                    'SEOSubtype'   => StaticArray::SEOSubtype(),
                    'maxViewedExceed'		=>	$maxViewedExceed,
                    'isloginReq'		=>	(isset($arrConfig['Listing']['signup_required_for_view_property']) ? $arrConfig['Listing']['signup_required_for_view_property'] : 'No'),
                    'arrPType'	         =>	StaticArray::arrPropertyType(),
                    'arrSType'	         =>	StaticArray::arrSubType(),
                    'virtual_url_link'  => $virtual_url_link,
                    'bitcoin'                       =>	$arrConfig['bitcoin'],
                    'etherium'                      =>	$arrConfig['etherium'],
                    'cardano'                       =>	$arrConfig['cardano'],
                    'Mortgage_rate'         => $Mortgage_rate
                ));

                if( is_user_logged_in() ){

                    global $current_user;
                    $userFavMLSNo       = $objAPI->getUserFavoritesHomes($current_user->data->ID);

                    $objTmpl->assign(array(
                        'isUserLoggedIn'    =>  true,
                        'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
                        'user_id'    =>  $current_user->data->ID,

                    ));
                }
                else {
                    $objTmpl->assign(array(
                        'isUserLoggedIn'    =>  false,
                    ));
                }
                if($_GET['action'] == 'listing-inquiry')
                {
                    echo $objTmpl->fetch('listing/frm-inquiry.tpl');
                    exit(0);
                }
                else
                {
                    $content = $objTmpl->fetch('listing/listing_detail.tpl');

                    return $content;
                }

            }
        }
        public function ScheduleShowing()
        {
            global $objAjaxResp,$arrPhysicalPath,$arrConfig,$objTmpl,$current_user,$arrVirtualPath;


            $objAPI     = IDXAPI::getInstance();
            $POST['ListingID_MLS'] = $_POST['ListingID_MLS'];
            $recProperty = $objAPI->getListingByMLSNum($POST);
            $detail_url = Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $recProperty);
            $recProperty['address_full'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressFull'], $recProperty);
            $recProperty['address_short'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressShort'], $recProperty);
            $recProperty['title'] 			= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_DETAIL], $recProperty);

            $wordpress_upload_dir = wp_upload_dir();
            $uploadPath = $wordpress_upload_dir['baseurl'].'/';

	        if((isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) || ($arrConfig['Listing']['enable_google_captcha'] == 'No'))
	        {

	            if($arrConfig['Listing']['enable_google_captcha'] == 'Yes')
	            {
	                $secretKey = $arrConfig['Listing']['google_secret_key'];


		        $url            = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($secretKey).'&response='.urlencode($_POST['g-recaptcha-response']);
		        $verifyResponse = file_get_contents($url);

		        $responseData = json_decode($verifyResponse);
	            }

		        if(($responseData->success == true && $responseData->score >= 0.5) || !isset($arrConfig['Listing']['enable_google_captcha']) || (isset($arrConfig['Listing']['enable_google_captcha']) && $arrConfig['Listing']['enable_google_captcha'] == 'No'))
		        {
                    #for EST NYC time zone
                    date_default_timezone_set('America/New_York');

				        if(email_exists($_POST['lead_email']) == true)
				        {
					        $checkUser             = get_user_by('email', $_POST['lead_email']);
					        $user_id               = $checkUser->data->ID;
					        $_POST['lead_user_id'] = $user_id;
					        update_user_meta($user_id, 'user_phone', $_POST['lead_home_phone']);
				        }
				        if(strpos($_POST['lead_first_name'], ' ') != false)
				        {
					        $name                     = explode(' ', $_POST['lead_first_name']);
					        $_POST['lead_first_name'] = $name[0];
					        $_POST['lead_last_name']  = $name[1];
				        }

				        $_POST['lead_listing_Id'] = $recProperty['MLS_NUM'];
				        $_POST['lead_mlsp_id']    = $recProperty['MLSP_ID'];
				        $_POST['lead_agent_id']   = $_POST['agent_id'];

				        $_POST['lead_listing_type'] = 'MLS';

				        $Lead['post']               = $_POST;
				        $Lead['record']             = $recProperty;
				        $host_url                   = get_home_url();
				        $IDPrefix                   = 'MLS';


                    $logArr                     = array();
					$logArr['log_listing_id']   = $recProperty['MLS_NUM'];
					$logArr['log_mlsp_id']      = $recProperty['MLSP_ID'];
					$logArr['log_listing_type'] = 'MLS';
					$logArr['log_city']         = $recProperty['CityName'];
					$logArr['log_state']        = $recProperty['State'];
					$logArr['log_community']    = $recProperty['Subdivision'];
					$logArr['log_price']        = $recProperty['ListPrice'];
					$logArr['log_ptype']        = $recProperty['PropertyType'];
					$logArr['log_bed']          = $recProperty['Beds'];
					$logArr['log_zip']          = $recProperty['ZipCode'];

					$logAction            = 'Schedule Showing';
					$logArr['log_ref_id'] = $_COOKIE['user_id'];
			        $Lead['lead_ref_id']  = $_COOKIE['user_id'];


						$id = LPTUserActionLog::getInstance()->InsertLog($logAction, $logArr, $_COOKIE['user_id']);
				        $lead_user_ID = LPTLeadMaster::getInstance()->InsertScheduleShowing($Lead);

				        //			$EmailSubject = get_bloginfo().' Lead : Schedule showing request Received from '.ucwords(strtolower($_POST['lead_first_name'])).' for '.$IDPrefix.'# '.$Record['MLS_NUM'];
				        $EmailSubject = 'Property Inquiry - '.ucwords(strtolower($_POST['lead_first_name'])).' '.ucwords(strtolower($_POST['lead_last_name'])).' @ '.date('H:i a')." - ".get_bloginfo();

				        $objTmpl->assign(array("frmData" => $_POST, "Host_Url" => $host_url, 'Record' => $recProperty,  'site_currency' => '$', 'current_user' => $current_user->data, 'LeadDate' => date('m/d/Y - H:i A'),  "uploadPath" => $uploadPath, "LeadProfile" => admin_url('admin.php?page='.Constants::SLUG.'-'.'user'),"Source"		=>	$_POST['XHR']['URL'],

				                         ));

				        $objTmpl->assign(array("Email_Header" => 'email_header.tpl', "Email_Body" => 'email_schedule_showing.tpl',//				                 "Email_Footer"		=>	'email_footer.tpl'
				                         ));

				        $EmailBody = $objTmpl->fetch('email_layout.tpl');
				        //file_put_contents('schedule-showing.html', print_r($EmailBody ." " .$EmailSubject, true));
				        $EmailTo = $_POST['email_to'];

				        add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

				        $headers = [];
                        if(isset($arrConfig['Listing']['cc_emails']) && !empty($arrConfig['Listing']['cc_emails'])){
                            $cc = explode(',', $arrConfig['Listing']['cc_emails']);
                            foreach($cc as $email){
                                $headers[] = 'Cc: '.$email;
                            }
                        }

				        wp_mail($EmailTo, $EmailSubject, $EmailBody, $headers);

				        # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
				        remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

				        $msgSuccess = "Your schedule preference has been sent successfully.";

				        AjaxResponse::obj()->success($msgSuccess);
		        }
		        else{

			        $msgError = 'Verification failed, please try again.';
			        AjaxResponse::obj()->error($msgError);
		        }
	        }
	        else
	        {   $msgError = 'Something went wrong, please try again.';
		        AjaxResponse::obj()->error($msgError);

	        }



        }
        public function Inquiry()
        {
            global $objAjaxResp,$arrPhysicalPath,$arrConfig,$objTmpl;
            $objAPI     = IDXAPI::getInstance();
            $POST['ListingID_MLS'] = $_POST['ListingID_MLS'];
            $Record = $objAPI->getListingByMLSNum($POST);
            $detail_url = Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record);
            $recProperty['address_full'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressFull'], $Record);
            $recProperty['address_short'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressShort'], $Record);
            $recProperty['title'] 			= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_DETAIL], $Record);

            if (email_exists($_POST['lead_email']) == true)
            {
                $checkUser  =   get_user_by('email', $_POST['lead_email']);
                $user_id    =   $checkUser->data->ID;
                $_POST['lead_user_id'] = $user_id;
                update_user_meta($user_id,'user_phone',$_POST['lead_home_phone']);
            }

            $host_url           =	get_home_url();
            $IDPrefix           =   'MLS';
            if(strpos($_POST['lead_first_name'],' ') !=false)
            {
                $name = explode(' ',$_POST['lead_first_name']);
                $_POST['lead_first_name'] = $name[0];
                $_POST['lead_last_name'] = $name[1];
            }
            $_POST['lead_listing_type'] = 'MLS';
            $_POST['lead_listing_Id']   = $Record['MLS_NUM'];
            $_POST['lead_mlsp_id']      = $Record['MLSP_ID'];
            $_POST['lead_agent_id']   = $_POST['agent_id'];




            if($Record['ListingStatus'] == 'Closed')
            {
                $_POST['lead_note_desc'] = 'Sold Property Inquiry';
            }
            $Lead['post'] = $_POST;
            $Lead['record'] = $Record;

            //Insert into Lead Manage
            $lead_user_ID = $objAPI->InsertPropertyInquiry($Lead);

            $EmailSubject = get_bloginfo().' Lead : Inquiry Request Received from '.ucwords(strtolower($_POST['lead_first_name'])).' for '.$IDPrefix.'# '.$Record['MLS_NUM'];

            $objTmpl->assign(array(
                "frmData"	 =>	$_POST,
                "Host_Url"  => $host_url,
                'Record'    => $Record,
                'title'     => get_bloginfo( 'name' ),
                'site_currency'    =>  '$',
            ));

            $objTmpl->assign(array(
                "Email_Header"		=>	'email_header.tpl',
                "Email_Body"		=>	'email_inquiry.tpl',
                "Email_Footer"		=>	'email_footer.tpl'
            ));

            $EmailBody = $objTmpl->fetch('email_layout.tpl');

            $EmailTo = $_POST['email_to'];
            //$headers[] = array('Content-Type: text/html; charset=UTF-8');

            add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

            $email = wp_mail($EmailTo, $EmailSubject, $EmailBody);
            //echo "<pre>";print_r($email);die;

            # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
            remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));


            $msgSuccess = 'Your inquiry has been sent successfully.';
            AjaxResponse::obj()->success($msgSuccess);

            return $objAjaxResp;
        }
        function set_html_content_type() {
            return 'text/html';
        }
    }
}
?>