<?php
define('BASE36_TOKEN', '9');
#=============================================================================================================================
#	File Name	:	Utility.php
#=============================================================================================================================
class Utility
{
    public static $Instance;

	public static function obj()
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self();

		return self::$Instance;
	}
    	#=========================================================================================================================
	#	Function Name	:   Utility
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
		// Show additional action for master admin
		$_SESSION['SHOW_ADMIN_SETTING']	=	isset($_GET['setadmin'])?$_GET['setadmin']:(isset($_SESSION['SHOW_ADMIN_SETTING']) ? $_SESSION['SHOW_ADMIN_SETTING'] : '');

		# Enable/Disable Responce Time
		#---------------------------------------------------------------------------------------------------------------------
		$_SESSION['SHOW_RESP_TIME']	=	isset($_GET['resp'])?$_GET['resp']:(isset($_SESSION['SHOW_RESP_TIME']) ? $_SESSION['SHOW_RESP_TIME'] : '');

		# Enable/Disable Responce Time
		#---------------------------------------------------------------------------------------------------------------------
		$_SESSION['SHOW_QUERY']	=	isset($_GET['query'])?$_GET['query']:(isset($_SESSION['SHOW_QUERY']) ? $_SESSION['SHOW_QUERY'] : 0);
	}

	#=========================================================================================================================
	#	Function Name	:   encode
	#-------------------------------------------------------------------------------------------------------------------------
	static function encode($str)
	{
		return urlencode(base64_encode(BASE64_TOKEN. $str));
	}

	#=========================================================================================================================
	#	Function Name	:   decode
	#-------------------------------------------------------------------------------------------------------------------------
	static function decode($str)
	{
		return str_replace(BASE64_TOKEN, '', base64_decode(urldecode($str)));
	}

	#=========================================================================================================================
	#	Function Name	:   encode10To36
	#-------------------------------------------------------------------------------------------------------------------------
	static function encode10To36($num)
	{
		if(!isset($num)) return false;

		$num = BASE36_TOKEN. str_pad($num, 15, '0', STR_PAD_LEFT);
		return strtoupper(base_convert($num, 10, 36));
	}

	#=========================================================================================================================
	#	Function Name	:   decode36To10
	#-------------------------------------------------------------------------------------------------------------------------
	static function decode36To10($str)
	{
		if(empty($str)) return false;

		$num = base_convert(strtoupper($str), 36, 10);
		$num = intval(substr($num, strlen(BASE36_TOKEN)));
		return $num;
	}

	#====================================================================================================
	#	Function Name		:	copyDirectory
	#	Purpose				:	Copy the directory to specified location
	#	Parameters			:	source, dest
	#	Return				:	Return the record set of config
	#----------------------------------------------------------------------------------------------------
	public function copyDirectory($source,	$dest)
	{
		if ($dir = opendir($source))
		{
			@mkdir($dest);
			@chmod($dest, 0777);
			while ($file = readdir($dir))
			{
				if (($file != ".")&&($file != ".."))
				{
					$tempSource = $source."/".$file;
					$tempDest 	= $dest."/".$file;
					if (is_dir($tempSource))
					{
						$ret = $this->copyDirectory($tempSource, $tempDest);
					}
					else
					{
						@copy($tempSource, $tempDest);
						@chmod($tempDest, 0777);
					}
				}
			}
		}
		else
		{
			return 0;
		}
		return 1;
	}

	#=========================================================================================================================
	#	Function Name	:   deleteDirectory
	#	Purpose			:	Delete client plugin folder
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
	public function deleteDirectory($file)
	{
		@chmod($file,0777);

        if (is_dir($file))
		{
		    $handle = opendir($file);
			while($filename = readdir($handle))
			{
				if ($filename != "." && $filename != "..")
				{
					if(is_dir($file. $filename))
					{
						$this->deleteDirectory($file. $filename. "/");
						//rmdir($file. $filename);
					}
					else
					{
						@unlink($file."/".$filename);
					}
				}
			}
			closedir($handle);
			@rmdir($file);
		}
		else
		{
            @unlink($file);
		}
	}

	#=========================================================================================================================
	#	Function Name	:   readDirectory
	#	Purpose			:	read directory for folders and files
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
	public function readDirectory($file)
	{
		$dir = array();

		if (is_dir($file))
		{
			$handle = opendir($file);
			while($filename = readdir($handle))
			{
				if ($filename != "." && $filename != "..")
				{
					if(is_dir($file. $filename))
					{
						$dir[] = $filename;
						//$this->readDirectory($file. $filename. "/");
					}
				}
			}
			closedir($handle);
		}

		return $dir;
	}

	#====================================================================================================
	#	Function Name		:	keyToDirectory
	#	Purpose				:	Copy the directory to specified location
	#	Parameters			:	source, dest
	#	Return				:	Return the record set of config
	#----------------------------------------------------------------------------------------------------
	public function keyToDirectory(&$arr, &$val, $index=0) {

	//	$narr = array();

		if(count($arr) > $index)
		{
			$narr[$arr[$index]]['data'] = $this->keyToDirectory($arr, $val, $index+1);
			$narr[$arr[$index]]['size'] += $val['size'];
		}
		else
		{
			$narr = $val;
		}

		return $narr;
	}
	#=========================================================================================================================
	#	Function Name	:   RemoveDirectoryContents
	#	Purpose			:	read directory files and remove them
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
	public function RemoveDirectoryContents($dir, $excludeFiles='')
	{
		if (is_dir($dir))
		{
			$handle = opendir($dir);

			while (($file = readdir($handle)) !== false)
			{
				if(is_array($excludeFiles))
				{
					if(!in_array($file, $excludeFiles))
						@unlink($dir.'/'.$file);
				}
				else
					@unlink($dir.'/'.$file);
			}

			closedir($handle);
		}
	}
	#=========================================================================================================================
	#	Function Name	:   generateRandStr
	#   Purpose         :   Its Generate the random string
	#-------------------------------------------------------------------------------------------------------------------------
	public function generateRandStr($length)
	{
		$randstr = "";
		for($i=0; $i<$length; $i++)
		{
			$randnum = mt_rand(0,61);
			if($randnum < 10)
			{
				$randstr .= chr($randnum+48);
			}
			else if($randnum < 36)
			{
				$randstr .= chr($randnum+55);
			}
			else
			{
				$randstr .= chr($randnum+61);
			}
		}
		return $randstr;
	}

	#=========================================================================================================================
	#	Function Name	:   generateRandStr
	#   Purpose         :   Its Generate the random string
	#-------------------------------------------------------------------------------------------------------------------------
	public function generatePassword($keywordArr)
	{
		global $asset;

		$keywordArr = array_merge($keywordArr,$asset['OL_password_keyword']);
		$rand_keys 	= array_rand($keywordArr);
		$rand_digit = mt_rand(10, 99);
		$keyword    = $keywordArr[$rand_keys];
		$randstr    = $keyword.$rand_digit;
		return $randstr;
	}
	#=========================================================================================================================
	#	Function Name	:   generateListingAttributes
	#	Purpose			:	Build useful value for listing page
	#	Return			:	Array of values
	#-------------------------------------------------------------------------------------------------------------------------
	static function generateListingAttributes($Record, $arrMetaData='')
	{
		global $config;

        if(!$Record)
			return;

		$rsAttr = array();

		/* Define address */
		//$rsAttr['SFPrefix'] 	= '';
		$rsAttr['Street'] 		= '';
		$rsAttr['AddressFull'] 	= '';
		$rsAttr['AddressSmall'] = '';
		$rsAttr['SFUrl'] 		= '';
		$street = '';

		// Sale Or Rent ?
		//$type = ($Record['PropertyType'] == 'Residential Lease') ? 'Rent' : 'Sale';
		$type = (isset($Record['Category']) && $Record['Category'] == 'For Lease') ? 'Rent' : 'Sale';

		//if ($Record['CityName'])
			//$rsAttr['SFPrefix'] .= "Home for $type in ".ucwords(strtolower($Record['CityName']));
        if(isset($Record['DisplayAddress']) && $Record['DisplayAddress'] == 'Y')
		{
			if( isset($Record['Address']) && $Record['Address'] != '')
			{
				$street = $Record['Address']." ";
			}
			else
			{
                if (isset($Record['UnitNo']))
				{
					$street .= trim($Record['UnitNo'], "#")." ";//(strpos($Record['UnitNo'], '#') === false ? '#' : '').$Record['UnitNo']." ";
				}
				if (isset($Record['StreetNumber']))
					$street .= trim($Record['StreetNumber'])." ";
                if (isset($Record['StreetDirection']))
					$street .= trim($Record['StreetDirection'])." ";
				if(isset($Record['StreetDirPrefix']))
                    $street .= trim($Record['StreetDirPrefix'])." ";
				if (isset($Record['StreetName']))
					$street .= $Record['StreetName']." ";
				if (isset($Record['StreetSuffix']))
					$street .= trim($Record['StreetSuffix'])." ";
                if(isset($Record['StreetDirSuffix']))
                    $street .= trim($Record['StreetDirSuffix'])." ";
                if(isset($Record['UnitNo_2']) && $Record['UnitNo_2'] > 0)
                    $street .= "Unit ".trim($Record['UnitNo_2'])." ";
            }


			$street = ucwords(strtolower($street));

			$rsAttr['Street'] = str_replace(", ", "", $street);
		}
		$ads = '';
		if (isset($Record['UnitNo']))
		{
			$ads .= trim($Record['UnitNo'], "#")." ";//(strpos($Record['UnitNo'], '#') === false ? '#' : '').$Record['UnitNo']." ";
		}
		if (isset($Record['StreetNumber']))
			$ads .= trim($Record['StreetNumber'])." ";
		if (isset($Record['StreetDirection']))
			$ads .= trim($Record['StreetDirection'])." ";
		if(isset($Record['StreetDirPrefix']))
			$ads .= trim($Record['StreetDirPrefix'])." ";
		if (isset($Record['StreetName']))
			$ads .= $Record['StreetName']." ";
		if (isset($Record['StreetSuffix']))
			$ads .= trim($Record['StreetSuffix'])." ";
		if(isset($Record['StreetDirSuffix']))
			$ads .= trim($Record['StreetDirSuffix'])." ";
		if(isset($Record['UnitNo_2']) && $Record['UnitNo_2'] > 0)
			$ads .= "Unit ".trim($Record['UnitNo_2'])." ";

		$rsAttr['AddressSort'] = $ads;
		$rsAttr['AddressFull'] = $street;

		if (isset($Record['CityName']))
			$rsAttr['AddressFull'] .= $Record['CityName'].", ";

		$rsAttr['AddressFull'] = ucwords(strtolower($rsAttr['AddressFull']));

        if(isset($Record['State']))
		$rsAttr['AddressFull'] .= $Record['State'];

		if (isset($Record['ZipCode']))
			$rsAttr['AddressFull'] .= " ".$Record['ZipCode'];

		//$rsAttr['AddressSmall'] = $street;


		if(isset($Record['DisplayAddress']) && $Record['DisplayAddress'] == 'Y')
		{
			$rsAttr['AddressSmall'] = $street;
		}
        elseif(isset($Record['DisplayAddress']) && $Record['DisplayAddress'] == 'N' && $street == '')
        {
            $rsAttr['AddressSmall'] = 'Address Not Available';
        }
		else
		{
			$rsAttr['AddressSmall'] = $rsAttr['AddressFull'];
		}

        /* Search Friend Url */
		$urlPrefix = '';

		if (isset($Record['CityName']))
			$urlPrefix .= $Record['CityName']." ";

		$rsAttr['SFUrl'] = Utility::formatListingUrl($Record['formatURL'], $Record);

        return $rsAttr;
	}
	public function formatListingUrl($format, $arrRecord)
    {
        global $asset;

        $arrFields = $asset['arrListingField'];//explode(',', $arrConfig['Fields']);

        $slug_1 = $format['slug-1'];
        $slug_2 = $format['slug-2'];

        foreach($arrFields as $key=>$fieldName) {
            $fieldName = trim($fieldName);
            $slug_1 = preg_replace("/\b".$fieldName."\b/", $arrRecord[$fieldName], $slug_1);
            $slug_2 = preg_replace("/\b".$fieldName."\b/", $arrRecord[$fieldName], $slug_2);
        }

        $slug_1 = trim(Utility::buildSefString(trim($slug_1)), "_-");
        $slug_2 = trim(Utility::buildSefString(trim($slug_2)), "_-");	/* Make alph numerical string */

        $strReturn = strtolower($slug_1 ."/". $slug_2 . "-mls-" . $arrRecord['ListingID_MLS'])."/";
        return $strReturn;
    }
	#=========================================================================================================================
	#	Function Name	:   generateListingAttributesForMobile
	#	Purpose			:	Build useful value for listing page
	#	Return			:	Array of values
	#-------------------------------------------------------------------------------------------------------------------------
	public function generateListingAttributesForMobile($Record)
	{
		global $config;

		if(!$Record)
			return;

		$rsAttr = array();

		/* Define address */
		$rsAttr['Street'] 		= '';
		$rsAttr['AddressFull'] 	= '';
		$rsAttr['AddressSmall'] = '';
		$rsAttr['SFUrl'] 		= '';
		$street = '';

		//$type = ($Record['Category'] == 'For Lease') ? 'Rent' : 'Sale';

		if($Record['DisplayAddress'] == 'Y')
		{
			if($Record['Address'] != '')
			{
				$street = $Record['Address']." ";
			}
			else
			{
				if ($Record['StreetDirection'])
					$street .= trim($Record['StreetDirection'])." ";
				if ($Record['StreetNumber'])
					$street .= trim($Record['StreetNumber'])." ";
				if ($Record['StreetName'])
					$street .= $Record['StreetName']." ";
				if ($Record['StreetSuffix'])
					$street .= trim($Record['StreetSuffix'])." ";
				if ($Record['UnitNo'])
				{
					$street .= (strpos($Record['UnitNo'], '#') === false ? '#' : '').$Record['UnitNo']." ";
				}
			}

			$street = ucwords(strtolower($street));

			$rsAttr['Street'] = str_replace(", ", "", $street);
		}

		$rsAttr['AddressFull'] = $street;

		if ($Record['CityName'])
			$rsAttr['AddressFull'] .= $Record['CityName'].", ";

		$rsAttr['AddressFull'] = ucwords(strtolower($rsAttr['AddressFull']));

		$rsAttr['AddressFull'] .= $Record['State'];

		if ($Record['ZipCode'])
			$rsAttr['AddressFull'] .= " - ".$Record['ZipCode'];

		//$rsAttr['AddressSmall'] = $street;


		if($Record['DisplayAddress'] == 'Y')
		{
			$rsAttr['AddressSmall'] = $street;
		}
		else
		{
			$rsAttr['AddressSmall'] = $rsAttr['AddressFull'];
		}

		/* Search Friend Url */
		$urlPrefix = '';

		if ($Record['CityName'])
			$urlPrefix .= $Record['CityName']." ";

		$urlPrefix .= ' real estate ';

		$urlPrefix = Utility::buildSefString(trim($urlPrefix));

		$rsAttr['SFUrl'] = $rsAttr['AddressFull'];

		$rsAttr['SFUrl'] .= " MLS ";;

		$rsAttr['SFUrl'] .= $Record['MLS_NUM']. " ". $Record['MLSP_ID'];

		$rsAttr['SFUrl'] = $urlPrefix. "/". Utility::buildSefString(trim($rsAttr['SFUrl']));

		return $rsAttr;
	}
	#=========================================================================================================================
	#	Function Name	:   getSEFUrl
	#	Purpose			:	Create url for differnet links used under site map
	#	Used			:
	#-------------------------------------------------------------------------------------------------------------------------
	public function getSEFUrl2($linkType, $title, $homeType, $title2='', $mobileVersion=false)
	{
		$strUrl = 'sc/';

		if(in_array($linkType, array('area','subdivision')))
			$strUrl .= $linkType.'/';

		$strUrl .= Utility::buildSefString($title);

		if($title2)
			$strUrl .= '/'. $title2;

		$strUrl .= '-'. $homeType;

		if(!$mobileVersion)
			$strUrl .= '.html';

		return $strUrl;
	}
	#=========================================================================================================================
	#	Function Name	:   getSEFUrl
	#	Purpose			:	Create url for differnet links used under site map
	#	Used			:
	#-------------------------------------------------------------------------------------------------------------------------
	static function getSEFUrl($state, $homeType, $city='', $zipcode='', $suburb='')
	{
		$strUrl = Utility::buildSefString($state);

		//if(in_array($linkType, array('area','subdivision')))
			//$strUrl .= $linkType.'/';

		//$strUrl .= Utility::buildSefString($title);
		// Replace (),/. with ~, so it will help to when fetch rows from db by using like
		$city = str_replace(array('(',')','/','.'), '~', $city);

		if($city)
			$strUrl .= '/'.Utility::buildSefString($city);

		if($zipcode)
			$strUrl .= '/'.$zipcode;

		if($suburb)
		{
			$suburb = str_replace(array('(',')','/','.'), '~', $suburb);
			$strUrl .= '/'.Utility::buildSefString($suburb);
		}

		//$strUrl .= '-'.$homeType.'.html';
		$strUrl .= '/'.$homeType.'/';

		return $strUrl;
	}
	#=========================================================================================================================
	#	Function Name		:	buildSefUrl
	#	Purpose				:	Get Unique filename
	#	Return				:	Unique filename based on time
	#-------------------------------------------------------------------------------------------------------------------------
	static function buildSefString($str)
	{
		$str = str_replace("'",					"-",		$str); 	//replace ' with -
		$str = str_replace('"',					"-",		$str); 	//replace " with -
		$str = preg_replace("/[^a-zA-Z0-9_-~]/",	"-", 	$str); 	//convert non alphanumeric and non - _ to -
		$str = preg_replace ( "/-+/" , 			"-" , 	$str ); //convert multiple dashes to a single dash
		$str = preg_replace ( "/ +/" , 			" " , 	$str ); //convert multiple spaces to a single space
		$str = strtolower($str);

		return $str;
	}
	#=========================================================================================================================
	#	Function Name		:	buildSefString2
	#	Purpose				:	Get SEF String
	#	Return				:	STring
	#-------------------------------------------------------------------------------------------------------------------------
	public function buildSefString2($str)
	{
		$str = str_replace(array('(',')','/','.'), '~', $str);

		$str = Utility::buildSefString($str);

		return $str;
	}
	#=========================================================================================================================
	#	Function Name		:	enableCache
	#	Purpose				:	enable cache parameter and generate cached output if anything there
	#-------------------------------------------------------------------------------------------------------------------------
	public static function enableCache($CacheKey='')
	{
		global $cacheId, $config, $asset, $physical_path, $objCart;

        return true;

		/* Enable cache */
		if($config['site_cache_enable'] == 'Yes' && !AuthUser::obj()->User_Logged && empty($_POST))
		{
			$reqUrlPart = explode("/", $_SERVER['REDIRECT_URL']);
			$reqType = str_replace('.html', '', $reqUrlPart[1]);

			$arrCacheKey = array();
			array_push($arrCacheKey, $_SERVER['REQUEST_URI']);

			# Include Cart Parameters
			if($CacheKey != '')
			{
				array_push($arrCacheKey, $CacheKey);
			}
			/*
			print $reqType;
			print "<pre>";
			print_r($arrCacheKey);
			print "</pre>";
			*/
			$cacheId = md5(serialize($arrCacheKey)). '_'. $reqType;

			# Enable cache for website section
			## Use cache till 05:00:00 AM, so if current hour is below 5 AM, Set lifetime for same date otherwise add one day to curday
			/*$curHour = date('G');
			if($curHour >= 5)
				$cache_lifetime 	= mktime(5,0,0, date('n'), date('j')+1, date('Y'));
			else
				$cache_lifetime 	= mktime(5,0,0, date('n'), date('j'), date('Y'));
			*/

			st::$obj->caching 			= 2;	// means we are setting cache expiration time
			st::$obj->cache_lifetime	= 60 * 60 * 1; # 1 hour
			//st::$obj->cache_lifetime	= $cache_lifetime - time();
			st::$obj->cache_dir 		= $physical_path['User_Root']. '/cache';
			//st::$obj->cache_modified_check = true;
			//gzip, deflate

			# If Popup Window
			if(defined('POPUP_WIN'))
			{
				if(st::$obj->isCached('default_popup'. $config['tplEx'], $cacheId))
				{
					st::$obj->display('default_popup'. $config['tplEx'], $cacheId);
					exit(0);
				}
			}
			else
			{
				if(st::$obj->isCached('default_layout'. $config['tplEx'], $cacheId))
				{
					st::$obj->display('default_layout'. $config['tplEx'], $cacheId);
					exit(0);
				}
			}

			/* Let's check for sitemap condition also */
			if(st::$obj->isCached('sitemap_xml'. $config['tplEx'], $cacheId)) {
				/* MUST SET xml header */
				header ("Content-Type:text/xml");
				st::$obj->display('sitemap_xml'. $config['tplEx'], $cacheId);
				exit(0);
			}
		}
	}

	#=========================================================================================================================
	#	Function Name	:   Breadcrumbs
	#	Purpose			:	Build link navigation path
	#	Return			:	Return navigation path
	#-------------------------------------------------------------------------------------------------------------------------
    public function Breadcrumbs()
    {
		global $Sysuser_Privileges;

		$reqUrl = $_SERVER['REQUEST_URI'];

		/* Is home page? */
		if(strpos($reqUrl, "index.php") !== false) return '';

		$str = '<a href="index.php">Home</a> &raquo; ';

		$str .= $this->ChildLink($Sysuser_Privileges, $reqUrl);

		return $str;
	}

	#=========================================================================================================================
	#	Function Name	:   ChildLink
	#	Purpose			:	Build link navigation path
	#	Return			:	Return navigation path
	#-------------------------------------------------------------------------------------------------------------------------
    public function ChildLink($arrPrivileges, $reqUrl)
    {
		$str = '';

		/* Loop through each option */
		foreach($arrPrivileges as $key => $menu) {

			if(!empty($menu[LINK]) && strpos($reqUrl, $menu[LINK]) !== false) {
				return '<a href="'. $menu[LINK]. '" >'. $menu[TITLE]. '</a>';
			} elseif(isset($menu[SUBOPTION]) && is_array($menu[SUBOPTION])) {
				$str = $this->ChildLink($menu[SUBOPTION], $reqUrl);
			}

			if(!empty($str)) {
				return (!empty($menu[LINK]) ? '<a href="'. $menu[LINK]. '" >'. $menu[TITLE]. '</a>' : $menu[TITLE]). ' &raquo; ' . $str;
			}
		}
	}

	#=========================================================================================================================
	#	Function Name	:   IsBlockedEmail
	#	Purpose			:	Check given email address is blocked by admin or not
	#	Return			:	Return true or false
	#-------------------------------------------------------------------------------------------------------------------------
    public function IsBlockedEmail($email_address)
    {
		global $config;

        if(!empty($config['blocked_email']))
		{
			$arrBlockedEmail = preg_split('/\r\n|[\r\n]/', $config['blocked_email']);//explode('\r\n', $config['blocked_email']);

            if(in_array($email_address, $arrBlockedEmail))
				return true;
			else
				return false;
		}
        return false;
	}
	#=========================================================================================================================
	#	Function Name	:   IsValidInputs
	#	Purpose			:	Check given email address is blocked by admin or not
	#	Return			:	Return true or false
	#-------------------------------------------------------------------------------------------------------------------------
    public  function IsValidInputs($arrInput, $POST)
    {
		global $config;

		if(!is_array($arrInput))
			return false;

		$invalidInput = 0;

		if(is_array($POST))
		{
			foreach($POST as $key	=>	$val)
			{
				if(strip_tags($val) != $val)
					return false;
			}
		}

		foreach($arrInput as $input	=>	$valType)
		{
			for($i=0; $i<count($valType); $i++)
			{
				$POST[$input] = trim($POST[$input]);

				switch($valType[$i])
				{
					case SV_EMPTY:
								// Not Empty
								if(empty($POST[$input]))
								{
									//print SV_EMPTY.' '.$input .' = '. $POST[$input];exit;
									return false;
								}
								break;

					case SV_NAME:
								// Allow alpha numeric with space only
								if(!preg_match("/^[a-zA-Z0-9 ]*$/", $POST[$input]))
								{
									//print SV_NAME.' '.$input .' = '. $POST[$input];exit;
									return false;
									//$invalidInput++;
								}
								break;

					case SV_EMAIL:
								// Email
								if(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$/', $POST[$input]))
								{
									//print SV_EMAIL.' '.$input .' = '. $POST[$input];exit;
									return false;
									//$invalidInput++;
								}
								break;

					case SV_TEXT:
								// Email Not Allowed
								if(preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$/', $POST[$input]))
								{
									//print SV_TEXT.'1';exit;
									return false;
									//$invalidInput++;
								}

								// Reference Site : http://phpcentral.com/208-url-validation-in-php.html
								// Url Not Allowed
								$urlregexFull = "#(?:https?://)?(?:[a-z0-9-]+\.)*((?:[a-z0-9-]+\.)[a-z]+)#i";
								//$urlregexFull = "/^(https?|ftp)\:\/\/([a-z0-9+!*(),;?\&=\$_.-]+(\:[a-z0-9+!*(),;?\&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+\&\$_.-][a-z0-9;:@/\&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$/";

								//$urlregexFull = '%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i';
								$POST[$input] = str_replace($config['site_title'], "", $POST[$input]);

								if(preg_match($urlregexFull, $POST[$input]))
								{
									//print SV_TEXT.'2';exit;
									return false;
									//$invalidInput++;
								}

								break;

					case SV_PHONE:
								// Ex 111-333-444
								if($POST[$input] != '--')
								{
								    $POST[$input] = preg_replace("/[^0-9]/",	"", 	$POST[$input]);
									if(strlen(trim($POST[$input])) !== 10 || !is_numeric($POST[$input]))
								    {
									   //print SV_PHONE.' '.$input .' = '. $POST[$input];exit;
										return false;
										//$invalidInput++;
									}
								}

								break;

					case SV_NUMBER:

								if($POST[$input] != '')
								{
									if(!preg_match("/^[0-9]*$/", $POST[$input]))
									{
										return false;
									}
								}

								break;
				}
			}
		}
		//exit;
		return true;
	}

	static function GenerateBccString()
	{
		global $config, $physical_path;

		$arrMail = array();

		# Set Bcc
		if(!empty($config['email_developer']))
			array_push($arrMail, $config['email_developer']);

		return $arrMail;

	}
	#====================================================================================================
	#	Function Name		:	GenerateEmailToList
	#	Purpose				:	Generate List of Emails/Sign as per logged user/ given market
	#	Return				:	output
	#----------------------------------------------------------------------------------------------------
	static function GenerateEmailToList($arrParams='')
	{
		global $physical_path, $asset, $config, $user, $usrInfo;

		$arrMail = array();

        if(isset($arrParams['agent_code']) || isset($arrParams['agent_safe_url']) || isset($arrParams['agent_id']))
		{
		    $arrParam = array();

            if(!empty($arrParams['agent_code']))
                $arrParam['agent_code'] = $arrParams['agent_code'];

            if(!empty($arrParams['agent_safe_url']))
                $arrParam['agent_safe_url'] = $arrParams['agent_safe_url'];

            if($arrParams['agent_id'] > 0)
                $arrParam['agent_id'] = $arrParams['agent_id'];

			$recAgent = AgentRoster::obj()->getInfoByParam2($arrParam);

            if($recAgent['agent_id'] > 0)
			{
				//array_push($arrMail, $recAgent['agent_first_name'].' '.$recAgent['agent_last_name'].' <'.$recAgent['agent_email'].'>');
				array_push($arrMail,$recAgent['agent_email'].'|'.$recAgent['agent_first_name'].' '.$recAgent['agent_last_name']);
			}
		}

        # No Email set
		if(count($arrMail) == 0)
        {
			$recDefAdmin = AdminMaster::obj()->getDefaultAdminInfo();

			if(!empty($recDefAdmin['admin_email']))
				array_push($arrMail,$recDefAdmin['admin_email'].'|'.$recDefAdmin['admin_firstname'].' '.$recDefAdmin['admin_lastname']);
		}

		return $arrMail;

	}
	public function GetEmailForCC($arrParams='')
	{
		global $config, $physical_path;

		// Fetch Agent if available
		$arrAgentEmail = array();

		if(isset($arrParams['agent_code']) || isset($arrParams['agent_safe_url']))
		{
		    $arrParam = array();

            if(!empty($arrParams['agent_code']))
                $arrParam['agent_code'] = $arrParams['agent_code'];

            if(!empty($arrParams['agent_safe_url']))
                $arrParam['agent_safe_url'] = $arrParams['agent_safe_url'];

			$recAgent = AgentRoster::obj()->getInfoByParam2($arrParam);

			if($recAgent['agent_id'] > 0)
			{
				//array_push($arrAgentEmail, $recAgent['agent_first_name'].' '.$recAgent['agent_last_name'].' <'.$recAgent['agent_email'].'>');
				array_push($arrAgentEmail,$recAgent['agent_email'].'|'.$recAgent['agent_first_name'].' '.$recAgent['agent_last_name']);
			}
		}

		$arrEmail = AdminMaster::obj()->getKeyValueArrayForEmail();

		if(count($arrAgentEmail) > 0)
		{
			$arrEmail = array_merge($arrAgentEmail, $arrEmail);
		}

		//array_push($arrEmail, 'Chris <rgard32@yahoo.com>');

		return $arrEmail;
	}
	#=========================================================================================================================
	#	Function Name	:   ReplaceCustomVariables
	#	Purpose			:	Replace $smarty variavles with actual values given
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	public function ReplaceCustomVariables($recTemplate, $recUser = '')
	{
		global $config, $asset;

		$retArr = array();

		# Replace Tempalte Varibales With Actual Values [Contents/Subject]
		$arrReplaceWith = array($config['site_title'], $config['site_url'], $config['site_domain']);

		// This information passed from Cronjob [send_agent_introduction/ second_login_responder]
		if($recUser['user_first_name'])
		{
			array_push($arrReplaceWith, $recUser['user_first_name']);
			array_push($asset['EMAIL_CONTENT_KEYWORDS'], '{$user_name}');
		}

		// Subject
		$recTemplate['email_subject'] = str_replace($asset['EMAIL_CONTENT_KEYWORDS'], $arrReplaceWith, $recTemplate['email_subject']);

		// Content
		$recTemplate['email_content'] = str_replace($asset['EMAIL_CONTENT_KEYWORDS'], $arrReplaceWith, $recTemplate['email_content']);


		$recTemplate['email_content'] = str_replace('{$Site_Link}', '<a target="_blank" href="'.$config['site_url'].'">'.$config['site_domain'].'</a>', $recTemplate['email_content']);

		// Replcae First Name
		if($recUser['user_first_name'])
			$recTemplate['email_content'] = str_replace('{$user_first_name}', $recUser['user_first_name'], $recTemplate['email_content']);

		// Replcae Last Name
		if($recUser['user_last_name'])
			$recTemplate['email_content'] = str_replace('{$user_last_name}', $recUser['user_last_name'], $recTemplate['email_content']);

		// Replcae Last Name
		if($recUser['user_first_name'])
			$recTemplate['email_content'] = str_replace('{$user_name}', trim(ucwords(strtolower($recUser['user_first_name'].' '.$recUser['user_last_name']))), $recTemplate['email_content']);

		# Set Generated Subject/Contents
		$retArr['Email_Subject'] = $recTemplate['email_subject'];
		$retArr['Email_Content'] = stripslashes($recTemplate['email_content']);

		return $retArr;
	}

	#====================================================================================================
	#	Function Name		:	readUrl
	#	Purpose				:	Its read url through curl
	#	Return				:	output
	#----------------------------------------------------------------------------------------------------
	public static function readUrl($url, $param='', $cookie_file='', $id_password='', $token='')
	{
		global $config, $virtual_path;

		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER,			false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,	true);
		curl_setopt($ch, CURLOPT_USERAGENT,			'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)');
		curl_setopt($ch, CURLOPT_VERBOSE,			false);
		curl_setopt($ch, CURLOPT_NOPROGRESS,		false);
		curl_setopt($ch, CURLOPT_TIMEOUT,			180); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,	false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,	true);

		if($token)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , "Authorization: Bearer ".$token ));
		}

		if($id_password)
		{
			curl_setopt($ch, CURLOPT_USERPWD,  $id_password);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic '. base64_encode($id_password) // <---
			);
		}
		# Post query
		if($param != '')
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		}

		# Cookie ?
		if($cookie_file != '')
		{
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		}

		$result = curl_exec ($ch);

		// close cURL resource, and free up system resources
		$info = curl_getinfo($ch);

		curl_close ($ch);

		$arrRet = array();
		$arrRet['Result'] 	= $result;
		$arrRet['Info'] 	= $info;
		//echo"<pre>";print_r($arrRet);exit;
		return $arrRet;
	}
	#====================================================================================================
	#	Function Name		:	IsMobileBrowser
	#	Purpose				:	Check whether site is running on mobile browser or not
	#	Return				:	status [true/false]
	#----------------------------------------------------------------------------------------------------
	public function IsMobileBrowser()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		$arrMobileUserAgents = array('iPhone','iPad','BlackBerry','Ericsson','LG','MOT',
								 'SonyEricsson','Samsung','Nokia','Panasonic',
								 'Philips','Cellphone','MobilePhone','PDA',
								 'SmartPhone','SymbianOS','Windows CE', 'IEMobile',
								 'Mobile Safari', 'Android');

		for($i=0; $i<count($arrMobileUserAgents); $i++)
		{
			if(strpos($user_agent, $arrMobileUserAgents[$i]) !== false)
			{
				return true;
			}
		}

		return false;
	}
	#====================================================================================================
	#	Function Name		:	getLatLong
	#	Purpose				:	Fetch Lat/Long using google geocoding API
	#	Return				:	lATITUDE & lONGITUDE
	#----------------------------------------------------------------------------------------------------
	public function getLatLong($address)
	{
		global $physical_path, $config;

		include_once($physical_path['Libs']. '/GeoCodeGoogle.php');
		include_once($physical_path['Libs']. '/JSON.php');

		$objGeoGoogle 	= new GeoCodeGoogle($config['google_map_key'], 'curl', $config['goolge_geocode_api_url']);
		$objJSON		= new Services_JSON();

		$geo_info = $objJSON->decode($objGeoGoogle->GetLatLng($address));

		$latitude = 0;
		$longitude = 0;

		//print $geo_info->results[0]->geometry->location->lat;exit;
		if ($geo_info->results[0]->geometry->location->lat)
			$latitude = $geo_info->results[0]->geometry->location->lat;

		if ($geo_info->results[0]->geometry->location->lng)
			$longitude = $geo_info->results[0]->geometry->location->lng;

		$arrRet = array();
		$arrRet['Lat'] = $latitude;
		$arrRet['Long'] = $longitude;

		return $arrRet;
	}
	#====================================================================================================
	#	Function Name		:	getSchoolLinkFromEdu
	#----------------------------------------------------------------------------------------------------
	public function getSchoolLinkFromEdu($CityName, $state)
	{
		global $config;

		$api_url = $config['education_api_service_url']. "?f=gbd&key=".$config['education_api_key']."&sn=sf&v=4&resf=json&city=".str_replace(" ", "+", $CityName)."&state=".$state;

	//	echo $api_url;

		$resp = $this->readUrl($api_url);

		$arrEduInfo = @json_decode($resp['Result']);

		$arr = array();
		$arr['Title'] 		= "See more information on ". $CityName. ", ". $state. " schools from Education.com";
		$arr['Url'] 		= $arrEduInfo->lsc;

		return $arr;
	}

	#====================================================================================================
	#	Function Name		:	genSeoMetaForPredefineSearch
	#	Purpose				:	Build seo parameters
	#	Return				:	array with generated parameters
	#----------------------------------------------------------------------------------------------------
	static function genSeoMetaForPredefineSearch($BrowserTitlePattern, $KeywordsPattern, $DescPattern, $Params)
	{
		$title			= '';
		$keywords		= '';
		$description	= '';

		if(count($Params) > 0)
		{
			foreach($Params as $code => $arrVals)
			{
				if(is_array($arrVals))
					$strVals = implode(", ", $arrVals);
				else
				{
					$strVals = $arrVals;
					$arrVals = array($arrVals);
				}

				if($title != '')
				{
					$BrowserTitlePattern = $title;
					$title	= '';
				}

				$title = str_ireplace("[$code]", $strVals, $BrowserTitlePattern);

				if($keywords != '')
				{
					$KeywordsPattern = $keywords;
					$keywords		= '';
				}

				foreach($arrVals as $key => $val)
				{
					$keywords .= str_ireplace("[$code]", $val, $KeywordsPattern). ", ";
				}

				if($description != '')
				{
					$DescPattern	= $description;
					$description	= '';
				}

				$description = str_ireplace("[$code]", $strVals, $DescPattern);
			}
		}
		else
		{
			$title			= $BrowserTitlePattern;
			$keywords		= $KeywordsPattern;
			$description	= $DescPattern;
		}

		$arrKeywords = explode(",", $keywords);
		array_walk($arrKeywords, "clean_keyword");
		$arrKeywords = array_unique(array_filter($arrKeywords, "strlen"));

		$title 			= preg_replace('/(\[.*\],?)/', '', $title);
		$description 	= preg_replace('/(\[.*\],?)/', '', $description);

		$returnData['browser_title']	= $title;
		$returnData['meta_keyword']		= implode(", ", $arrKeywords);
		$returnData['meta_desc']		= $description;

		return $returnData;
	}
	#====================================================================================================
	#	Function Name		:	getPredefineSearchUrl
	#	Purpose				:
	#	Return				:
	#----------------------------------------------------------------------------------------------------
	static function getPredefineSearchUrl($recSearch)
	{
		return Predefined_Search_Link. Utility::buildSefString($recSearch['psearch_title']). ".html?uid=". Utility::encode10To36($recSearch['psearch_id']);
	}

	#====================================================================================================
	#	Function Name		:	PriceFormat
	#	Purpose				:	Convert given price to its short name display
	# 	comment				: 	Used on wordpress map search
	#	Return				:
	#----------------------------------------------------------------------------------------------------
	public function PriceFormat($nStr)
	{
		if(!is_nan($nStr))
		{
			$tmpNo = '';
			$tmpStr = '';

			if($nStr > 1000000000000)
			{
				$tmpNo =  ($nStr/1000000000000);
				$tmpStr = 'T';
			}
			else if($nStr >= 1000000000)
			{
				$tmpNo =  ($nStr/1000000000);
				$tmpStr = 'B';
			}
			else if($nStr >= 1000000)
			{
				$tmpNo =  ($nStr/1000000);
				$tmpStr = 'M';
			}
			else if($nStr >= 1000)
			{
				$tmpNo = ($nStr/1000);
				$tmpStr = 'K';
			}

			if($tmpNo != '')
			{
				//return number_format($tmpNo, 1).$tmpStr;

				//print $tmpNo.'<br>';

				//if($tmpNo%1 != 0)
				if(is_float($tmpNo))
				{
				/*	$tmpArr = explode('.', $tmpNo);
					if($tmpArr[1] >= 5)
						$tmpNo = ceil($tmpNo);
					else
						$tmpNo = ceil($tmpNo);*/
					$tmpNo = number_format($tmpNo, 1);
					if(strpos($tmpNo, '.0') !== false)
						$tmpNo = substr($tmpNo, 0, strpos($tmpNo, '.0'));

					return $tmpNo.$tmpStr;
				}
				else
					return number_format($tmpNo, 0).$tmpStr;
			}
			else
				return $nStr;
		}
	}
	public function getNextPrevCanonical($pageBaseUrl, $page_size, $page, $total_record)
	{
		$arrCanonical = array();

		if(strpos($pageBaseUrl, '?') === false)
		{
			$pageBaseUrl2 = $pageBaseUrl. '?';
		}
		else
		{
			$pageBaseUrl2 = $pageBaseUrl. '&';
		}

		$page		= intval($page);
		$totalPages = ceil($total_record/$page_size);

		if($page > 0)
		{
			if($page == 1)
			{
				$arrCanonical[] = array('rel' => 'prev', 'url' => $pageBaseUrl);
			}
			else
			{
				$arrCanonical[] = array('rel' => 'prev', 'url' => $pageBaseUrl2. "page=". ($page));
			}
		}

		if(($page+2) <= $totalPages)
		{
			$arrCanonical[] = array('rel' => 'next', 'url' => $pageBaseUrl2. "page=". ($page+2));
		}

		return $arrCanonical;
	}
	#====================================================================================================
	#	Function Name		:	FetchListingAgent
	#	Purpose				:	Feth details if any agent associate with given listing. So we can assigned the lead to that agent
	#	Return				:	array
	#----------------------------------------------------------------------------------------------------
	public function FetchListingAgent($agent_info='')
	{
		global $physical_path, $asset, $config, $user, $usrInfo;

		include_once($physical_path['DB_Access']. '/Admin.php');
		include_once($physical_path['DB_Access'].'/AgentRoster.php');

		$objAdmin 	= new Admin('');
		$objAgent 	= new AgentRoster();

		$arrMail = array();
	}
	#====================================================================================================
	#	Function Name		:	SwitchConfigs
	#	Purpose				:	if Agent is logged in, need to switch some path, so proper links generate related to their domain only
	#	Return				:	array
	#----------------------------------------------------------------------------------------------------
	public function SwitchConfigs($recAgent='')
	{
		global $virtual_path, $usrInfo;

		// Agent logged in & sending emails from admin section [listing-utility], send search alert, price alert
		if(defined('IN_ADMIN') && AuthUser::obj()->User_Perm == AGENT)
		{
			$virtual_path['Host_Url'] = 'http://'.$usrInfo->Profile['agent_domain'];
		}
		elseif(isset($recAgent['Type']) && $recAgent['Type'] == AGENT)
		{
			$virtual_path['Host_Url'] = 'http://'. $recAgent['agent_domain'];
            $Main_Host = 'http://'. $_SERVER['HTTP_HOST'];

            st::$obj->assign(array(
							"Main_Host"				=> 	$Main_Host,
						));
		}
		else
		{
			$virtual_path['Host_Url']		=	'http://'. $_SERVER['HTTP_HOST'];
		}

		st::$obj->assign(array(
							"Host_Url"				=> 	$virtual_path['Host_Url'],
						));
	}
    public static function pre($data, $debug=false)
	{
        echo "<pre>";

        if(is_array($data) || is_object($data))
            print_r($data);
        elseif($debug === true)
            var_dump($data);
        else
            echo $data;

        exit;
    }
	public static function OrderUrlParams(array $param, $init_order=false)
	{
		global $asset;
		$out=array();

		if($init_order == false)
		{
			$intersect = array_keys($param);
			asort($intersect);
		}
		else
			$intersect = array_intersect($init_order, array_keys($param));


		foreach($intersect as $key=>$value)
		{
			$out[$value] = $param[$value];

			if(is_array($out[$value]) && count($out[$value])>0 && !in_array($value,$asset['OL_NON_SORTABLE_FIELD_IN_URL']))
			{
				foreach($out[$value] as $k=>$v)
				{
					if(is_array($v))
						ksort($out[$value]);
					else
						asort($out[$value]);

					if(is_array($out[$value][$k]))
					{
						ksort($out[$value][$k]);
						asort($out[$value][$k]);
					}
				}
			}
		}
		return $out;
	}
	public function GetSearchParam($URLparam)
	{
		global $asset, $virtual_path;
		$ret_param = array();
		$s_param = array();
		$is_add_search = false;
		$URLparam = trim($URLparam);

		if(!empty($URLparam))
		{
			global $state;
			$URLparam = str_replace($virtual_path['Host_Url'].SEARCH_URL,'/',$URLparam);

			if(strpos($URLparam, URL_SEPARATORBACKSLASE."addtype".URL_SEPARATORDASH) !== false)
			{
				$is_add_search = true;
			}

			$qp = explode(URL_SEPARATORBACKSLASE,ltrim(rtrim(trim($URLparam),URL_SEPARATORBACKSLASE),URL_SEPARATORBACKSLASE));

			foreach($qp as $key => $val)
			{
				if(strpos($val,URL_SEPARATORDASH) === false  || (isset($is_add_search) && $is_add_search == true))
				{
					if ($key == 0 && strlen($val) == 2)
					{
						$state = $val;
					}
					else
					{
						if(!is_numeric($val) && !empty($state))
						{
							$s_param['addval'] = str_replace('_',' ',$val).", ".$state;
							$is_add_search = false;
						}
						else
						{
							$s_param['addval'] = $val;
							$is_add_search = false;
						}
					}
				}
				else
				{
					$args = explode(URL_SEPARATORDASH,$val,2);
					$s_param[$args[0]] = $args[1];
				}

				if(is_array($s_param) && count($s_param) > 0)
				{
					foreach($s_param AS $field => $value)
					{
						if($value == '' || empty($value))
							unset($s_param[$field]);

						if($field !== 'addval' && $field !== 'addname')
						{
							if(!is_array($value) && strpos($value, URL_SEPARATORCOMMA) == true)
							{
								unset($s_param[$field]);
								$v               = explode(URL_SEPARATORCOMMA, $value);
								$s_param[$field] = $v;
							}
						}
					}
				}
			}
		}
		if(isset($s_param['addval']) && !array_key_exists('addtype',$s_param))
		{
			$s_param['addtype'] = ASTYPE_CITYSTATE;
		}
		if(is_array($s_param) && count($s_param) > 0)
		{
			foreach($s_param AS $F_Key => $F_val)
			{
				if(!is_array($F_val) && ($F_Key == FIELD_SUBTYPE || $F_Key == FIELD_PROP_CONDITION || $F_Key == FIELD_SALETYPE || $F_Key == FIELD_STORIES_DESC))
					$ret_param[$F_Key] =  array($F_val);
				else
					$ret_param[$F_Key] =  $F_val;
			}
		}

		return array_filter($ret_param);

	}

	public function GetSearchURL($arr_Param)
	{
		global $asset;
		$url_param = array();
		if(!is_array($arr_Param))
			return false;

		# Order all URL params so URL can be in same way every time
		$Param = self::OrderUrlParams($arr_Param,false);

		$arrParam = array_filter($Param);
		$def_url_param = array();

		foreach($arrParam AS $key => $value)
		{
			if(!in_array($key,$asset['OL_NON_STATIC_LOOK_UP']))
			{
				if(in_array($key,$asset['OL_DEFAUL_URL_PARAM']))
				{
					$def_url_param[$key] = $arrParam[$key];
					$def_url_param = self::OrderUrlParams($def_url_param,$asset['OL_DEFAUL_URL_PARAM']);
					$arrParam[$key] = '';
				}
				if($arrParam[$key] != 'Any' && $arrParam[$key] != '')
				{
					if(is_array($arrParam[$key]) && count($arrParam[$key]) > 0)
					{
						$temp_array = $arrParam[$key];
						$arrParam[$key] = array_filter($temp_array);
						if(!in_array($key,$asset['OL_NON_SORTABLE_FIELD_IN_URL']))
						{
							asort($arrParam[$key]);
						}
						if(count($arrParam[$key]) > 0)
							$url_param[$key] = implode(URL_SEPARATORCOMMA,$arrParam[$key]);
					}
					else
					{
						$url_param[$key] = $arrParam[$key];
					}
				}
			}
		}

		$url_param = array_merge($url_param,$def_url_param);

		if(is_array($url_param) && count($url_param) > 0)
		{
			$turl_param = array_filter($url_param);

			foreach($turl_param as $f => $v)
			{
				if($f == 'addval')
					$turl_args[] =  $v;
				else
                {
                    $turl_args[] =  $f.URL_SEPARATORDASH.$v;
                }

			}
		}

		$url_args = array_filter($turl_args);

       $url = implode(URL_SEPARATORBACKSLASE,$url_args);
       return $url;
	}

	public function SearchParamAndURL($url=false, $arr_search=false)
	{
		global $virtual_path, $physical_path;
		$is_redirect = false;


		if((empty($url) || $url == false) && (!is_array($arr_search) || (is_array($arr_search) && count($arr_search) <= 0)))
			$is_redirect = true;
		else
		{
			if((!empty($url) || $url != false) && (!is_array($arr_search) || empty($arr_search) || $arr_search == false))
			{
				$ret_Param['sparam'] = $this->GetSearchParam(urldecode($url));
				$ret_Param['sparam'][P_SIZE]   =   RESULT_PAGESIZE;

				$ret_Param['sparam'][GO_TO_PAGE] 			= isset($ret_Param['sparam'][GO_TO_PAGE]) && intval($ret_Param['sparam'][GO_TO_PAGE]) > 1 ? intval($ret_Param['sparam'][GO_TO_PAGE]) : 1;
				$ret_Param['sparam'][S_RECORD]  = ($ret_Param['sparam'][GO_TO_PAGE] - 1) * $ret_Param['sparam'][P_SIZE];

				//$ret_Param['sparam']['referer_url'] = $_SERVER['REQUEST_URI'];
			}
			elseif(is_array($arr_search) && count($arr_search) > 0 && (empty($url) || $url == false))
			{
				$ret_Param['sparam'] = array_filter($arr_search);
			}
			elseif(!empty($url) && is_array($arr_search) && count($arr_search) > 0)
			{
				//$is_redirect = false;
				if(strpos($url, SEARCH_URL) != false)
				{
					$urlparam = explode(SEARCH_URL,$url)[1];
				}
				else
					$urlparam = $url;

				$old_param = $this->GetSearchParam(urldecode($urlparam));

				//$_SESSION['page_size'] = $arr_search['page_size']   =   RESULT_PAGESIZE;
				if(isset($arr_search['addtocart']) && $arr_search['addtocart'] == true)
					$ret_Param['sparam'] = $arr_search;
				else
				{   //Utility::pre($old_param);
					$arr_search[GO_TO_PAGE] = isset($arr_search[GO_TO_PAGE]) ? $arr_search[GO_TO_PAGE] : (isset($old_param[GO_TO_PAGE]) ? $old_param[GO_TO_PAGE] : 1);
					$arr_search[S_RECORD]  = ($arr_search[GO_TO_PAGE] - 1) * $arr_search[P_SIZE];

					$ret_Param['sparam'] = array_merge($old_param,$arr_search);

					if(isset($old_param[V_TYPE]) && $old_param[V_TYPE] != $arr_search[V_TYPE])
					{
						$is_redirect = true;
					}

				}

				if((isset($arr_search['AddressName']) || isset($arr_search['addval'])) && (isset($arr_search['addtype']) && ($arr_search['addtype'] == ASTYPE_CITYSTATE || $arr_search['addtype'] == ASTYPE_SUB || $arr_search['addtype'] == ASTYPE_ALL)))
				{
					if((isset($old_param['AddressName']) && isset ($old_param['addval']) && strtolower($old_param['AddressName']) != strtolower($arr_search['AddressName'])) && strtolower($old_param['addval']) != strtolower($arr_search['addval']))
					{
						$ret_Param['sparam']['isPolySearch'] = 'NEW';
					}
					else
					{
						$ret_Param['sparam']['isPolySearch'] = 'OLD';
					}
				}
				else
				{
					$ret_Param['sparam']['isPolySearch'] = '';
				}

			}
		}

		if(!array_key_exists(SO,$ret_Param['sparam']) || (array_key_exists(SO,$ret_Param['sparam']) && $ret_Param['sparam'][SO] == ''))
		{
			$ret_Param['sparam'][SO] = DEFAULT_SO;
		}
		if(!array_key_exists(SD,$ret_Param['sparam']) || (array_key_exists(SD,$ret_Param['sparam']) && $ret_Param['sparam'][SD] == ''))
		{
			$ret_Param['sparam'][SD] = DEFAULT_SD;
		}
		if(!array_key_exists(V_TYPE,$ret_Param['sparam']) || (array_key_exists(V_TYPE,$ret_Param['sparam']) && $ret_Param['sparam'][V_TYPE] == ''))
		{
			$ret_Param['sparam'][V_TYPE] = DEFAULT_VT;
		}

		if(!array_key_exists(GO_TO_PAGE,$ret_Param['sparam']) || (array_key_exists(GO_TO_PAGE,$ret_Param['sparam']) && $ret_Param['sparam'][GO_TO_PAGE] == ''))
		{
			$ret_Param['sparam'][GO_TO_PAGE] = 1;
		}
		else{
			$ret_Param['sparam'][GO_TO_PAGE] = $ret_Param['sparam'][GO_TO_PAGE];
		}
		$ret_Param['sparam'][P_SIZE]   =   RESULT_PAGESIZE;
		if($ret_Param['sparam'][V_TYPE] == VT_MAP)
		{
			$ret_Param['sparam']['getMapData'] = true;
			$ret_Param['sparam']['getAllPhoto'] 	= true;
		}
		if(isset($ret_Param['sparam']['poly']) && !empty($ret_Param['sparam']['poly']))
		{
			$ret_Param['sparam']['poly'] = trim($ret_Param['sparam']['poly'], "~");
		}
		if(isset($ret_Param['sparam']['cir']) && !empty($ret_Param['sparam']['cir']))
		{
			$ret_Param['sparam']['cir'] = trim($ret_Param['sparam']['cir'], "~");
		}

		$ret_Param['url'] = $this->GetSearchURL($ret_Param['sparam']);

		if(isset($is_redirect) && $is_redirect == true)
		{
			header("location: ".$virtual_path['Host_Url'].SEARCH_URL.$ret_Param['url']);
			exit(0);
		}
		else
			return $ret_Param;
	}
	public function getSiteMapSearchUrl($POST)
	{
		global $virtual_path;

		$search_url = '';
		if(isset($POST['pc_safe_url']) && !empty($POST['pc_safe_url']))
		{
			if($_GET['section'] == 'preconstruction')
				$search_url	=	$virtual_path['Host_Url'].PRECONSTRUCTION_URL.$this->buildSefString($POST['pc_safe_url']);
		}
		$search_url	=	strtolower($search_url);

		return $search_url;
	}
    public function getDateTimeDiff($first_datetime, $second_datetime = false, $diff=false)
	{
		if(empty($second_datetime))
			$second_datetime = date('Y-m-d H:i:s');

		//echo $first_datetime;die;
		$obj_first_datetime     =   new DateTime($first_datetime);
		$obj_second_datetime    =   new DateTime($second_datetime);

		$dt_diff = date_diff($obj_second_datetime, $obj_first_datetime);

		//Utility::pre($dt_diff);

		if($diff === false)
			return $dt_diff;
		else
			return $dt_diff->$diff;
	}
	public function pad_query_string($url, $querystring=false)
	{
		$has_querystring = strpos($url, '?');

		$url = trim($url);
		if($has_querystring === false)
			$url .= '?'.$querystring;
		else
			$url .= '&'.$querystring;

		return $url;
	}

}

// remove keyword if replacement not take palce for any code
function clean_keyword(&$item, $key) {
	$ret = preg_match('/(\[.*\])/', $item, $matches);
	if($ret >= 1)
		$item = '';
	else
		$item = trim($item);

}
?>