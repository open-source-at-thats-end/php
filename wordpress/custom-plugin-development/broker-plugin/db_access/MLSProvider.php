<?php
#=============================================================================================================================
#	File Name		:	MLS.php
#=============================================================================================================================
if(!function_exists('TrimArray'))
{
	function TrimArray($Input)
	{
		return trim($Input);
	}
}
//require_once(dirname(__FILE__) . '/MLSMaster.php');

class MLSProvider
{
	public static $Instance;

	public static function obj()
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self();

		return self::$Instance;
	}
    #=========================================================================================================================
	#	Function Name	:   MLSProvider
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
		global $physical_path, $virtual_path, $config;

		$this->picPath['MLS_Pic_Folder']		= array(
                                                        "1" =>  "trestle",
                                                    );

		# Table name
		$this->Data['Agent_Table']				=	$config['Table_Prefix']. 'listing_agent';
		$this->Data['Office_Table']				=	$config['Table_Prefix']. 'listing_office';
		$this->Data['Metadata_Table']			=	$config['Table_Prefix']. 'listing_metadata';

		$this->Data['TableName']				=	$config['Table_Prefix']. 'listing_master';
		$this->Data['Listing_Address']			=	$config['Table_Prefix']. 'listing_address';
		$this->Data['Listing_Additional_Info']	=	$config['Table_Prefix']. 'listing_additional_info';
		$this->Data['Listing_Open_House'] 	    = 	$config['Table_Prefix']. 'listing_open_house';
		$this->Data['MLS_Photo_Table'] 			= 	$config['Table_Prefix']. 'listing_photos';
		$this->Data['MLS_Virtual_Tour_Table'] 	= 	$config['Table_Prefix']. 'listing_virtual_tours';
		$this->Data['Listing_Log']		        =	$config['Table_Prefix']. 'listing_log';
		$this->Data['Listing_Deleted']          =   $config['Table_Prefix']. 'listing_deleted';
        $this->Data['Listing_Unit_Info']	    =	$config['Table_Prefix']. 'listing_unit_info';

		# Temp Tables
		$this->Data['MLS_Tmp_Photo_Data']		=	$config['Table_Prefix']. 'mls_photos';
	    $this->Data['MLS_Tmp_Unit_Data']		=	$config['Table_Prefix']. 'mls_units';
	}

#====================================================================================================
#	RETS to Master Table Transfer Function
#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   TruncateRETSTablebyName
	#-------------------------------------------------------------------------------------------------------------------------
    public function TruncateRETSTablebyName($TableList)
    {
		global $db;

		//Delete Table Empty
		if(!is_array($TableList))
		{
			$sql =	" TRUNCATE TABLE ".$TableList;
			$db->query($sql);

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);
		}
		else
		{
			foreach($TableList as $key => $TableName)
			{
				$sql =	" TRUNCATE TABLE ".$TableName;
				$db->query($sql);

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);
			}
		}

		return true;
	}

#====================================================================================================
#	JOB XML Function
#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   getXMLDataCount
	#-------------------------------------------------------------------------------------------------------------------------
	public function getXMLDataCount($objRETS, $retsResource, $retsClass, $retsFormat, $retsSelect, $retsQuery)
	{
		$search = $objRETS->SearchQuery(
						$Resource = $retsResource
						,$Class = $retsClass
						,$Query = $retsQuery
						,$OptionalParams = array(
													'Select' => $retsSelect,
													'Count' => 2
													//'Limit'	=>	5
												));
		//var_dump($search);exit;
		if(isset($objRETS->search_data[$search]['total_records_found']))
			return $objRETS->search_data[$search]['total_records_found'];
		else
		{
			print "<pre>";
			print_r($objRETS->Error());
			return 0;
		}

		/*$loop_no = 5;
		$l_no = 0;
		$data_count = 0;

		do {
			$response = $objRETS->Search(
				$Resource = $retsResource
				,$Class = $retsClass
				,$Count = 2								//0 = data   1 = data & count, 2 = count
				,$Format = $retsFormat			//COMPACT | COMPACT-DECODED | STANDARD-XML | STANDARD-XML:dtd-version
				,$Limit = 'NONE'
				,$QueryType = 'DMQL2'
				,$Standard_Names = 0
				,$Select = $retsSelect
				,$Query = $retsQuery
				,$Offset = ''
			);
			$l_no++;

			if (($response=='') || (strpos($response,'No Object Found')>0) || (strpos($response,'Not Found')>0) || (strpos($response,'Object Moved')>0) || (strpos($response,'Access is denied')>0))
			{
				sleep(50);
			}
			else
			{
				$data_count = $this->getDataCountFromXMLResponse($response);
				return $data_count;
			}

			if ($l_no==$loop_no)
			{
				return '';
			}

		} while (1);*/
	}

	#=========================================================================================================================
	#	Function Name	:   doDataTransfer_RETS2Table
	#-------------------------------------------------------------------------------------------------------------------------
	public function doDataTransfer_RETS2Table($objRETS, $retsResource, $retsClass, $retsFormat, $retsSelect, $retsQuery, $FieldList, $TableName, $Limit='', $Offset='', $extra_field='', $extra_value='')
	{
		global $db;

		$search = $objRETS->SearchQuery(
						$Resource = $retsResource
						,$Class = $retsClass
						,$Query = $retsQuery
						,$OptionalParams = array(
													'Select'	=> $retsSelect,
													'Count' 	=> 1,
													'Limit'		=> ($Limit!='')?$Limit:'',
													'Offset' 	=> ($Offset!='')?$Offset:''
												));
		//var_dump($search);exit;t
		//print "===>".$objRETS->search_data[$search]['total_records_found'];

		if(isset($objRETS->search_data[$search]['total_records_found']) && $objRETS->search_data[$search]['total_records_found'] > 0)
		{
			$sqlFields = '';
			$rec_no	= 25;
			$cnt	= 0;
			$sql 	= '';
			while ($listing = $objRETS->FetchRow($search))
			{
				// Create sql field list if not prepared yet
				if($sqlFields == '')
				{
					$temp_1 = explode(",",$retsSelect);
					$temp_2 = explode(",",$FieldList);

                    $temp = array_combine($temp_1,$temp_2);

					// FALSE ?
					if($temp === false)
					{
						print("Not able to create sql fields list \n\n");

						return false;
					}

					// Get RETS Fields Name array from listin array, get all keys
					$arrRetsField = array_keys($listing);

					foreach($arrRetsField as $key => $val)
					{
						$sqlFields .= $temp[$val].', ';
					}
					// Remove additional comma
					$sqlFields = trim($sqlFields, ', ');

					if ($extra_field=='')
						$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields . ") VALUES ";
					else
						$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields .", ".$extra_field. ") VALUES ";
				}

				$arrValues = array_values($listing);
				//array_walk($arrValues, 'addslashes');
				$arrValues = array_map( 'addslashes', $arrValues );

				if ($extra_field=='')
					$sql .= "('" . implode("', '", $arrValues) . "'), ";
				else
					$sql .= "('" . implode("', '", $arrValues) . "', '".$extra_value."'), ";

				$cnt++;

				if ($cnt==$rec_no)
				{
					//Insert Data
					$sql = substr($sql,0,strlen($sql)-2);

					# Show debug info
					if(DEBUG)
						$this->__debugMessage($sql);

					$db->db_close();

					$db->reconnect();

					$db->reset_database();

					$db->query($sql);

					$sql = "";

					if ($extra_field=='')
						$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields . ") VALUES ";
					else
						$sql .= "REPLACE INTO ".$TableName." (" . $sqlFields .", ".$extra_field. ") VALUES ";

					$cnt = 0;
				}

			   /*echo "Address: {$listing['StreetNumber']} {$listing['StreetName']}, ";
			   echo "{$listing['City']}, ";
			   echo "{$listing['State']} {$listing['ZipCode']} listed for ";
			   echo "\$".number_format($listing['ListPrice'])."\n";*/
			}

			if ($extra_field=='')
				$chksql = "REPLACE INTO ".$TableName." (" . $sqlFields . ") VALUES ";
			else
				$chksql = "REPLACE INTO ".$TableName." (" . $sqlFields .", ".$extra_field. ") VALUES ";

			if ($sql!=$chksql)
			{
				//Insert Data
				$sql = substr($sql,0,strlen($sql)-2);

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);

				$db->query($sql);
			}
		}
		else
		{
			print "<pre>";
			print_r($objRETS->Error());
			return '';
		}

		//$loop_no = 5;
