<?php

class CustomClass{
    private static $instance;

    # Private member
    var	$Data 			=	array();
    var $Error			=	array();
    var $page_size		=	'';

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
    protected function __construct()
    {
        # Update post data
        if(isset($this->Data['F_FieldInfo']) && is_array($this->Data['F_FieldInfo']))
        {
            foreach($this->Data['F_FieldInfo'] as $key => $val)
            {
                if(array_key_exists($key, $_POST))
                    $this->Data['F_FieldInfo'][$key][SEL_VAL] = $_POST[$key];
            }
        }
    }

#=============================================================================================================================
# Data manupulation function
#=============================================================================================================================

    #=========================================================================================================================
    #	Function Name	:   ViewAll
    #	Purpose			:	Provide list of information
    #	Return			:	Return info
    #-------------------------------------------------------------------------------------------------------------------------
    function ViewAll($addParameters='', $allRecord=false)
    {
        global $db;

        $sql = $this->getSelectQuery(	$this->Data['TableName'],
            $this->Data['F_HeaderItem'],
            $this->Data['F_PrimaryField'],
            $addParameters,
            $allRecord,
            $this->Data['F_Sort']);

        //print $sql;die;
        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        return $db->query($sql);

    }

    #=========================================================================================================================
    #	Function Name	:   getAll
    #	Purpose			:	Provide list of information
    #	Return			:	Return info
    #-------------------------------------------------------------------------------------------------------------------------
    function getAll($addParameters='', $F_CustomSelect='')
    {
        global $db;

        $selectField = !empty($F_CustomSelect) ? $F_CustomSelect : (!empty($this->Data['F_BasicSelect']) ? $this->Data['F_BasicSelect'] : " * ");

        $sql	= " SELECT ". $selectField
            . " FROM ". $this->Data['TableName']
            . " WHERE 1 "
            . (!empty($addParameters)? $addParameters :'');

        if (isset($this->Data['F_Sort']) && $this->Data['F_Sort']!='')
            $sql .= " ORDER BY ". $this->Data['F_Sort']. " ASC ";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        return $db->query($sql);
    }

    #=========================================================================================================================
    #	Function Name	:   getInfoById
    #	Purpose			:	Get the information
    #	Return			:	Return info
    #-------------------------------------------------------------------------------------------------------------------------
    function getInfoById($id, $F_CustomSelect='')
    {
        global $db;
        
        if(is_array($id))
            $idList = implode("','", $id);
        else
            $idList = $id;

        $selectField = !empty($F_CustomSelect) ? $F_CustomSelect : (!empty($this->Data['F_BasicSelect']) ? $this->Data['F_BasicSelect'] : " * ");

        $sql	= " SELECT ". $selectField
            . " FROM ". $this->Data['TableName']
            . " WHERE ". $this->Data['F_PrimaryKey']. " IN ('". $idList. "') ";


        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);
        //return

