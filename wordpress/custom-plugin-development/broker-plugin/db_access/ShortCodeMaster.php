<?php

require_once(dirname(__FILE__) . '/CustomClass.php');

class ShortCodeMaster extends CustomClass {

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

        $this->Data['TableName']			        =	'shortcode_master';
        $this->Data['F_PrimaryKey']                 =   'shortcode_id';
        $this->Data['F_FieldInfo']				    =
            array(
                'shortcode_name'                     =>	array(	'title'			=>	'Name',
                    'c_type'		=>	'text',
                ),
                'shortcode_detail'               =>	array(	'title'			=>	'Detail',
                    'c_type'		=>	'text',
                ),
            );
        parent::__construct();
    }
    public function addShortcode($POST)
    {
        $id = parent::Insert($POST);
        return array('id' => $id);
    }
    public function getShortcode($POST)
    {
        $result = array();
        if(!isset($POST['page_size'])){
            $POST['page_size'] = 0;
        }
        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];

        $param = "ORDER BY shortcode_id ASC LIMIT ". $startRecord .",".$POST['page_size'];
        $rsShortCode = parent::getAll($param);

        $result['rsShortCode'] = $rsShortCode->fetch_array();
        $totalFetched = parent::ViewAll('', true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }
    public function getShortcodeById($POST)
    {
        $rs = parent::getInfoById($POST);
        return $rs;
    }
    public function updateShortcode($POST){
        $rs = parent::Update($POST['pk'], $POST);
        return $rs;
    }
    public function deleteShortcode($POST){
        $rs = parent::Delete($POST);
        return true;
    }
    public function viewAllShortcode(){
        $rs = parent::ViewAll('', true);
        return $rs->fetch_array();
    }
}