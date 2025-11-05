<?php
/**
 * Created by PhpStorm.
 * User: od1
 * Date: 11/05/20
 * Time: 11:11 PM
 */

if(!class_exists('ShortCodeHandler'))
{
    class ShortCodeHandler
    {
        private static $instance;

        private function __construct()
        {
            //
        }

        public static function getInstance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new ShortCodeHandler();
            }
            return self::$instance;
        }

        public function getListingDetail(){


            global $objTmpl,$wp, $arrPhysicalPath,$arrVirtualPath,$arrConfig;

            # Dynamic Search Form building and custom theme template logic will goes here
            $objTmpl->assign(array('T_Body'	=>	'home-listing-detail.tpl'));

            return $this->output();

        }

        public function listingSearchForm($atts)
        {

            global $objAPI, $objTmpl, $arrVirtualPath, $arrConfig, $arrPhysicalPath;

            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script( 'p-common-js', 'objLPTAjax', array( 'action' => 'lpt_front_ajax', 'lpt_mod' => 'consumer-tools', 'ajaxurl_as' => $arrConfig['autosugg_url'],'ajaxurl' => admin_url( 'admin-ajax.php' ),'agentSysName' => $arrConfig['Agent']['agent_system_name']));

            wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script(	'p-mapsearch',
                'objMapSearch',
                array('action' => 'front_ajax', 'mod' => Constants::TYPE_LISTING_MAPSEARCH, 'url' => admin_url('admin-ajax.php')));
            //wp_enqueue_style('lpt-color-style');
            include_once($arrPhysicalPath['Libs']. '/Mobile-Detect-2.8.19/OE_Mobile_Detect.php');
            $detect  =   new Mobile_Detect();
            $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

            $opt=get_option('lpt_config');

            $post_title=get_the_title($opt['page-config']['page-search-result']);

            if(strpos($_SERVER['HTTP_HOST'], 'project') !== false || strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false)
            {
                $frmAction = get_home_url().'/'.$post_title;
            }else{
                $frmAction = '/'.$post_title;
            }

            wp_enqueue_style('srchresult');
            //echo '<pre>';print_r($_SERVER);exit();
            if(isset($_POST) && count($_POST) > 0) {
                $arrsearchParam = Utility::GetSearchParamAndURL(false, $_POST);
            }else{

                $arrsearchParam = Utility::GetSearchParamAndURL(urldecode($_SERVER['QUERY_STRING']), false);
            }

            if( is_user_logged_in() ){

                global $current_user;
                $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);

                $objTmpl->assign(array(
                    'isUserLoggedIn'    =>  true,
                    'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
                    'user_id'    =>  $current_user->data->ID,

                ));
            }
            else {

                $objTmpl->assign(array(
                    'isUserLoggedIn'    =>  false,
                ));
            }

          /*  if(isset($opt['Agent']['agent_system_name']) && $opt['Agent']['agent_system_name'] == Constants::ACTRIS) {
                $arrWaterfrontDesc = StaticArray::arrWaterfrontDescActris();
            }
            else
            {*/
                $arrWaterfrontDesc  = StaticArray::arrWaterfrontDesc();
            /*}*/
