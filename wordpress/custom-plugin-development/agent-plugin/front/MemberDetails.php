<?php

if(!session_id()) {
    session_start();
}

if( !class_exists('MemberDetails')) {
    class MemberDetails implements FrontModule {

        private static $instance;

        public function __construct(){

		}

        public static function getInstance(){
			if( !isset(self::$instance)){
				self::$instance = new MemberDetails();
			}
			return self::$instance;
		}

        public function getTitle(){
			return $this->title;
		}

        public function getPageTemplate(){
			global $arrOREConfig;
			$pageTemplate = $arrOREConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TEMPLATE_DETAIL];

			return $pageTemplate;
		}

        public function getContent($POST=''){
            global $objTmpl,$arrConfig,$arrPhysicalPath;

            $Action     = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');
            $mlsNum     = isset($_GET['mlsNum']) ? $_GET['mlsNum'] : (isset($_POST['mlsNum']) ? $_POST['mlsNum'] : '');
            $ReqType    = isset($_GET['ReqType']) ? $_GET['ReqType'] : (isset($_POST['ReqType']) ? $_POST['ReqType'] : '');
            $IsPage     = isset($_GET['IsPage']) ? $_GET['IsPage'] : (isset($_POST['IsPage']) ? $_POST['IsPage'] : '');
            $pid     = isset($_GET['pid']) ? $_GET['pid'] : (isset($_POST['pid']) ? $_POST['pid'] : '');
            $isag     = isset($_GET['isag']) ? $_GET['isag'] : (isset($_POST['isag']) ? $_POST['isag'] : '');

            if($arrConfig['SocialConfig']['fb_app_id'] != '' && $arrConfig['SocialConfig']['fb_app_secret'] != '')
            {
                # Facebook
                require_once($arrPhysicalPath['Libs'] . '/facebook/src/Facebook/autoload.php');

                $objFacebook = new Facebook\Facebook(array(
                    'app_id' => $arrConfig['SocialConfig']['fb_app_id'],// Facebook App ID
                    'app_secret' => $arrConfig['SocialConfig']['fb_app_secret'],// Facebook App Secret
                    'default_graph_version' => 'v2.6',
                ));

                $helper = $objFacebook->getRedirectLoginHelper();

                if (!defined('IN_SOCIAL')) {
                    $redirect_uri = get_home_url() . '/third-party-response/?Action=FACEBOOK';
                    $permissions = ['email', 'public_profile'];
                    $fb_loginUrl = $helper->getLoginUrl($redirect_uri, $permissions);

                    $objTmpl->assign(array(
                        'fb_loginUrl' => $fb_loginUrl,
                    ));
                }
            }

            if($arrConfig['SocialConfig']['gml_app_id'] != '' && $arrConfig['SocialConfig']['gml_app_secret'] != '')
            {
                # Google
                require_once($arrPhysicalPath['Libs'] . '/googleplus/src/Google/Client.php');
                require_once($arrPhysicalPath['Libs'] . '/googleplus/src/Google/Service/Oauth2.php');


                $objclient = new Google_Client();
                $objclient->setApplicationName($_SERVER['HTTP_HOST']); // Set your application name
                $objclient->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile')); // set scope during user login
                $objclient->setClientId($arrConfig['SocialConfig']['gml_app_id']); // paste the client id which you get from google API Console
                $objclient->setClientSecret($arrConfig['SocialConfig']['gml_app_secret']); // set the client secret
                $url = $objclient->setRedirectUri(get_home_url() . '/third-party-response/?Action=GOOGLE'); // paste the redirect URI where you given in APi Console. You will get the Access Token here during login success

                $objoauth2 = new Google_Service_Oauth2($objclient);

                $authUrl = $objclient->createAuthUrl();

                $objTmpl->assign(array(
                    'authUrl' => $authUrl,
                ));
            }

            # Fetch diffrent items from DB
			$objTmpl->assign(array(
                'mlsNum'            =>  $mlsNum,
                'ReqType'           =>  $ReqType,
                'IsPage'            =>  $IsPage,
                'arrYesNo'          =>  StaticArray::arrYesNo(),
                'site_url'          =>  get_home_url(),
                'arrConfig'         => $arrConfig,
			));

            if($Action == 'member-login')
            {
                echo $objTmpl->fetch('sign-in.tpl');
                exit(0);

            }
	        elseif($Action == 'member-register')
	        {
		        echo $objTmpl->fetch('sign-up.tpl');
		        exit(0);

	        }
            elseif($Action == 'forgot-password')
            {
	            echo $objTmpl->fetch('forgot-password.tpl');
	            exit(0);

            }
            elseif($Action == 'SaveSearch')
            {
                $objAPI = IDXAPI::getInstance();
                if(isset($pid) && $pid != '')
                {
                    if(isset($_POST['isag']) && $_POST['isag'] == true){

                        $predefined = LPTAgentPredefined::getInstance()->getInfoById($_POST['pid']);
                        $search_crieteria = unserialize($predefined['psearch_criteria']);

                    }else{

                        $predefined = $objAPI->getPredefinedSearchById($pid);
                        $search_crieteria = unserialize($predefined['psearch_criteria']);
                    }

                    $arr_scriteria = Utility::GetSearchParamAndURL('', $search_crieteria);
                    $url = $_SERVER['HTTP_REFERER'];
                }
                else{
                    $url = $_SERVER['HTTP_REFERER'];
                    $values = parse_url($url);
                    $url = urldecode($values['query']);
                    $arr_scriteria = Utility::GetSearchParamAndURL($url, false);
                }

                $objTmpl->assign(array(
                    'arrSearchParams'	=>	$arr_scriteria['sparam'],
                    'surl'              =>  $url,
                    'currency'      =>  '$',
                    'arr_email_notification'      =>  StaticArray::Email_Notification(),
                    'arrWaterfrontDesc'	    =>	StaticArray::arrWaterfrontDesc(),
                    'arrSecuritySafety'	    =>	StaticArray::arrSecuritySafety(),
                ));

                echo $objTmpl->fetch('save-search.tpl');
                exit(0);

            }

	        $content ='';
            return $content;
        }
    }
}
?>