<?php
class DAO{

    protected $_daStruct 	= array();

    protected function __construct(){}

    final public function __clone() {
        throw new Exception(__CLASS__ . ' class can\'t be instantiated. Please use the method called getInstance.');
    }

    public function viewAll($arrParams, $addWhere='', $customSelect='') {

        global $objDB;

        $arrReturn = array();

        $arrPageSize = StaticArray::arrPageSize();
        $arrParams['page_size'] = $arrParams['page_size'] ? $arrParams['page_size'] : $arrPageSize[2];	//RESULT_PAGESIZE;
        $startRecord 			= ((intval($arrParams['page_current']) ? intval($arrParams['page_current']) : 1 ) - 1) * $arrParams['page_size'];

        $sortBy 	= '';
        $sordDir 	= 'ASC';

        if($arrParams['sort_order'] != '')
            $sortBy 	= $arrParams['sort_order'];
        elseif($this->_daStruct['SortBy'] != '')
            $sortBy 	= $this->_daStruct['SortBy'];

        if($arrParams['sort_dir'] != '')
            $sordDir 	= $arrParams['sort_dir'];
        elseif($this->_daStruct['SortDir'] != '')
            $sordDir 	= $this->_daStruct['SortDir'];

        $arrReturn['pageSize'] 	= $arrParams['page_size'];

        $sql =	" SELECT count(*) as cnt ".
            " FROM ". $this->_daStruct['BaseTable'];

        $sql .= " WHERE 1 ". $addWhere;

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        # Execute query
        $rs = $objDB->query($sql);
        $rs->next_record();

        $arrReturn['totalRecord'] = $rs->f("cnt");
        $count = count($rs->fetch_array());
        $arrReturn['total_record'] = $count;
        $rs->free();

        if (!isset($arrParams['allRecord']) || isset($arrParams['allRecord']) && $arrParams['allRecord'] == true)
        {
            if($startRecord >= $arrReturn['totalRecord'] || $arrParams['page_size'] >= $arrReturn['totalRecord'] || !isset($startRecord))
                $startRecord = 0;
        }

        $arrReturn['startRecord'] = $startRecord;

        $sql =  " SELECT * ".
            " FROM ". $this->_daStruct['BaseTable'].
            " WHERE 1 ". $addWhere .$customSelect;

        if($sortBy != '') {
            $sql .=  " ORDER BY ". $sortBy.' '. $sordDir;
        }

        if (!$arrParams['allRecord'])
            $sql .=  " LIMIT ". $startRecord. ", ". $arrParams['page_size'];

        //echo $sql;die;
        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $arrReturn['rsData'] = $objDB->query($sql);
        $arrReturn['totalFetched'] = $arrReturn['rsData']->TotalRow;

        return $arrReturn;
    }

    public function getAll($addWhere='', $fieldCustomSelect='') {

        global $objDB;

        $selectField = !empty($fieldCustomSelect) ? $fieldCustomSelect : (!empty($this->_daStruct['BasicSelect']) ? $this->_daStruct['BasicSelect'] : " * ");

        $sql	= " SELECT ". $selectField
            . " FROM ". $this->_daStruct['BaseTable']
            . " WHERE 1 "
            . (!empty($addWhere)? $addWhere :'');

        if ($this->_daStruct['SortBy']!='')
            $sql .= " ORDER BY ". $this->_daStruct['SortBy']. " ASC ";

        # Note [MS|02 August, 2013]: required better debugging system
        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        return $objDB->query($sql);
    }

    public function getInfoByParam($param, $fieldCustomSelect='',$type=MYSQLI_FETCH_SINGLE) {
        global $objDB;

        $selectField = !empty($fieldCustomSelect) ? $fieldCustomSelect : (!empty($this->_daStruct['BasicSelect']) ? $this->_daStruct['BasicSelect'] : " * ");

        $sql	= " SELECT ".$selectField
            . " FROM ". $this->_daStruct['BaseTable']
            . " WHERE 1 ". $param;

        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $rs = $objDB->query($sql);

        return ($rs->fetch_array(MYSQLI_FETCH_SINGLE));
    }

