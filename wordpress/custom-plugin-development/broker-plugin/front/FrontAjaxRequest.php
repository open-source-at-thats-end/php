<?php
/**
 * Created by PhpStorm.
 * User: od1
 * Date: 15/05/20
 * Time: 11:34 PM
 */



class FrontAjaxRequest
{
	private static $instance;
	private        $action;
	private        $xhr_ajax;
	protected $_subaction;

	protected function __construct()
	{


	}

	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new FrontAjaxRequest();
		}

		return self::$instance;
	}
	public function requestHandler()
	{
		global $arrPhysicalPath, $objAjaxResp,$isAjaxRequest;


		include_once($arrPhysicalPath['Libs']."AjaxResponse.php");

		$objAjaxResp = AjaxResponse::obj();
		//echo '<pre>';print_r($_POST);exit();

		$isAjaxRequest = $_POST['ajax_in_site'];

		if ($isAjaxRequest) {
			$strModule = strtolower($_POST['ajax_mod']);

			AjaxResponse::obj()->call_request_area();

			# Unset data base connection
			// DBc::unset_instance();
			//echo "<pre>";print_r(AjaxResponse::obj()->send());die;
			echo AjaxResponse::obj()->send();
			exit();
		} else {
			$strModule = get_query_var(Constants::TYPE_URL_VAR);
		}
	}
}
class Listing
{
	function Schedule_Showing()
	{
		global $arrPhysicalPath,$isAjaxRequest;
		include_once $arrPhysicalPath['UserBase']. 'ListingDetail.php';
		ListingDetail::getInstance()->requestHandler($isAjaxRequest, AjaxResponse::obj()->XHR_MODULE);

	}
	function Inquiry()
	{
		global $arrPhysicalPath,$isAjaxRequest;
		include_once $arrPhysicalPath['UserBase']. 'ListingDetail.php';
		ListingDetail::getInstance()->requestHandler($isAjaxRequest, AjaxResponse::obj()->XHR_MODULE);

	}
}
class LResult
{
    function MS_LP()
    {
        global $objAPI, $objTmpl, $arrVirtualPath, $arrPhysicalPath, $wp, $arrConfig;
        $objAPI = IDXAPI::getInstance();
//echo "<pre>";print_r($_POST);exit("12345");
        if(isset($_POST['pid']) && $_POST['pid'] !== '')
        {
            $predefine = $objAPI->getPredefinedSearchById($_POST['pid']);

            $pid = $_POST['pid'];
            $searchParam = unserialize($predefine['psearch_criteria']);
            $searchParam['getMapData'] = true;
            //$searchParam['page_size']		= (isset($_POST['page_size']) && $_POST['page_size'] != ''? $_POST['page_size']:Constants::LISTING_PAGE_SIZE);

            $page 			= (isset($_POST['spage']) && $_POST['spage'] != '' ? $_POST['spage']: '1');
            $searchParam['start_record'] 	= ($page - 1) * $_POST['page_size'];
            $marketReport = get_home_url().'/'.Constants::TYPE_MARKET_REPORT_DETAIL.'/'.str_replace(' ', '-', $predefine['psearch_title']);

            $searchParam = array_merge($_POST, $searchParam);
            if(isset($_POST['isRental']) && ($_POST['isRental'] == 'true' || $_POST['isRental'] == true))
			{
				$searchParam['status'] = 'rental';
			}

            $arr = Utility::GetSearchParamAndURL(false, $searchParam);
            $shareUrl = get_home_url().'/?'.$arr['url'];
            $objTmpl->assign(array(
            "predefinedId"                           => $pid,
            "psearch_generate_mrktreport"   => $predefine['psearch_generate_mrktreport'], 'psearch_generate_rental'	=>	$predefine['psearch_generate_rental'],
            'psearch_display_tab'	=>	$predefine['psearch_display_tab'],
            "marketReportURL"               => $marketReport,
            "presearch_title"		        =>	$predefine['psearch_title'],
            "isPredefined"		            =>	true,
            "arrPreQuickSorting"	        =>	StaticArray::arrPreQuickSorting(),
            "shareUrl"	                    =>	$shareUrl,
             'is_rental'	    =>	$_POST['isRental'],
            'rental_url'    => get_home_url().'/'.str_replace(' ', '-', $predefine['psearch_title']).'?isrental=true',
            //'disclaimer'		=>	(isset($_POST['disclaimer']) && $_POST['disclaimer'] != ''?$_POST['disclaimer'] : 'true'),
            'tabs'          =>	(isset($_POST['tabs']) && $_POST['tabs'] != ''?$_POST['tabs'] : 'true'),
            ));

            /*if(!isset($_POST['isgrid']) && $_POST['isgrid'] != true)
            {
                //$arr['sparam']['Is_GeoCoded'] = true;
            }*/

            $arr['sparam']['isAjax'] = 'true';
            $arrSearchResult = $objAPI->getIDXListingByParam($arr['sparam'], '', Constants::VT_MAP);

            if(isset($predefine['psearch_result_limit']) && $predefine['psearch_result_limit'] != '')
            {
                $arrSearchResult['total_record'] = $predefine['psearch_result_limit'];
            }else{
                $arrSearchResult['total_record'] = $arrSearchResult['total_record'];
            }

            AjaxResponse::obj()->set_data('weburl', $_POST['URL'].'?'.$arr['url']);
            AjaxResponse::obj()->script("isPredefined = true");

        }else{

            if((isset($_POST['addtype']) && $_POST['addtype'] == 'add') && (isset($_POST['ListingID_MLS']) && $_POST['ListingID_MLS'] != ''))
            {
                $search['ListingID_MLS'] =  $_POST['ListingID_MLS'];

                $Record = $objAPI->getListingByMLSNum($search);
                $detailURL = Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record);
//                AjaxResponse::obj()->redirect($detailURL);
                AjaxResponse::obj()->set_data('weburl', $detailURL);

            }

            if(isset($_POST['isBackSearch']) && $_POST['isBackSearch'] == 'true')
            {
                //$URLparam = str_replace(get_home_url().'/'.$post_title.'/?','/',AjaxResponse::obj()->XHR_URL);
                $URLparam = substr(AjaxResponse::obj()->XHR_URL, strpos(AjaxResponse::obj()->XHR_URL, "?") + 1);
                $arr = Utility::GetSearchParamAndURL($URLparam, false);

            }else{

                if(isset($_POST['lgminbath']) && $_POST['lgminbath'] !== '')
                {
                    $_POST['minbath'] = $_POST['lgminbath'];

                }
                if(isset($_POST['lgminbed']) && $_POST['lgminbed'] !== '')
                {
                    $_POST['minbed'] = $_POST['lgminbed'];

                }
                unset($_POST['lgminbed']);
                unset($_POST['lgminbath']);
                $arr = Utility::GetSearchParamAndURL(false, $_POST);
//                echo "<pre>array1111";print_r($arr);exit();
            }


            $arr['sparam']['getMapData'] = true;
            $page 			= (isset($arr['sparam']['spage']) ? $arr['sparam']['spage']: '1');

            $arr['sparam']['start_record'] 	= ($page - 1) * $arr['sparam']['page_size'];
            //$arr['sparam']['Is_GeoCoded'] = true;

            $arr['sparam']['isAjax'] = 'true';
            /*$arr['sparam']['so'] = (isset($_POST['so']) && $_POST['so'] != ''? $_POST['so']:Constants::DEFAULT_SO);
            $arr['sparam']['sd'] = (isset($_POST['sd']) && $_POST['sd'] != ''? $_POST['sd']:Constants::DEFAULT_SD);*/

            $arr['sparam']['so'] = (isset($_POST['so']) && $_POST['so'] != ''? $_POST['so']:'cosfr');
            $arr['sparam']['sd'] = (isset($_POST['sd']) && $_POST['sd'] != ''? $_POST['sd']:'asc');
            //if ((isset($_POST['spage']) && $_POST['spage'] == 1) || (isset($_POST['spage']) && $_POST['spage'] == ''))
            if (isset($_POST['spage']) && $_POST['spage'] == '')
            {
                //$arr['sparam']['sort_order_list'] = array('DOM' => 'asc', 'ListPrice' => 'desc');
                $arr['sparam']['dom'] = '7';
            }
            //echo "<pre>";print_r($arr);die;
            //$arrSearchResult = $objAPI->getListingByParam($arr['sparam'], '', Constants::VT_MAP);
            $arrSearchResult = $objAPI->getIDXListingByParam($arr['sparam'], '', Constants::VT_MAP);
//            echo '<pre>';print_r($arrSearchResult);exit();

            AjaxResponse::obj()->set_data('weburl', $_POST['URL'].'?'.$arr['url']);
        }

