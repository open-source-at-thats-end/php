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

        public static function getInstance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new ShortCodeHandler();
            }
            return self::$instance;
        }


        public function listingSearchForm($atts)
        {
            global $objAPI, $objTmpl, $arrVirtualPath, $arrConfig, $arrPhysicalPath;

            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script( 'p-common-js', 'objLPTAjax', array( 'action' => 'lpt_front_ajax', 'lpt_mod' => 'consumer-tools', 'ajaxurl_as' => $arrConfig['autosugg_url'],'ajaxurl' => admin_url( 'admin-ajax.php' ), 'agentSysName' => $arrConfig['Site_Agent']['agent_mls']));

            wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script(	'p-mapsearch',
                'objMapSearch',
                array('action' => 'front_ajax', 'mod' => Constants::TYPE_LISTING_MAPSEARCH, 'url' => admin_url('admin-ajax.php')));
            //wp_enqueue_style('ore-color-style');

            include_once($arrPhysicalPath['Libs']. '/Mobile-Detect-2.8.19/OE_Mobile_Detect.php');
            $detect  =   new Mobile_Detect();
            $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

            $opt=get_option('lpt_config');

            $post_title=get_the_permalink($opt['page-config']['page-search-result']);

            $frmAction = $post_title;

            wp_enqueue_style('srchresult');

            if(isset($_POST) && count($_POST) > 0) {
                $arrsearchParam = Utility::GetSearchParamAndURL(false, $_POST);
            }else{
                $arrsearchParam = Utility::GetSearchParamAndURL(urldecode($_SERVER['QUERY_STRING']), false);
            }

           /* if(isset($opt['Site_Agent']['agent_mls']) && $opt['Site_Agent']['agent_mls'] == Constants::ACTRIS) {
                $arrWaterfrontDesc = StaticArray::arrWaterfrontDescActris();
            }
            else
            {*/
                $arrWaterfrontDesc  = StaticArray::arrWaterfrontDesc();
            /*}*/

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

            $objTmpl->assign(array(
                'T_Body'		=>	'listing/listing-searchfrm.tpl',
                'formAction'    =>	$frmAction,
                'arrMeta'       =>  $objAPI->getMeta(array('SubType','SubTypeActris')),
                'arrPriceRange'	=>	StaticArray::arrPriceRange(''),
                'arrBedRange'	=>	StaticArray::arrBedRange(''),
                'arrBathRange'	=>	StaticArray::arrBathRange(''),
                'arrLotSize'	=>	StaticArray::arrLotSize(),
                'arrSqftRange'	=>	StaticArray::arrSQFTRange(''),
                'arrminYearBuild'	=>	StaticArray::arrYearBuild('from'),
                'arrmaxYearBuild'	=>	StaticArray::arrYearBuild('to'),
                'arrStatus'	    =>	StaticArray::arrStatus(),
                'arrDayMarket'	    =>	StaticArray::arrDayMarket(),
                'arrYesNo'	    =>	StaticArray::arrYesNo(),
                'arrWaterfrontDesc'	    =>	$arrWaterfrontDesc,
                'arrSecuritySafety'	    =>	StaticArray::arrSecuritySafety(),
                'arrTrueFalse'	    =>	StaticArray::arrTrueFalse(),
                'arrSortingOption'	    =>	StaticArray::arrSortingOption(),
                'arrSearchCriteria'	    =>	$arrsearchParam['sparam'],
                'arrFurnished'	    =>	StaticArray::arrFurnished(),
                'arrSystemName'=>	StaticArray::arrSystemName(),
                'deviceType'	    =>	$deviceType,
                'isGrid'    =>  'false',
                'AgentSystemName'       =>	$opt['Site_Agent']['agent_mls'],
                'is_map'                =>  $arrsearchParam['sparam']['is_map'] ? $arrsearchParam['sparam']['is_map'] : 'true',
                'login_enable'                  =>	$arrConfig['OtherConfig']['login_enable'],
            ));

            return $this->output();

        }
        public function QuickSearchForm($atts)
        {
	        global $objAPI, $objTmpl, $arrVirtualPath, $arrConfig, $arrPhysicalPath;
	        $opt=get_option('lpt_config');
	        $post_title=get_the_permalink($opt['page-config']['page-search-result']);

	        wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script( 'p-common-js', 'objLPTAjax', array( 'action' => 'lpt_front_ajax', 'lpt_mod' => 'consumer-tools', 'ajaxurl_as' => $arrConfig['autosugg_url'],'ajaxurl' => admin_url( 'admin-ajax.php' ), 'agentSysName' => $arrConfig['Site_Agent']['agent_mls']));

            wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script(	'p-mapsearch',
                'objMapSearch',
                array('action' => 'front_ajax', 'mod' => Constants::TYPE_LISTING_MAPSEARCH, 'url' => admin_url('admin-ajax.php')));
            $isTitle = true;
            if(isset($attr['title']))
            {
                $isTitle = $atts['title'];
            }
			if(isset($atts['style']) && $atts['style'] != '')
			{
				$style = $atts['style'];
			}
			else{
				$style = 1;
			}

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
		                         'T_Body'		=>	'quick-search-form.tpl',
		                         'formAction'    =>	$frmAction,
		                         'OtherConfig'    =>	$opt['OtherConfig'],
		                         'arrPriceRange'	=>	StaticArray::arrPriceRangeQuick(''),
		                         'arrBedRange'	=>	StaticArray::arrBedRange(''),
		                         'arrBathRange'	=>	StaticArray::arrBathRange(''),
		                         'arrMeta'       =>  $objAPI->getMeta(array('SubType','SubTypeActris')),
		                         'style'       => $style,
		                         'isTitle'       => $isTitle,
                                 'AgentSystemName'  => $opt['Site_Agent']['agent_mls'],
	                         ));

	        return $this->output();
        }
        public function SearchForm($attr)
        {
            global $objTmpl, $arrVirtualPath, $arrConfig;

            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script( 'p-common-js', 'objLPTAjax', array( 'action' => 'lpt_front_ajax', 'lpt_mod' => 'consumer-tools', 'ajaxurl_as' => $arrConfig['autosugg_url'],'ajaxurl' => admin_url( 'admin-ajax.php' ), 'agentSysName' => $arrConfig['Site_Agent']['agent_mls']));
            wp_enqueue_style('ore-color-style');
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
                'isTitle'       =>	$isTitle,
            ));

            return $this->output();
        }
        public function listingSearchResult($attr)
        {
            global $objAPI, $objTmpl, $arrVirtualPath, $arrPhysicalPath,$arrConfig;
            ShortCodeHandler::getInstance()->mapListing();
            wp_enqueue_script('default-style-js', $arrVirtualPath['TemplateJs']. 'default-style.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

            $opt=get_option('lpt_config');

            include_once($arrPhysicalPath['Libs']. '/Mobile-Detect-2.8.19/OE_Mobile_Detect.php');
            $detect  =   new Mobile_Detect();
            $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

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

            $arrsearchParam['sparam']['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']: (isset($attr['isgrid']) && $attr['isgrid'] == true ? Constants:: GRIDVIEW_PAGE_SIZE : Constants::LISTING_PAGE_SIZE));
            $page 			= (isset($arrsearchParam['sparam']['spage']) ? $arrsearchParam['sparam']['spage']: '1');

            $arrsearchParam['sparam']['start_record'] 	= ($page - 1) * $arrsearchParam['sparam']['page_size'];
            /*$arrsearchParam['sparam']['so'] = (isset($_GET['so']) && $_GET['so'] != ''? $_GET['so']:Constants::DEFAULT_SO);
            $arrsearchParam['sparam']['sd'] = (isset($_GET['sd']) && $_GET['sd'] != ''? $_GET['sd']:Constants::DEFAULT_SD);*/
            $arrsearchParam['sparam']['so'] = (isset($_GET['so']) && $_GET['so'] != ''? $_GET['so']:'cosfr');
            $arrsearchParam['sparam']['sd'] = (isset($_GET['sd']) && $_GET['sd'] != ''? $_GET['sd']:'asc');
            $arrsearchParam['sparam']['status'] = (isset($_POST['status']) && $_POST['status'] != '' ? $_POST['status'] : (isset($_GET['status']) && $_GET['status'] != '' ? $_GET['status']:Constants::DEFAULT_STATUS));

            //$arrsearchParam['sparam']['Is_GeoCoded'] = true;
           // echo '<pre>';print_r($arrsearchParam['sparam']);exit();

            /* if we get system name then we going to use this shortcode other wise set deafault miami feed listing */
            /*if(isset($opt['Site_Agent']['agent_mls']) && $opt['Site_Agent']['agent_mls'] == Constants::ACTRIS)
            {
                $arrsearchParam['sparam']['sys_name'] = StaticArray::arr_ASName_LookUP()[$opt['Site_Agent']['agent_mls']];
            }*/
            if(isset($attr['sys_name']))
            {
                $arrsearchParam['sparam']['sys_name'] = StaticArray::arr_SName_LookUP()[strtolower($attr['sys_name'])];
            }
            /*else
            {
                $arrsearchParam['sparam']['sys_name'] = Constants:: DEFAULT_LISTINGS;
            }*/

            if(isset($arrConfig['Site_Agent']['agent_select_mls']))
            {
                $arrsearchParam['sparam']['sys_name'] = $arrConfig['Site_Agent']['agent_select_mls'];
            }
            
            //$arrsearchParam['sparam']['dom'] = '7';
            $arrSearchResult = $objAPI->getIDXListingByParam($arrsearchParam['sparam'], '', 'map');

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
            //echo '<pre>';print_r($arrSearchResult);exit();
            /*if(isset($opt['Site_Agent']['agent_mls']) && $opt['Site_Agent']['agent_mls'] == Constants::ACTRIS) {
                $arrSearchResult['MLS_last_update_date'] = new DateTimeImmutable($arrSearchResult['MLS_last_update_date']);
                $MLS_date = gmdate('F d, Y', $arrSearchResult['MLS_last_update_date']->format('U'));
                $MLS_time = gmdate('h:ia', $arrSearchResult['MLS_last_update_date']->format('U'));
                $MLS_last_update_date = $MLS_date." at ".$MLS_time;
            }
            else
            {*/
                $arrSearchResult['MLS_last_update_date'] = new DateTimeImmutable($arrSearchResult['MLS_last_update_date']);
                $MLS_last_update_date = gmdate('M d, Y', $arrSearchResult['MLS_last_update_date']->format('U'));
            /*}*/

            $arrCryptoData = $objAPI->getCryptoData();

            $objTmpl->assign(array(
                'T_Body'		=>	'listing/listing-result.tpl',
                'Site_Url'      =>  get_home_url().'/',
                'URL'           =>  $current_url,
                'currency'      =>  '$',
                'page'          =>  $page,
                'page_size'     =>  $arrsearchParam['sparam']['page_size'],
                'arrSortingOption'	    =>	StaticArray::arrSortingOption(),
                'TPL_images'    =>  $arrVirtualPath['TemplateImages'],
                'arrSearchCriteria'	=>	$arrsearchParam['sparam'],
                'total_record'	=>	$arrSearchResult['total_record'],
                'jsonMapData'	=>	$arrSearchResult['map-data'],
                'MLS_last_update_date'	=>	$MLS_last_update_date,
                'mapZoomLevel'  =>  $arrsearchParam['sparam']['mz'] ? $arrsearchParam['sparam']['mz'] : 13,
                'mapCenterLat'  =>  $arrsearchParam['sparam']['clat'] ? $arrsearchParam['sparam']['clat'] : 25.761681, // Austin: 30.3074624, -98.0335911 // Dallas 32.8203525, -97.0115281
                'mapCenterLng'  =>  $arrsearchParam['sparam']['clng'] ? $arrsearchParam['sparam']['clng'] : -80.191788,
                'issorting'		=>	$issorting,
                'issavesearch'	=>	$issavesearch,
                'memberDetail'	=>	Constants::TYPE_MEMBER_DETAIL,
                'deviceType'    =>  $deviceType,
                'isGrid'    =>  $isGrid,
                'arrPType'	    =>	StaticArray::arrPropertyType(),
                'arrSType'	    =>	StaticArray::arrSubType(),
                'arrSystemName'=>	StaticArray::arrSystemName(),
                'sys_name'      => $arrsearchParam['sparam']['sys_name'],
                'is_map'        =>   $arrsearchParam['sparam']['is_map'] ? $arrsearchParam['sparam']['is_map'] : 'true',
                //'disclaimer'    => $disclaimer,
                'AgentSystemName'           =>	$opt['Site_Agent']['agent_mls'],
                'AgentCryptoValue'           =>	$arrConfig['Site_Agent']['crypto_active'],
                'login_enable'                  =>	$arrConfig['OtherConfig']['login_enable'],
                'bitcoin'                   =>	$arrCryptoData['bitcoin'],
                'etherium'                  =>	$arrCryptoData['etherium'],
                'cardano'                   =>	$arrCryptoData['cardano'],
                'hideAddress'               =>  $arrConfig['Listing']['hide_property_address'],

            ));

            return $this->output();
        }
        public function mapListing()
        {
            global $arrVirtualPath;
            wp_enqueue_script('ore-google-map','https://maps.googleapis.com/maps/api/js?libraries=drawing,geometry,places&key=AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-gmap-marker', $arrVirtualPath['TemplateJs'].'gmap-marker.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_script('p-jsxcompressor', $arrVirtualPath['Libs'].'jQuery/JSXCompressor/jsxcompressor.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            wp_enqueue_script('p-jquery-lzl', $arrVirtualPath['Libs'].'jQuery/jquery_lazyload/jquery.lazyload.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            wp_enqueue_style('p-mapsearchCSS');
            wp_enqueue_style('srchresult');


            wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_localize_script(	'p-mapsearch',
                'objMapSearch',
                array('action' => 'front_ajax', 'mod' => Constants::TYPE_LISTING_MAPSEARCH, 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('ore-color-style');

        }
        public function EditProfile()
        {
            global $arrConfig,$objTmpl,$arrVirtualPath;
            $userInfo = wp_get_current_user();
            $arrname = explode('_',$userInfo->data->display_name);
            $meta = get_user_meta($userInfo->data->ID);
            wp_enqueue_style('srchresult');
            wp_enqueue_style( 'p-user-dashboard', $arrVirtualPath['Libs']. 'front/css/user-dashboard.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('ore-color-style');

            if( is_user_logged_in() ){

                $objTmpl->assign(array(
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
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('ore-color-style');
            if( is_user_logged_in() ){

                $objTmpl->assign(array(
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
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('ore-color-style');
            if( is_user_logged_in() ){
                $objAPI = IDXAPI::getInstance();
                $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($userInfo->data->ID);
                if(count($userFavMLSNo) > 0)
                {
                    $arrParams = array();
                    $arrParams['mlsnowithmarket']    =   implode(",",$userFavMLSNo);

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
            wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
            wp_localize_script(	'p-my-account',
                'objMyAccount',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_localize_script(	'p-my-account',
                'objMem',
                array('action' => 'front_ajax', 'mod' => 'myaccount', 'url' => admin_url('admin-ajax.php')));
            wp_enqueue_style('ore-color-style');

            $save_search = LPTUserSavedSearches::getInstance()->getUserSaveSearch($current_user->data->ID);
            $objTmpl->assign(array(
            	'T_Body'            =>	'my-account/saved-search.tpl',
                'userInfo'           =>  $current_user->data,
                'arrConfig'          =>  $arrConfig,
                'save_search'        =>  $save_search,


            ));
            return $this->output();

        }

        public function PredefineSearchResult($attr)
        {
            global $arrVirtualPath,$objTmpl,$wp,$arrConfig;

            ShortCodeHandler::getInstance()->mapListing();

            if(isset($attr['pid']) && is_numeric($attr['pid']))
            {   
                if ((isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == 'Yes') || (!isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == '')) {
                    $redis = new Redis();
                    $redis->connect('127.0.0.1', 6379);
                }

                $shareUrl = get_home_url().'/'.$_SERVER['REQUEST_URI'];

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
                $isstyle = false;
                if(isset($attr['style']))
                {
                    $isstyle = $attr['style'];
                }
                if(isset($attr['issorting']) && $attr['issorting'] != ''){
		            $issorting = 'false';
	            }else{
		            $issorting = 'true';
	            }

	            if(isset($attr['isgrid']) && $attr['isgrid'] == true){
		            $isGrid = 'true';
	            }else{
		            $isGrid = 'false';
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

                $objAPI = IDXAPI::getInstance();
                if(isset($attr['ag']) && $attr['ag'] == true){

                    $predefine = LPTAgentPredefined::getInstance()->getInfoById($attr['pid']);
                    if(is_array($predefine) && count($predefine) > 0){

                        $searchParam = unserialize($predefine['psearch_criteria']);
                        if(isset($searchParam['Agent_profile_Id']) && $searchParam['Agent_profile_Id'] != ""){
                            $objTmpl->assign(array(
                                'agent_Profile_Id'		=>	($searchParam['Agent_profile_Id']=='Array' ? '' : $searchParam['Agent_profile_Id']),
                            ));
                        }
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
                        $page		= (isset($_GET['spage']) && $_GET['spage'] != ''? $_GET['spage']: (isset($searchParam['spage']) ? $searchParam['spage'] : '1'));
                        $searchParam['start_record'] 	= ($page - 1) * $searchParam['page_size'];

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
                        if ((isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == 'Yes') || (!isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == '')) {
                            if(isset($attr['ag']) && $attr['ag'] == true && isset($attr['pid']) && is_numeric($attr['pid']) && $attr['pid'] != '')
                            {
                                $cacheQuery = $redis->get($_SERVER['SERVER_NAME'].'_ps_ag_'.$attr['pid']);
                            }

                            if($cacheQuery)
                            {
                                $arrResult = unserialize($cacheQuery);
                            }
                            else
                            {
                                $arrResult = $objAPI->getListingByParam($searchParam,'','map');

                                if(isset($attr['ag']) && $attr['ag'] == true && isset($attr['pid']) && is_numeric($attr['pid']) && $attr['pid'] != '')
                                {
                                    $redis->set($_SERVER['SERVER_NAME'].'_ps_ag_'.$attr['pid'], serialize($arrResult));
                                    $redis->expire($_SERVER['SERVER_NAME'].'_ps_ag_'.$attr['pid'], 600);
                                }
                            }
                        }
                        else {
                            $arrResult = $objAPI->getIDXListingByParam($searchParam,'','map');
                        }

                        //$arrResult = $objAPI->getIDXListingByParam($searchParam,'','map');
                        if(isset($predefine['psearch_result_limit']) && $predefine['psearch_result_limit'] != '' && $arrResult['total_record'] > $predefine['psearch_result_limit'])
                        {
                            $total_record = $predefine['psearch_result_limit'];
                        }else{
                            $total_record = $arrResult['total_record'];
                        }

                    }else{

                        $objTmpl->assign(array(
                            'T_Body'		=>	'listing/listing-result.tpl',
                            'isPredefined'		=>	true,
                            'total_record'	=>	0,
                            'isGrid'	        =>	'true',

                        ));
                        return $this->output();
                    }

                }else{

                    //get listing by master predefined search
                    $searchParam['pid'] = $attr['pid'];
                    if ($isstyle != false && ($isstyle == 2 || $isstyle == 1 || $isstyle == 3 || $isstyle == 4 || $isstyle == 7))
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
                    elseif($isstyle == false )
                    {
                        if(isset($attr['limit']) && $attr['limit'] != '')
                        {
                            $searchParam['page_size']    = $attr['limit'];
                        }
                        else{
                            
                            $searchParam['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']: (isset($attr['isgrid']) && $attr['isgrid'] == true ? Constants:: GRIDVIEW_PAGE_SIZE : Constants::LISTING_PAGE_SIZE));

                        }
                    }
                    else{
                        $searchParam['page_size']		= (isset($_GET['page_size']) && $_GET['page_size'] != ''? $_GET['page_size']: (isset($attr['isgrid']) && $attr['isgrid'] == true ? Constants:: GRIDVIEW_PAGE_SIZE : Constants::LISTING_PAGE_SIZE));

                    }

                    $page		= (isset($_GET['spage']) && $_GET['spage'] != ''? $_GET['spage']: (isset($searchParam['spage']) ? $searchParam['spage'] : '1'));
                    $searchParam['start_record'] 	= ($page - 1) * $searchParam['page_size'];

                    /*if(!isset($attr['isgrid']) && $attr['isgrid'] != true){
                        $searchParam['Is_GeoCoded'] = true;
                    }*/
                    if(isset($searchParam['sort_by']) && $searchParam['sort_by'] != '')
                        {
                            $arrsort = explode('|', $searchParam['sort_by']);
                            $searchParam['so'] = (isset($arrsort[0]) && $arrsort[0] != ''? $arrsort[0]:Constants::DEFAULT_SO);
                            $searchParam['sd'] = (isset($arrsort[1]) && $arrsort[1] != ''? $arrsort[1]:Constants::DEFAULT_SD);
                            unset($searchParam['sort_by']);
                        }
                    /*$searchParam['so'] = (isset($_GET['so']) && $_GET['so'] != ''? $_GET['so']:'');
                    $searchParam['sd'] = (isset($_GET['sd']) && $_GET['sd'] != ''? $_GET['sd']:'');*/
                    $searchParam = array_merge($_GET, $searchParam);
	                $is_rental= false;
	                if(isset($_GET['isrental']) && ($_GET['isrental'] == 'true' || $_GET['isrental'] == true))
	                {
		                $searchParam['status'] = 'rental';
		                $is_rental= true;
	                }

                    if ((isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == 'Yes') || (!isset($arrConfig['redis_enable']) && $arrConfig['redis_enable'] == '')) {
                        $redis = new Redis();
                        $redis->connect('127.0.0.1', 6379);

                        if(isset($attr['pid']) && is_numeric($attr['pid']) && $attr['pid'] != '')
                        {
                            $cacheQuery = $redis->get($_SERVER['SERVER_NAME'].'_ps_'.$attr['pid']);
                        }

                        if($cacheQuery)
                        {
                            $arrSearchResult = unserialize($cacheQuery);
                        }
                        else
                        {
                            $arrSearchResult = $objAPI->getListingByPreSearch($searchParam);

                            if(isset($attr['pid']) && is_numeric($attr['pid']) && $attr['pid'] != '')
                            {
                                $redis->set($_SERVER['SERVER_NAME'].'_ps_' . $attr['pid'], serialize($arrSearchResult));
                                $redis->expire($_SERVER['SERVER_NAME'].'_ps_' . $attr['pid'], 600);
                            }
                        }
                    }
                    else {
                        $arrSearchResult = $objAPI->getListingByPreSearch($searchParam);
                    }

                    //$arrSearchResult = $objAPI->getListingByPreSearch($searchParam);

                    $searchParam = $arrSearchResult['searchParam'];
                    $predefine = $arrSearchResult['psearch_criteria'];
                    $arrResult = $arrSearchResult['arrRssult'];

                    if(isset($predefine['psearch_result_limit']) && $predefine['psearch_result_limit'] != '' && $arrResult['total_record'] > $predefine['psearch_result_limit'])
                    {
                        $total_record = $predefine['psearch_result_limit'];
                    }
                    elseif ($isstyle != false && ($isstyle == 2 || $isstyle == 1 || $isstyle == 3 || $isstyle == 4 || $isstyle == 7))
                    {

                        if(isset($attr['limit']) && $attr['limit'] != '')
	                    {
		                    $total_record   = $attr['limit'];
	                    }
	                    else{
		                    $total_record   = Constants:: GRIDVIEW_STYLE2_PAGE_SIZE;
	                    }
                    }
                    elseif($isstyle != false && ($isstyle == 5 || $isstyle == 6) && isset($attr['limit']) && $attr['limit'] != '')
                    {
	                    if(isset($attr['limit']) && $attr['limit'] != '')
	                    {
		                    $total_record   = $attr['limit'];
	                    }
                        /*if(isset($isstyle) && $isstyle == 5)
                        {
                            $total_record   = Constants:: GRIDVIEW_STYLE5_PAGE_SIZE;
                        }
                        else{
                            $total_record   = Constants:: GRIDVIEW_STYLE6_PAGE_SIZE;
                        }*/
                    }
                    else{
                        $total_record = $arrResult['total_record'];
                    }
                    $marketReport = get_home_url().'/'.Constants::TYPE_MARKET_REPORT_DETAIL.'/'.str_replace(' ', '-', $predefine['psearch_title']);
                    $objTmpl->assign(array(
                        'psearch_generate_mrktreport'	=>	$predefine['psearch_generate_mrktreport'],
                        'marketReportURL'	=>	$marketReport,
                        'psearch_generate_rental'	=>	$predefine['psearch_generate_rental'],
                        'is_rental'	    =>	$is_rental,
                        'rental_url'    => home_url( $wp->request ).'?isrental=true',
                        'psearch_display_tab'	=>	$predefine['psearch_display_tab'],
                    ));
                }

                if(isset($isGrid) && ($isGrid == true && $isGrid == 'true') && isset($isstyle) && $isstyle == 2){
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

                    wp_enqueue_script('style12-js', $arrVirtualPath['TemplateJs']. 'style12.js', array( 'jquery' ));
                    wp_enqueue_style('style12-css', $arrVirtualPath['TemplateCss']. 'style12.css', array(),Constants::CSS_JS_VERSION);
                }
                else{
                    wp_enqueue_script('default-style-js', $arrVirtualPath['TemplateJs']. 'default-style.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                }

                wp_enqueue_style('p-mapsearchCSS');

                wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
                wp_localize_script(	'p-common-js',
                    'objMem',
                    array('action' => 'front_ajax', 'mod' => Constants::TYPE_MEMBER_DETAIL, 'url' => admin_url('admin-ajax.php'), 'google_conv_code' => $arrConfig['OtherConfig']['google_conv_code'], 'captcha_site_key' => $arrConfig['Listing']['google_site_key']));

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


                $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
               /* if(isset($arrConfig['Site_Agent']['agent_mls']) && $arrConfig['Site_Agent']['agent_mls'] == Constants::ACTRIS)
                {
                    $arrResult['MLS_last_update_date'] = new DateTimeImmutable($arrResult['MLS_last_update_date']);
                    $MLS_date = gmdate('F d, Y', $arrResult['MLS_last_update_date']->format('U'));
                    $MLS_time = gmdate('h:ia', $arrResult['MLS_last_update_date']->format('U'));
                    $MLS_last_update_date = $MLS_date." at ".$MLS_time;

                    $sys_name = StaticArray::arr_ASName_LookUP()[$arrConfig['Site_Agent']['agent_mls']];
                }
                else
                {*/
                    $arrResult['MLS_last_update_date'] = new DateTimeImmutable($arrResult['MLS_last_update_date']);
                    $MLS_last_update_date = gmdate('M d, Y', $arrResult['MLS_last_update_date']->format('U'));

                    $sys_name = $searchParam['sys_name'];
                /*}*/

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

                    $objTmpl->assign(array(
                        'CustomCSS'    =>  $CustomCSS ? $CustomCSS : '',
                        'CustomTitle'    =>  $CustomTitle ? $CustomTitle : '',
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
                $arrCryptoData = $objAPI->getCryptoData();
                //echo '<pre>';print_r($arrCryptoData);exit();

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
                    'T_Body'		=>	'listing/listing-result.tpl',
                    'Site_Url'      =>  get_home_url().'/',
                    'URL'           =>  $current_url,
                    'arrSortingOption'	    =>	StaticArray::arrSortingOption(),
                    'arrPreQuickSorting'	=>	StaticArray::arrPreQuickSorting(),
                    'currency'      =>  '$',
                    'predefinedId'  =>  $attr['pid'],
                    'page'          =>  $page,
                    'page_size'     =>  $searchParam['page_size'],
                    'TPL_images'    =>  $arrVirtualPath['TemplateImages'],
                    'arrSearchCriteria'		=>	$searchParam,
                    'total_record'	=>	$total_record,
                    'jsonMapData'	=>	$arrResult['map-data'],
                    'attr'	=>	$attr,
                    'mapZoomLevel'  =>  $searchParam['mz'] ? $searchParam['mz'] : 13,
                    'mapCenterLat'  =>  $searchParam['clat'] ? $searchParam['clat'] : 25.761681, // Austin: 30.3074624, -98.0335911 // Dallas 32.8203525, -97.0115281
                    'mapCenterLng'  =>  $searchParam['clng'] ? $searchParam['clng'] : -80.191788,
                    'isSorting'		=>	true,
                    'memberDetail'	=>	Constants::TYPE_MEMBER_DETAIL,
                    'isGrid'	        =>	$isGrid,
                    'isHeading'         => $isHeading,
                    'issorting'        => $issorting,
                    'isFilter'        => $isFilter,
                    'issavesearch'		=>	'false',
                    'isPredefined'		=>	true,
                    'presearch_title'		=>	$predefine['psearch_title'],
                    'isAgentPre'		=>	(isset($attr['ag']) && $attr['ag'] == true ? 1 : 0),
                    'arrPriceRange'	=>	StaticArray::arrPriceRange(''),
                    'arrBedRange'	=>	StaticArray::arrBedRange(''),
                    'arrBathRange'	=>	StaticArray::arrBathRange(''),
                    'arrLotSize'	=>	StaticArray::arrLotSize(),
                    'arrSqftRange'	=>	StaticArray::arrSQFTRange(''),
                    'arrminYearBuild'	=>	StaticArray::arrYearBuild('from'),
                    'arrmaxYearBuild'	=>	StaticArray::arrYearBuild('to'),
                    'arrStatus'	    =>	StaticArray::arrStatus(),
                    'arrDayMarket'	    =>	StaticArray::arrDayMarket(),
                    'arrYesNo'	    =>	StaticArray::arrYesNo(),
                    'arrTrueFalse'	    =>	StaticArray::arrTrueFalse(),
                    'shareUrl'	    =>	$shareUrl,
                    'isstyle'	    =>	$isstyle,
                    'view_page_url'    => home_url().$arrConfig['OtherConfig']['style8_view_page_url'],
                    'arrPType'	    =>	StaticArray::arrPropertyType(),
                    'arrSType'	    =>	StaticArray::arrSubType(),
                    'is_map'        =>   $searchParam['sparam']['is_map'] ? $searchParam['sparam']['is_map'] : 'true',
                    'MLS_last_update_date'	=>	$MLS_last_update_date,
                    //'disclaimer'    => $disclaimer,
                    'tabs'          => $tabs,
                    'sys_name'              => $sys_name,
                    'login_enable'                  =>	$arrConfig['OtherConfig']['login_enable'],
                    'AgentCryptoValue'           =>	$arrConfig['Site_Agent']['crypto_active'],
                    'bitcoin'                   =>	$arrCryptoData['bitcoin'],
                    'etherium'                  =>	$arrCryptoData['etherium'],
                    'cardano'                   =>	$arrCryptoData['cardano'],
                    'ViewURL'    =>  $viewURL ? $viewURL : '',
                    'rel'    =>  $rel,
                    'isloginReq'		 =>	 (isset($arrConfig['Listing']['signup_required_for_view_property']) ? $arrConfig['Listing']['signup_required_for_view_property'] : 'No'),
                    'arrConfig'         =>  $arrConfig,
                    'maxViewedExceed'         =>  $maxViewedExceed,
                    'user_log_in'         =>	( is_user_logged_in() )?'Yes':'No',
                    'hideAddress'               =>  $arrConfig['Listing']['hide_property_address'],

                ));

                return $this->output();

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

            $con_search = $objAPI->getCondoSearchById($attr['cid']);

           /* if(is_array($con_search) && $con_search['csearch_name'] != '')
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
                   // 'rsPending'             =>  $rsPending,
                    'price_red'             =>  $price_red,
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
                'currency'  =>  '$',
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
                $condo = $objAPI->getCondoSearchById($attr['cid']);
                $searchParam    =array();
                if(isset($condo) && is_array($condo) && count($condo) > 0){

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

                    /*if ($_GET !=''){
                        $searchParam = array_merge($_GET, $searchParam);

                    }*/
                    $searchParam = array_merge(isset($_GET) ? $_GET : [], $searchParam);


                    //$param['status']    = 'active';
                    $param['add']       = $searchParam['add'];
                    $param['sdivlist']       = $searchParam['sdivlist'];
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

                    $param['status']            = array('active','rental','pending');
                    $param['sort_order_list']   = array('Beds' => 'desc', 'ListPrice' => 'desc');
                    $arrCondoStatistic          = $objAPI->getIDXListingByParam($param,true,Constants::VT_MAP);

                    $params['add']               = $searchParam['add'];
                    $params['sdivlist']       = $searchParam['sdivlist'];
                    $params['city']              = $searchParam['city'];
                    $params['zipcode']           = $searchParam['zipcode'];
                    $params['stype']             = $searchParam['stype'];
                    $params['sys_name']          = $searchParam['sys_name'];
                    $params['status']            = 'closed';
                    $params['sort_order_list']   = array('Beds' => 'desc', 'Sold_Date' => 'desc');

                    $arrRecentSales                 = $objAPI->getIDXListingByParam($params,true,Constants::VT_MAP);
                    /*echo '<pre>';print_r($arrCondoStatistic['rs']);exit();
                    echo '<pre>';print_r($arrRecentSales['rs']);exit();*/
                    $arrCondoStatisticResult['rs']  = array_merge(isset($arrCondoStatistic['rs']) ? $arrCondoStatistic['rs'] : [],$arrRecentSales['rs']);

                    if( is_user_logged_in() ){

                        global $current_user;
                        $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);
                        //$userFavCondo       = LPTUserFavoriteCondo::getInstance()->getUserFavoritesCondos($current_user->data->ID);

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  true,
                            'userFavList'       =>  explode(',',$userFavMLSNo['strIds']),
                            //'userFavCondoList'  =>  explode(',',$userFavCondo['strIds']),
                            'user_id'           =>  $current_user->data->ID,

                        ));
                    }
                    else {

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  false,
                        ));
                    }

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
        public function DevelopmentPageResult($attr)
        {
            global $arrVirtualPath,$objTmpl,$arrConfig;

            wp_enqueue_script('p-development-js', $arrVirtualPath['TemplateJs'] . 'development.js', array('jquery'), Constants::CSS_JS_VERSION, true);
            wp_enqueue_style('development-css', $arrVirtualPath['TemplateCss']. 'development.css', array(), Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_style( 'p-search-result', $arrVirtualPath['TemplateCss']. 'search-results.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_style( 'p-photo-swipe', $arrVirtualPath['TemplateCss'].'photoswipe.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_style( 'p-default-skin', $arrVirtualPath['TemplateCss']. 'default-skin.css',array(),Constants::CSS_JS_VERSION);
            wp_enqueue_script('p-photo-swipe-js', $arrVirtualPath['TemplateJs']. 'photoswipe.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_script('p-photo-swipe-ui-js', $arrVirtualPath['TemplateJs']. 'photoswipe-ui-default.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_script('p-gallery-js', $arrVirtualPath['TemplateJs']. 'gallery.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
            wp_enqueue_style('ore-color-style');
            wp_localize_script(	'p-development-js',
                'objProp',
                array('action' => 'front_ajax', 'mod' => 'development', 'url' => admin_url('admin-ajax.php'), 'google_conv_code' => $arrConfig['OtherConfig']['google_conv_code'],'captcha_site_key' => $arrConfig['Listing']['google_site_key']));


            if(isset($attr['did']) && is_numeric($attr['did']))
            {
                $shareUrl   = get_home_url().'/'.$_SERVER['REQUEST_URI'];
                $objAPI     = IDXAPI::getInstance();
                $development = $objAPI->getFullDataDevelopmentPageById($attr['did']);

                if(isset($development) && is_array($development) && count($development) > 0){

                    $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                    wp_enqueue_style( 'icon-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',array(),Constants::CSS_JS_VERSION);
                    wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',array(),Constants::CSS_JS_VERSION);
                    wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',array(),Constants::CSS_JS_VERSION);


                    if( is_user_logged_in() ){

                        global $current_user;
                        $userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($current_user->data->ID);

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  true,
                            'userFavList'       =>  explode(',',$userFavMLSNo['strIds']),
                            'user_id'           =>  $current_user->data->ID,

                        ));
                    }
                    else {

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  false,
                        ));
                    }
//echo '<pre>';print_r($development);exit;
                    $objTmpl->assign(array(
                        'T_Body'		            =>	'development/development-result.tpl',
                        'Site_Url'                  =>  get_home_url().'/',
                        'URL'                       =>  $current_url,
                        'currency'                  =>  '$',
                        'devId'                     =>  $attr['did'],
                        'TPL_images'                =>  $arrVirtualPath['TemplateImages'],
                        'shareUrl'                  =>	$shareUrl,
                        'Host_Url'                  =>  get_home_url(),
                        'arrDevelopment'            =>  $development,
                        'arrConfig'                 =>	$arrConfig,
                        'agentInfo'                 =>  $arrConfig['Agent'],
                        'OtherConfig'               =>	$arrConfig['OtherConfig'],
                        'google_api_key'            =>  'AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',
                    ));

                    return $this->output();
                }
                else{

                    $objTmpl->assign(array(
                        'T_Body'		=>	'development/development-result.tpl',
                        'total_record'	=>	0,
                    ));
                    return $this->output();
                }
            }
            else{
                return 'No results found';
            }
        }
        public function getRegisterFormPopup($attr)
        {
            global $arrConfig,$objTmpl,$arrVirtualPath,$current_user;

            wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            if (isset($attr['subline']) && $attr['subline'] != ''){
                $subline = $attr['subline'];
            }else{
                $subline = '';
            }

            if( is_user_logged_in() ){

                $objTmpl->assign(array(
                    'arrConfig'          =>  $arrConfig,
                    'isUserLoggedIn'    =>  true,
                    'user_id'           =>  $current_user->data->ID,
                ));

            }
            else
            {
                global $wp;
                $current_url = home_url( add_query_arg( array(), $wp->request ) );
                $popupURL = $current_url.'/?register&'.$subline;

                $objTmpl->assign(array(
                    'T_Body'            =>	'register_popup.tpl',
                    'arrConfig'          =>  $arrConfig,
                    'isUserLoggedIn'    =>  false,
                    'siteurl'           =>  get_home_url(),
                    'current_url'       =>  $current_url,
                    'popupURL'       =>  $popupURL,

                ));
                return $this->output();
            }
        }
    }
}
?>