//		$l_no = 0;
//
//		do {
//			$response = $objRETS->Search(
//					$Resource 	= $retsResource
//					,$Class 	= $retsClass
//					,$Count 	= 1								//0 = data   1 = data & count, 2 = count
//					,$Format 	= $retsFormat		//COMPACT | COMPACT-DECODED | STANDARD-XML | STANDARD-XML:dtd-version
//					,$Limit 	= ($Limit!='')?$Limit:'NONE'
//					,$QueryType = 'DMQL2'
//					,$Standard_Names = 0
//					,$Select 	= $retsSelect
//					,$Query 	= $retsQuery
//					,$Offset = ($Offset!='')?$Offset:''
//				);
//
//			$l_no++;
//
//			if (($response=='') || (strpos($response,'No Object Found')>0) || /*(strpos($response,'Not Found')>0) ||*/ (strpos($response,'Object Moved')>0) || (strpos($response,'Access is denied')>0))
//			{
//				print("Opps! got sleep: ". $retsQuery." \n\n");
//				sleep(50);
//			}
//			else
//			{
//				//print("RETS Query: ". $retsQuery." \n\n");
//				$this->dataInsertXML2Table($response, $retsSelect, $FieldList, $TableName, $extra_field, $extra_value);
//				return true;
//			}
//
//			if ($l_no>=$loop_no)
//			{
//				return false;
//			}
//
//
//		} while (1);
	}
