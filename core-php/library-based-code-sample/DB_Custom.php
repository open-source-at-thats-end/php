<?php
/**
 * @author OEqual - Niravraj Parmar
 * @date 23 May 2013
 * @package PDO & pdo-2.1 & DB_Custom
 *
 * @last-modified Sun 10 January 2016 12:38:48 PM
 * @last-modified-by OEqual - Niravraj Parmar
 *
 * @filename DB_Custom.php
 * @language-base No
 * @version 1.1
 *
 * DB_Custom is a database access library, contains in built sql query structure to use.
 * This class library is based on pdo-2.2 library.
 * Class required some constants. Those will be found in [includes/constants.php] under NOTICE : DB_Custom constants
 */
abstract class DB_Custom
{
    public $DBC; # DataBase Connection
    public $Data           =    array();
    public $filter	       =    array();
    public $page_size;
	public $start_record;
	public $so;
	public $sd;
	public $alpha;
	public $total_record;
    public $Error;
    public $ActionLog       =   true;
    public $DBErrorLog      =   true;
	public $TablePartition  =   false;

    /**
     * DB_Custom::__construct()
     * @return none
     *
     * @__construct set field values in field info array if found in POST variable
     */
    public function __construct()
    {
	    # Manipulate partition for current module
        $this->set_partition_with_table_name();

	    # Update post data
        if(isset($this->Data[F_F_INFO]) && is_array($this->Data[F_F_INFO]) && (!isset($_POST['Search_Filter']) && count($_POST) > 0))
        {
			foreach($this->Data[F_F_INFO] as $key => $val)
            {
                if(array_key_exists($key, $_POST))
                    $this->Data[F_F_INFO][$key][SEL_VAL] = $_POST[$key];
            }
        }
    }
	/**
	 * DB_Custom::set_partition_with_table_name()
	 * @return none
	 *
	 * @set_partition_with_table_name set up partition info for module
	 * @param $partition = name of partition to set with database table name
	 */
	public function set_partition_with_table_name($partition=false)
	{
		if($partition == false || empty($partition))
			$partition = $this->TablePartition;

		if(isset($this->Data[F_PARTITION_FIELD]) && $partition != false && !empty($partition))
		{
			$this->Data[O_TABLE_NAME]   =   $this->Data[TABLE_NAME];
			$this->Data[TABLE_NAME]     =   $this->Data[O_TABLE_NAME]. ' PARTITION('.$partition.')';
		}
	}
	public function set_partition_name($partition)
	{
		$this->unset_partition_name();

		$this->TablePartition = $partition;

		$this->set_partition_with_table_name();
	}
	public function unset_partition_name()
	{
		$this->TablePartition = false;

		$this->reset_table_name();
	}
	/**
	 * DB_Custom::reset_table_name()
	 * @return none
	 *
	 * @reset_table_name reset table name to original
	 */
	public function reset_table_name()
	{
		if(isset($this->Data[O_TABLE_NAME]))
			$this->Data[TABLE_NAME] = $this->Data[O_TABLE_NAME];
	}
	/**
     * DB_Custom::ViewAll()
     * @param string $addParameters = false | query string (i.e: AND field_name = field_value)
     * @param array $value = false | array(key => value) to prepare statement
     * @param bool $allRecord = false | true to get all recordes
	 * @param array $Custom_Param = false | key => value array
     * @return record set
     *
     * @ViewAll create sql statement, execute it and return record set
     */
    public function ViewAll($addParameters=false, $value=false, $Join=false, $Custom_Param=false, $allRecord=false)
    {
        $F_PrimaryField     =   isset($this->Data[F_P_FIELD])?$this->Data[F_P_FIELD]:'';
	    $default_F_Sort     =   isset($this->Data[F_SORT])?$this->Data[F_SORT]:'';

	    $sql = $this->getSelectQuery(   $this->Data[TABLE_NAME],
		                                $F_PrimaryField,
		                                $addParameters,
		                                $value,
		                                $Join,
		                                $Custom_Param,
	                                    $allRecord,
		                                $default_F_Sort,
		                                (isset($this->Data[F_H_ITEM])?$this->Data[F_H_ITEM]:false)
	                                );

        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

        $rs = $this->DBC->run_query($sql,$value);

        return $rs;
	}
    /**
     * DB_Custom::getAll()
     * @param string $addParameters = sql query string
     * @param array $value = false | array(key => value) for sql query
     * @param array $Custom_Param = false | key => value array
     * @return record set
     *
     * @getAll get recordset for all data as per given parameter
     */
    public function getAll($addParameters=false, $value=false, $Join=false, $Custom_Param=array())
    {
        $selectField = isset($Custom_Param[F_B_SELECT])?$Custom_Param[F_B_SELECT]:(!empty($this->Data[F_B_SELECT]) ? $this->Data[F_B_SELECT] : " * ");

		$sql	= "/*Code removed*/";

	    if (isset($Custom_Param[GROUP_BY]) && !empty($Custom_Param[GROUP_BY]))
		    $sql .= " GROUP BY ".$Custom_Param[GROUP_BY]." ";

	    if(isset($Custom_Param[HAVING]) && !empty($Custom_Param[HAVING]))
		    $sql .= " HAVING ".$Custom_Param[HAVING]." ";

        if(isset($Custom_Param[CUST_SORT_ORDER_STR]) && !empty($Custom_Param[CUST_SORT_ORDER_STR]))
            $sql .= $Custom_Param[CUST_SORT_ORDER_STR];
        elseif(isset($this->Data[F_SORT]) && !empty($this->Data[F_SORT]))
			$sql .= " ORDER BY ". $this->Data[F_SORT]. " ASC ";

        # Check for given limit
        if(isset($Custom_Param[SQL_LIMIT]) && !empty($Custom_Param[SQL_LIMIT]))
            $sql .= " LIMIT ".$Custom_Param[SQL_LIMIT];

        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

		$rs   =   $this->DBC->run_query($sql,$value);

        return $rs;
	}
	/**
	 * DB_Custom::getAllWithFormat()
	 * @param string $addParameters = sql query string
	 * @param array $value = false | array(key => value) for sql query
	 * @param array $Custom_Param = false | key => value array
	 * @param function | bool $call_function = false | call back function to do some manipulation
	 * @return array of all data as per passes argument in list and in tree format and other if call back function is passes
	 *
	 * @getAllWithFormat get all data as per given parameter. It recursive logic. Save multiple databse call
	 */
	public function getAllWithFormat($addParameters=false, $value=false, $Join=false, $Custom_Param=false, $call_function=false)
	{
		$rs = $this->getAll($addParameters, $value, $Join, $Custom_Param);
        $arr = $rs->fetch_record();

		$arrList=array();$arrTree=array();$arrOther=array();

		if($call_function == false) $call_function = function(){};

		foreach($arr as $k => $info)
		{
			$id = $info[$this->Data[F_P_KEY]];

			$arrList[$id] = $info;

			if(isset($this->Data[F_PARENT_FIELD]) && $info[$this->Data[F_PARENT_FIELD]] == '0')
			{
				$arrTree[$id][$this->Data[F_P_KEY]] = $id;

				# Check for any child
				$child = $this->getAllChildWithFormat($arr, $id);
				if(is_array($child) && count($child) > 0){$arrTree[$id]['child'] = $child;}
			}

			# If some other manipulation required then do it
			$call_function($k, $info, $arr, $arrOther);
		}
		return array('list'=>$arrList, 'tree'=>$arrTree, 'other'=>$arrOther);
	}
	/**
	 * DB_Custom::getAllChildWithFormat()
	 * @param array $arrData = Data in array form to manipulate
	 * @param int $parent_id = parent id to manipulate with it
	 * @return array of all child data based on given parent id
	 *
	 * @getAllChildWithFormat get all data as per given parameter. It is for recursive logic. This method is not independent. It is require for getAllWithFormat
	 */
	public function getAllChildWithFormat($arrData, $parent_id)
	{
		if(!is_array($arrData) || count($arrData) <= 0) return false;

		$arrTree = array();
		foreach($arrData as $k => $info)
		{
			$id = $info[$this->Data[F_P_KEY]];
			$p_id = $info[$this->Data[F_PARENT_FIELD]];

			if($p_id == $parent_id)
			{
				$arrTree[$id][$this->Data[F_P_KEY]] = $id;

				# Check for any child
				$SubChild = $this->getAllChildWithFormat($arrData,$id);
				if(is_array($SubChild) && count($SubChild) > 0)
					$arrTree[$id]['child'] = $SubChild;
			}
		}
		return $arrTree;
	}
    /**
     * DB_Custom::getInfoById()
     * @param mixed $id = single id | array of ids
     * @param string $F_CustomSelect = false | name of fields to select. Comma (,) separated
     * @parem string $index_key = name of database table filed to set as index for each record
     * @return array of data
     *
     * @getInfoById execute sql query as per given parameter and return array of data
     */
    public function getInfoById($id, $F_CustomSelect=false, $index_key=false)
    {
        if(!is_array($id))
            $id = array($id);

        $count  = count($id);
        $idList = rtrim(str_repeat("?,",$count),",");

		$selectField = !empty($F_CustomSelect) ? $F_CustomSelect : (!empty($this->Data[F_B_SELECT]) ? $this->Data[F_B_SELECT] : " * ");

        $sql	= " SELECT ". $selectField
				. " FROM ". $this->Data[TABLE_NAME]
				. " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";

		# Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

		$rs     =   $this->DBC->run_query($sql,$id);
        $data   =   $rs->fetch_record(($count == 1)?PDO_FETCH_SINGLE:PDO_FETCH_ALL, $result_type = PDO_FETCH_ASSOC, $index_key);

		return $data;
	}
    /**
     * DB_Custom::getInfoByParam()
     * @param string $param = sql query string
     * @param array $value = array(key => value) for sql query
     * @param string $F_CustomSelect = custome selection field
     * @param string $Join = sqo quesry for join part
     * @param const $type = PDO_FETCH_SINGLE | PDO_FETCH_ALL
     * @parem string $index_key = name of database table filed to set as index for each record
     * @return array of data
     *
     * @getInfoByParam execute sql query as per given parameter and return array of data
     */
    public function getInfoByParam($param=false, $value=false, $F_CustomSelect=false, $Join=false, $type=PDO_FETCH_SINGLE, $index_key=false)
    {
	    $selectField = !empty($F_CustomSelect) ? $F_CustomSelect : (!empty($this->Data[F_B_SELECT]) ? $this->Data[F_B_SELECT] : " * ");

	    $sql	= " SELECT ". $selectField
		    . " FROM ". $this->Data[TABLE_NAME] ." MTBL ".$Join
		    . " WHERE ". $param;

        # Show debug info
	    if(defined('DEBUG'))
		    $this->__debugMessage($sql);

	    $rs   =   $this->DBC->run_query($sql, $value);
        $data =   $rs->fetch_record($type, $result_type = PDO_FETCH_ASSOC, $index_key);

	    return $data;
    }
    /**
     * DB_Custom::getCount()
     * @param string $param = string sql query
     * @param array $value = false | array(key => value) for sql query
     * @return count of number of records
     *
     * @getCount count number of records for givem parameter
     */
    public function getCount($param = '', $value = false)
    {
		$sql	= " SELECT count(*) as 'count' "
				. " FROM ". $this->Data[TABLE_NAME]." MTBL "
				. " WHERE 1 ".$param;

		# Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

		$rs = $this->DBC->run_query($sql, $value);
        $rs->next_record();
        $count = $rs->f('count');

        return $count;
	}
    /**
     * DB_Custom::getKeyValueArray()
     * @param string $param = false | sql query string
     * @param bool $value = false | array(key => value) for sql query
     * @param bool $encrypt = false | whether encrypt key or not
     * @return array(key => value)
     *
     * @getKeyValueArray get record for primary key & primary field as per given parameter.
     * Set data as a key primary_key => primary_field value array
     */
    public function getKeyValueArray($param=false, $value=false, $encrypt=false)
    {
        # Set basic select fields
        $Custom_Param[F_B_SELECT] = $this->Data[F_P_KEY]. ", ". $this->Data[F_P_FIELD];
        $rs             = $this->getAll($param, $value, $Join=false, $Custom_Param);

        if($rs->TotalRow > 0)
        {
            while($rs->next_record())
                $arr[($encrypt===false)?$rs->f($this->Data[F_P_KEY]):Ocrypt::enc($rs->f($this->Data[F_P_KEY]))]  = $rs->f($this->Data[F_P_FIELD]);

            return $arr;
        }
        return false;
    }