    public function getInfoById($id, $fieldCustomSelect='')  {
        global $objDB;

        if(is_array($id))
            $idList = implode("','", $id);
        else
            $idList = $id;

        $selectField = !empty($fieldCustomSelect) ? $fieldCustomSelect : (!empty($this->_daStruct['F_BasicSelect']) ? $this->_daStruct['F_BasicSelect'] : " * ");

        $sql	= " SELECT ". $selectField
            . " FROM ". $this->_daStruct['BaseTable']
            . " WHERE ". $this->_daStruct['PrimaryKey']. " IN ('". $idList. "') ";

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $rs = $objDB->query($sql);

        return ($rs->fetch_array(is_array($id)?'':MYSQLI_FETCH_SINGLE));
    }

    public function getKeyValueArray($addWhere='') {

        $rs = $this->getAll($param, $this->_daStruct['PrimaryKey']. ", ". $this->_daStruct['PrimaryField']);

        $arrReturn = array();

        while($rs->next_record())
        {
            $arrReturn[$rs->f($this->_daStruct['PrimaryKey'])]  = $rs->f($this->_daStruct['PrimaryField']);
        }

        return $arrReturn;
    }

    public function getCount($addWhere='') {
        global $objDB;

        $sql =	" SELECT count(*) as cnt ".
            " FROM ". $this->_daStruct['BaseTable'];

        $sql .= " WHERE 1 ". $addWhere;

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        # Execute query
        $rs = $objDB->query($sql);
        $rs->next_record();

        return $rs->f("cnt");
    }

    public function Insert($POST) {
        global $objDB;

        $sql = $this->getInsertQuery($this->_daStruct['BaseTable'], $this->_daStruct['FieldInfo'], $POST);

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        # Execute query
        //$rs = $objDB->query($sql);
        $objDB->query($sql);
        return ($objDB->sql_inserted_id());
    }

    public function Update($pk, $POST) {
        global $objDB;

        $sql = $this->getUpdateQuery(	$this->_daStruct['BaseTable'],
            $this->_daStruct['FieldInfo'],
            $POST,
            $this->_daStruct['PrimaryKey']."='$pk'"
        );

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        # Execute query
        return $rs = $objDB->query($sql);
    }

    public function getInsertQuery($TableName, $FieldInfo, $POST)
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

    function getFieldsValue($FieldInfo, $POST)
    {   global $arrOREPhysicalPath;
        //echo "<pre>";print_r($POST);die;
        foreach ($FieldInfo as $fieldName => $params)
        {
            if(isset($POST[$fieldName]) || isset($_FILES[$fieldName]) || $params['c_type'] == 'picfile' || $params['c_type'] == 'checkbox')
            {
                if($params['c_type'] == 'date_picker')
                {
                    $FieldsValue[$fieldName] = date('Y-m-d', strtotime(str_replace(",", "", $POST[$fieldName])));
                }
                elseif($params['c_type'] == 'picfile')
                {
                    $FieldsValue[$fieldName] = Utility::uploadFile($_FILES[$fieldName], $params['upload'], $POST['prev_'.$fieldName],'',isset($POST['del_'.$fieldName])?$_POST['del_'.$fieldName]:'');

                }
                elseif($params['c_type'] == 'date_time_picker')
                {
                    if($POST[$fieldName] != '')
                    {
                        if($POST[$fieldName. 'Hour'] != ''){
                            if($POST[$fieldName. 'Meridian'] == 'pm')
                                $hour = $POST[$fieldName. 'Hour'] + 12;
                            else
                                $hour = $POST[$fieldName. 'Hour'];

                            $FieldsValue[$fieldName] = date('Y-m-d', strtotime(str_replace(",", "", $POST[$fieldName]))).' '.$hour.':'.$POST[$fieldName. 'Minute'].':'.$POST[$fieldName. 'Second'];
                        }
                        else {
                            $FieldsValue[$fieldName] = date('Y-m-d H:i:s', strtotime(str_replace(",", "", $POST[$fieldName])));
                        }
                    }
                }
                elseif(is_array($POST[$fieldName]))
                    $FieldsValue[$fieldName] = implode(",", $POST[$fieldName]);
                else
                {
                    $FieldsValue[$fieldName] = trim($POST[$fieldName]);
                }

                # Empty ?
                if(empty($FieldsValue[$fieldName]) && isset($params['c_datatype']))
                {
                    $FieldsValue[$fieldName] = $this->getFieldDefaultValue($params['c_datatype']);
                }
            }
        }


        return $FieldsValue;
    }

