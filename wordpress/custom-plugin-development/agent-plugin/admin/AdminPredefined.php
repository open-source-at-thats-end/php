<?php
class AdminPredefined extends AdminModule
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
        global $arrPhysicalPath;

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
            case 'view':
                $this->viewListing();
                break;
            case 'pre-list-pagination':
                $this->viewListing();
                break;
            case 'pre-search':
                $this->manage();
                break;
            case 'add':
                $this->add();
                break;
            case 'edit':
                $this->add();
                break;
            case 'delete':
                $this->delete();
                break;
            case 'pred-listing':
                $this->add();
                break;
            default:
                $this->manage();
                break;
        }
    }
    public function manage()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
	    wp_enqueue_script('predefine-js',              $arrVirtualPath['TemplateJs']. 'predefined.js', array( 'jquery' ));
	    wp_localize_script(	'predefine-js',
	                           'objpredeAjax',
	                           array('action' => 'admin_ajax', 'predef_mod' => $this->__moduleKey, 'predef_action' => admin_url('admin-ajax.php')));
        if (isset($_GET['add']) && $_GET['add'] == true)
            $msgSuccess = "Predefined search has been added successfully.";
        elseif (isset($_GET['save']) && $_GET['save'] == true)
            $msgSuccess = "Predefined search has been saved successfully.";
        elseif (isset($_GET['delete']) && $_GET['delete'] == true)
            $msgSuccess = "Predefined search has been deleted successfully.";

        if(is_array($_POST) && count($_POST) > 0)
        {
        	if(isset($_POST['psearch_title']) && $_POST['psearch_title'] != '')
	        {
		        $arrParams['psearch_title'] =  $_POST['psearch_title'];
	        }
	        if(isset($_POST['psearch_tag']) && $_POST['psearch_tag'] != '')
	        {
		        $arrParams['psearch_tag'] =  $_POST['psearch_tag'];
	        }

        }
        $objAPI = IDXAPI::getInstance();
        //$arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_size'] = Constants::PRE_DEFINE_PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

        $rsPredefined = $objAPI->getPredefined($arrParams);

        $arrPre = array();
        foreach ($rsPredefined['rsPredefined'] as $key=>$val){
	        $searchParams = unserialize($val['psearch_criteria']);
	        $shortcode = '[predefine-search-result pid=';

	        $shortcode .= $val['psearch_id'].']';

            $arrPre[$key] = array(
                'psearch_id' => $val['psearch_id'],
                'psearch_title' => $val['psearch_title'],
                'psearch_added_date' => $val['psearch_added_date'],
                'psearch_criteria' => unserialize($val['psearch_criteria']),
                'psearch_tag' => $val['psearch_tag'],
                'shortcode' => $shortcode,
            );
        }

        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');
        wp_enqueue_script('predefine-js',              $arrVirtualPath['TemplateJs']. 'predefined.js', array( 'jquery' ));
		if(isset($_POST['scriptname']) && $_POST['scriptname'] != '')
		{
			$this->baseUrl = $_POST['scriptname'];
		}
        $objTmpl->assign(array(
            'scriptname' => $this->baseUrl,
            'rsPredefined'	=>	$arrPre,
            "total_record"	=>	count($rsPredefined['rsPredefined']),
            'totalFetched'  =>  $rsPredefined['totalFetched'],
            'page_size'	    =>	Constants::PAGE_SIZE,
            'startRecord'  =>  $rsPredefined['startRecord'],
            'objAdminPre'  =>  AdminPredefined::getInstance(),
            //'Filter'		=>	AgentRoster::obj()->filter,
            //'PageSize'		=>	$asset['OL_PageSize'],
            'msgSuccess' => $msgSuccess,
            'arrPageSize'	=>	StaticArray::arrPageSize(),

        ));

	    if(!$this->__isAjaxRequest){

		    $objTmpl->assign(array(
			                     'T_Body'            => 'predefined/predefined.tpl',
		                     ));
	    }else{

            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false || strpos($_SERVER['HTTP_HOST'], 'project') !== false)
            {
                $_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-predefined';
            }else{
                $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-predefined';
            }
		    AjaxResponse::obj()->assign($objTmpl->fetch('predefined/predefined-list.tpl'), '.frmStdForm');
		    AjaxResponse::obj()->assign($objTmpl->fetch('predefined/predefined-pagination.tpl'), '#pre-pagination');


		    AjaxResponse::obj()->call_request_area();

		    echo AjaxResponse::obj()->send();
		    exit();
	    }

    }
    public function add()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        include_once($arrPhysicalPath['UserBase']. 'AdminAjaxRequest.php');

        $objAPI = IDXAPI::getInstance();
        if(!$this->__isAjaxRequest){

            if($this->_action == 'add' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save')
            {

                unset($_POST['Submit']);
                unset($_POST['Action']);

                $searchParams = $_POST;

                unset($searchParams['psearch_title']);

                $_POST['psearch_criteria'] = serialize(array_filter($searchParams));
                $_POST['psearch_added_date'] 	= date('Y-m-d');
                $insert = $objAPI->addPredefinedSearch($_POST);

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

                $searchParams = $_POST;

                unset($searchParams['psearch_title']);

                $_POST['psearch_criteria'] = serialize(array_filter($searchParams));

                $update = $objAPI->updatePredefinedSearch($_POST);
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
                $rsPredefined = $objAPI->getPredefinedSearchById($pk);

                $searchParams = unserialize($rsPredefined['psearch_criteria']);

                $objTmpl->assign(array(
                    'rsPredefined'   => $rsPredefined,
                    'arrSearchCriteria'   => $searchParams,
                    'pk'        => $pk
                ));
            }

            wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'].'jQuery/validate/jquery.validate.min.js', array('jquery'));
            wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'].'jQuery/validate/additional-methods.js', array('jquery'));

            # JQuery Input Masking
            wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'].'jQuery/jquery.maskedinput.min.js', array('jquery'));
            wp_enqueue_script('jquery-jsxcompressor-js', $arrVirtualPath['Libs']. 'jQuery/JSXCompressor/jsxcompressor.js', array( 'jquery' ), false, true);


            wp_enqueue_script('predefine-js', $arrVirtualPath['TemplateJs']. 'predefined.js', array( 'jquery' ), false, true);


            $cntListing = $objAPI->getCountbyParam($searchParams);

            $objTmpl->assign(array('T_Body'     => 'predefined/predefined-add.tpl',
                'scriptname' => $this->baseUrl,
                'arrMeta'       =>  $objAPI->getMeta(array('PropertyStyle','City','SubType')),
                'arrPriceRange'	=>	StaticArray::arrPriceRangeAdmin(),
                'arrSqftRange'	=>	StaticArray::arrSQFTRange(''),
                'arrBedRange'	=>	StaticArray::arrBedRange(''),
                'arrBathRange'	=>	StaticArray::arrBathRange(''),
                'arrGarageRange'=>	StaticArray::arrBathRange(''),
                'arrShowOnly'	=>	StaticArray::arrShowOnly(),
                'arrLotSize'	=>	StaticArray::arrLotSize(),
                'arrminYearBuild'	=>	StaticArray::arrYearBuild('from'),
                'arrmaxYearBuild'	=>	StaticArray::arrYearBuild('to'),
                'arrYesNo'	    =>	StaticArray::arrYesNo(),
                'arrWaterfrontDesc'	=>	StaticArray::arrWaterfrontDesc(),
                'arrSecuritySafety'	    =>	StaticArray::arrSecuritySafety(),
                'arrStatus'	    =>	StaticArray::arrStatusAdmin(),
                'arrSortingOption'	    =>	StaticArray::arrSortingOption(),
                'arrSystemName'	    =>	StaticArray::arrSystemName(),
                'arrDayMarket'	    =>	StaticArray::arrDayMarket(),
                'total_record'	=>	$cntListing,
                'isPredefine'	=>	true,

//            'msgError'	=>	$msgError,

            ));
        }
        else {

            $containerId = $_POST['containerId'];
            $params 	 = $_POST;
            $noblink	 = isset($_POST['noblink'])?$_POST['noblink']:'0';

            // Get Count
            $cntListing = $objAPI->getCountbyParam($params);

           /* include_once($arrPhysicalPath['Libs']. "AjaxResponse.php");
            $objResp = new ajaxResponse();*/

            /*$objResp->assign('match', 'innerHTML', $cntListing. ' matche(s) found');
            echo json_encode($objResp->aCommands);*/
            AjaxResponse::obj()->script("jQuery('#".$containerId." .match').html('<i></i>&nbsp;<b>".number_format($cntListing, 0)." MATCHES"."</b>');");
            if($noblink != 1)
                AjaxResponse::obj()->script('$("#'.$containerId.' .match b").fadeOut(250).fadeIn(300).fadeOut(250).fadeIn(300);');

            AjaxResponse::obj()->call_request_area();

            echo AjaxResponse::obj()->send();
            exit();

        }

    }
    public function delete(){

        $objAPI = IDXAPI::getInstance();

        $delete = $objAPI->deletePredefinedSearch($_GET['pk']);

        if($delete){
            header("location: $this->baseUrl&delete=true");
        }else{
            header("location: $this->baseUrl&error=true");
        }

        exit(0);
    }
    public function viewListing()
    {
        global $objTmpl,$arrConfig,$arrVirtualPath;

        wp_enqueue_style('ore-style-popup');
        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');

        wp_enqueue_script('predefine-js',              $arrVirtualPath['TemplateJs']. 'predefined.js', array( 'jquery' ));

        wp_localize_script(	'predefine-js',
            'objpredeAjax',
            array('action' => 'admin_ajax', 'predef_mod' => $this->__moduleKey, 'predef_action' => admin_url('admin-ajax.php')));

        $objAPI = IDXAPI::getInstance();

        if(isset($_GET['psearch_id']) && !empty($_GET['psearch_id'])){

            $psearch_id = (isset($_GET['psearch_id']) && $_GET['psearch_id'] != ''? $_GET['psearch_id']:$_POST['psearch_id']);
            $rsPredefined = $objAPI->getPredefinedSearchById($psearch_id);
            $limit_result = $rsPredefined['psearch_result_limit'];
            $searchParams = unserialize($rsPredefined['psearch_criteria']);
            //echo "<pre>";print_r($searchParams);die;
            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
            {
                $_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-predefined&action=view&psearch_id='.$psearch_id;
            }else{
                $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-predefined&action=view&psearch_id='.$psearch_id;
            }

            $objTmpl->assign(array(
                'psearch_id'	    =>	$psearch_id,
            ));
        }
        else{

            if(isset($_POST['psearch_param']) && !empty($_POST['psearch_param']))
            {
                $searchParams = json_decode(stripslashes($_POST['psearch_param']), true);
                $limit_result = $searchParams['psearch_result_limit'];

            }else{

                $limit_result = $_POST['psearch_result_limit'];
                $searchParams = $_POST;
            }


            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
            {
                $_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-predefined&action=view';
            }else{
                $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-predefined&action=view';
            }
        }

        if(isset($searchParams['sort_by']) && $searchParams['sort_by'] != ''){
            $arrsort = explode('|', $searchParams['sort_by']);
            $searchParams['so'] = $arrsort[0];
            $searchParams['sd'] = $arrsort[1];
        }

        $arrResOptions = array();
        $arrResOptions['page_current'] = $_GET['cpage'];

        if(isset($limit_result) && !empty($limit_result) && $limit_result > 0){
            $searchParams['page_size'] = $limit_result;
        }else{
            $searchParams['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']: isset($_POST['page_size']) && $_POST['page_size'] != ''? $_POST['page_size']:25);
        }

        if(isset($_GET['cpage']))
        {
            $page 			= intval($_GET['cpage']) > 0 ? intval($_GET['cpage']) - 1 : 0;
        }else{
            $page 			= intval($_POST['cpage']) > 0 ? intval($_POST['cpage']) - 1 : 0;
        }

        $searchParams['start_record'] 	= $page * $searchParams['page_size'];

        $recProperty = $objAPI->getListingByParam($searchParams);

        if(isset($limit_result) && !empty($limit_result)){
            $total_record = $limit_result;
        }else{
            $total_record = $recProperty['total_record'];
        }

        if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
        {
            $basePageUrl = '/backend/wp-admin/admin.php?page=lpt-listings';
        }else{
            $basePageUrl = '/wp-admin/admin.php?page=lpt-listings';
        }

        $objTmpl->assign(array(
            'arrRecordSet'	    =>	$recProperty,
            'PhotoBaseUrl'	    =>	$recProperty['PhotoBaseUrl'],
            'total_record'	    =>	$total_record,
            'arrListingConfig'  =>  $arrConfig['Listing'],
            'Templates_Image'	=>	$arrVirtualPath['TemplateImages'],
            'basePageUrl'       =>  $basePageUrl,
            'arrPageSize'	    =>	StaticArray::arrPageSize(),
            'arrSearchParams'   =>	$searchParams,
            'search_meta'       =>	json_encode($searchParams),
        ));

        if(!$this->__isAjaxRequest){

            $objTmpl->assign(array(
                'T_Body'            => 'predefined/view-listing.tpl',
            ));
        }else{
            AjaxResponse::obj()->script("searchParam = '".json_encode($searchParams)."'");
            AjaxResponse::obj()->assign($objTmpl->fetch('listing/list.tpl'), '.list-holder');
            AjaxResponse::obj()->assign($objTmpl->fetch('listing/list-pagination.tpl'), '#list-pagination');

            AjaxResponse::obj()->call_request_area();

            echo AjaxResponse::obj()->send();
            exit();
        }



    }
	function getPropertyCount($psearch_id)
	{
		global $objTmpl;

		if(isset($psearch_id) && !empty($psearch_id)){

			$objAPI = IDXAPI::getInstance();
			$rsPredefined = $objAPI->getPredefinedSearchById($psearch_id);
			$limit_result = $rsPredefined['psearch_result_limit'];
			$searchParams = unserialize($rsPredefined['psearch_criteria']);
			//echo "<pre>";print_r($searchParams);die;
			/*if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
			{
				$_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-predefined&action=view&psearch_id='.$psearch_id;
			}else{
				$_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-predefined&action=view&psearch_id='.$psearch_id;
			}*/

			$objTmpl->assign(array(
				                 'psearch_id'	    =>	$psearch_id,
			                 ));

			$count = $objAPI->getCountbyParam($searchParams);

			return $count;
		}
	}
}
?>