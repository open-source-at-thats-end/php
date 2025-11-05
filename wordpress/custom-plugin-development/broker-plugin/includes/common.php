<?php

define('IN_SECURE',	true);

# Store start time
global $t_start;
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_start = $mtime;

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE & ~E_WARNING);
global $physical_path, $virtual_path, $config, $asset;

$physical_path	= array();
$virtual_path	= array();
$config 		= array();

#=============================================================================================================================
#	Define site state and set site root
#-----------------------------------------------------------------------------------------------------------------------------
# Set the server name
$config['Server_Name'] = strtoupper($_SERVER['SERVER_NAME']);

/*define("INSTALL_DIR", '..');

$physical_path['Site_Root']		=	INSTALL_DIR;
$virtual_path['Site_Root']		=	'';*/
//echo '<pre>';print_r($virtual_path);exit();
if(!defined("IN_CRON")) {

    if(defined("IN_ADMIN") || defined("IN_API"))
        define("INSTALL_DIR", '..');
    else
        define("INSTALL_DIR", '.');

    $physical_path['Site_Root']		=	INSTALL_DIR;
    $virtual_path['Site_Root']		=	'';
}
else
{
    define("INSTALL_DIR", '');

    $physical_path['Site_Root']		=	rtrim($_SERVER['DOCUMENT_ROOT']. INSTALL_DIR, "/");
    $virtual_path['Site_Root']		=	INSTALL_DIR;
}


$virtual_path['Host_Url']		=	'https://'. $_SERVER['HTTP_HOST'];

$urlPart                            =   explode(".", $_SERVER['HTTP_HOST']);

if(strpos($_SERVER['HTTP_HOST'], 'project') !== false)
{
    $_SERVER['NON_WWW_HTTP_HOST']	=    $_SERVER['HTTP_HOST'];

    $virtual_path['Static_Url']		=	'http://'. $_SERVER['NON_WWW_HTTP_HOST'];
    $virtual_path['Assets_Url']		=	'http://'. $_SERVER['NON_WWW_HTTP_HOST'];
}
else
{

    $_SERVER['NON_WWW_HTTP_HOST']	= $_SERVER['HTTP_HOST'];
    $virtual_path['Static_Url']		=	'https://'. $_SERVER['NON_WWW_HTTP_HOST'];
    $virtual_path['Assets_Url']		=	'https://'. $_SERVER['NON_WWW_HTTP_HOST'];
}

# Email template
$physical_path['EmailTemplate']		=	$physical_path['Site_Root']. '/email_templates';
$virtual_path['EmailTemplate']		=	$virtual_path['Site_Root']. '/email_templates';

#=============================================================================================================================
#	Including required configuration
#-----------------------------------------------------------------------------------------------------------------------------
$physical_path['Site_Include']	=	$physical_path['Site_Root']. '/includes';

/*include($physical_path['Site_Include']. '/config.php');
include($physical_path['Site_Include']. '/constants.php');
include($physical_path['Site_Include']. '/static_data.php');*/

$physical_path['Libs']	=	$physical_path['Site_Root']. '/libs';

# Api Path
/*$physical_path['API_Path']	=	$physical_path['Site_Root']. '/apis';

include($physical_path['Libs']. '/mysqli5.php');
include($physical_path['Libs']. '/thumbnail.php');
include($physical_path['Libs']. '/pdo-2.1.php');

include($physical_path['Libs']. '/smarty-3.1.30/libs/OE_Smarty.php');
st::$obj = new st();

//st::$obj = new Smarty();

st::$obj->debugging 	= DEBUG;

# Define page layout
st::$obj->template_dir 	= array($physical_path['Templates_Root'], $physical_path['EmailTemplate']);
st::$obj->compile_dir 	= $physical_path['Site_Root']. '/templates_c';*/

#=============================================================================================================================
#	File upload directory
#-----------------------------------------------------------------------------------------------------------------------------
$physical_path['Upload']	=	$physical_path['Site_Root']. '/upload';
//$virtual_path['Upload']		=	$virtual_path['Site_Root']. '/upload';

#=============================================================================================================================
#	Get the basic data access
#-----------------------------------------------------------------------------------------------------------------------------
$physical_path['DB_Access']		=	$physical_path['Site_Root']. '/db_access';
/*spl_autoload_register('db_access');
function db_access($class)
{
	global $physical_path;
	$path = $physical_path['DB_Access']. '/'.$class.'.php';

	if(file_exists($path)){require_once($path);}
}
if(isset($_POST['type']) && isset($_POST['cmd']) && $_POST['type'] == 'pic' && $_POST['cmd'] == 'property')
{

}
else
{

    //require($physical_path['DB_Access']. '/Utility.php');

    # Initial the required object

    # Make the database connection
    #-----------------------------------------------------------------------------------------------------------------------------
    global $db;

    $db = '';

	if(defined("IN_CRON"))
	{
		$db = new DB_Sql($config['DB_Host'], $config['DB_Name'], $config['DB_Cron_User'], $config['DB_Cron_Passwd'], false);
	}
	else
	{
		$db = new DB_Sql($config['DB_Host'], $config['DB_Name'], $config['DB_User'], $config['DB_Passwd'], false);
	}

    if(!$db->link_id())
    {
        die("Could not connect to the database");
    }

    $db->query("SET CHARACTER SET UTF8");
    $db->query("SET collation_connection = utf8_general_ci");
    /*global $Utility;
    $Utility = new Utility();*/

//}
?>