<?php

if( !class_exists('PreDefined'))
{
    class PreDefined implements FrontModule
    {
        private static $instance;
        private $title= '';
        public $browser_title, $meta_keyword, $meta_desc;

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
            global $objTmpl, $arrConfig, $arrVirtualPath;

            $objAPI     = IDXAPI::getInstance();

            $Action = get_query_var('action');
            $title = str_replace('-',' ',get_query_var('title'));
            $pre_search = $objAPI->getPreDefineSearchByTitle($title);
            $con_search = $objAPI->getCondoSearchByName($title);

            $page_content = get_page_by_path( $title );
            if(is_object($page_content) && !is_array($pre_search) && !is_array($con_search))
            {
                $arr = explode('][', $page_content->post_content);

                if (in_array("condo-search-result", array_flip($arr)))
                {
                    $shrtCode = implode(preg_grep('/^condo-search-result.*/', $arr));
                    $shrtCodeArr = explode('=',$shrtCode);

                    if(is_array($shrtCodeArr) && $shrtCodeArr[1] > 0){
                        $con_search = $objAPI->getCondoSearchById($shrtCodeArr[1]);
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
                    if(in_array('active', $criteria['status']) && !in_array('rental', $criteria['status']))
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
                $criteria['so'] = 'sold';
                $criteria['sd'] = 'desc';
                $criteria['page_size'] = 30;
                $criteria['last_sold'] = $before_six_month;

                $recent_sales = $objAPI->getIDXListingByParam($criteria);
                $rcriteria = unserialize($pre_search['psearch_criteria']);
                $rcriteria['status'] = 'active';
                $rcriteria['so'] = 'pricedef';
                $rcriteria['sd'] = 'asc';
                $rcriteria['page_size'] = 30;
                $rcriteria['pricereduce'] = true;
                $rcriteria['maxpricedef'] = '-60';

                $price_red = $objAPI->getIDXListingByParam($rcriteria);

                unset($rcriteria['maxpricedef'], $rcriteria['pricereduce']);
                $rcriteria['status'] = 'pending';
                $rcriteria['so'] = 'price';
                $rcriteria['sd'] = 'desc';
                $rsPending = $objAPI->getIDXListingByParam($rcriteria);
               // echo '<pre>';print_r($rsPending);exit();

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
                }else{
                    $subtype = '';
                }

                $desc = 'As of '.date('F j, Y'). ' there are approximately '.$count.' '.trim($subtype, ', ').' for '.(isset($criteria['status']) && $criteria['status'] == 'rental'? 'rent':'sale').' in '.(isset($criteria['city'])? implode(', ', $criteria['city']):'').', Florida with a median listing price of $'.number_format($statistic['statistic_median_active_price']).' or $'.number_format($statistic['statistic_median_active_price_sqft']).' per square foot. In the last 180 days, approximately '.number_format($statistic['statistic_sixmon_tot_sold_listing']).' '.trim($subtype, ', ').' sold in '.
                    (isset($criteria['city'])? implode(', ', $criteria['city']):'').', FL with a median closing price of $'.number_format($statistic['statistic_median_sold_price']).' or $'.number_format($statistic['statistic_median_sold_price_sqft']).' per square foot.';

                $this->meta_desc = $desc;
                //$rsPending['MLS_last_update_date'] = new DateTimeImmutable($rsPending['MLS_last_update_date']);
                /*if(isset($arrConfig['Site_Agent']['agent_mls']) && $arrConfig['Site_Agent']['agent_mls'] == Constants::ACTRIS)
                {
                    $rsPending['MLS_last_update_date'] = new DateTimeImmutable($rsPending['MLS_last_update_date']);
                    $MLS_date = gmdate('F d, Y', $rsPending['MLS_last_update_date']->format('U'));
                    $MLS_time = gmdate('h:ia', $rsPending['MLS_last_update_date']->format('U'));
                    $MLS_last_update_date = $MLS_date." at ".$MLS_time;
                }
                else
                {*/
                    $rsPending['MLS_last_update_date'] = new DateTimeImmutable($rsPending['MLS_last_update_date']);
                    $MLS_last_update_date = gmdate('M d, Y', $rsPending['MLS_last_update_date']->format('U'));
               /* }*/

                if(is_array($con_search) && $con_search['csearch_id'] > 0)
                    $Title = $con_search['csearch_name'];
                else
                    $Title = $this->getTitle();

                $objTmpl->assign(array(
                        'pre-search'            => $pre_search,
                        'statistic'             => $statistic,
                        'title'                 => $Title,
                        'currency'              =>  '$',
                        'recent_sales'          => $recent_sales['rs'],
                        'rsPending'             => $rsPending,
                        'price_red'             => $price_red,
                        'arrConfig'             => $arrConfig,
                        'TodayDate'             => date('m-d-Y'),
                        'SEODescription'        => $desc,
                        'MLS_last_update_date'  => $MLS_last_update_date,//gmdate('M d, Y', $rsPending['MLS_last_update_date'] ->format('U')),
                        //'sys_name'              => $criteria['sys_name'],
                        'Templates_Image'	    => $arrVirtualPath['TemplateImages'],
                    )



                );
                $content = $objTmpl->fetch('market_report.tpl');

                return $content;
            }
            else if(isset($Action) && $Action == Constants::TYPE_SALES || isset($Action) && $Action == Constants::TYPE_RENTALS || isset($Action) && $Action == Constants::TYPE_SOLD)
            {
            	$shareUrl = get_home_url().'/'.$_SERVER['REQUEST_URI'];
	            $searchParam = unserialize($pre_search['psearch_criteria']);
	            $searchParam['getMapData'] = true;

	            if(isset($searchParam['sort_by']) && $searchParam['sort_by'] != '')
	            {
		            $arrsort = explode('|', $searchParam['sort_by']);
		            $searchParam['so'] = (isset($arrsort[0]) && $arrsort[0] != ''? $arrsort[0]:Constants::DEFAULT_SO);
		            $searchParam['sd'] = (isset($arrsort[1]) && $arrsort[1] != ''? $arrsort[1]:Constants::DEFAULT_SD);
		            unset($searchParam['sort_by']);
	            }

	            $searchParam = array_merge($_GET, $searchParam);

	            if(isset($Action) && $Action == Constants::TYPE_RENTALS)
	            {
		            $searchParam['status'] = 'rental';

	            }
	            elseif(isset($Action) && $Action == Constants::TYPE_SOLD)
	            {
		            $searchParam['status'] = 'closed';
	            }

	            $arrResult = $objAPI->getIDXListingByParam($searchParam,true,VT_MAP);

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

        }

    }
}
?>