        return ($rs->fetch_array(is_array($id)?MYSQLI_ASSOC:MYSQLI_FETCH_SINGLE));
    }
    #=========================================================================================================================
    #	Function Name	:   getInfoByParam
    #	Purpose			:	Get the information
    #	Return			:	Return info
    #-------------------------------------------------------------------------------------------------------------------------
    function getInfoByParam($param,$type=MYSQLI_FETCH_SINGLE)
    {
        global $db;

        $sql	= " SELECT * "
            . " FROM ". $this->Data['TableName']
            . " WHERE 1 ". $param;

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);

        return ($rs->fetch_array($type));
    }

    #=========================================================================================================================
    #	Function Name	:   Insert
    #	Purpose			:	Insert new information
    #	Return			:	Return insert status
    #-------------------------------------------------------------------------------------------------------------------------
    function Insert($POST)
    {
        global $db;

        $this->Error['Desc'] = '';

        #check and builder URL Friendly Name
        if ( array_key_exists('F_Sef',$this->Data) && isset($this->Data['F_Sef']) )
        {
            if ( $POST[$this->Data['F_Sef']] == "" )
                $POST[$this->Data['F_Sef']] = $this->buildURLFriendlyName($POST[$this->Data['F_PrimaryField']]);
            else
                $POST[$this->Data['F_Sef']] = $this->buildURLFriendlyName($POST[$this->Data['F_Sef']]);

            #check if Url Friendly name already exist in database
            if ( $this->isExistURLFriendlyName($POST[$this->Data['F_Sef']]) )
            {
                $this->Error['Desc'] = 'URL Friendly name is already exist';
                return false;
            }
        }

        $sql = $this->getInsertQuery($this->Data['TableName'],
            $this->Data['F_FieldInfo'],
            $POST);


        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        # Execute query
        $db->query($sql);


        # Get inserted record id
        $pk_id = $db->sql_inserted_id();

        # If sort order exist, set sort order value to primary key
        if($this->Data['F_Sort'])
        {
            $sql = " UPDATE " . $this->Data['TableName']
                . " SET "
                . $this->Data['F_Sort'] . "='" . $pk_id. "' "
                . " WHERE " . $this->Data['F_PrimaryKey'] . "=  '". $pk_id. "'";

            # Show debug info
            if(DEBUG)
                $this->__debugMessage($sql);

            # Update
            $db->query($sql);
        }

        return $pk_id;
    }

    #=========================================================================================================================
    #	Function Name	:   Update
    #	Purpose			:	Update the information
    #	Return			:	Return update status
    #-------------------------------------------------------------------------------------------------------------------------
    function Update($pkValue, $POST)
    {
        global $db;

        #check and builder URL Friendly Name
        if ( array_key_exists('F_Sef',$this->Data) && isset($this->Data['F_Sef']) )
        {

            if ( $POST[$this->Data['F_Sef']] == "" )
                $POST[$this->Data['F_Sef']] = $this->buildURLFriendlyName($POST[$this->Data['F_PrimaryField']]);
            else
                $POST[$this->Data['F_Sef']] = $this->buildURLFriendlyName($POST[$this->Data['F_Sef']]);

            if ( $this->isExistURLFriendlyName($POST[$this->Data['F_Sef']], $pkValue) )
            {
                $this->Error['Desc'] = 'URL Friendly name already exist';
                return false;
            }

        }

        $sql = $this->getUpdateQuery($this->Data['TableName'],
            $this->Data['F_FieldInfo'],
            $POST,
            $this->Data['F_PrimaryKey']."='$pkValue'");


        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);
        //die;
        //die;
        $db->query($sql);

        //return $db->affected_rows();
        return true;
    }
    #=========================================================================================================================
    #	Function Name	:   Delete
    #	Purpose			:	Delete the information
    #	Return			:	Return delete status
    #-------------------------------------------------------------------------------------------------------------------------
    function Delete($id, $retField='')
    {
        global $db;

        if(!$id)
            return false;

        if(is_array($id))
            $idList = implode("','", $id);
        else
            $idList	= $id;

        # if need any field value, store it first
        if($retField != '')
        {
            $sql = " SELECT $retField "
                . " FROM ". $this->Data['TableName']
                . " WHERE ". $this->Data['F_PrimaryKey']. " IN ('". $idList. "') ";

            $rs = $db->query($sql);

            $retValue = array();

            while($rs->next_record())
            {
                if($rs->f($retField) != '')
                    array_push($retValue, $rs->f($retField));
            }
        }

        # Is have picture field
        if(isset($this->Data['F_DataField']) && count($this->Data['F_DataField']) > 0)
        {
            foreach($this->Data['F_DataField'] as $key=>$val)
            {
                # Get the picture file name and delete all files along with thumbnail
                # Define query
                $sql = " SELECT ". $this->Data['F_DataField'][$key][0]
                    . " FROM ". $this->Data['TableName']
                    . " WHERE ". $this->Data['F_PrimaryKey']. " IN ('". $idList. "') ";

                $rs = $db->query($sql);

                $data = array();

                while($rs->next_record())
                {
                    if($rs->f($this->Data['F_DataField'][$key][0]) != '')
                        array_push($data, $rs->f($this->Data['F_DataField'][$key][0]));
                }

                $ret = $this->deleteFiles($data, $this->Data['F_DataField'][$key][1]);
            }
        }

        #delete related references
        if(is_array($this->delete_relation))
        {
            foreach($this->delete_relation as $db_table => $db_field)
            {
                $where = '';
                if(is_array($db_field))
                {
                    foreach($db_field as $key => $val)
                    {
                        if($where != '')
                            $where .= "OR ". $val. " IN ('". $idList. "') ";
                        else
                            $where .= $val. " IN ('". $idList. "') ";
                    }
                }
                else
                {
                    $where = $db_field. " IN ('". $idList. "') ";
                }

                $sql = " DELETE FROM ".$db_table." WHERE ".$where;

                if(DEBUG)
                    $this->__debugMessage($sql);

                $db->query($sql);
            }
        }

        # Define query
        $sql = " DELETE FROM ". $this->Data['TableName']
            . " WHERE ". $this->Data['F_PrimaryKey']. " IN ('". $idList. "') ";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        $db->query($sql);

        return $retValue;
    }