        if($arrSearchResult['total_record'] == 1 && (!isset($arr['sparam']['add']) || $arr['sparam']['add'] == ''))
        {
            $Record       = $arrSearchResult['rs'][0];
            $detailURL = Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record);
            AjaxResponse::obj()->redirect($detailURL);

        }else{
            if( is_user_logged_in() ){

                global $current_user;
                $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);

                $objTmpl->assign(array(
                    'isUserLoggedIn'    =>  true,
                    'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
                    'user_id'    =>  $current_user->data->ID,

                ));
                AjaxResponse::obj()->script("isUserLoggedIn = true");
                //AjaxResponse::obj()->script("userFavList = '".implode(",", $userFavMLSNo['strIds'])."'");
                AjaxResponse::obj()->script("userFavList = '".$userFavMLSNo['strIds']."'");

            }
            else {

                $objTmpl->assign(array(
                    'isUserLoggedIn'    =>  false,
                ));
                AjaxResponse::obj()->script("isUserLoggedIn = false");
//                echo "<pre>";var_dump(AjaxResponse::obj()->script("isUserLoggedIn = false"));exit();
            }

            include_once($arrPhysicalPath['Libs']. '/Mobile-Detect-2.8.19/OE_Mobile_Detect.php');
            $detect  =   new Mobile_Detect();
            $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

            //$arrSearchResult['MLS_last_update_date'] = new DateTimeImmutable($arrSearchResult['MLS_last_update_date']);
            /*if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
            {
                $arrSearchResult['MLS_last_update_date'] = new DateTimeImmutable($arrSearchResult['MLS_last_update_date']);
                $MLS_date = gmdate('F d, Y', $arrSearchResult['MLS_last_update_date']->format('U'));
                $MLS_time = gmdate('h:ia', $arrSearchResult['MLS_last_update_date']->format('U'));
                $MLS_last_update_date = $MLS_date." at ".$MLS_time;

                $arrMeta            = $objAPI->getMeta(array('SubTypeActris'));
                $arrWaterfrontDesc  = StaticArray::arrWaterfrontDescActris();
            }
            else
            {*/
            $arrSearchResult['MLS_last_update_date'] = new DateTimeImmutable($arrSearchResult['MLS_last_update_date']);
            $MLS_last_update_date = gmdate('M d, Y', $arrSearchResult['MLS_last_update_date']->format('U'));
            $arrMeta            = $objAPI->getMeta(array('SubType'));
            $arrWaterfrontDesc  = StaticArray::arrWaterfrontDesc();
//            echo "<pre>";print_r($arrWaterfrontDesc);exit("arrWaterfrontDesc");
            /* }*/
