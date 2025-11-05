<?php
class UserMaster extends AdminModule
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

		//$this->baseUrl = admin_url('admin.php?page=' . Constants::SLUG . '-' . $this->__moduleKey);

		switch ($this->_action) {
			case 'add':
				$this->add();
				break;
            case 'edit':
                $this->add();
                break;
            case 'delete':
                $this->delete();
                break;
            case 'export':
                $this->export();
                break;
            case 'view':
                $this->view();
                break;
            case 'view_listing':
                $this->view_listing();
                break;
            case 'emails_sent':
                $this->emails_sent();
                break;
            case 'view_email_template':
                $this->view_email_template();
                break;
            case 'user_profile':
                $this->user_profile();
                break;
            case 'send_lead_info':
                $this->send_lead_info();
                break;
            case 'send_email':
                $this->send_email();
                break;
            case 'save_search' :
                $this->save_search();
                break;
            case 'edit_save_search' :
                $this->save_search();
                break;
            case 'email_listing_save_search' :
                $this->email_listing_save_search();
                break;
            case 'save_search_listing' :
                $this->save_search_listing();
                break;
            case 'delete_save_search' :
                $this->delete_save_search();
                break;
            case 'saved-listing':
                $this->save_search();
                break;
			default:
				$this->manage();
				break;
		}
	}
	public function add()
	{
		global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

		if($this->_action == 'add' && isset($_POST['submit']) && $_POST['submit'] == 'Add')
		{
			$_POST['lead_subs'] = implode(',',$_POST['lead_subs']);
			$_POST['lead_created_date'] = date('Y-m-d H:i:s');
			$_POST['lead_created_by'] = 'Admin';
			LPTLeadMaster::getInstance()->Insert($_POST);

			header("location: $this->baseUrl&save=true");
			exit(0);

		}
        elseif($this->_action == 'edit' && isset($_POST['submit']) && $_POST['submit'] == 'Update')
        {
            unset($_POST['Submit']);
            unset($_POST['Action']);
            if(isset($_POST['lead_subs']) && $_POST['lead_subs'] != ''){
                $_POST['lead_subs'] =implode(',',$_POST['lead_subs']);
            }
            else{
                $_POST['lead_subs'] = array();
            }


            $_POST['lead_created_date'] = date('Y-m-d H:i:s');

            LPTLeadMaster::getInstance()->Update($_POST['pk'], $_POST);

            header("location: $this->baseUrl&update=true");
            exit(0);

        }

        wp_enqueue_script('contacts-js', $arrVirtualPath['TemplateJs']. 'contacts.js', array( 'jquery' ), false, true);

		if($this->_action == 'add' || $this->_action == 'edit')
        {
            $objTmpl->assign(array(
                'arrYesNo'          => StaticArray::arrYesNo(),
                'arrTimeFrame'      => StaticArray::arrTimeFrame(),
                'arrLeadType'       => StaticArray::arrLeadType(),
                'arrSource'         => StaticArray::arrSource(),
                'arrSubscription'   => StaticArray::arrSubscription(),
            ));
        }
		if($this->_action == 'edit')
        {
            $record = LPTLeadMaster::getInstance()->getInfoById($_GET['pk']);

            $objTmpl->assign(array(
                'record'            => $record,
                'action'            => $_GET['action'],
            ));
        }

        $objTmpl->assign(array(
            'scriptname'     => $this->baseUrl,
        ));

        $content = $objTmpl->fetch('user_add.tpl');

        echo $content;die;
	}
    public function delete(){

        $delete = LPTLeadMaster::getInstance()->DeleteUser($_GET['pk'],$_GET['ref_id']);

        if($delete){
            header("location: $this->baseUrl&delete=true");
        }else{
            header("location: $this->baseUrl&error=true");
        }

        exit(0);
    }
	public function manage()
	{
		global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

        wp_enqueue_script('contacts-js', $arrVirtualPath['TemplateJs']. 'contacts.js', array( 'jquery' ), false, true);

        if($_GET['save'] == true)
            $msgSuccess = "Contact has been added successfully.";
        elseif($_GET['update']==true)
            $msgSuccess = "Contact has been updated successfully.";
        elseif($_GET['delete']==true)
            $msgSuccess = "Contact has been deleted successfully.";



		/*$objAPI = IDXAPI::getInstance();
		$arrParams['page_size'] = Constants::PAGE_SIZE;
		$arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

		$rsUser = $objAPI->getUser($arrParams);*/
		if(isset($_GET['page_size']) && count($_GET['page_size']) > 0)
		{
			$arrParams['page_size'] = $_GET['page_size'];
		}
		else{
			$arrParams['page_size'] = Constants::PAGE_SIZE;
		}


		$arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

		if (isset($_GET['page']) && $_GET['page'] == 'lpt-hot-leads')
            $arrParams['type'] = 'Hot Lead';

        if(isset($_GET['page']) && $_GET['page'] == 'lpt-opportunity')
            $arrParams['type'] = 'Opportunity';

        $arrParams = array_merge($_GET,$arrParams);

		//$rsUser = LPTLeadMaster::getInstance()->getAllUser($arrParams);
		//echo "<pre>";print_r($rsUser['rsData']->fetch_array());die;
		/*$page_current = isset($_GET['cpage'])?$_GET['cpage']:0;
		$startRecord = ((intval($page_current) ? intval($page_current) : 1 )-1) * Constants::PAGE_SIZE;*/
		//$startRecord = ($page_current == 0 ? Constants::PAGE_SIZE : ($page_current * Constants::PAGE_SIZE));

		/*$user_query = new WP_User_Query( array(
			'role'   => 'subscriber',
			'number' => Constants::PAGE_SIZE,
			'offset' => $startRecord,
			'orderby' => 'user_registered',
			'order'   => 'DESC'
		));
		//
		$rsUser = array();
		$userMeta = array();
		foreach ( $user_query->results as $user ) {

			$rsUser[] = $user->data;
			$meta = get_user_meta($user->data->ID);

			$userMeta[$user->data->ID] = array(
				"user_phone" => (isset($meta['user_phone'][0]) ? $meta['user_phone'][0] : ''),
				"user_type"  => (isset($meta['user_type'][0]) ? $meta['user_type'][0] : ''),
			);
		}*/
		//echo "<pre>";print_r($rsUser);die;
		/*$arrUser = $rsUser['rsData']->fetch_array();

		$objTmpl->assign(array('T_Body'         => 'user.tpl',
		                       'scriptname'     => $this->baseUrl,
		                       'rsUser'	        => $arrUser,
		                       //'userMeta'	    =>	$userMeta,
		                       'total_record'	=> $rsUser['totalRecord'],
		                       'totalFetched'   => $rsUser['totalFetched'],
		                       //'page_size'	    =>	Constants::PAGE_SIZE,
		                       'page_size'	    => 1,
		                       'startRecord'    => $rsUser['startRecord'],
                               'page'           => $_GET['page'],
                               'arrParams'      => $arrParams,
                               'msgSuccess'     => $msgSuccess,
                               'arrYesNo'       => StaticArray::arrYesNo(),
                               'arrTimeFrame'   => StaticArray::arrTimeFrame(),
                               'arrLeadType'    => StaticArray::arrLeadType(),
                               'arrSource'      => StaticArray::arrSource(),
                               'arrSubscription'=> StaticArray::arrSubscription(),
		                 ));*/


             $rsUser = LPTLeadMaster::getInstance()->getUsers($arrParams);

             $arrUser = $rsUser['rsData']->fetch_array();
            //echo '<pre>';print_r($arrUser);exit();

        $objTmpl->assign(array('T_Body'         => 'user_main.tpl',
		                       'scriptname'     => $this->baseUrl,
		                       'rsUser'	        => $arrUser,
		                       //'userMeta'	    =>	$userMeta,
		                       'total_record'	=> $rsUser['totalRecord'],
		                       'totalFetched'   => $rsUser['totalFetched'],
		                       //'page_size'	    =>	Constants::PAGE_SIZE,
		                       'page_size'	    => $arrParams['page_size'],
		                       'arrPageSize'    => StaticArray::arrPageSize(),
		                       'startRecord'    => $rsUser['startRecord'],
                               'page'           => $_GET['page'],
                               'arrParams'      => $arrParams,
                               'msgSuccess'     => $msgSuccess,
                               'arrYesNo'       => StaticArray::arrYesNo(),
                               'arrTimeFrame'   => StaticArray::arrTimeFrame(),
                               'arrLeadType'    => StaticArray::arrLeadType(),
                               'arrSource'      => StaticArray::arrSource(),
                               'arrSubscription'=> StaticArray::arrSubscription(),
		                 ));
	}
    public function export()
    {
        global $objTmpl;

        $arrUserMaster	= array('Date Added','First Name Last Name','Website Visit','Email Open','System Activity', 'Top Data', 'Emails', 'Properties');
        /*$arrParams['page_size'] = 1;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

        $arrParams = array_merge($_GET,$arrParams);*/
        if (isset($_GET['page']) && $_GET['page'] == 'lpt-hot-leads')
            $arrParams['type'] = 'Hot Lead';

        if(isset($_GET['page']) && $_GET['page'] == 'lpt-opportunity')
            $arrParams['type'] = 'Opportunity';
        
        $arrParams['allRecord'] = true;
        $rsUser = LPTLeadMaster::getInstance()->getUsers($arrParams);

        $arrUser = array();
        while ($rsUser['rsData']->next_record()){

            $user = $rsUser['rsData']->Record;
            $meta = get_user_meta($user['lead_user_id']);

            # Date Added
            $date1 = date_create();
            $date2 = date_create($user['lead_created_date']);
            $diff = date_diff($date1,$date2);
            if ($diff->format("%a") == 0)
            {
                $date_added = 'Today';
            }
            else if ($diff->format("%a") < 10)
            {
                $date_added = $diff->format("%a days");
            }
            else
            {
                $date_added = date_format($user['lead_created_date'], "%Y-%m-%d");
            }

            # Website Visit
            if ($user['log_datetime'] != '') {
                $date_time = date_create($user['log_datetime']);
                $date_time_lead = $user['log_datetime'];
            }
            else {
                $date_time = date_create($user['lead_created_date']);
                $date_time_lead = $user['lead_created_date'];
            }
            
            if (date_format($date_time, 'Y-m-d') == date_format($date1, 'Y-m-d'))
                $website_visit = 'Today '.date("h:i a",strtotime($date_time_lead));
            else
                $website_visit = $date_time->format('Y-m-d')." ".date("h:i a",strtotime($date_time_lead));

            # System Activity
            if ($user['system_datetime'] != '') {
                $date_time = date_create($user['system_datetime']);

                if (date_format($date_time, 'Y-m-d') == date_format($date1, 'Y-m-d'))
                    $system_activity = 'Today '.date("h:i a",strtotime($user['log_datetime']));
                else
                    $system_activity = $date_time->format('Y-m-d')." ".date("h:i a",strtotime($user['system_datetime']));
            }
            else
            {
                $system_activity = '-';
            }

            # Top Data
            if ($user['statstic_price'] != '') {
                $top_data = '$'.number_format($user['statstic_price']).' - ';
                if ($user['statstic_ptype'] !='')
                {
                    $top_data .= $user['statstic_ptype'].' '.$user['statstic_ptype_per'].'% ';
                }
            }

            if ($user['statstic_city_name'] !='')
            {
                $top_data .= $user['statstic_city_name'].' '.$user['stastic_city_per'].'%';
            }

            $arrUser[] = array(
                "user_id" => $user['lead_user_id'],
                "date_added" => $date_added,
                "user_first_name" => (isset($meta['user_first_name'][0]) ? $meta['user_first_name'][0] : $user['lead_first_name']),
                "user_last_name" => (isset($meta['user_last_name'][0]) ? $meta['user_last_name'][0] : $user['lead_last_name']),
                "website_visit" => $website_visit,
                "email_open" => '0/0',
                "system_activity" => $system_activity,
                "top_data" => $top_data,
                "emails" => '0/0',
                "properties" => $user['viewed_property'].'/'.$user['total_favorites'],
            );
        }

        $objTmpl->assign(array('F_HeaderItem'              => $arrUserMaster,
            'scriptname'    => $this->baseUrl,
            'rsUser'	    =>	$arrUser,
            'total_record'	=>	$rsUser['totalRecord'],
            'totalFetched'  =>  $rsUser['totalFetched'],
            'page_size'	    =>	Constants::PAGE_SIZE,
            'startRecord'  =>  $rsUser['startRecord'],

        ));

//		header("Content-Type: application/vnd.ms-excel");
        header('Content-Type: text/csv charset=utf-8');
        header('Content-Disposition: attachment; filename=Contact_'. date('dmY'). '.csv');
        $output = fopen("php://output", "w");

        fputcsv($output, array('Date Added','First Name Last Name','Website Visit','Email Open','System Activity', 'Top Data', 'Emails', 'Properties'));


        foreach ($arrUser as $key => $val){
            $leadcsv = array(
                'Date Added' => $val['date_added'],
                'Name' => $val['user_first_name']. ' ' . $val['user_last_name'],
                'Website Visit' => $val['website_visit'],
                'Email Open' => $val['email_open'],
                'System Activity' => $val['system_activity'],
                'Top Data' => $val['top_data'],
                'Emails' => $val['emails'],
                'Properties' => $val['properties'],
            );
            fputcsv($output, $leadcsv);
        }
        fclose($output);

        exit;

    }
    public function view()
    {
        global $objTmpl, $arrVirtualPath;

        wp_enqueue_style( 'listing-view', $arrVirtualPath['TemplateCss']. 'listing-view.css',array(),Constants::CSS_JS_VERSION);

        wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'listing-view.js', array( 'jquery' ));

        if(isset($_GET['page_size']) && count($_GET['page_size']) > 0)
        {
            $arrParams['page_size'] = $_GET['page_size'];
        }
        else
        {
            $arrParams['page_size'] = Constants::PAGE_SIZE;
        }
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

        $arrParams = array_merge($_GET,$arrParams);
        $arrUserlistings = LPTLeadMaster::getInstance()->getUsersViewedListings($arrParams);
        $arrUser = $arrUserlistings['rsData']->fetch_array();

        /* Pulling log data by reference id */
        $log_data =  LPTUserActionLog::getInstance()->getRecordByRefId($_GET['refId']);

        $stats = array();
        $stats['ref_id'] = $_GET['refId'];

        /* City Calculation */
        $city               = array_column($log_data, 'log_city');
        $frequancy_city     = array_count_values($city);
        $percenatage        = 100/count($city);
        $stats['max_city']  = implode(',',array_keys($frequancy_city, max($frequancy_city)));
        foreach ($frequancy_city as $key=>$val)
        {
            $stats['city'][$key] = floor( $val * $percenatage);
        }

        /* ZipCode Calculation */
        $zip                = array_column($log_data, 'log_zip');
        $frequancy_zip      = array_count_values($zip);
        $percenatage        = 100/count($zip);
        $stats['max_zip']   = implode(',',array_keys($frequancy_zip, max($frequancy_zip)));
        foreach ($frequancy_zip as $key=>$val)
        {
            $stats['zip'][$key] = floor( $val * $percenatage);
        }

        /* Bedroom Calculation */
        $bed                = array_column($log_data, 'log_bed');
        $frequancy_bed      = array_count_values($bed);
        $percenatage        = 100/count($bed);
        $stats['max_bed']   = implode(',',array_keys($frequancy_bed, max($frequancy_bed)));
        foreach ($frequancy_bed as $key=>$val)
        {
            $stats['bed'][$key] = floor( $val * $percenatage);
        }

        /* Community Calculation */
        $community              = array_column($log_data, 'log_community');
        $frequancy_community    = array_count_values($community);
        $percenatage            = 100/count($community);
        $stats['max_community'] = implode(',',array_keys($frequancy_community, max($frequancy_community)));
        foreach ($frequancy_community as $key=>$val)
        {
            $stats['community'][$key] = floor( $val * $percenatage);
        }

        /* AveragePrice Calculation */
        $price = array_column($log_data, 'log_price');
        $stats['avg_price'] = floor(array_sum($price) / count($price));

        $objTmpl->assign(array('T_Body'         => 'user_listings.tpl',
                                'scriptname'    => $this->baseUrl,
                                'rsUser'        => $arrUser,
                                'total_record'	=> $arrUserlistings['totalRecord'],
                                'totalFetched'  => $arrUserlistings['totalFetched'],
                                'page_size'	    => $arrParams['page_size'],
                                'arrPageSize'   => StaticArray::arrPageSize(),
                                'startRecord'   => $arrUserlistings['startRecord'],
                                'page'          => $_GET['page'],
                                'arrParams'     => $arrParams,
                                'stats'         => $stats,
                            ));
    }
    public function view_listing()
    {
        global $objTmpl, $arrVirtualPath, $arrConfig;

        wp_enqueue_style('ore-style-popup');

        wp_enqueue_style( 'jquery-flexslider', $arrVirtualPath['Libs']. 'jQuery/woothemes-FlexSlider/flexslider.css');
        wp_enqueue_style( 'listing-view', $arrVirtualPath['TemplateCss']. 'listing-view.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_script( 'jquery-flexslider', $arrVirtualPath['Libs']. 'jQuery/woothemes-FlexSlider/jquery.flexslider-min.js', array('jquery'));

        wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'listing-view.js', array( 'jquery' ));

        $objAPI                     = IDXAPI::getInstance();
        $arrParams                  = array();
        $arrParams['ListingID_MLS'] = $_GET['mls_id'];
        $recProperty                = $objAPI->getListingByMLSNum($arrParams);

        $objTmpl->assign(array('T_Body'             => 'user_listing_detail.tpl',
                                'Record'            => $recProperty,
                                'arrListingConfig'  => $arrConfig['Listing'],
        ));
    }
    public function emails_sent()
    {
        global $objTmpl, $arrVirtualPath;

        wp_enqueue_script('js-manage-common', $arrVirtualPath['TemplateJs']. 'listing-view.js', array( 'jquery' ));

        if(isset($_GET['page_size']) && count($_GET['page_size']) > 0)
        {
            $arrParams['page_size'] = $_GET['page_size'];
        }
        else{
            $arrParams['page_size'] = Constants::PAGE_SIZE;
        }

        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;
        $arrParams = array_merge($_GET,$arrParams);

        $rsUserSentEmails   = LPTLeadMaster::getInstance()->getUserSentEmail($arrParams);
        $arrUser            = $rsUserSentEmails['rsData']->fetch_array();
        //echo '<pre>';print_r($arrUser);exit();

        $objTmpl->assign(array('T_Body'         => 'user_sent_emails_list.tpl',
                                'rsUser'        => $arrUser,
                                'scriptname'    => $this->baseUrl."&action=".$_GET['action']."&userId=".$_GET['userId'],
                                'total_record'	=> $rsUserSentEmails['totalRecord'],
                                'totalFetched'  => $rsUserSentEmails['totalFetched'],
                                'page_size'	    => $arrParams['page_size'],
                                'arrPageSize'   => StaticArray::arrPageSize(),
                                'startRecord'   => $rsUserSentEmails['startRecord'],
                                'page'          => $_GET['page'],
                                'action'        => $_GET['action'],
                                'userId'        => $_GET['userId'],
                                'arrParams'     => $arrParams,
                                'MainUrl'      => get_home_url().$_SERVER['SCRIPT_NAME'].'?page='.$_GET['page'],
        ));
    }
    public function view_email_template()
    {
        global $objTmpl;

        $record = LPTLeadEmail::getInstance()->getInfoById($_GET['emailId']);

        $objTmpl->assign(array(
            'template'   => $record['ldemail_content'],
        ));

        $content = $objTmpl->fetch('user_email_template.tpl');

        echo $content;die;
    }

    public function user_profile()
    {
       //echo '<pre>';print_r($_POST);exit();

        $record = LPTLeadEmail::getInstance()->getInfoById($_GET['emailId']);

        global $objTmpl;
        if(isset($_GET['user_id'])){
            $id = $_GET['user_id'];
            $userProfile    = LPTLeadMaster::getInstance()->getUserById($id);
        }
        elseif (isset($_GET['user_ref_id'])){
            $id = $_GET['user_ref_id'];
            $userProfile    = LPTLeadMaster::getInstance()->getUserByRefId($id);
        }
        //echo '<pre>';print_r($userProfile);exit();


        $log_data       = LPTUserActionLog::getInstance()->getRecordByRefId($id);
        $insights       = LPTLeadMaster::getInstance()->getUserInsightsByRefId($id);

        //echo "<pre>";print_r($log_data);die;
      //  echo "<pre>";print_r($id);die;

        /* ZipCode Calculation */
        $zip = array_column($log_data, 'log_zip');

        if (empty($zip)){
            $stats['zip_max'] = 0;
            $stats['zip_per'] = 0;
        }
        else{

            $frequancy_zip = array_count_values($zip);
            $percenatage = 100/count($zip);
            $max = max($frequancy_zip);

            $stats['zip_max'] = array_keys($frequancy_zip,$max)[0];
            $stats['zip_per'] = floor( $max * $percenatage);
        }


        /* Property Type Calculation */
        $ptype = array_column($log_data, 'log_ptype');

       if(empty($ptype)){
           $stats['ptype_max'] = 0;
           $stats['ptype_per'] = 0;
       }
       else{
           $frequancy_ptype = array_count_values($ptype);
           $percenatage = 100/count($ptype);
           $max = max($frequancy_ptype);

           $stats['ptype_max'] = array_keys($frequancy_ptype,$max)[0];
           $stats['ptype_per'] = floor( $max * $percenatage);
       }


        /* City Calculation */
        $city = array_column($log_data, 'log_city');

        if(empty($city)){
            $stats['city_max'] = 0;
            $stats['city_per'] = 0;
        }else{
            $frequancy_city = array_count_values($city);
            $percenatage = 100/count($city);
            $max = max($frequancy_city);

            $stats['city_max'] = array_keys($frequancy_city,$max)[0];
            $stats['city_per'] = floor( $max * $percenatage);
        }


        /* Price Calculation */
        $price = array_column($log_data, 'log_price');
        $totNo = count($price);
        if($totNo > 0)
        {
            if (is_float($totNo/2))
            {
                $stats['price'] = round($price[(($totNo + 1)/2)-1]);
            }
            else
            {
                $arrPos1 = ($totNo/2)-1;
                $arrPos2 = $arrPos1 + 1;

                $Price1 = $price[$arrPos1];
                $Price2 = $price[$arrPos2];
                $stats['price'] = round(($Price1+$Price2)/2);
            }
        }
        else
            $stats['price'] = 0;
        //
        if(isset($_GET['s']))
        {
            $msgSuccess = 'Email has been sent successfully!';
        }
        elseif (isset($_GET['e']))
        {
            $msgError = 'Something went wrong, please try again later.';
        }
        elseif (isset($_GET['er']))
        {
            $msgError = "Please enter email content.";
        }
        //echo '<pre>';print_r($stats);exit();
        $objTmpl->assign(array('T_Body'     => 'user_profile.tpl',
                               'profile'    => $userProfile,
                               'stats'      => $stats,
                               'MainUrl'    => get_home_url().$_SERVER['SCRIPT_NAME'].'?page='.$_GET['page'],
                               'User_Id'    =>  $id,
                                'msgSuccess'=>      $msgSuccess,
                                'msgError'  =>      $msgError,
                                'scriptname'     => $this->baseUrl,

    ));

    }
    public function send_email()
    {
        //echo '<pre>';print_r($_POST);exit();
        global $msgSuccess,$msgError,$objTmpl;
        $url = $this->baseUrl.'&action=user_profile';
        if(isset($_GET['user_id'])){
            $url .='&user_id='.$_GET['user_id'];
        }
        else
            $url .='&user_ref_id='.$_GET['user_ref_id'];

        $EmailTo    =   $_POST['lead_email'];
        //$EmailTo = "test.1.thatsend@gmail.com";
       // var_dump(isset($_POST['email_content']) && $_POST['email_content'] != '');exit();
        if(isset($_POST['email_content']) && $_POST['email_content'] != '')
        {
            if(isset($_POST['lead_email']) && $_POST['lead_email'] != ''){

               // $mail=  wp_mail($EmailTo,$_POST['email_subject'],$_POST['email_content']);
                add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
                $mail=  wp_mail($EmailTo,$_POST['email_subject'],$_POST['email_content']);

                # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
                remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
                # Email to User End #

                if($mail){
                    $msgSuccess = 'Email has been sent successfully!';
                    // header('Location:'.$url.'&success=true');
                    $url.='&s=true';
                    wp_redirect($url);
                    exit();
                }
                else{
                    $msgError = 'Something went wrong, please try again later.';
                    $url.='&e=true';
                    //echo $url;exit();
                    wp_redirect($url);
                    // header('Location:'.$url.'&error=true');
                    exit();
                }
            }
        }
        else{
            $msgError = "Please enter email content.";
            $url.='&er=true';
            wp_redirect($url);
            // header('Location:'.$url.'&error=true');
            exit();
        }



        //echo $this->baseUrl;exit();

    }
    public function save_search()
    {
        //echo '<pre>';print_r($_POST);exit();
        //echo '<pre>';print_r($_GET);exit();

        global $searchParams, $user_id, $objTmpl, $adminId, $arrVirtualPath, $msgSuccess, $msgError, $SavedSearchData, $arrConfig,$arrPhysicalPath;
        include_once($arrPhysicalPath['UserBase']. 'AdminAjaxRequest.php');
        if (isset($_GET['action'])) {
            $Action = $_GET['action'];
        }

        $objAPI = IDXAPI::getInstance();
        if(!$this->__isAjaxRequest){
        if (isset($_POST['Submit']) && $_POST['Submit'] == 'Save') {

            /*if($arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
            {
                unset($_POST['pstyle']);
                unset($_POST['security_safety']);
            }*/
            //echo "<pre>";print_r($_POST);die;

            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
            } else
                $user_id = $_GET['user_ref_id'];

            $wp_user_search = wp_get_current_user();
            $adminId = $wp_user_search->data->ID;

            unset($_POST['Submit']);
            $searchParams = $_POST;

            unset($searchParams['psearch_title']);
            $arr_param = Utility::GetSearchParamAndURL('', $searchParams);

            $search_crieteria = $arr_param['sparam'];
            //echo '<pre>';print_r($search_crieteria);exit();
            $result_count = $objAPI->getCountbyParam($search_crieteria);
            $listing_lastupdatedate = $objAPI->getListingLastUpdateDate();
            //$search_crieteria = unserialize ($search_crieteria['search_crieteria']);
            $POST['search_title'] = $_POST['psearch_title'];
            $POST['search_crieteria'] = $search_crieteria;
            $POST['result_count'] = $result_count;
            $POST['url'] = $arr_param['url'];
            $POST['listing_lastupdatedate'] = $listing_lastupdatedate;

            if ($Action == 'save_search') {
                $POST['user_id'] = $user_id;
                $POST['search_saved_main_url'] = get_home_url();
                $POST['search_saved_site'] = $_SERVER['HTTP_HOST'];
                $POST['search_saved_from'] = 1;
                $POST['search_added_by_type'] = 'Admin';
                $POST['search_added_by_id'] = $adminId;
                $POST['search_page_slug'] = 'Advanced Search';

                $agent = $objAPI->getInfoByWebsite($POST['search_saved_site']);
                //echo'<pre>'; print_r($agent);exit();
                if (is_array($agent) && count($agent) > 0) {
                    $POST['search_site_agent'] = $agent[0]['agent_id'];
                } else {
                    $POST['search_site_agent'] = 0;
                }

                $search_Id = LPTUserSavedSearches::getInstance()->InsertUserSaveSearch($POST);
            } elseif ($Action == 'edit_save_search') {
                //exit();

                $search_Id = $_GET['search_id'];
                //$search_crieteria = unserialize ($search_crieteria['search_crieteria']);

                $UpdateData = LPTUserSavedSearches::getInstance()->UpdateUserSaveSearch($_GET['search_id'], $POST);
                //echo '<pre>';print_r($UpdateData);exit();

            }

            $url = $this->baseUrl . '&action=' . $Action;

            if (isset($_GET['user_id'])) {

                $url .= '&user_id=' . $_GET['user_id'];
            } else
                $url .= '&user_ref_id=' . $_GET['user_ref_id'];

            if (is_numeric($search_Id)) {
                $url .= '&search_id=' . $search_Id . '&s=true';
                // wp_redirect( $this->baseUrl.'&action=save_search&search_id='.$search_Id);
                wp_redirect($url);
                exit();
            } else {
                $url .= '&e=true';
                wp_redirect($url);
                exit();
            }
            //echo $url;exit();

        }

        if (isset($_GET['search_id']) && isset($_GET['search_id']) != '' && $Action == 'edit_save_search') {

            $SavedSearchData = LPTUserSavedSearches::getInstance()->getSavedSearchById($_GET['search_id']);
            $search_Id = $_GET['search_id'];

            $unserializeData = unserialize($SavedSearchData['search_criteria']);
            $objTmpl->assign(array(
                'rsSaveSearch' => $SavedSearchData,
                'arrSearchCriteria' => $unserializeData,
                'user_ref_Id' => $_GET['user_ref_id'],
                'user_Id' => $_GET['user_id'],
            ));

        }

        if (isset($_GET['s']) && isset($_GET['s']) != '') {

            if ($Action == 'save_search') {

                $msgSuccess = 'Saved data successfully!';
            } elseif ($Action == 'edit_save_search') {
                $url = $this->baseUrl . '&action=save_search';
                if (isset($_GET['user_id'])) {

                    $url .= '&user_id=' . $_GET['user_id'];
                } else
                    $url .= '&user_ref_id=' . $_GET['user_ref_id'];

                $url .= '&search_id=' . $search_Id . '&us=true';
                // wp_redirect( $this->baseUrl.'&action=save_search&search_id='.$search_Id);
                wp_redirect($url);
                exit();

            }
        } elseif (($_GET['us']) && isset($_GET['us']) != '') {
            $msgSuccess .= 'Updated data successfully!';
        } elseif (isset($_GET['e']) && isset($_GET['e']) != '') {
            $msgError = 'Something went wrong, please try again later.';

        }


        wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'] . 'jQuery/validate/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'] . 'jQuery/validate/additional-methods.js', array('jquery'));

        # JQuery Input Masking
        wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'] . 'jQuery/jquery.maskedinput.min.js', array('jquery'));
        wp_enqueue_script('jquery-jsxcompressor-js', $arrVirtualPath['Libs'] . 'jQuery/JSXCompressor/jsxcompressor.js', array('jquery'), false, true);


        wp_enqueue_script('predefine-js', $arrVirtualPath['TemplateJs'] . 'predefined.js', array('jquery'), false, true);
        /*  add_filter( 'the_editor', 'add_required_attribute_to_wp_editor', 10, 1 );

          function add_required_attribute_to_wp_editor( $editor ) {
              $editor = str_replace( '<textarea', '<textarea required="required"', $editor );
              return $editor;
          }*/
        add_filter('wp_editor', 'add_required_attribute_to_wp_editor', 10, 1);

        function add_required_attribute_to_wp_editor($editor)
        {
            $editor = str_replace('<textarea', '<textarea required="required"', $editor);
            return $editor;
        }

        $settings = array('textarea_name' => 'text_name');

        /* if(isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)
         {
             $arrWaterfrontDesc  = StaticArray::arrWaterfrontDescActris();
             $arrMeta            = $objAPI->getMeta(array('PropertyStyle','City','SubTypeActris'));
         }
         else
         {*/
        $arrWaterfrontDesc = StaticArray::arrWaterfrontDesc();
        $arrMeta = $objAPI->getMeta(array('PropertyStyle', 'City', 'SubType'));
        /* }*/

        $result_count = $objAPI->getCountbyParam($searchParams);

        $objTmpl->assign(array('T_Body' => 'save_search.tpl',
            'scriptname' => $this->baseUrl,
            //'arrMeta'           =>  $objAPI->getMeta(array('PropertyStyle','City','SubType')),
            'arrMeta' => $arrMeta,
            'arrPriceRange' => StaticArray::arrPriceRangeAdmin(),
            'arrSqftRange' => StaticArray::arrSQFTRange(''),
            'arrBedRange' => StaticArray::arrBedRange(''),
            'arrBathRange' => StaticArray::arrBathRange(''),
            'arrGarageRange' => StaticArray::arrBathRange(''),
            'arrShowOnly' => StaticArray::arrShowOnly(),
            'arrLotSize' => StaticArray::arrLotSize(),
            'arrminYearBuild' => StaticArray::arrYearBuild('from'),
            'arrmaxYearBuild' => StaticArray::arrYearBuild('to'),
            'arrYesNo' => StaticArray::arrYesNo(),
            'arrStatus' => StaticArray::arrStatusAdmin(),
            'arrSortingOption' => StaticArray::arrSortingOption(),
            'arrDayMarket' => StaticArray::arrDayMarket(),
            'arrSystemName' => StaticArray::arrSystemName(),
            'arr_SName_LookUP' => StaticArray::arr_SName_LookUP(),
            //'arrWaterfrontDesc'	    =>	StaticArray::arrWaterfrontDesc(),
            'arrWaterfrontDesc' => $arrWaterfrontDesc,
            'arrSecuritySafety' => StaticArray::arrSecuritySafety(),
            'total_record' => $result_count,
            'isPredefine' => true,
            'msgSuccess' => $msgSuccess,
            'msgError' => $msgError,
            'MainUrl' => get_home_url() . $_SERVER['SCRIPT_NAME'] . '?page=' . $_GET['page'],
            'Action' => $Action,
            'search_Id' => $_GET['search_id'],
            'user_ref_Id' => $_GET['user_ref_id'],
            'user_Id' => $_GET['user_id'],
            'settings' => $settings,
            'AgentSystemName' => $arrConfig['Agent']['agent_system_name'],
        ));
    }
    else {

        $containerId = $_POST['containerId'];
        $params 	 = $_POST;
        $noblink	 = isset($_POST['noblink'])?$_POST['noblink']:'0';

        // Get Count
        $cntListing = $objAPI->getCountbyParam($params);
        //echo print_r($cntListing);exit();
        /*if(isset($_POST['sysName']) && $_POST['sysName'] == 'yes')
        {
            if (isset($_POST['sys_name']) && $_POST['sys_name'] == 'actris')
            {
                $arrWaterfrontDesc = StaticArray::arrWaterfrontDescActris();
                $arrMeta = $objAPI->getMeta(array('SubTypeActris'));
            }
            else
            {
                $arrWaterfrontDesc = StaticArray::arrWaterfrontDesc();
                $arrMeta = $objAPI->getMeta(array('SubType'));
            }
            //echo "<pre>";print_r($arrMeta);die;
            $objTmpl->assign(array(
                'arrWaterfrontDesc' => $arrWaterfrontDesc,
                'arrMeta' => $arrMeta,
                'sysName' => $_POST['sys_name'],
            ));

            AjaxResponse::obj()->assign($objTmpl->fetch("save_search_ptype_actris.tpl"), '.ProperTypeActris');
            AjaxResponse::obj()->assign($objTmpl->fetch("save_search_options.tpl"), '.WaterFrontDesc');
            //AjaxResponse::obj()->assign($objTmpl->fetch("manage.tpl"), '#frmlistingSearch');
            //AjaxResponse::obj()->assign($objTmpl->fetch("save_search.tpl"), '#frmPredSearch');
        }*/

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
    public function save_search_listing()
    {
            global $objTmpl;
           // echo '<pre>';print_r($_GET);exit();

        if(isset($_GET['user_id'])){
            $id = $_GET['user_id'];
            $userProfile    = LPTLeadMaster::getInstance()->getUserById($id);
        }
        elseif (isset($_GET['user_ref_id'])){
            $id = $_GET['user_ref_id'];
            $userProfile    = LPTLeadMaster::getInstance()->getUserByRefId($id);
        }

        if(isset($_GET['page_size']) && count($_GET['page_size']) > 0)
        {
            $arrParams['page_size'] = $_GET['page_size'];
        }
        else{
            $arrParams['page_size'] = Constants::PAGE_SIZE;
            //$arrParams['page_size'] = 2;
        }

        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

        //$rsUser =  LPTUserSavedSearches::getInstance()->getUserSaveSearch($id,$arrParams);
        $rsUser =  LPTUserSavedSearches::getInstance()->getadminUserSaveSearch($id,$arrParams);
        $arrListing = $rsUser['rsData']->fetch_array();
        //echo '<pre>';print_r($arrListing);exit();
        //$arrListing = $rsUser['rsData'];
        // $arrListing =  LPTUserSavedSearches::getInstance()->getUserSaveSearch($id,$arrParams);

        if(isset($_GET['delete']) && isset($_GET['delete']) !=''){

            $msgSuccess = 'Delete save search data successfully!';

        }
        elseif(isset($_GET['error']) && isset($_GET['error']) !='')
        {
            $msgError = 'Something went wrong, please try again later.';

        }
      //  $arrListing = implode(',',$arrListing['search_criteria']);

       // echo '<pre>';print_r($rsUser);exit();

        $objTmpl->assign(array('T_Body'             =>  'save-search-listing.tpl',
                               'arrListing'         =>  $arrListing,
                               'total_record'           =>  $rsUser['totalRecord'],
                               'startRecord'           =>  $rsUser['startRecord'],
                               'totalFetched'           =>  $rsUser['totalFetched'],
                                'MainUrl'           =>  get_home_url().$_SERVER['SCRIPT_NAME'].'?page='.$_GET['page'],
                                'user_ref_Id'       => $_GET['user_ref_id'],
                                'user_Id'           => $_GET['user_id'],
                                'scriptname'        => $this->baseUrl,
                                'msgSuccess'        =>  $msgSuccess,
                                'msgError'          =>  $msgError,
                                'arrParams'         => $arrParams,
                                'page_size'	        =>	$arrParams['page_size'],
        ));
    }
    public function delete_save_search()
    {
        $Search_Id=$_GET['search_id'];
        $delete_id  =   LPTUserSavedSearches::getInstance()->DeleteSearch($Search_Id);
       if($delete_id){
            header("location: $this->baseUrl&action=save_search_listing&user_id=32&delete=true");
        }else{
            header("location: $this->baseUrl&action=save_search_listing&user_id=32&error=true");
        }

        exit(0);

    }
    public function email_listing_save_search()
    {
        global $objTmpl,$user_id,$objAPI,$arrConfig,$searchParams,$arr_param,$arrVirtualPath;

        $objAPI                     = IDXAPI::getInstance();

        if(isset($_GET['user_id'])){
            $id = $_GET['user_id'];
            $userProfile    = LPTLeadMaster::getInstance()->getUserById($id);
        }
        elseif (isset($_GET['user_ref_id'])){
            $id = $_GET['user_ref_id'];
            $userProfile    = LPTLeadMaster::getInstance()->getUserByRefId($id);
        }

        //echo '<pre>';print_r($userProfile);exit();

        $url = $this->baseUrl.'&action=email_listing_save_search';
        if(isset($_POST['Submit']) && $_POST['Submit'] == 'Send')  {

            $record =   LPTUserSavedSearches::getInstance()->getSavedSearchById($_GET['search_id']);
            //echo '<pre>';print_r($record);exit();
            if ($_POST['email_content'] != ''){
                $search_title = $record['search_title'];
                $search_criteria = unserialize($record['search_criteria']);
                $search_resultcount = $record['search_resultcount'];
                $arrListing =   $objAPI->getListingByParamforSaveSearch($search_criteria);
                $wordpress_upload_dir = wp_upload_dir();
                $uploadPath           = $wordpress_upload_dir['baseurl'].'/';
               /* $arrListing['formatURL']    = array('slug-1'=>'CityName-properties',
                    'slug-2'=>'UnitNo-StreetNumber-StreetDirPrefix-StreetName-Subdivision-CityName-State-ZipCode'); */                                                                                                                                                                         ;
                //echo '<pre>';print_r($arrVirtualPath);exit();

                if($arrListing['total_record'] > 0) {

                    $objTmpl->assign(array(
                        "arrListing" => $arrListing,
                        //"recAgentInfo"  =>  $recAgentInfo,
                        "PhotoBaseUrl" => $arrListing['PhotoBaseUrl'],
                        "currency" => '$',
                        'search_title' => $search_title,
                        'total_count' => $search_resultcount,
                        'AgentInfo'     =>$arrConfig['Agent'],
                        'AgentImgUrl'    => $arrVirtualPath['UploadBase'].'agent/',
                        "uploadPath"         =>      $uploadPath,
                        'recSearch'         => $record,
                        'host_url'           =>      $record['search_saved_main_url'],
                    ));
                    $EmailSubject = $_POST['email_subject'];

                    $CurrentListing =   $objTmpl->fetch("email_search_notify.tpl");

                    $EmailContents = str_replace('[[listing]]', $CurrentListing, $_POST['email_content']);

                    //$Email = Utility::getInstance()->ReplaceCustomVariables($record, $userProfile);

                   // $host_url             = get_home_url();
                    $host_url             = $record['search_saved_main_url'];
                    $wordpress_upload_dir = wp_upload_dir();
                    $uploadPath           = $wordpress_upload_dir['baseurl'].'/';

                    //echo '<pre>';print_r($EmailContents);exit();

                    $objTmpl->assign(array(
                        'Email_Body'         =>      $EmailContents,
                        'isContent'          =>      true,
                        'Use_HeaderFooter'   =>      $_POST['header_footer'],
                        'Email_Header'       =>      'email_header.tpl',
                        'Email_Footer'       =>      'email_footer.tpl',
                        'logo'               =>      $arrConfig['Agent']['print_photo'],
                        "uploadPath"         =>      $uploadPath,
                        'host_url'           =>      $host_url,
                        'isHideSender'       =>      true,

                    ));
                    $EmailBody  =   $objTmpl->fetch('email_layout.tpl');
                    $EmailTo    =   $_POST['email'];

                    $EmailBody  =   stripslashes($EmailBody);
                    //echo $host_url;
                    //print($EmailBody);exit();

                    add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
                    //$mail = wp_mail($EmailTo,$EmailSubject,$EmailContents);
                    $mail = wp_mail($EmailTo,$EmailSubject,$EmailBody);

                    # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
                    remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
                    # Email to User End #

                    $url = $this->baseUrl.'&action=email_listing_save_search';

                    if(isset($_GET['user_id'])){
                        $url .='&user_id='.$_GET['user_id'];
                    }
                    else
                        $url .='&user_ref_id='.$_GET['user_ref_id'];

                    if(is_numeric($_GET['search_id'])){
                        $url .='&search_id='.$_GET['search_id'];
                    }
                    //echo '<pre>';print_r($url);exit();
                    if($mail){
                        $msgSuccess = 'Email has been sent successfully!';
                        // header('Location:'.$url.'&success=true');
                        $url.='&s=true';
                        wp_redirect($url);
                        exit();
                    }
                    else{
                        $msgError = 'Something went wrong, please try again later.';
                        $url.='&e=true';
                        wp_redirect($url);
                        exit();
                    }
                }

            }
            else{
                $msgError = "Please enter required values.";
                $url.='&er=true';
                wp_redirect($url);
                exit();
            }

        }
        if(isset($_GET['s']) && isset($_GET['s']) !=''){

            $msgSuccess = 'Email has been sent successfully!';

        }
        elseif(isset($_GET['e']) && isset($_GET['e']) !='')
        {
            $msgError = 'Something went wrong, please try again later.';

        }
        elseif(isset($_GET['er']) && isset($_GET['er']) !='')
        {
            $msgError = 'Please enter email content.';

        }

        $objTmpl->assign(array(
            'T_Body'            =>      'email_listing_save_search.tpl',
            'profile'           =>      $userProfile,
            'msgSuccess'        =>      $msgSuccess,
            'msgError'          =>      $msgError,
        ));

    }
    public function send_lead_info()
    {
        global $objTmpl,$arrPhysicalPath;

        $arrPhysicalPath['EmailTemplate']	= $arrPhysicalPath['Base']. 'email_templates'. DS;

        $uid = $_GET['user_id'];
        $post = LPTLeadMaster::getInstance()->getUserById($uid);

        $EmailSubject = 'Lead Information - '.ucwords(strtolower($post['lead_first_name'])).' '.ucwords(strtolower($post['lead_last_name'])).' @ '.date('H:i a')." - ".get_bloginfo();

        /*$objTmpl->assign(array("frmData" => $_POST,
        ));*/

        $objTmpl->assign(array("Email_Header" => 'email_header.tpl', "Email_Body" => 'email_schedule_showing.tpl',//				                 "Email_Footer"		=>	'email_footer.tpl'
        ));

        $EmailBody = $objTmpl->fetch('email_layout.tpl');

        file_put_contents('user-lead.html', print_r($EmailBody ." " .$EmailSubject, true));

        $EmailTo = $post['lead_email'];

        add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

        //wp_mail($EmailTo, $EmailSubject, $EmailBody, $headers);

        # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
        remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

        $msgSuccess = "Lead information has been sent successfully.";

        return $msgSuccess;
    }
    function set_html_content_type() {  return 'text/html'; }
}
?>