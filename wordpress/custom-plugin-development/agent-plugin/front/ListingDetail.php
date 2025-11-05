<?php

if( !class_exists('ListingDetail')) {
	class ListingDetail implements FrontModule {

		private static $instance;
		private $title="Homes For Sale";

		public $type = "single";

		public $browser_title, $meta_keyword, $meta_desc, $og_image;

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


		}
		public function getTitle(){
			return $this->title;
		}

		public function getPageTemplate(){

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
			global $objTmpl, $arrVirtualPath, $arrConfig, $current_user;

            $wordpress_upload_dir = wp_upload_dir();

            $uploadPath = $wordpress_upload_dir['baseurl'].'/';


            $agent_id = get_query_var('agent_id');
            if(isset($agent_id) && $agent_id != "") {
                $agent_id = trim(str_replace('aid-', '', $agent_id));
                $objagent = LPTAgentProfile::getInstance()->getInfoByIdAgent($agent_id);

                $objTmpl->assign(array(
                    'objagent'          => $objagent,
                    'agentprofileImgUrl'   =>  $uploadPath,
                ));
            }

            $objAPI     = IDXAPI::getInstance();

			$meta = get_user_meta($current_user->ID);

			$arrParams = array();
			$arrParams['ListingID_MLS'] = get_query_var('mls_no');
			//$recProperty = $objAPI->getListingByMLSNum($arrParams);
			//echo '<pre>';print_r($recProperty);exit();

            /* REDIS */
			if ((isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == 'Yes') || (!isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == '')) {
				$redis = new Redis();
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
						$redis->expire($_SERVER['SERVER_NAME'].'_mls_'.$recProperty['MLS_NUM'], 600);
					}
				}
			}
			else {
				$recProperty = $objAPI->getListingByMLSNum($arrParams);
			}

			$isDeleted = false;
            //$recProperty = $objAPI->getListingByMLSNum($arrParams);
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
					$userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);

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

                $wordpress_upload_dir = wp_upload_dir();

				$agentInfo      =   $arrConfig['Agent'];
