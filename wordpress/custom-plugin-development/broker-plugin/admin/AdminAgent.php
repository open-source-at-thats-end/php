<?php

class AdminAgent extends AdminModule {
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
        global $arrPhysicalPath;

        parent::requestHandler($isAjaxRequest, $moduleKey);

        $this->baseUrl = admin_url('admin.php?page='.Constants::SLUG.'-'.$this->__moduleKey);

        switch($this->_action)
        {
            case 'view':
                $this->view();
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
            default:
                $this->manage();
                break;
        }
    }
    public function manage() {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

        $objAPI = IDXAPI::getInstance();

/*        include_once($arrPhysicalPath['DBAccess']. 'DAOAgentRoaster.php');
        $objAgentRoaster = DAOAgentRoaster::getInstance();*/


        $objAPI = IDXAPI::getInstance();
        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;
       
        $arrParams = array_merge($_GET,$arrParams);
        $rsAgent = $objAPI->getAgent($arrParams);


        if(isset($_GET['add']) && $_GET['add']==true)
            $msgSuccess =  "Agent data has been added successfully.";
        elseif(isset($_GET['save']) && $_GET['save']==true)
            $msgSuccess = "Agent data has been saved successfully.";
        elseif(isset($_GET['delete']) && $_GET['delete']==true)
            $msgSuccess = "Agent data has been deleted successfully.";

        $objTmpl->assign(array( 'T_Body'		=>	'agent/agent.tpl' ,
            'scriptname'    =>  $this->baseUrl,
            'rsAgent'	    =>	$rsAgent['rsAgent'],
            "total_record"	=>	count($rsAgent['rsAgent']),
            'totalFetched' =>  $rsAgent['totalFetched'],
            'page_size'     =>  Constants::PAGE_SIZE,
            'startRecord'  =>  $rsAgent['startRecord'],
            'arrParams'      => $arrParams,
            //'Filter'		=>	AgentRoster::obj()->filter,
            //'PageSize'		=>	$asset['OL_PageSize'],
            'msgSuccess'	=>	$msgSuccess,
            'agentImgUrl'   =>  $arrConfig['upload_url']."agent/",
            'page'          =>  $_GET['page'],
        ));

    }
    public function add()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        $objAPI = IDXAPI::getInstance();

        /*include_once($arrPhysicalPath['DBAccess'].'DAOAgentRoaster.php');
        $objAgentRoaster = DAOAgentRoaster::getInstance();*/

        $city = $objAPI->getCityKeyValueArray('');
        $allCity['all'] = 'All';
        $arrMIAMICity = array_merge($allCity,$city['MIAMI/BEACHES']);
        $arrACTRISCity = array_merge($allCity,$city['ACTRIS']);
//        echo"<pre>";print_r($arrCity);die;
        $_POST['agent_select_mls'] = (isset($_POST['agent_select_mls']) && $_POST['agent_select_mls'] != null)?($_POST['agent_select_mls']):"SEFMIAMI";
        
        if($this->_action == 'add' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save')
        {
            $_POST['agent_mls'] = 1;
            $_POST['agent_key_code'] = md5(time());
            $_POST['files'] = $_FILES;
            if($objAPI->addAgent($_POST))
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
            /*if (isset($_POST['sys_name_change']) && $_POST['sys_name_change'] == 'Yes')
            {
                wp_remote_post($_SERVER['REQUEST_SCHEME'].'://'.$_POST['agent_website'].'/wp-content/plugins/loopt/updateOption.php?agent_mls='.$_POST["agent_mls"]);
            }*/

            /*if (isset($_POST['agent_condo_photo_video_url']) && $_POST['agent_condo_photo_video_url'] != '')
            {
                if(isset($_POST['agent_condo_photo_video_url']) && $_POST['agent_condo_photo_video_url'] != '' && strpos($_POST['agent_condo_photo_video_url'], 'youtube'))
                {
                    $_POST['agent_condo_photo_video_url'] = str_replace("watch?v=","embed/",$_POST['agent_condo_photo_video_url']);
                }

                wp_remote_post($_SERVER['REQUEST_SCHEME'].'://'.$_POST['agent_website'].'/wp-content/plugins/loopt/updateOption.php?agent_condo_photo_video_url='.$_POST["agent_condo_photo_video_url"]);
            }*/

            $_POST['files'] = $_FILES;

            //echo "<pre>"; print_r($_POST); exit("22222222");

            if($objAPI->updateAgent($_POST))
            {
                header("location: $this->baseUrl&save=true");
                exit(0);
            }
            else{
                $msgError = 'Something went wrong.';
            }

        }

        if($this->_action == 'edit')
        {
            $pk = $_GET['pk'];
            $rsAgent = $objAPI->getInfoById($pk);
            $objTmpl->assign(array(
                'rsAgent'   => $rsAgent,
                'pk'        => $pk
            ));
        }



        wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'].'jQuery/validate/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'].'jQuery/validate/additional-methods.js', array('jquery'));

        # JQuery Input Masking
        wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'].'jQuery/jquery.maskedinput.min.js', array('jquery'));

        $objTmpl->assign(array('T_Body'             => 'agent/agent-add.tpl', //'A_Action'		=>	$scriptName,
                            //'customAction'	=>	'agent_actions.tpl' ,
                            'scriptname'            => $this->baseUrl, //"total_record"	=>	AgentRoster::obj()->total_record,
                            //'City'       => $arrCity,
                            'agentImgUrl'           =>  $arrConfig['upload_url']."agent/",
                            'msgError'	            =>	$msgError,
                            'arrMIAMICity'	        =>	$arrMIAMICity,
                            'arrACTRISCity'	        =>	$arrACTRISCity,
                            'AgentSystemName'       =>	$arrConfig['Agent']['agent_system_name'],
                            'arrAgentSystemName'    =>	StaticArray::arrAgentSystemName(),
                            'selectMLS'             =>	StaticArray::arr_SName_MLS(),
        ));

    }
    public function delete()
    {
        global  $arrPhysicalPath;

        $objAPI = IDXAPI::getInstance();

        $ret = $objAPI->deleteAgent($_GET['pk']);

        if($ret)
            header("location: $this->baseUrl&delete=true");
        else
            header("location: $this->baseUrl&error=true");

        exit(0);

    }
}
?>