    function getEditFieldInfo($rsRecord, $FieldInfo)
    {
        foreach($FieldInfo as $key => $val)
        {
            if(array_key_exists($key, $rsRecord))
            {
                $FieldInfo[$key]['sel_val'] = $rsRecord[$key];

                /*if(is_array($FieldInfo[$key][OPTION]))
                {
                    $FieldInfo[$key][SEL_TEXT] = $this->getArrayValue($FieldInfo[$key][SEL_VAL], $FieldInfo[$key][OPTION]);
                }*/
            }
        }

        return $FieldInfo;
    }

    public function Delete($id, $retField='') {

        global $objDB;

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
                . " FROM ". $this->_daStruct['BaseTable']
                . " WHERE ". $this->_daStruct['PrimaryKey']. " IN ('". $idList. "') ";

            # Show debug info
            if(WP_DEBUG)
                $this->__debugMessage($sql);

            $rs = $objDB->query($sql);

            $retValue = array();

            while($rs->next_record())
            {
                if($rs->f($retField) != '')
                    array_push($retValue, $rs->f($retField));
            }
        }

        # Define query
        $sql = 	" DELETE FROM ". $this->_daStruct['BaseTable'].
            " WHERE ". $this->_daStruct['PrimaryKey']. " IN ('". $idList. "') ";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        $objDB->query($sql);

