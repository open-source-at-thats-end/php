<?php
#=============================================================================================================================
#	File Name		:	Metadata.php
#=============================================================================================================================
class Metadata
{
	public static $Instance;

	public static function obj()
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self();

		return self::$Instance;
	}
    #=========================================================================================================================
	#	Function Name	:   Metadata
	#	Purpose			:	Simple constructor
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
        global $config;
		$this->Data['Metadata_Table'] = $config['Table_Prefix'].'listing_metadata';
	}
	#=========================================================================================================================
	#	Function Name	:   getMetadataValue
	#-------------------------------------------------------------------------------------------------------------------------
    public function getMetadataValue($Field_Name, $Lookup_Name='', $POST='') // [Note : Second param need to be changed, from usrealtyteam it commes as array]
    {
        global $db;

		$sql =	" SELECT distinct LongValue". // distinct LongValue, IDValue
				" FROM ". $this->Data['Metadata_Table'].
				" WHERE Field_Name = '".$Field_Name."' AND LongValue != '' AND LongValue != 'None'";

		if(is_array($Lookup_Name))
		{
			if($Lookup_Name['Lookup_Name'] != '')
				$sql .= " AND Lookup_Name = '".$Lookup_Name['Lookup_Name']."' ";
		}
		else
		{
			if ($Lookup_Name!='')
			$sql .= " AND Lookup_Name = '".$Lookup_Name."' ";
		}

		if(isset($POST['MLSP_ID']) && $POST['MLSP_ID'] != '')
			$sql .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql .= " ORDER BY LongValue";

		$rs = $db->query($sql);
		# Make call to parent constructor
		$rs 	= $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
		{
			$arr[trim($row['LongValue'])]  = ucwords(strtolower(trim($row['LongValue'])));
		}
		return ($arr);
	}
	#=========================================================================================================================
	#	Function Name	:   getAllMetadataValue
	#-------------------------------------------------------------------------------------------------------------------------
    public function getAllMetadataValue($POST='')
    {
		global $db;

		$addParameters = '';

		if(isset($POST['MLS_ID']) && $POST['MLS_ID'] != '')
			$addParameters .= " AND MLS_ID IN('".$POST['MLS_ID']."')";

		$sql =	" SELECT distinct Field_Name ".
				" FROM ". $this->Data['Metadata_Table'].
				" WHERE 1".$addParameters.
				" ORDER BY Field_Name";

		$rs = $db->query($sql);

		# Make call to parent constructor
		$rs 	= $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
		{
			$arr[trim($row['Field_Name'])]  = array();

			$sql =	" SELECT distinct LongValue, IDValue ".
					" FROM ". $this->Data['Metadata_Table'].
					" WHERE Field_Name = '".$row['Field_Name']."' ".
					" ORDER BY LongValue";

			$rs1 = $db->query($sql);
			$rsLongValue = $rs1->fetch_array();

			foreach($rsLongValue as $keyLongValue => $rowLongValue)
			{
				$arr[trim($row['Field_Name'])][trim($rowLongValue['IDValue'])]  = ucwords(strtolower(trim($rowLongValue['LongValue'])));
			}
		}
		return ($arr);
	}
}
?>