<?php
class AgentPredefined extends AdminModule {

    private static $instance;

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
            case 'full-view':
                $this->FullView();
                break;
            default:
                $this->manage();
                break;
        }
    }
    public function manage()
    {
        global $arrVirtualPath, $arrConfig, $objTmpl;
        wp_enqueue_script('predefine-js',$arrVirtualPath['TemplateJs']. 'predefined.js', array( 'jquery' ));
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

        $arrParams['page_size']         = Constants::PAGE_SIZE;
        $arrParams['page_current']      = isset($_GET['cpage'])?$_GET['cpage']:1;
        $arrParams['agent_sys_name']    = Constants::MARBEACHES; //((isset($arrConfig['Site_Agent']['agent_mls']) && $arrConfig['Site_Agent']['agent_mls'] == Constants::ACTRIS)?Constants::ACTRIS:Constants::MARBEACHES);

        $rsPredefined = LPTAgentPredefined::getInstance()->viewAll($arrParams,$addWhere='', $customSelect='');
        //echo '<pre>';print_r($rsPredefined);exit();
        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');

        if(isset($_POST['scriptname']) && $_POST['scriptname'] != '')
        {
            $this->baseUrl = $_POST['scriptname'];
        }
        $objTmpl->assign(array(
            'scriptname' => $this->baseUrl,
            'rsPredefined'	=>	$rsPredefined['rsData'],
            "total_record"	=>	$rsPredefined['totalRecord'],
            'totalFetched'  =>  $rsPredefined['totalFetched'],
            //'page_size'	    =>	Constants::PAGE_SIZE,
            'page_size'	    =>	Constants::PRE_DEFINE_PAGE_SIZE,
            'startRecord'  =>  $rsPredefined['startRecord'],
            'objAdminPre'  =>  AgentPredefined::getInstance(),
            'msgSuccess' => $msgSuccess,
            'arrPageSize'	=>	StaticArray::arrPageSize(),

        ));

        if(!$this->__isAjaxRequest){

            $objTmpl->assign(array(
                'T_Body'            => 'predefined/predefined.tpl',
            ));
        }else{

            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
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
    function getPropertyCount($psearch_id)
    {
        global $objTmpl;

        if(isset($psearch_id) && !empty($psearch_id)){

            $objAPI = IDXAPI::getInstance();
            $rsPredefined = LPTAgentPredefined::getInstance()->getInfoById($psearch_id);
            $limit_result = $rsPredefined['psearch_result_limit'];
            $searchParams = unserialize($rsPredefined['psearch_criteria']);

            $objTmpl->assign(array(
                'psearch_id'	    =>	$psearch_id,
            ));

            $count = $objAPI->getCountbyParam($searchParams);

            return $count;
        }
    }
    public function add()
    {
        global $arrPhysicalPath, $arrVirtualPath, $objTmpl, $arrConfig;
        include_once($arrPhysicalPath['UserBase']. 'AdminAjaxRequest.php');

        $arrAgent =LPTAgentProfile::getInstance()->agentList();

        $objAPI = IDXAPI::getInstance();
        if(!$this->__isAjaxRequest){

            if($this->_action == 'add' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save')
            {
                unset($_POST['Submit']);
                unset($_POST['Action']);

               /* if(isset($arrConfig['Site_Agent']['agent_mls']) && $arrConfig['Site_Agent']['agent_mls'] == Constants::ACTRIS && !isset($_POST['sys_name']))
                {
                    //$_POST['sys_name'] = StaticArray::arr_ASName_LookUP()[$arrConfig['Site_Agent']['agent_mls']];
                    $_POST['sys_name'] = Constants::MLS_ACTRIS;
                    $_POST['psearch_sys_name'] = Constants::ACTRIS;
                }*/

                $searchParams = $_POST;

                $param = array_filter($searchParams);
                if (isset($_POST['minbed']) && $_POST['minbed'] == '0') {
                    $param['minbed'] = $_POST['minbed'];
                }
                if (isset($_POST['maxbed']) && $_POST['maxbed'] == '0') {
                    $param['maxbed'] = $_POST['maxbed'];
                }

                unset($searchParams['psearch_title']);

                $_POST['psearch_criteria'] = serialize($param);
                $_POST['psearch_added_date'] 	= date('Y-m-d');
                $insert = LPTAgentPredefined::getInstance()->Insert($_POST);

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

                /*$redis = new Redis();
                $redis->connect('127.0.0.1', 6379);

                $redisExists = $redis->exists('ps_'.$_POST['pk']);

                if(isset($redisExists) && $redisExists == true)
                {
                    $redis->delete('ps_'.$_POST['pk']);
                }
                $redis = new Redis();
                $redis->connect('127.0.0.1', 6379);

                $redisExists = $redis->exists($_SERVER['SERVER_NAME'].'_ps_'.$_POST['pk']);

                if(isset($redisExists) && $redisExists == true)
                {
                    $redis->delete($_SERVER['SERVER_NAME'].'_ps_'.$_POST['pk']);
                }

                if(isset($arrConfig['Site_Agent']['agent_mls']) && $arrConfig['Site_Agent']['agent_mls'] == Constants::ACTRIS && !isset($_POST['sys_name']))
                {
                    $_POST['sys_name'] = Constants::MLS_ACTRIS;
                    $_POST['psearch_sys_name'] = Constants::ACTRIS;
                }*/

                $searchParams = $_POST;

                unset($searchParams['psearch_title']);

                $param = array_filter($searchParams);
                if (isset($_POST['minbed']) && $_POST['minbed'] == '0') {
                    $param['minbed'] = $_POST['minbed'];
                }
                if (isset($_POST['maxbed']) && $_POST['maxbed'] == '0') {
                    $param['maxbed'] = $_POST['maxbed'];
                }

                $_POST['psearch_criteria'] = serialize($param);


                $update = LPTAgentPredefined::getInstance()->Update($_POST['pk'],$_POST);

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
                $rsPredefined = LPTAgentPredefined::getInstance()->getInfoById($pk);

                $searchParams = unserialize($rsPredefined['psearch_criteria']);

                $objTmpl->assign(array(
                    'rsPredefined'   => $rsPredefined,
                    'arrSearchCriteria'   => $searchParams,
                    'pk'        => $pk
                ));
            }

            wp_enqueue_style('jquery-colorbox-style');
            wp_enqueue_style('a-maps-search-css', $arrVirtualPath['TemplateCss']. 'map-search.css', array(), Constants::CSS_JS_VERSION);
            wp_enqueue_style('a-maps-search-css', $arrVirtualPath['Libs']. 'fontawesome/css/all.css', array(), Constants::CSS_JS_VERSION);

            wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'].'jQuery/validate/jquery.validate.min.js', array('jquery'));
            wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'].'jQuery/validate/additional-methods.js', array('jquery'));

            wp_enqueue_script('ore-google-map','https://maps.googleapis.com/maps/api/js?libraries=drawing,geometry,places&key=AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',array(),Constants::CSS_JS_VERSION);

            # JQuery Input Masking
            wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'].'jQuery/jquery.maskedinput.min.js', array('jquery'));
            wp_enqueue_script('jquery-jsxcompressor-js', $arrVirtualPath['Libs']. 'jQuery/JSXCompressor/jsxcompressor.js', array( 'jquery' ), false, true);


            wp_enqueue_script('predefine-js', $arrVirtualPath['TemplateJs']. 'predefined.js', array( 'jquery' ), false, true);
            wp_enqueue_script('a-map-search', $arrVirtualPath['TemplateJs']. 'map-search.js', array( 'jquery' ), false, true);
            wp_enqueue_script('a-font-awesome-js', $arrVirtualPath['Libs']. 'fontawesome/js/all.js', array( 'jquery' ), false, true);


            $cntListing = $objAPI->getCountbyParam($searchParams);

           /* if(isset($arrConfig['Site_Agent']['agent_mls']) && $arrConfig['Site_Agent']['agent_mls'] == Constants::ACTRIS)
            {
                $arrWaterfrontDesc  = StaticArray::arrWaterfrontDescActris();
            }
            else
            {*/
                $arrWaterfrontDesc  = StaticArray::arradminWaterfrontDesc();
           /* }*/

            $objTmpl->assign(array('T_Body'     => 'predefined/predefined-add.tpl',
                'scriptname'            =>  $this->baseUrl,
                'arrMeta'               =>  $objAPI->getMeta(array('PropertyStyle','CityActris','SubType','SubTypeActris')),
                'arrPriceRange'	        =>	StaticArray::arrPriceRangeAdmin(),
                'arrSqftRange'	        =>	StaticArray::arrSQFTRange(''),
                'arrBedRange'	        =>	StaticArray::arrBedRange(''),
                'arrBathRange'	        =>	StaticArray::arrBathRange(''),
                'arrGarageRange'        =>	StaticArray::arrBathRange(''),
                'arrShowOnly'	        =>	StaticArray::arrShowOnly(),
                'arrLotSize'	        =>	StaticArray::arrLotSize(),
                'arrminYearBuild'	    =>	StaticArray::arrYearBuild('from'),
                'arrmaxYearBuild'	    =>	StaticArray::arrYearBuild('to'),
                'arrYesNo'	            =>	StaticArray::arrYesNo(),
                'arrWaterfrontDesc'	    =>	$arrWaterfrontDesc,
                'arrSecuritySafety'	    =>	StaticArray::arrSecuritySafety(),
                'arrStatus'	            =>	StaticArray::arrStatusAdmin(),
                'arrSortingOption'	    =>	StaticArray::arrSortingOption(),
                'arrDayMarket'	        =>	StaticArray::arrDayMarket(),
                'arrSystemName'	        =>	StaticArray::arrSystemName(),
                'total_record'	        =>	$cntListing,
                'isPredefine'	        =>	true,
                'AgentSystemName'       =>	$arrConfig['Site_Agent']['agent_mls'],
                'TPL_images'                =>  $arrVirtualPath['TemplateImages'],
                'mapZoomLevel'              =>  isset($searchParams['mz']) ? $searchParams['mz'] : 13,
                'mapCenterLat'              =>  isset($searchParams['clat']) ? $searchParams['clat'] : 25.761681, // Austin: 30.3074624, -98.0335911 // Dallas 32.8203525, -97.0115281
                'mapCenterLng'              =>  isset($searchParams['clng']) ? $searchParams['clng'] : -80.191788,
                'arrAgent'                  => $arrAgent

//            'msgError'	=>	$msgError,

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
    public function viewListing()
    {
        global $objTmpl,$arrConfig,$arrVirtualPath;

        wp_enqueue_style('ore-style-popup');
        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');

        wp_enqueue_script('predefine-js',$arrVirtualPath['TemplateJs']. 'predefined.js', array( 'jquery' ));

        wp_localize_script(	'predefine-js',
            'objpredeAjax',
            array('action' => 'admin_ajax', 'predef_mod' => $this->__moduleKey, 'predef_action' => admin_url('admin-ajax.php')));

        $objAPI = IDXAPI::getInstance();

        if(isset($_GET['psearch_id']) && !empty($_GET['psearch_id'])){

            $psearch_id = (isset($_GET['psearch_id']) && $_GET['psearch_id'] != ''? $_GET['psearch_id']:$_POST['psearch_id']);
            $rsPredefined = LPTAgentPredefined::getInstance()->getInfoById($psearch_id);
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
            $searchParams['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != '')? $_GET['page_size']: (isset($_POST['page_size']) && $_POST['page_size'] != ''? $_POST['page_size']:25);
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
            $basePageUrl = '/backend/wp-admin/admin.php?page=lpt-predefined';
        }else{
            $basePageUrl = '/wp-admin/admin.php?page=lpt-predefined';
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
    public function delete(){

        $delete = LPTAgentPredefined::getInstance()->Delete($_GET['pk']);

        if($delete){
            header("location: $this->baseUrl&delete=true");
        }else{
            header("location: $this->baseUrl&error=true");
        }

        exit(0);
    }
    public function FullView(){
        global $objTmpl, $arrVirtualPath, $arrConfig;

        wp_enqueue_style('ore-style-popup');

        # IMAGGE GALLERY
        wp_enqueue_style( 'jquery-flexslider', $arrVirtualPath['Libs']. 'jQuery/woothemes-FlexSlider/flexslider.css');
        wp_enqueue_script( 'jquery-flexslider', $arrVirtualPath['Libs']. 'jQuery/woothemes-FlexSlider/jquery.flexslider-min.js', array('jquery'));
//        wp_enqueue_script( 'ore-jquery-gallery', $arrVirtualPath['Libs']. 'jQuery/elastislide/gallery.js', array('jquery'));

        # Googel MAP
        //wp_enqueue_script('ore-google-map','https://maps.googleapis.com/maps/api/js?libraries=drawing,geometry,places&key=AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',array(),Constants::CSS_JS_VERSION);

        //wp_enqueue_script('ore-google-map', 'https://maps.googleapis.com/maps/api/js?sensor=false');

        wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'listing-view.js', array( 'jquery' ));

        $objAPI = IDXAPI::getInstance();

        $arrParams = array();
        $arrParams['ListingID_MLS'] = $_GET['mls_no'];

        $recProperty = $objAPI->getListingByMLSNum($arrParams);

        # Fetch diffrent items from DB
        $objTmpl->assign(array(
            'Record'			=>	$recProperty,
            'arrListingConfig'  =>  $arrConfig['Listing'],
            //'arrFiledMapping'	=>	(OREDAOField::getInstance('')->getDBFieldKeyValueArray() + $customFieldMapping),
            'Templates_Image'	=>	$arrVirtualPath['TemplateImages'],
            'google_api_key'	=>	'AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',
        ));

        $objTmpl->assign(array(
            'T_Body'		=>	'listing/view.tpl',
            //	'IsPopup'		=>	true
        ));
    }
}
?>