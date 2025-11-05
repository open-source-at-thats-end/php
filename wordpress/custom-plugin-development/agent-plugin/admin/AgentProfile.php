<?php
class AgentProfile extends AdminModule
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

            case 'add':
                $this->add();
                break;
            case 'viewListing':
                $this->viewListing();
                break;
            case 'delete':
                //exit("aaaaaaaaaaa");
                $this->delete();
                break;
            case 'edit':
                $this->add();
                break;
                default:
                $this->manage();
                break;
        }
    }

    public function manage()
    {

        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

        if(isset($_POST['scriptname']) && $_POST['scriptname'] != '')
        {
            $this->baseUrl = $_POST['scriptname'];
        }

        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;
        $arrParams = array_merge($_GET,$arrParams);
        $rsAgent = LPTAgentProfile::getInstance()->viewAllAgent($arrParams);
        $wordpress_upload_dir = wp_upload_dir();

        $uploadPath = $wordpress_upload_dir['baseurl'].'/';

        $objTmpl->assign(array(
            'T_Body' => 'agentprofile/agentprofile.tpl',
            'scriptname' => $this->baseUrl,
            'rsAgent'	    =>	$rsAgent['rsData'],
            'total_record' => $rsAgent['totalRecord'],
            'totalFetched'  =>  $rsAgent['totalFetched'],
            'page_size'=>Constants::AGENT_PROFILE_PAGE_SIZE,
            'startRecord'  =>  $rsAgent['startRecord'],
            'agentprofileImgUrl'   =>  $uploadPath,
        ));


    }
    public function add()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        $uploadPath = wp_upload_dir()['basedir'].'/';

        if($this->_action == 'add' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save') {

            # Upload Image & Get uploade file name
            if(isset($_FILES['agent_photo']['size']) && $_FILES['agent_photo']['size'] > 0)
            {
                $photoUrl = Utility::uploadFile($_FILES['agent_photo'], $uploadPath, $_POST['prev_agent_photo']);
            }
            else
            {
                $photoUrl = $_POST['prev_agent_photo'];
            }

            $_POST['agent_photo'] = $photoUrl;

            LPTAgentProfile::getInstance()->Insert($_POST);

        }
        elseif ($this->_action=='edit' && isset($_POST['Submit']) && $_POST['Submit']=='Save'){

            if(isset($_FILES['agent_photo']['size']) && $_FILES['agent_photo']['size'] > 0)
            {
                $photoUrl = Utility::uploadFile($_FILES['agent_photo'], $uploadPath, $_POST['prev_agent_photo']);
            }
            else
            {
                $photoUrl = $_POST['prev_agent_photo'];
            }
            $_POST['agent_photo'] = $photoUrl;

            LPTAgentProfile::getInstance()->Update($_POST['pk'],$_POST);
        }

        if($this->_action == 'edit')
        {
            $pk = $_GET['pk'];

            $rsAgent =  LPTAgentProfile::getInstance()->getInfoByIdAgent($pk);

            $wordpress_upload_dir = wp_upload_dir();

            $uploadPath = $wordpress_upload_dir['baseurl'].'/';
            $str = str_replace('  ', ' ', $rsAgent['Agent_Name']);
            $arr = explode(" ", trim($str));

            if (count($arr) > 0){
                $rsAgent['agent_first_name'] = $arr[0];

            }
            if (count($arr) > 1){
                $rsAgent['agent_last_name'] = $arr[1];
            }

            $objTmpl->assign(array(
                'rsAgent'   => $rsAgent,
                'pk'        => $pk,
                'agentprofileImgUrl'   =>  $uploadPath,
                'scriptname'    =>  $this->baseUrl,
            ));
        }

        $objTmpl->assign(array('T_Body' => 'agentprofile/agentprofile-add.tpl',
            'scriptname'    =>  $this->baseUrl,

        ));
    }
    public function viewListing(){
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        $objTmpl = LPTAgentProfile::getInstance()->viewAllAgent($_GET);

        $objTmpl->assign(array('T_Body' => 'agentprofile/agentprofile.tpl',
            'scriptname'    =>  $this->baseUrl,
        ));

    }

    public function delete()
    {
        global  $arrPhysicalPath;

        $objAPI = LPTAgentProfile::getInstance()->deleteAgent($_GET['pk']);

        if($objAPI)
            header("location: $this->baseUrl&delete=true");
        else
            header("location: $this->baseUrl&error=true");

        exit(0);

    }

}
?>