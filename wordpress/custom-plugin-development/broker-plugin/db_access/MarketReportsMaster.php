<?php

require_once(dirname(__FILE__) . '/CustomClass.php');
require_once(dirname(__FILE__) . '/MarketTrend.php');

class MarketReportsMaster extends CustomClass
{
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

        $this->Data['TableName']			        =	'market_reports';
        $this->Data['F_PrimaryKey']                 =   'mr_id';
        $this->Data['F_FieldInfo']				    =
            array(
                'mr_name'                     =>	array(	'title'			=>	'Name',
                    'c_type'		=>	'text',
                ),
                'mr_desc'               =>	array(	'title'			=>	'Description',
                    'c_type'		=>	'text',
                ),
                'mr_city'               =>	array(	'title'			=>	'City',
                    'c_type'		=>	'text',
                ),
            );
        parent::__construct();
    }
    public function InsertMarketReports($POST)
    {
        $id = parent::Insert($POST);

        if($id > 0)
        {
            $arr['city'] = $POST['mr_city'];
            $arr['ref_id'] = $id;
            MarketTrend::getInstance()->InsertCityWiseStatistic($arr);
            return $id;
        }
        else{
            return false;
        }
    }
    public function getMarketReportsByParam($POST)
    {
        $param = '';
        if(isset($POST['mr_city']) && $POST['mr_city'] != '')
        {
            $param .= " AND mr_city = '" . $POST['mr_city'] . "'";
        }
        if(isset($POST['mr_id']) && $POST['mr_id'] != '')
        {
            $param .= " AND mr_id != '" . $POST['mr_id'] . "'";
        }

        return $rs = parent::getInfoByParam($param);

    }
    public function getMarketReports($POST)
    {
        $result = array();
        if(!isset($POST['page_size'])){
            $POST['page_size'] = 0;
        }
        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

        $param = "ORDER BY mr_id ASC LIMIT ". $startRecord .",".$POST['page_size'];
        $rsMarketRepo = parent::getAll($param);

        $result['rsMarketRepo'] = $rsMarketRepo->fetch_array();
        $totalFetched = parent::ViewAll('', true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }
    public function getMarketReportsById($POST)
    {
        $rs = parent::getInfoById($POST);
        return $rs;
    }
    public function updateMarketReports($POST)
    {
        $rs = parent::Update($POST['pk'], $POST);
        return $rs;
    }
    public function deleteMarketReports($POST)
    {
        $rs = parent::Delete($POST);
        MarketTrend::getInstance()->DeleteStatistic('City', $POST);
        return true;
    }
    public function getAllMarketReports()
    {
        $rs = parent::ViewAll('', true);
        return $rs->fetch_array();
    }
}
?>