<?php
class AdminListings extends AdminModule {

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

        $this->__isAjaxRequest = $isAjaxRequest;
        $this->__moduleKey = $moduleKey;

        if($this->__isAjaxRequest) {
            $this->_action 		= strtolower($_POST['ajax_mod']);
            $this->_subaction 	= $_POST['ajax_subaction'];
            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
            {
                $_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-'.'listings';
            }else{
                $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-'.'listings';
            }

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
            default:
                $this->manage();
                break;
        }
    }
    public function manage()
    {
        //echo '<pre>';print_r($_POST);exit();
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

        $objAPI = IDXAPI::getInstance();

        # Non-ajax request

        if(!$this->__isAjaxRequest)
        {
            wp_enqueue_script('jquery-colorbox-js');
            wp_enqueue_style('jquery-colorbox-style');

            wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs']. 'jQuery/validate/jquery.validate.min.js', array( 'jquery' ));
            wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'manage.js', array( 'jquery' ));
            //wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'manage.js', array( 'jquery' ),"5.7.2",true);
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
            //$arrParams['vt']= Constants::VT_LIST;
            $arr_SName_LookUP = StaticArray::arr_SName_LookUP();

           /* if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
            {
                $arrParams['sys_name'] = StaticArray::arr_SName_LookUP()[strtolower($arrConfig['Agent']['agent_system_name'])];
            }
            else
            {*/
                $arrParams['sys_name'] = Constants:: DEFAULT_LISTINGS;
          /*  }*/
            //echo '<pre>';print_r($systemName);exit();

            $arrRecordSet = $objAPI->getListingByParam($arrParams);
            $arrRecordSet['SystemName'] = $arr_SName_LookUP;

           /* if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
            {
                $arrWaterfrontDesc  = StaticArray::arrWaterfrontDescActris();
                $arrMeta            = $objAPI->getMeta(array('PropertyStyle','City','SubTypeActris'));
            }
            else
            {*/
                $arrWaterfrontDesc  = StaticArray::arrWaterfrontDesc();
                $arrMeta            = $objAPI->getMeta(array('PropertyStyle','City','SubType'));
            /*}*/

           // echo '<pre>';print_r($arrRecordSet);exit();

            $objTmpl->assign(array(	'T_Body' 		=> 'listing/manage.tpl',
                'arrMeta'           =>  $arrMeta,
                'arrPriceRange'	    =>	StaticArray::arrPriceRangeAdmin(),
                'arrSqftRange'	    =>	StaticArray::arrSQFTRange(''),
                'arrBedRange'	    =>	StaticArray::arrBedRange(''),
                'arrBathRange'	    =>	StaticArray::arrBathRange(''),
                'arrGarageRange'    =>	StaticArray::arrBathRange(''),
                'arrShowOnly'	    =>	StaticArray::arrShowOnly(),
                'arrSortBy'		    =>	StaticArray::arrSortingOption(),
                'arrSystemName'     =>	StaticArray::arrSystemName(),
                'arrLotSize'	    =>	StaticArray::arrLotSize(),
                'arrminYearBuild'	=>	StaticArray::arrYearBuild('from'),
                'arrmaxYearBuild'	=>	StaticArray::arrYearBuild('to'),
                'arrYesNo'	        =>	StaticArray::arrYesNo(),
                'arrWaterfrontDesc'	=>	$arrWaterfrontDesc,
                'arrSecuritySafety'	=>	StaticArray::arrSecuritySafety(),
                'arrStatus'	        =>	StaticArray::arrStatusAdmin(),
                'arrDayMarket'	    =>	StaticArray::arrDayMarket(),
                'basePageUrl'	    =>	$this->baseUrl,
                'arrListingConfig'  =>  $arrConfig['Listing'],
                'arrRecordSet'	    =>	$arrRecordSet,
                'total_record'	    =>	$arrRecordSet['total_record'],
                "PhotoBaseUrl"		=>	$arrRecordSet['PhotoBaseUrl'],
                'arrPageSize'	    =>	StaticArray::arrPageSize(),
                'arrSearchParams'   =>	$arrParams,
                'arr_SName_LookUP'  =>  $arr_SName_LookUP,
                'AgentSystemName'   =>	$arrConfig['Agent']['agent_system_name'],
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

    private function __reloadList($cPage, $addParams="") {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

        $objAPI = IDXAPI::getInstance();

        $arrParams = array();

        if(is_array($addParams))
            $arrParams = $addParams;

        $arrParams['page_size']		= (isset($_POST['page_size']) && $_POST['page_size'] != ''? $_POST['page_size']:25);
        $page 			            = intval($cPage) > 0 ? intval($cPage) - 1 : 0;
        $arrParams['start_record'] 	= $page * $arrParams['page_size'];

       /* if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
        {
            $arrParams['sys_name'] = StaticArray::arr_SName_LookUP()[strtolower($arrConfig['Agent']['agent_system_name'])];
        }
        else
        {*/
            $arrParams['sys_name'] = $addParams['sys_name'];
      /*  }*/

        if(isset($arrParams['sort_by']) && $arrParams['sort_by'] != ''){
            $arrsort = explode('|', $arrParams['sort_by']);
            $arrParams['so'] = $arrsort[0];
            $arrParams['sd'] = $arrsort[1];
        }
        $arrRecordSet = $objAPI->getListingByParam($arrParams);

        # Assign data
        $objTmpl->assign(array(	'arrSearchParams' =>	$arrParams,
            'arrRecordSet'      =>	$arrRecordSet,
            'total_record'	    =>	$arrRecordSet['total_record'],
            "PhotoBaseUrl"	    =>	$arrRecordSet['PhotoBaseUrl'],
            'basePageUrl'	    =>	$_SERVER['REQUEST_URI'],
            'arrListingConfig'  =>  $arrConfig['Listing'],
            'arrPageSize'	    =>	StaticArray::arrPageSize(),
            'arrSystemName'     =>	StaticArray::arrSystemName(),
            'SystemName'        =>	$arrConfig['Agent']['agent_system_name'],
        ));

        AjaxResponse::obj()->assign($objTmpl->fetch('listing/list-data.tpl'), '#list-holder');
        AjaxResponse::obj()->assign($objTmpl->fetch('listing/list-pagination.tpl'), '#list-pagination');

        AjaxResponse::obj()->call_request_area();

        echo AjaxResponse::obj()->send();
        exit();

    }
    function view(){
        global $objTmpl, $arrPhysicalPath, $arrVirtualPath, $arrConfig;

        wp_enqueue_style('ore-style-popup');

        # IMAGGE GALLERY
        wp_enqueue_style( 'jquery-flexslider', $arrVirtualPath['Libs']. 'jQuery/woothemes-FlexSlider/flexslider.css');
        wp_enqueue_script( 'jquery-flexslider', $arrVirtualPath['Libs']. 'jQuery/woothemes-FlexSlider/jquery.flexslider-min.js', array('jquery'));
//        wp_enqueue_script( 'ore-jquery-gallery', $arrVirtualPath['Libs']. 'jQuery/elastislide/gallery.js', array('jquery'));

        # Googel MAP
        //wp_enqueue_script('ore-google-map', 'https://maps.googleapis.com/maps/api/js?sensor=false');

        wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'listing-view.js', array( 'jquery' ));

        $objAPI = IDXAPI::getInstance();

        $arrParams = array();
        $arrParams['ListingID_MLS'] = $_GET['mls_no'];

        $recProperty = $objAPI->getListingByMLSNum($arrParams);
//echo"<pre>";print_r($recProperty);die;
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