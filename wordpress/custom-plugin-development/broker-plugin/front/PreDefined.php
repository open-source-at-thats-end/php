<?php

if( !class_exists('PreDefined'))
{
    class PreDefined implements FrontModule
    {
        private static $instance;
        private $title= '';
        public $browser_title, $meta_keyword, $meta_desc;

        public function __construct(){

        }

        public static function getInstance(){
            if( !isset(self::$instance)){
                self::$instance = new PreDefined();
            }
            return self::$instance;
        }
        public function requestHandler($isAjaxRequest = false, $moduleKey)
        {   global $objAjaxResp;


        }
        public function getTitle(){
            $this->title = ucwords(str_replace('-',' ',get_query_var('title')));
            return $this->title;
        }

        public function getPageTemplate(){
            global $arrOREConfig;
            add_filter('template_include', function($default_template) {

                global $arrPhysicalPath;

                $templatefilename = 'detail_template.php';
                $template = $arrPhysicalPath['Base'] . $templatefilename;
                $default_template = $template;

                // Load new template also fallback if both condition fails load default
                return $default_template;

            }, 9999);

            //return $pageTemplate;
        }

        public function getContent($POST=''){
            global $objTmpl, $arrPhysicalPath, $arrVirtualPath, $arrConfig, $userinfo;

            $objAPI     = IDXAPI::getInstance();

            $Action = get_query_var('action');
            $title = str_replace('-',' ',get_query_var('title'));
            $pre_search = $objAPI->getPreDefineSearchByTitle($title);
            $con_search = CondoSearch::getInstance()->getCondoSearchByName($title);

            $page_content = get_page_by_path( $title );
            if(is_object($page_content) && !is_array($pre_search) && !is_array($con_search))
            {
                $arr = explode('][', $page_content->post_content);

                //if (in_array("condo-search-result", array_flip($arr),false))  //krishna patel
                if ( array_map('checkMappingInArray',$arr))
                {
                    $shrtCode = implode(preg_grep('/^condo-search-result.*/', $arr));
                    $shrtCodeArr = explode('=',$shrtCode);

                    if(is_array($shrtCodeArr) && $shrtCodeArr[1] > 0){
                        $con_search = CondoSearch::getInstance()->getCondoSearchById($shrtCodeArr[1]);
                    }
                }
            }

            if(isset($Action) && $Action == Constants::TYPE_MARKET_REPORT_DETAIL)
            {
                if(is_array($con_search) && $con_search['csearch_name'] != '')
                {
                    $statistic = $objAPI->getCondoStatistic($con_search['csearch_id']);
                }
                else
                {
                    $statistic = $objAPI->getPreDefineStatistic($pre_search['psearch_id']);
                }

                if(is_array($con_search) && $con_search['csearch_criteria'] != '')
                    $criteria = unserialize($con_search['csearch_criteria']);
                else
                    $criteria = unserialize($pre_search['psearch_criteria']);

                $count = $objAPI->getCountbyParam($criteria);

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

                $recent_sales = $objAPI->getIDXListingByParam($criteria);
                //echo "<pre>";print_r($recent_sales);die;

                if(is_array($con_search) && $con_search['csearch_criteria'] != '')
                    $rcriteria = unserialize($con_search['csearch_criteria']);
                else
                    $rcriteria = unserialize($pre_search['psearch_criteria']);

                $rcriteria['status'] = 'active';
                $rcriteria['so'] = 'pricedef';
                $rcriteria['sd'] = 'asc';
                //$rcriteria['sort_by'] = 'pricedef|asc';
                $rcriteria['page_size'] = 15;
                $rcriteria['pricereduce'] = true;
                $rcriteria['maxpricedef'] = '-60';

                $price_red = $objAPI->getIDXListingByParam($rcriteria,true,Constants::VT_LIST);

                unset($rcriteria['maxpricedef'], $rcriteria['pricereduce']);
                $rcriteria['status'] = 'pending';
                $rcriteria['so'] = 'price';
                $rcriteria['sd'] = 'desc';
                $rsPending = $objAPI->getIDXListingByParam($rcriteria,true,Constants::VT_LIST);
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


                $city = (isset($criteria['city'] )?(is_array($criteria['city']) ?implode(', ', $criteria['city']):$criteria['city']):'');

                $desc = 'As of '.date('F j, Y'). ' there are approximately '.$count.' '.trim($subtype, ', ').' for '.(isset($criteria['status']) && $criteria['status'] == 'rental'? 'rent':'sale').' in '.$city.', Florida with a median listing price of $'.number_format($statistic['statistic_median_active_price']).' or $'.number_format($statistic['statistic_median_active_price_sqft']).' per square foot. In the last 180 days, approximately '.number_format($statistic['statistic_sixmon_tot_sold_listing']).' '.trim($subtype, ', ').' sold in '.
                    $city.', FL with a median closing price of $'.number_format($statistic['statistic_median_sold_price']).' or $'.number_format($statistic['statistic_median_sold_price_sqft']).' per square foot.';
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

                if(is_array($con_search) && $con_search['csearch_id'] > 0)
                    $Title = $con_search['csearch_name'];
                else
                    $Title = $this->getTitle();

                $objTmpl->assign(array(
                        'pre-search'            =>  $pre_search,
                        'statistic'             =>  $statistic,
                        'title'                 =>  $Title,
                        'currency'              =>  '$',
                        'recent_sales'          =>  $recent_sales['rs'],
                        'rsPending'             =>  $rsPending,
                        'price_red'             =>  $price_red,
                        'arrConfig'             =>  $arrConfig,
                        'TodayDate'             =>  date('m-d-Y'),
                        'SEODescription'        =>  $desc,
                        //'sys_name'              =>  $criteria['sys_name'],
                        'Templates_Image'	    =>	$arrVirtualPath['TemplateImages'],
                        'MLS_last_update_date'	=>	$MLS_last_update_date,//gmdate('M d, Y', $price_red['MLS_last_update_date']->format('U')),
                    )



                );
                $content = $objTmpl->fetch('market_report.tpl');

                return $content;
            }
	        else if(isset($Action) && $Action == Constants::TYPE_SALES || isset($Action) && $Action == Constants::TYPE_RENTALS || isset($Action) && $Action == Constants::TYPE_SOLD)
	        {
            	
		        $isHeading = true;
				
		        $shareUrl = get_home_url().'/'.$_SERVER['REQUEST_URI'];
		        $searchParam = unserialize($pre_search['psearch_criteria']);
		        $searchParam['getMapData'] = true;
				
		        $page		= (isset($_GET['spage']) && $_GET['spage'] != ''? $_GET['spage']: (isset($searchParam['spage']) ? $searchParam['spage'] : '1'));


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
		        if(isset($Action) && $Action == Constants::TYPE_RENTALS)
		        {
			        $searchParam['status'] = 'rental';
			        $is_rental= true;
		        }
		        elseif(isset($Action) && $Action == Constants::TYPE_SOLD)
		        {
			        $searchParam['status'] = 'closed';
		        }
				
		        $arrResult = $objAPI->getIDXListingByParam($searchParam,true,Constants::VT_MAP);
				
               	// echo "<pre>"; print_r($arrResult);die;
                
		        $arr = array();
		        $recent_reduce = array();
		        $new_prop= array();
		        foreach($arrResult['rs'] as $result)
		        {
			        $dateOne = new DateTime();
			        $dateTwo = new DateTime($result['PriceChangeDate']);
			        $dateThree = new DateTime($result['ListingDate']);
			        $result['DayOnMarket'] = $dateThree->diff($dateOne)->format("%a");
			        if( $dateTwo->diff($dateOne)->format("%a") < 160)
			        {
				        $recent_reduce[] = $result;
			        }
			        if( $dateThree->diff($dateOne)->format("%a") < 7)
			        {

				        $new_prop[] = $result;
			        }

		        	$arr[$result['Beds']][] = $result;
		        }
				ksort($arr);
                
		        $objTmpl->assign(array(
			                         'pre_search' => $pre_search,
			                         'recent_reduce'    => $recent_reduce,
			                         'new_prop'    => $new_prop,
			                         'title'      => $this->getTitle(),
			                         'currency'   =>  '$',
			                         'arrRecord'  => $arr,
			                         'arrConfig'  =>  $arrConfig,
			                         'TodayDate'  =>  date('m-d-Y'),
			                         'total_record'  =>  $arrResult['total_record'],
			                          'Action'      => $Action,
			                          'shareUrl'      => $shareUrl,
		                         )



		        );
		        if( is_user_logged_in() ){

			        global $current_user;

			        $objTmpl->assign(array(
				                         'isUserLoggedIn'    =>  true,

				                         'user_id'    =>  $current_user->data->ID,

			                         ));
		        }
		        else {

			        $objTmpl->assign(array(
				                         'isUserLoggedIn'    =>  false,
			                         ));
		        }
		        $content = $objTmpl->fetch('sales.tpl');

		        return $content;
	        }
            else{
                exit();
            }
        }


    }
    function checkMappingInArray($v)
    {
        if (strpos($v, 'condo-search-result') !== false)
        {
            return true;
        }
        return false;
    }
}
?>