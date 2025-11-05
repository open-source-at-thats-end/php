<?php
define('SECRET_PASS', 'neverever');
#=============================================================================================================================
#	File Name	:	Utility.php
#=============================================================================================================================
class Utility
{
    private static $instance ;
    public static function getInstance(){
        if( !isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    protected function __construct(){
        global $wpdb, $arrPhysicalPath;
    }
    static public function uploadFile($File, $destFolder, $prevFileName, $createThumb=false, $deletePrevFile=true)
    {
        global $config, $asset;

        # Clean filename and make unique name
        $destFile = str_replace(" " , "-", $File['name']);  	//convert spaces to a dash
        $destFile = str_replace("_" , "-", $File['name']);  	//convert underscore to a dash
        $destFile = preg_replace("/-+/" , "-", $destFile);  	//convert multiple dashes to a single dash
        $destFile = strtolower(Utility::getUniqueFilePrefix(). preg_replace("#[^a-z0-9.-]#i", "", $destFile));

        # Is file uploaded
        if($File['size'] !=0 && is_uploaded_file($File['tmp_name']))
        {
            # Delete any existing file with same name
            @unlink($destFolder. $destFile);

            # Upload file
            $uploadStatus = move_uploaded_file($File['tmp_name'], $destFolder. $destFile);

            # If file uploaded, create required thumb
            if($uploadStatus)
            {
                # Delete previous file
                if($prevFileName)
                    @unlink($destFolder. $prevFileName);

                if($createThumb)
                {
                    // Create thumbs here
                }
            }

            # Return file
            return $destFile;
        }

        # If have any default file, return it
        if($prevFileName)
        {
            # Delete previous file if mention
            if($deletePrevFile)
            {
                @unlink($destFolder. $prevFileName);

                if($createThumb)
                {
                    //@unlink($destFolder. 'small_'. $prevFileName);
                    //@unlink($destFolder. 'medium_'. $prevFileName);
                    //@unlink($destFolder. 'big_'. $prevFileName);
                }

                return '';
            }

            return $prevFileName;
        }

        return '';
    }

    static public function getUniqueFilePrefix()
    {
        list($usec, $sec)	= explode(" ",microtime());
        list($trash, $usec)	= explode(".",$usec);

        return (date("YmdHis").substr(($sec + $usec), -10).'-');
    }
	static public function buildSefSUrl($str) {

		$str = preg_replace('/[^a-zA-Z0-9_-]+/', '-', $str);	/* Make alph numerical string */
		$str = preg_replace('/-+/', '-', $str);  			/* convert multiple dashes to a single dash */
		$str = trim(trim($str), "-");

		return $str;
	}
    static public function formatListingAddress($arrConfig, $arrRecord) {

        $arrFields = StaticArray::arrListingField();//explode(',', $arrConfig['Fields']);

        $strReturn = $arrConfig['Format'];

        foreach($arrFields as $key=>$fieldName) {

            $fieldName = trim($fieldName);
            if($fieldName == 'StreetDirPrefix')
            {
                $strReturn = str_replace($fieldName, strtoupper($arrRecord[$fieldName]), $strReturn);
            }
            elseif ($fieldName == 'UnitNo' && $arrRecord[$fieldName] != ''){
                $strReturn = str_replace($fieldName, ' #'.strtoupper($arrRecord[$fieldName]), $strReturn);
            }
            else{
                $strReturn = str_replace($fieldName, $arrRecord[$fieldName], $strReturn);
            }

        }

        $strReturn = preg_replace ('/(,\s{0,})+/', ', ', $strReturn);  	/* convert multiple comma to a single space */
        $strReturn = preg_replace ('/ +/', ' ', $strReturn);  			/* convert multiple spaces to a single space */

        $strReturn = trim(ucwords($strReturn),', ');  					/* convert to word case */
        //$strReturn = trim(ucwords(strtolower($strReturn)),', ');  					/* convert to word case */

        if($strReturn == '')
        {
            $strReturn = 'Address Not Available';
        }

        return $strReturn;
    }
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
	static public function formatListingUrl($format, $arrRecord)
	{
		global $asset;

		$arrFields = $asset['arrListingField'];//explode(',', $arrConfig['Fields']);

        if(isset($arrRecord['SubType']) && $arrRecord['SubType'] == "Condominium" && isset($format['condo-slug-1']) && $format['condo-slug-1'] != '' && isset($format['condo-slug-2']) && $format['condo-slug-2'] != '')
        {
            $slug_1 = $format['condo-slug-1'];
            $slug_2 = $format['condo-slug-2'];
        }
        else
        {
            $slug_1 = $format['slug-1'];
            $slug_2 = $format['slug-2'];
        }

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
	static public function formatListingTitle($arrConfig, $arrRecord) {

		$arrFields = StaticArray::arrListingField();//explode(',', $arrConfig['Fields']);
		$strReturn = $arrConfig['Format'];

		foreach($arrFields as $key=>$fieldName) {
			$fieldName = trim($fieldName);
            if($fieldName == 'StreetDirPrefix')
            {
                $strReturn = str_replace($fieldName, strtoupper($arrRecord[$fieldName]), $strReturn);
            }
            elseif ($fieldName == 'UnitNo' && $arrRecord[$fieldName] != ''){
                $strReturn = str_replace($fieldName, ' #'.strtoupper($arrRecord[$fieldName]), $strReturn);
            }
            else{
                $strReturn = str_replace($fieldName, $arrRecord[$fieldName], $strReturn);
            }
			//$strReturn = str_replace($fieldName, $arrRecord[$fieldName], $strReturn);
		}

		$strReturn = preg_replace ('/(,\s{0,})+/', ', ', $strReturn);  	/* convert multiple comma to a single space */
		$strReturn = preg_replace ('/ +/', ' ',	$strReturn);  			/* convert multiple spaces to a single space */

        $strReturn = trim(ucwords($strReturn),', ');   					/* convert to word case */
//		$strReturn = trim(ucwords(strtolower($strReturn)), ', ');  					/* convert to word case */

		return $strReturn;
	}
	static public function generatePassword($keywordArr)
	{
		$keywordArr = array_merge($keywordArr, StaticArray::arrPasswordKeyword());
		$rand_keys 	= array_rand($keywordArr);
		$rand_digit = mt_rand(10, 99);
		$keyword    = $keywordArr[$rand_keys];
		$randstr    = $keyword.$rand_digit;
		return $randstr;
	}
	static public function GetSearchParamAndURL($url=false, $arr_search=false)
    {

            //$arr_search = array_filter($arr_search);


        if((!empty($url) || $url != false) && (!is_array($arr_search) || empty($arr_search) || $arr_search == false)){
            $qp = explode('&',$url);
	        $qp = array_filter($qp);

            foreach($qp as $key => $val)
            {
                $args = explode('=',$val);

	            if($args[0] == 'minprice' || $args[0] == 'maxprice')
	            {
		            $s_param['sparam'][$args[0]] = str_replace(',','',$args[1]);
	            }
                elseif($args[0] !== 'addval' && $args[0] !== 'addressname' && $args[0] !== 'kword' && strpos($args[1], ',') == true){
                    $s_param['sparam'][$args[0]] = explode(',', $args[1]);
                }
                else{
                    $s_param['sparam'][$args[0]] = $args[1];
                }
            }
        }
        elseif (is_array($arr_search) && count($arr_search) > 0){
            $arr_search = array_filter($arr_search);
            foreach ($arr_search as $key => $val){

            	if($key == 'minprice' || $key == 'maxprice')
	            {
		            $s_param['sparam'][$key] = str_replace(',','',$val);
	            }
                elseif($key !== 'addval' && $key !== 'addressname' && $key !== 'kword' && Utility::strposa($val, ',') == true){
                    $s_param['sparam'][$key] = explode(',', $val);
                }
                else{
                    $s_param['sparam'][$key] = $val;
                }
            }


        }

        $s_param['url'] = Utility::GetSearchURL($s_param['sparam']);
        return array_filter($s_param);

    }
    static function strposa($haystack, $needles=array(), $offset=0) {
        $chr = array();
        foreach($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        return min($chr);
    }
    static public function GetSearchURL($arr_Param)
    {

        //$def_url_param = array();
        $tmp = array();
        foreach($arr_Param as $key => $val)
        {
            if(!in_array($key, StaticArray::OL_NON_STATIC_LOOK_UP()))
            {
                if(is_array($arr_Param[$key]) && count($arr_Param[$key]) > 0){
                    $tmp[] = $key .'='.implode(',', $val);
                }else{
                    $tmp[] = $key.'='.$val;
                }

            }
        }

        $temp_q = implode('&',$tmp);
        return $temp_q;

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
	/*function get_custom_options()
	{
		global $objDB, $wpdb;

		$sql = "SELECT * FROM ". $wpdb->prefix. "options WHERE option_name = 'lpt_config'";

		$rs = $objDB->query($sql);

		$arr_config = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

		$arr_option_value = unserialize($arr_config['option_value']);

		return $arr_option_value;
	}*/
	static function generateListingAttributes($Record, $arrMetaData='')
	{
		global $config,$arrConfig;

		//echo '<pre>';print_r($Record);exit();

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
            /*if( isset($Record['Address']) && $Record['Address'] != '')
            {
                $street = $Record['Address']." ";
            }
            else
            {*/

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
                    $street .= strtoupper((strpos($Record['UnitNo_2'], '#') === false ? ', #' : '').$Record['UnitNo_2']." ");
                    //$street .= "Unit ".trim($Record['UnitNo_2'])." ";
                if (isset($Record['UnitNo']) && $Record['UnitNo'] !='')
                {
                    //$street .= trim($Record['UnitNo'], "#")." ";//(strpos($Record['UnitNo'], '#') === false ? '#' : '').$Record['UnitNo']." ";
                    $street .= strtoupper((strpos($Record['UnitNo'], '#') === false ? ', #' : '').$Record['UnitNo']." ");
                }
            //}

           //echo $street;exit();


            //$street = ucwords(strtolower($street));

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
        $rsAttr['AddressFull'] = rtrim($street,' ');

        if (isset($Record['CityName']))
            $rsAttr['AddressFull'] .= ", ".$Record['CityName'].", ";

        $rsAttr['AddressFull'] = ucwords(strtolower($rsAttr['AddressFull']));

        if(isset($Record['State']))
            $rsAttr['AddressFull'] .= $Record['State'];

        if (isset($Record['ZipCode']))
            $rsAttr['AddressFull'] .= " ".$Record['ZipCode'];

        //$rsAttr['AddressSmall'] = $street;


        if(isset($Record['DisplayAddress']) && $Record['DisplayAddress'] == 'Y')
        {
            $rsAttr['AddressSmall'] = rtrim($street, ' ');
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

        $Record['formatURL'] = $arrConfig['page-config']['page-permalink-text-detail'];
        $rsAttr['SFUrl'] = Utility::formatListingUrl($Record['formatURL'], $Record);
        //echo '<pre>';print_r($street);exit();

        return $rsAttr;
    }
    public function ReplaceCustomVariables($recTemplate, $recUser = array())
    {
        global $config, $asset;

        $retArr = array();

        # Replace Tempalte Varibales With Actual Values [Contents/Subject]
        $arrReplaceWith = array($config['site_title'], $config['site_url'], $config['site_domain']);

        // This information passed from Cronjob [send_agent_introduction/ second_login_responder]
        if ($recUser['user_first_name']) {
            array_push($arrReplaceWith, $recUser['user_first_name']);
            array_push($asset['EMAIL_CONTENT_KEYWORDS'], '{$user_name}');
        }
        //echo '<pre>';print_r($asset['EMAIL_CONTENT_KEYWORDS']);exit();
        // Subject
        $recTemplate['email_subject'] = str_replace($asset['EMAIL_CONTENT_KEYWORDS'], $arrReplaceWith, $recTemplate['search_url']).',';
        $recTemplate['email_subject'] .= str_replace($asset['EMAIL_CONTENT_KEYWORDS'], $arrReplaceWith, $recTemplate['search_title']);

        // Content
        $recTemplate['email_content'] = str_replace($asset['EMAIL_CONTENT_KEYWORDS'], $arrReplaceWith, $recTemplate['email_content']);


        $recTemplate['email_content'] = str_replace('{$Site_Link}', '<a target="_blank" href="' . $config['site_url'] . '">' . $config['site_domain'] . '</a>', $recTemplate['email_content']);

        // Replcae First Name
        if ($recUser['lead_first_name'])
            $recTemplate['email_content'] = str_replace('{$lead_first_name}', $recUser['$lead_first_name'], $recTemplate['email_content']);

        // Replcae Last Name
        if ($recUser['lead_last_name'])
            $recTemplate['email_content'] .= str_replace('{$lead_last_name}', $recUser['$lead_last_name'], $recTemplate['email_content']);

        // Replcae Last Name
        if ($recUser['lead_first_name'])
            $recTemplate['email_content'] .= str_replace('{$lead_name}', trim(ucwords(strtolower($recUser['lead_first_name'] . ' ' . $recUser['lead_last_name']))), $recTemplate['email_content']);

        # Set Generated Subject/Contents
        $retArr['Email_Subject'] = $recTemplate['email_subject'];
        $retArr['Email_Content'] = stripslashes($recTemplate['email_content']);

        return $retArr;
    }
	/*function get_custom_options()
	{
		global $objDB, $wpdb;

		$sql = "SELECT * FROM ". $wpdb->prefix. "options WHERE option_name = 'lpt_config'";

		$rs = $objDB->query($sql);

		$arr_config = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

		$arr_option_value = unserialize($arr_config['option_value']);

		return $arr_option_value;
	}*/
}

?>