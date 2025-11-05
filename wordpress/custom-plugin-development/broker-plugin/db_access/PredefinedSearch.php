<?php

require_once(dirname(__FILE__) . '/CustomClass.php');

class PredefinedSearch extends CustomClass {
    private static $instance;

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

        $this->Data['TableName']			        =	'predefined_searches';
        $this->Data['StatisticTable']			        =	'listing_statistic';
        $this->Data['F_PrimaryKey']                 =   'psearch_id';
        $this->Data['F_FieldInfo']				    =
            array(
                'psearch_title'                     =>	array(	'title'			=>	'Title',
                    'c_type'		=>	'text',
                ),
                'psearch_criteria'               =>	array(	'title'			=>	'Criteria',
                    'c_type'		=>	'text',
                ),
                'psearch_result_limit'               =>	array(	'title'			=>	'psearch result limit',
                    'c_type'		=>	'text',
                ),
                'psearch_added_date'               =>	array(	'title'			=>	'Added Date',
                    'c_type'		=>	C_HIDDEN,
                ),
                'psearch_added_by_id'               =>	array(	'title'			=>	'Added Id',
                    'c_type'		=>	'text',
                ),
                'psearch_added_by_type'               =>	array(	'title'			=>	'Added Type',
                    'c_type'		=>	'text',
                ),
                'psearch_generate_mrktreport'               =>	array(	'title'			=>	'Generate Market Report',
                    'c_type'		=>	'text',
                ),
                'psearch_generate_rental'               =>	array(	'title'			=>	'Generate Rentals Page',
                    'c_type'		=>	'text',
                ),
                'psearch_display_tab'               =>	array(	'title'			=>	'Display Tab Layout?',
                                                                        'c_type'		=>	'text',
                ),
                'psearch_tag'               =>	array(	'title'			=>	'Tag',
                    'c_type'		=>	'text',
                ),
                'psearch_sys_name'               =>	array(	'title'			=>	'Agent System Name',
                    'c_type'		=>	'text',
                ),
                'psearch_monthwise_report'               =>	array(	'title'			=>	'Generate Monthwise Market Repor',
                    'c_type'		=>	'text',
                ),
            );
        parent::__construct();
    }

    public function addPredefinedSearch($POST)
    {
    	if(isset($POST['psearch_tag']) && $POST['psearch_tag'] != '')
	    {
		    $POST['psearch_tag'] = str_replace(', ',',',$POST['psearch_tag']);
	    }
        $id = parent::Insert($POST);

        if($id > 0)
        {
            if(isset($POST['psearch_generate_mrktreport']) && $POST['psearch_generate_mrktreport'] == 'Yes')
            {
                $arr['psearch_criteria'] = $POST['psearch_criteria'];
                $arr['ref_id'] = $id;
                MarketTrend::getInstance()->InsertSearchCriteriaWiseStatistic($arr);
                return $id;
            }else{
                return array('id' => $id);
            }
        }else{
            return array('id' => $id);
        }


    }
    public function getPredefined($POST)
    {
        $result = array();
        if(!isset($POST['page_size'])){
            $POST['page_size'] = 0;
        }
        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];
		$parameters = '';
		//echo"<pre>";print_r($POST);die;
		if(isset($POST['psearch_title']) && $POST['psearch_title'] != '')
		{
		    if(is_array($POST['psearch_title']) && count($POST['psearch_title']) > 0){
                $POST['psearch_title'] = implode(',',$POST['psearch_title']);
            }
            $title = explode(',', $POST['psearch_title']);

            $temp = array();
            foreach($title as $Key=>$val){
                $temp[] = " psearch_title LIKE '%".$val."%' ";
            }


            $temp_q = implode(' OR ',$temp);
            $parameters .=  " AND (".$temp_q.")";
			//$parameters .= " AND psearch_title LIKE '%".$POST['psearch_title']."%' ";
		}
	    if(isset($POST['psearch_tag']) && $POST['psearch_tag'] !='')
	    {
            if(is_array($POST['psearch_tag']) && count($POST['psearch_tag']) > 0){
                $POST['psearch_tag'] = implode(',',$POST['psearch_tag']);
            }

            $tag = explode(',', $POST['psearch_tag']);

            $temp = array();
            foreach($tag as $Key=>$val){
                $temp[] = " FIND_IN_SET('".$val."', psearch_tag) ";
            }

            $temp_q = implode(' OR ',$temp);
            $parameters .=  " AND (".$temp_q.")";

            //$parameters .= " AND FIND_IN_SET('".$POST['psearch_tag']."', psearch_tag)";
	    }

	    if(isset($POST['agent_sys_name']) && $POST['agent_sys_name'] != '')
        {
            $parameters .= " AND psearch_sys_name = '".$POST['agent_sys_name']. "'";
        }

	    $param = "ORDER BY psearch_title ASC LIMIT ". $startRecord .",".$POST['page_size'];
        $rsPredefined = parent::getAll($parameters.$param);

        $arresult = $rsPredefined->fetch_array();
        $result['rsPredefined'] = array();
        foreach($arresult as $Record)
        {
	        $Record['psearch_count'] =  $this->getPredefinedSearchCountById($Record['psearch_id']);
			array_push($result['rsPredefined'],$Record);
        }

        $totalFetched = parent::ViewAll($parameters, true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }
    public function getPredefinedSearchById($POST)
    {
        $rs = parent::getInfoById($POST);
        return $rs;
    }
	public function getPredefinedSearchByTitle($title)
	{
		$param = '';
		//$param .= " AND psearch_title LIKE '".$title."'";
        $param .= " AND Replace(psearch_title , '-', ' ') LIKE '".$title."'";
        
        
		$rs = parent::getInfoByParam($param);
		return $rs;
	}
	public function getPreDefineStatisticById($id)
	{
		global $db;
		if(!is_numeric($id))
		{
			return false;
		}

		$sql = "SELECT * FROM ".$this->Data['StatisticTable']. " WHERE 1 AND statistic_type = 'Market' AND statistic_ref_id = '".$id."'";
		$rs = $db->query($sql);
		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}
    public function updatePredefinedSearch($POST)
    {
        if(isset($POST['psearch_tag']) && $POST['psearch_tag'] != '')
	    {
		    $POST['psearch_tag'] = str_replace(', ',',',$POST['psearch_tag']);
	    }

        if(isset($POST['psearch_generate_mrktreport']) && $POST['psearch_generate_mrktreport'] == 'Yes')
        {
            $arr['psearch_criteria'] = $POST['psearch_criteria'];
            $arr['ref_id'] = $POST['pk'];

            MarketTrend::getInstance()->InsertSearchCriteriaWiseStatistic($arr);

        }
        else{
            $POST['psearch_generate_mrktreport'] = 'No';
            $ref_id = $POST['pk'];
            MarketTrend::getInstance()->DeleteStatistic('Market', $ref_id);
        }

        if(!isset($POST['psearch_display_tab']))
	    {
		    $POST['psearch_display_tab'] = 'No';
	    }
	    if(!isset($POST['psearch_generate_rental']))
	    {
		    $POST['psearch_generate_rental'] = 'No';
	    }

        $POST['psearch_monthwise_report']   = isset($POST['psearch_monthwise_report']) && $POST['psearch_monthwise_report'] == 'Yes' ? 'Yes' : 'No'; 

        // echo "<pre>"; print_r($POST);die;
        $rs = parent::Update($POST['pk'], $POST);
        return $rs;
    }
    public function deletePredefinedSearch($POST)
    {
        $rs = parent::Delete($POST);
        MarketTrend::getInstance()->DeleteStatistic('Market', $POST);
        return true;
    }
    public function getPredefinedSearchCountById($id)
    {

        $rsPredefined = $this->getPredefinedSearchById($id);

        $searchParams = unserialize($rsPredefined['psearch_criteria']);

        $count = IDXListing::obj()->getListingCountByParam($searchParams);

        return $count;

    }
    public function getListingByPreSearch($POST)
    {
        if(isset($POST['pid']) && is_numeric($POST['pid'])){

            $rsPredefined = $this->getPredefinedSearchById($POST['pid']);

            if (is_array($rsPredefined) && count($rsPredefined) > 0){

                $searchParam = unserialize($rsPredefined['psearch_criteria']);

                $searchParam['getMapData'] = true;
                $searchParam['page_size'] = $POST['page_size'];
                $searchParam['start_record'] = $POST['start_record'];
               if(isset($POST['so']) &&  $POST['so'] != '' && isset($POST['sd']) && $POST['sd'] != '')
                {
	                $searchParam['so'] = $POST['so'];
	                $searchParam['sd'] = $POST['sd'];
                }
	            else if(isset($searchParam['sort_by']) && $searchParam['sort_by'] != '')
	            {
		            $arrsort = explode('|', $searchParam['sort_by']);
		            $searchParam['so'] = (isset($arrsort[0]) && $arrsort[0] != ''? $arrsort[0]:Constants::DEFAULT_SO);
		            $searchParam['sd'] = (isset($arrsort[1]) && $arrsort[1] != ''? $arrsort[1]:Constants::DEFAULT_SD);
		            unset($searchParam['sort_by']);
	            }
                $searchParam['formatURL'] = $POST['formatURL'];
                $searchParam = array_merge($searchParam, $POST);
                //$arrParam = Utility::obj()->SearchParamAndURL(false, $searchParam);

                $rsListing = IDXListing::obj()->getListingByParam($searchParam, '', 'map');
                $rsResult = array(
                    'searchParam' => $searchParam,
                    'arrRssult' => $rsListing,
                    'psearch_criteria' => $rsPredefined
                );
                return $rsResult;
            }

        }else{
            return false;
        }

    }
}