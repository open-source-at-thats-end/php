<?php

class LPTAgentCodes extends DAO
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    {
        global $wpdb;

        $this->_daStruct['BaseTable'] =  'listing_agent';
        $this->_daStruct['OfficeTable'] =  'listing_office';
        $this->_daStruct['PrimaryKey'] = 'Office_ID';
    }

    public function viewAll($arrParams = array(), $addWhere = '', $customSelect = '')
    {
        global $objDB;

        $arrReturn = array();

        $arrPageSize = StaticArray::arrPageSize();
        $arrParams['page_size'] = $arrParams['page_size'] ? $arrParams['page_size'] : $arrPageSize[2];	//RESULT_PAGESIZE;
        $startRecord 			= ((intval($arrParams['page_current']) ? intval($arrParams['page_current']) : 1 ) - 1) * $arrParams['page_size'];

        $sortBy 	= '';
        $sordDir 	= 'ASC';

	    if(isset($arrParams['agent_name']) && $arrParams['agent_name'] != '')
	    {
		    $ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $arrParams['agent_name'], $keywords);

		    $searchFields = array();
		    $searchFields[] = 'Agent_FName';
		    $searchFields[] = 'Agent_LName';

		    $fieldsToSearch = implode(", ", $searchFields);

		    $arrAddKeyword = array();
		    $Params = array();
		    for($i=0; $i<count($keywords[0]); $i++)
		    {
			    $word = $keywords[0][$i];

			    array_push($arrAddKeyword, $word);
		    }

		    if(count($arrAddKeyword) > 0)
		    {
			    // Street
			    $strSearch = " CONCAT_WS(' ',". $fieldsToSearch. ") LIKE '%". implode(" ", $arrAddKeyword). "%' ";
			    array_push($Params, $strSearch);
		    }

		    if(count($arrParams) > 0)
			    $addWhere	 .=	" AND (".implode(" OR ", $Params).")";
	    }
	    if(isset($arrParams['agent_id']) && $arrParams['agent_id'] != '')
	    {
		    $addWhere.= " AND Agent_ID LIKE '".$arrParams['agent_id']."'";
	    }

	    if(isset($arrParams['broker_name']) && $arrParams['broker_name'] != '')
	    {
		    $addWhere.= " AND O.Office_Name LIKE '%".$arrParams['broker_name']."%'";
	    }

	    if(isset($arrParams['agent_sys_name']) && $arrParams['agent_sys_name'] != '')
	    {
		    $addWhere.= " AND Agent_MLSP_ID = ".$arrParams['agent_sys_name'];
	    }

        $arrReturn['pageSize'] 	= $arrParams['page_size'];

        $sql =	" SELECT count(*) as cnt ".
            " FROM ". $this->_daStruct['BaseTable']." AS LA".
            " LEFT JOIN ". $this->_daStruct['OfficeTable']." AS O ON O.Office_ID = LA.Agent_Office_ID";

        $sql .= " WHERE 1 ". $addWhere;

        # Debug sql
        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        # Execute query
        $rs = $objDB->query($sql);
        $rs->next_record();

        $arrReturn['totalRecord'] = $rs->f("cnt");
        $rs->free();

        $arrReturn['startRecord'] = $startRecord;

        $sql =	" SELECT LA.* ,O.Office_Name".
            " FROM ". $this->_daStruct['BaseTable']." AS LA".
            " LEFT JOIN ". $this->_daStruct['OfficeTable']." AS O ON O.Office_ID = LA.Agent_Office_ID".
            " WHERE 1 ". $addWhere;

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
}
?>