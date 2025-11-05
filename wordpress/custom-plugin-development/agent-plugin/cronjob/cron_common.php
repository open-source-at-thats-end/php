<?php
# set server path
$server = '';
exec("uname -n", $server);
//print 'uname: '.$server[0].' -- ';exit;
switch(strtolower(@$server[0]))
{
	/*case 'server.realstoria.com':
		$_SERVER['SERVER_NAME']		=	'realstoria.com';
		$_SERVER['HTTP_HOST'] 		=	'realstoria.com';
		break;

	case 'biz169.inmotionhosting.com':
	case 'biz170.inmotionhosting.com':
        $_SERVER['SERVER_NAME']		=	'realstoria.oequal.com';
		$_SERVER['HTTP_HOST'] 		=	'realstoria.oequal.com';
        break;*/

	default:
        $_SERVER['SERVER_NAME'] = 'CustomWpPluginagent.project';
        $_SERVER['HTTP_HOST']   = 'CustomWpPluginagent.project:7777';
        $_SERVER["SERVER_ADDR"] = '127.0.0.1';
		/*$_SERVER['SERVER_NAME']		=	'CustomWpPlugin.thatsend.dev';
		$_SERVER['HTTP_HOST'] 		=	'CustomWpPlugin.thatsend.dev';*/
		break;
}

$_SERVER['DOCUMENT_ROOT'] 	= dirname(dirname(__FILE__));

//print_r($_SERVER);exit;

define("INSTALL_DIR", '');
?>