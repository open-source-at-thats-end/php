<?php
class AdminMarketReports extends AdminModule {

    private static $instance ;
    private $action;

    protected function __construct(){

    }

    public static function getInstance(){
        if( !isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function requestHandler($isAjaxRequest=false, $moduleKey) {

        parent::requestHandler($isAjaxRequest, $moduleKey);

        $this->baseUrl = admin_url('admin.php?page='.Constants::SLUG.'-'.$this->__moduleKey);

        switch($this->_action)
        {
            case 'add':
                $this->add();
                break;
            case 'edit':
                $this->add();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                $this->manage();
                break;
        }
    }
    public function manage()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        $objAPI = IDXAPI::getInstance();

        if(isset($_GET['add']) && $_GET['add']==true)
            $msgSuccess =  "Market Report has been added successfully.";
        elseif(isset($_GET['save']) && $_GET['save']==true)
            $msgSuccess = "Market Report has been saved successfully.";
        elseif(isset($_GET['delete']) && $_GET['delete']==true)
            $msgSuccess = "Market Report has been deleted successfully.";

        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;
        $rsMarketRepo = $objAPI->getMarketReports($arrParams);

        $objTmpl->assign(array( 'T_Body'		=>	'market-report/market-report.tpl' ,
            'scriptname'    =>  $this->baseUrl,
            'rsMarketRepo'	=>	$rsMarketRepo['rsMarketRepo'],
            "total_record"	=>	count($rsMarketRepo['rsMarketRepo']),
            'totalFetched' =>  $rsMarketRepo['totalFetched'],
            'page_size'     =>  Constants::PAGE_SIZE,
            'startRecord'  =>  $rsMarketRepo['startRecord'],
            'msgSuccess'	=>	$msgSuccess,
        ));
    }
    public function add()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        $objAPI = IDXAPI::getInstance();

        if(isset($_POST['Submit']) && $_POST['Submit'] == 'Save'){
            if($this->_action == 'add')
            {
                $param['mr_city'] = $_POST['mr_city'];
                $city = $objAPI->getMarketReportsByParam($param);

                if(empty($city))
                {
                    $objAPI->InsertMarketReports($_POST);
                    header("location: $this->baseUrl&add=true");
                    exit(0);
                }
                else{
                    $msgError = 'City already exists in our records - please enter a different city.';
                }

            }
            elseif($this->_action == 'edit')
            {
                $update = $objAPI->updateMarketReports($_POST);
                if ($update){
                    header("location: $this->baseUrl&save=true");
                    exit(0);
                }
                else{
                    $msgError = 'Something went wrong.';
                }
            }
        }


        wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'].'jQuery/validate/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'].'jQuery/validate/additional-methods.js', array('jquery'));

        # JQuery Input Masking
        wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'].'jQuery/jquery.maskedinput.min.js', array('jquery'));


        if($this->_action == 'edit')
        {
            $pk = $_GET['pk'];
            $rsMarketRepo = $objAPI->getMarketReportsById($pk);

            $objTmpl->assign(array(
                'rsMarketRepo'   => $rsMarketRepo,
                'pk'        => $pk
            ));
        }

        $city = $objAPI->getCityKeyValueArray('');
        $allCity[''] = 'select';
        $arrCity = array_merge($allCity,$city);

        $objTmpl->assign(array('T_Body'     => 'market-report/market-report-add.tpl', //'A_Action'		=>	$scriptName,
            'scriptname' => $this->baseUrl,
            'City'       => $arrCity,
            'msgError'	=>	$msgError,

        ));

    }
    function delete()
    {
        $objAPI = IDXAPI::getInstance();

        $delete = $objAPI->deleteMarketReports($_GET['pk']);

        if($delete){
            header("location: $this->baseUrl&delete=true");
        }else{
            header("location: $this->baseUrl&error=true");
        }

        exit(0);
    }
}

?>