<?php
/**
 * @file /includes/global.php
 */

# Store start time
global $t_start;
$mtime      = microtime();
$mtime      = explode(" ",$mtime);
$mtime 	    = $mtime[1] + $mtime[0];
$t_start    = $mtime;

define('IN_SECURE',	true);
if(isset($_POST['XHR']['AJAX']) && $_POST['XHR']['AJAX'] == 'true')
{
	define('IN_AJAX', true);

	if(isset($_SERVER['HTTP_ORIGIN']))
	{
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
	}
}
//ini_set('memory_limit', '1024M');

if(isset($_GET['rs']) || isset($_SESSION['rs']) || (isset($_SERVER['SERVER_PORT']) && strpos($_SERVER['HTTP_HOST'],'.project:'.$_SERVER['SERVER_PORT']) != false))
{
	ini_set('display_errors', 'on');
	//error_reporting(E_ALL);
   // error_reporting(0); //+E_ERROR | E_WARNING | E_PARSE // This will NOT report uninitialized variables
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT ^ E_DEPRECATED);
  //  error_reporting(E_ALL);//& ~E_NOTICE & ~E_STRICT
}
else
{
	ini_set('display_errors', 'off');
	//error_reporting(0);
}

define('ENDUSER_SID_COOKIE',       'REALSTORIASID');
define('ENDUSER_SID_COOKIE_ADMIN', 'REALSTORIARICTEDSID');

if(!defined("IN_CRON") && !defined("IN_ASSETS"))
{
    # Check for IP address fro each request
	if(!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == ''){exit("Unable to identify your request.");}

	$session_name = ENDUSER_SID_COOKIE;

	if(defined('IN_ADMIN'))
		$session_name = ENDUSER_SID_COOKIE_ADMIN;

	ini_set('session.name', $session_name);

	/*session_save_path("/");*/
	# To share session between sub domain
	$tmpServer = explode('.', $_SERVER['SERVER_NAME']);
    ini_set('session.cookie_domain', '.'.$tmpServer[count($tmpServer)-2]. ".". $tmpServer[count($tmpServer)-1]);

	session_start();
	/*session_regenerate_id();*/
}
date_default_timezone_set('America/Chicago');

# Define some basic configuration arrays. This also prevents malicious rewriting of language and otherarray values via URI params
global $config, $physical_path, $virtual_path, $asset, $Debug_info, $msgSuccess, $msgError, $msgWarning, $msgInfo, $css_files, $js_files, $preferences;
$physical_path=array(); $virtual_path=array(); $config=array(); $css_files=array(); $js_files=array();  $preferences=array();

# Set required sub domain
$asset['SUB_DOMAIN_LIST'] = array(
	'STAR'=>'*',    'CDN'=>'cdn',   'MDN'=>'mdn',   'API'=>'api',   'XHR'=>'xhr', 'SECURE'=>'secure',
	'RESPONSE'=>'response','TRACK'=>'track'
);

# Define site state and set site root. Set the server name.
$config['Server_Name']              =   strtoupper($_SERVER['SERVER_NAME']);

if(!defined("IN_CRON"))
{
	if(defined("IN_ADMIN") || defined("IN_API"))
		define("INSTALL_DIR", '..');
	else
		define("INSTALL_DIR", '.');

	$physical_path['Site_Root']		=	INSTALL_DIR;
	$virtual_path['Site_Root']		=	'';
}
else
{
	if(!defined('INSTALL_DIR'))
		define("INSTALL_DIR", '');

	$physical_path['Site_Root']		=	rtrim($_SERVER['DOCUMENT_ROOT']. INSTALL_DIR, "/");
	$virtual_path['Site_Root']		=	INSTALL_DIR;
}

if(defined("IN_CRON"))
{
	$sr=$physical_path['Site_Root'];
	$plorp = substr(strrchr($sr,'/'), 1);
	$physical_path['Server_Root'] = rtrim(substr($sr, 0, - strlen($plorp)),"/");
}
else
{
	$physical_path['Server_Root'] = "../".$physical_path['Site_Root'];
}

