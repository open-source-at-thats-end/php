<?php
class Admin {
    private static $instance ;

    private function __construct(){
        //
    }

    public static function getInstance(){
        if( !isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function initialize() {
        global $arrPhysicalPath, $arrVirtualPath, $agentInfo;


        # Add menu
        add_action('admin_menu', array($this, 'createAdminMenu'));

//        add_action('wp_ajax_admin_ajax', array($this, 'requestHandler'));

        add_action('wp_ajax_nopriv_admin_ajax', array(AdminAjaxRequest::getInstance(), 'requestHandler'));
        add_action('wp_ajax_admin_ajax', array(AdminAjaxRequest::getInstance(), 'requestHandler'));

        # if this enable, it will called from other plugin too
        add_action('admin_head', array($this, 'requestHandler3'));
        # Adds functionality to the text editor for pages and posts
        # Add buttons to text editor and initialize short codes
        //add_action('admin_init', array(TinyMceManager::getInstance(), "addButtons") );

        # add one more params to identify multi upload
        if (!empty($_FILES) && isset($_POST['is_multiupload'])) {do_action('wp_ajax_admin_ajax');}

    }
    public function requestHandler3(){

        global $arrVirtualPath, $arrPhysicalPath;

        wp_dequeue_style( 'application_maker_style' );
        wp_enqueue_style( 'ore-jquery-ui-css', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_style( 'ore-jquery-ui-theme-css', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.theme.css',array(),Constants::CSS_JS_VERSION);

        wp_enqueue_script( 'ajax-request', $arrVirtualPath['Libs']. 'jQuery/jquery.oe.ajaxrequest.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

        wp_enqueue_script('ore-jquery-ui-js', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-1.4.1.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

        wp_enqueue_style( 'jquery-colorpic-css', $arrVirtualPath['Libs']. 'jQuery/Color-Picker/jquery.minicolors.css');
        wp_enqueue_script( 'jquery-colorpic-js', $arrVirtualPath['Libs']. 'jQuery/Color-Picker/jquery.minicolors.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

        wp_enqueue_style( 'ore-style-global', 		$arrVirtualPath['TemplateCss']. 'global.css', '', filemtime($arrPhysicalPath['TemplateCss']. 'global.css'));

        wp_enqueue_script('listing-js', 		$arrVirtualPath['TemplateJs']. 'listing.js', array( 'jquery' ), 1, true);
        wp_localize_script( 'listing-js', 'adminAjax', array('action' => 'admin_ajax', 'admin_mod' => 'listing', 'ajaxurl_ax' => '/ajaxRequest.php', 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    }

    public function createAdminMenu(){

        global $arrVirtualPath, $arrConfig, $agentInfo;

        $baseAdminUrl= admin_url('admin.php?page='.Constants::SLUG);

        $main_menu_slug = add_menu_page('CustomWpPlugin IDX', 'CustomWpPlugin IDX', 'manage_options', Constants::SLUG, array($this, 'finalHandler'), $arrVirtualPath['TemplateImages'].'icons/home.png', 25);
        if(is_array($agentInfo) && count($agentInfo) > 0 && $agentInfo['agent_active']) {
            $arrMenu = array(
                '' => array('name' => 'Dashboard', 'icon' => 'icon2-dashboard'),
                'predefined' => array('name' => 'My Predefined Searches', 'plural_name' => 'My Predefined Searches', 'singular_name' => 'My Predefined Searches', 'icon' => 'icon2-listings'),
                //'masterpredefined' => array('name' => 'Master Predefined Searches', 'plural_name' => 'Master Predefined Searches', 'singular_name' => 'Master Predefined Searches', 'icon' => 'icon2-listings'),
//                'listings' => array('name' => 'MLS Listings', 'plural_name' => 'Listings', 'singular_name' => 'Listing', 'icon' => 'icon2-listings'),
                'user'				    =>	array('name'	=>	'Leads', 'plural_name'	=>	'Leads', 'singular_name'	=>	'Leads', 'icon'	=>	'icon2-listings'),
                'agent'   =>array('name'=>'Agent Profile' ,'icon' => 'icon2-dashboard'),
            );
        }else{
            $arrMenu = array(
                '' => array('name' => 'Dashboard', 'icon' => 'icon2-dashboard'),
            );
        }

        foreach($arrMenu as $key =>	$menuInfo)
        {
            $slug = $menuInfo['slug'] ? "-".$menuInfo['slug'] : ($key != '' ? "-".$key : "");

            $strMenu = $menuInfo['name'];
            $page = add_submenu_page(Constants::SLUG, $menuInfo['name'], $strMenu, 'manage_options', Constants::SLUG.$slug, array($this, 'finalHandler'));
            add_action('load-' . $page, array($this, 'requestHandler'));
        }
    }
    public function requestHandler() {

        # Note : Need to find some solution so that we don;t have to include this variables at all places
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;

        # Note : Need more proper checking
        $isAjaxRequest 	= ($_POST['action'] == 'admin_ajax');

        if($isAjaxRequest) {
            $strModule 	= strtolower($_POST['ajax_mod']);
        } else {
            $strModule = str_replace(Constants::SLUG. '-', '', $_GET['page']);
        }

        if(!$isAjaxRequest) {
            # Note [MS|02 August, 2013]: Need to find solution so that stylesheet get include in header, not in footer part
            wp_register_script('bootstrap-js',              $arrVirtualPath['TemplateJs']. 'bootstrap.js', array( 'jquery' ));
            wp_register_script('jquery-colorbox-js', 		$arrVirtualPath['Libs']. 'jQuery/colorbox/jquery.colorbox-min.js', array( 'jquery' ));
            wp_register_style( 'jquery-colorbox-style', 	$arrVirtualPath['Libs']. 'jQuery/colorbox/skin5/colorbox.css');
            wp_register_style( 'ore-style-default', 	$arrVirtualPath['TemplateCss']. 'style.css', '', filemtime($arrPhysicalPath['TemplateCss']. 'style.css'));
            wp_register_style( 'ore-style-popup', 		$arrVirtualPath['TemplateCss']. 'popup.css', '', filemtime($arrPhysicalPath['TemplateCss']. 'popup.css'));
            wp_register_script('jquery-admin-script', 		$arrVirtualPath['TemplateJs']. 'scripts.js', array( 'jquery' ));

            wp_enqueue_style( 'ore-style-bootstrap', 	$arrVirtualPath['TemplateCss']. 'bootstrap.css');
            wp_enqueue_style('ore-style-default');
            wp_dequeue_style( 'application_maker_style' );

            wp_enqueue_script('bootstrap-js');
            wp_enqueue_script('jquery-admin-script');

            $objTmpl->assign('baseAdminUrl', admin_url('admin.php?page='.Constants::SLUG));
        }

        switch($strModule)
        {
            # Manage Listing
            /*case 'listings';
                include_once($arrPhysicalPath['UserBase']. 'AdminListings.php');
                AdminListings::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;*/
            case 'predefined';
                include_once($arrPhysicalPath['UserBase']. 'AgentPredefined.php');
                AgentPredefined::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;
            case 'user';
                include_once($arrPhysicalPath['UserBase']. 'UserMaster.php');
                UserMaster::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;
            case 'agent';
                include_once($arrPhysicalPath['UserBase']. 'AgentProfile.php');
                AgentProfile::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;



            # Default show dashboard
            default:
                include_once($arrPhysicalPath['UserBase']. 'AdminDashboard.php');
                AdminDashboard::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;
        }

        if($isAjaxRequest) {
            die(0);

        } else {
        }
    }
    public function showInProgress() {
        global $objTmpl;

        $objTmpl->assign('T_Body', 'in-progress.tpl');
    }
    public function finalHandler() {

        global $objTmpl, $arrOREVirtualPath, $arrOREPhysicalPath, $arrOREConfig;

        # Last some common assignment
        $objTmpl->assign(array(
            'activeModule'		=> 	$strModule,
            'arrOREVirtualPath' 	=> 	$arrOREVirtualPath,
            'arrOREPhysicalPath' => 	$arrOREPhysicalPath,
            'arrOREConfig' 		=> 	$arrOREConfig,
        ));

        $objTmpl->display('default_layout.tpl');
    }
}