    /**
     * DB_Custom::TruncateTable()
     * @param bool $value = false | array(key => value) for sql query
     * @return array(key => value)
     *
     * @TruncateTable() Truncate the Table which are given in param.
     */
    public function TruncateTable($table_name)
    {
        global $asset;
        try
    	{
    		$total_records = $this->DBC->truncate_table($table_name);

            # Add user action log
            if($this->ActionLog === true)
                AdminLog::obj()->AddActionLog(A_TRUNCATE_TABLE,false,false,array("TotalDeletedRecord" => $total_records));

            return $total_records;
        }
    	catch(Exception $e)
    	{
            #Error Log Action
            if($this->DBErrorLog === true)
                ErrorLog::obj()->AddErrorLog(A_TRUNCATE_TABLE, $e->getMessage());

            $db_e = unserialize($e->getMessage());
    		if(!isset($config['OnLocal']))
    			$this->Error[E_DESC] = 'Sorry, Unable to truncate your table.Check your details and try again.';
    		else
    			$this->Error[E_DESC] = $db_e['ProgramError'];
    	}
    }
	/**
	 * DB_Custom::ServerSideValidation()
	 * @param array $POST array of post value from user
	 * @param array $F_FieldInfo = false | field info array
	 * @return true | false
	 *
	 * @ServerSideValidation check for valid user input as per pre defined validation flag.
	 */
	public function ServerSideValidation($POST, $F_FieldInfo = false, $ReturnValidPOST = false)
	{
        global $config;

		if($config['enable_serverside_validation'] == NO)
			return true;

		if($F_FieldInfo==false && isset($this->Data[F_F_INFO]) && is_array($this->Data[F_F_INFO]))
			$F_FieldInfo = $this->Data[F_F_INFO];

        if(!is_array($F_FieldInfo))
			return false;

		if(isset($this->Data[F_PARENT_FIELD]))
		  	$PField = str_replace($this->Data[FIELD_PREFIX],'',$this->Data[F_PARENT_FIELD]);

		$e_error = null;
		foreach ($F_FieldInfo as $Fname => $Finfo)
		{
			if(!isset($Finfo[GROUP_TITLE]))
			{
				$title = isset($Finfo[TITLE])?$Finfo[TITLE]:(isset($POST[$Fname])?$POST[$Fname]:'');

				if(isset($Finfo[VALIDATE]) && $Finfo[VALIDATE] == true)
				{
					$error = null;

					if($Finfo[VAL_TYPE]&V_EMPTY)
					{
                        if($Finfo[CNT_TYPE] == C_PICFILE || $Finfo[CNT_TYPE] == C_FILE)
                        {
                            if(!isset($_FILES[$Fname]) || empty($_FILES[$Fname]['name']))
                                $error .= "Field is required. Upload a valid file.";
                        }
                        else
                        {
                            if(!isset($POST[$Fname]) || $POST[$Fname] == '')
                                $error .= "Field is required. ";
                        }
					}
					if($Finfo[VAL_TYPE]&V_EMPTYFILE && empty($_FILES[$Fname]['name']))
					{
                        if(isset($POST['prev_'.$Fname]) && empty($POST['prev_'.$Fname]))
                        {
                            $error .= "File upload is required. ";
                        }
                        elseif(isset($POST['del_'.$Fname]))
                        {
                            $error .= "You are trying to delet existing file but not uploading new file. ";
                        }
					}
					if($Finfo[VAL_TYPE]&V_EXTENTION && !empty($_FILES[$Fname]['name']))
					{
						$ValidExt   =   explode("|",$Finfo[VAL_EXT]);
						$ext        =   ".".strtolower(pathinfo($_FILES[$Fname]['name'],PATHINFO_EXTENSION));

						if(!in_array($ext,$ValidExt))
							$error .= "Upload a valid file. ".$Finfo[VAL_EXT]." are allowed.";
					}
                    if($Finfo[VAL_TYPE]&V_IMG_WH && !empty($_FILES[$Fname]['tmp_name']))
                    {
                        list($w,$h) = getimagesize($_FILES[$Fname]['tmp_name']);
                        $e = '';
                        if(isset($Finfo[VAL_IMG_WIDTH]) && $Finfo[VAL_IMG_WIDTH] !== $w)
                        {
                            $e .= " width must be ".$Finfo[VAL_IMG_WIDTH]." Pixel";
                        }
                        if(isset($Finfo[VAL_IMG_HEIGHT]) && $Finfo[VAL_IMG_HEIGHT] !== $h)
                        {
                            $e .= " height must be ".$Finfo[VAL_IMG_HEIGHT]." Pixel";
                        }

                        if($e != ''){$error .= "Image ".$e.".";}
                    }
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_MAXLEN && isset($Finfo[VAL_MAXLEN]) && strlen($POST[$Fname]) > $Finfo[VAL_MAXLEN])
					{
						$error .= "Maximum allowed string length is ".$Finfo[VAL_MAXLEN]." ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_MAX && isset($Finfo[VAL_MAX]) && strlen($POST[$Fname]) > $Finfo[VAL_MAX])
					{
						$error .= "Enter a value less than or equal to ".$Finfo[VAL_MAX]." ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_MINLEN && isset($Finfo[VAL_MINLEN]) && strlen($POST[$Fname]) < $Finfo[VAL_MINLEN])
					{
						$error .= "Enter at least ".$Finfo[VAL_MINLEN]." characters. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_MIN && isset($Finfo[VAL_MIN]) && strlen($POST[$Fname]) < $Finfo[VAL_MIN])
					{
						$error .= "Enter a value greater than or equal to ".$Finfo[VAL_MIN]." ";
					}
					/*if($Finfo[VAL_TYPE]&V_CHAR_RANGE && isset($Finfo[VAL_CHAR_RANGE]))
					{

					}
					if($Finfo[VAL_TYPE]&V_VALUE_RANGE && isset($Finfo[VAL_VALUE_RANGE]))
					{

					}
					if($Finfo[VAL_TYPE]&V_URL_FRIENDLY)
					{

					}*/
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_PHONE && Utility::obj()->ValidatePhoneNumber($POST[$Fname]) !== true)
					{
						$error .= "Enter a valid contact number. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_EMAIL && (filter_var($POST[$Fname], FILTER_VALIDATE_EMAIL) == false || Utility::obj()->ValidateEmail($POST[$Fname]) == false))
					{
						$error .= "Enter a valid email address. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_URL && filter_var($POST[$Fname], FILTER_VALIDATE_URL) == false)
					{
						$error .= "Enter a valid URL. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_ALPHANUMERIC && preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $POST[$Fname])==false)/*ctype_alnum()*/
					{
						$error .= "Enter a valid alphanumeric value. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_NO_SPACE && strpos($POST[$Fname],' ') !== false)
					{
						$error .= "No white space allowed. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_INT && filter_var($POST[$Fname], FILTER_VALIDATE_INT) === false)
					{
						$error .= "Enter a valid integer value. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_FLOAT && filter_var($POST[$Fname], FILTER_VALIDATE_FLOAT) === false)
					{
						$error .= "Enter a valid float value. ";
					}
					if(!empty($POST[$Fname]) && ($Finfo[VAL_TYPE]&V_IP4 || $Finfo[VAL_TYPE]&V_IP6) && filter_var($POST[$Fname], FILTER_VALIDATE_IP) == false)
					{
						$error .= "Enter a valid IP address. ";
					}
					if(!empty($POST[$Fname]) && $Finfo[VAL_TYPE]&V_STR && is_string($POST[$Fname]) == false)
					{
						$error .= "Enter a valid string value. ";
					}
					if($Finfo[VAL_TYPE]&V_EQUALTO && isset($Field[VAL_EQUALTO]) && $POST[$Fname] != $POST[$Field[VAL_EQUALTO]])
					{
						$error .= "Is not equal to with ".$F_FieldInfo[$Field[VAL_EQUALTO]][TITLE].". ";
					}
					if($error !== null)
					{
						$e_error .= "<b>".$title."</b>: ".$error." ";
					}
				}

				# Some other validation
				/*if(isset($this->Data[F_PARENT_FIELD]) && $PField == $Fname && $POST[$Fname] == $POST['pk'])*/
                if(isset($this->Data[F_PARENT_FIELD]) && $PField == $Fname && isset($POST[$Fname]) && (isset($POST['pk']) && is_numeric($POST['pk'])) && ($POST[$Fname] == $POST['pk']))
				{
					$e_error .= "<b>".$title."</b>: You cannot select self record as a parent. ";
				}
				elseif(!empty($POST[$Fname]) && ($Finfo[CNT_TYPE] == C_DATE_PICKER || $Finfo[CNT_TYPE] == C_DATE_RANGE) && isset($Finfo['MinDate']))
				{
					$cur_date =  strtotime(date('Y-m-d', strtotime($POST[$Fname])));
					$min_date =  strtotime(date('Y-m-d', strtotime($Finfo['MinDate'])));

					if($cur_date < $min_date)
						$e_error .= "Minimum date selection range is ".date('d M Y', strtotime($Finfo['MinDate']))." ";
				}
				elseif(!empty($POST[$Fname]) && ($Finfo[CNT_TYPE] == C_DATE_PICKER || $Finfo[CNT_TYPE] == C_DATE_RANGE) && isset($Finfo['MaxDate']))
				{
					$cur_date =  strtotime(date('Y-m-d', strtotime($POST[$Fname])));
					$max_date =  strtotime(date('Y-m-d', strtotime($Finfo['MaxDate'])));

					if($cur_date > $max_date)
						$e_error .= "Maximum date selection range is ".date('d M Y', strtotime($Finfo['MaxDate']))." ";
				}
				elseif(!empty($POST[$Fname]) && $Finfo[CNT_TYPE] == C_CURRENCY)
				{
					$currency = str_replace(',','',$POST[$Fname]);
					$arr_currency = explode('.',$currency);
					if(!is_numeric($currency))
					{
						$e_error .= "<b>".$title."</b>: Invalid amount value.";
					}
					if(strlen($arr_currency[0]) > 20)
					{
						$e_error .= "<b>".$title."</b>: Amount value exceed the maximum length.";
					}
				}
				if($ReturnValidPOST === true && empty($e_error))
					$ValidPOST[$Fname] = isset($POST[$Fname])?$POST[$Fname]:'';
			}
		}
        if($e_error !== null)
		{
			$this->Error[E_DESC] = $e_error;
			return false;
		}
		else
		{
			if($ReturnValidPOST === true)
				return $ValidPOST;
			else
				return true;
		}
	}
	/**
	 * DB_Custom::CheckWordCensoring()
	 * @param array $POST array of post value from user
	 * @param array $F_FieldInfo = false | field info array
	 * @return POST
	 *
	 * @ServerSideValidation check for valid user input as per pre defined validation flag.
	 */
	public function CheckWordCensoring(&$POST, $F_FieldInfo = false)
	{
		global $config;

		if($config['enable_word_censoring'] == NO)
			return true;

		if($F_FieldInfo==false && isset($this->Data[F_F_INFO]) && is_array($this->Data[F_F_INFO]))
			$F_FieldInfo = $this->Data[F_F_INFO];

		if(!is_array($F_FieldInfo))
			return false;

		if(!isset($_SESSION[WORD_CENSORING]))
			WordCensoring::obj()->getAllWordCensoring();

		if(isset($_SESSION[WORD_CENSORING]))
		{
			$checking_field_type    =   array(C_TEXT, C_TEXTAREA, C_RICHTEXT);
			$search                 =   $_SESSION[WORD_CENSORING]['SEARCH'];
			$replace                =   $_SESSION[WORD_CENSORING]['REPLACE'];

			foreach ($F_FieldInfo as $Fname => $Finfo)
			{
				if(isset($Finfo[CNT_TYPE]) && in_array($Finfo[CNT_TYPE], $checking_field_type) && isset($POST[$Fname]) && !empty($POST[$Fname]) && !is_array($POST[$Fname]))
					$POST[$Fname] = trim(str_ireplace($search, $replace, $POST[$Fname]));
			}
		}
		return $POST;
	}
	/**
	 * DB_Custom::CheckUniqueFieldValue()
	 * @param array $POST array of post value from user
	 * @param mix $pk = false | primary key value
	 * @param arrray $arrUniqueField = array of field names to check for unique value
	 * @param string $primary_key = databaase field name which is set at primary key
	 * @return true | false
	 *
	 * @CheckUniqueFieldValue check value in database and set error message if dupicate entry found.
	 */
	public function CheckUniqueFieldValue($POST, $pk=false, $arrUniqueField=false, $primary_key=false)
	{
		if($arrUniqueField == false)
			$arrUniqueField = isset($this->Data[F_U_FIELD])?$this->Data[F_U_FIELD]:'';

		if(!empty($arrUniqueField))
		{
		  	if(!is_array($arrUniqueField))
				$arrUniqueField = array($arrUniqueField);

            if($primary_key == false)
				$primary_key = isset($this->Data[F_P_KEY])?$this->Data[F_P_KEY]:'';

			$error = false;
			$this->Error[E_DESC] = "Duplicate entry found. ";

			foreach ($arrUniqueField as $key => $field_name)
			{
				if(is_array($field_name))
				{
					$chk=''; $val=array(); $title=''; $v='';
					foreach($field_name as $k=>$fn)
					{
						$_fn = str_replace($this->Data[FIELD_PREFIX],'',$fn);
						if(isset($POST[$_fn]))
						{
							$chk .= " AND ".$fn." = ?";
							$val[] = trim($POST[$_fn]);
						}
						$title .= isset($this->Data[F_F_INFO][$_fn][TITLE])?$this->Data[F_F_INFO][$_fn][TITLE].', ':'';
						$v .= isset($POST[$_fn])?$POST[$_fn].', ':'';
					}
					if($pk != false && !empty($primary_key))
					{
						$chk .= " AND ".$primary_key." <> ?";
						$val[]  =  $pk;
					}

					$info = $this->getAll($chk, $val);
					if($info->TotalRow != 0)
					{
						$error = true;
						if(isset($this->Data[F_F_INFO][$_fn][TITLE]))
							$this->Error[E_DESC] .= "<b>".rtrim($title,', ')."</b> ";
						else
							$this->Error[E_DESC] .= "<b>".rtrim($v,', ')."</b> ";
					}
				}
				else
				{
					$chk=''; $val=array();
					$field = str_replace($this->Data[FIELD_PREFIX],'',$field_name);

					if(isset($POST[$field]))
					{
						$chk .= " AND ".$field_name." = ?";
						$val[] = trim($POST[$field]);

						if($pk != false && !empty($primary_key))
						{
							$chk .= " AND ".$primary_key." <> ?";
							$val[]  =  $pk;
						}
						$info = $this->getAll($chk, $val);
						if($info->TotalRow != 0)
						{
							$error = true;
							if(isset($this->Data[F_F_INFO][$field][TITLE]))
								$this->Error[E_DESC] .= "<b>".$this->Data[F_F_INFO][$field][TITLE]."</b> ";
							else
								$this->Error[E_DESC] .= "<b>".$POST[$field]."</b> ";
						}
					}
				}
			}
			if($error == true)
				return false;
			else
			{
				$this->Error[E_DESC] = '';
				return true;
			}
		}
		return true;
	}
    /**
     * DB_Custom::Insert()
     * @param array $POST = array(field_name => field_value)
     * @return last insert id
     *
     * @Insert get insert query from given value.
     * Execute insert query and update it's related information
     */
    public function Insert($POST)
	{
        global $config, $asset;

		$this->Error[E_DESC] = '';

		# Check for word censoring
		$this->CheckWordCensoring($POST);

        # Check for valid user input. Server side validation
		if($this->ServerSideValidation($POST) == false)
			return false;

        # Check for unique field values. Check for any duplicate entry
		if($this->CheckUniqueFieldValue($POST) == false)
			return false;

        # Check and builder URL Friendly Name
		if (array_key_exists(F_S_URL,$this->Data) && isset($this->Data[F_S_URL]))
		{
		    $f_safe_url = str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_S_URL]);

            if (!isset($POST[$f_safe_url]) || empty($POST[$f_safe_url]))
				$POST[$f_safe_url] = $this->buildURLFriendlyName($POST[str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_P_FIELD])]);
			else
				$POST[$f_safe_url] = $this->buildURLFriendlyName($POST[$f_safe_url]);

			# Check if Url Friendly name already exist in database
			if ($this->isExistURLFriendlyName($POST[$f_safe_url]))
			{
				$this->Error[E_DESC] = 'URL Friendly name is already exist';
				return false;
			}
		}

        # Get array of insert query and value array
		$sql = $this->getInsertQuery($this->Data[TABLE_NAME],
									$this->Data[F_F_INFO],
									$POST);

        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

        $sql_query = $sql[0];
        $sql_value = $sql[1];

        # Execute actual query
		$this->DBC->ThrowError(true);

        try
		{
		    $pk_id = $this->DBC->run_query($sql_query,$sql_value,PDO_I);
        }
		catch(Exception $e)
		{
		    #Error Log Action
            if($this->DBErrorLog === true)
                ErrorLog::obj()->AddErrorLog(A_ADD, $e->getMessage());

            $db_e = unserialize($e->getMessage());

            if(!isset($config['OnLocal']))
				$this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to insert your record. Check your details and try again.';
			else
				$this->Error[E_DESC] = $db_e['ProgramError'];
		}
		$this->DBC->ThrowError(false);

		if(isset($pk_id) && is_numeric($pk_id))
		{
		  	# If sort order exist, set sort order value to primary key
			if(isset($this->Data[F_SORT]) && $this->Data[F_SORT]!='')
			{
				$u_sql = " UPDATE " . $this->Data[TABLE_NAME]
					. " SET "
					. $this->Data[F_SORT] . "= :pk_id "
					. " WHERE " . $this->Data[F_P_KEY] . "= :pk_id ";

				$u_val[':pk_id'] = $pk_id;

				# Show debug info
				if(defined('DEBUG'))
					$this->__debugMessage($u_sql);

				# Update sort order
				$this->DBC->run_query($u_sql,$u_val,PDO_U);
			}
            if(isset($this->Data[P_UP]) && $this->Data[P_UP] != '')
            {
                # Set physical upload root to local variable
                $p_up = $this->Data[P_UP];

                # If added date time filed is defined then create new folder
                if(isset($this->Data[F_ADDED_DATETIME]) && $this->Data[F_ADDED_DATETIME] != '')
                {
                    $f_added_datetime = ":" . str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_ADDED_DATETIME]);
                    if (isset($sql_value[$f_added_datetime]) && !empty($sql_value[$f_added_datetime]))
                    {
                        # Create directory structure based on added date time
                        $p_up = Utility::obj()->DateTimeBasedUploadLocation($this->Data[P_UP], $sql_value[$f_added_datetime], false, true);
                    }
                }

                # If Module required to create specific folder as upload root
                if(isset($this->Data[F_UP_FOLDER_NAME]) && $this->Data[F_UP_FOLDER_NAME] != '')
                {
                    $f_up_folder_name = ":" . str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_UP_FOLDER_NAME]);

                    # If need to use primary key
                    if ($this->Data[F_UP_FOLDER_NAME] == $this->Data[F_P_KEY])
                        $folder_name = $pk_id;
                    elseif (isset($sql_value[$f_up_folder_name]) && !empty($sql_value[$f_up_folder_name]))
                        $folder_name = $sql_value[$f_up_folder_name];

                    if (isset($folder_name) && !empty($folder_name))
                        $p_up .= "/" . $folder_name;
                }
                # If new upload root is created then move attachment to that folder
                if ($p_up != $this->Data[P_UP])
                {
                    # If directory is not exists
                    if (!is_dir($p_up))
                        mkdir($p_up);

                    if (is_dir($p_up))
                    {
                        foreach ($this->Data[F_D_FIELD] as $key => $arr_info)
                        {
                            $f_d_field = ":" . str_replace($this->Data[FIELD_PREFIX], '', $arr_info[0]);
                            $file_name = isset($sql_value[$f_d_field]) ? $sql_value[$f_d_field] : '';

                            if(!empty($file_name))
                                Utility::obj()->MoveUploadedFile($file_name, $this->Data[P_UP], $p_up);

                        }
                    }
                }
            }

            # Add user action log
            if($this->ActionLog === true && !in_array($this->Data[TABLE_NAME], $asset['Table_NotAllowActionLog_Add']))
                AdminLog::obj()->AddActionLog(A_ADD, $pk_id, $POST);

            return $pk_id;
		}
	}
    /**
     * DB_Custom::Update()
     * @param string $pkValue = primary key value to update record
     * @param array $POST = array(field_name => field_value)
     * @return true
     *
     * @Update generate update query and execute it
     */
    public function Update($pkValue, $POST)
	{
        global $config, $asset;

		$this->Error[E_DESC] = '';

		# Check for word censoring
		$this->CheckWordCensoring($POST);

        # Check for valid user input. Server side validation
		if($this->ServerSideValidation($POST) == false)
			return false;

		# Check for unique field values. Check for any duplicate entry
		if($this->CheckUniqueFieldValue($POST, $pkValue) == false)
			return false;

        # Get previous record
        $RecordsHistory = $this->getInfoById($pkValue);

        if (array_key_exists(F_S_URL,$this->Data) && isset($this->Data[F_S_URL]))
        {
            $f_safe_url = str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_S_URL]);

    		# Check and builder URL Friendly Name
    		if (array_key_exists($f_safe_url,$POST))
    		{
    			if (!isset($POST[$f_safe_url]) || empty($POST[$f_safe_url]))
    				$POST[$f_safe_url] = $this->buildURLFriendlyName($POST[str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_P_FIELD])]);
    			else
    				$POST[$f_safe_url] = $this->buildURLFriendlyName($POST[$f_safe_url]);

    			if ($this->isExistURLFriendlyName($POST[$f_safe_url], $pkValue))
    			{
    				$this->Error[E_DESC] = 'URL Friendly name already exist';
    				return false;
    			}
    		}
        }

        if (isset($this->Data[P_UP]) && $this->Data[P_UP] != '')
        {
            # Set physical upload root to local variable
            $p_up = $this->Data[P_UP];

            # If added date time filed is defined then create new folder
            if (isset($this->Data[F_ADDED_DATETIME]) && !empty($this->Data[F_ADDED_DATETIME])) {
                if (isset($RecordsHistory[$this->Data[F_ADDED_DATETIME]]) && !empty($RecordsHistory[$this->Data[F_ADDED_DATETIME]])) {
                    # Create directory structure based on added date time
                    $p_up = Utility::obj()->DateTimeBasedUploadLocation($this->Data[P_UP], $RecordsHistory[$this->Data[F_ADDED_DATETIME]], false, true);
                }
            }

            # If Module required to create specific folder as upload root
            if (isset($this->Data[F_UP_FOLDER_NAME]) && !empty($this->Data[F_UP_FOLDER_NAME])) {
                # If need to use primary key
                if (isset($RecordsHistory[$this->Data[F_UP_FOLDER_NAME]]) && !empty($RecordsHistory[$this->Data[F_UP_FOLDER_NAME]]))
                    $p_up .= "/" . $RecordsHistory[$this->Data[F_UP_FOLDER_NAME]];
            }

            # If new upload root is found then reset it
            if ($p_up != $this->Data[P_UP]) {
                # If directory is not exists
                if (!is_dir($p_up))
                    mkdir($p_up);

                if (is_dir($p_up)) {
                    $this->Data[P_UP] = $p_up;
                }
            }
        }

		$sql = $this->getUpdateQuery($this->Data[TABLE_NAME],
									$this->Data[F_F_INFO],
									$POST,
									$this->Data[F_P_KEY]."='$pkValue'");

        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

        $sql_query = $sql[0];
        $sql_value = $sql[1];

        $this->DBC->ThrowError(true);
		try
		{
			//$affected_rows = $this->DBC->run_query($sql[0],$sql[1],PDO_U);
            $affected_rows = $this->DBC->run_query($sql_query,$sql_value,PDO_U);

            # Add admin user action log
            if($this->ActionLog === true && !in_array($this->Data[TABLE_NAME], $asset['Table_NotAllowActionLog_Add']))
            {
                try{
                    AdminLog::obj()->AddActionLog(A_EDIT,$pkValue,$POST,$affected_rows, $RecordsHistory);
                }
                catch(exception $e){

                }

            }

            return $affected_rows;
        }
		catch(Exception $e)
		{
            #Error Log Action
            if($this->DBErrorLog === true)
                ErrorLog::obj()->AddErrorLog(A_EDIT, $e->getMessage());

            $db_e = unserialize($e->getMessage());
			if(!isset($config['OnLocal']))
				$this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to update your record. Check your details and try again.';
			else
				$this->Error[E_DESC] = $db_e['ProgramError'];
		}

		$this->DBC->ThrowError(false);
	}
	/**
	 * DB_Custom::InsertUpdate()
	 * @param array $Insert = array(field_name => field_value) | All fields to insert
	 * @param array $Update = array(field_name => field_value) | All fields to update
	 *
	 * @InsertUpdate get insert or update query from given value.
	 * Execute insert or update query on duplicate
	 */
	public function InsertUpdate($Insert, $Update)
	{
	   if(!is_array($Insert) || !is_array($Update))
			return false;

		$this->Error[E_DESC] = '';

		# Check for word censoring
		$this->CheckWordCensoring($Insert);

		# Check for valid user input. Server side validation
		if($this->ServerSideValidation($Insert) == false)
			return false;

		# Get insert query
		$insert_sql = $this->getInsertQuery($this->Data[TABLE_NAME], $this->Data[F_F_INFO], $Insert, false);

		$update_sets   =   array();
		foreach($Update as $FieldName=>$FieldValue)
		{
			if(is_array($FieldValue))
				$FieldValue = implode(',',$FieldValue);

			$update_sets[] = $this->Data[FIELD_PREFIX].$FieldName ."= '".addslashes(stripslashes(trim($FieldValue)))."'";
		}
		$update_sets = implode(',',$update_sets);

		# Create update query
		$update_sql = "UPDATE ".$update_sets;

		$sql    =   $insert_sql." ON DUPLICATE KEY ".$update_sql;

		# Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

        # Execute actual query
		$this->DBC->ThrowError(true);
        try
        {
            # Execute query
            return $this->DBC->run_query($sql,false,false);
        }
        catch(Exception $e)
		{
		    #Error Log Action
            if($this->DBErrorLog === true)
                ErrorLog::obj()->AddErrorLog(A_ADD, $e->getMessage());

            $db_e = unserialize($e->getMessage());
			if(!isset($config['OnLocal']))
				$this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to update your record. Check your details and try again.';
			else
				$this->Error[E_DESC] = $db_e['ProgramError'];
		}
        $this->DBC->ThrowError(false);
	}
    /**
     * DB_Custom::UpdateAll()
     * @param array $POST = array(field_name => field_value)
     * @return true
     *
     * @UpdateAll generate update query and execute it for all given record
     */
    /*
    public function UpdateAll($POST)
	{
		try
        {
            # start debug
            $this->DBC->start_debug();

            # start transaction
            $this->DBC->start_transaction();

            for($i=0; $i<count($POST[$this->Data[F_P_KEY]]); $i++)
    		{
    			$sqlSets    = '';
                $arr_value  = '';

                # Set primary key value
                $pkVal_field                =   ":".$this->Data[F_P_KEY];
                $arr_value[$pkVal_field]    =   $POST[$this->Data[F_P_KEY]][$i];

                # Set field and field value
    			foreach($this->Data[F_H_ALT] as $FieldName=>$FieldValues)
    			{
    				if ($FieldValues[IS_CNT])
    				{
                       $valField  = ":".$FieldName;

    				   $sqlSets .= $FieldName." = " .$valField. ",";
                       $arr_value[$valField] = trim($POST[$FieldName][$i]);
    				}
    			}

                $sqlSets = rtrim($sqlSets,",");

    			$sql	= " UPDATE " . $this->Data[TABLE_NAME]
    					. " SET " . $sqlSets
    					. " WHERE " . $this->Data[F_P_KEY] . " = " . $pkVal_field;

    			# Show debug info
    			if(defined('DEBUG'))
    				$this->__debugMessage($sql);

    			# Prepare sql statement
                $this->DBC->q_prepare($sql);

                # Execute sql statement with or without values
                $this->DBC->q_execute($arr_value);
    		}

            # commit changes
            $this->DBC->end_transaction();

            # stop debug
            $this->DBC->stop_debug($sql);

            return true;
        }
        catch (PDOException $e)
        {
            # roll back all changes
            $this->DBC->stop_transaction();

            $this->DBC->halt($e,"Invalid update all SQL query.",$sql,$arr_value);
        }
	}
    */
	/**
	 * DB_Custom::UpdateFieldByParam()
	 * @param string $field_sets = sql query string
	 * @param string $where_condition = sql query string
	 * @param array $value = false | array(key => value) for sql query
	 * @return number of affected rows
     *
     * @UpdateFieldByParam update record as per given parameter
	 */
	public function UpdateFieldByParam($field_sets , $where_condition, $value=false)
	{
		global $config;

		$this->DBC->ThrowError(true);
		try
		{
			$sql	=	"UPDATE " . $this->Data[TABLE_NAME]
					.	" SET "   . $field_sets
					.	" WHERE " . $where_condition ;

            # Show debug info
			if(defined('DEBUG'))
				$this->__debugMessage($sql);

            # Execute Query
			$run = $this->DBC->run_query($sql, $value, PDO_U);

            return $run;
		}
		catch(Exception $e)
		{
			$db_e = unserialize($e->getMessage());
            if(!isset($config['OnLocal']))
				$this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to update your record. Check your details and try again.';
			else
				$this->Error[E_DESC] = $db_e['ProgramError'];
		}
		$this->DBC->ThrowError(false);
	}
	/**
	 * DB_Custom::VirtualDelete()
	 * @param mixed $id = id of record | array of ids
	 * @param string $retField = field name to get it's value before delete record
	 * @return array of return fields
	 *
	 * @VirtualDelete virtualy delete record for given ids also virtualy delete related files and other records in relation
	 */
	public function VirtualDelete($id, $visibility)
	{
		if(!$id)
			return false;

		if(!is_array($id))
            $id = array($id);

        $idList = rtrim(str_repeat("?,",count($id)),",");

		# Define query
		$sql = " UPDATE ". $this->Data[TABLE_NAME]
			 . " SET ". $this->Data[F_VIRTUAL_DELETE]. " = '".$visibility."' "
			 . " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";

		# Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

		$affected_rows = $this->DBC->run_query($sql,$id,PDO_U);

        # Add user action log
        if($this->ActionLog === true)
            AdminLog::obj()->AddActionLog(A_VIRTUAL_DELETE,$id,false,$affected_rows,array("Virtually Deleted" => $visibility));

        return $affected_rows;
	}
    /**
     * DB_Custom::Delete()
     * @param mixed $id = id of record | array of ids
     * @param string $retField = field name to get it's value before delete record
     * @return array of return fields
     *
     * @Delete delete record for given ids also delete related files and other records in relation
     */
    public function Delete($id, $retField='')
	{
		global $config;

        if(!$id)
			return false;

		$this->DBC->ThrowError(true);
		try
		{
	        $retValue= array();

	        if(!is_array($id))
	            $id = array($id);

	        $idList = rtrim(str_repeat("?,",count($id)),",");

            # Get all records which are going to delete
            $RecordsHistory = $this->getInfoById($id);

	        # If default record is set, check for that whether default field is not in delete ID list
	        if(isset($this->Data[F_NO_DEL]))
	        {
	            $param = $this->Data[F_P_KEY]." IN (".$idList.") AND ".$this->Data[F_NO_DEL]['fname']." <> '".$this->Data[F_NO_DEL]['fvalue']."'";
	            $this->Data[F_B_SELECT] =   $this->Data[F_P_KEY];
	            $info = $this->getInfoByParam($param, $id, false, false, PDO_FETCH_ALL);

	            unset($id); unset($this->Data[F_B_SELECT]);

	            foreach ($info as $key => $value)
	                $id[]   =   $value[$this->Data[F_P_KEY]];

	            if(count($id) <= 0)
	                return false;

	            $idList = rtrim(str_repeat("?,",count($id)),",");
	        }

			# If need any field value, store it first
			if($retField != '')
			{
				$sql = " SELECT $retField "
					 . " FROM ". $this->Data[TABLE_NAME]
					 . " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";

	            $rs      =  $this->DBC->run_query($sql,$id);

				while($rs->next_record())
				{
					if($rs->f($retField) != '')
						array_push($retValue, $rs->f($retField));
				}
			}

			# If have some physical data like pictures, docs, pdf then get all of those data and file name and delete all files along with thumbnail
			if(isset($this->Data[F_D_FIELD]) && count($this->Data[F_D_FIELD]) > 0 && isset($this->Data[P_UP]) && $this->Data[P_UP] != '')
			{
                $completed = false;
				foreach($this->Data[F_D_FIELD] as $key=>$val)
				{
				    $f_custom_select[] = $val[0];

                    if(isset($this->Data[F_ADDED_DATETIME]) && !empty($this->Data[F_ADDED_DATETIME]))
                        $f_custom_select[] = $this->Data[F_ADDED_DATETIME];

                    if(isset($this->Data[F_UP_FOLDER_NAME]) && !empty($this->Data[F_UP_FOLDER_NAME]))
                        $f_custom_select[] = $this->Data[F_UP_FOLDER_NAME];

					# Define query
					/*$sql = " SELECT ". $this->Data[F_D_FIELD][$key][0]
						 . " FROM ". $this->Data[TABLE_NAME]
						 . " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";
                    */

                    # Define query
					$sql = " SELECT ". implode(",",$f_custom_select)
						 . " FROM ". $this->Data[TABLE_NAME]
						 . " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";

	                $rs = $this->DBC->run_query($sql,$id);
					$data = array();

					while($rs->next_record())
					{
                        $f_d_field_val = $rs->f($val[0]);

                        if($f_d_field_val != '')
                        {
                            # Set physical upload root to local variable
                            $p_up = $this->Data[P_UP];

                            # If added date time filed is defined then create new folder
                            if(isset($this->Data[F_ADDED_DATETIME]) && !empty($this->Data[F_ADDED_DATETIME]))
                            {
                                $f_added_datetime_val = $rs->f($this->Data[F_ADDED_DATETIME]);
                                if(isset($f_added_datetime_val) && !empty($f_added_datetime_val))
                                    $p_up = Utility::obj()->DateTimeBasedUploadLocation($this->Data[P_UP],$f_added_datetime_val,false,false);
                            }

                            # If Module required to create specific folder as upload root
                            if(isset($this->Data[F_UP_FOLDER_NAME]) && !empty($this->Data[F_UP_FOLDER_NAME]))
                            {
                                $f_up_folder_name_val = $rs->f($this->Data[F_UP_FOLDER_NAME]);
                                if(isset($f_up_folder_name_val) && !empty($f_up_folder_name_val))
                                {
                                    $p_up .= "/".$f_up_folder_name_val;

                                    # Module has individual directory based upload so remove entire directory
                                    Utility::obj()->deleteDirectory($p_up);

                                    $completed = true;
                                    continue;
                                }
                            }

                            $data[] =   array('file' => $f_d_field_val, 'location' => $p_up);
                        }
						//if($rs->f($this->Data[F_D_FIELD][$key][0]) != '')
						//	array_push($data, $rs->f($this->Data[F_D_FIELD][$key][0]));
					}
                    if($completed === true)
                        break;
                    else
					    $ret = $this->deleteFiles($data, $val[1]);
                   	//$ret = $this->deleteFiles($data, $this->Data[F_D_FIELD][$key][1]);
				}
			}

			# Delete related references
			if(isset($this->Data[F_DELETE_RELATION]) && is_array($this->Data[F_DELETE_RELATION]))
			{
				foreach($this->Data[F_DELETE_RELATION] as $db_table => $db_field)
				{
					$where = '';
					if(is_array($db_field))
					{
						foreach($db_field as $key => $val)
						{
							if($where != '')
								$where .= "OR ". $val. " IN (". $idList. ") ";
							else
								$where .= $val. " IN (". $idList. ") ";
						}
					}
					else
					{
						$where = $db_field. " IN (". $idList. ") ";
					}

					$sql = " DELETE FROM ".$db_table." WHERE ".$where;

					if(defined('DEBUG'))
						$this->__debugMessage($sql);

					$affected["relation"][] = $this->DBC->run_query($sql,$id,PDO_D);
	            }
	        }

			# Check for custome relation with different table with different field.
			if(isset($this->Data[F_DELETE_CUS_RELATION]) && is_array($this->Data[F_DELETE_CUS_RELATION]))
			{
				foreach($this->Data[F_DELETE_CUS_RELATION] as $db_table => $db_relation)
				{
					$sql = "DELETE FROM ".$db_table."
							WHERE ".$db_relation[1]."
							IN (SELECT ".$db_relation[0]." FROM ".$this->Data[TABLE_NAME]." WHERE ".$this->Data[F_P_KEY]." IN (".$idList."))";

					if(defined('DEBUG'))
						$this->__debugMessage($sql);

					$affected["cus_relation"][] = $this->DBC->run_query($sql,$id,PDO_D);
				}
			}

			# Define query
			$sql = " DELETE FROM ". $this->Data[TABLE_NAME]
				 . " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";

	        # Show debug info
			if(defined('DEBUG'))
				$this->__debugMessage($sql);

			$affected["record"] = $this->DBC->run_query($sql,$id,PDO_D);

            # Add user action log
            if($this->ActionLog === true)
                AdminLog::obj()->AddActionLog(A_DELETE, $id, false, $affected["record"], $RecordsHistory);

			if(!empty($retField))
				return $retValue;
			else
				return $affected["record"];
		}
		catch(Exception $e)
		{
            #Error Log Action
            if($this->DBErrorLog === true)
                ErrorLog::obj()->AddErrorLog(A_DELETE, $e->getMessage());

			$db_e = unserialize($e->getMessage());
			if(!isset($config['OnLocal']))
				$this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to delete your record. Check your details and try again.';
			else
				$this->Error[E_DESC] = $db_e['ProgramError'];
		}
		$this->DBC->ThrowError(false);
	}
	/**
	 * DB_Custom::DeleteByParam()
	 * @param string $param = sql query string
	 * @param array $value = false | array(key => value) for sql query
	 * @param string $retField = field name to retrive before delete record
	 * @return retrive field
     *
     * @DeleteByParam delete record as per given parameter and also delete it's related files and other records
	 */
	public function DeleteByParam($param, $value=array(), $retField='')
	{
		global $config;

		if(!$param)
			return false;

		$this->DBC->ThrowError(true);
		try
		{
	        $retValue = array();

	        # If default record is set, check for that whether default field is not in delete ID list
	        if(isset($this->Data[F_NO_DEL]))
	        {
	            $param .= " AND ".$this->Data[F_NO_DEL]['fname']." <> ?";
		        $value[] = $this->Data[F_NO_DEL]['fvalue'];
	        }

			# if need any field value, store it first
			if($retField != '')
			{
				$sql = " SELECT $retField "
					 . " FROM ". $this->Data[TABLE_NAME]
					 . " WHERE "
					 . $param;

				# Execute query
				$rs = $this->DBC->run_query($sql, $value);

				while($rs->next_record())
				{
					if($rs->f($retField) != '')
						array_push($retValue, $rs->f($retField));
				}
			}

			# If have some physical data like pictures, docs, pdf then get all of those data and file name and delete all files along with thumbnail
            if(isset($this->Data[F_D_FIELD]) && count($this->Data[F_D_FIELD]) > 0 && isset($this->Data[P_UP]) && $this->Data[P_UP] != '')
            {
                $completed = false;
                foreach($this->Data[F_D_FIELD] as $key=>$arr_info)
                {
                    $f_custom_select[] = $arr_info[0];

                    if(isset($this->Data[F_ADDED_DATETIME]) && !empty($this->Data[F_ADDED_DATETIME]))
                        $f_custom_select[] = $this->Data[F_ADDED_DATETIME];

                    if(isset($this->Data[F_UP_FOLDER_NAME]) && !empty($this->Data[F_UP_FOLDER_NAME]))
                        $f_custom_select[] = $this->Data[F_UP_FOLDER_NAME];

                    # Define query
                    $sql = " SELECT ". implode(",",$f_custom_select)
                        . " FROM ". $this->Data[TABLE_NAME]
                        . " WHERE ". $param;

                    $rs = $this->DBC->run_query($sql,$value);
                    $data = array();

                    while($rs->next_record())
                    {
                        $f_d_field_val = $rs->f($arr_info[0]);

                        if($f_d_field_val != '')
                        {
                            # Set physical upload root to local variable
                            $p_up = $this->Data[P_UP];

                            # If added date time filed is defined then create new folder
                            if(isset($this->Data[F_ADDED_DATETIME]) && !empty($this->Data[F_ADDED_DATETIME]))
                            {
                                $f_added_datetime_val = $rs->f($this->Data[F_ADDED_DATETIME]);
                                if(isset($f_added_datetime_val) && !empty($f_added_datetime_val))
                                    $p_up = Utility::obj()->DateTimeBasedUploadLocation($this->Data[P_UP],$f_added_datetime_val,false,false);
                            }

                            # If Module required to create specific folder as upload root
                            if(isset($this->Data[F_UP_FOLDER_NAME]) && !empty($this->Data[F_UP_FOLDER_NAME]))
                            {
                                $f_up_folder_name_val = $rs->f($this->Data[F_UP_FOLDER_NAME]);
                                if(isset($f_up_folder_name_val) && !empty($f_up_folder_name_val))
                                {
                                    $p_up .= "/".$f_up_folder_name_val;

                                    # Module has individual directory based upload so remove entire directory
                                    Utility::obj()->deleteDirectory($p_up);

                                    $completed = true;
                                    continue;
                                }
                            }

                            $data[] =   array('file' => $f_d_field_val, 'location' => $p_up);
                        }
                    }
                    if($completed === true)
                        break;
                    else
                        $ret = $this->deleteFiles($data, $arr_info[1]);
                }
            }

			# Define query
			$sql = " DELETE FROM ". $this->Data[TABLE_NAME]
				 . " WHERE "
				 . $param;

			# Show debug info
			if(defined('DEBUG'))
				$this->__debugMessage($sql);

			# Execute Query
			$affected_rows = $this->DBC->run_query($sql,$value,PDO_D);

			if(!empty($retField))
				return $retValue;
			else
				return $affected_rows;
		}
		catch(Exception $e)
		{
			$db_e = unserialize($e->getMessage());
			if(!isset($config['OnLocal']))
				$this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to delete your record. Check your details and try again.';
			else
				$this->Error[E_DESC] = $db_e['ProgramError'];
		}
		$this->DBC->ThrowError(false);
	}
    /**
     * DB_Custom::ActiveInactive()
     * @param mixed $id = single id to update | array of ids
     * @param string $active = value of active to set
     * @return affected rows
     *
     * @ActiveInactive set activeinactive for given parameter
     * Change method name VisibleHide => ActiveInactive
     * Last Modified : 2016-01-20 11:40:00 AM
     */
    public function ActiveInactive($id, $active)
	{
        if(!$id)
			return false;

		if(!is_array($id))
            $id = array($id);

        $idList = rtrim(str_repeat("?,",count($id)),",");

		# Define query
		$sql = " UPDATE ". $this->Data[TABLE_NAME]
			 . " SET ". $this->Data[F_ACTIVE]. " = '".$active."' "
			 . " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";

        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

		$affected_rows = $this->DBC->run_query($sql,$id,PDO_U);

        # Add user action log
        if($this->ActionLog === true)
            AdminLog::obj()->AddActionLog(A_ACTIVEINACTIVE,$id,false,$affected_rows,array("ActiveInactive" => $active));

        return $affected_rows;
	}
    /**
     * DB_Custom::ApproveDisapprove()
     * @param mixed $id = single id to update | array of ids
     * @param string $approvedisapprove = value of approve to set
     * @return affected rows
     *
     * @ApproveDisapprove set ApproveDisapprove for given parameter
     */
    public function ApproveDisapprove($id, $approvedisapprove)
	{
        if(!$id)
			return false;

		if(!is_array($id))
            $id = array($id);

        $idList = rtrim(str_repeat("?,",count($id)),",");

		# Define query
		$sql = " UPDATE ". $this->Data[TABLE_NAME]
			 . " SET ". $this->Data[F_APPROVEDISAPPROVE]. " = '".$approvedisapprove."' "
			 . " WHERE ". $this->Data[F_P_KEY]. " IN (". $idList. ") ";

        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

		$affected_rows = $this->DBC->run_query($sql,$id,PDO_U);

        # Add user action log
        if($this->ActionLog === true)
            AdminLog::obj()->AddActionLog(A_APPROVEDISAPPROVE,$id,false,$affected_rows,array("ApproveDisapprove" => $approvedisapprove));

        return $affected_rows;
	}
	/**
	 * DB_Custom::SortSingle()
	 * @param mixed $id = value of primary key
	 * @param string $move = Up | Down
	 * @param string $param = sql query string
	 * @param array $value = false | array(key => value) for sql query
	 * @return true
     *
     * @SortSingle update 2 records for sort order for given parameter
	 */
	public function SortSingle($id, $move, $param='', $value=false)
    {
		# Get info
		$curRS = $this->getInfoById($id);

        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($curRS);

		if($move == 'Up')
		{
            # Get the up record
			$sql =	" SELECT * "
				 .	" FROM ". $this->Data[TABLE_NAME]
				 .	" WHERE ". $this->Data[F_SORT]. " < :sort "
				 .	" AND " . $this->Data[F_P_KEY] . " != :id "
				 . ($param != ''? $param :'')
				 .	" ORDER BY ". $this->Data[F_SORT]. " DESC ";


        }
		else
		{
            # Get the down record
			$sql =	" SELECT * "
				 .	" FROM ". $this->Data[TABLE_NAME]
				 .	" WHERE ". $this->Data[F_SORT]. " > :sort "
				 .	" AND " . $this->Data[F_P_KEY] . " != :id "
				 . ($param != ''? $param :'')
				 .	" ORDER BY ". $this->Data[F_SORT]. " ASC ";

        }

        # Set value array
        $arr_val = array(   ":sort" =>  $curRS[$this->Data[F_SORT]],
                            ":id"   =>  $id);

        # Merge param value array
        if(is_array($value))
            $arr_val = array_merge($arr_val,$value);

        # Show debug info
    	if(defined('DEBUG'))
            $this->__debugMessage($sql);

        $rs      = $this->DBC->run_query($sql,$arr_val);
		$repRS   = $rs->fetch_record(PDO_FETCH_SINGLE);

		if(count($repRS) == 0 || empty($repRS))
			return false;

		# Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($repRS);

        unset($arr_val);

        try
        {
            # start debug
            $this->DBC->start_debug();

            # start transaction
            $this->DBC->start_transaction();

            # SQL query to update order
    		$sql = " UPDATE " . $this->Data[TABLE_NAME]
    			 . " SET " . $this->Data[F_SORT]. "= :sort "
    			 . " WHERE " . $this->Data[F_P_KEY] . "=  :id ";

        	# Show debug info
    		if(defined('DEBUG'))
    			$this->__debugMessage($sql);

            # Prepare sql statement
            $this->DBC->q_prepare($sql);

            # Execute first record
            $arr_val = array(   ":sort" =>  $repRS[$this->Data[F_SORT]],
                                ":id"   =>  $id);
            $this->DBC->q_execute($arr_val);

            # Execute second record
            $arr_val = array(   ":sort"  =>  $curRS[$this->Data[F_SORT]],
                                 ":id"   =>  $repRS[$this->Data[F_P_KEY]]);
            $this->DBC->q_execute($arr_val);

            # commit changes
            $this->DBC->end_transaction();

            # stop debug
            $this->DBC->stop_debug($sql);

             # Add user action log
            if($this->ActionLog === true )
                AdminLog::obj()->AddActionLog(A_SORT,$id,false,false,$repRS,array("MoveDirection" => $move));

            return true;
        }
        catch (PDOException $e)
        {
            # roll back all changes
            $this->DBC->stop_transaction();

            $this->DBC->halt($e,"Invalid single sort SQL query.",$sql);
        }
	}
    /**
     * DB_Custom::Sort()
     * @param string $sort_order = sort order separated  by (;)
     * @return true
     *
     * @Sort set sort order as per given order
     */
    public function Sort($sort_order)
    {
		try
        {
            # Explode the string to array
            $arrSortList = explode(';', $sort_order);

            # start debug
            $this->DBC->start_debug();

            # start transaction
            $this->DBC->start_transaction();

	        $c = count($arrSortList);
            for($i=0; $i < $c; $i++)
    		{
    			$sql = " UPDATE " . $this->Data[TABLE_NAME]
    				 . " SET "
    				 .	 $this->Data[F_SORT] . "= :sort "
    				 . " WHERE " . $this->Data[F_P_KEY] . "=  :pk_val";

                $arr_value = array( ":sort"     =>  ($i+1),
                                    ":pk_val"   =>  $arrSortList[$i]);
    			# Show debug info
    			if(defined('DEBUG'))
    				$this->__debugMessage($sql);

    			$this->DBC->run_query($sql,$arr_value,PDO_U);
    		}

            # commit changes
            $this->DBC->end_transaction();

            # stop debug
            $this->DBC->stop_debug($sql);

            return true;
        }
        catch(PDOException $e)
        {
            # roll back all changes
            $this->DBC->stop_transaction();

            $this->DBC->halt($e,"Invalid sort SQL query.",$sql,$arr_value);
        }
	}
	/**
	 * DB_Custom::buildURLFriendlyName()
	 * @param string $string = url friendly name
	 * @return safe url friendly name
     *
     * @buildURLFriendlyName check in side given string, modified it if required and return safe url friendly name
	 */
	public function buildURLFriendlyName($string)
	{
		# Store the special charater into the array which is to be remove for URL Friendly name
		$special_character_array = str_split('!@#$%^&*()+=[]\';,/{}|":<>?');
		$string_array = str_split($string);
		$new_string =   '';
		# Loop through the string and remove the special character
		foreach($string_array as $char)
		{
			if (!in_array($char,$special_character_array))
			{
				$new_string .= $char;
			}
		}

		#remove trailing space
		$new_string = trim($new_string," ");

		#build the more safe url
		//$new_string = $this->buildSefString($new_string);
		$new_string = str_replace(" ",					"-",		$new_string); 	#replace space with dash
		$new_string = str_replace("'",					"",			$new_string); 	#replace ' with nothing
		$new_string = str_replace('"',					"",			$new_string); 	#replace " with nothing
		//$new_string = preg_replace("/[^a-zA-Z0-9_-]/",	"-", 	$new_string); 	#convert non alphanumeric and non - _ to -
		$new_string = preg_replace ( "/-+/" , 			"-" , 		$new_string );  #convert multiple dashes to a single dash
		$new_string = preg_replace ( "/ +/" , 			" " , 		$new_string );  #convert multiple spaces to a single space
		$new_string = strtolower($new_string);

		return $new_string;
	}
	public function buildDatabaseName($string)
	{
		$name   =   $this->buildURLFriendlyName($string);

		$name   =   preg_replace("/[0-9]/", "", $name);     #remove number
		$name   =   str_replace("-", "", $name); 	        #replace - with nothing
		$name   =   str_replace(" ","",$name); 	            #replace space with nothing
		$name   =   trim(strtolower($name));

		return $name;
	}
	/**
	 * DB_Custom::isExistURLFriendlyName()
	 * @param mixed $value = flase | safe url value
	 * @param mixed $exclude_key = flase | primary key value to check
	 * @return true | flase
     *
     * @isExistURLFriendlyName check for given safe url value and return true if found and false if not found
	 */
	public function isExistURLFriendlyName($value=false, $exclude_key=false)
	{
		if ($value != false)
        {
			# Set parameter
			$param = $this->Data[F_S_URL]." = ?";
            $arr_value[] = $value;

			# Exclude primary key if not false
			if ($exclude_key != false)
            {
				$param .= " AND ".$this->Data[F_P_KEY]." != ?";
                $arr_value[] = $exclude_key;
			}

			$rs = $this->getInfoByParam($param, $arr_value);

			if ((count($rs) > 0) && (!empty($rs)))
				return true;
			else
				return false;
		}
		else
			return false;
	}
	/**
	 * DB_Custom::getInfoBySefUrl()
	 * @param mixed $str = safe url value
	 * @return array of record
     *
     * @getInfoBySefUrl get array of record for given safe url
	 */
	public function getInfoBySefUrl($str, $addParameters=false, $value=false)
	{
		$param = $this->Data[F_S_URL]. " = ?";
        $val[] = $str;

        if(isset($addParameters) && is_string($addParameters))
        {
            $param .= $addParameters;
            if(is_array($value))
            {
                $val = array_merge($val,$value);
            }
        }

		return $this->getInfoByParam($param,$val);
	}