$virtual_path['Host_Url']           =	'http://'. $_SERVER['HTTP_HOST'];

$urlPart                            =   explode(".", $_SERVER['HTTP_HOST']);
//$_SERVER['NON_WWW_HTTP_HOST']	    =   $urlPart[count($urlPart)-2].".".$urlPart[count($urlPart)-1];

if(strpos($_SERVER['HTTP_HOST'], 'oequal') !== false)
{
	$_SERVER['NON_WWW_HTTP_HOST']	= $urlPart[count($urlPart)-3].".". $urlPart[count($urlPart)-2].".".$urlPart[count($urlPart)-1];
}
else
{
	$_SERVER['NON_WWW_HTTP_HOST']	= $urlPart[count($urlPart)-2]. ".". $urlPart[count($urlPart)-1];
}
# Main host name so in case of request from sub domain we can get main http host
$virtual_path['Main_Host_Url']           =	'http://'.((strpos($_SERVER['HTTP_HOST'],'.project:'.$_SERVER['SERVER_PORT'])===false && strpos($_SERVER['HTTP_HOST'],'oequal')===false)?'www.':''). $_SERVER['NON_WWW_HTTP_HOST'];
//echo"<pre>";print_r($_SERVER);die;

//$_SERVER['HTTP_HOST'];}
if(strpos($_SERVER['HTTP_HOST'], 'oequal') !== false)
{
	#DEMO SERVER
	foreach($asset['SUB_DOMAIN_LIST'] as $k=>$d)
	{$virtual_path[$k.'_Url'] =	'http://'.$_SERVER['HTTP_HOST'];}
}
else
{
	#LIVE SERVER
	foreach($asset['SUB_DOMAIN_LIST'] as $k=>$d)
	{$virtual_path[$k.'_Url'] =	'http://'.$_SERVER['HTTP_HOST'];}
}
# Including required configuration
$physical_path['Site_Include']      =	$physical_path['Site_Root']. '/includes';

# Set library path
$physical_path['Libs']              =	$physical_path['Site_Root']. '/libs';
$virtual_path['Libs']               =	$virtual_path['CDN_Url'].$virtual_path['Site_Root']. '/libs';

# Define upload folder fake name
define('ENC_V_UP_FOLDER',           preg_replace("/[0-9]/", "", md5('rs-image')));
# Define regular site url
define('REGULAR_SITE_URL',		    'http://'.$_SERVER['NON_WWW_HTTP_HOST']);

# Define rich html editor path
define('EDITOR_ROOT',               $physical_path['Libs']. '/ckeditor/' );
define('EDITOR_URL', 	            $virtual_path['Site_Root']. '/libs/ckeditor/');

# Get the basic data access
$physical_path['DB_Access']         =	$physical_path['Site_Root']. '/db_access';

# cronjob path
$physical_path['Cronjob']           =	$physical_path['Site_Root']. '/cronjob';

# Api Path
$physical_path['API']               =	$physical_path['Site_Root']. '/apis';

# File upload directory
$physical_path['Upload']            =	$physical_path['Site_Root']. '/upload';
$virtual_path['Upload']             =	$virtual_path['Site_Root']. '/upload';
$virtual_path['ENC_Upload']         =	$virtual_path['Site_Root']. '/'.ENC_V_UP_FOLDER;

$physical_path['Temp_Upload']       =   $physical_path['Upload'].'/temp';
$virtual_path['Temp_Upload']        =   $virtual_path['Upload'].'/temp';
$virtual_path['ENC_Temp_Upload']    =	$virtual_path['ENC_Upload'].'/temp';

# Define basic path
if(defined("IN_ADMIN"))
{
	$physical_path['User_Root']		=	$physical_path['Site_Root']. '/admin-zone';
	$virtual_path['User_Root']		=	$virtual_path['Site_Root']. '/admin-zone';
}
else
{
	$physical_path['User_Root']		=	$physical_path['Site_Root'];
	$virtual_path['User_Root']		=	$virtual_path['Site_Root'];
}

