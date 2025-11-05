<?php
class AdminDevelopment extends AdminModule
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
        parent::requestHandler($isAjaxRequest, $moduleKey);

        $this->__isAjaxRequest = $isAjaxRequest;
        $this->__moduleKey = $moduleKey;

        if($this->__isAjaxRequest) {
            $this->_action 		= strtolower($_POST['ajax_mod']);
            $this->_subaction 	= $_POST['ajax_subaction'];
            $this->baseUrl 	    = $_POST['XHR']['URL'];

        } else {
            // For non-ajax requests
            $this->baseUrl = admin_url('admin.php?page='.constants::SLUG.'-'.$this->__moduleKey);
        }
//echo '<pre>';print_r($this->_action);exit;
        switch ($this->_action) {
            case 'add':
                $this->add();
                break;
            case 'edit':
                $this->add();
                break;
            case 'development-search':
                $this->manage();
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
        global $arrVirtualPath, $arrConfig, $objTmpl;

        wp_enqueue_script('development-js',              $arrVirtualPath['TemplateJs']. 'development.js', array( 'jquery' ));
        wp_localize_script(	'development-js',
            'objdevelopmentAjax',
            array('action' => 'admin_ajax', 'development_mod' => $this->__moduleKey, 'development_action' => admin_url('admin-ajax.php')));

        if (isset($_GET['add']) && $_GET['add'] == true)
            $msgSuccess = "Development Page has been added successfully.";
        elseif (isset($_GET['save']) && $_GET['save'] == true)
            $msgSuccess = "Development Page has been saved successfully.";
        elseif (isset($_GET['delete']) && $_GET['delete'] == true)
            $msgSuccess = "Development Page has been deleted successfully.";

        $objAPI = IDXAPI::getInstance();
        $arrParams['page_size']         = Constants::PAGE_SIZE;
        $arrParams['page_current']      = isset($_POST['cpage'])?$_POST['cpage']:1;
//        $arrParams['agent_sys_name']    = Constants::MARBEACHES; //((isset($arrConfig['Agent']['agent_system_name']) && $arrConfig['Agent']['agent_system_name'] == Constants::ACTRIS)?Constants::ACTRIS:Constants::MARBEACHES);

        $arrParams  = array_merge($_GET,$arrParams);
//        echo '<pre>';print_r($arrParams);exit;
        $rsDevelopment    = $objAPI->getDevelopment($arrParams);

        $arrPre = array();
        $setting  =array('textarea_rows'=> '5');
        foreach ($rsDevelopment['rsDevelopment'] as $key=>$val)
        {
            $shortcode = '[development-result did=';

            $shortcode .= $val['dev_id'].']';


            $arrPre[$key] = array(
                'dev_id'            => $val['dev_id'],
                'dev_title'          => $val['dev_title'],
                /*'csearch_address'       => $val['csearch_address'],
                'csearch_added_date'    => $val['csearch_added_date'],
                'csearch_tag'           => $val['csearch_tag'],*/
                'dev_criteria'      => unserialize($val['dev_criteria']),
                'dev_require_reg'      => $val['dev_require_reg'],
                'shortcode'             => $shortcode,
            );
        }

        wp_enqueue_script('jquery-colorbox-js');
        wp_enqueue_style('jquery-colorbox-style');
        wp_enqueue_script('development-js',              $arrVirtualPath['TemplateJs']. 'development.js', array( 'jquery' ));
        if(isset($_POST['scriptname']) && $_POST['scriptname'] != '')
        {
            $this->baseUrl = $_POST['scriptname'];
        }
//        echo '<pre>';print_r($rsDevelopment);exit;
        $objTmpl->assign(array(
            'scriptname'    => $this->baseUrl,
            'rsDevelopment'       => $arrPre,
            "total_record"	=> count($rsDevelopment['rsDevelopment']),
            'totalFetched'  => $rsDevelopment['totalFetched'],
            'page_size'	    => Constants::PAGE_SIZE,
            'startRecord'   => $rsDevelopment['startRecord'],
            'objAdminDev'   => AdminDevelopment::getInstance(),
            'msgSuccess'    => $msgSuccess,
            'arrPageSize'	=> StaticArray::arrPageSize(),
            'arrParams'     => $arrParams,
            'page'          => $_GET['page'],
            'setting'          => $setting,
        ));

        if(!$this->__isAjaxRequest){

            $objTmpl->assign(array(
                'T_Body'            => 'development/development.tpl',
            ));
        }else{

            if(strpos($_SERVER['HTTP_HOST'], 'thatsend') !== false || strpos($_SERVER['HTTP_HOST'], 'project') !== false)
            {
                $_SERVER['REQUEST_URI'] = '/backend/wp-admin/admin.php?page='.Constants::SLUG.'-development';
            }else{
                $_SERVER['REQUEST_URI'] = '/wp-admin/admin.php?page='.Constants::SLUG.'-development';
            }

            AjaxResponse::obj()->assign($objTmpl->fetch('development/development-list.tpl'), '.frmStdForm');
            AjaxResponse::obj()->assign($objTmpl->fetch('development/development-pagination.tpl'), '#pre-pagination');

            AjaxResponse::obj()->call_request_area();

            echo AjaxResponse::obj()->send();
            exit();
        }
    }

    public function add()
    {
        global $arrVirtualPath, $arrConfig, $objTmpl,$physical_path;

        $objAPI = IDXAPI::getInstance();

        if(!$this->__isAjaxRequest)
        {
            if($this->_action == 'add' && isset($_POST['Submit']) && $_POST['Submit'] == 'Save')
            {
                unset($_POST['Submit']);
                unset($_POST['Action']);

                /*if(isset($_FILES['main_photo']['size']) && $_FILES['main_photo']['size'] > 0)
                {
                    $photoUrl = Utility::uploadFile($_FILES['agent_photo'], $uploadPath, $_POST['prev_agent_photo']);
                }
                else
                {
                    $photoUrl = $_POST['prev_agent_photo'];
                }*/

                $searchParams = $_POST;

                $_POST['dev_criteria']      = serialize(array_filter($searchParams));
                $_POST['dev_added_date'] 	= date('Y-m-d');
//                echo '<pre>';print_r($_POST);exit;
                $insert = $objAPI->addDevelopmentPage($_POST);

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
                unset($_POST['Submit']);
                unset($_POST['Action']);

                $update = $objAPI->updateDevelopmentPage($_POST);
                if ($update){
                    header("location: $this->baseUrl&save=true");
                    exit(0);
                }
                else{
                    $msgError = 'Something went wrong.';
                }
            }

            $searchParams= '';
            if($this->_action == 'edit')
            {
                $pk = $_GET['pk'];
                $rsDevelopment = $objAPI->getDevelopmentPageById($pk);

                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                    $url = "https://";
                else
                    $url = "http://";
                // Append the host(domain name, ip) to the URL.
                $url.= $_SERVER['HTTP_HOST'];
                // Append the requested resource location to the URL
                $url.= $_SERVER['REQUEST_URI'];

                $objTmpl->assign(array(
                    'rsDevelopment'         => $rsDevelopment,
//                    'arrSearchCriteria'     => $searchParams,
                    'pk'                    => $pk,
                    'action'            => $this->_action,
                    'RedirectURL'       => $url,
                ));
            }

            wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs'].'jQuery/validate/jquery.validate.min.js', array('jquery'));
            wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs'].'jQuery/validate/additional-methods.js', array('jquery'));
            wp_enqueue_script('js-ckeditor', $arrVirtualPath['Libs'].'ckeditor/ckeditor.js', array('jquery'));

            # JQuery Input Masking
            wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs'].'jQuery/jquery.maskedinput.min.js', array('jquery'));
            wp_enqueue_script('jquery-jsxcompressor-js', $arrVirtualPath['Libs']. 'jQuery/JSXCompressor/jsxcompressor.js', array( 'jquery' ), false, true);

            $setting  =array(
                'media_buttons' => false,
                'teeny' => true,
                'editor_class' => 'plus_sign_editor',
                'textarea_rows' => 5
            );

            $addPK = $objAPI->getDevelopmentPagePreId();

            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $url = "https://";
            else
                $url = "http://";
            // Append the host(domain name, ip) to the URL.
            $url.= $_SERVER['HTTP_HOST'];
            // Append the requested resource location to the URL
            $url.= $_SERVER['REQUEST_URI'];

            $objTmpl->assign(array('T_Body'             => 'development/development-add.tpl',
                                    'scriptname'        =>  $this->baseUrl,
                                    'arrYesNo'	        =>	StaticArray::arrYesNo(),
                                    'isCondo'	        =>	true,
                                    'msgError'	        =>	$msgError,
                                    'setting'           => $setting,
                                    'action'            => $this->_action,
                                    'addPK'             => $addPK,
                                    'RedirectURL'       => $url,
            ));
        }
        else {

            $containerId = $_POST['containerId'];
            $params 	 = $_POST;
            $noblink	 = isset($_POST['noblink'])?$_POST['noblink']:'0';

            // Get Count
            $cntListing = $objAPI->getCountbyParam($params);

            AjaxResponse::obj()->script("jQuery('#".$containerId." .match').html('<i></i>&nbsp;<b>".number_format($cntListing, 0)." MATCHES"."</b>');");
            if($noblink != 1)
                AjaxResponse::obj()->script('$("#'.$containerId.' .match b").fadeOut(250).fadeIn(300).fadeOut(250).fadeIn(300);');

            AjaxResponse::obj()->call_request_area();

            echo AjaxResponse::obj()->send();
            exit();

        }
    }

    /*function getPropertyCount($csearch_id)
    {
        global $objTmpl;

        if(isset($csearch_id) && !empty($csearch_id)){

            $objAPI = IDXAPI::getInstance();
            $rsCondo = $objAPI->getCondoSearchById($csearch_id);
            $searchParams = unserialize($rsCondo['csearch_criteria']);

            $objTmpl->assign(array(
                'csearch_id'	    =>	$csearch_id,
            ));

            $count = $objAPI->getCountbyParam($searchParams);

            return $count;
        }
    }*/

    public function delete()
    {
        $objAPI = IDXAPI::getInstance();

        $delete = $objAPI->deleteDevelopmentPage($_GET['pk']);

        header("location: $this->baseUrl&delete=true");

        if($delete){
            header("location: $this->baseUrl&delete=true");
        }else{
            header("location: $this->baseUrl&error=true");
        }

        exit(0);
    }
}
?>