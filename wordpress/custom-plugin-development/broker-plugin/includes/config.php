<?php
# Check for hacking attempt
if ( !defined('IN_SECURE') )
{
    die("Hacking attempt");
}

$config['Table_Prefix']			= '';
$config['Folder_Perms'] 		= decoct('0765');
$config['File_Perms'] 			= decoct('0744');
$config['picDefault'] 			= 'default.jpg';

switch($config['Server_Name'])
{
    case "LOOPT-API.PROJECT":
        $config['DB_Host']      = 'localhost';
        $config['DB_Name']      = 'uskbazgmts';
        $config['DB_User']      = 'uskbazgmts';
        $config['DB_Passwd']    = '4gjhn9pUUq';
        break;
    default:
        /*$config['DB_Host']      = 'localhost';
        $config['DB_Name']      = 'uskbazgmts';
        $config['DB_User']      = 'uskbazgmts';
        $config['DB_Passwd']    = '4gjhn9pUUq';

	    $config['DB_Cron_User']      = 'looptidx_cron_dbuser';
	    $config['DB_Cron_Passwd']    = 'Iz$xh!1}.EX_';*/

        $config['DB_Host']      = 'localhost';
        $config['DB_Name']      = 'bubwqcebhd';
        $config['DB_User']      = 'bubwqcebhd';
        $config['DB_Passwd']    = '2Fcp7jW62w';

        $config['DB_Cron_User']      = 'bubwqcebhd';
        $config['DB_Cron_Passwd']    = '2Fcp7jW62w';
	    /*$config['DB_Cron_User']      = 'uskbazgmts';
	    $config['DB_Cron_Passwd']    = '4gjhn9pUUq';*/
}
?>