#====================================================================================================
#	General XML Function
#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   dataInsertXML2Table
	#	Purpose			:	data insert from cron information
	#-------------------------------------------------------------------------------------------------------------------------
    public function dataInsertXML2Table($xml_data, $selectList, $dbFieldList, $table_name, $extra_field='', $extra_value='')
    {
		global $db;

		$sql	= "";
		$temp_1 = explode(",",$selectList);
		$temp_2 = explode(",",$dbFieldList);

		$temp = array_combine($temp_1,$temp_2);

		$temp_list = str_replace("\t",",", trim($xmlData->COLUMNS));

		$temp_3 = explode(",",$temp_list);

		$field_list = '';
		foreach($temp_3 as $key=>$val)
		{
			if (count($temp_3)-1==$key)
				$field_list .= $temp[$val];
			else
				$field_list .= $temp[$val].', ';
		}

		if ($extra_field=='')
			$sql .= "REPLACE INTO ".$table_name." (" . $field_list . ") VALUES ";
		else
			$sql .= "REPLACE INTO ".$table_name." (" . $field_list .", ".$extra_field. ") VALUES ";

		$rec_no	= 25;
		$cnt	= 0;

		$myData = $xmlData->DATA;
		foreach($myData as $data)
		{

			//$data = str_replace("'","", $data);
			//$data = str_replace("/","-", $data);
			//$data = str_replace("\\","", $data);

			$data = addslashes($data);
			$data_list = str_replace("\t","','", $data);
			$data_list = substr($data_list,3,strlen($data_list)-6);
			$data_list = preg_replace("/ +/", " ", $data_list); //convert multiple spaces to a single space

			if ($extra_field=='')
				$sql .= "('" . ($data_list) . "'), ";
			else
				$sql .= "('" . ($data_list) . "', '".$extra_value."'), ";

			$cnt++;

			if ($cnt==$rec_no)
			{
				//Insert Data
				$sql = substr($sql,0,strlen($sql)-2);

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);

				$db->db_close();

				$db->reconnect();

				$db->reset_database();

				$db->query($sql);

				$sql = "";

				if ($extra_field=='')
					$sql .= "REPLACE INTO ".$table_name." (" . $field_list . ") VALUES ";
				else
					$sql .= "REPLACE INTO ".$table_name." (" . $field_list .", ".$extra_field. ") VALUES ";

				$cnt = 0;
			}
		}

		unset($myData);

		if ($extra_field=='')
			$chksql = "REPLACE INTO ".$table_name." (" . $field_list . ") VALUES ";
		else
			$chksql = "REPLACE INTO ".$table_name." (" . $field_list .", ".$extra_field. ") VALUES ";

		if ($sql!=$chksql)
		{
			//Insert Data
			$sql = substr($sql,0,strlen($sql)-2);

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$db->query($sql);
		}

		unset($xmlData);
	}
	#=========================================================================================================================
	#	Function Name	:   getDataCountFromXMLResponse
	#	Purpose			:	get data Count
	#-------------------------------------------------------------------------------------------------------------------------
    public function getDataCountFromXMLResponse($xml_data)
    {
		global $db;

		$count_str = 0;
		$xmlData = @simplexml_load_string($xml_data);

		if($xmlData === false)
		{
			//mail(CRON_EMAIL_ADD, $this->Data['MLS_Provider']." : RETS Problem [Count Problem]", "Data : ".$xml_data);
			return false;
		}

		if(isset($xmlData->COUNT))
		{
			foreach ($xmlData->COUNT->attributes() as $a => $b)
			{
				if ($a = 'Records')
					$count_str = $b;
			}
		}

		return round($count_str);
	}
	#=========================================================================================================================
	#	Function Name	:   dataInsertXML2Arr
	#-------------------------------------------------------------------------------------------------------------------------
    public function dataInsertXML2Arr($xml_data)
    {
		$xmlData = simplexml_load_string(utf8_encode($xml_data));

		foreach($xmlData->attributes() as $a => $b)
		{
			if (($a=='ReplyCode') && ($b=='0' || $b=='20201'))
				break(1);

			mail(CRON_EMAIL_ADD, $this->Data['MLS_Provider']." : RETS Problem", "Code : ". $a." Value : ".$b);

			if ($a!='ReplyCode')
			{
				mail(CRON_EMAIL_ADD, $this->Data['MLS_Provider']." : JOB Exit from here", "Date : ". date('d-M-Y'));
				exit;
			}
		}

		$temp_list = str_replace("\t",",", trim($xmlData->COLUMNS));
		$temp = explode(",",$temp_list);

		$retArr = array();
		foreach($xmlData->DATA as $key => $data)
		{
			$data = addslashes($data);
			$data_list = str_replace("\t",",", trim($data));
			$arrData_list = explode(",",$data_list);

			$arrN = array_combine($temp, $arrData_list);

			array_push($retArr, $arrN);
		}

		return $retArr;
	}

	#=========================================================================================================================
	#	Function Name	:   RemoveDeletedListing
	#-------------------------------------------------------------------------------------------------------------------------
	public function MarkDeletedListing($MLSP_ID, $LookupTableName, $Status='')
	{
		global $db, $config;

		//Mark Listing for delete
		$sql =	" SELECT COUNT(*) AS cnt FROM ".$LookupTableName;

		$rs = $db->query($sql);

		$rs->next_record();

		//print 'In Delete : '. $rs->f('cnt')."<br>";

		if($rs->f('cnt') > 0)
		{
            if(is_array($Status))
                $Status = implode("','", $Status);

			//Mark Listing for delete
			$sql =	" UPDATE ".$this->Data['TableName'].
					" SET is_mark_for_deletion = 'Y', LastUpdateDate = NOW()".
					" WHERE MLSP_ID = ".$MLSP_ID." AND MLS_NUM NOT IN (SELECT MLS_NUM FROM ".$LookupTableName." ) AND is_mark_for_deletion = 'N' AND ListingStatus IN ('".$Status."')";

			//print $sql;

			$db->query($sql);

			//Re-activate delete marked listing
			$sql =	" UPDATE ".$this->Data['TableName'].
					" SET is_mark_for_deletion = 'N'".
					" WHERE MLSP_ID = ".$MLSP_ID." AND MLS_NUM IN (SELECT MLS_NUM FROM ".$LookupTableName." ) AND is_mark_for_deletion = 'Y' AND ListingStatus IN ('".$Status."')";

			//print $sql;

			$db->query($sql);


		$sql =	" UPDATE ".$this->Data['TableName']." AS M".
				" INNER JOIN ".$this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID".
				" SET M.is_mark_for_deletion = 'Y'".
				" WHERE M.MLSP_ID = ".$MLSP_ID." AND ListingStatus = 'Closed'  AND (DATEDIFF(CURDATE(), LastUpdateDate) >= 730 OR DATEDIFF(CURDATE(), Listing_Created_Date) >= 730 OR DATEDIFF(CURDATE(), Sold_Date) >= 730)";

			//print $sql;

			$db->query($sql);
		}
	}
    #=========================================================================================================================
    #	Function Name	:   MarkDeletedSoldListing
    #   Purpose         :   Mark Sold Listing As deleted.
    #-------------------------------------------------------------------------------------------------------------------------
    public function MarkDeletedSoldListing($LookupTableName, $ResultTableName)
    {
        global $db, $config;

        //Mark Listing for delete
		$sql =	" SELECT COUNT(*) AS cnt FROM ".$LookupTableName;

		$rs = $db->query($sql);

		$rs->next_record();

		//print 'In Delete : '. $rs->f('cnt')."<br>";

		if($rs->f('cnt') > 0)
		{
            $sql =	" UPDATE ".$ResultTableName.
					" SET is_mark_for_deletion = 'Y'".
					" WHERE MLS_NUM NOT IN (SELECT MLS_NUM FROM ".$LookupTableName." ) AND is_mark_for_deletion = 'N' ";

			//print $sql;

			$db->query($sql);

			//Re-activate delete marked listing
			$sql =	" UPDATE ".$ResultTableName.
					" SET is_mark_for_deletion = 'N'".
					" WHERE MLS_NUM IN (SELECT MLS_NUM FROM ".$LookupTableName." ) AND is_mark_for_deletion = 'Y' ";

			//print $sql;

			$db->query($sql);
        }
    }
