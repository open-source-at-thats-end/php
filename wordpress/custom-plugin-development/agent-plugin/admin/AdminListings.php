<?php
class AdminListings extends AdminModule {

    private static $instance ;

    public static function getInstance(){
        if( !isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function requestHandler($isAjaxRequest=false, $moduleKey) {

        parent::requestHandler($isAjaxRequest, $moduleKey);

        $this->__isAjaxRequest = $isAjaxRequest;
        $this->__moduleKey = $moduleKey;

        if($this->__isAjaxRequest) {
            $this->_action 		= strtolower($_POST['ajax_mod']);
            $this->_subaction 	= $_POST['ajax_subaction'];

            $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-'.'listings';


        } else {
            $this->baseUrl = admin_url('admin.php?page='.Constants::SLUG.'-'.$this->__moduleKey);
        }

        switch($this->_action)
        {
            case 'view':
                $this->view();
                break;
            case 'manage-listing':
                $this->manage();
                break;
            case 'listing-count':
                $this->getListingCount();
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

        # Non-ajax request
        if(!$this->__isAjaxRequest)
        {
            wp_enqueue_script('jquery-colorbox-js');
            wp_enqueue_style('jquery-colorbox-style');

            wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs']. 'jQuery/validate/jquery.validate.min.js', array( 'jquery' ));
            wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'manage.js', array( 'jquery' ));
//        wp_enqueue_script('js-manage-listing', $arrVirtualPath['TemplateJs']. 'manage-listing.js', array( 'jquery' ));

            # Must include javascript file with same key 'js-manage-class' otherwise it will not included
            wp_localize_script(	'js-manage-common',
                'objlistAjax',
                array('action' => 'admin_ajax', 'listing_mod' => $this->__moduleKey, 'listing_action' => admin_url('admin-ajax.php')));

            $arrResOptions = array();
            $arrResOptions['page_current'] = $_GET['cpage'];

            $arrParams['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']:25);
            $page 			= intval($_GET['page']) > 0 ? intval($_GET['page']) - 1 : 0;
            $arrParams['start_record'] 	= $page * $arrParams['page_size'];

            $arrRecordSet = $objAPI->getListingByParam($arrParams);

            $objTmpl->assign(array(	'T_Body' 		=> 'listing/manage.tpl',
                'arrMeta'       =>  $objAPI->getMeta(array('PropertyStyle','City','SubType')),
                'arrPriceRange'	=>	StaticArray::arrPriceRangeAdmin(),
                'arrSqftRange'	=>	StaticArray::arrSQFTRange(''),
                'arrBedRange'	=>	StaticArray::arrBedRange(''),
                'arrBathRange'	=>	StaticArray::arrBathRange(''),
                'arrGarageRange'=>	StaticArray::arrBathRange(''),
                'arrShowOnly'	=>	StaticArray::arrShowOnly(),
                'arrSortBy'		=>	StaticArray::arrSortingOption(),
                'arrLotSize'	=>	StaticArray::arrLotSize(),
                'arrminYearBuild'	=>	StaticArray::arrYearBuild('from'),
                'arrmaxYearBuild'	=>	StaticArray::arrYearBuild('to'),
                'arrYesNo'	    =>	StaticArray::arrYesNo(),
                'arrStatus'	    =>	StaticArray::arrStatusAdmin(),
                'arrDayMarket'	    =>	StaticArray::arrDayMarket(),
                'basePageUrl'	=>	$this->baseUrl,
                'arrListingConfig'  =>  $arrConfig['Listing'],
                'arrRecordSet'	=>	$arrRecordSet,
                'total_record'	    =>	$arrRecordSet['total_record'],
                "PhotoBaseUrl"		=>	$arrRecordSet['PhotoBaseUrl'],
                'arrPageSize'	=>	StaticArray::arrPageSize(),
                'arrSearchParams'=>	$arrParams,

            ));
        }
        else{

            # Get required library
            include_once($arrPhysicalPath['Libs']. "ajaxResponse.php");

            $objResp = new ajaxResponse();

            $frmData = array();

            # Perform operation base on subaction
            switch($this->_subaction)
            {
                /**
                 * Get page
                 *********************************************************/
                case 'getpage':
                    $this->__reloadList($_POST['cpage'], $_POST);
                    $objResp->script('__hideLoaderLarge2();');

                    break;
            }
        }
    }

    public function getListingCount()
    {
        global $arrPhysicalPath;
        include_once($arrPhysicalPath['UserBase']. 'AdminAjaxRequest.php');

        $objAPI = IDXAPI::getInstance();

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

    private function __reloadList($cPage, $addParams="") {
        global $arrConfig, $objTmpl;

        $objAPI = IDXAPI::getInstance();

        $arrParams = array();

        if(is_array($addParams))
            $arrParams = $addParams;

        $arrParams['page_size']		= (isset($_POST['page_size']) && $_POST['page_size'] != ''? $_POST['page_size']:25);
        $page 			            = intval($cPage) > 0 ? intval($cPage) - 1 : 0;
        $arrParams['start_record'] 	= $page * $arrParams['page_size'];


        if(isset($arrParams['sort_by']) && $arrParams['sort_by'] != ''){
            $arrsort = explode('|', $arrParams['sort_by']);
            $arrParams['so'] = $arrsort[0];
            $arrParams['sd'] = $arrsort[1];
        }
        $arrRecordSet = $objAPI->getListingByParam($arrParams);

        # Assign data
        $objTmpl->assign(array(	'arrSearchParams' =>	$arrParams,
            'arrRecordSet'	  =>	$arrRecordSet,
            'total_record'	=>	$arrRecordSet['total_record'],
            "PhotoBaseUrl"	=>	$arrRecordSet['PhotoBaseUrl'],
            'basePageUrl'	=>	$_SERVER['REQUEST_URI'],
            'arrListingConfig'  =>  $arrConfig['Listing'],
            'arrPageSize'	=>	StaticArray::arrPageSize(),
        ));

        AjaxResponse::obj()->assign($objTmpl->fetch('listing/list-data.tpl'), '#list-holder');
        AjaxResponse::obj()->assign($objTmpl->fetch('listing/list-pagination.tpl'), '#list-pagination');

        AjaxResponse::obj()->call_request_area();

        echo AjaxResponse::obj()->send();
        exit();

    }
    function view(){
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