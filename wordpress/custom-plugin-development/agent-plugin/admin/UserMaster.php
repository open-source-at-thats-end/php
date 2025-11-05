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

        $this->baseUrl = admin_url('admin.php?page=' . Constants::SLUG . '-' . $this->__moduleKey);

        switch ($this->_action) {
            case 'delete':
		        $this->delete();
		        break;
	        case 'export':
	        	$this->export();
	        	break;
            default:
                $this->manage();
                break;
        }
    }
    public function manage()
    {
        global $objTmpl;

        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;
        $arrParams['allRecord'] = false;
        $arrParams['sort_order'] = 'lead_created_date';
        $arrParams['sort_dir'] = 'DESC';
        $rsUser = LPTLeadMaster::getInstance()->getRegisterAndUnregisterUser($arrParams);

        if (isset($_GET['delete']) && $_GET['delete'] == true)
		    $msgSuccess = "Lead has been deleted successfully.";

        $arrUser = array();
        while ($rsUser['rsData']->next_record()){

            $user = $rsUser['rsData']->Record;
            $meta = get_user_meta($user['lead_user_id']);

            if(isset($meta['user_phone'][0]) && $meta['user_phone'][0] != '')
            {
                $user_phone = $meta['user_phone'][0];
            }
            elseif (isset($user['lead_mobile']) && $user['lead_mobile'] !='')
            {

                $user_phone = $user['lead_mobile'];
            }
            else
            {
                $user_phone = $user['lead_home_phone'];
            }

            $arrUser[] = array(
                    "user_id" => $user['lead_user_id'],
                    "user_first_name" => (isset($meta['user_first_name'][0]) ? $meta['user_first_name'][0] : $user['lead_first_name']),
                    "user_last_name" => (isset($meta['user_last_name'][0]) ? $meta['user_last_name'][0] : $user['lead_last_name']),
                    "user_email" => (isset($meta['user_email'][0]) ? $meta['user_email'][0] : $user['lead_email']),
                    //"user_phone" => (isset($meta['user_phone'][0]) ? $meta['user_phone'][0] : $user['lead_home_phone']),
                    "user_phone" => $user_phone,
                     "lead_id"   => $user['lead_id'],
                     "lead_date"   => $user['lead_created_date'],
                     "lead_type"   => $user['lead_type'],
                );
        }

        $objTmpl->assign(array('T_Body' => 'user.tpl',
            'scriptname'    => $this->baseUrl,
            'rsUser'	    =>	$arrUser,
            'total_record'	=>	$rsUser['total_record'],
            'totalFetched'  =>  $rsUser['totalFetched'],
            'page_size'	    =>	Constants::PAGE_SIZE,
            'startRecord'  =>  $rsUser['startRecord'],
             'msgSuccess' => $msgSuccess,

        ));

    }
	public function delete(){


			$delete = LPTLeadMaster::getInstance()->DeleteLeadUser($_GET['email'],$_GET['user_id']);

			if($delete){
				header("location: $this->baseUrl&delete=true");
			}else{
				header("location: $this->baseUrl&error=true");
			}

			exit(0);
		}
	public function export()
	{
		global $objTmpl;

		$arrUserMaster	= array('Name','Email','Phone','User Type','Date');
		$arrParams['allRecord'] = true;
        $arrParams['sort_order'] = 'lead_created_date';
        $arrParams['sort_dir'] = 'DESC';
		$rsUser = LPTLeadMaster::getInstance()->getRegisterAndUnregisterUser($arrParams);
		$arrUser = array();
		while ($rsUser['rsData']->next_record()){

			$user = $rsUser['rsData']->Record;
            $date = date_create($user['lead_created_date']);
			$meta = get_user_meta($user['lead_user_id']);

            if(isset($meta['user_phone'][0]) && $meta['user_phone'][0] != '')
            {
                $user_phone = $meta['user_phone'][0];
            }
            elseif (isset($user['lead_mobile']) && $user['lead_mobile'] !='')
            {

                $user_phone = $user['lead_mobile'];
            }
            else
            {
                $user_phone = $user['lead_home_phone'];
            }

			$arrUser[] = array(
				"user_id" => $user['lead_user_id'],
				"user_first_name" => (isset($meta['user_first_name'][0]) ? $meta['user_first_name'][0] : $user['lead_first_name']),
				"user_last_name" => (isset($meta['user_last_name'][0]) ? $meta['user_last_name'][0] : $user['lead_last_name']),
				"user_email" => (isset($meta['user_email'][0]) ? $meta['user_email'][0] : $user['lead_email']),
				//"user_phone" => (isset($meta['user_phone'][0]) ? $meta['user_phone'][0] : $user['lead_home_phone']),
                "lead_type"   => $user['lead_type'],
                "user_phone" => $user_phone,
				"date" => $date->format('Y-m-d'),
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
		header('Content-Disposition: attachment; filename=Lead_'. date('dmY'). '.csv');
        $output = fopen("php://output", "w");

        fputcsv($output, array('Name','Email','Phone','Lead Type','User Type','Date'));

        foreach ($arrUser as $key => $val){
            $leadcsv = array(
                'Name' => $val['user_first_name']. ' ' . $val['user_last_name'],
                'Email' => $val['user_email'],
                'Phone' => $val['user_phone'],
                'Lead Type' => $val['lead_type'],
                'User Type' => (isset($val['user_id']) && $val['user_id'] == 0 ? 'Unregistered' : 'Registered'),
                'Date' => $val['date']
            );
            fputcsv($output, $leadcsv);
        }
        fclose($output);

		exit;

	}

}
?>