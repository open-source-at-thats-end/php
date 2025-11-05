<?php

class MasterPredefined extends AdminModule
{
    private static $instance;
    private $action;

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

        if ($this->__isAjaxRequest) {
            $this->_action = strtolower($_POST['ajax_mod']);
            $this->_subaction = $_POST['ajax_subaction'];
        } else {
            // For non-ajax requests
            $this->baseUrl = admin_url('admin.php?page=' . constants::SLUG . '-' . $this->__moduleKey);
        }

        switch ($this->_action) {
            case 'view':
                $this->viewListing();
                break;
            case 'master-prelist-pagination':
                $this->viewListing();
                break;
            default:
                $this->manage();
                break;
        }

    }
    public function manage()
    {
        global $objTmpl, $arrVirtualPath;

        wp_enqueue_script('master-predefine-js',              $arrVirtualPath['TemplateJs']. 'master-predefined.js', array( 'jquery' ));
        wp_localize_script(	'master-predefine-js',
            'objpredeAjax',
            array('action' => 'admin_ajax', 'predef_mod' => $this->__moduleKey, 'predef_action' => admin_url('admin-ajax.php')));

        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');

        $objAPI = IDXAPI::getInstance();

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

        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

        $rsPredefined = $objAPI->getPredefined($arrParams);

        $arrPre = array();
        foreach ($rsPredefined['rsPredefined'] as $key=>$val){
            $shortcode = '[predefine-search-result pid='.$val['psearch_id'].']';

            $arrPre[$key] = array(
                'psearch_id' => $val['psearch_id'],
                'psearch_title' => $val['psearch_title'],
                'psearch_added_date' => $val['psearch_added_date'],
                'psearch_criteria' => unserialize($val['psearch_criteria']),
                'psearch_tag' => $val['psearch_tag'],
                'shortcode' => $shortcode,
            );
        }

        $objTmpl->assign(array(
            'scriptname' => $this->baseUrl,
            'rsPredefined'	=>	$arrPre,
            "total_record"	=>	count($rsPredefined['rsPredefined']),
            'totalFetched'  =>  $rsPredefined['totalFetched'],
            'page_size'	    =>	Constants::PAGE_SIZE,
            'startRecord'  =>  $rsPredefined['startRecord'],
            'objAdminPre'  =>  MasterPredefined::getInstance(),
            'arrPageSize'	=>	StaticArray::arrPageSize(),

        ));

        if(!$this->__isAjaxRequest){

            $objTmpl->assign(array(
                'T_Body'            => 'master-predefined/master-predefined.tpl',
            ));
        }else{

            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
            {
                $_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-masterpredefined';
            }else{
                $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-masterpredefined';
            }
            AjaxResponse::obj()->assign($objTmpl->fetch('master-predefined/master-predefined-list.tpl'), '.frmStdForm');
            AjaxResponse::obj()->assign($objTmpl->fetch('master-predefined/master-predefined-pagination.tpl'), '#pre-pagination');


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
            //$rsPredefined = $objAPI->getPredefinedSearchById($psearch_id);
            $count = $objAPI->getPredefinedSearchCountById($psearch_id);

            $objTmpl->assign(array(
                'psearch_id'	    =>	$psearch_id,
            ));


            return $count;
        }
    }
    function viewListing()
    {
        global $objTmpl,$arrConfig,$arrVirtualPath;

        wp_enqueue_style('ore-style-popup');
        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');
        wp_enqueue_script('master-predefine-js',              $arrVirtualPath['TemplateJs']. 'master-predefined.js', array( 'jquery' ));
        wp_localize_script(	'master-predefine-js',
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
}
?>