//echo '<pre>';print_r($objAPI->getMeta(array('SubType','SubTypeActris')));exit();
            $objTmpl->assign(array(
                'T_Body'		        =>	'listing/listing-searchfrm.tpl',
                'formAction'            =>	$frmAction,
                'arrMeta'               =>  $objAPI->getMeta(array('SubType','SubTypeActris')),
                'arrPriceRange'	        =>	StaticArray::arrPriceRange(''),
                'arrBedRange'	        =>	StaticArray::arrBedRange(''),
                'arrBathRange'	        =>	StaticArray::arrBathRange(''),
                'arrLotSize'	        =>	StaticArray::arrLotSize(),
                'arrSqftRange'	        =>	StaticArray::arrSQFTRange(''),
                'arrminYearBuild'	    =>	StaticArray::arrYearBuild('from'),
                'arrmaxYearBuild'	    =>	StaticArray::arrYearBuild('to'),
                'arrStatus'	            =>	StaticArray::arrStatus(),
                'arrDayMarket'	        =>	StaticArray::arrDayMarket(),
                'arrYesNo'	            =>	StaticArray::arrYesNo(),
                'arrWaterfrontDesc'	    =>	$arrWaterfrontDesc,
                'arrSecuritySafety'	    =>	StaticArray::arrSecuritySafety(),
                'arrTrueFalse'	        =>	StaticArray::arrTrueFalse(),
                'arrSortingOption'	    =>	StaticArray::arrSortingOption(),
                'arrSearchCriteria'	    =>	$arrsearchParam['sparam'],
                'arrFurnished'	        =>	StaticArray::arrFurnished(),
                'arrSystemName'         =>	StaticArray::arrSystemName(),
                'deviceType'	        =>	$deviceType,
                'isGrid'                =>  'false',
                'AgentSystemName'       =>	$opt['Agent']['agent_system_name'],
                'is_map'                =>  $arrsearchParam['sparam']['is_map'] ? $arrsearchParam['sparam']['is_map'] : 'true',

            ));

            return $this->output();

        }

        public function QuickSearchForm($atts)
        {
            global $objAPI, $objTmpl, $arrVirtualPath, $arrConfig, $arrPhysicalPath;
            $opt = get_option('lpt_config');
            $post_title = get_the_permalink($opt['page-config']['page-search-result']);

            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'] . 'common.js', array('jquery'), Constants::CSS_JS_VERSION, true);
            wp_localize_script('p-common-js', 'objLPTAjax', array('action' => 'lpt_front_ajax', 'lpt_mod' => 'consumer-tools', 'ajaxurl_as' => $arrConfig['autosugg_url'], 'ajaxurl' => admin_url('admin-ajax.php'), 'agentSysName' => $arrConfig['Agent']['agent_system_name']));

            wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'] . 'map-search.js', array('jquery'), Constants::CSS_JS_VERSION, true);
            wp_localize_script('p-mapsearch',
                'objMapSearch',
                array('action' => 'front_ajax', 'mod' => Constants::TYPE_LISTING_MAPSEARCH, 'url' => admin_url('admin-ajax.php')));

			if(isset($atts['style']) && $atts['style'] != '')
			{
				$style = $atts['style'];
			}
			else{
				$style = 1;
			}
            /*if(isset($opt['Agent']['agent_system_name']) && $opt['Agent']['agent_system_name'] == Constants::ACTRIS)
                $arrMeta = $objAPI->getMeta(array('SubTypeActris'));
            else*/
                $arrMeta = $objAPI->getMeta(array('SubType'));

            if (isset($atts['style']) && $atts['style'] == 6)
            {
                if (isset($atts['darkmode']) && $atts['darkmode'] != '') {
                    $darkmode = $atts['darkmode'];
                } else {
                    $darkmode = 'true';
                }

                if (isset($atts['bgcolor']) && $atts['bgcolor'] != '') {
                    $bgcolor = $atts['bgcolor'];
                } else {
                    $bgcolor = '#000';
                }

                $objTmpl->assign(array(
                    'darkmode'  =>  $darkmode,
                    'bgcolor'   =>  $bgcolor,
                ));
            }

	        $frmAction = $post_title;
	        $objTmpl->assign(array(
		                         'T_Body'		    =>	'quick-search-form.tpl',
		                         'formAction'       =>	$frmAction,
		                         'OtherConfig'      =>	$opt['OtherConfig'],
		                         'arrPriceRange'	=>	StaticArray::arrPriceRangeQuick(''),
		                         'arrBedRange'	    =>	StaticArray::arrBedRange(''),
		                         'arrBathRange'	    =>	StaticArray::arrBathRange(''),
		                         'arrMeta'          =>  $arrMeta,
		                         'style'            =>  $style,
                                 'AgentSystemName'  =>	$opt['Agent']['agent_system_name'],
	                         ));

	        return $this->output();
        }
        public function SearchForm($attr)
        {
            global $objAPI, $objTmpl, $arrVirtualPath, $arrConfig, $arrPhysicalPath;

            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script( 'p-common-js', 'objLPTAjax', array( 'action' => 'lpt_front_ajax', 'lpt_mod' => 'consumer-tools', 'ajaxurl_as' => $arrConfig['autosugg_url'],'ajaxurl' => admin_url( 'admin-ajax.php' ),'agentSysName' => strtoupper($arrConfig['Agent']['agent_system_name'])));

            /*wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script(	'p-mapsearch',
                'objMapSearch',
                array('action' => 'front_ajax', 'mod' => Constants::TYPE_LISTING_MAPSEARCH, 'url' => admin_url('admin-ajax.php')));*/
            wp_enqueue_style('lpt-color-style');
            $opt=get_option('lpt_config');
            $post_title=get_the_permalink($opt['page-config']['page-search-result']);


            $frmAction = $post_title;

            wp_enqueue_style('srchresult');
            $isTitle = true;
            if(isset($attr['title']))
            {
                $isTitle = $attr['title'];
            }
            $objTmpl->assign(array(
                'T_Body'		=>	'search-form.tpl',
                'formAction'    =>	$frmAction,
                'OtherConfig'    =>	$opt['OtherConfig'],
                'isTitle'    =>	$isTitle,

            ));

            return $this->output();
        }

        public function listingSearchResult($attr)
        {


            global $objAPI, $objTmpl, $arrVirtualPath, $wpdb, $arrPhysicalPath, $wp,$arrConfig;

            ShortCodeHandler::getInstance()->mapListing();
            wp_enqueue_script('default-style-js', $arrVirtualPath['TemplateJs']. 'default-style.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

            include_once($arrPhysicalPath['Libs']. '/Mobile-Detect-2.8.19/OE_Mobile_Detect.php');
            $detect  =   new Mobile_Detect();
            $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
            //echo '<pre>';print_r($arrConfig);exit();
            if(isset($_POST) && count($_POST) > 0){

                $arrsearchParam = Utility::GetSearchParamAndURL(false, $_POST);
                $url = $_SERVER['REQUEST_URI'].'/?'.$arrsearchParam['url'];
                echo("<script>history.replaceState({},'','$url');</script>");
            }else{
                $arrsearchParam = Utility::GetSearchParamAndURL(urldecode($_SERVER['QUERY_STRING']), false);
            }

            if(is_array($attr) && count($attr) > 0)
            {
                $attrParam = Utility::GetSearchParamAndURL(false, $attr);
                if(isset($arrsearchParam['sparam'])){
                    $arrsearchParam['sparam'] = array_merge($attrParam['sparam'],$arrsearchParam['sparam']);
                }else{
                    $arrsearchParam['sparam'] = array_merge($attrParam['sparam'],$arrsearchParam);
                }
            }

            if(isset($arrsearchParam['sparam']['city']))
            {
                $arrsearchParam['sparam']['city'] = str_replace('-',' ',$arrsearchParam['sparam']['city']);
            }

            $arrsearchParam['sparam']['getMapData'] = true;

//	        $arrsearchParam['sparam']['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']:Constants::LISTING_PAGE_SIZE);
            $arrsearchParam['sparam']['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']: (isset($attr['isgrid']) && $attr['isgrid'] == true ? Constants:: GRIDVIEW_PAGE_SIZE : Constants::LISTING_PAGE_SIZE));
            $page 			= (isset($arrsearchParam['sparam']['spage']) ? $arrsearchParam['sparam']['spage']: '1');


            $arrsearchParam['sparam']['start_record'] 	= ($page - 1) * $arrsearchParam['sparam']['page_size'];
            //$arrsearchParam['sparam']['so'] = (isset($_GET['so']) && $_GET['so'] != ''? $_GET['so']:Constants::DEFAULT_SO);
            $arrsearchParam['sparam']['so'] = (isset($_GET['so']) && $_GET['so'] != ''? $_GET['so']:'cosfr');
            $arrsearchParam['sparam']['sd'] = (isset($_GET['sd']) && $_GET['sd'] != ''? $_GET['sd']:'asc');
            //$arrsearchParam['sparam']['sd'] = (isset($_GET['sd']) && $_GET['sd'] != ''? $_GET['sd']:Constants::DEFAULT_SD);
           // $arrsearchParam['sparam']['isMap'] = (isset($_GET['isMap']) && $_GET['isMap'] != ''? $_GET['isMap']:'');

            //$arrsearchParam['sparam']['status'] = (isset($_GET['status']) && $_GET['status'] != ''? $_GET['status']:Constants::DEFAULT_STATUS);
            $arrsearchParam['sparam']['status'] = (isset($_POST['status']) && $_POST['status'] != '' ? $_POST['status'] : (isset($_GET['status']) && $_GET['status'] != '' ? $_GET['status']:Constants::DEFAULT_STATUS));

            //$arrsearchParam['sparam']['Is_GeoCoded'] = true;

            //echo '<pre>';print_r($_GET);exit();
            /* if we get system name then we going to use this shortcode other wise set deafault miami feed listing */
           /* if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
            {
                $arrsearchParam['sparam']['sys_name'] = StaticArray::arr_ASName_LookUP()[$arrConfig['Agent']['agent_system_name']];
            }*/
            if(isset($attr['sys_name']))
            {
                $arrsearchParam['sparam']['sys_name'] = StaticArray::arr_SName_LookUP()[strtolower($attr['sys_name'])];
            }
            else
            {
                $arrsearchParam['sparam']['sys_name'] = Constants:: DEFAULT_LISTINGS;
            }
            //$arrsearchParam['sparam']['sys_name'] = 'actris';
            //$arrsearchParam['sparam']['dom'] = '7';
            /*if (is_array($_GET) && empty($_GET))
            {
                $arrsearchParam['sparam']['sort_order_list'] = array('DOM' => 'asc', 'ListPrice' => 'desc');
            }*/

            //$arrSearchResult = $objAPI->getListingByParam($arrsearchParam['sparam'], '', Constants::VT_MAP);
            $arrSearchResult = $objAPI->getIDXListingByParam($arrsearchParam['sparam'], '', Constants::VT_MAP);
            //echo '<pre>';print_r($arrSearchResult);exit();

            if(isset($attr['issorting']) && $attr['issorting'] != ''){
                $issorting = 'false';
            }else{
                $issorting = 'true';
            }
            if(isset($attr['issavesearch']) && $attr['issavesearch'] == 'false'){
                $issavesearch = 'false';
            }else{
                $issavesearch = 'true';
            }

            if(isset($attr['isgrid']) && $attr['isgrid'] == true){
                $isGrid = 'true';
                $issavesearch = 'false';
            }else{
                $isGrid = 'false';
            }
            /*if(isset($attr['disclaimer']) && $attr['disclaimer'] == 'false'){
                $disclaimer = 'false';
            }else{
                $disclaimer = 'true';
            }*/

            if( is_user_logged_in() ){

                global $current_user;
                $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);

                $objTmpl->assign(array(
                    'isUserLoggedIn'    =>  true,
                    'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
                    'user_id'    =>  $current_user->data->ID,

                ));
            }
            else {

                $objTmpl->assign(array(
                    'isUserLoggedIn'    =>  false,
                ));
            }
            //print_r($arrsearchParam);exit();
            /*if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
            {
                $arrSearchResult['MLS_last_update_date'] = new DateTimeImmutable($arrSearchResult['MLS_last_update_date']);
                $MLS_date = gmdate('F d, Y', $arrSearchResult['MLS_last_update_date']->format('U'));
                $MLS_time = gmdate('h:ia', $arrSearchResult['MLS_last_update_date']->format('U'));
                $MLS_last_update_date = $MLS_date." at ".$MLS_time;

                $sys_name = StaticArray::arr_ASName_LookUP()[$arrConfig['Agent']['agent_system_name']];
            }
            else
            {*/
                $arrSearchResult['MLS_last_update_date'] = new DateTimeImmutable($arrSearchResult['MLS_last_update_date']);
                $MLS_last_update_date = gmdate('M d, Y', $arrSearchResult['MLS_last_update_date']->format('U'));

                $sys_name = $arrsearchParam['sparam']['sys_name'];
           /* }*/

            $objTmpl->assign(array(
                'T_Body'		            =>	'listing/listing-result.tpl',
                'Site_Url'                  =>  get_home_url().'/',
                'URL'                       =>  $current_url,
                'currency'                  =>  '$',
                'page'                      =>  $page,
                'page_size'                 =>  $arrsearchParam['sparam']['page_size'],
                'arrSortingOption'	        =>	StaticArray::arrSortingOption(),
                'TPL_images'                =>  $arrVirtualPath['TemplateImages'],
                'arrSearchCriteria'	        =>	$arrsearchParam['sparam'],
                'total_record'	            =>	$arrSearchResult['total_record'],
                'jsonMapData'	            =>	$arrSearchResult['map-data'],
                'MLS_last_update_date'	    =>	$MLS_last_update_date,//gmdate('M d, Y', $arrSearchResult['MLS_last_update_date']->format('U')),
                'mapZoomLevel'              =>  $arrsearchParam['sparam']['mz'] ? $arrsearchParam['sparam']['mz'] : 13,
                'mapCenterLat'              =>  $arrsearchParam['sparam']['clat'] ? $arrsearchParam['sparam']['clat'] : 25.761681, // Austin: 30.3074624, -98.0335911 // Dallas 32.8203525, -97.0115281
                'mapCenterLng'              =>  $arrsearchParam['sparam']['clng'] ? $arrsearchParam['sparam']['clng'] : -80.191788,
                'issorting'		            =>	$issorting,
                'issavesearch'	            =>	$issavesearch,
                'memberDetail'	            =>	Constants::TYPE_MEMBER_DETAIL,
                'deviceType'                =>  $deviceType,
                'isGrid'                    =>  $isGrid,
                'arrSystemName'             =>	StaticArray::arrSystemName(),
                'sys_name'                  =>  $sys_name,//$arrsearchParam['sparam']['sys_name'],
                'is_map'                    =>  $arrsearchParam['sparam']['is_map'] ? $arrsearchParam['sparam']['is_map'] : 'true',
                //'isPredefined'            =>  'false',
                //'disclaimer'                =>  $disclaimer,
                'AgentSystemName'           =>	$arrConfig['Agent']['agent_system_name'],
                'login_enable'              =>	$arrConfig['OtherConfig']['login_enable'],
                'bitcoin'                   =>	$arrConfig['bitcoin'],
                'etherium'                  =>	$arrConfig['etherium'],
                'cardano'                   =>	$arrConfig['cardano'],
            ));
           // var_dump($isMap);

            return $this->output();
        }
        public function mapListing()
        {
            global $objAPI, $objTmpl, $arrVirtualPath, $wpdb, $arrPhysicalPath, $wp;
            wp_enqueue_script('ore-google-map','https://maps.googleapis.com/maps/api/js?libraries=drawing,geometry,places&key=AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',array(),Constants::CSS_JS_VERSION);
            //wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_script('p-gmap-marker', $arrVirtualPath['TemplateJs'].'gmap-marker.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_script('p-jsxcompressor', $arrVirtualPath['Libs'].'jQuery/JSXCompressor/jsxcompressor.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            wp_enqueue_script('p-jquery-lzl', $arrVirtualPath['Libs'].'jQuery/jquery_lazyload/jquery.lazyload.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            wp_enqueue_style('p-mapsearchCSS');
            wp_enqueue_style('srchresult');

            /* wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
             wp_localize_script(	'p-common-js',
                 'objMem',
                 array('action' => 'front_ajax', 'mod' => Constants::TYPE_MEMBER_DETAIL, 'url' => admin_url('admin-ajax.php')));*/

            wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script(	'p-mapsearch',
                'objMapSearch',
                array('action' => 'front_ajax', 'mod' => Constants::TYPE_LISTING_MAPSEARCH, 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('lpt-color-style');
        }
        public function PredefineSearchResult($attr)
        {
            global $arrVirtualPath,$objTmpl,$wp,$arrConfig;

            ShortCodeHandler::getInstance()->mapListing();

            if(isset($attr['pid']) && is_numeric($attr['pid']))
            {
                $shareUrl = get_home_url().'/'.$_SERVER['REQUEST_URI'];
                $objAPI = IDXAPI::getInstance();
                $predefine = $objAPI->getPredefinedSearchById($attr['pid']);
                //echo '<pre>';print_r($predefine);exit();
                if(is_array($predefine) && count($predefine) > 0){
	                $isHeading = true;
                	if(isset($attr['heading']))
	                {
	                	$isHeading = $attr['heading'];
	                }
                    $isFilter = true;
                    if(isset($attr['filter']))
                    {
                        $isFilter = $attr['filter'];
                    }

                    if(isset($attr['isgrid']) && $attr['isgrid'] == true){
                        $isGrid = 'true';
                        $issavesearch = 'false';
                    }else{
                        $isGrid = 'false';
                    }

                    $isstyle = false;
                    if(isset($attr['style']))
                    {
                        $isstyle = $attr['style'];
                    }
                    $searchParam = unserialize($predefine['psearch_criteria']);
                    $searchParam['getMapData'] = true;
                    if(isset($predefine['psearch_result_limit']) && $predefine['psearch_result_limit'] != '')
                    {
                        $searchParam['page_size'] = $predefine['psearch_result_limit'];
                    }
                    elseif ($isstyle != false && ($isstyle == 2 || $isstyle == 1 || $isstyle == 3 || $isstyle == 4 || $isstyle == 7))
                    {
                    	if(isset($attr['limit']) && $attr['limit'] != '')
	                    {
		                    $searchParam['page_size']    = $attr['limit'];
	                    }
	                    else{
		                    $searchParam['page_size']    = Constants:: GRIDVIEW_STYLE2_PAGE_SIZE;
	                    }

                    }
                    elseif($isstyle != false && ($isstyle == 5 || $isstyle == 6 || $isstyle == 10))
                    {
	                    if(isset($attr['limit']) && $attr['limit'] != '')
	                    {
		                    $searchParam['page_size']    = $attr['limit'];
	                    }
                        elseif(isset($isstyle) && $isstyle == 5)
                        {
                            $searchParam['page_size']   = Constants:: GRIDVIEW_STYLE5_PAGE_SIZE;
                        }
                        elseif(isset($isstyle) && $isstyle == 10)
                        {
                            $searchParam['page_size']   = Constants:: GRIDVIEW_STYLE10_PAGE_SIZE;
                        }
                        else{
                            $searchParam['page_size']   = Constants:: GRIDVIEW_STYLE6_PAGE_SIZE;
                        }
                    }
                    else{
                        $searchParam['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']: (isset($attr['isgrid']) && $attr['isgrid'] == true ? Constants:: GRIDVIEW_PAGE_SIZE : Constants::LISTING_PAGE_SIZE));
                    }
//                $searchParam['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']: (isset($attr['isgrid']) && $attr['isgrid'] == true ? Constants:: GRIDVIEW_PAGE_SIZE : Constants::LISTING_PAGE_SIZE));

                    $page		= (isset($_GET['spage']) && $_GET['spage'] != ''? $_GET['spage']: (isset($searchParam['spage']) ? $searchParam['spage'] : '1'));
//		        $page 			= (isset($searchParam['spage']) ? $searchParam['spage']: '1');
                    $searchParam['start_record'] 	= ($page - 1) * $searchParam['page_size'];
                    $marketReport = get_home_url().'/'.Constants::TYPE_MARKET_REPORT_DETAIL.'/'.str_replace(' ', '-', $predefine['psearch_title']);

                    if(isset($searchParam['sort_by']) && $searchParam['sort_by'] != '')
                    {
                        $arrsort = explode('|', $searchParam['sort_by']);
                        $searchParam['so'] = (isset($arrsort[0]) && $arrsort[0] != ''? $arrsort[0]:Constants::DEFAULT_SO);
                        $searchParam['sd'] = (isset($arrsort[1]) && $arrsort[1] != ''? $arrsort[1]:Constants::DEFAULT_SD);
                        unset($searchParam['sort_by']);
                    }

                    /*if(!isset($attr['isgrid']) && $attr['isgrid'] != true){
                        $searchParam['Is_GeoCoded'] = true;
                    }*/
                    $searchParam = array_merge($_GET, $searchParam);
                    $is_rental= false;
                    if(isset($_GET['isrental']) && ($_GET['isrental'] == 'true' || $_GET['isrental'] == true))
                    {
	                    $searchParam['status'] = 'rental';
	                    $is_rental= true;
                    }

                    /* REDIS */
                    /*$redis = new Redis();
                    $redis->connect('127.0.0.1', 6379);

                    if(isset($attr['pid']) && is_numeric($attr['pid']) && $attr['pid'] != '')
                    {
                        $cacheQuery = $redis->get($_SERVER['SERVER_NAME'].'_ps_'.$attr['pid']);
                    }

                    if($cacheQuery)
                    {
                        $arrResult = unserialize($cacheQuery);
                    }
                    else
                    {
                        $arrResult = $objAPI->getListingByParam($searchParam,'',Constants::VT_MAP);

                        if(isset($attr['pid']) && is_numeric($attr['pid']) && $attr['pid'] != '')
                        {
                            $redis->set($_SERVER['SERVER_NAME'].'_ps_' . $attr['pid'], serialize($arrResult));
                            $redis->expire($_SERVER['SERVER_NAME'].'_ps_' . $attr['pid'], 3600);
                        }
                    }*/

                    $arrResult = $objAPI->getIDXListingByParam($searchParam,'',Constants::VT_MAP);

                   // echo '<pre>';print_r($arrResult);exit();
                    if(isset($predefine['psearch_result_limit']) && $predefine['psearch_result_limit'] != '')
                    {
                        $total_record = $predefine['psearch_result_limit'];
                    }else{
                        $total_record = $arrResult['total_record'];
                    }

                    wp_enqueue_style('p-mapsearchCSS');

                    //wp_enqueue_script('p-highchart',$arrVirtualPath['Libs'].'/jQuery/highchart/code/highcharts.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                    wp_enqueue_script('p-chart',$arrVirtualPath['Libs'].'/jQuery/highchart/chart.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

                    wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                    wp_localize_script(	'p-common-js',
                        'objMem',
                        array('action' => 'front_ajax', 'mod' => Constants::TYPE_MEMBER_DETAIL, 'url' => admin_url('admin-ajax.php'), 'google_conv_code' => $arrConfig['OtherConfig']['google_conv_code'], 'captcha_site_key' => $arrConfig['Listing']['google_site_key']));

                    if(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 2){

//                        wp_enqueue_style( 'style2-css', $arrVirtualPath['TemplateCss']. 'style2.css',array(),Constants::CSS_JS_VERSION);
                        wp_enqueue_script('style2-js', $arrVirtualPath['TemplateJs']. 'style2.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                    }
                    elseif (isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && ($isstyle == 1 || $isstyle == 7 || $isstyle == 8 || $isstyle == 9)){

                        wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',array(),Constants::CSS_JS_VERSION);

                        wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',array(),Constants::CSS_JS_VERSION);


                        if($isstyle == 8)
                        {
	                        wp_enqueue_script('style8-js', $arrVirtualPath['TemplateJs']. 'style8.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                        }
                        elseif($isstyle == 9)
                        {
	                        wp_enqueue_script('style9-js', $arrVirtualPath['TemplateJs']. 'style9.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                        }
                        else{
	                        wp_enqueue_script('style1-js', $arrVirtualPath['TemplateJs']. 'style1.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                        }
                    }
                    elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 3)
                    {
	                    wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',array(),Constants::CSS_JS_VERSION);

	                    wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',array(),Constants::CSS_JS_VERSION);
	                    wp_enqueue_script('style3-js', $arrVirtualPath['TemplateJs']. 'style3.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
	                    wp_enqueue_style('style3-css', $arrVirtualPath['TemplateCss']. 'style3.css', array(), Constants::CSS_JS_VERSION);
                    }
                    /*elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && ($isstyle == 4 || $isstyle == 5))
                    {
	                    wp_enqueue_script('style4-js', $arrVirtualPath['TemplateJs']. 'style4.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
	                    wp_enqueue_style('style4-css', $arrVirtualPath['TemplateCss']. 'style4.css', array(), Constants::CSS_JS_VERSION);
                    }*/
                    elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 4)
                    {
                        wp_enqueue_script('style4-js', $arrVirtualPath['TemplateJs']. 'style4.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                        wp_enqueue_style('style4-css', $arrVirtualPath['TemplateCss']. 'style4.css', array(), Constants::CSS_JS_VERSION);
                    }
                    elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 5)
                    {
                        wp_enqueue_script('style5-js', $arrVirtualPath['TemplateJs']. 'style5.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                        wp_enqueue_style('style5-css', $arrVirtualPath['TemplateCss']. 'style5.css', array(), Constants::CSS_JS_VERSION);
                    }
                    elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 6)
                    {
	                    wp_enqueue_script('style6-js', $arrVirtualPath['TemplateJs']. 'style6.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
	                    wp_enqueue_style('style4-css', $arrVirtualPath['TemplateCss']. 'style4.css', array(), Constants::CSS_JS_VERSION);
                    }
                    elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 10)
                    {
	                    wp_enqueue_script('style10-js', $arrVirtualPath['TemplateJs']. 'style10.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                    }
                    elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 11)
                    {
                        wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/jquery.slick/1.3.13/slick.css',array(),Constants::CSS_JS_VERSION);

                        wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/jquery.slick/1.3.13/slick.min.js',array(),Constants::CSS_JS_VERSION);

	                    wp_enqueue_script('style11-js', $arrVirtualPath['TemplateJs']. 'style11.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                        wp_enqueue_style('style11-css', $arrVirtualPath['TemplateCss']. 'style11.css', array(), Constants::CSS_JS_VERSION);
                    }
                    elseif(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 12)
                    {
                        wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',array(),Constants::CSS_JS_VERSION);

                        wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',array(),Constants::CSS_JS_VERSION);

	                    wp_enqueue_script('style12-js', $arrVirtualPath['TemplateJs']. 'style12.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                        wp_enqueue_style('style12-css', $arrVirtualPath['TemplateCss']. 'style12.css', array(), Constants::CSS_JS_VERSION);
                    }
                    else{
                        wp_enqueue_script('default-style-js', $arrVirtualPath['TemplateJs']. 'default-style.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                    }

                    if( is_user_logged_in() ){

                        global $current_user;
                        $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  true,
                            'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
                            'user_id'    =>  $current_user->data->ID,

                        ));
                    }
                    else {

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  false,
                        ));
                    }
                    if(isset($attr['issorting']) && $attr['issorting'] != ''){
                        $issorting = 'false';
                    }else{
                        $issorting = 'true';
                    }
                    /*if(isset($attr['disclaimer']) && $attr['disclaimer'] == 'false'){
                        $disclaimer = 'false';
                    }else{
                        $disclaimer = 'true';
                    }*/
                    if(isset($attr['tabs']) && $attr['tabs'] == 'false'){
                        $tabs = 'false';
                    }else{
                        $tabs = 'true';
                    }

                    $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                   /* if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
                    {
                        $arrResult['MLS_last_update_date'] = new DateTimeImmutable($arrResult['MLS_last_update_date']);
                        $MLS_date = gmdate('F d, Y', $arrResult['MLS_last_update_date']->format('U'));
                        $MLS_time = gmdate('h:ia', $arrResult['MLS_last_update_date']->format('U'));
                        $MLS_last_update_date = $MLS_date." at ".$MLS_time;

                        $sys_name = StaticArray::arr_ASName_LookUP()[$arrConfig['Agent']['agent_system_name']];
                    }
                    else
                    {*/
                        $arrResult['MLS_last_update_date'] = new DateTimeImmutable($arrResult['MLS_last_update_date']);
                        $MLS_last_update_date = gmdate('M d, Y', $arrResult['MLS_last_update_date']->format('U'));

                        $sys_name = $searchParam['sys_name'];
                   /* }*/

                    if(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 12 && (isset($attr['css']) && $attr['css'] != '') || (isset($attr['title']) && $attr['title'] != ''))
                    {
                        if(isset($attr['css']) && $attr['css'] != '')
                        {
                            $CustomCSS = $attr['css'];
                        }
                        if(isset($attr['title']) && $attr['title'] != '')
                        {
                            $CustomTitle = $attr['title'];
                        }

                        if(isset($attr['background']) && $attr['background'] != '')
                        {
                            $background = $attr['background'];
                        }



                        $objTmpl->assign(array(
                            'CustomCSS'    =>  $CustomCSS ? $CustomCSS : '',
                            'CustomTitle'    =>  $CustomTitle ? $CustomTitle : '',
                            'Background'    =>  $background ? $background : '',

                        ));
                    }
                    if(isset($attr['url']) && $attr['url'] != '')
                    {
                        $viewURL = $attr['url'];
                    }
                    if(isset($attr['rel']) && $attr['rel'] != '')
                    {
                        $rel = $attr['rel'];
                    }
                    //echo '<pre>';print_r($attr);exit();
                    $maxViewedExceed = 'false';
                    if (isset($arrConfig['OtherConfig']['login_enable']) && $arrConfig['OtherConfig']['login_enable'] == 'Yes')
                    {
                        if (isset($arrConfig['Listing']['signup_required_for_view_property']) && $arrConfig['Listing']['signup_required_for_view_property'] == 'Yes')
                        {

                            if (($arrConfig['Listing']['site_max_viewed_without_login'] >= 0) && (!is_user_logged_in() == true)) {
                                //$_SESSION['user_view_details_count'] = $_SESSION['user_view_details_count'] + 1;

                                if ($arrConfig['Listing']['site_max_viewed_without_login'] == 0 || ($arrConfig['Listing']['site_max_viewed_without_login'] > 0 && $_COOKIE['user_view_details_count'] >= $arrConfig['Listing']['site_max_viewed_without_login'])) {
                                    $maxViewedExceed = true;
                                }
                            }
                        }
                    }

                    $objTmpl->assign(array(
                        'T_Body'		                =>	'listing/listing-result.tpl',
                        'Site_Url'                      =>  get_home_url().'/',
                        'URL'                           =>  $current_url,
                        'arrSortingOption'	            =>	StaticArray::arrSortingOption(),
                        'arrPreQuickSorting'	        =>	StaticArray::arrPreQuickSorting(),
                        'currency'                      =>  '$',
                        'predefinedId'                  =>  $attr['pid'],
                        'page'                          =>  $page,
                        'page_size'                     =>  $searchParam['page_size'],
                        'TPL_images'                    =>  $arrVirtualPath['TemplateImages'],
                        'arrSearchCriteria'		        =>	$searchParam,
                        'total_record'	                =>	$total_record,
                        'jsonMapData'	                =>	$arrResult['map-data'],
                        'mapZoomLevel'                  =>  $searchParam['mz'] ? $searchParam['mz'] : 13,
                        'mapCenterLat'                  =>  $searchParam['clat'] ? $searchParam['clat'] : 25.761681, // Austin: 30.3074624, -98.0335911 // Dallas 32.8203525, -97.0115281
                        'mapCenterLng'                  =>  $searchParam['clng'] ? $searchParam['clng'] : -80.191788,
                        'isSorting'		                =>	true,
                        'memberDetail'	                =>	Constants::TYPE_MEMBER_DETAIL,
                        'psearch_generate_mrktreport'	=>	$predefine['psearch_generate_mrktreport'],
                        'psearch_generate_rental'	    =>	$predefine['psearch_generate_rental'],
                        'psearch_display_tab'	        =>	$predefine['psearch_display_tab'],
                        'marketReportURL'	            =>	$marketReport,
                        'isGrid'	                    =>	$isGrid,
                        'isHeading'	                    =>	$isHeading,
                        'issorting'                     => $issorting,
                        'isFilter'                      => $isFilter,
                        'issavesearch'		            =>	'false',
                        'isPredefined'		            =>	true,
                        'presearch_title'		        =>	$predefine['psearch_title'],
                        'arrMeta'                       =>  $objAPI->getMeta(array('SubType')),
                        'arrPriceRange'	                =>	StaticArray::arrPriceRange(''),
                        'arrBedRange'	                =>	StaticArray::arrBedRange(''),
                        'arrBathRange'	                =>	StaticArray::arrBathRange(''),
                        'arrLotSize'	                =>	StaticArray::arrLotSize(),
                        'arrSqftRange'	                =>	StaticArray::arrSQFTRange(''),
                        'arrminYearBuild'	            =>	StaticArray::arrYearBuild('from'),
                        'arrmaxYearBuild'	            =>	StaticArray::arrYearBuild('to'),
                        'arrStatus'	                    =>	StaticArray::arrStatus(),
                        'arrDayMarket'	                =>	StaticArray::arrDayMarket(),
                        'arrYesNo'	                    =>	StaticArray::arrYesNo(),
                        'arrTrueFalse'	                =>	StaticArray::arrTrueFalse(),
                        'shareUrl'	                    =>	$shareUrl,
                        'isstyle'	                    =>	$isstyle,
                        'is_rental'	                    =>	$is_rental,
                        'rental_url'                    =>  home_url( $wp->request ).'?isrental=true',
                        'view_page_url'                 =>  home_url().$arrConfig['OtherConfig']['style8_view_page_url'],
                        'is_map'                        =>  $searchParam['sparam']['is_map'] ? $searchParam['sparam']['is_map'] : 'true',
                        'MLS_last_update_date'	        =>	$MLS_last_update_date,//gmdate('M d, Y', $arrResult['MLS_last_update_date']->format('U')),
                        //'disclaimer'                    =>  $disclaimer,
                        'tabs'                          =>  $tabs,
                        'sys_name'                      =>  $sys_name,//$searchParam['sys_name'],
                        'login_enable'                  =>	$arrConfig['OtherConfig']['login_enable'],
                        'bitcoin'                       =>	$arrConfig['bitcoin'],
                        'etherium'                      =>	$arrConfig['etherium'],
                        'cardano'                       =>	$arrConfig['cardano'],
                        'attr'                          => $attr,
                        'ViewURL'    =>  $viewURL ? $viewURL : '',
                        'rel'    =>  $rel,
                        'isloginReq'		 =>	 (isset($arrConfig['Listing']['signup_required_for_view_property']) ? $arrConfig['Listing']['signup_required_for_view_property'] : 'No'),
                        'arrConfig'         =>  $arrConfig,
                        'maxViewedExceed'         =>  $maxViewedExceed,

                    ));

                    return $this->output();
                }
                else{

                    $objTmpl->assign(array(
                        'T_Body'		=>	'listing/listing-result.tpl',
                        'isPredefined'		=>	true,
                        'total_record'	=>	0,
                        'isGrid'	        =>	'true',

                    ));
                    return $this->output();
                }

            }
            else{
                return 'No results found';
            }

        }
        public function  PredefineMarketReport($attr){
            //echo '<pre>';print_r($attr);exit();

            global $objTmpl, $arrPhysicalPath, $arrVirtualPath, $arrConfig, $userinfo;

            $objAPI     = IDXAPI::getInstance();

            $Action = "market-report";
            $title = str_replace('-',' ',$attr['title']);

            $pre_search = $objAPI->getPredefinedSearchById($attr['pid']);




            /*$con_search = CondoSearch::getInstance()->getCondoSearchById($attr['cid']);

            if(is_array($con_search) && $con_search['csearch_name'] != '')
            {
                $statistic = $objAPI->getCondoStatistic($con_search['csearch_id']);
            }
            else
            {
                $statistic = $objAPI->getPreDefineStatistic($pre_search['psearch_id']);
            }*/
            $statistic = $objAPI->getPreDefineStatistic($pre_search['psearch_id']);
            if(isset($criteria['status']) && is_array($criteria['status']))
            {
                if(in_array('active', $criteria['status']) || in_array('pending', $criteria['status']) && !in_array('rental', $criteria['status']))
                {
                    $criteria['notptype'] = 'ResidentialLease';
                }
                elseif (in_array('rental', $criteria['status']) && !in_array('active', $criteria['status']))
                {
                    $criteria['stype'] = 'ResidentialLease';
                }
            }

            if(date("d") == date("d", strtotime("last day of this month")))
            {
                $date = date("Y-m-d");
            }
            else
            {
                $date = date("Y-m-d", strtotime("last month"));
            }

            $temp_date = date("Y-m-01", strtotime($date));
            $before_six_month = date("Y-m-d", strtotime($temp_date." -5 Month"));


            $criteria['status'] = 'closed';
//                $criteria['sort_by'] = 'sold|asc';
            $criteria['so'] = 'sold';
            $criteria['sd'] = 'desc';
            $criteria['page_size'] = 30;
            $criteria['last_sold'] = $before_six_month;

            //$recent_sales = $objAPI->getIDXListingByParam($criteria);
            //echo "<pre>";print_r($recent_sales);die;

            /*if(is_array($con_search) && $con_search['csearch_criteria'] != '')
                $rcriteria = unserialize($con_search['csearch_criteria']);
            else*/
                $rcriteria = unserialize($pre_search['psearch_criteria']);

            $rcriteria['status'] = 'active';
            $rcriteria['so'] = 'pricedef';
            $rcriteria['sd'] = 'asc';
            //$rcriteria['sort_by'] = 'pricedef|asc';
            $rcriteria['page_size'] = 15;
            $rcriteria['pricereduce'] = true;
            $rcriteria['maxpricedef'] = '-60';

            //$price_red = $objAPI->getIDXListingByParam($rcriteria,true,Constants::VT_LIST);

            unset($rcriteria['maxpricedef'], $rcriteria['pricereduce']);
            $rcriteria['status'] = 'pending';
            $rcriteria['so'] = 'price';
            $rcriteria['sd'] = 'desc';
            //$rsPending = $objAPI->getIDXListingByParam($rcriteria,true,Constants::VT_LIST);
            //echo "<pre>";print_r($rsPending);die;
            $SEOstype = StaticArray::MarketRepoSEOStype();

            if(isset($criteria['stype'])){
                $subtype = '';
                foreach ($criteria['stype'] as $key=>$val){
                    if (array_key_exists($val, $SEOstype)){
                        $subtype .= $SEOstype[$val].', ';
                    }
                    else{
                        $subtype .= preg_replace('/(?<!\ )[A-Z]/', ' $0',strtolower($val)).', ';
                    }
                };
//                    $subtype = implode(', ', preg_replace('/(?<!\ )[A-Z]/', ' $0', $criteria['stype']));

            }else{
                $subtype = '';
            }

            $desc = 'As of '.date('F j, Y'). ' there are approximately '.$count.' '.trim($subtype, ', ').' for '.(isset($criteria['status']) && $criteria['status'] == 'rental'? 'rent':'sale').' in '.(isset($criteria['city'])? implode(', ', $criteria['city']):'').', Florida with a median listing price of $'.number_format($statistic['statistic_median_active_price']).' or $'.number_format($statistic['statistic_median_active_price_sqft']).' per square foot. In the last 180 days, approximately '.number_format($statistic['statistic_sixmon_tot_sold_listing']).' '.trim($subtype, ', ').' sold in '.
                (isset($criteria['city'])? implode(', ', $criteria['city']):'').', FL with a median closing price of $'.number_format($statistic['statistic_median_sold_price']).' or $'.number_format($statistic['statistic_median_sold_price_sqft']).' per square foot.';
            /*.(isset($criteria['stype'])? ' Interested in refinancing or selling your '.implode(', ', preg_replace('/(?<!\ )[A-Z]/', ' $0', $criteria['stype'])).'?':'').
        ' Contact a '.(isset($criteria['city'])? implode(', ', $criteria['city']):''). ' REALTOR速 specializing in '.(isset($criteria['stype'])? implode(', ', preg_replace('/(?<!\ )[A-Z]/', ' $0', $criteria['stype'])):'').' for sale in '.(isset($criteria['city'])? implode(', ', $criteria['city']):'').' to provide a free market value of your home.';*/
            $this->meta_desc = $desc;

            /* if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
             {
                 $price_red['MLS_last_update_date'] = new DateTimeImmutable($price_red['MLS_last_update_date']);
                 $MLS_date = gmdate('F d, Y', $price_red['MLS_last_update_date']->format('U'));
                 $MLS_time = gmdate('h:ia', $price_red['MLS_last_update_date']->format('U'));
                 $MLS_last_update_date = $MLS_date." at ".$MLS_time;
             }
             else
             {*/
            $price_red['MLS_last_update_date'] = new DateTimeImmutable($price_red['MLS_last_update_date']);
            $MLS_last_update_date = gmdate('M d, Y', $price_red['MLS_last_update_date']->format('U'));
            /* }*/

            /*if(is_array($con_search) && $con_search['csearch_id'] > 0)
                $Title = $con_search['csearch_name'];
            else
                $Title = $this->getTitle();*/
            if(isset($attr['background']) && $attr['background'] != '')
            {
                $background = $attr['background'];
            }

            $objTmpl->assign(array(
                'pre-search'            =>  $pre_search,
                'statistic'             =>  $statistic,
                'title'                 =>  $attr['title'],
                'attr'                  =>  $attr,
                'pid'                  =>  $attr['pid'],
                'currency'              =>  '$',
                //'recent_sales'          =>  $recent_sales['rs'],
                //'rsPending'             =>  $rsPending,
                //'price_red'             =>  $price_red,
                'arrConfig'             =>  $arrConfig,
                'TodayDate'             =>  date('m-d-Y'),
                'SEODescription'        =>  $desc,
                //'sys_name'              =>  $criteria['sys_name'],
                'Templates_Image'	    =>	$arrVirtualPath['TemplateImages'],
                'MLS_last_update_date'	=>	$MLS_last_update_date,//gmdate('M d, Y', $price_red['MLS_last_update_date']->format('U')),
            )
            );

            $content = $objTmpl->fetch('market_report_shortcode.tpl');

            return $content;
            //echo '<pre>';print_r($statistic);exit();


        }
        public function EditProfile()
        {
            global $arrConfig,$objTmpl,$arrVirtualPath;
            $userInfo = wp_get_current_user();
            $arrname = explode('_',$userInfo->data->display_name);
            $meta = get_user_meta($userInfo->data->ID);
            wp_enqueue_style('srchresult');
            wp_enqueue_style( 'p-user-dashboard', $arrVirtualPath['Libs']. 'front/css/user-dashboard.css',array(),Constants::CSS_JS_VERSION);
            //wp_enqueue_style( 'p-search-result', $arrVirtualPath['Libs']. 'front/css/search-results.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_style( 'p-mls-property', $arrVirtualPath['Libs']. 'front/css/mls-properties-embedding.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('lpt-color-style');
            if( is_user_logged_in() ){

                $objTmpl->assign(array(
                    //'T_Right'           =>  $ShortCodeHandlerobj->MyaccountRightSidebar(),
                    'T_Body'            =>	'my-account/edit-profile.tpl',
                    'userInfo'           =>  $userInfo->data,
                    'first_name'         =>  $arrname[0],
                    'last_name'          =>  $arrname[1],
                    'meta'               =>  $meta,
                    'arrConfig'          =>  $arrConfig,


                ));
                return $this->output();
            }
            else
            {
                header("Location:".get_home_url());
                exit(0);
            }
        }

        public function ChangePassword()
        {
            global $arrConfig,$objTmpl,$arrVirtualPath;
            $userInfo = wp_get_current_user();
            $arrname = explode('_',$userInfo->data->display_name);
            $meta = get_user_meta($userInfo->data->ID);
            wp_enqueue_style('srchresult');
            wp_enqueue_style( 'p-user-dashboard', $arrVirtualPath['Libs']. 'front/css/user-dashboard.css',array(),Constants::CSS_JS_VERSION);
            //wp_enqueue_style( 'p-search-result', $arrVirtualPath['Libs']. 'front/css/search-results.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_style( 'p-mls-property', $arrVirtualPath['Libs']. 'front/css/mls-properties-embedding.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('lpt-color-style');
            if( is_user_logged_in() ){

                $objTmpl->assign(array(
                    //'T_Right'           =>  $ShortCodeHandlerobj->MyaccountRightSidebar(),
                    'T_Body'            =>	 'my-account/change-password.tpl',
                    'userInfo'           =>  $userInfo->data,
                    'first_name'         =>  $arrname[0],
                    'last_name'          =>  $arrname[1],
                    'meta'               =>  $meta,
                    'arrConfig'          =>  $arrConfig,


                ));
                return $this->output();
            }
            else
            {
                header("Location:".get_home_url());
                exit(0);
            }
        }
        public function FavouriteProperty()
        {
            global $arrConfig,$objTmpl,$arrVirtualPath,$current_user;
            $userInfo = $current_user;
            $arrname = explode('_',$userInfo->data->display_name);
            $meta = get_user_meta($userInfo->data->ID);
            wp_enqueue_style('srchresult');
            wp_enqueue_style( 'p-user-dashboard', $arrVirtualPath['Libs']. 'front/css/user-dashboard.css',array(),Constants::CSS_JS_VERSION);
            //wp_enqueue_style( 'p-search-result', $arrVirtualPath['Libs']. 'front/css/search-results.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_style( 'p-mls-property', $arrVirtualPath['Libs']. 'front/css/mls-properties-embedding.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('lpt-color-style');
            if( is_user_logged_in() ){
                $objAPI = IDXAPI::getInstance();
                $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($userInfo->data->ID);
                if(count($userFavMLSNo) > 0)
                {
                    $arrParams = array();
                    $arrParams['mlsnowithmarket']    =   implode(",",$userFavMLSNo);
                    //	$arrParams[P_SIZE] = '12';
                    $arrListing =    $objAPI->getListingByParam($arrParams);

                    $objTmpl->assign(array(
                        "rsResult"			=>	$arrListing['rs'],
                        "total_record"		=>	$arrListing['total_record'],
                        "PhotoBaseUrl"		=>	$arrListing['PhotoBaseUrl'],
                        'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
                        'currency'          =>  '$',

                    ));
                }
                $objTmpl->assign(array(
                    //'T_Right'           =>  $ShortCodeHandlerobj->MyaccountRightSidebar(),
                    'T_Body'            =>	'my-account/favourite-property.tpl',
                    'userInfo'           =>  $userInfo->data,
                    'first_name'         =>  $arrname[0],
                    'last_name'          =>  $arrname[1],
                    'meta'               =>  $meta,
                    'arrConfig'          =>  $arrConfig,


                ));
                return $this->output();
            }
            else
            {
                header("Location:".get_home_url());
                exit(0);
            }
        }
        public function SavedSearches()
        {
            global $arrConfig,$objTmpl,$arrVirtualPath,$current_user;
            wp_enqueue_style('srchresult');
            wp_enqueue_style( 'p-user-dashboard', $arrVirtualPath['Libs']. 'front/css/user-dashboard.css',array(),Constants::CSS_JS_VERSION);
            //wp_enqueue_style( 'p-search-result', $arrVirtualPath['Libs']. 'front/css/search-results.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_style( 'p-mls-property', $arrVirtualPath['Libs']. 'front/css/mls-properties-embedding.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('lpt-color-style');

            $objAPI = IDXAPI::getInstance();
            $save_search = LPTUserSavedSearches::getInstance()->getUserSaveSearch($current_user->data->ID);
            $objTmpl->assign(array(
                //'T_Right'           =>  $ShortCodeHandlerobj->MyaccountRightSidebar(),
                'T_Body'            =>	'my-account/saved-search.tpl',
                'userInfo'           =>  $current_user->data,
                'arrConfig'          =>  $arrConfig,
                'save_search'        =>  $save_search,
            ));
            return $this->output();

        }
        public function output()
        {

            global $objTmpl,$arrPhysicalPath,$arrVirtualPath,$arrConfig;

            $objTmpl->assign(array(
                'base_image'=>$arrVirtualPath['TemplateImages'],

            ));
            if(defined('POPUP_WIN'))
                return   $objTmpl->fetch('default_popup.tpl');
            else
                return  $objTmpl->fetch('default_layout.tpl');


        }
        public function BuildingData($attr)
        {
            global $objTmpl,$arrVirtualPath;

            wp_enqueue_style( 'building-data-css', $arrVirtualPath['TemplateCss'].'building-data.css',array(),Constants::CSS_JS_VERSION);

            $objAPI = IDXAPI::getInstance();
            $statistic = $objAPI->getPreDefineStatistic($attr['pid']);

            $objTmpl->assign(array(
                'T_Body'	=>	'building-data.tpl',
                'title'     =>	$attr['title'],
                'statistic' =>	$statistic,
            ));

            return $this->output();
        }

        public function CondoSearchResult($attr)
        { 
            global $arrVirtualPath,$objTmpl,$arrConfig;


            wp_enqueue_script('p-condo-js', $arrVirtualPath['TemplateJs'] . 'condo.js', array('jquery'), Constants::CSS_JS_VERSION, true);
            wp_enqueue_style('condo-css', $arrVirtualPath['TemplateCss']. 'condo.css', array(), Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_style( 'p-search-result', $arrVirtualPath['TemplateCss']. 'search-results.css',array(),Constants::CSS_JS_VERSION);

            if(isset($attr['cid']) && is_numeric($attr['cid']))
            {
                $shareUrl   = get_home_url().'/'.$_SERVER['REQUEST_URI'];
                $objAPI     = IDXAPI::getInstance();
                $condo      = $objAPI->getCondoSearchById($attr['cid']);

                if(is_array($condo) && count($condo) > 0){

                    $searchParam = unserialize($condo['csearch_criteria']);

                    if(isset($condo['csearch_result_limit']) && $condo['csearch_result_limit'] != '')
                    {
                        $searchParam['page_size'] = $condo['csearch_result_limit'];
                    }
                    else
                    {
                        $searchParam['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']:Constants::LISTING_PAGE_SIZE);
                    }

                    $page   = (isset($_GET['spage']) && $_GET['spage'] != ''? $_GET['spage']: (isset($searchParam['spage']) ? $searchParam['spage'] : '1'));		        $page 			= (isset($searchParam['spage']) ? $searchParam['spage']: '1');

                    $searchParam['start_record']    = ($page - 1) * $searchParam['page_size'];
                    $condoMarketReport = get_home_url().'/'.Constants::TYPE_MARKET_REPORT_DETAIL.str_replace(' ', '-', $_SERVER['REQUEST_URI']);
                    $searchParam = array_merge($_GET, $searchParam);

                    //$param['status']    = 'active';
                    $param['add']       = $searchParam['add'];
                    $param['sdivlist']  = $searchParam['sdivlist'];
                    $param['city']      = $searchParam['city'];
                    $param['zipcode']   = $searchParam['zipcode'];
                    $param['stype']     = $searchParam['stype'];
                    $param['sys_name']  = $searchParam['sys_name'];
                    $param['so']        = 'price';
                    $param['sd']        = 'desc';

                    $arrResult = $objAPI->getIDXListingByParam($param,'',Constants::VT_MAP);
                    if(isset($condo['csearch_result_limit']) && $condo['csearch_result_limit'] != '')
                    {
                        $total_record = $condo['csearch_result_limit'];
                    }
                    else
                    {
                        $total_record = $arrResult['total_record'];
                    }

                    $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                    wp_enqueue_style( 'icon-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',array(),Constants::CSS_JS_VERSION);
                    wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',array(),Constants::CSS_JS_VERSION);
                    wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',array(),Constants::CSS_JS_VERSION);

                    /* Condo Statistics */
                    $statistic  = $objAPI->getCondoStatistic($condo['csearch_id']);

                    //$Param              = $searchParam;
                    $param['status']            = array('active','rental','pending');
                    $param['sort_order_list']   = array('Beds' => 'desc', 'ListPrice' => 'desc');
                    $arrCondoStatistic          = $objAPI->getIDXListingByParam($param,true,Constants::VT_MAP);

                    $params['add']               = $searchParam['add'];
                    $params['city']              = $searchParam['city'];
                    $params['zipcode']           = $searchParam['zipcode'];
                    $params['stype']             = $searchParam['stype'];
                    $params['sys_name']          = $searchParam['sys_name'];
                    $params['status']            = 'closed';
                    $params['sort_order_list']   = array('Beds' => 'desc', 'Sold_Date' => 'desc');

                    $arrRecentSales                 = $objAPI->getIDXListingByParam($params,true,Constants::VT_MAP);
                    $arrCondoStatisticResult['rs']  = array_merge($arrCondoStatistic['rs'],$arrRecentSales['rs']);

                    if( is_user_logged_in() ){

                        global $current_user;
                        $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);
                        $userFavCondo       = LPTUserFavoriteCondo::getInstance()->getUserFavoritesCondos($current_user->data->ID);

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  true,
                            'userFavList'       =>  explode(',',$userFavMLSNo['strIds']),
                            'userFavCondoList'  =>  explode(',',$userFavCondo['strIds']),
                            'user_id'           =>  $current_user->data->ID,

                        ));
                    }
                    else {

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  false,
                        ));
                    }
                    
//echo "<pre>";print_r($arrConfig);exit();
                    $objTmpl->assign(array(
                        'T_Body'		            =>	'condo/condo-result.tpl',
                        'Site_Url'                  =>  get_home_url().'/',
                        'URL'                       =>  $current_url,
                        'currency'                  =>  '$',
                        'condoId'                   =>  $attr['cid'],
                        'page'                      =>  $page,
                        'page_size'                 =>  $searchParam['page_size'],
                        'TPL_images'                =>  $arrVirtualPath['TemplateImages'],
                        'arrSearchCriteria'		    =>	$searchParam,
                        'total_record'	            =>	$total_record,
                        'csearch_name'              =>	$condo['csearch_name'],
                        'shareUrl'                  =>	$shareUrl,
                        'arrCondoResult'            =>	$arrResult['rs'],
                        'Host_Url'                  =>  get_home_url(),
                        'arrCondo'                  =>  $condo,
                        'arrCStatistics'            =>  $statistic,
                        'arrCondoStatisticResult'   =>	$arrCondoStatisticResult,
                        'arrConfig'                 =>	$arrConfig,
                        'marketReportURL'	        =>	$condoMarketReport,
                    ));
                    return $this->output();
                }
                else{

                    $objTmpl->assign(array(
                        'T_Body'		=>	'condo/condo-result.tpl',
                        'isCondo'		=>	true,
                        'total_record'	=>	0,
                    ));
                    return $this->output();
                }

            }
            else{
                return 'No results found';
            }
        }
        public function MarketReport($attr)
        {
            global $objTmpl, $arrPhysicalPath, $arrVirtualPath, $arrConfig, $userinfo;

            //wp_enqueue_script('p-highchart', $arrVirtualPath['Libs'] . '/jQuery/highchart/code/highcharts.js', array('jquery'), Constants::CSS_JS_VERSION, true);
            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'] . 'common.js', array('jquery'), Constants::CSS_JS_VERSION, true);
            wp_enqueue_script('p-chart', $arrVirtualPath['Libs'] . '/jQuery/chart/chart.js', array('jquery'), Constants::CSS_JS_VERSION, true);

            $objAPI = IDXAPI::getInstance();

            $Action = "market-report-new";

            $default_PreSearch = true;
            $default_ConSearch = true;

            if (isset($attr['pid']) && $attr['pid'] != '') {
                if (strpos($attr['pid'], ',') !== false) {
                    $attr['pid'] = explode(',', $attr['pid']);
                }
            }

            if(isset($default_PreSearch) && $default_PreSearch == true) {
                $pre_search = $objAPI->getPredefinedSearchById($attr['pid']);
            }

            if(isset($default_ConSearch) && $default_ConSearch == true) {
                $con_search = $objAPI->getCondoSearchById($attr['cid']);
            }

            if (isset($pre_search) && is_array($pre_search) && count($pre_search) > 0) {
                for ($i = 0; $i <= count($pre_search); $i++) {
                    $home_search[$pre_search[$i]['psearch_title']] = $pre_search[$i];
                }
            }

            # market insights
            if (isset($home_search['market insights'])) {
                $market_insights = $home_search['market insights'];
                $pre_static      = $objAPI->getPreDefineStatistic($market_insights['psearch_id']);

                if (isset($pre_static)) {
                    $pre_totcount = unserialize($pre_static['statistic_property_type_cnt']);
                    $pre_totcount = $pre_totcount['active'];
                    $pre_monthly_data = unserialize($pre_static['statistic_monthly_property_data']);
                    $MNT_data['xAx'] = array_keys($pre_monthly_data['active']);
                    $pre_yAy = array_values($pre_monthly_data['active']);

                    for ($i = 0; $i < count($pre_yAy); $i++) {
                        $pre_price[$i] = $pre_yAy[$i]['price'];
                        $pre_count[$i] = $pre_yAy[$i]['count'];
                        $pre_sqft[$i] = $pre_yAy[$i]['sqft'];
                    }

                    $MNT_data['preTotCnt'] = $pre_totcount;
                    $MNT_data['precnt'] = $pre_count;
                    $MNT_data['preprice'] = $pre_price;
                    $MNT_data['prepricesqft'] = $pre_sqft;
                }
            }

            if (isset($con_search['csearch_id'])) {
                $con_static     = $objAPI->getCondoStatistic($con_search['csearch_id']);

                if (isset($con_search)) {
                    $con_totcount = unserialize($con_static['statistic_property_type_cnt']);
                    $con_totcount = $con_totcount['active'];
                    $con_monthly_data = unserialize($con_static['statistic_monthly_property_data']);
                    $con_yAy = array_values($con_monthly_data['active']);

                    for ($i = 0; $i < count($con_yAy); $i++) {
                        $con_price[$i] = $con_yAy[$i]['price'];
                        $con_count[$i] = $con_yAy[$i]['count'];
                        $con_sqft[$i] = $con_yAy[$i]['sqft'];
                    }

                    $MNT_data['conTotCnt'] = $con_totcount;
                    $MNT_data['concnt'] = $con_count;
                    $MNT_data['conprice'] = $con_price;
                    $MNT_data['conpricesqft'] = $con_sqft;
                }
            }

            $MNT_data['min'] = min($pre_price) > min($con_price) ? min($con_price) : min($pre_price);
            $MNT_data['max'] = max($pre_price) > max($con_price) ? max($pre_price) : max($con_price);

            # Active for sale
            $st = 'active';
            if (isset($pre_static)) {
                $pre_comp_data = unserialize($pre_static['statistic_comparision_data']);

                if (isset($pre_comp_data) && is_array($pre_comp_data) && $pre_comp_data != '') {
                    $pre_sale_active['MNT'] = $pre_comp_data['mo'][$st];
                    $pre_sale_active['YR'] = $pre_comp_data['yr'][$st];
                }
            }

            if (isset($con_static)) {
                $con_comp_data = unserialize($con_static['statistic_comparision_data']);

                if (isset($con_comp_data) && is_array($con_comp_data) && $con_comp_data != '') {
                    $con_sale_active['MNT'] = $con_comp_data['mo'][$st];
                    $con_sale_active['YR'] = $con_comp_data['yr'][$st];
                }
            }

            # Pending
            $st = 'pending';
            if (isset($home_search['pending market report'])) {
                $pending_market = $home_search['pending market report'];
                $pre_static_PND = $objAPI->getPreDefineStatistic($pending_market['psearch_id']);

                $pre_comp_data_PND = unserialize($pre_static_PND['statistic_comparision_data']);
                $pre_pending['MNT'] = $pre_comp_data_PND['mo'][$st];
                $pre_pending['YR'] = $pre_comp_data_PND['yr'][$st];

                $pre_monthly_data_PND = unserialize($pre_static_PND['statistic_monthly_property_data']);
                $MNT_data_PND['xAx'] = array_keys($pre_monthly_data_PND['pending']);
                $pre_yAy_PND = array_values($pre_monthly_data_PND['pending']);

                for ($i = 0; $i < count($pre_yAy_PND); $i++) {
                    $pre_price_PND[$i] = $pre_yAy_PND[$i]['price'];
                    $pre_count_PND[$i] = $pre_yAy_PND[$i]['count'];
                }

                $MNT_data_PND['precnt'] = $pre_count_PND;
                $MNT_data_PND['preprice'] = $pre_price_PND;
            }

            if (isset($con_comp_data)) {
                $con_pending['MNT'] = $con_comp_data['mo'][$st];
                $con_pending['YR'] = $con_comp_data['yr'][$st];

                if (isset($con_monthly_data['pending'])) {
                    $con_yAy_PND = array_values($con_monthly_data['pending']);
                }
                for ($i = 0; $i < count($con_yAy_PND); $i++) {
                    $con_price_PND[$i] = $con_yAy_PND[$i]['price'];
                    $con_count_PND[$i] = $con_yAy_PND[$i]['count'];
                }
                $MNT_data_PND['concnt'] = $con_count_PND;
                $MNT_data_PND['conprice'] = $con_price_PND;
            }

            # Sold
            $st = 'closed';

            if (isset($home_search['sold market report'])) {
                $sold_market = $home_search['sold market report'];
                $pre_static_CLOSD = $objAPI->getPreDefineStatistic($sold_market['psearch_id']);

                $pre_comp_data_CLOSD = unserialize($pre_static_CLOSD['statistic_comparision_data']);
                $pre_closed['MNT'] = $pre_comp_data_CLOSD['mo'][$st];
                $pre_closed['YR'] = $pre_comp_data_CLOSD['yr'][$st];

                $pre_monthly_data_CLOSD = unserialize($pre_static_CLOSD['statistic_monthly_property_data']);
                $MNT_data_CLOSD['xAx'] = array_keys($pre_monthly_data_CLOSD[$st]);
                $pre_yAy_CLOSD = array_values($pre_monthly_data_CLOSD[$st]);

                for ($i = 0; $i < count($pre_yAy_CLOSD); $i++) {
                    $pre_price_CLOSD[$i] = $pre_yAy_CLOSD[$i]['price'];
                    $pre_count_CLOSD[$i] = $pre_yAy_CLOSD[$i]['count'];
                }
                $MNT_data_CLOSD['precnt'] = $pre_count_CLOSD;
                $MNT_data_CLOSD['preprice'] = $pre_price_CLOSD;
            }

            if (isset($con_comp_data)) {
                $con_closed['MNT'] = $con_comp_data['mo'][$st];
                $con_closed['YR'] = $con_comp_data['yr'][$st];

                if (isset($con_monthly_data[$st])) {
                    $con_yAy_CLOSD = array_values($con_monthly_data[$st]);
                }
                for ($i = 0; $i < count($con_yAy_CLOSD); $i++) {
                    $con_price_CLOSD[$i] = $con_yAy_CLOSD[$i]['price'];
                    $con_count_CLOSD[$i] = $con_yAy_CLOSD[$i]['count'];
                }
                $MNT_data_CLOSD['concnt'] = $con_count_CLOSD;
                $MNT_data_CLOSD['conprice'] = $con_price_CLOSD;
            }

            # sold luxury
            if (isset($home_search['sold luxury market report'])){
                $sold_lux_market = $home_search['sold luxury market report'];
                $pre_static_LUX = $objAPI->getPreDefineStatistic($sold_lux_market['psearch_id']);

                $pre_comp_data_LUX = unserialize($pre_static_LUX['statistic_comparision_data']);
                $pre_luxury['MNT'] = $pre_comp_data_LUX['mo'][$st];
                $pre_luxury['YR'] = $pre_comp_data_LUX['yr'][$st];
                $pre_monthly_data_LUX = unserialize($pre_static_LUX['statistic_monthly_property_data']);

                $MNT_data_LUX['xAx'] = array_keys($pre_monthly_data_LUX[$st]);
                $pre_yAy_LUX = array_values($pre_monthly_data_LUX[$st]);

                for ($i = 0; $i < count($pre_yAy_LUX); $i++) {
                    $pre_price_LUX[$i] = $pre_yAy_LUX[$i]['price'];
                    $pre_count_LUX[$i] = $pre_yAy_LUX[$i]['count'];
                }
                $MNT_data_LUX['precnt'] = $pre_count_LUX;
                $MNT_data_LUX['preprice'] = $pre_price_LUX;
            }

            if (isset($con_comp_data)) {
                $con_luxury['MNT'] = $con_comp_data['mo']['closed_luxury'];
                $con_luxury['YR'] = $con_comp_data['yr']['closed_luxury'];
                if (isset($pre_monthly_data_LUX[$st]) && isset($con_monthly_data['closed_luxury'])) {

                    $con_yAy_LUX = array_values($con_monthly_data['closed_luxury']);
                }
                for ($i = 0; $i < count($con_yAy_LUX); $i++) {
                    $con_price_LUX[$i] = $con_yAy_LUX[$i]['price'];
                    $con_count_LUX[$i] = $con_yAy_LUX[$i]['count'];
                }
                $MNT_data_LUX['concnt'] = $con_count_LUX;
                $MNT_data_LUX['conprice'] = $con_price_LUX;
            }

            # show listings tables
            if (is_array($pre_search) && $pre_search['psearch_criteria'] != '') {
                $rcriteria = unserialize($pre_search['psearch_criteria']);
            }

            # price reduce by %
            if (isset($default_PreSearch) && $default_PreSearch == true) {
                $rcriteria['market_report'] = 'YES';
                $rcriteria['status'] = 'active';
                $rcriteria['so'] = 'pricedef';
                $rcriteria['sd'] = 'asc';
                $rcriteria['page_size'] = 25;
                $rcriteria['pricereduce'] = true;
                $rcriteria['maxpricedef'] = '-60';

                $price_red_percnt = $objAPI->getIDXListingByParam($rcriteria, false, Constants::VT_LIST);

                # price reduce by price
                $rcriteria['so'] = 'pricedefer';
                $rcriteria['sd'] = 'desc';
                $price_red_price = $objAPI->getIDXListingByParam($rcriteria, false, Constants::VT_LIST);

                # Under Contract/Pending
                unset($rcriteria['maxpricedef'], $rcriteria['pricereduce']);

                $rcriteria['status'] = 'pending';
                $rcriteria['so'] = 'price';
                $rcriteria['sd'] = 'desc';
                $rsPending = $objAPI->getIDXListingByParam($rcriteria,false,Constants::VT_LIST);

                # Recent sale
                if (date("d") == date("d", strtotime("last day of this month"))) {
                    $date = date("Y-m-d");
                } else {
                    $date = date("Y-m-d", strtotime("last month"));
                }

                $temp_date = date("Y-m-01", strtotime($date));
                $before_six_month = date("Y-m-d", strtotime($temp_date . " -5 Month"));

                $rcriteria['status'] = 'closed';
//                $criteria['sort_by'] = 'sold|asc';
                $rcriteria['so'] = 'sold';
                $rcriteria['sd'] = 'desc';
                $rcriteria['page_size'] = 25;
                $rcriteria['last_sold'] = $before_six_month;

                $recent_sales = $objAPI->getIDXListingByParam($rcriteria);
            }

            /*-----------------------------------------------------------*/

            if (is_array($con_search) && $con_search['csearch_criteria'] != '') {
                $rcriteria_con = unserialize($con_search['csearch_criteria']);
            }

            if (isset($default_ConSearch) && $default_ConSearch == true) {
                $rcriteria_con['market_report'] = 'YES';
                $rcriteria_con['status'] = 'active';
                $rcriteria_con['so'] = 'pricedef';
                $rcriteria_con['sd'] = 'asc';
                $rcriteria_con['page_size'] = 25;
                $rcriteria_con['pricereduce'] = true;
                $rcriteria_con['maxpricedef'] = '-60';

                $price_red_percnt_con = $objAPI->getIDXListingByParam($rcriteria_con, false, Constants::VT_LIST);

                # price reduce by price
                $rcriteria_con['so'] = 'pricedefer';
                $rcriteria_con['sd'] = 'desc';
                $price_red_price_con = $objAPI->getIDXListingByParam($rcriteria_con, false, Constants::VT_LIST);

                # Under Contract/Pending
                unset($rcriteria_con['maxpricedef'], $rcriteria_con['pricereduce']);

                $rcriteria_con['status'] = 'pending';
                $rcriteria_con['so'] = 'price';
                $rcriteria_con['sd'] = 'desc';
                $rsPending_con = $objAPI->getIDXListingByParam($rcriteria_con,false,Constants::VT_LIST);

                # Recent sale
                if (date("d") == date("d", strtotime("last day of this month"))) {
                    $date = date("Y-m-d");
                } else {
                    $date = date("Y-m-d", strtotime("last month"));
                }

                $temp_date = date("Y-m-01", strtotime($date));
                $before_six_month = date("Y-m-d", strtotime($temp_date . " -5 Month"));

                $rcriteria_con['status'] = 'closed';
//                $criteria_con['sort_by'] = 'sold|asc';
                $rcriteria_con['so'] = 'sold';
                $rcriteria_con['sd'] = 'desc';
                $rcriteria_con['page_size'] = 25;
                $rcriteria_con['last_sold'] = $before_six_month;

                $recent_sales_con = $objAPI->getIDXListingByParam($rcriteria_con);
            }

            $objTmpl->assign(array(
                    'arrConfig'         => $arrConfig,
                    /*'PreSearch' => (isset($pre_search) && $pre_search != '')?true : false,
                    'ConSearch' => (isset($con_search) && $con_search != '')?true : false,*/
                    'PreSearch'         => $default_PreSearch,
                    'ConSearch'         => $default_ConSearch,
                    'preCount'          => $pre_totcount,
                    'conCount'          => $con_totcount,
                    'PreStatic'         => $pre_static,
                    'PreStaticPND'      => $pre_static_PND,
                    'PreStaticCLOSD'    => $pre_static_CLOSD,
                    'PreStaticLUX'      => $pre_static_LUX,
                    'ConStatic'         => $con_static,
                    'PreSaleActive'     => $pre_sale_active,
                    'ConSaleActive'     => $con_sale_active,
                    'PrePending'        => $pre_pending,
                    'ConPending'        => $con_pending,
                    'PreClosed'         => $pre_closed,
                    'ConClosed'         => $con_closed,
                    'PreClosedLux'      => $pre_luxury,
                    'ConClosedLux'      => $con_luxury,
                    'monthlyData'       => $MNT_data,
                    'monthlyDataPND'    => $MNT_data_PND,
                    'monthlyDataCLOSD'  => $MNT_data_CLOSD,
                    'monthlyDataLUX'    => $MNT_data_LUX,
                    'preTotCount'       => $pre_totcount,
                    'conTotCount'       => $con_totcount,
                    'currency'          => '$',
                    'percnt'            => '%',
                    'price_red'         => $price_red_percnt,
                    'price_red_ByPrice' => $price_red_price,
                    'recent_sales'      =>  $recent_sales['rs'],
                    'rsPending'         =>  $rsPending,
                    'price_red_con'         => $price_red_percnt_con,
                    'price_red_ByPrice_con' => $price_red_price_con,
                    'recent_sales_con'      =>  $recent_sales_con['rs'],
                    'rsPending_con'         =>  $rsPending_con,
                    'Templates_Image'   => $arrVirtualPath['TemplateImages'],
                )
            );
            $content = $objTmpl->fetch('market_report_new.tpl');

            return $content;
        }
    }
}
?>