#=========================================================================================
# Query creating code
#=========================================================================================
	/**
	 * DB_Custom::getSelectQuery()
	 * @param string $TableName = name of table
	 * @param string $F_PrimaryField = primary field for alpha sort
	 * @param string $addParameters = sql statement
	 * @param array $value = array(key => value) to execute sql statement
	 * @param string $Join = sql statement
	 * @param array $Custom_Param = all other required SQL statements and arguments as an array formate
	 * @param bool $allRecord = true | false whether to retrieve all record or not
	 * @param string $default_F_Sort = field name to sort record
	 * @param array $HeaderItem = array of fields
	 * @return sql query string
     *
     * @getSelectQuery generate sql query string as per given parameter
	 */
	public function getSelectQuery($TableName, $F_PrimaryField, $addParameters, $value, $Join, $Custom_Param, $allRecord, $default_F_Sort, $HeaderItem=false)
    {
	    $sql = "Code removed";
        # Show debug info
		if(defined('DEBUG'))
			$this->__debugMessage($sql);

        return $sql;
	}
    /**
     * DB_Custom::getInsertQuery()
     * @param string $TableName = name of table
     * @param array $FieldInfo = db field info array($key => $value)
     * @param array $POST = posted value from form
     * @param boll $StrictPrepare = true | flase What kind of sql query required. With or without values in query
     * @return $StrictPrepare true => array(sql_query, value_array) | $StrictPrepare false => sql query as a single string
     *
     * @getInsertQuery generate insert sql query string
     */
    public function getInsertQuery($TableName, $FieldInfo, $POST, $StrictPrepare = true)
    {
        $sqlFields = '';
        $sqlValues = '';

        # Get field_name => field_value array
		$FieldList  = $this->getFieldsValue($FieldInfo, $POST);

        if ($StrictPrepare == true)
        {
            /*Code removed*/
            $arr_SqlValues = '';

            $sqlFields = rtrim($sqlFields, ", ");
            $sqlValues = rtrim($sqlValues, ", ");

            $sql = "INSERT INTO $TableName($sqlFields) VALUES ($sqlValues)";

            return array($sql, $arr_SqlValues);
        }
        elseif ($StrictPrepare == false)
        {
            /*Code removed*/
        	$sql = "INSERT INTO $TableName($sqlFields) VALUES ($sqlValues)";
            return $sql;
        }
	}
    /**
     * DB_Custom::getUpdateQuery()
     * @param string $TableName = name of table
     * @param array $FieldInfo = db field info array($key => $value)
     * @param array $POST = posted value from form
     * @param string $primaryKey = string primary key field name
     * @param boll $StrictPrepare = true | flase What kind of sql query required. With or without values in query
     * @return $StrictPrepare true => array(sql_query, value_array) | $StrictPrepare false => sql query as a single string
     *
     * @getUpdateQuery generate update sql query string
     */
    public function getUpdateQuery($TableName, $FieldInfo, $POST, $primaryKey, $StrictPrepare = true)
    {
        /*Code removed*/
	}
	public function getCrossCondition()
	{
		global $config;
		if(isset($this->Data[F_CROSS_FIELD]))
		{
			if($config[OEC_INPSESSION] === YES)
				$param = ' AND '.$this->Data[F_CROSS_FIELD].' = "'.YES.'" ';
			else
				$param = ' AND '.$this->Data[F_CROSS_FIELD].' = "'.NO.'" ';

			return $param;
		}
	}
