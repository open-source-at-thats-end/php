<?php

require_once(dirname(__FILE__) . '/CustomClass.php');

class CondoSearch extends CustomClass
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
        $this->Data['TableName']			        =	'condo_searches';
        $this->Data['StatisticTable']			    =	'listing_statistic';
        $this->Data['F_PrimaryKey']                 =   'csearch_id';
        $this->Data['F_FieldInfo']				    =
            array(
                'csearch_name'                      =>	array(	'title'			=>	'Title',
                    'c_type'		=>	'text',
                ),
                'csearch_criteria'                  =>	array(	'title'			=>	'Criteria',
                    'c_type'		=>	'text',
                ),
                'csearch_result_limit'              =>	array(	'title'			=>	'Result Limit',
                    'c_type'		=>	'text',
                ),
                'csearch_tag'                       =>	array(	'title'			=>	'Tag',
                    'c_type'		=>	'text',
                ),
                'csearch_address'                   =>	array(	'title'			=>	'Address',
                    'c_type'		=>	'text',
                ),
                'csearch_city'                      =>	array(	'title'			=>	'City',
                    'c_type'		=>	'text',
                ),
                'csearch_zipcode'                   =>	array(	'title'			=>	'ZipCode',
                    'c_type'		=>	'text',
                ),
                'csearch_short_desc'                =>	array(	'title'			=>	'Short Description',
                    'c_type'		=>	'text',
                ),
                'csearch_year_built'                =>	array(	'title'			=>	'Year Built',
                    'c_type'		=>	'text',
                ),
                'csearch_unit'                      =>	array(	'title'			=>	'Unit',
                    'c_type'		=>	'text',
                ),
                'csearch_stories'                   =>	array(	'title'			=>	'Stories',
                    'c_type'		=>	'text',
                ),
                'csearch_sys_name'                  =>	array(	'title'			=>	'Agent System Name',
                    'c_type'		=>	'text',
                ),
                'csearch_is_visible'               =>	array(	'title'			=>	'Is Visible',

                ),
                'csearch_photo_video_url'           =>	array(	'title'			=>	'Photo/Video URL',
                    'c_type'		=>	'text',
                ),
                'csearch_added_date'                =>	array(	'title'			=>	'Added Date',
                    'c_type'		=>	C_HIDDEN,
                ),
                'csearch_added_by_id'               =>	array(	'title'			=>	'Added Id',
                    'c_type'		=>	'text',
                ),
                'csearch_added_by_type'             =>	array(	'title'			=>	'Added Type',
                    'c_type'		=>	'text',
                ),
                 'csearch_generate_mrktreport'       =>	array(	'title'			=>	'Generate Market Report',
                    'c_type'		=>	'text',
                ),
                'csearch_display_in_agent'                =>	array(	'title'			=>	'Display in Agent',
                    'c_type'		=>	'text',
                ),
                'csearch_building'                =>	array(	'title'			=>	'Building',
                    'c_type'		=>	'text',
                ),
                'csearch_luxury'                =>	array(	'title'			=>	'Luxury',
                    'c_type'		=>	'text',
                ),
                'csearch_neighborhood'                =>	array(	'title'			=>	'Neighborhood',
                    'c_type'		=>	'text',
                ),
                'csearch_amenities'                =>	array(	'title'			=>	'Amenities',
                    'c_type'		=>	'text',
                ),
                'csearch_min_price'                =>	array(	'title'			=>	'Min Price',
                    'c_type'		=>	'text',
                ),
                'csearch_max_price'                =>	array(	'title'			=>	'Max Price',
                    'c_type'		=>	'text',
                ),
                'csearch_image_path'                =>	array(	'title'			=>	'Image Path',
                    'c_type'		=>	'text',
                ),
                'csearch_min_MLS_NUM'                =>	array(	'title'			=>	'Min MLS_NUM',
                    'c_type'		=>	'text',
                ),
                'csearch_max_MLS_NUM'                =>	array(	'title'			=>	'Max MLS_NUM',
                    'c_type'		=>	'text',
                ),
                'csearch_pet_friendly'                =>	array(	'title'			=>	'Pet Friendly',
                    'c_type'		=>	'text',
                ),
                'csearch_rental_restrictions'                =>	array(	'title'			=>	'Rental Restrictions',
                    'c_type'		=>	'text',
                ),
                'csearch_min_sqft'                =>	array(	'title'			=>	'Min Sqft',
                    'c_type'		=>	'text',
                ),
                'csearch_max_sqft'                =>	array(	'title'			=>	'Max Sqft',
                    'c_type'		=>	'text',
                ),
                'csearch_updated_date'                =>	array(	'title'			=>	'Update Date',
                    'c_type'		=>	C_HIDDEN,
                ),
            );
        parent::__construct();
    }

    public function addCondoSearch($POST)
    {
        $id = parent::Insert($POST);

        if($id > 0)
        {
                $arr['csearch_criteria'] = $POST['csearch_criteria'];
                $arr['ref_id'] = $id;
                MarketTrend::getInstance()->InsertCondoWiseStatistic($arr);
                return $id;
        }else{
            return array('id' => $id);
        }
    }

    public function getCondo($POST)
    {
        $result = array();
        if(!isset($POST['page_size'])){
            $POST['page_size'] = 0;
        }
        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];
        $parameters = '';

        if(isset($POST['csearch_name']) && $POST['csearch_name'] != '')
        {
            if(is_array($POST['csearch_name']) && count($POST['csearch_name']) > 0){
                $POST['csearch_name'] = implode(',',$POST['csearch_name']);
            }
            $title = explode(',', $POST['csearch_name']);

            $temp = array();
            foreach($title as $Key=>$val){
                $temp[] = " csearch_name LIKE '%".$val."%' ";
            }

            $temp_q = implode(' OR ',$temp);
            $parameters .=  " AND (".$temp_q.")";
        }

        if(isset($POST['csearch_address']) && $POST['csearch_address'] != '')
        {
            /*if(is_array($POST['csearch_name']) && count($POST['csearch_name']) > 0){
                $POST['csearch_name'] = implode(',',$POST['csearch_name']);
            }*/
            $title = explode(',', $POST['csearch_address']);

            $temp = array();
            foreach($title as $Key=>$val){
                $temp[] = " csearch_address LIKE '%".$val."%' ";
            }

            $temp_q = implode(' OR ',$temp);
            $parameters .=  " AND (".$temp_q.")";
        }

        if(isset($POST['agent_sys_name']) && $POST['agent_sys_name'] != '')
        {
            $parameters .= " AND csearch_sys_name = '".$POST['agent_sys_name']. "'";
        }
        if(isset($POST['csearch_display_in_agent']) && $POST['csearch_display_in_agent'] != '')
        {
            $parameters .= "' csearch_updated_date >= '".$POST['csearch_updated_date']."'";
        }
        $param = "ORDER BY csearch_name ASC";

        if(!isset($POST['fetch_all']) && $POST['fetch_all'] == false) {
            $param .= " LIMIT " . $startRecord . "," . $POST['page_size'];
        }

        //$param = "ORDER BY csearch_name ASC LIMIT ". $startRecord .",".$POST['page_size'];
        $rsCondo = parent::getAll($parameters.$param);

        $arresult = $rsCondo->fetch_array();

        if(isset($POST['is_cronjob']) && $POST['is_cronjob']==true)
        {
//                file_put_contents('result.txt', print_r($arresult,true),FILE_APPEND);
                return $arresult;
        }
        $result['rsCondo'] = array();
        foreach($arresult as $Record)
        {
            $Record['csearch_count'] =  $this->getCondoSearchCountById($Record['csearch_id']);
            array_push($result['rsCondo'],$Record);
        }

        $totalFetched = parent::ViewAll($parameters, true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }

    public function getCondoSearchCountById($id)
    {
        $rsCondo = $this->getCondoSearchById($id);

        $searchParams = unserialize($rsCondo['csearch_criteria']);

        $count = IDXListing::obj()->getListingCountByParam($searchParams);

        return $count;

    }

    public function getCondoSearchById($POST)
    {
        $rs = parent::getInfoById($POST);
        return $rs;
    }

    public function updateCondoSearch($POST)
    {  
        file_put_contents('response-update.txt',print_r($POST,true), FILE_APPEND);
        $arr['csearch_criteria'] = $POST['csearch_criteria'];
        $arr['ref_id'] = $POST['pk'];
		
        MarketTrend::getInstance()->InsertCondoWiseStatistic($arr);

        /*if(isset($POST['psearch_generate_mrktreport']) && $POST['psearch_generate_mrktreport'] == 'Yes')
        {
            $arr['psearch_criteria'] = $POST['psearch_criteria'];
            $arr['ref_id'] = $POST['pk'];

            MarketTrend::getInstance()->InsertSearchCriteriaWiseStatistic($arr);

        }
        else{
            $POST['psearch_generate_mrktreport'] = 'No';
            $ref_id = $POST['pk'];
            MarketTrend::getInstance()->DeleteStatistic('Market', $ref_id);
        }*/

        $rs = parent::Update($POST['pk'], $POST);
        // echo "<pre>"; print_r($rs); die;
        return $rs;
    }

    public function deleteCondoSearch($POST)
    {
        $rs = parent::Delete($POST);
        //MarketTrend::getInstance()->DeleteStatistic('Market', $POST);
        return true;
    }

    public function getCondoStatisticById($id)
    {
        global $db;
        if(!is_numeric($id))
        {
            return false;
        }

        $sql = "SELECT * FROM ".$this->Data['StatisticTable']. " WHERE 1 AND statistic_type = 'Condo' AND statistic_ref_id = '".$id."'";
        $rs = $db->query($sql);
        return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
    }

    public function getCondoSearchByName($title)
    {
        $param = '';
        $param .= " AND csearch_name LIKE '".$title."'";
        $rs = parent::getInfoByParam($param);
        return $rs;
    }

    public function getCondoMinMaxFields($id, $cseachCriteria)
    {
        global $db;
        // echo "<pre>"; print_r($cseachCriteria);die;
        // echo "<pre>"; print_r($id);die;
        if (isset($cseachCriteria) && !empty($cseachCriteria)) {
            $searchParams = unserialize($cseachCriteria);
            // echo "<pre>"; print_r($searchParams);die;
            $query = IDXListing::obj()->getQueryParameters($searchParams);
            // echo "<pre>"; print_r($query);die;

            $sql = "select X.MLS_NUM as Min_MLS_NUM, minprice, Y.MLS_NUM as Max_MLS_NUM, maxprice
            from
            (
            select MLS_NUM, ListPrice as minprice from  trigger_search_by_mapsearch
            where ListPrice =(select min(ListPrice) from  trigger_search_by_mapsearch M WHERE ListPrice != 0 AND PropertyType = 'Residential' $query Limit 1)
            )X cross join
            (
            select MLS_NUM, ListPrice as maxprice from  trigger_search_by_mapsearch
            where ListPrice =(select max(ListPrice) from  trigger_search_by_mapsearch M WHERE ListPrice != 0 AND PropertyType = 'Residential' $query Limit 1)
            )Y";

            $sql1 = "select X.MLS_NUM as Min_MLS_NUM, minsqft, Y.MLS_NUM as Max_MLS_NUM, maxsqft
            from
            (
            select MLS_NUM, SQFT as minsqft from  trigger_search_by_mapsearch
            where SQFT =(select min(SQFT) from  trigger_search_by_mapsearch M WHERE SQFT != 0  $query Limit 1)
            )X cross join
            (
            select MLS_NUM, SQFT as maxsqft from  trigger_search_by_mapsearch
            where SQFT =(select max(SQFT) from  trigger_search_by_mapsearch M WHERE SQFT != 0  $query Limit 1)
            )Y";
            
            // echo "<pre>"; print_r($sql);die;
            $rs = $db->query($sql);
            $rs1 = $db->query($sql1);
            // echo "<pre>"; print_r($rs->fetch_array(MYSQLI_FETCH_SINGLE));die;
            $result = $rs->fetch_array(MYSQLI_FETCH_SINGLE);
            $result1 = $rs1->fetch_array(MYSQLI_FETCH_SINGLE);
            // echo "<pre>"; print_r($result1);die;

            if ((isset($result) && $result != '') && (isset($result1) && $result1 != '')) {
                $searchById = IDXListing::obj()->getImageurlById($result['Max_MLS_NUM']);
                // echo "<pre>"; print_r($searchById['MainPicture']);
        
                $POST['csearch_min_price'] = $result['minprice'];
                $POST['csearch_max_price'] = $result['maxprice'];
                $POST['csearch_min_MLS_NUM'] = $result['Min_MLS_NUM'];
                $POST['csearch_max_MLS_NUM'] = $result['Max_MLS_NUM'];
                $POST['csearch_min_sqft'] = $result1['minsqft'];
                $POST['csearch_max_sqft'] = $result1['maxsqft'];
                $POST['csearch_image_path'] = $searchById['MainPicture'];
        
                $rst = parent::Update($id, $POST);
                // echo "<pre>"; print_r($rst);die;
                return $rst;
            }
            else {
                return false;
            }
            
        }
    }

    public function getCondoSearch()
    {
        global $db;

        $sql = "SELECT * FROM ".$this->Data['TableName']. " WHERE 1";
        // echo "<pre>"; print_r($sql); die;
        $rs = $db->query($sql);
        return $rs->fetch_array();
    }
}

?>