//echo "<pre>arrSearchResult";print_r($arrSearchResult);exit();
            $objTmpl->assign(array(
//            "page"                   => ($arr['sparam']['spage']?$arr['sparam']['spage']:'1'),
            "page"                          =>  $page,
            'Site_Url'                      =>  get_home_url().'/',
            'arrSearchCriteria'	            =>	$arr['sparam'],
            'page_size'                     =>  $arr['sparam']['page_size'],
            'currency'                      =>  '$',
            'arrSortingOption'	            =>	StaticArray::arrSortingOption(),
            'TPL_images'                    =>  $arrVirtualPath['TemplateImages'],
            'arrSearch'		                =>	$arr['sparam'],
            'total_record'	                =>	$arrSearchResult['total_record'],
            'jsonMapData'	                =>	$arrSearchResult['map-data'],
            'MLS_last_update_date'          =>	$MLS_last_update_date,//gmdate('M d, Y', $arrSearchResult['MLS_last_update_date']->format('U')),
            'mapZoomLevel'                  =>  $arr['sparam']['mz'] ? $arr['sparam']['mz'] : 13,
            'mapCenterLat'                  =>  $arr['sparam']['clat'] ? $arr['sparam']['clat'] : 25.761681, // Austin: 30.3074624, -98.0335911 // Dallas 32.8203525, -97.0115281
            'mapCenterLng'                  =>  $arr['sparam']['clng'] ? $arr['sparam']['clng'] : -80.191788,
            'memberDetail'	                =>	Constants::TYPE_MEMBER_DETAIL,
            'deviceType'                    =>  $deviceType,
            'arrMeta'                       =>  $arrMeta,
            'arrPriceRange'	                =>	StaticArray::arrPriceRange(''),
            'arrBedRange'	                =>	StaticArray::arrBedRange(''),
            'arrBathRange'	                =>	StaticArray::arrBathRange(''),
            'arrLotSize'	                =>	StaticArray::arrLotSize(),
            'arrSqftRange'	                =>	StaticArray::arrSQFTRange(''),
            'arrminYearBuild'               =>	StaticArray::arrYearBuild('from'),
            'arrmaxYearBuild'	            =>	StaticArray::arrYearBuild('to'),
            'arrStatus'	                    =>	StaticArray::arrStatus(),
            'arrDayMarket'	                =>	StaticArray::arrDayMarket(),
            'arrYesNo'	                    =>	StaticArray::arrYesNo(),
            'arrWaterfrontDesc'	            =>	$arrWaterfrontDesc,
            'arrSecuritySafety'	            =>	StaticArray::arrSecuritySafety(),
            'arrTrueFalse'	                =>	StaticArray::arrTrueFalse(),
            'arrFurnished'	                =>	StaticArray::arrFurnished(),
            'issorting'		                =>	$_POST['issorting'],
            'issavesearch'                  =>	$_POST['issavesearch'],
            'isGrid'		                =>	(isset($_POST['isgrid']) && $_POST['isgrid'] != ''?$_POST['isgrid'] : 'false'),
            'isFilter'		                =>	(isset($_POST['isFilter']) && $_POST['isFilter'] != ''?$_POST['isFilter'] : 'true'),
            'isHeading'		                =>	(isset($_POST['isHeading']) && $_POST['isHeading'] != ''?$_POST['isHeading'] : 'true'),
            'isstyle'		                =>	(isset($_POST['isstyle']) && $_POST['isstyle'] != ''?$_POST['isstyle'] : false),
            //'sys_name'                    =>  (isset($_POST['sys_name']) && $_POST['sys_name'] != 'both'?$_POST['sys_name'] : Constants::DEFAULT_LISTINGS),
            'device'		                =>	cw::$screen,
            'arrSystemName'                 =>	StaticArray::arrSystemName(),
            'is_map'                        =>  $arr['sparam']['is_map'] ? $arr['sparam']['is_map'] : 'true',
            //'disclaimer'	                =>	(isset($_POST['disclaimer']) && $_POST['disclaimer'] != ''?$_POST['disclaimer'] : 'true'),
            'AgentSystemName'               =>	$arrConfig['Agent']['agent_system_name'],
            'arrConfig'                     =>  $arrConfig,

            ));
//        AjaxResponse::obj()->script("jQuery('.lg-device-bedbath').remove();");
            AjaxResponse::obj()->assign($objTmpl->fetch("listing/map-view.tpl"), '#pms-area-listing');
            AjaxResponse::obj()->assign($objTmpl->fetch("listing/main-device-search-form.tpl"),'#pms-searchfrm');
            AjaxResponse::obj()->script("total_record = '".$arrSearchResult['total_record']."'");
            AjaxResponse::obj()->script("jsonMapData = '".$arrSearchResult['map-data']."'");
            AjaxResponse::obj()->script("issorting = '".$_POST['issorting']."'");
            AjaxResponse::obj()->script("issavesearch = '".$_POST['issavesearch']."'");
            AjaxResponse::obj()->script("isFilter = '".(isset($_POST['isFilter']) && $_POST['isFilter'] != ''?$_POST['isFilter'] : 'false')."'");
            AjaxResponse::obj()->script("isHeading = '".$_POST['isHeading']."'");
            AjaxResponse::obj()->script("isstyle = '".$_POST['isstyle']."'");
        }
    }
}
class User
{
	function __construct()
	{
		global $objAPI;
		$objAPI = IDXAPI::getInstance();
	}