#====================================================================================================
#	Listing Picture Transfer Job Function
#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   SetListingPhotoDownloadFlag
	#-------------------------------------------------------------------------------------------------------------------------
    public function SetListingPhotoDownloadFlag($Pic_Download_Flag='N', $MLSP_ID)
    {
		global $db;

		# Define query
		$sql =	" UPDATE ". $this->Data['TableName'].
				" SET Pic_Download_Flag = '".$Pic_Download_Flag."'".
				" WHERE MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);

		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   get_Pending_Photo_Download_ListingInfo
	#-------------------------------------------------------------------------------------------------------------------------
    public function get_Pending_Photo_Download_ListingInfo($MLSP_ID, $limit='')
    {
		global $db, $config;

        $officeIds = str_replace(',', "','", $config['mls_office_ids']);

	    $sql	= " SELECT MLSP_ID, MLS_NUM AS MLS_NUM, TotalPhotos, ListingKey, ListingStatus"
		    . " FROM ". $this->Data['TableName']

		    . " WHERE TotalPhotos > 0 AND MLS_NUM != '' AND MLSP_ID = '".$MLSP_ID."'"
		    . " 	AND is_mark_for_deletion = 'N'  "
		    //. " AND ((Pic_Download_Flag = 'N' AND (Pic_Updated_Date <= NOW() OR Pic_Updated_Date IS NULL)) OR (date_format(LastPhotoDate, '%Y-%m-%d') > Pic_Updated_Date))"
		    //. " ORDER BY Pic_Updated_Date";//
		    . " AND ((Pic_Download_Flag = 'N' AND (Pic_Download_Try_Date <= NOW() OR Pic_Download_Try_Date IS NULL)) OR (LastPhotoDate > Pic_Updated_Date)) OR (TotalPhotos = 0 AND (Pic_Download_Try_Date <= NOW() OR Pic_Download_Try_Date IS NULL) AND Pic_Updated_Date IS NOT NULL AND LastPhotoDate > Pic_Updated_Date)"
		    //. " AND (ListingStatus = 'Active' OR (ListingStatus = 'Closed' AND OfficeID IN('{$officeIds}')))"
		    . "  ORDER BY ListingStatus ASC, Pic_Download_Try_Date";


	    if ($limit!='')
			$sql .= " LIMIT 0 , ".$limit;

		$rs = $db->query($sql);

		return ($rs->fetch_array());
	}
    #=========================================================================================================================
	#	Function Name	:   get_Pending_Photo_Download_ListingInfo2
	#-------------------------------------------------------------------------------------------------------------------------
    public function get_Pending_Photo_Download_ListingInfo2($MLSP_ID, $limit='', $status='')
    {
		global $db, $config;

        $officeIds = str_replace(',', "','", $config['mls_office_ids']);

        $addParams = '';

        if($status != '')
            $addParams .= " AND ListingStatus IN ('".str_replace(',', "','", $status)."')";

        $sql	= " SELECT MLSP_ID, MLS_NUM AS MLS_NUM, TotalPhotos, ListingKey, ListingStatus"
				. " FROM ". $this->Data['TableName']
				. " WHERE TotalPhotos > 0 AND MLS_NUM != '' AND MLSP_ID = '".$MLSP_ID."'"
				. " 	AND is_mark_for_deletion = 'N' "
				//. " AND ((Pic_Download_Flag = 'N' AND (Pic_Updated_Date <= NOW() OR Pic_Updated_Date IS NULL)) OR (date_format(LastPhotoDate, '%Y-%m-%d') > Pic_Updated_Date))"
				//. " ORDER BY Pic_Updated_Date";
                //. " AND Pic_Download_Flag2 = 'N'"
				. " AND (Pic_Download_Flag2 = 'N' AND (Pic_Download_Try_Date2 <= NOW() OR Pic_Download_Try_Date2 IS NULL))"
				//. " AND (ListingStatus = 'Active' OR (ListingStatus = 'Closed' AND OfficeID IN('{$officeIds}')))"
                . $addParams
                . " ORDER BY ListingStatus ASC, Pic_Download_Try_Date2";

		if ($limit!='')
			$sql .= " LIMIT 0 , ".$limit;

		$rs = $db->query($sql);

		return ($rs->fetch_array());
	}
	#=========================================================================================================================
	#	Function Name	:   getListingPhotoStatusInfo
	#-------------------------------------------------------------------------------------------------------------------------
    public function getListingPhotoStatusInfo($MLSP_ID, $limit='')
    {
		global $db;

		$sql	= " SELECT MLS_NUM, TotalPhotos"
				. " FROM ". $this->Data['TableName']
				. " WHERE TotalPhotos > 0 AND MLS_NUM != '' AND MLSP_ID = '".$MLSP_ID."'"
				. " 	AND is_mark_for_deletion = 'N'";

		if ($limit!='')
			$sql .= " LIMIT 0 , ".$limit;

		$rs = $db->query($sql);

		return ($rs->fetch_array());
	}
	#=========================================================================================================================
	#	Function Name	:   updatePhotoDownloadFlag
	#-------------------------------------------------------------------------------------------------------------------------
    public function updatePhotoDownloadFlag($Pic_Download_Flag, $MLS_NUM, $MLSP_ID)
    {
		global $db;

		$sql =	" UPDATE ". $this->Data['TableName'].
				" SET Pic_Download_Flag = '".$Pic_Download_Flag."', ".
				" 	Pic_Updated_Date = NOW() ".
				" WHERE MLS_NUM = '". $MLS_NUM. "' AND MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);

		return true;
	}
    #=========================================================================================================================
	#	Function Name	:   updatePhotoDownloadFlag2
	#-------------------------------------------------------------------------------------------------------------------------
    public function updatePhotoDownloadFlag2($Pic_Download_Flag, $MLS_NUM, $MLSP_ID)
    {
		global $db;

		$sql =	" UPDATE ". $this->Data['TableName'].
				" SET Pic_Download_Flag2 = '".$Pic_Download_Flag."'".
				" WHERE MLS_NUM = '". $MLS_NUM. "' AND MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);

		return true;
	}

	#=========================================================================================================================
	#	Function Name	:   updatePhotoProcessDate
	#-------------------------------------------------------------------------------------------------------------------------
    public function updatePhotoProcessDate($MLS_NUM, $MLSP_ID)
    {
		global $db;

		$nextDate = date("Y-m-d", mktime(0,0,0,date('m'), intval(date('d'))+1,date('Y')));

		$sql =	" UPDATE ". $this->Data['TableName'].
				//" SET Pic_Updated_Date = '".$nextDate."' ".
				" SET Pic_Download_Try_Date = DATE_ADD(NOW() ,INTERVAL 1 HOUR), ".
				"	Pic_Download_Flag = 'N', Main_Photo_Url = '' ".
				" WHERE MLS_NUM = '". $MLS_NUM. "' AND MLSP_ID = '".$MLSP_ID."'";

        $sql = 
		$db->query($sql);

		return true;
	}
    #=========================================================================================================================
	#	Function Name	:   updatePhotoProcessDate
	#-------------------------------------------------------------------------------------------------------------------------
    public function updatePhotoProcessDate2($MLS_NUM, $MLSP_ID)
    {
		global $db;

		$nextDate = date("Y-m-d", mktime(0,0,0,date('m'), intval(date('d'))+1,date('Y')));

		$sql =	" UPDATE ". $this->Data['TableName'].
				//" SET Pic_Updated_Date = '".$nextDate."' ".
				" SET Pic_Download_Try_Date2 = DATE_ADD(NOW() ,INTERVAL 1 HOUR), ".
				"	Pic_Download_Flag2 = 'N'  ".
				" WHERE MLS_NUM = '". $MLS_NUM. "' AND MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);
		
		
		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   updatePhotoCount
	#-------------------------------------------------------------------------------------------------------------------------
    public function updatePhotoCount($MLS_NUM, $MLSP_ID, $TotalPhotos)
    {
		global $db;

		$sql =	" UPDATE ". $this->Data['TableName'].
				" SET TotalPhotos = '".$TotalPhotos."'".
				" WHERE MLS_NUM = '". $MLS_NUM. "' AND MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);

		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   updatePhotoCount
	#-------------------------------------------------------------------------------------------------------------------------
    public function markAllForDelete($MLSP_ID, $Status)
    {
		global $db;

		$sql =	" UPDATE ". $this->Data['TableName'].
				" SET is_mark_for_deletion = '".$Status."'".
				" WHERE MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);

		return true;
	}
#====================================================================================================
#	Latitude Longitude Job Function
#----------------------------------------------------------------------------------------------------
	#====================================================================================================
	#	Function Name	:   getLatiLongForCron
	#----------------------------------------------------------------------------------------------------
    public function getLatiLongForCron($limit=0,$lati_long_flag='N')
    {
		global $db;

		/*$sql = 	" SELECT * ".
				"	FROM ". $this->Data['Listing_Address']." " .
				" WHERE MLS_NUM IN ( 'N2496058')";*/

		$sql = 	" SELECT * ".
				"	FROM ". $this->Data['Listing_Address']." " .
				" WHERE Latitude = 0 AND Longitude = 0 AND lati_long_flag = '".$lati_long_flag."' ".
				"	AND (process_date <= NOW() OR process_date IS NULL)".
				"	AND MLS_NUM IN (SELECT MLS_NUM FROM ". $this->Data['TableName']. " WHERE is_mark_for_deletion = 'N' AND ListingStatus != 'Closed' ) ".
				//" 	AND ListingStatus != 'Closed' ".
				" ORDER BY process_date ";

		if ($limit>0)
			$sql .= " LIMIT 0,".$limit;

		//print $sql."<br>";

		$rs = $db->query($sql);

		$retArr = $rs->fetch_object();

		if (($lati_long_flag=='N') && (count($retArr)==0))
		{
			$sql = 	" SELECT * ".
					"	FROM ". $this->Data['Listing_Address']." " .
					" WHERE process_flag = 'N' ".
					"	AND (process_date <= NOW() OR process_date IS NULL)".
					"	AND MLS_NUM IN (SELECT MLS_NUM FROM ". $this->Data['TableName']. " WHERE is_mark_for_deletion = 'N' ) ".
//				" 	AND CityName IN ('Aurora', 'Newmarket') ".
					" ORDER BY process_date ";

			if ($limit>0)
				$sql .= " LIMIT 0,".$limit;

			//print $sql."<br>";

			$rs = $db->query($sql);
			$retArr = $rs->fetch_object();

			if (count($retArr)==0)
			{
				$sql = 	" SELECT * ".
						"	FROM ". $this->Data['Listing_Address']." " .
						" WHERE Latitude = 0 AND Longitude = 0 ".
						"	AND (process_date <= NOW() OR process_date IS NULL)".
						"	AND MLS_NUM IN (SELECT MLS_NUM FROM ". $this->Data['TableName']. " WHERE is_mark_for_deletion = 'N' ) ".
						" ORDER BY process_date ";

				if ($limit>0)
					$sql .= " LIMIT 0,".$limit;

				//print $sql."<br>";

				$rs = $db->query($sql);

				$retArr = $rs->fetch_object();

				/*if (count($retArr)==0)
				{
					$sql = 	" SELECT * ".
							"	FROM ". $this->Data['Listing_Address']." " .
							" WHERE lati_long_flag = 'G' ".
							"	AND (process_date <= NOW() OR process_date IS NULL)".
							"	AND MLS_NUM IN (SELECT MLS_NUM FROM ". $this->Data['TableName']. " WHERE is_mark_for_deletion = 'N' ) ".
							" ORDER BY process_date ";

					if ($limit>0)
						$sql .= " LIMIT 0,".$limit;

					//print $sql."<br>";

					$rs = $db->query($sql);

					$retArr = $rs->fetch_object();
				}*/
			}
		}

		return ($retArr);
	}
	#====================================================================================================
	#	Function Name	:   updateLatiLongByCron
	#----------------------------------------------------------------------------------------------------
    public function updateLatiLongByCron($MLS_NUM, $MLSP_ID, $latitude, $longitude, $lati_long_flag)
    {
		global $db;

		$sql = " UPDATE ".$this->Data['Listing_Address']
			 . " SET "
			 . " Latitude 		=  '". $latitude .			"', "
			 . " Longitude 		=  '". $longitude .			"', "
			 . " lati_long_flag =  '". $lati_long_flag.		"', "
			 . " process_flag 	=  'Y' "
			 . " WHERE MLS_NUM = '". $MLS_NUM . "' AND MLSP_ID = '". $MLSP_ID . "' ";

		 return $db->query($sql);
	}
	#=========================================================================================================================
	#	Function Name	:   updateLatiLongProcessDate
	#-------------------------------------------------------------------------------------------------------------------------
    public function updateLatiLongProcessDate($MLS_NUM, $MLSP_ID)
    {
		global $db;

		$sql =	" UPDATE ". $this->Data['Listing_Address'].
				" SET process_date = DATE_ADD( NOW() , INTERVAL 5 HOUR )".
				" WHERE MLS_NUM = '". $MLS_NUM. "' AND MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);

		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   updateLatiLongProcessDate2
	#-------------------------------------------------------------------------------------------------------------------------
	public function updateLatiLongProcessDate2($POST)
	{
		global $db;

		$sql =	" UPDATE ". $this->Data['Listing_Address'].
			" SET process_date = DATE_ADD( NOW() , INTERVAL 5 HOUR )".
			" WHERE MLS_NUM IN ('". implode("','",array_column($POST,'MLS_NUM')). "')";

		$db->query($sql);

		return true;
	}
	#====================================================================================================
	#	Function Name	:   FetchReminingListingID
	#----------------------------------------------------------------------------------------------------
    public function FetchReminingListingID($MLSP_ID)
    {
		global $db;

		$sql = " SELECT MLS_NUM FROM ".$this->Data['Temp_MLS_Listing']
			 . " WHERE MLSP_ID = '". $MLSP_ID . "'"
			 . "	AND MLS_NUM NOT IN (SELECT MLS_NUM FROM ".$this->Data['TableName']." WHERE MLSP_ID = '". $MLSP_ID . "' AND is_mark_for_deletion = 'N' )";

		//print $sql;

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#====================================================================================================
	#	Function Name	:   FetchReminingListingID
	#----------------------------------------------------------------------------------------------------
    public function getListingID($MLSP_ID, $Table_Name)
    {
		global $db;

		$sql = " SELECT MLS_NUM FROM ".$Table_Name
			 . " WHERE MLSP_ID = '". $MLSP_ID . "'";

		//print $sql;

		$rs = $db->query($sql);

		$arrRet = array();

		while($rs->next_record())
		{
			array_push($arrRet, $rs->f('MLS_NUM'));
		}

		return $arrRet;

		//return $rs->fetch_array(MYSQL_FETCH_ARRAY);
	}
	#====================================================================================================
	#	Function Name	:   getDeleteListing
	#	Purpose			:	Remove Listing Marked For Deletion
	#----------------------------------------------------------------------------------------------------
    public function DeletePhotos($MLSP_ID)
    {
		global $db, $physical_path;

		$arrRet = array();

		/* Delete Listing */
		$sql = " SELECT MLS_NUM AS MLS_NUM FROM ".$this->Data['TableName']
			 . " WHERE TotalPhotos > 0 AND is_mark_for_deletion = 'Y' AND MLSP_ID = '".$MLSP_ID."'";

		$rs = $db->query($sql);

		$pic_Path = $physical_path['Upload']. "/".$this->picPath['MLS_Pic_Folder'][$MLSP_ID]."/";

		while($rs->next_record())
		{
			$full_Path = $pic_Path.$rs->f('MLS_NUM')."/";

			if (is_dir($full_Path))
			{
				chdir($full_Path);
				//scandir($pic_Path)
				$arrFileName = glob("*.*");
				foreach($arrFileName as $key=>$fname)
				{
					@unlink($full_Path. $fname);
				}

				rmdir($full_Path);
			}
		}

		return;
	}
	#====================================================================================================
	#	Function Name	:   DeleteListing
	#	Purpose			:	Remove Listing Marked For Deletion
	#----------------------------------------------------------------------------------------------------
    public function DeleteListing($MLSP_ID, $status='')
    {
		global $db;

		$arrRet = array();

        $addParams = "";
        if($status != '')
            $addParams = " AND ListingStatus = '{$status}'";

		/* Delete Address Of Listing */
		//$sql = " DELETE FROM ".$this->Data['Listing_Address']
//			 . " WHERE MLS_NUM"
//			 ." 	IN( SELECT MLS_NUM FROM ".$this->Data['TableName']." WHERE is_mark_for_deletion = 'Y' AND MLSP_ID = '".$MLSP_ID."')"
//			 ." AND MLSP_ID = '".$MLSP_ID."'";
//
//		$db->query($sql);
//
//		$arrRet['cnt_address_delete'] = $db->affected_rows();
//
//		/* Delete Additional Inforamtion Of Listing */
//		$sql = " DELETE FROM ".$this->Data['Listing_Additional_Info']
//			 . " WHERE MLS_NUM"
//			 ." 	IN( SELECT MLS_NUM FROM ".$this->Data['TableName']." WHERE is_mark_for_deletion = 'Y' AND MLSP_ID = '".$MLSP_ID."')"
//			 ." AND MLSP_ID = '".$MLSP_ID."'";
//
//		$db->query($sql);
//
//		$arrRet['cnt_additional_info_delete'] = $db->affected_rows();

        /*$sql = " DELETE FROM ".$this->Data['MLS_Photo_Table']
			 . " WHERE EXISTS"
			 ."      ( SELECT ListingKey FROM ".$this->Data['TableName']." AS M WHERE M.is_mark_for_deletion = 'Y' AND M.ListingKey = ".$this->Data['MLS_Photo_Table'].".MLS_NUM)";
        */
        $sql = " DELETE P FROM ".$this->Data['MLS_Photo_Table']." P"
            ." INNER JOIN ".$this->Data['TableName']." M ON P.ListingKey = M.ListingKey WHERE is_mark_for_deletion = 'Y'".$addParams;

		$db->query($sql);

		$arrRet['cnt_photo_delete'] = $db->affected_rows();

		/* Delete Listing */
	//	$sql = " DELETE FROM ".$this->Data['TableName']
//			 . " WHERE is_mark_for_deletion = 'Y' AND MLSP_ID = '".$MLSP_ID."'";
//
//		$db->query($sql);
//
//		$arrRet['cnt_listing_delete'] = $db->affected_rows();

        $sql = " DELETE A, AI, M FROM ".$this->Data['TableName']." M"
            ." LEFT JOIN ".$this->Data['Listing_Additional_Info']." AI ON AI.MLS_NUM = M.MLS_NUM"
            ." LEFT JOIN ".$this->Data['Listing_Address']." A ON A.MLS_NUM = M.MLS_NUM WHERE is_mark_for_deletion = 'Y'".$addParams;

        $db->query($sql);

		$arrRet['cnt_listing_delete'] = $db->affected_rows();

		return $arrRet;
	}
	#====================================================================================================
	#	Function Name	:   DeleteListingByParams
	#	Purpose			:	Remove Listings based on given params
	#----------------------------------------------------------------------------------------------------
    public function DeleteClosedListing($MLSP_ID)
    {
		global $db;

		$arrRet = array();

		/* Delete Listing */
		$sql = " DELETE FROM ".$this->Data['TableName']
			 . " WHERE MLSP_ID = '".$MLSP_ID."' AND listingstatus = 'Closed Sale' AND propertytype != 'Single Family' AND (closingdate < DATE_SUB(NOW(), INTERVAL '12' MONTH))";

		$db->query($sql);

		/* Delete Listing */
		$sql = " DELETE FROM ".$this->Data['TableName']
			 . " WHERE MLSP_ID = '".$MLSP_ID."' AND listingstatus = 'Closed Sale' AND propertytype = 'Single Family' AND (statuschangedate < DATE_SUB(NOW(), INTERVAL '12' MONTH))";

		$db->query($sql);

		//$arrRet['cnt_listing_delete'] = $db->affected_rows();

		return $arrRet;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingIDWithPicture
	#	Purpose			:	Get listing with given ending character
	#-------------------------------------------------------------------------------------------------------------------------
    public function getListingIDWithPicture($suffix, $MLSP_ID)
    {
		global $db;

		$sql = "SELECT MLS_NUM FROM ". $this->Data['TableName']
			. " WHERE is_mark_for_deletion = 'N' AND TotalPhotos > 0 "
			. " 	AND SUBSTRING(MLS_NUM, -2) = ". $suffix
			. " 	AND MLSP_ID = ". $MLSP_ID
			. " ORDER BY MLS_NUM ";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		return $db->query($sql);
	}
    #=========================================================================================================================
	#	Function Name	:   UpdateOpenHouseStatus
	#	Use				:	Update open status to yes in master table if any available from today onwards
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdateOpenHouseStatus()
	{
		global $db;

		// Reset open house status to N in all records
		## Update Status in Listing Master table
		/* 2016-01-09 : Client want to show open house if property has any open house in past or future,
        so do not change flag to N, keep as it is.
        */
        $sql = "UPDATE ".$this->Data['TableName'].
				" SET Is_OpenHouse = 'N'".
				" WHERE is_mark_for_deletion = 'N'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$db->query($sql);


        ## Update Status in Listing Master table
		$sql = "UPDATE ".$this->Data['TableName']." AS LM".
                " INNER JOIN ".$this->Data['Listing_Open_House']." AS OH ON OH.MLS_NUM = LM.MLS_NUM".
				" SET Is_OpenHouse = 'Y'"; // , OpenHouse_Date = '".$rec['OH_Begins']."'
				//" WHERE is_mark_for_deletion = 'N'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

       	$db->query($sql);

	}

    #=========================================================================================================================
	#	Function Name	:   UpdateListingLog
	#	Use				:	Maintain listing history like New listing or price updated or deleted listing or status changed
	#-------------------------------------------------------------------------------------------------------------------------
	/*public function UpdateListingLog($MLSP_ID, $log_last_update_date)
	{
		global $db;

       	$sql =	" INSERT INTO ".$this->Data['Listing_Log'].
				" (lslog_mls_num, lslog_mlsp_id, lslog_status, lslog_actual_status, lslog_old_status, lslog_price, lslog_price_per_sqft, lslog_old_price, lslog_price_diff, lslog_source, lslog_ref_date, lslog_date)".

				" SELECT LM.MLS_NUM, LM.MLSP_ID,".
				" CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') = CURDATE()) THEN 'Listed' WHEN (ListingStatus != lslog_actual_status AND LM.is_mark_for_deletion = 'N' ) THEN 'Status Change' WHEN (ListPrice != lslog_price) THEN 'Price Change' WHEN (LM.is_mark_for_deletion = 'Y' AND DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') = CURDATE()) THEN 'Listing Removed' END,".
				" ListingStatus, lslog_actual_status, ListPrice, IF(ListPrice/SQFT > 0, ListPrice/SQFT, 0), lslog_price, IF(lslog_price > 0, (lslog_price-ListPrice)*100*(-1)/lslog_price, 0), Office_Name, ".
                " CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') = CURDATE() AND ListingStatus = 'Active' ) THEN DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') WHEN (ListingStatus = 'Active with Contract') THEN DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') ELSE CURDATE() END,".
                " CURDATE()".
				" FROM ".$this->Data['TableName']." AS LM".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON LM.OfficeID = O.Office_ID AND LM.MLSP_ID = O.Office_MLSP_ID ".
				" LEFT JOIN ".$this->Data['Listing_Log']." AS PL ON PL.lslog_mls_num = LM.MLS_NUM AND PL.lslog_mlsp_id = LM.MLSP_ID".
				" AND lslog_datetime = (SELECT lslog_datetime FROM ".$this->Data['Listing_Log']." WHERE lslog_mls_num = PL.lslog_mls_num AND lslog_mlsp_id = PL.lslog_mlsp_id ORDER BY lslog_datetime DESC LIMIT 1)".

				" WHERE ListingStatus IN ('Active','Active with Contract') AND (Listing_Created_Date >= '$log_last_update_date' OR LastUpdateDate >= '$log_last_update_date') AND (".
                " (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') = CURDATE())". 		// New Listing
				" OR (ListPrice != lslog_price)". 					// Price Changed
				" OR (LM.is_mark_for_deletion = 'Y' AND DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') = CURDATE())".
                " )". // Listing Removed

				" ON DUPLICATE KEY UPDATE lslog_mls_num = VALUES(lslog_mls_num), lslog_price_per_sqft = VALUES(lslog_price_per_sqft)";

        # Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$db->query($sql);
	}*/

    #=========================================================================================================================
	#	Function Name	:   UpdatePriceDifference
	#	Use				:	Update price difference in master table as per price increase/decrease for today
	#-------------------------------------------------------------------------------------------------------------------------
	public function UpdatePriceDifference($MLSP_ID)
	{
		global $db;

		// Note : Reset Price diff to 0, for listings mark  for deletion,
		// Because if that listing listed again on same day, it will not count as price changed.
		$sql = "UPDATE ".$this->Data['TableName'].
				" SET Price_Diff = 0, Old_Price = 0".
				" WHERE MLSP_ID = ".$MLSP_ID." AND is_mark_for_deletion = 'Y'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$db->query($sql);

		// Get all price changed log for today only
		$sql =	" UPDATE ".$this->Data['TableName']." AS LM".
                " INNER JOIN ".$this->Data['Listing_Log']." AS PL ON PL.lslog_mls_num = LM.MLS_NUM AND PL.lslog_mlsp_id = LM.MLSP_ID AND lslog_date = CURDATE() AND lslog_status = 'Price Change'".
				" SET LM.Price_Diff = PL.lslog_price_diff, LM.Old_Price = PL.lslog_old_price".
				" WHERE lslog_old_price > 0";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		/*while($rs->next_record())
		{
			$rec = $rs->Record;

			## Update Status in Listing Master table
			$sql = "UPDATE ".$this->Data['TableName'].
					" SET Price_Diff = '".$rec['lplog_price_diff']."'".
					" WHERE MLS_NUM = '".$rec['MLS_NUM']."' AND MLSP_ID = '".$rec['MLSP_ID']."'";

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$db->query($sql);

		}
        */
	}
	#====================================================================================================
	#	Unit Data Transfer Job Function
	#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   SetListingUnitDownloadFlag
	#-------------------------------------------------------------------------------------------------------------------------
	function SetListingUnitDownloadFlag($Unit_Download_Flag='N', $MLSP_ID)
	{
		global $db;

		# Define query
		$sql =	" UPDATE ". $this->Data['TableName'].
			" SET Unit_Download_Flag = '".$Unit_Download_Flag."'".
			" WHERE MLSP_ID = '".$MLSP_ID."'";

		$db->query($sql);

		return true;
	}
	#=========================================================================================================================
	#	Function Name	:   get_Pending_Unit_Download_ListingInfo
	#-------------------------------------------------------------------------------------------------------------------------
	function get_Pending_Unit_Download_ListingInfo($MLSP_ID, $limit='')
	{
		global $db;

		$sql	= " SELECT ListingKey,MLS_NUM"
			. " FROM ". $this->Data['TableName']
			. " WHERE  1 AND TotalUnits > 0 AND MLS_NUM != '' AND MLSP_ID = '".$MLSP_ID."'"
			. " 	AND is_mark_for_deletion = 'N' "
			. " AND Unit_Download_Flag = 'N' AND (Unit_Download_Try_Date <= NOW() OR Unit_Download_Try_Date IS NULL)"
			. " ORDER BY ListingStatus ASC, Unit_Download_Try_Date";

		if ($limit!='')
			$sql .= " LIMIT 0 , ".$limit;

		$rs = $db->query($sql);

		return ($rs->fetch_array());
	}
	#=========================================================================================================================
	#	Function Name	:   InsertUnitData
	#	Purpose			:	data insert from temp table to unit table
	#-------------------------------------------------------------------------------------------------------------------------
	function InsertUnitData($strListingIds='')
	{
		global $db;

		if($strListingIds != '')
		{
			$strListingIds = str_replace(",", "','", $strListingIds);

			// Delete Old entries from phoros table if any
			$sql =	" DELETE FROM ".$this->Data['Listing_Unit_Info'].

				" WHERE MLS_NUM IN('".$strListingIds."')";


			$db->query($sql);

			// Unit Data Transfer
			$sql =	" INSERT INTO ".$this->Data['Listing_Unit_Info'].

				" SELECT ListingKey, ".$this->MLSP_ID.", ListingKey, UnitTypeType, UnitTypeActualRent, UnitTypeGarageSpaces, UnitTypeBedsTotal, UnitTypeBathsTotal, UnitTypeProForma,UnitTypeDescription, NOW()".

				" FROM ".$this->Data['MLS_Tmp_Unit_Data'];

			$db->query($sql);

			$sql =	" UPDATE ".$this->Data['TableName']." M".
				" INNER JOIN ".$this->Data['MLS_Tmp_Unit_Data']." AS P ON M.ListingKey = P.ListingKey AND M.MLSP_ID = '".$this->MLSP_ID."'".
				" SET Unit_Download_Flag = 'Y', Unit_Updated_Date = NOW() ";

			$db->query($sql);
		}

	}
	#=========================================================================================================================
	#	Function Name	:   __debugMessage
	#	Purpose			:	Display debug message
	#	Return			:	Nothing
	#-------------------------------------------------------------------------------------------------------------------------
	public function __debugMessage($message)
	{
		if(is_array($message))
		{
			print "<pre>";
			print_r($message);
			printf("</pre>\n%s\n", str_repeat("-=", 65));
		}
		else
		{
			printf("%s\n%s\n", $message, str_repeat("-=", 65));
		}
	}
}
?>