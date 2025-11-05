<?php

require_once(dirname(__FILE__) . '/CustomClass.php');
include_once($arrPhysicalPath['Libs']."aws/aws-autoloader.php");

class Development extends CustomClass
{
    private static $instance;

    public static function getInstance()
    { file_put_contents('123.txt',print_r('123123123',true),FILE_APPEND);
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected function __construct()
    {
        $this->Data['TableName']			        =	'development_page_info';
        $this->Data['StatisticTable']			    =	'listing_statistic';
        $this->Data['F_PrimaryKey']                 =   'dev_id';
        $this->Data['F_FieldInfo']				    =
            array(
                'dev_title'                         =>	array(	'title'			=>	'Title',
                    'c_type'		=>	'text',
                ),
                'dev_criteria'                      =>	array(	'title'			=>	'Criteria',
                    'c_type'		=>	'text',
                ),
                'dev_content_head'                  =>	array(	'title'			=>	'Head Content',
                    'c_type'		=>	'text',
                ),
                'dev_content_build_info'            =>	array(	'title'			=>	'Building Info',
                    'c_type'		=>	'text',
                ),
                'dev_content_footer'                =>	array(	'title'			=>	'Footer Content',
                    'c_type'		=>	'text',
                ),
                'dev_require_reg'                   =>	array(	'title'			=>	'Require Registration',
                    'c_type'		=>	'text',
                ),
                'dev_link1'                     =>	array(	'title'			=>	'Link 1',
                    'c_type'		=>	'text',
                ),
                'dev_link2'                     =>	array(	'title'			=>	'Link 2',
                    'c_type'		=>	'text',
                ),
                'dev_link3'                     =>	array(	'title'			=>	'Link 3',
                    'c_type'		=>	'text',
                ),
                'dev_google_map_code'               =>	array(	'title'			=>	'Google Embeded Code',
                    'c_type'		=>	'text',
                ),
                'dev_added_date'                    =>	array(	'title'			=>	'Added Date',
                    'c_type'		=>	C_HIDDEN,
                ),

            );
        parent::__construct();
    }

    public function addDevelopmentPage($POST)
    {
        global $arrPhysicalPath,$physical_path;

        $id = parent::Insert($POST);

        if($id > 0)
        {
            return $id;
        }else{
            return array('id' => $id);
        }
    }

    public function getDevelopment($POST)
    {
        $result = array();
        if(!isset($POST['page_size'])){
            $POST['page_size'] = 0;
        }
        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];
        $parameters = '';

        if(isset($POST['dev_title']) && $POST['dev_title'] != '')
        {
            $parameters .= " AND dev_title LIKE '%".$POST['dev_title']. "%' ";
        }

        $param = "ORDER BY dev_title ASC LIMIT ". $startRecord .",".$POST['page_size'];
        $rsDevelopment = parent::getAll($parameters.$param);

        $arresult = $rsDevelopment->fetch_array();

        $result['rsDevelopment'] = array();
        foreach($arresult as $Record)
        {
            array_push($result['rsDevelopment'],$Record);
        }

        $totalFetched = parent::ViewAll($parameters, true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }

    /*public function getCondoSearchCountById($id)
    {
        $rsCondo = $this->getCondoSearchById($id);

        $searchParams = unserialize($rsCondo['csearch_criteria']);

        $count = IDXListing::obj()->getListingCountByParam($searchParams);

        return $count;

    }*/

    public function getDevelopmentPageById($POST)
    {
        $rs = parent::getInfoById($POST);
        return $rs;
    }

    public function updateDevelopmentPage($POST)
    {
        global $arrPhysicalPath;
        $rs = parent::Update($POST['pk'], $POST);

        return $rs;
    }

    public function deleteDevelopmentPage($POST)
    {
        $rs = parent::Delete($POST);

        return true;
    }

    public function getCondoSearchByName($title)
    {
        $param = '';
        $param .= " AND csearch_name LIKE '".$title."'";
        $rs = parent::getInfoByParam($param);
        return $rs;
    }
    public function getDevelopmentPagePreId($type=MYSQLI_FETCH_SINGLE){
        global $db;

        $sql = "SELECT MAX(dev_id) as LatestId FROM ".$this->Data['TableName'];

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        # Execute query
        $db->query($sql);

        $rs = $db->query($sql);

        $result = $rs->fetch_array($type);
        $preId = $result[0]['LatestId'] + 1;

        return $preId;
    }
}

?>