#=========================================================================================
# Field manipulation code
#=========================================================================================
    /**
     * DB_Custom::getEditFieldInfo()
     * @param array $arrRecord = data array of selected edit record
     * @param mixed $FieldInfo = field info
     * @return true
     *
     * @getEditFieldInfo set value in field info array for selected edit record
     */
    public function getEditFieldInfo($arrRecord, &$FieldInfo, $Action=false)
    {
	    if(!is_array($arrRecord))
		    return;

        foreach($FieldInfo as $key => $val)
		{
            $field_name = $this->Data[FIELD_PREFIX].$key;

            if(array_key_exists($field_name, $arrRecord))
			{
				$FieldInfo[$key][SEL_VAL] = $arrRecord[$field_name];

				if(isset($FieldInfo[$key][OPTION]) && is_array($FieldInfo[$key][OPTION]) && $FieldInfo[$key][CNT_TYPE] != C_PRIVILEGE)
				{
					$FieldInfo[$key][SEL_TEXT] = $this->getArrayValue($FieldInfo[$key][SEL_VAL], $FieldInfo[$key][OPTION]);
				}
			}
        }
       if($Action == A_VIEW)
        {
            $pk_id = $arrRecord[$this->Data[F_P_KEY]];
            $record = $this->getInfoById($pk_id);

            # Add user action log
            if($this->ActionLog === true )
                AdminLog::obj()->AddActionLog(A_VIEW,$pk_id,false,false,$record);
        }

        return true;
	}
	/**
	 * DB_Custom::getArrayValue()
	 * @param mixed $searchKey = comma (,) saperated keyes
	 * @param array $array = array to check for key
	 * @return array value
     *
     * @getArrayValue check for given key in given array and return if found
	 */
	public function getArrayValue($searchKey, $array)
	{
		$arrSearch = explode(",", $searchKey);
		$value = '';

		if (count($arrSearch)<=1)
		{
			$value = isset($array[$searchKey])?$array[$searchKey]:'';

			if(is_array($value) || !$value)
			{
				foreach($array as $key=>$val)
				{
					if(is_array($val))
					{
						$value = $this->getArrayValue($searchKey, $val);
						if($value)	break;
					}
				}
			}
		}
		else
		{
			foreach($arrSearch as $keySearch=>$valSearch)
			{
                if(isset($array[$valSearch]))
				    $value .= $array[$valSearch].", ";
			}
			$value = substr($value, 0, strlen($value)-2);
		}
		return $value;
	}
	/**
	 * DB_Custom::getFieldsValue()
	 * @param array $FieldInfo = array(key => value) for database fields
	 * @param array $POST = posted values from form
	 * @return array(field => field_value)
     *
     * @getFieldsValue check for field values in POST array.
     * Create array for field => field_value as per condition in field info array
	 */
	public function getFieldsValue($FieldInfo, $POST)
	{
        foreach ($FieldInfo as $fieldName => $params)
		{
            if(!isset($params[GROUP_TITLE]) && isset($params[CNT_TYPE]) && $params[CNT_TYPE] != C_BSPACE && (isset($POST[$fieldName]) || isset($_FILES[$fieldName]) || $params[CNT_TYPE] == C_DATE || $params[CNT_TYPE] == C_TIME || $params[CNT_TYPE] == C_SWITCH  || $params[CNT_TYPE] == C_CHECKBOX || $params[CNT_TYPE] == C_MULTI_SELECTION || $params[CNT_TYPE] == C_MULTI_AUTO_SUGGESTION))
			{
                if(isset($params[NULL_ON_EMPTY]) && $params[NULL_ON_EMPTY] === true && empty($POST[$fieldName]))
                {
                    $FieldsValue[$fieldName] = 'NULL';
                }
				elseif(isset($_FILES[$fieldName]) && is_array($_FILES[$fieldName]) && (in_array($params[CNT_TYPE], array(C_PICFILE, C_AUDIOFILE, C_FILE, C_VIDEOFILE))))
				{
				    $create_thumb = isset($params[CREATE_THUMB])?$params[CREATE_THUMB]:false;
					$FieldsValue[$fieldName] = $this->uploadFile($_FILES[$fieldName], $POST['prev_'.$fieldName], $create_thumb, isset($POST['del_'.$fieldName]), isset($params[ADDITIONAL_THUMBS]));
				}
                elseif($params[CNT_TYPE] == C_DATE)
				{
				    if (isset($POST[$fieldName. '_year']) && isset($POST[$fieldName. '_month']) && isset($POST[$fieldName. '_day']))
                        $FieldsValue[$fieldName] = $POST[$fieldName. '_year']. '-'. $POST[$fieldName. '_month']. '-'. $POST[$fieldName. '_day'];
				}
                elseif($params[CNT_TYPE] == C_DATE_PICKER || $params[CNT_TYPE] == C_DATE_RANGE)
				{
					$FieldsValue[$fieldName] = date('Y-m-d', strtotime($POST[$fieldName]));
				}
				elseif($params[CNT_TYPE] == C_TIME_PICKER)
				{
				    $FieldsValue[$fieldName] = date('H:i:s', strtotime($POST[$fieldName]));
				}
				elseif($params[CNT_TYPE] == C_DATE_TIME_PICKER)
				{
				    $FieldsValue[$fieldName] = date('Y-m-d H:i:s', strtotime($POST[$fieldName]));
				}
				elseif($params[CNT_TYPE] == C_TIME)
				{
				    $_meridian   =   isset($POST[$fieldName. '_meridian'])?$POST[$fieldName. '_meridian']:'';
                    $_hour       =   isset($POST[$fieldName. '_hour'])?$POST[$fieldName. '_hour']:'';
                    $_minute     =   isset($POST[$fieldName. '_minute'])?$POST[$fieldName. '_minute']:'';

                    if(!empty($_meridian) && !empty($_hour) && !empty($_minute))
                    {
    					if($_meridian == 'pm')
    						$hour = $_hour + 12;
    					else
    						$hour = $_hour;

    					$FieldsValue[$fieldName] = $hour.":".$_minute.":00";//mktime($hour, $POST[$fieldName. '_minute'], 0, date("m"), date("d"), date("Y"));
                    }
				}
				/*elseif($params[CNT_TYPE] == C_PHONE)
				{
					$FieldsValue[$fieldName] = implode("-",$POST[$fieldName]);
				}*/
				elseif($params[CNT_TYPE] == C_SWITCH)
				{
					$FieldsValue[$fieldName] = (isset($POST[$fieldName]) && $POST[$fieldName] == YES)?YES:NO;
				}
				elseif($params[CNT_TYPE] == C_CURRENCY)
				{
					$FieldsValue[$fieldName] = str_replace(',','',$POST[$fieldName]);
				}
                elseif($params[CNT_TYPE] == C_CHECKBOX || $params[CNT_TYPE] == C_MULTI_SELECTION || $params[CNT_TYPE] == C_MULTI_AUTO_SUGGESTION)
                {
                    if(!isset($POST[$fieldName]))
                        $FieldsValue[$fieldName] = '';
                    else
                    {
	                    $FieldsValue[$fieldName] = implode(",", $POST[$fieldName]);
                        $FieldsValue[$fieldName] = str_replace(",,",",",$FieldsValue[$fieldName]);
                    }
                }
				elseif(is_array($POST[$fieldName]))
                {
                    $FieldsValue[$fieldName] = implode(",", $POST[$fieldName]);
				    $FieldsValue[$fieldName] = str_replace(",,",",",$FieldsValue[$fieldName]);
                }
                else
				{
				    if(isset($params[VAL_TYPE]))
				    {
				        if($params[VAL_TYPE]&V_INT)
    						$FieldsValue[$fieldName] = intval($POST[$fieldName]);
    					elseif($params[VAL_TYPE]&V_FLOAT)
    						$FieldsValue[$fieldName] = floatval($POST[$fieldName]);
					    elseif($params[VAL_TYPE]&V_IP4 || $params[VAL_TYPE]&V_IP6)
    						$FieldsValue[$fieldName] = filter_var($POST[$fieldName], FILTER_VALIDATE_IP);
					    else
    						$FieldsValue[$fieldName] = trim($POST[$fieldName]);
					}
                    else
						$FieldsValue[$fieldName] = trim($POST[$fieldName]);
				}
			}
	   }

	   return $FieldsValue;
	}
	/**
	 * DB_Custom::uploadFile()
	 * @param mixed $File = uploaded file
	 * @param string $prevFileName = name of previous file
	 * @param bool $createThumb = false | true
	 * @param bool $deletePrevFile = true | false
	 * @param bool $additionalThumbs = false | true
	 * @return file name
     *
     * @uploadFile upload file to server
	 */
	public function uploadFile($File, $prevFileName, $createThumb=false, $deletePrevFile=true, $additionalThumbs=false)
	{
		global $config, $asset;

		# Clean filename and make unique name
		$destFile = str_replace(" " , "-", $File['name']);  	//convert spaces to a dash
		$destFile = str_replace("_" , "-", $File['name']);  	//convert underscore to a dash
		$destFile = preg_replace("/-+/" , "-", $destFile);  	//convert multiple dashes to a single dash
		$destFile = strtolower($this->getUniqueFilePrefix(). preg_replace("/[^[:alnum:].\-]/", "", $destFile));
		//$destFile 	= strtolower($this->getUniqueFilePrefix(). preg_replace("/[^[:alnum:].]/", "", $File['name']));

		# Define upload folder
		$destFolder	= $this->Data[P_UP]. '/';

        # Is file uploaded
		if($File['size'] !=0 && is_uploaded_file($File['tmp_name']))
		{
			# Delete any existing file with same name
			if (file_exists($destFolder. $destFile))
                unlink($destFolder. $destFile);

			# Upload file
			$uploadStatus = move_uploaded_file($File['tmp_name'], $destFolder. $destFile);

			# If file uploaded, create required thumb
			if($uploadStatus)
			{
				# Delete previous file
				if($prevFileName && file_exists($destFolder. $prevFileName))
                    unlink($destFolder. $prevFileName);

				if($createThumb == true)
				{
					# Make thumb
					$thumb = new Thumbnail(SystemConfig::obj()->Data[P_UP]. '/'. $config['watermark_image']);
					$thumb->image($destFolder. $destFile);
					$thumb->jpeg_quality(100);

					# Small thumbnail - create new and delete old one
					list($width, $height) = explode('x', strtolower($config['thumb_small']));

					$thumb->size_smart($width, $height);
					$thumb->get(S_IMG);

					if($prevFileName && file_exists($destFolder. S_IMG.'_'. $prevFileName))
						unlink($destFolder. S_IMG.'_'. $prevFileName);

					# Medium thumbnail - create new and delete old one
					list($width, $height) = explode('x', strtolower($config['thumb_medium']));

					$thumb->size_smart($width, $height);
					$thumb->get(M_IMG);

					if($prevFileName && file_exists($destFolder.M_IMG.'_'. $prevFileName))
						unlink($destFolder.M_IMG.'_'. $prevFileName);

					# Big thumbnail - create new and delete old one
					list($width, $height) = explode('x', strtolower($config['thumb_big']));

					$thumb->size_smart($width, $height);
					$thumb->get(B_IMG);

					if($prevFileName && file_exists($destFolder.B_IMG.'_'. $prevFileName))
						unlink($destFolder.B_IMG.'_'. $prevFileName);

					# Additional Thumbs Required
					if($additionalThumbs)
					{
						foreach($asset['Additional_Thumbs'] as $key => $val)
						{
							$thumbName = $key;
							list($width, $height) = explode('x', strtolower($val));
							$thumb->size_smart($width, $height);
							$thumb->get($thumbName);

							if($prevFileName && file_exists($destFolder. $thumbName . '_' . $prevFileName))
								unlink($destFolder. $thumbName . '_' . $prevFileName);
						}
					}
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
			     if (file_exists($destFolder. $prevFileName))
				    unlink($destFolder. $prevFileName);

				if($createThumb)
				{
				    if (file_exists($destFolder. S_IMG.'_'. $prevFileName))
					   unlink($destFolder. S_IMG.'_'. $prevFileName);

                    if (file_exists($destFolder.M_IMG.'_'. $prevFileName))
                        unlink($destFolder.M_IMG.'_'. $prevFileName);

                    if (file_exists($destFolder.B_IMG.'_'. $prevFileName))
                        unlink($destFolder.B_IMG.'_'. $prevFileName);
				}
				return '';
			}
			return $prevFileName;
		}
		return '';
	}
	/**
	 * DB_Custom::deleteFiles()
	 * @param mixed $fileList = single name of file | array of file names
	 * @param bool $isPicture = true | false
	 * @return none
     *
     * @deleteFiles delete given file from P_UP path
	 */
	public function deleteFiles($fileList, $isPicture=false)
	{
		$delete_file = function($fileName, $isPicture, $desLocation=false)
		{
            if($desLocation == false)
                $desLocation = $this->Data[P_UP];

			if (file_exists($desLocation. '/'. $fileName))
				unlink($desLocation. '/'. $fileName);

			if($isPicture)
			{
				if (file_exists($desLocation. '/'.S_IMG.'_'. $fileName))
					unlink($desLocation. '/'.S_IMG.'_'. $fileName);
				if (file_exists($desLocation. '/'.M_IMG.'_'. $fileName))
					unlink($desLocation. '/'.M_IMG.'_'. $fileName);
				if (file_exists($desLocation. '/'.B_IMG.'_'. $fileName))
					unlink($desLocation. '/'.B_IMG.'_'. $fileName);
			}
		};

        if(is_array($fileList))
		{
			if(count($fileList) == 0) return false;

			foreach($fileList as $key=>$fileInfo)
            {
                if(is_array($fileInfo))
                    $delete_file($fileInfo['file'],$isPicture,$fileInfo['location']);
                elseif(is_string($fileInfo))
                    $delete_file($fileInfo, $isPicture);
            }
		}
		else
		{
			if(!empty($fileList))
				$delete_file($fileList, $isPicture);
        }
	}
	/**
	 * DB_Custom::RandomPassword()
	 * @param int $num_letters = default 7 | length of password
	 * @return password
     *
     * @RandomPassword generate alpha numeric password as per given length
	 */
	public function RandomPassword($num_letters = 7)
	{
		$array = array(
						 /*Code removed*/
						 );
		$uppercased =   3;
		$pass       =   '';
		mt_srand ((double)microtime()*1000000);

		for($i=0; $i<$num_letters; $i++)
			$pass .= $array[mt_rand(0, (count($array) - 1))];

		$c = strlen($pass);
		for($i=1; $i<$c; $i++)
		{
			if(substr($pass, $i, 1) == substr($pass, $i-1, 1))
				$pass = substr($pass, 0, $i) . substr($pass, $i+1);
		}

		$c = strlen($pass);
		for($i=0; $i<$c; $i++)
		{
			if(mt_rand(0, $uppercased) == 0)
				$pass = substr($pass,0,$i) . strtoupper(substr($pass, $i,1)) .
				substr($pass, $i+1);
		}

		$pass = substr($pass, 0, $num_letters);
		return($pass);
	}
	/**
	 * DB_Custom::getUniqueFilePrefix()
	 * @return unique name
     *
     * @getUniqueFilePrefix generate unique name from date, time & microtime
	 */
	public function getUniqueFilePrefix()
	{
		list($usec, $sec)	= explode(" ",microtime());
		list($trash, $usec)	= explode(".",$usec);

        return (date("YmdHis").substr(($sec + $usec + rand($sec, $usec)), -10).'-');
	}
	/**
	 * DB_Custom::buildSefString()
	 * @param mixed $str == string to make safe
	 * @return safe string
     *
     * @buildSefString check inside given string and replace character if required
	 */
	public function buildSefString($str)
	{
		$str = str_replace("'",					"",		$str); 	#replace ' with nothing
		$str = str_replace('"',					"",		$str); 	#replace " with nothing
		$str = preg_replace("/[^a-zA-Z0-9_-]/",	"-", 	$str); 	#convert non alphanumeric and non - _ to -
		$str = preg_replace ( "/-+/" , 			"-" , 	$str ); #convert multiple dashes to a single dash
		$str = preg_replace ( "/ +/" , 			" " , 	$str ); #convert multiple spaces to a single space
		$str = strtolower($str);

        return $str;
	}
	/**
	 * DB_Custom::arrayKeyExists()
	 * @param int $pos = position of key
	 * @param array $array = array to check
	 * @return key
     *
     * @arrayKeyExists check for given key in given array
	 */
	public function arrayKeyExists($pos, $array)
	{
	   if (is_array($array))
       {
            $keys = array_keys($array);

            if(isset($keys[$pos-1]))
                return $keys[$pos-1];
        }
	}
	/**
	 * DB_Custom::IsEmpty()
	 * @param mixed $var = any value | array
	 * @return true | flase
     *
     * @IsEmpty check for empty given value
	 */
	public function IsEmpty($var)
	{
		if(!is_array($var))
            return empty($var);

		$flag = true;

		foreach($var as $key=>$val)
		{
			if(!empty($val))
				return false;
		}
		return $flag;
	}
    /**
     * DB_Custom::getAllInfoByParam()
     * @param string $param = sql query string
     * @param array $value = false | array(key => value) for sql query
     * @param string $orderBy = false | string field name
     * @return array of records
     *
     * @getAllInfoByParam get all records as per given parameter in array format
     */
    public function getAllInfoByParam($param, $value=false, $orderBy=false)
    {
		$data = "Code removed";

        return $data;
	}
    /**
     * DB_Custom::ReadFilter()
     * @param mixed $key = false | name for cookie/session to set
     * @param array $defArr = false | default criteria array(key => value)
     * @return none
     *
     * @ReadFilter check for cookie/session and set cookie/session
     */
    public function ReadFilter($key=false, $defArr=false)
    {
		if($key)
			$cookieKey = md5($key);
		else
			$cookieKey = md5($_SERVER['REDIRECT_URL']);

		if(isset($_POST[S_FILTER]))
		{
			foreach($_POST as $key=>$val)
			{
				if(is_numeric($val) || !empty($val))
                {
                    if(is_array($val))
                        $this->filter[$key]		=	$val;
                    else
					   $this->filter[$key]		=	trim($val);
                }
			}
		}
		elseif(isset($_POST['Remove_'.S_FILTER]))
		{
			$this->filter = array();

            # Want some default criteria ?
			if(is_array($defArr))
			{
				foreach($defArr as $key=>$val)
				{
					if(is_array($val))
                        $this->filter[$key]		=	$val;
                    else
					   $this->filter[$key]		=	trim($val);
				}
			}
		}
		elseif (isset($_SESSION[$cookieKey]) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['REDIRECT_URL']) !== false)
		{
			# Set filter
			//$this->filter = unserialize(urldecode($_COOKIE[$cookieKey]));
			$this->filter = unserialize(urldecode($_SESSION[$cookieKey]));
		}

	    # Save filter to local storage
	    $this->SaveFilter($cookieKey);
	}
	public function SaveFilter($cookieKey)
	{
		# Save filter criteria
		//setcookie($cookieKey, urlencode(serialize($this->filter)), COOKIE_EXPIRE_TIME_MIN);
		$_SESSION[$cookieKey] = urlencode(serialize($this->filter));
	}
    /**
     * DB_Custom::setSortingOptions()
     * @param array $defSort = false | array('so'=>so_value, 'sd'=>sd_value);
     * @return none
     *
     * @setSortingOptions set cookie/session for sorting option
     */
    public function setSortingOptions($defSort = false)
	{
		/*Code removed*/
    }
	/**
	 * DB_Custom::__errorAlert()
	 * @param mixed $message = message to alert
	 * @return none
     *
     * @__errorAlert print error message
	 */
	public function __errorAlert($message)
	{
		print( '<br>'. $message .'<br>'."\r\n");
	}
	/**
	 * DB_Custom::__debugMessage()
	 * @param mixed $message = message to display
	 * @return none
     *
     * @__debugMessage print debug message
	 */
	public function __debugMessage($message)
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
	/**
	 * DB_Custom::BasicResponseProcess()
	 * @param string $Action = action to perform | A_ADD, A_EDIT, A_SORT, A_DELETE, DeleteSelected, VisibleHide, VisibleHideSelected,
	 * @param array $POST = post data from form
	 * @param string $file_name = main controller file name
	 * @param array $objController = false | object to use processing methodes
	 * @return none
	 *
	 * @BasicResponseProcessing function perform some basic actions for any module so no need to duplicate code
	 * Last Modified : 2016-01-20 11:36:00 AM
     */
	public function BasicResponseProcess($Action, $POST, $file_name, $objController = false)
	{
        global $msgError,$msgSuccess;

		if(count($POST) <= 0)
			return;

		if($objController == false)
			$objController = $this;

		if(isset($objController->Data[C_COMMAND_LIST]) && in_array($Action, $objController->Data[C_COMMAND_LIST]))
		{
            if(!isset($POST['SubmitForm']) || (isset($POST['SubmitForm']) && $POST['SubmitForm'] != 'Next'))
                $file_name = Utility::obj()->pad_query_string($file_name);

			if($Action == A_ADD && isset($POST['SubmitForm']) && ($POST['SubmitForm'] == 'Save' || $POST['SubmitForm'] == 'Next'))
			{
                if(method_exists($objController,'_Insert'))
					$last_insert_id = $objController->_Insert($POST);
				else
					$last_insert_id = $objController->Insert($POST);

                /*Code removed*/
			}
			elseif(($Action == A_EDIT || $Action == A_USER_ACT_PROFILE) && isset($POST['SubmitForm']) && ($POST['SubmitForm'] == 'Save' || $POST['SubmitForm'] == 'Next'))
			{
				/*Code removed*/
			}
			elseif(true)/*Code removed*/
			{
				/*Code removed*/
			}
			elseif($Action == XYZ)/*Code removed*/
			{
				/*Code removed*/
			}
			elseif($Action == UXY)/*Code removed*/
			{
				if(method_exists($objController, '_ActiveInactive')){/*Code removed*/}
				else{/*Code removed*/}

				if(defined('IN_XAJAX'))
				{
					/*Code removed*/
				}
				else
				{
					/*Code removed*/
				}
			}
			elseif($Action == ABX)/*Code removed*/
			{
				/*Code removed*/
			}
            elseif($Action == IUIU)/*Code removed*/
			{
				/*Code removed*/
			}
			elseif($Action == IOIO)
			{
				/*Code removed*/
			}

			elseif($Action == SORT)
			{
				/*Code removed*/
			}
            elseif($Action == A_TRUNCATE_TABLE)
            {
	            /*Code removed*/
            }
            elseif($Action == A_VIRTUAL_DELETE)
			{
				/*Code removed*/
			}
            elseif($Action == A_VIRTUAL_DELETE_SEL)
			{
                if(method_exists($objController, '_VirtualDelete'))
					$affected_row = $objController->_VirtualDelete($POST['pk_list'], $POST['v_delete']);
				else
					$affected_row = $objController->VirtualDelete($POST['pk_list'], $POST['v_delete']);

               	if(defined('IN_XAJAX'))
				{
					if($affected_row == 1)
						$_GET['v_delete'] = $POST['v_delete'];
					else
						$_GET['error'] = 'true';
				}
				else
				{
				    if($affected_row > 0)
						header("location: ".$file_name."virtual-delete=".$POST['v_delete']);
					else
						header("location: ".$file_name."error=true");

					exit();
				}
			}
			elseif(isset($POST['submit'])  && $POST['submit'] == 'Cancel')
			{
				/*Code removed*/
			}
            else
            {
                if(method_exists($objController,'_BasicResponseProcess'))
                    $objController->_BasicResponseProcess($Action, $POST, $file_name, $objController);

            }
		}
	}
	/**
	 * DB_Custom::recursive_array_key_search()
	 * @param string $needle = array key to search
	 * @param array $haystack = array to search in
	 * @param string &$out_key = pass by referance out variable
	 * @return given key from array
	 *
	 * @recursive_array_key_search function check for key whether it is exists in array or not. function is written to deal with multi dimencial array
	 */
	public function recursive_array_key_search($needle, $haystack, $check_key=false, &$out_key = '')
	{
		if(!is_array($haystack)) return false;

		foreach($haystack as $key=>$value)
		{
			if($key === $needle)
			{
				/*Code removed*/
			}
			else
			{
				/*Code removed*/

				# Logic has some dought so commented
				/*
				if($check_key === false && is_array($value))
				{
					$this->recursive_array_key_search($needle, $value, $check_key, $out_key);
				}
				elseif($check_key !== false && isset($value[$check_key]))
				{
					$this->recursive_array_key_search($needle, $value[$check_key], $check_key, $out_key);
				}
				*/
			}
		}
		return $out_key;
	}
	/**
	 * DB_Custom::getPeriodRangeQuery()
	 * @param string $field_name = database field name to use in final sql query string
	 * @param array $getSearchFilter = array of search filter for form
	 * @param string $p_field = period_range | radio button field name to get users selected search area
	 * @param string $pf_field =  period_from | field name for from date selection
	 * @param string $pt_field = period_to | field name for to date selection
	 * @return sql string with AND condition
	 *
	 * @getPeriodRangeQuery function check for users input for date and time range selection and if it is set then it will create appropriate sql query string and return
	 */
	public function getPeriodRangeQuery($field_name, $getSearchFilter, $p_field='period_range', $pf_field='period_from', $pt_field='period_to')
	{
		$param='';
		if(isset($this->filter[$p_field]))
		{
			switch($this->filter[$p_field])
			{
				case 'Month';
					$param	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (MONTH(".$field_name.") = ".date("m"). ") ";
					break;
				case 'Week';
					$param	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (WEEK(".$field_name.", 3) = ". date('W').")  ";
					break;
				case 'Today';
					$param	 .=	" AND (DATE(".$field_name.") = '". date("Y-m-d")."') ";
					break;
				case 'Specify';
					if(isset($this->filter[$pf_field]) && !empty($this->filter[$pf_field]))
					{
	                    if($getSearchFilter['IsDateTime'] === true)
						{
					        $FromDate 	= date('Y-m-d H:i:s', strtotime($this->filter[$pf_field]));

							if(isset($this->filter[$pt_field]) && !empty($this->filter[$pt_field]))
								$ToDate 	= date('Y-m-d H:i:s', strtotime($this->filter[$pt_field]));
							else
								$ToDate 	= date('Y-m-d H:i:s');
	                    }
	                    else
	                    {
	                        $FromDate 	= date('Y-m-d', strtotime($this->filter[$pf_field]));

		                    if(isset($this->filter[$pt_field]) && !empty($this->filter[$pt_field]))
	                            $ToDate 	= date('Y-m-d', strtotime($this->filter[$pt_field]));
	                        else
		                        $ToDate 	= date('Y-m-d');
	                    }
						$param	 .=	" AND ".$field_name." BETWEEN '".$FromDate."' AND '".$ToDate."'";
					}
				break;
			}
		}
		return $param;
	}
    public function getLikeQueryForKeyword($keyword, $searchFields)
    {
	    global $asset;
        //$ret = preg_match_all("/[\w]{1,}+/", $keyword, $out_keywords);
        //$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $keyword, $out_keywords);

        /*$ret = preg_match_all("/[a-zA-Z0-9-\/]{2,}+/", $keyword, $out_keywords);
        $fieldsToSearch =   implode(", ' ', ", $searchFields);
        $strSearch      =   implode("%' OR CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '%", $out_keywords[0]);
        $param          =   " AND (CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '%". $strSearch. "%') ";
		return $param;*/

	    $keyword = strtolower($keyword);

	    preg_match_all("/[a-zA-Z0-9-\/]{1,}+/", $keyword, $out_keywords);

	    if(isset($out_keywords[0]) && is_array($out_keywords[0]))
	    {
		    $operator_words = array_intersect($asset['SEARCH_OPERATOR'], $out_keywords[0]);
		    $search_words = array_diff($out_keywords[0],$asset['SEARCH_OPERATOR']);

		    return $this->setLikeQueryWithKeywordAndField($search_words, $searchFields, $operator_words);
		}
    }
	public function setLikeQueryWithKeywordAndField($keyword, $searchFields, $operator_words=false)
	{
		foreach($keyword as $k => $word)
			$a[$k] = implode(" LIKE '%".$word."%' OR ", $searchFields)." LIKE '%".$word."%' ";

		if(isset($a))
		{
			if(is_array($operator_words) && in_array(SEARCH_OPERATOR_OR, $operator_words))
				$param = " AND (".implode(" OR ", $a).") ";
			else
				$param = " AND (".implode(" ) AND ( ", $a).") ";

			return $param;
		}
	}
    public function getRegExpQueryForKeyword($keyword, $searchFields)
    {
        //$ret = preg_match_all("/[\w]{1,}+/", $keyword, $out_keywords);
        //$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $keyword, $out_keywords);
        $ret = preg_match_all("/[a-zA-Z0-9-\/]{1,}+/", $keyword, $out_keywords);

        $fieldsToSearch =   implode(", ' ', ", $searchFields);
        $strSearch      =   implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $out_keywords[0]);
        $param          =   " AND (CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]". $strSearch. "') ";

        return $param;
    }
    public function  getAutoSuggestionRecord($str, array $searchFields, $addParameters='', $value=false, $Custom_Param=array(), $Join=false, $limit=50)
	{
		$addParameters .= $this->getLikeQueryForKeyword($str, $searchFields);

		//$likeQuery = implode(" LIKE '%".$keywords[0][0]."%' OR ",$searchFields);
        //$addParameters .= " AND (".$likeQuery." LIKE '%".$keywords[0][0]."%') ";

		$Custom_Param[SQL_LIMIT] = (!empty($limit) ? intval($limit) : 100);

		return $this->getAll($addParameters, $value, $Join, $Custom_Param);
	}
}
?>