	function Login()
	{
		DoLoginAfterSignup($_POST);
	}
	function SignUP(){
		global $objAjaxResp, $objTmpl, $arrPhysicalPath, $arrConfig, $arrVirtualPath;
		$objAPI = IDXAPI::getInstance();
		$POST = $_POST;
		$allowed_html   = array();
		$msgError = '';
		$user_email  =   trim( sanitize_text_field(wp_kses( $POST['user_email'] ,$allowed_html) ) );
		$user_name   =   trim( sanitize_text_field(wp_kses( $POST['user_first_name'] .'_'.$POST['user_last_name'] ,$allowed_html) ) );

		if((isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'] != '') || ($arrConfig['Listing']['enable_google_captcha'] == 'No'))
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

				if(email_exists($user_email) == false && empty($msgError) and $msgError == '')
				{
					$user_password = $POST['user_password'];
					$user_data     = array('user_pass' => $user_password, 'user_login' => $user_email, 'user_nicename' => $POST['user_first_name'], 'display_name' => $user_name, 'user_email' => $user_email,);
					$user_id       = wp_insert_user($user_data);
					if(is_wp_error($user_id))
					{

						$msgError = 'Please, check all your input(s). Make sure you have entered all valid information.';
					}
					else
					{

						$host_url             = get_home_url();
						$wordpress_upload_dir = wp_upload_dir();
						$uploadPath           = $wordpress_upload_dir['baseurl'].'/';

						/*$POST['user_wp_id'] = $user_id;
						$POST['user_type'] = 'Registered';
						$id = $objAPI->InsertRegistration($POST);*/
						$POST['lead_user_id'] = $user_id;
						$lead                 = LPTLeadMaster::getInstance()->InsertRegistration($POST);
						$hash                 = base64_encode($user_email);
						$login_url            = $host_url.'?hash='.$hash;

						update_user_meta($user_id, 'show_admin_bar_front', false);
						update_user_meta($user_id, 'user_phone', $POST['user_password']);
						# Email To User Start #
						$objTmpl->assign(array("frmData" => $POST, "password" => $user_password, "Site_Title" => get_option('blogname'), 'user_name' => $user_name, 'user_pass' => $user_password, 'user_email' => $user_email, 'login_url' => $login_url, 'Host_Url' => $host_url, 'AgentInfo' => $arrConfig['Agent'], //'logo'           => et_get_option( 'divi_logo' ),
						                       'logo'    => '','title'=>'', "uploadPath" => $uploadPath, 'AgentImgUrl' => $uploadPath));

						$objTmpl->assign(array("Email_Header" => 'email_header.tpl', "Email_Body" => 'email_register.tpl',//"Email_Footer"		=>	'email_footer.tpl'
						                 ));

						$EmailTo      = $POST['user_name'].' <'.$POST['user_email'].'>';
						$headers      = array('From: '.$arrConfig['Agent']['agent_email'].' <'.$arrConfig['Agent']['agent_name'].'>');
						$EmailSubject = "Thank You For Signing Up";

						$EmailBody = $objTmpl->fetch('email_layout.tpl');

						//file_put_contents('register-email.html', print_r($EmailBody, true));

						add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

						 wp_mail($EmailTo, $EmailSubject, $EmailBody);
						//var_dump($user);exit();

						# Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
						remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
						# Email to User End #

						#=======================================#
						# Email to Admin
						global $arrConfig;

						$objTmpl->assign(array("Email_Header" => 'email_header.tpl', "Email_Body" => 'email_register_to_admin.tpl', //				                        "Email_Footer"		=>	'email_footer.tpl',
						                       "LeadDate"     => date('m/d/Y - H:i A'), "LeadProfile" => admin_url('admin.php?page='.Constants::SLUG.'-'.'user'), "RegistrationPage" => $POST['XHR']['URL'], 'logo' => $arrConfig['Agent']['print_photo'], "uploadPath" => $uploadPath,));


						# Prepare Email Data
						$EmailTo = $arrConfig['Agent']['agent_email'];

						$EmailSubject = "New Website Lead - ".ucwords(strtolower(str_replace('_', " ", $user_name)))." @ ".date('H:i a')." - ".get_bloginfo();

						$EmailBody = $objTmpl->fetch('email_layout.tpl');

						//file_put_contents('register-email-admin.html', print_r($EmailBody, true));

						$headers = array('From: '.$arrConfig['Agent']['agent_email'].' <'.$arrConfig['Agent']['agent_name'].'>');
						# Send Email to Author
						add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

						if(isset($arrConfig['Listing']['cc_emails']) && !empty($arrConfig['Listing']['cc_emails'])){
                            $cc = explode(',', $arrConfig['Listing']['cc_emails']);
                            foreach($cc as $email){
                                $headers[] = 'Cc: '.$email;
                            }
                        }

						wp_mail($EmailTo, $EmailSubject, $EmailBody, $headers);

						# Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
						remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

						$msgSuccess = 'Registration completed successfully';
					}
				}
				else
				{
					$msgError = 'Email already exists. Please Sign In to your account and reset password.';
				}
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
		if(isset($msgSuccess) && $msgSuccess != '')
		{

			$POST['username']	= $_POST['user_email'];
			$POST['password']   = $user_password;

			DoLoginAfterSignup($POST);
		}
		else
		{
			AjaxResponse::obj()->error($msgError);
		}



	}
	function ForgotPassword()
	{
		global $objTmpl, $arrPhysicalPath , $current_user, $arrVirtualPath, $arrConfig;
		$allowed_html   =   array();
		$login_user  =  wp_kses ( $_POST['user_email'],$allowed_html ) ;

		if($login_user != '')
		{
			$user = get_user_by('email', $login_user);

			$objUser = $user->data;
			if(isset($objUser->ID) && $objUser->ID > 0)
			{
				$keywordArr     = array($objUser->user_login,$objUser->user_nicename);
				$randPassword	= strtolower(Utility::generatePassword($keywordArr));

                $wordpress_upload_dir = wp_upload_dir();
                $uploadPath = $wordpress_upload_dir['baseurl'].'/';
				wp_set_password( $randPassword, $objUser->ID );

				# Email To User
				$objTmpl->assign(array(
					                 "frmData"        =>	$_POST,
					                 "password"       =>	$randPassword,
					                 "Site_Title"     => get_option('blogname'),
					                 'user_name'      => $objUser->user_login,
					                 'user_email'     => $objUser->user_email,
				                 ));
				$objTmpl->assign(array(
					                 'user_name'		=>	ucwords(strtolower($objUser->user_login)),
					                 'user_first_name'	=>	ucwords(strtolower($objUser->user_login)),
					                 'user_last_name'	=>	ucwords(strtolower($objUser->user_nicename)),
					                 'user_login_id'	=> 	$objUser->user_email,
					                 'user_password'	=>	$randPassword,
					                 'Site_Title'		=>	get_bloginfo(),
					                 'Site_Url'			=>	get_home_url(),
					                 'Site_Domain'		=>	$_SERVER['HTTP_HOST'],
					                 'display_name'		=>	ucwords(strtolower($objUser->display_name)),
					                 'logo'           => $arrConfig['Agent']['print_photo'],
                "uploadPath"		=>	$uploadPath,
				                 ));

				$objTmpl->assign(array(

					                 "Email_Header"		=>	'email_header.tpl',
					                 "Email_Body"		=>	'email_forgot_password.tpl',
					                 //"Email_Footer"		=>	'email_footer.tpl',
				                 ));

				$EmailTo = $objUser->user_email;
				$EmailSubject = 'Forgot Or Reset Password';

				$EmailBody = $objTmpl->fetch('email_layout.tpl');
                //file_put_contents('forgot-pwd.html', print_r($EmailBody, true));
				add_filter( 'wp_mail_content_type', array($this, 'set_html_content_type') );

				wp_mail( $EmailTo, $EmailSubject, $EmailBody);

				# Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
				remove_filter( 'wp_mail_content_type', array($this, 'set_html_content_type') );

				$msgSuccess = "Password has been Sent successfully.";
				AjaxResponse::obj()->success($msgSuccess);
			}
			else
			{
				$msgError = "Email address is not registered with us.";
				AjaxResponse::obj()->error($msgError);
			}
		}
		else
		{
			$msgError = "Invalid request found.";
			AjaxResponse::obj()->error($msgError);
		}
	}
	function UserFavourites()
	{
		global $objAjaxResp, $objTmpl, $arrPhysicalPath , $current_user;
		$POST = $_POST;
		$MlsNum     = $POST['mls_no'];
		$Action     = $POST['favaction'];
		$PageType   = $POST['pageType'];
		$isredirect = $POST['isredirect'];
		$userId     = $POST['UserId'];
		$id= '#fav-link-container-'.$POST['mls_no'];
		switch($Action)
		{

			case "Add":
				$objAPI     = IDXAPI::getInstance();

				LPTUserFavoriteProperty::getInstance()->UpdateFavoritesHomes($userId, $MlsNum, $Action);

				if($POST['page_type'] == 'FullView')
				{
                    $width='';
                    if(isset($POST['ismobile']) && $POST['ismobile'] == true)
                    {
                        $width = 'w-100';
                    }
					//$loveitlink = '<a class="btn btn-sm te-btn text-white text-uppercase te-font-size-14 shadow-none p-2 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn lpt-btn-txt '.$width.'" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Remove\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart pr-2"></i> SAVE</a>';
                    $loveitlink = '<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2- py-2 py-lg-2 px-xl-3 px-lg-2 te-save-propery-detail rounded-0 mx-1- mx-lg-0- lpt-btn- lpt-btn-txt- btn-gray '.$width.'" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Remove\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fa-2x pr-1 align-middle"></i> Save</a>';
					AjaxResponse::obj()->assign( $loveitlink,'.fav-link-container');
				}
				elseif($POST['page_type'] == 'Similar' || $POST['page_type'] == 'Other')
				{
					$slovelink = '<a class="" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Remove\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fav-icon"></i> </a>';
					AjaxResponse::obj()->assign( $slovelink,$id);
				}
				elseif ($POST['page_type'] == 'SearchResult')
                {
                    $loveitlink = '<a class="" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Remove\',\'SearchResult\',\''.$userId.'\');" href="JavaScript:void(0);" title="Remove to favorites"><i class="fas fa-heart fav-icon"></i></a>';
                    AjaxResponse::obj()->assign( $loveitlink, '.fav-link-container-'.$MlsNum);

                    $userFavList = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($userId);
                    //$objTmpl->assign(array('userFavList'    =>  $userFavList));
                    AjaxResponse::obj()->script("parent.userFavList='".implode(",",$userFavList)."';");
                }
				elseif ($POST['page_type'] == 'CondoSearchResult')
                {
                    $loveitlink = '<a class="mr-3" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Remove\',\'CondoSearchResult\',\''.$userId.'\');" href="JavaScript:void(0);" title="Remove to favorites"><i class="fas fa-heart fav-icon"></i></a>';
                    AjaxResponse::obj()->assign( $loveitlink, '.fav-link-container-'.$MlsNum);

                    $userFavList = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($userId);
                    AjaxResponse::obj()->script("parent.userFavList='".implode(",",$userFavList)."';");
                }

				break;
			case "Remove":
				$objAPI     = IDXAPI::getInstance();

				LPTUserFavoriteProperty::getInstance()->UpdateFavoritesHomes($userId, $MlsNum, $Action);
				if($POST['page_type'] == 'FullView')
				{
                    $width='';
                    if(isset($POST['ismobile']) && $POST['ismobile'] == true)
                    {
                        $width = 'w-100';
                    }
					//$loveitlink = '<a class="btn btn-sm te-btn text-white text-uppercase te-font-size-14 shadow-none p-2 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn lpt-btn-txt '.$width.'" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Add\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="far fa-heart pr-2"></i> SAVE</a>';
                    $loveitlink = '<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2- py-2 py-lg-2 px-xl-3 px-lg-2  te-save-propery-detail rounded-0 mx-1- mx-lg-0- lpt-btn- lpt-btn-txt- btn-gray '.$width.'" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Add\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i> Save</a>';
                    AjaxResponse::obj()->assign( $loveitlink,'.fav-link-container');
				}
				if($POST['page_type'] == 'Similar')
				{
					$slovelink = '<a class="" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Add\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="far fa-heart fav-icon"></i></a>';
					AjaxResponse::obj()->assign( $slovelink,$id);
				}
				elseif($POST['page_type'] == 'Other')
				{
					$slovelink = '<a class="" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Add\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="far fa-heart fav-icon"></i></a>';
					AjaxResponse::obj()->assign( $slovelink,$id);
					AjaxResponse::obj()->script("window.location.reload();");
				}
                if ($POST['page_type'] == 'SearchResult')
                {
                    $loveitlink = '<a class="" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Add\',\'SearchResult\',\''.$userId.'\');" href="JavaScript:void(0);" title="Add to favorites"><i class="far fa-heart fav-icon"></i></a>';
                    AjaxResponse::obj()->assign( $loveitlink, '.fav-link-container-'.$MlsNum);

                    $userFavList = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($userId);
                    //$tpl->assign(array('userFavList'    =>  $userFavList));
                    AjaxResponse::obj()->script("parent.userFavList='".implode(",",$userFavList)."';");

                }
                if ($POST['page_type'] == 'CondoSearchResult')
                {
                    $loveitlink = '<a class="mr-3" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Add\',\'CondoSearchResult\',\''.$userId.'\');" href="JavaScript:void(0);" title="Add to favorites"><i class="far fa-heart fav-icon"></i></a>';
                    AjaxResponse::obj()->assign( $loveitlink, '.fav-link-container-'.$MlsNum);

                    $userFavList = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($userId);
                    AjaxResponse::obj()->script("parent.userFavList='".implode(",",$userFavList)."';");
                }

				break;
		}

	}
    function UserFavouritesCondos()
    {
        global $objAjaxResp, $objTmpl, $arrPhysicalPath , $current_user;
        $POST = $_POST;
        $CondoId     = $POST['condo_id'];
        $Action     = $POST['favaction'];
        $PageType   = $POST['pageType'];
        $isredirect = $POST['isredirect'];
        $userId     = $POST['UserId'];
        $id= '#fav-link-container-'.$POST['condo_id'];
        switch($Action)
        {

            case "Add":
                $objAPI     = IDXAPI::getInstance();

                LPTUserFavoriteCondo::getInstance()->UpdateFavoritesCondos($userId, $CondoId, $Action);

                if($POST['page_type'] == 'CondoFullView')
                {
                    $width='';
                    if(isset($POST['ismobile']) && $POST['ismobile'] == true)
                    {
                        $width = 'w-100';
                    }
                    //$loveitlink = '<a class="btn btn-sm te-btn text-white text-uppercase te-font-size-14 shadow-none p-2 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn lpt-btn-txt '.$width.'" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Remove\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart pr-2"></i> SAVE</a>';
                    $loveitlink = '<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2- py-2 py-lg-2 px-xl-3 px-lg-2 te-save-propery-detail rounded-0 mx-1- mx-lg-0- lpt-btn- lpt-btn-txt-  '.$width.'" onclick="JavaScript:UpdateFavoritesCondos_Click(\''.$POST['condo_id'].'\', \'Remove\',\'CondoFullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fa-2x pr-1 align-middle"></i></a>';
                    AjaxResponse::obj()->assign( $loveitlink,'.fav-link-container');
                }
                elseif($POST['page_type'] == 'Other')
                {
                    $slovelink = '<a class="" onclick="JavaScript:UpdateFavoritesCondos_Click(\''.$POST['condo_id'].'\', \'Remove\',\'CondoFullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fav-icon"></i> </a>';
                    AjaxResponse::obj()->assign( $slovelink,$id);
                }

                break;
            case "Remove":
                $objAPI     = IDXAPI::getInstance();

                LPTUserFavoriteCondo::getInstance()->UpdateFavoritesCondos($userId, $CondoId, $Action);
                if($POST['page_type'] == 'CondoFullView')
                {
                    $width='';
                    if(isset($POST['ismobile']) && $POST['ismobile'] == true)
                    {
                        $width = 'w-100';
                    }
                    //$loveitlink = '<a class="btn btn-sm te-btn text-white text-uppercase te-font-size-14 shadow-none p-2 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn lpt-btn-txt '.$width.'" onclick="JavaScript:UpdateFavorites_Click(\''.$POST['mls_no'].'\', \'Add\',\'FullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="far fa-heart pr-2"></i> SAVE</a>';
                    $loveitlink = '<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2- py-2 py-lg-2 px-xl-3 px-lg-2  te-save-propery-detail rounded-0 mx-1- mx-lg-0- lpt-btn- lpt-btn-txt- '.$width.'" onclick="JavaScript:UpdateFavoritesCondos_Click(\''.$POST['condo_id'].'\', \'Add\',\'CondoFullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i></a>';
                    AjaxResponse::obj()->assign( $loveitlink,'.fav-link-container');
                }
                elseif($POST['page_type'] == 'Other')
                {
                    $slovelink = '<a class="" onclick="JavaScript:UpdateFavoritesCondos_Click(\''.$POST['condo_id'].'\', \'Add\',\'CondoFullView\',\''.$userId.'\');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="far fa-heart fav-icon"></i></a>';
                    AjaxResponse::obj()->assign( $slovelink,$id);
                    AjaxResponse::obj()->script("window.location.reload();");
                }

                break;
        }

    }
	function EditProfile()
	{
	    global $objAPI;
		$allowed_html= array();
		$user_id = $_POST['user_id'];
		$user_name   =   trim( sanitize_text_field(wp_kses( $_POST['user_first_name'] .'_'.$_POST['user_last_name'] ,$allowed_html) ) );
		$user_data = array(
			'ID' => $user_id,
			'user_login'    =>  $_POST[ 'user_email' ],
			'user_nicename' => $_POST['user_first_name'],
			'display_name'  => $user_name,
			'user_email'    => $_POST[ 'user_email' ],
		);
        /*$_POST['user_wp_id'] = $user_id;
        $objAPI->UpdateRegistration($_POST);*/
        $_POST['user_type'] = 'registered';
		wp_update_user($user_data);
		$user_meta = StaticArray::UserMeta();

		foreach($user_meta as $val)
		{
			update_user_meta( $user_id, $val, $_POST[$val]);
		}

		$msgSuccess = "Your profile has been updated successfully.";
		AjaxResponse::obj()->success($msgSuccess);
	}
	function ChangePassword()
	{
		$allowed_html= array();
		$user = wp_get_current_user();
		$check = wp_check_password($_POST[ 'current_password'],$user->data->user_pass,$user->data->ID);
		if($check == true)
		{
			wp_set_password($_POST['new_password'],$user->data->ID);
			$msgSuccess = "Password has been updated successfully.";
			AjaxResponse::obj()->success($msgSuccess);
		}
		else{
			$msgSuccess = "Current Password is wrong!";
			AjaxResponse::obj()->error($msgSuccess);
		}




	}
	function SaveSearch()
    {
        global $current_user;

        $objAPI     = IDXAPI::getInstance();

        if(isset($_POST['pid']) && $_POST['pid'] != ''){

            $predefined = $objAPI->getPredefinedSearchById($_POST['pid']);
            $search_crieteria = unserialize($predefined['psearch_criteria']);

            $arr_param = Utility::GetSearchParamAndURL('', $search_crieteria);
        }
        elseif (isset($_POST['cid']) && $_POST['cid'] != '')
        {
            $condo = CondoSearch::getInstance()->getCondoSearchById($_POST['cid']);
            $search_crieteria = unserialize($condo['csearch_criteria']);

            $arr_param = Utility::GetSearchParamAndURL('', $search_crieteria);
        }
        else{
            $arr_param = Utility::GetSearchParamAndURL($_POST['surl'], false);
            $search_crieteria = $arr_param['sparam'];
           // $search_crieteria['Is_GeoCoded'] = true;
        }

        $result_count = $objAPI->getCountbyParam($search_crieteria);
        $listing_lastupdatedate = $objAPI->getListingLastUpdateDate();

        $POST['search_title']= $_POST['search_title'];
        $POST['search_crieteria'] = $search_crieteria;
        $POST['result_count'] = $result_count;
        $POST['url'] = $_POST['surl'];
        $POST['listing_lastupdatedate'] = $listing_lastupdatedate;
        $POST['user_id'] = $current_user->ID;
        $POST['search_saved_main_url'] = get_home_url();
        $POST['search_saved_site'] = $_SERVER['HTTP_HOST'];
        $POST['search_saved_from'] = (isset($_POST['pid']) && $_POST['pid'] != '' ? 2 : 1);

        $opt=get_option('lpt_config');

        $post_title=get_the_title($opt['page-config']['page-search-result']);

       /* if(strpos($_SERVER['HTTP_HOST'], 'project') !== false || strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
        {
            $slug = get_home_url().'/'.$post_title;
        }else{
            $slug = '/'.$post_title;
        }*/

        $POST['search_page_slug'] = $post_title;

        $agent = $objAPI->getInfoByWebsite($POST['search_saved_site']);

        if(is_array($agent) && count($agent) > 0)
        {
            $POST['search_site_agent'] = $agent[0]['agent_id'];
        }else{
            $POST['search_site_agent'] = 0;
        }

        $search_Id = LPTUserSavedSearches::getInstance()->InsertUserSaveSearch($POST);

        if($search_Id > 0){
            $msgSuccess = "Search has been saved.";
            AjaxResponse::obj()->success($msgSuccess);
        }
        else{
            $msgError = "Something went wrong!";
            AjaxResponse::obj()->error($msgError);
        }


    }
    function RunSearch()
    {
    	global $objAPI,$arrConfig;
	    $rs = LPTUserSavedSearches::getInstance()->getSavedSearchById($_POST['search_id']);
	    $arrSearchParams = unserialize($rs['search_criteria']);

        $arr_param = Utility::GetSearchParamAndURL(false, $arrSearchParams);
	    //$url = Utility::getInstance()->SearchParamAndURL(false,$arrSearchParams)['url'];
	    /*$url = '';

	    foreach($arrSearchParams as $key => $val)
	    {
	    	if(strpos($url,'?') === false)
		    {
			    $url.= '?'.$key.'='.$val;

		    }
		    else{
			    $url.= '&'.$key.'='.$val;
		    }

	    }*/

		AjaxResponse::obj()->set_data('url',get_the_permalink($arrConfig['page-config']['page-search-result']).'?'.$arr_param['url']);

    }
    function DeleteSearch()
    {
	    global $objAPI,$arrConfig;
	   // $user_search = LPTUserSavedSearches::getInstance()->getSavedSearchById($_POST['search_id']);
	    LPTUserSavedSearches::getInstance()->DeleteSearch($_POST['search_id']);

	    AjaxResponse::obj()->success("Search has been deleted successfully");
    }
    function SearchEmailNotification()
    {
        global $objAPI;
        $new_Search_id = $_POST['search_id'];

        $POST['newid'] = $_POST['newid'];
        $POST['search_id'] = $_POST['search_id'];

	    LPTUserSavedSearches::getInstance()->UpdateSavedSearchEmailAlert($_POST['newid'], $_POST['search_id']);
        AjaxResponse::obj()->script("$('#save_search_response_$new_Search_id').show();");
    }
    function set_html_content_type() {
        return 'text/html';
    }
}
function DoLoginAfterSignup($POST)
{

	$allowed_html   =   array();
	$login_user  =  wp_kses ( $POST['username'],$allowed_html );
	$login_pwd   =  wp_kses ( $POST['password'], $allowed_html);

	wp_clear_auth_cookie();
	$info                   = array();
	$info['user_login']     = $login_user;
	$info['user_password']  = $login_pwd;

	$user_signon            = wp_signon( $info, true );
	if ( is_wp_error($user_signon) ){

		$msgError =  'Wrong username or password!';
		AjaxResponse::obj()->error($msgError);
	} else {
		global $current_user;
//echo "<pre>";print_r($POST);die;
		wp_set_current_user($user_signon->ID);
		do_action('set_current_user');
		$current_user = wp_get_current_user();

		$msgSuccess = 'Login successful, redirecting...';

        AjaxResponse::obj()->script("jQuery('.close').trigger('click');");

		if($POST['OnPage'] == 'FullView') {
			if($POST['ReqType'] == 'AddFav'){
				AjaxResponse::obj()->script("UpdateFavorites_Click('".$POST['mlsNum']."','Add','FullView',$user_signon->ID);");

				AjaxResponse::obj()->script('setTimeout("window.parent.location.reload()", 2000);');
			}else{

                AjaxResponse::obj()->script("window.parent.location.reload();");
            }
		}
		else if($POST['OnPage'] == 'Similar') {
			if($POST['ReqType'] == 'AddFav'){
				AjaxResponse::obj()->script("UpdateFavorites_Click('".$POST['mlsNum']."','Add','Similar',$user_signon->ID);");

				AjaxResponse::obj()->script('setTimeout("window.parent.location.reload()", 2000);');
			}
		}
        else if($POST['OnPage'] == 'SearchResult') {
            if($POST['ReqType'] == 'AddFav'){
                AjaxResponse::obj()->script("UpdateFavorites_Click('".$POST['mlsNum']."','Add','SearchResult',$user_signon->ID);");

                AjaxResponse::obj()->script('setTimeout("window.parent.location.reload()", 2000);');
            }
            elseif($POST['ReqType'] == 'SaveSearch')
            {
                $savebutton = '<button id="save_search" type="button" class="btn ml-1 ml-lg-1 rounded-0 shadow-none border-secondary te-btn text-white popup-modal-sm" data-url="'.get_home_url().'/'.Constants::TYPE_MEMBER_DETAIL.'/?action=SaveSearch&pid='.$POST['pid'].'" data-toggle="modal" data-target="savesearch">
                            Save Search
                        </button>';
                AjaxResponse::obj()->assign( $savebutton,'#user-savesearch');
                 AjaxResponse::obj()->assign($savebutton,'.save_search_mob');
                AjaxResponse::obj()->script("parent.jQuery('#save_search').trigger('click');");
                AjaxResponse::obj()->set_data('save_search', true);
                 AjaxResponse::obj()->script('setTimeout("window.parent.location.reload()", 15000);');

//                AjaxResponse::obj()->set_data('ReloadResult', true);
            }
            else{

                AjaxResponse::obj()->script("window.parent.location.reload();");
            }
        }
        else if($POST['OnPage'] == 'CondoSearchResult') {
            if($POST['ReqType'] == 'SaveSearch')
            {
                $savebutton = '<button id="save_search" class="btn btn-sm align-self-center btn-gray- font-size-sm-12 font-size-sm-10 te-btn- text-white- te-font-size-14 te-btn- shadow-none p-0 p-lg-2 p-xl-2 px-2- text-md-right te-pre-saveser px-xl-3 font-tab- col-md-4- col-xl-auto- px-sm-3 rounded-0 lpt-btn- lpt-btn-txt- popup-modal-sm" data-url="'.get_home_url().'/'.Constants::TYPE_MEMBER_DETAIL.'/?action=SaveSearch&cid='.$condoId.'" data-toggle="modal" data-target="savesearch">
                                            <i class="far fa-2x fa-bell align-middle pr-2"></i>
                                            <span class="d-none- d-sm-inline">Alerts</span>
                                        </button>';
                AjaxResponse::obj()->assign( $savebutton,'#user-condo-savesearch');
                AjaxResponse::obj()->script("parent.jQuery('#save_search').trigger('click');");
                AjaxResponse::obj()->set_data('condo_save_search', true);
                AjaxResponse::obj()->script('setTimeout("window.parent.location.reload()", 15000);');
            }
            else{

                AjaxResponse::obj()->script("window.parent.location.reload();");
            }
        }
        else if(isset($POST['OnPage']) && $POST['OnPage'] == 'RandomResult')
        {
            #Check & Add MLS_NUM to Fav.
            if($POST['ReqType'] == 'AddFav')
            {

                AjaxResponse::obj()->script("UpdateFavorites_Click('".$POST['mlsNum']."','Add','SearchResult',$user_signon->ID);");
                AjaxResponse::obj()->script('setTimeout("window.parent.location.reload()", 2000);');
                //AjaxResponse::obj()->script("window.parent.location.reload();");
            }
            else
            {
                AjaxResponse::obj()->script("window.parent.location.reload();");

            }
        }
		else{
			AjaxResponse::obj()->script("parent.window.location ='".get_home_url()."/myaccount"."';");
		}
	}
}