# Define template related paths
$physical_path['Templates_Root']	=	$physical_path['User_Root']. '/templates';
$virtual_path['Templates_Root']		=	$virtual_path['User_Root'].  '/templates';

$physical_path['TPL_css']           =	$physical_path['Templates_Root']. '/css';
$virtual_path['TPL_css']            =	$virtual_path['CDN_Url'].$virtual_path['Templates_Root']. '/css';
$virtual_path['TPL_js']             =	$virtual_path['CDN_Url'].$virtual_path['Templates_Root']. '/js';

$physical_path['TPL_images']        =	$physical_path['Templates_Root']. '/images';
$virtual_path['TPL_images']         =	$virtual_path['MDN_Url'].$virtual_path['Templates_Root']. '/images';

# Email template
$physical_path['EmailTemplate']		=	$physical_path['Site_Root']. '/email_templates';
$virtual_path['EmailTemplate']		=	$virtual_path['Site_Root']. '/email_templates';

spl_autoload_register('db_access');
function db_access($class)
{
	global $physical_path;
	$path = $physical_path['DB_Access']. '/'.$class.'.php';

	if(file_exists($path)){require_once($path);}
}

# OE_ClientWindow functionality
/*require_once($physical_path['Libs']. '/OE_ClientWindow/cw.php');
cw::$obj = new cw(array('cookie_name'=>'crs_cw'));

# At initial load screen is not detected so set screen size as per assumption afer once screen will be detected it will be more perfect
if(cw::$screen == null)
{
	require_once($physical_path['Libs']. '/Mobile-Detect-2.8.19/OE_Mobile_Detect.php');
	dd::$obj = new dd();

	if(dd::$obj->isMobile() && !dd::$obj->isTablet())
		cw::$screen = CW_S_XS;
	elseif(dd::$obj->isTablet())
		cw::$screen = CW_S_MD;
	else
		cw::$screen = CW_S_XL;

    cw::$obj->SetApproxScreenDimention(cw::$screen);
}*/

//Utility::pre(cw::$obj);
# Include required files
require_once($physical_path['Site_Include']. '/constants.php');
require_once($physical_path['Site_Include']. '/static_data.php');
require_once($physical_path['Site_Include']. '/config.php');
require_once($physical_path['Site_Include']. '/sys_config.php');
//require_once($physical_path['Libs']. '/Ocrypt.php');
require_once($physical_path['Libs']. '/pdo-2.1.php');
require_once($physical_path['Libs']. '/mysqli5.php');
require_once($physical_path['Libs']. '/thumbnail.php');

if(defined("IN_API") && isset($_POST['type']) && isset($_POST['cmd']) && $_POST['type'] == 'pic' && $_POST['cmd'] == 'property')
{

}
else
{
    global $db;
    $db = '';
    # Make the OE database connection
    $db = new DB_Sql($config[DB_HOST],$config[DB_NAME],$config[DB_USER],$config[DB_PASSWD],false);

    if(!$db->link_id())
    {
    	exit("Could not connect to the database");
    }
    //$db->query("SET NAMES 'utf8'");
    //$db->query("SET CHARACTER SET UTF8");
    //$Debug_info = $db->Debug_info;
    # Make the OE database connection
    DBc::$obj = new DBc($config[DB_HOST],$config[DB_USER],$config[DB_PASSWD],$config[DB_NAME],$config[DB_DRIVER],$config[DB_CHARSET],$config[DB_PORT]);
    if(!isset($config['OnLocal'])){DBc::$obj->Halt_On_Error('No');}

    if(!isset($config['OnLocal'])){$db->Halt_On_Error('no');}


}

/*foreach($asset['SUB_DOMAIN_LIST'] as $k=>$d)
    {$virtual_path['Data_'.$k.'_Url'] =	'http://'.$d.'.'. $config['data_domain'].":".$_SERVER["SERVER_PORT"];}*/

# Initiate user and start session

?>