#=============================================================================================================================
# Query creating code
#=============================================================================================================================

    #=========================================================================================================================
    #	Function Name	:   getSelectQuery
    #	Purpose			:	Create the query
    #	Return			:	None
    #-------------------------------------------------------------------------------------------------------------------------
    function getSelectQuery($TableName, $HeaderItem, $defaultField, $addParameters, $allRecord, $defaultF_Sort)
    {
        global $db;

        # Set Cookies/Values Used For Sorting
        $this->setSortingOptions();

        $sort 	= $this->so;
        $dir 	= $this->sd;

        /*
		$sort 	= $this->arrayKeyExists($this->so, $HeaderItem);
		$dir 	= $this->arrayKeyExists($this->sd, array('asc'=>'asc', 'desc'=>'desc'));

		$sort	= empty($sort) ? key($HeaderItem) : $sort;
		$dir	= empty($dir) ? 'asc' : $dir;
		*/
        $_SESSION['page_size'] = ($this->page_size?$this->page_size:$_SESSION['page_size']);

        $sql	= " SELECT count(*) as cnt "
            . " FROM ". $TableName
            . " WHERE 1 "
            . ($this->alpha != ''? " AND ". $defaultField. " LIKE '". $this->alpha. "%' ":'')
            . ($addParameters != ''? $addParameters :'');

        //print $sql;

        $rs = $db->query($sql);
        $rs->next_record();
        $this->total_record = $rs->f("cnt") ;

        $rs->free();

        # Reset the start record if required
        if($_SESSION['start_record'] >= $this->total_record || $_SESSION['page_size'] >= $this->total_record )
            $_SESSION['start_record'] = 0;

        $selectField = !empty($F_CustomSelect) ? $F_CustomSelect : (!empty($this->Data['F_BasicSelect']) ? $this->Data['F_BasicSelect'] : " * ");

        $sql	= " SELECT ". $selectField
            //$sql	= " SELECT * "
            . " FROM ". $TableName
            . " WHERE 1 "
            . ($this->alpha != ''? " AND ". $defaultField. " LIKE '". $this->alpha. "%' ":'')
            . ($addParameters != ''? $addParameters :'')
            . ($sort != ''? ' ORDER BY '. $sort. ($dir != '' ? ' '. $dir:'') : ($defaultF_Sort != '' ? ' ORDER BY '. $defaultF_Sort : ""))
            . (!$allRecord?" LIMIT ". $_SESSION['start_record']. ", ". $_SESSION['page_size']:"");

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        return $sql;
    }
    #=========================================================================================================================
    #	Function Name	:   getInsertQuery
    #	Purpose			:	Create the input query
    #	Return			:	None
    #-------------------------------------------------------------------------------------------------------------------------
    function getInsertQuery($TableName, $FieldInfo, $POST)
    {
        $sqlFields = '';
        $sqlValues = '';

        $FieldList  = $this->getFieldsValue($FieldInfo, $POST);

        foreach($FieldList as $FieldName=>$FieldValue)
        {
            $FieldValue = addslashes(stripslashes(trim($FieldValue)));

            if ($sqlFields != '')
                $sqlFields .= ", \r\n";

            $sqlFields .= $FieldName;

            if ($sqlValues != '')
                $sqlValues .= ", \r\n";

            $sqlValues .= "'" . addslashes(stripslashes(trim($FieldValue))) . "'";
        }

        return "INSERT INTO $TableName($sqlFields) VALUES ($sqlValues)";
    }

    #=========================================================================================================================
    #	Function Name	:   getUpdateQuery
    #	Purpose			:	Create update query
    #	Return			:	None
    #-------------------------------------------------------------------------------------------------------------------------
    function getUpdateQuery($TableName, $FieldInfo, $POST, $primaryKey)
    {
        $sqlSets = '';

        $FieldList  = $this->getFieldsValue($FieldInfo, $POST);
        foreach($FieldList as $FieldName=>$FieldValue)
        {
            if ($sqlSets != '')
                $sqlSets .= ', ';

            $sqlSets .= "$FieldName = '" . addslashes(stripslashes(trim($FieldValue))) . "'";
        }

        return "UPDATE $TableName SET $sqlSets WHERE $primaryKey";
    }
	#====================================================================================================
	#	Function Name	:   UpdateFieldByParam
	#	Purpose			:	get field from table
	#	Return			:	return insert status
	#----------------------------------------------------------------------------------------------------
	public function UpdateFieldByParam($field_sets , $where_condition)
	{
		global $db;

		$sql	=	"UPDATE " .  $this->Data['TableName']
			.	" SET "   . $field_sets
			.	" WHERE " . $where_condition ;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		# Execute Query
		$db->query($sql);

		return $db->affected_rows();
	}
    #=========================================================================================================================
    #	Function Name	:   getFieldsValue
    #	Purpose			:	Strip all field values
    #	Return			:	None
    #-------------------------------------------------------------------------------------------------------------------------
    function getFieldsValue($FieldInfo, $POST)
    {
        foreach ($FieldInfo as $fieldName => $params)
        {
            if(isset($POST[$fieldName]) || isset($_FILES[$fieldName]) || $params[CNT_TYPE] == C_DATE || $params[CNT_TYPE] == C_TIME || $params[CNT_TYPE] == C_CHECKBOX )
            {
                if(is_array($_FILES[$fieldName]) && (in_array($params[CNT_TYPE], array(C_PICFILE, C_AUDIOFILE, C_FILE))))
                    $FieldsValue[$fieldName] = $this->uploadFile($_FILES[$fieldName], $POST['prev_'.$fieldName], $params[CNT_TYPE] == C_PICFILE?true:false, $POST['del_'.$fieldName], $params[ADDITIONAL_THUMBS]);
                elseif($params[CNT_TYPE] == C_DATE)
                    $FieldsValue[$fieldName] = $POST[$fieldName. '_year']. '-'. $POST[$fieldName. '_month']. '-'. $POST[$fieldName. '_day'];
                elseif($params[CNT_TYPE] == C_DATE_PICKER)
                {
                    $FieldsValue[$fieldName] = date('Y-m-d', strtotime(str_replace(",", "", $POST[$fieldName])));
                }
                elseif($params[CNT_TYPE] == C_TIME)
                {
                    if($POST[$fieldName. '_meridian'] == 'pm')
                        $hour = $POST[$fieldName. '_hour'] + 12;
                    else
                        $hour = $POST[$fieldName. '_hour'];

                    $FieldsValue[$fieldName] = mktime($hour, $POST[$fieldName. '_minute'], 0, date("m"), date("d"), date("Y"));
                }
                elseif($params[CNT_TYPE] == C_PHONE && is_array($POST[$fieldName]))
                {
                    $FieldsValue[$fieldName] = implode("-",$POST[$fieldName]);
                }
                elseif(is_array($POST[$fieldName]))
                    $FieldsValue[$fieldName] = implode(",", $POST[$fieldName]);
                elseif($params[CNT_SWITCH] == true)
                {
                    $FieldsValue[$fieldName] = (isset($POST[$fieldName]) && $POST[$fieldName] == YES)?YES:NO;
                }
                else
                {
                    if($params[VAL_TYPE]&V_INT)
                        $FieldsValue[$fieldName] = intval($POST[$fieldName]);
                    elseif($params[VAL_TYPE]&V_FLOAT)
                        $FieldsValue[$fieldName] = floatval($POST[$fieldName]);
                    else
                        $FieldsValue[$fieldName] = trim(stripslashes($POST[$fieldName]));
                }
            }
        }

        return $FieldsValue;
    }

    #=========================================================================================================================
    #	Function Name	:   uploadFile
    #	Purpose			:	Upload file
    #	Return			:	None
    #-------------------------------------------------------------------------------------------------------------------------
    function uploadFile($File, $prevFileName, $createThumb=false, $deletePrevFile=true, $additionalThumbs=false)
    {
        global $config, $asset;

        # Clean filename and make unique name
        $destFile = str_replace(" " , "-", $File['name']);  	//convert spaces to a dash
        $destFile = str_replace("_" , "-", $File['name']);  	//convert underscore to a dash
        $destFile = preg_replace("/-+/" , "-", $destFile);  	//convert multiple dashes to a single dash
        $destFile = strtolower($this->getUniqueFilePrefix(). preg_replace("/[^[:alnum:].\-]/", "", $destFile));
        //$destFile 	= strtolower($this->getUniqueFilePrefix(). ereg_replace("[^[:alnum:].]", "", $File['name']));

        /* Define upload folder */
        $destFolder	= $this->Data['P_Upload']. '/';

        # Is file uploaded
//        if($File['size'] !=0 && is_uploaded_file($File['tmp_name']))
        if($File['size'] !=0)
        {
//            var_dump(is_uploaded_file($File['tmp_name']));die;
            # Delete any existing file with same name
            @unlink($destFolder. $destFile);


            # Upload file
//            $directory = mkdir($destFolder.'/13', 0777);

            //$uploadStatus = move_uploaded_file($File['tmp_name'], $destFolder.$destFile);
            $content = $fileData = file_get_contents($File['tmp_name']);
            $uploadStatus = fopen($destFolder.$destFile, 'w');
            fwrite($uploadStatus, $content);
            fclose($uploadStatus);

            # If file uploaded, create required thumb
            if($uploadStatus)
            {
                # Delete previous file
                if($prevFileName)
                    @unlink($destFolder. $prevFileName);

//                if($createThumb)
//                {
//                    global $webConf;
//
//                    # Make thumb
//                    $thumb = new Thumbnail($webConf->Data['P_Upload']. '/'. $config['watermark_image']);
//
//                    $thumb->image($destFolder. $destFile);
//                    $thumb->jpeg_quality(100);
//
//                    # Small thumbnail - create new and delete old one
//                    list($width, $height) = explode('x', strtolower($config['thumb_small']));
//
//                    $thumb->size_smart($width, $height);
//                    $thumb->get('small');
//
//                    if($prevFileName)
//                        @unlink($destFolder. 'small_'. $prevFileName);
//
//                    # Medium thumbnail - create new and delete old one
//                    list($width, $height) = explode('x', strtolower($config['thumb_medium']));
//
//                    $thumb->size_smart($width, $height);
//                    $thumb->get('medium');
//
//                    if($prevFileName)
//                        @unlink($destFolder. 'medium_'. $prevFileName);
//
//                    # Big thumbnail - create new and delete old one
//                    list($width, $height) = explode('x', strtolower($config['thumb_big']));
//
//                    $thumb->size_smart($width, $height);
//                    $thumb->get('big');
//
//                    if($prevFileName)
//                        @unlink($destFolder. 'big_'. $prevFileName);
//
//                    # Additional Thumbs Required
//                    if(is_array($additionalThumbs))
//                    {
//                        foreach($additionalThumbs as $key => $val)
//                        {
//                            $thumbName = $key;
//
//                            list($width, $height) = explode('x', strtolower($val));
//
//                            $thumb->size_smart($width, $height);
//                            $thumb->get($thumbName);
//
//                            if($prevFileName)
//                                @unlink($destFolder. $thumbName . '_' . $prevFileName);
//
//                        }
//                    }
//                }
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
                    @unlink($destFolder. 'small_'. $prevFileName);
                    @unlink($destFolder. 'medium_'. $prevFileName);
                    @unlink($destFolder. 'big_'. $prevFileName);
                }

                return '';
            }

            return $prevFileName;
        }

        return '';
    }

    #=========================================================================================================================
    #	Function Name	:   getSelectQuery
    #	Purpose			:	Build URL Friendly Name
    #	Return			:	URL Friendly String
    #-------------------------------------------------------------------------------------------------------------------------
    function buildURLFriendlyName($string)
    {
        #store the special charater into the array which is to be remove for URL Friendly name
        $special_character_array = str_split('!@#$%^&*()+=[]\';,./{}|":<>?');
        $string_array = str_split($string);

        #loop through the string and remove the special character
        foreach($string_array as $char)
        {
            if ( !in_array($char,$special_character_array) )
            {
                $new_string .= $char;
            }
        }

        #remove trailing space
        $new_string = trim($new_string," ");

        #build the more safe url
        //$new_string = $this->buildSefString($new_string);
        $new_string = str_replace(' ',					"-",		$new_string); 	//replace " with nothing
        $new_string = str_replace("'",					"",			$new_string); 	//replace ' with nothing
        $new_string = str_replace('"',					"",			$new_string); 	//replace " with nothing
        //$new_string = preg_replace("/[^a-zA-Z0-9_-]/",	"-", 	$new_string); 	//convert non alphanumeric and non - _ to -
        $new_string = preg_replace ( "/-+/" , 			"-" , 		$new_string );  //convert multiple dashes to a single dash
        $new_string = preg_replace ( "/ +/" , 			" " , 		$new_string );  //convert multiple spaces to a single space

        $new_string = strtolower($new_string);

        return $new_string;
    }

    #=========================================================================================================================
    #	Function Name	:   isExistURLFriendlyName
    #	Purpose			:	Check if the URL Friendly name alredy exist
    #	Return			:	true/false
    #-------------------------------------------------------------------------------------------------------------------------
    function isExistURLFriendlyName($value='',$exclude_key='')
    {
        global $db;

        if ( $value ) {
            #set parameter
            $param = $this->Data['F_Sef']." = '".$value."'";

            #exclue primary key if not null
            if ( $exclude_key != "" ) {
                $param .= " AND ".$this->Data['F_PrimaryKey']." != ".$exclude_key;
            }

            if(isset($this->Data['F_Sef_Params']))
            {
                $param .= $this->Data['F_Sef_Params'];
            }
            //print $param;die;
            $rs = $this->getInfoByParam($param);
            if ((count($rs) > 0) && (!empty($rs)))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    #=========================================================================================================================
    #	Function Name	:   __debugMessage
    #	Purpose			:	Display debug message
    #	Return			:	Nothing
    #-------------------------------------------------------------------------------------------------------------------------
    function __debugMessage($message)
    {
        if(is_array($message))
        {
            print "<pre>";
            print_r($message);
            printf("</pre><br>%s<br>", str_repeat("-=", 65));
        }
        else
        {
            printf("%s<br>%s<br>", $message, str_repeat("-=", 65));
        }
    }

    #=========================================================================================================================
    #	Function Name	:   setSortingOptions
    #	Purpose			:	Set Cookies/Fields For Sorting used in All Listing
    #	Return			:
    #-------------------------------------------------------------------------------------------------------------------------
    function setSortingOptions($defSort=array())
    {
        if(@strpos(urldecode($_SERVER['HTTP_REFERER']), $_SERVER['PHP_SELF']) !== false)
        {
            # Set sort order
            $this->so		=	($_GET['so']?$_GET['so']:($_COOKIE['so']?$_COOKIE['so']:($defSort['so']?$defSort['so']:'')));
            # Set sort direction
            $this->sd		=	($_GET['sd']?$_GET['sd']:($_COOKIE['sd']?$_COOKIE['sd']:($defSort['sd']?$defSort['sd']:'asc')));
            # Set filter character
            $this->alpha	=	(isset($_GET['alpha'])?$_GET['alpha']:$_COOKIE['alpha']);

        }

        # Save filter data
        @setcookie('so', 		$this->so, 		COOKIE_EXPIRE_TIME_MIN);

        @setcookie('sd', 		$this->sd, 		COOKIE_EXPIRE_TIME_MIN);

        @setcookie('alpha', 	$this->alpha,	COOKIE_EXPIRE_TIME_MIN);

        //@setcookie('sort_order', 	urlencode(serialize($this->sort_order)),	COOKIE_EXPIRE_TIME_MIN);

    }
    #=========================================================================================================================
    #	Function Name		:	deleteFiles
    #	Purpose				:	Delete the required file list
    #	Return				:	Delete status
    #-------------------------------------------------------------------------------------------------------------------------
    function deleteFiles($fileList, $isPicture=false, $additionalThumbs=false)
    {
        if(is_array($fileList))
        {
            if(count($fileList) == 0) return false;

            foreach($fileList as $key=>$fileName)
            {
                @unlink($this->Data['P_Upload']. '/'. $fileName);

                if($isPicture)
                {
                    @unlink($this->Data['P_Upload']. '/'. 'small_'. $fileName);
                    @unlink($this->Data['P_Upload']. '/'. 'medium_'. $fileName);
                    @unlink($this->Data['P_Upload']. '/'. 'big_'. $fileName);

                    # Additional Thumbs
                    if(is_array($additionalThumbs))
                    {
                        foreach($additionalThumbs as $key => $val)
                        {
                            @unlink($this->Data['P_Upload']. '/'. $key. '_'. $fileName);
                        }
                    }
                }
            }
        }
        else
        {
            if(!empty($fileList))
            {
                $fileName = $fileList;
                @unlink($this->Data['P_Upload']. '/'. $fileName);

                if($isPicture)
                {
                    @unlink($this->Data['P_Upload']. '/'. 'small_'. $fileName);
                    @unlink($this->Data['P_Upload']. '/'. 'medium_'. $fileName);
                    @unlink($this->Data['P_Upload']. '/'. 'big_'. $fileName);

                    # Additional Thumbs
                    if(is_array($additionalThumbs))
                    {
                        foreach($additionalThumbs as $key => $val)
                        {
                            @unlink($this->Data['P_Upload']. '/'. $key. '_'. $fileName);
                        }
                    }
                }
            }
        }
    }

    #=========================================================================================================================
    #	Function Name		:	getUniqueFilePrefix
    #	Purpose				:	Get Unique filename
    #	Return				:	Unique filename based on time
    #-------------------------------------------------------------------------------------------------------------------------
    function getUniqueFilePrefix()
    {
        list($usec, $sec)	= explode(" ",microtime());
        list($trash, $usec)	= explode(".",$usec);

        return (date("YmdHis").substr(($sec + $usec), -10).'-');
    }
}
?>