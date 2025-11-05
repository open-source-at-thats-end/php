<?php
class AdminCondo extends AdminModule
{
    private static $instance;
    private $action;

    protected function __construct()
    {


    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function requestHandler($isAjaxRequest = false, $moduleKey)
    {
        parent::requestHandler($isAjaxRequest, $moduleKey);

        $this->__isAjaxRequest = $isAjaxRequest;
        $this->__moduleKey = $moduleKey;

        if($this->__isAjaxRequest) {
            $this->_action 		= strtolower($_POST['ajax_mod']);
            $this->_subaction 	= $_POST['ajax_subaction'];
        } else {
            // For non-ajax requests
            $this->baseUrl = admin_url('admin.php?page='.constants::SLUG.'-'.$this->__moduleKey);
        }

        switch ($this->_action) {
            case 'add':
                $this->add();
                break;
            case 'edit':
                $this->add();
                break;
            case 'condo-search':
                $this->manage();
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
        global $arrVirtualPath, $arrConfig, $objTmpl;

        wp_enqueue_script('condo-js',              $arrVirtualPath['TemplateJs']. 'condo.js', array( 'jquery' ));
        wp_localize_script(	'condo-js',
            'objcondoAjax',
            array('action' => 'admin_ajax', 'condo_mod' => $this->__moduleKey, 'condo_action' => admin_url('admin-ajax.php')));

        if (isset($_GET['add']) && $_GET['add'] == true)
            $msgSuccess = "Condo search has been added successfully.";
        elseif (isset($_GET['save']) && $_GET['save'] == true)
            $msgSuccess = "Condo search has been saved successfully.";
        elseif (isset($_GET['delete']) && $_GET['delete'] == true)
            $msgSuccess = "Condo search has been deleted successfully.";

        $objAPI = IDXAPI::getInstance();
        $arrParams['page_size']         = Constants::CONDO_PAGE_SIZE;
        $arrParams['page_current']      = isset($_GET['cpage'])?$_GET['cpage']:1;
        $arrParams['agent_sys_name']    = Constants::MARBEACHES; //((isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)?Constants::ACTRIS:Constants::MARBEACHES);

        $arrParams  = array_merge($_GET,$arrParams);
        $rsCondo    = $objAPI->getCondo($arrParams);

        $arrPre = array();
        $setting  =array('textarea_rows'=> '10');
        foreach ($rsCondo['rsCondo'] as $key=>$val)
        {
            $shortcode = '[condo-search-result cid=';

            $shortcode .= $val['csearch_id'].']';


            $arrPre[$key] = array(
                'csearch_id'            => $val['csearch_id'],
                'csearch_name'          => $val['csearch_name'],
                'csearch_address'       => $val['csearch_address'],
                'csearch_added_date'    => $val['csearch_added_date'],
                'csearch_tag'           => $val['csearch_tag'],
                'csearch_display_in_agent'           => $val['csearch_display_in_agent'],
                'csearch_criteria'      => unserialize($val['csearch_criteria']),
                'shortcode'             => $shortcode,
            );
        }

        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');
        wp_enqueue_script('condo-js',              $arrVirtualPath['TemplateJs']. 'condo.js', array( 'jquery' ));
        if(isset($_POST['scriptname']) && $_POST['scriptname'] != '')
        {
            $this->baseUrl = $_POST['scriptname'];
        }
        $objTmpl->assign(array(
            'scriptname'    => $this->baseUrl,
            'rsCondo'       => $arrPre,
            "total_record"	=> count($rsCondo['rsCondo']),
            'totalFetched'  => $rsCondo['totalFetched'],
            'page_size'	    => Constants::CONDO_PAGE_SIZE,
            'startRecord'   => $rsCondo['startRecord'],
            'objAdminCon'   => AdminCondo::getInstance(),
            'msgSuccess'    => $msgSuccess,
            'arrPageSize'	=> StaticArray::arrPageSize(),
            'arrParams'     => $arrParams,
            'page'          => $_GET['page'],
            'setting'          => $setting,

        ));

        if(!$this->__isAjaxRequest){

            $objTmpl->assign(array(
                'T_Body'            => 'condo/condo.tpl',
            ));
        }else{

            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false || strpos($_SERVER['HTTP_HOST'], 'project') !== false)
            {
                $_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-condo';
            }else{
                $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-condo';
            }
            AjaxResponse::obj()->assign($objTmpl->fetch('condo/condo-list.tpl'), '.frmStdForm');
            AjaxResponse::obj()->assign($objTmpl->fetch('condo/condo-pagination.tpl'), '#pre-pagination');

            AjaxResponse::obj()->call_request_area();

            echo AjaxResponse::obj()->send();
            exit();
        }
    }

    public function add()
    {
        global $arrVirtualPath, $arrConfig, $objTmpl;

        $objAPI = IDXAPI::getInstance();

        wp_enqueue_script('condo-js',              $arrVirtualPath['TemplateJs']. 'condo.js', array( 'jquery' ));
        wp_localize_script(	'condo-js', 'objcondoAjax', array('action' => 'admin_ajax', 'condo_mod' => $this->__moduleKey, 'condo_action' => admin_url('admin-ajax.php')));

        if(!$this->__isAjaxRequest)
        {
            if($this->_action == 'add' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save')
            {
                unset($_POST['Submit']);
                unset($_POST['Action']);

                if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS && !isset($_POST['sys_name']))
                {
                    $_POST['sys_name']          = Constants::MLS_ACTRIS;
                    $_POST['csearch_sys_name']  = Constants::ACTRIS;
                }
                else
                {
                    $_POST['csearch_sys_name'] = Constants::MARBEACHES;
                }

                $searchParams = $_POST;

                unset($searchParams['csearch_name'],$searchParams['csearch_result_limit'],$searchParams['csearch_tag'],$searchParams['csearch_address'],$searchParams['csearch_city'],$searchParams['csearch_zipcode'],$searchParams['csearch_year_built'],$searchParams['csearch_unit'],$searchParams['csearch_stories'],$searchParams['csearch_short_desc'],$searchParams['csearch_is_visible'],$searchParams['csearch_sys_name'],$searchParams['csearch_generate_mrktreport'],$searchParams['pk']);

                $_POST['csearch_criteria']      = serialize(array_filter($searchParams));
                $_POST['csearch_added_date'] 	= date('Y-m-d');
                $_POST['csearch_updated_date'] 	    = date('Y-m-d');
                $_POST['csearch_generate_mrktreport']  = isset($_POST['csearch_generate_mrktreport']) && $_POST['csearch_generate_mrktreport'] == 'Yes' ? 'Yes' : 'No'; 
                $_POST['csearch_display_in_agent']  = isset($_POST['csearch_display_in_agent']) && $_POST['csearch_display_in_agent'] == 'Yes' ? 'Yes' : 'No'; 
                $_POST['csearch_building']  = isset($_POST['csearch_building']) && $_POST['csearch_building'] == 'Yes' ? 'Yes' : 'No'; 
                $_POST['csearch_luxury']  = isset($_POST['csearch_luxury']) && $_POST['csearch_luxury'] == 'Yes' ? 'Yes' : 'No';
                $_POST['csearch_pet_friendly']  = isset($_POST['csearch_pet_friendly']) && $_POST['csearch_pet_friendly'] == 'Yes' ? 'Yes' : 'No'; 
				// // echo "<pre>"; print_r($_POST); die;
                $insert = $objAPI->addCondoSearch($_POST);
				// echo "<pre>"; print_r($insert); die;
                // $condoMinMaxSearch = CondoSearch::getInstance()->getCondoMinMaxFields($insert['id'],$_POST['csearch_criteria']);
                // echo "<pre>"; print_r($condoMinMaxSearch);die;
                if($insert)
                {
                    header("location: $this->baseUrl&add=true");
                    exit(0);
                }
                else{
                    $msgError = 'Something went wrong.';
                }
            }
            elseif($this->_action == 'edit' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save')
            {
                unset($_POST['Submit']);
                unset($_POST['Action']);

                if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS && !isset($_POST['sys_name']))
                {
                    $_POST['sys_name'] = Constants::MLS_ACTRIS;
                    $_POST['csearch_sys_name'] = Constants::ACTRIS;
                }
                else
                {
                    $_POST['csearch_sys_name'] = Constants::MARBEACHES;
                }


                $searchParams = $_POST;


                unset($searchParams['csearch_name'],$searchParams['csearch_result_limit'],$searchParams['csearch_tag'],$searchParams['csearch_address'],$searchParams['csearch_city'],$searchParams['csearch_zipcode'],$searchParams['csearch_year_built'],$searchParams['csearch_unit'],$searchParams['csearch_stories'],$searchParams['csearch_short_desc'],$searchParams['csearch_is_visible'],$searchParams['csearch_sys_name'],$searchParams['csearch_generate_mrktreport'],$searchParams['pk']);

                $_POST['csearch_criteria'] = serialize(array_filter($searchParams));
                $_POST['csearch_updated_date']=date('Y-m-d');
                $_POST['csearch_generate_mrktreport']  = isset($_POST['csearch_generate_mrktreport']) && $_POST['csearch_generate_mrktreport'] == 'Yes' ? 'Yes' : 'No'; 
                $_POST['csearch_display_in_agent']  = isset($_POST['csearch_display_in_agent']) && $_POST['csearch_display_in_agent'] == 'Yes' ? 'Yes' : 'No';
                $_POST['csearch_building']  = isset($_POST['csearch_building']) && $_POST['csearch_building'] == 'Yes' ? 'Yes' : 'No'; 
                $_POST['csearch_luxury']  = isset($_POST['csearch_luxury']) && $_POST['csearch_luxury'] == 'Yes' ? 'Yes' : 'No';  
                $_POST['csearch_pet_friendly']  = isset($_POST['csearch_pet_friendly']) && $_POST['csearch_pet_friendly'] == 'Yes' ? 'Yes' : 'No'; 
                 //echo "<pre>"; print_r($_POST); die;

                $update = $objAPI->updateCondoSearch($_POST);
				// echo "<pre>"; print_r($update); die;
                // $condoMinMaxSearch = CondoSearch::getInstance()->getCondoMinMaxFields($_GET['pk'], $_POST['csearch_criteria']);
				// echo "<pre>"; print_r($condoMinMaxSearch); die;
                if ($update){
                    header("location: $this->baseUrl&save=true");
                    exit(0);
                }
                else{
                    $msgError = 'Something went wrong.';
                }
            }

            $searchParams= '';
            if($this->_action == 'edit')
            {
                $pk = $_GET['pk'];
                $rsCondo = $objAPI->getCondoSearchById($pk);

                $searchParams = unserialize($rsCondo['csearch_criteria']);

                $objTmpl->assign(array(
                    'rsCondo'               => $rsCondo,
                    'arrSearchCriteria'     => $searchParams,
                    'pk'                    => $pk,
                ));
            }

            wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'].'jQuery/validate/jquery.validate.min.js', array('jquery'));
            wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'].'jQuery/validate/additional-methods.js', array('jquery'));

            # JQuery Input Masking
            wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'].'jQuery/jquery.maskedinput.min.js', array('jquery'));
            wp_enqueue_script('jquery-jsxcompressor-js', $arrVirtualPath['Libs']. 'jQuery/JSXCompressor/jsxcompressor.js', array( 'jquery' ), false, true);

        

            $cntListing = $objAPI->getCountbyParam($searchParams);

            $objTmpl->assign(array('T_Body'             => 'condo/condo-add.tpl',
                'scriptname'        =>  $this->baseUrl,
                'arrMeta'           =>  $objAPI->getMeta(array('City','CityState')),
                'arrPriceRange'	    =>	StaticArray::arrPriceRangeAdmin(),
                'arrminYearBuild'	=>	StaticArray::arrYearBuild('from'),
                'arrmaxYearBuild'	=>	StaticArray::arrYearBuild('to'),
                'arrYesNo'	        =>	StaticArray::arrYesNo(),
                'arrSystemName'	    =>	StaticArray::arrSystemName(),
                'total_record'	    =>	$cntListing,
                'isCondo'	        =>	true,
                'AgentSystemName'   =>	$arrConfig['Agent']['agent_system_name'],
                'msgError'	        =>	$msgError,
                // 'arrAmenities'	    =>	StaticArray::arrAminities(),
                'condoMinMaxSearch'	    =>	$condoMinMaxSearch,
            ));
        }
        else {

            $containerId = $_POST['containerId'];
            $params 	 = $_POST;
            $noblink	 = isset($_POST['noblink'])?$_POST['noblink']:'0';

            // Get Count
            $cntListing = $objAPI->getCountbyParam($params);

            AjaxResponse::obj()->script("jQuery('#".$containerId." .match').html('<i></i>&nbsp;<b>".number_format($cntListing, 0)." MATCHES"."</b>');");
            if($noblink != 1)
                AjaxResponse::obj()->script('$("#'.$containerId.' .match b").fadeOut(250).fadeIn(300).fadeOut(250).fadeIn(300);');

            AjaxResponse::obj()->call_request_area();

            echo AjaxResponse::obj()->send();
            exit();

        }
    }

    function getPropertyCount($csearch_id)
    {
        global $objTmpl;

        if(isset($csearch_id) && !empty($csearch_id)){

            $objAPI = IDXAPI::getInstance();
            $rsCondo = $objAPI->getCondoSearchById($csearch_id);
            $searchParams = unserialize($rsCondo['csearch_criteria']);

            $objTmpl->assign(array(
                'csearch_id'	    =>	$csearch_id,
            ));

            $count = $objAPI->getCountbyParam($searchParams);

            return $count;
        }
    }

    public function delete()
    {
        $objAPI = IDXAPI::getInstance();

        $delete = $objAPI->deleteCondoSearch($_GET['pk']);

        header("location: $this->baseUrl&delete=true");

        if($delete){
            header("location: $this->baseUrl&delete=true");
        }else{
            header("location: $this->baseUrl&error=true");
        }

        exit(0);
    }
}
?>