        return $retValue;
    }

    public function uploadFile($File, $prevFileName, $createThumb=false, $deletePrevFile=true)
    {
        global $config, $asset;

        //list($filename, $extension) = explode(".", $File['name']);
        $extension = substr(strrchr($File['name'], "."), 1);
        # Clean filename and make unique name
        /*		$destFile = str_replace(" " , "-", $File['name']);  	//convert spaces to a dash
                $destFile = str_replace("_" , "-", $File['name']);  	//convert underscore to a dash
                $destFile = preg_replace("/-+/" , "-", $destFile);  	//convert multiple dashes to a single dash
                $destFile = strtolower(OREUtility::getUniqueFilePrefix(). preg_replace("#[^a-z0-9.-]#i", "", $destFile));		*/

        $destFile = trim(Utility::getUniqueFilePrefix(), "-"). ".". strtolower($extension);

        /* Define upload folder */
        $destFolder	= $this->_daStruct['P_Upload']. '/';

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

    function isSlugExists($value='', $exclude_key='')
    {
        if ( $value ) {
            #set parameter
            $param = " AND ". $this->_daStruct['Slug']." = '".$value."'";

            #exclue primary key if not null
            if ( $exclude_key != "" ) {
                $param .= " AND ".$this->_daStruct['PrimaryKey']." != ".$exclude_key;
            }

            $rs = $this->getAll($param);

            if ($rs->TotalRow > 0)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    public function getInfoBySlug($slug, $fieldCustomSelect='')  {
        global $objDB;

        $selectField = !empty($fieldCustomSelect) ? $fieldCustomSelect : (!empty($this->_daStruct['F_BasicSelect']) ? $this->_daStruct['F_BasicSelect'] : " * ");

        $sql	= " SELECT ". $selectField
            . " FROM ". $this->_daStruct['BaseTable']
            . " WHERE ". $this->_daStruct['Slug']. " = '". $slug. "'";

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $rs = $objDB->query($sql);

        return ($rs->fetch_array(MYSQLI_FETCH_SINGLE));
    }
    /**
     * Note [MS|Friday, August 16, 2013]
     * http://dev.MYSQLI.com/doc/MYSQLId-version-reference/en/MYSQLId-version-reference-reservedwords-5-5.html
     * Need to add validation so that reserved word not used as field name
     **/
    final public function formatStringForFieldName($str) {

        $str = preg_replace('/[^a-zA-Z0-9_]+/', '_', $str);	/* Make alph numerical string */
        $str = preg_replace('/-+/', '_', $str);  			/* convert multiple dashes to a single dash */
        $str = substr($str, 0, 64);
        $str = strtolower(trim($str, '_'));

        return $str;
    }

    final public function getFieldMaxLength($fieldType, $fieldLength) {

        $fieldMaxLength = '';

        switch($fieldType) {

            case 'tinyint':
                $fieldMaxLength = 3;
                break;
            case 'smallint':
                $fieldMaxLength = 6;
                break;
            case 'mediumint':
                $fieldMaxLength = 9;
                break;
            case 'int':
                $fieldMaxLength = 12;
                break;
            case 'bigint':
                $fieldMaxLength = 20;
                break;
            case 'char':
                if($fieldLength != '') {
                    $fieldMaxLength = intval($fieldLength);
                } else {
                    $fieldMaxLength = 5;
                }
                break;
            case 'varchar':
                if($fieldLength != '') {
                    $fieldMaxLength = intval($fieldLength);
                } else {
                    $fieldMaxLength = 255;
                }
                break;
            case 'decimal':
            case 'float':
            case 'double':
            case 'real':
                if($fieldLength != '') {
                    $fieldMaxLength = $fieldLength;
                }
                break;
            case 'date':
            case 'datetime':
            case 'tinytext':
            case 'text':
            case 'mediumtext':
            case 'longtext':
                $fieldMaxLength = '';
                break;
        }

        return $fieldMaxLength;
    }

    final public function getFieldDefaultValue($fieldType) {

        $fieldDefaultVal = '';

        switch($fieldType) {

            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'int':
            case 'bigint':
            case 'decimal':
            case 'float':
            case 'double':
            case 'real':
                $fieldDefaultVal = '0';
                break;
            case 'char':
            case 'varchar':
                $fieldDefaultVal = '';
                break;
            case 'tinytext':
            case 'text':
            case 'mediumtext':
            case 'longtext':
                $fieldDefaultVal = false;
                break;
            case 'date':
                $fieldDefaultVal = '0000-00-00';
                break;
            case 'datetime':
                $fieldDefaultVal = '0000-00-00 00:00:00';
                break;
        }

        return $fieldDefaultVal;
    }

    final public function __debugMessage($message) {

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

    public function ReadFilter($key = '', $defArr='')
    {
        if($key)
            $cookieKey = md5($key);
        else
            $cookieKey = md5($_SERVER['PHP_SELF']);

        if($_POST['Filter'])
        {
            foreach($_POST as $key=>$val)
            {
                if(!empty($val))
                    $this->filter[$key]		=	$val;
            }
        }

        elseif($_POST['ShowAll'])
        {
            $this->filter = array();
            # Want to some default criteria ?
            if(is_array($defArr))
            {
                foreach($defArr as $key=>$val)
                {
                    $this->filter[$key]		=	$val;
                }
            }

        }
        elseif (@strpos($_SERVER['HTTP_REFERER'], $_SERVER['PHP_SELF']) !== false)
        {
            # Set filter
            $this->filter = unserialize(urldecode($_COOKIE[$cookieKey]));
        }

        # Save filter criteria
        @setcookie($cookieKey, urlencode(serialize($this->filter)), time()+12*3600);
    }




}
?>