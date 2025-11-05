<?php
class AdminShortCode extends AdminModule
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

    public function manage()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

        if (isset($_GET['add']) && $_GET['add'] == true)
            $msgSuccess = "Shortcode has been added successfully.";
        elseif (isset($_GET['save']) && $_GET['save'] == true)
            $msgSuccess = "Shortcode has been saved successfully.";
        elseif (isset($_GET['delete']) && $_GET['delete'] == true)
            $msgSuccess = "Shortcode has been deleted successfully.";

        $objAPI = IDXAPI::getInstance();
        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

        $rsShortCode = $objAPI->getShortcode($arrParams);

        $objTmpl->assign(array('T_Body' => 'shortcode/shortcode.tpl',
            'scriptname' => $this->baseUrl,
            'rsShortCode'	=>	$rsShortCode['rsShortCode'],
            'totalFetched'  =>  $rsShortCode['totalFetched'],
            'page_size'	    =>	Constants::PAGE_SIZE,
            'start_record'  =>  $rsShortCode['startRecord'],
            //'Filter'		=>	AgentRoster::obj()->filter,
            //'PageSize'		=>	$asset['OL_PageSize'],
            'msgSuccess' => $msgSuccess,

        ));

    }

    public function add()
    {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        $objAPI = IDXAPI::getInstance();

        if($this->_action == 'add' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save')
        {
            $insert = $objAPI->addShortcode($_POST);

            if($insert)
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
            $update = $objAPI->updateShortcode($_POST);
            if ($update){
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
            $rsAgent = $objAPI->getShortcodeById($pk);

            $objTmpl->assign(array(
                'rsShortCode'   => $rsAgent,
                'pk'        => $pk
            ));
        }

        wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'].'jQuery/validate/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'].'jQuery/validate/additional-methods.js', array('jquery'));

        # JQuery Input Masking
        wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'].'jQuery/jquery.maskedinput.min.js', array('jquery'));

        $objTmpl->assign(array('T_Body'     => 'shortcode/shortcode-add.tpl',
            'scriptname' => $this->baseUrl,
            'msgError'	=>	$msgError,

        ));
    }
    public function delete(){

        $objAPI = IDXAPI::getInstance();

        $delete = $objAPI->deleteShortcode($_GET['pk']);

        if($delete){
            header("location: $this->baseUrl&delete=true");
        }else{
            header("location: $this->baseUrl&error=true");
        }

        exit(0);
    }
}