//                $agentInfo['agent_photo']      =   $arrConfig['Site_Agent']['agent_photo'];
                $agentImgUrl    =   $wordpress_upload_dir['baseurl'].'/';


				/*$arrRelProp                = array();
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


				$arr_Active_SimilarProp = $objAPI->getRandomListingByMLSNum($arrRelProp);*/
				if ((isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == 'Yes') || (!isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == '')) {
					$cacheRandomMLSKey = $redis->get($_SERVER['SERVER_NAME'].'_random_mls_'.$recProperty['MLS_NUM']);
					//$cacheRandomMLSKey ='';
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
						$redis->expire($_SERVER['SERVER_NAME'].'_random_mls_'.$recProperty['MLS_NUM'], 600);
					}
				}

				$maxViewedExceed = 'false';
                if (isset($arrConfig['OtherConfig']['login_enable']) && $arrConfig['OtherConfig']['login_enable'] == 'Yes')
                {
                    if (isset($arrConfig['Listing']['signup_required_for_view_property']) && $arrConfig['Listing']['signup_required_for_view_property'] == 'Yes')
                    {

                        if (($arrConfig['Listing']['site_max_viewed_without_login'] >= 0) && (!is_user_logged_in() == true)) {
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
                $arrCryptoData = $objAPI->getCryptoData();

                $text= file_get_contents('https://www.freddiemac.com/pmms/pmmsthick.html');
                $dom = new DomDocument();
                @ $dom->loadHTML($text);

                $child_elements = $dom->getElementsByTagName('tr');
                if (isset($child_elements) && $child_elements->length > 3)
                    $getTd = $child_elements[3]->getElementsByTagName('td');

                $Mortgage_rate = isset($getTd)?$getTd[0]->nodeValue:'6.42';

				$objTmpl->assign(array(
					                 'Record'            =>	$recProperty,
					                 'arrPageConfig'     =>  $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],
					                 'agentInfo'         => $agentInfo,
					                 'current_user'      => $current_user,
					                 'agentImgUrl'       => $agentImgUrl,
					                 'Templates_Image'	=>	$arrVirtualPath['TemplateImages'],
                                     'MLS_last_update_date'	=>	$MLS_last_update_date,
					                 'Site_Url'          =>  get_home_url().'/',
					                 'backToUrl'         =>  $_SERVER['HTTP_REFERER'],
					                 'ListingID_MLS'     =>  $recProperty['ListingID_MLS'],
					                 'print_logo'        =>  $arrVirtualPath['UploadBase']."agent/".$arrConfig['Agent']['print_photo'],
					                 'currency'          =>  '$',
					                 'arrSimilar'        =>  $arr_Active_SimilarProp['rs'],
					                 'PhotoBaseUrl'      =>  $arr_Active_SimilarProp['PhotoBaseUrl'],
					                 'google_api_key'    =>  'AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',
					                 'arrConfig'         =>  $arrConfig,
					                 'detail_url'        =>  $detail_url,
					                 'meta'              =>  $meta,
					                 'SEOSubtype'        =>  StaticArray::SEOSubtype(),
					                 'maxViewedExceed'   =>	 $maxViewedExceed,
					                 'isloginReq'		 =>	 (isset($arrConfig['Listing']['signup_required_for_view_property']) ? $arrConfig['Listing']['signup_required_for_view_property'] : 'No'),
					                 'virtual_url_link'  =>  $virtual_url_link,
                                     'arrPType'	         =>	 StaticArray::arrPropertyType(),
                                     'arrSType'	         =>	 StaticArray::arrSubType(),
                                     'bitcoin'           =>	 $arrCryptoData['bitcoin'],
                                     'etherium'          =>  $arrCryptoData['etherium'],
                                     'cardano'           =>	 $arrCryptoData['cardano'],
                                     'AgentCryptoValue'  =>	$arrConfig['Site_Agent']['crypto_active'],
                                     'user_log_in'         =>	( is_user_logged_in() )?'Yes':'No',
                                     'Mortgage_rate'         => $Mortgage_rate,
                                     'hideAddress'       =>  (isset($arrConfig['Listing']['hide_property_address']))?$arrConfig['Listing']['hide_property_address']:'No',
                                     //'AgentCryptoValue'  =>	false,
				                 ));

				if( is_user_logged_in() ){

					global $current_user;
					$userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);

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

				$content = $objTmpl->fetch('listing/listing_detail.tpl');

				return $content;

			}
		}
		public function ScheduleShowing()
		{
			global $objAjaxResp,$arrConfig,$objTmpl,$current_user,$arrVirtualPath;


			$objAPI     = IDXAPI::getInstance();
			$POST['ListingID_MLS'] = $_POST['ListingID_MLS'];
			$recProperty = $objAPI->getListingByMLSNum($POST);
			$detail_url = Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $recProperty);
			$recProperty['address_full'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressFull'], $recProperty);
			$recProperty['address_short'] 	= Utility::formatListingAddress($arrConfig['Listing']['AddressShort'], $recProperty);
			$recProperty['title'] 			= Utility::formatListingTitle($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_DETAIL], $recProperty);

			$wordpress_upload_dir = wp_upload_dir();
			$uploadPath = $wordpress_upload_dir['baseurl'].'/';
			if((isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))  || !isset($arrConfig['Listing']['enable_google_captcha']) || (isset($arrConfig['Listing']['enable_google_captcha']) && $arrConfig['Listing']['enable_google_captcha'] == 'No'))
			{

				if($arrConfig['Listing']['enable_google_captcha'] == 'Yes')
				{
					$secretKey = $arrConfig['Listing']['google_secret_key'];


					$url            = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($secretKey).'&response='.urlencode($_POST['g-recaptcha-response']);
					$verifyResponse = file_get_contents($url);

					$responseData = json_decode($verifyResponse);
				}
				if(($responseData->success == true && $responseData->score >= 0.5) || !isset($arrConfig['Listing']['enable_google_captcha']) || (isset($arrConfig['Listing']['enable_google_captcha']) && $arrConfig['Listing']['enable_google_captcha'] == 'No')  )
				{
                    date_default_timezone_set('America/New_York');

					if (email_exists($_POST['lead_email']) == true)
					{
						$checkUser  =   get_user_by('email', $_POST['lead_email']);
						$user_id    =   $checkUser->data->ID;
						$_POST['lead_user_id'] = $user_id;
						update_user_meta($user_id,'user_phone',$_POST['lead_home_phone']);
					}
					if(strpos($_POST['lead_first_name'],' ') !=false)
					{
						$name = explode(' ',$_POST['lead_first_name']);
						$_POST['lead_first_name'] = $name[0];
						$_POST['lead_last_name'] = $name[1];
					}

					$_POST['lead_listing_Id'] = $recProperty['MLS_NUM'];
					$_POST['lead_mlsp_id']    = $recProperty['MLSP_ID'];
					$_POST['lead_agent_id']   = $_POST['agent_id'];

					$_POST['lead_listing_type'] = 'MLS';
					# Check user is logged, if user is logged then insert user id
					if( is_user_logged_in() )
					{
						# Get logged user id
						$userID = get_current_user_id();

						if(is_numeric($userID))
							$_POST['lead_user_id'] = $userID;
					}
					else
					{
						# Get user info by email
						$userInfo = get_user_by('email',$_POST['lead_email']);

						# Check user is exist
						if(is_object($userInfo) && is_numeric($userInfo->ID))
							$_POST['lead_user_id'] = $userInfo->ID;
					}

					$host_url           =	get_home_url();

					$lead_user_ID = LPTLeadMaster::getInstance()->InsertScheduleShowing($_POST);

					$EmailSubject = 'Property Inquiry - '. ucwords(strtolower($_POST['lead_first_name'])) . ' ' . ucwords(strtolower($_POST['lead_last_name'])). ' @ '. date('H:i a')." - ".get_bloginfo();

					$objTmpl->assign(array(
						                 "frmData"	    =>	$_POST,
						                 "Host_Url"      => $host_url,
						                 'Record'        => $recProperty,
						                 //'title'         => get_bloginfo( 'name' ),
						                 'site_currency' =>  '$',
						                 'current_user'  =>  $current_user->data,
						                 'LeadDate'      =>  date('m/d/Y - h:i A'),
						                 //'logo'          => $arrConfig['Agent']['print_photo'],
						                 "uploadPath"	=>	$uploadPath,
						                 "LeadProfile"	=>	admin_url('admin.php?page=' . Constants::SLUG . '-' . 'user'),
                                         "Source"		=>	$_POST['XHR']['URL'],

					                 ));

					$objTmpl->assign(array(
						                 "Email_Header"		=>	'email_header.tpl',
						                 "Email_Body"		=>	'email_schedule_showing.tpl',

					                 ));

					$EmailBody = $objTmpl->fetch('email_layout.tpl');

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

					remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

					$msgSuccess = "Your contact preference has been sent successfully.";

					AjaxResponse::obj()->success($msgSuccess);
				}
				else{
					$msgError = 'Verification failed, please try again.';
					AjaxResponse::obj()->error($msgError);
				}
			}
			else{
				$msgError = 'Something went wrong, please try again.';
				AjaxResponse::obj()->error($msgError);
			}

		}

		function set_html_content_type() {
			return 'text/html';
		}
	}
}

?>