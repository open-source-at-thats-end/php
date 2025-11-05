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
        global $arrPhysicalPath, $arrVirtualPath;

        # Add menu
        add_action('admin_menu', array($this, 'createAdminMenu'));

//        add_action('wp_ajax_admin_ajax', array($this, 'requestHandler'));

        add_action('wp_ajax_nopriv_admin_ajax', array(AdminAjaxRequest::getInstance(), 'requestHandler'));
        add_action('wp_ajax_admin_ajax', array(AdminAjaxRequest::getInstance(), 'requestHandler'));

        # if this enable, it will called from other plugin too
        add_action('admin_head', array($this, 'requestHandler3'));
        # Adds functionality to the text editor for pages and posts
        # Add buttons to text editor and initialize short codes
        add_action('admin_init', array(TinyMceManager::getInstance(), "addButtons") );

        # add one more params to identify multi upload
        if (!empty($_FILES) && isset($_POST['is_multiupload'])) {do_action('wp_ajax_admin_ajax');}

    }
    public function requestHandler3(){

        global $arrVirtualPath, $arrPhysicalPath;

        wp_dequeue_style( 'application_maker_style' );

        wp_enqueue_style( 'ore-jquery-ui-css', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_style( 'ore-jquery-ui-theme-css', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.theme.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_script( 'ajax-request', $arrVirtualPath['Libs']. 'jQuery/jquery.oe.ajaxrequest.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

        wp_enqueue_script('ore-jquery-ui-js', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, false);
        wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-1.4.1.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, false);

        wp_enqueue_style( 'ore-style-global', 		$arrVirtualPath['TemplateCss']. 'global.css', '', filemtime($arrPhysicalPath['TemplateCss']. 'global.css'));

        wp_enqueue_script('listing-js', 		$arrVirtualPath['TemplateJs']. 'listing.js', array( 'jquery' ), 1, true);
        wp_localize_script( 'listing-js', 'adminAjax', array('action' => 'admin_ajax', 'admin_mod' => 'listing', 'ajaxurl_ax' => '/ajaxRequest.php', 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    }
    public function createAdminMenu(){

        global $arrVirtualPath, $arrConfig;

        $baseAdminUrl= admin_url('admin.php?page='.Constants::SLUG);

        $main_menu_slug = add_menu_page('Loopt IDX', 'Loopt IDX', 'manage_options', Constants::SLUG, array($this, 'finalHandler'), $arrVirtualPath['TemplateImages'].'icons/home.png', 25);

        $arrMenu = array(
            ''						=>	array('name'	=>	'Dashboard', 'icon'	=>	'icon2-dashboard'),
            'agent'				    =>	array('name'	=>	'Agent Master', 'plural_name'	=>	'Agents', 'singular_name'	=>	'Agent', 'icon'	=>	'icon2-listings'),
            'user'				    =>	array('name'	=>	'Contacts', 'plural_name'	=>	'Contacts', 'singular_name'	=>	'Contacts', /*'slug'	=> 'user', */'icon'	=>	'icon2-listings'),
            'predefined'		    =>	array('name'	=>	'Manage Predefined Searches', 'plural_name'	=>	'Manage Predefined Searches', 'singular_name'	=>	'Manage Predefined Searches', 'icon'	=>	'icon2-listings'),
            'condo'		            =>	array('name'	=>	'Manage Condo Searches', 'plural_name'	=>	'Manage Condo Searches', 'singular_name'	=>	'Manage Condo Searches', 'icon'	=>	'icon2-listings'),
            'listings'				=>	array('name'	=>	'MLS Listings', 'plural_name'	=>	'Listings', 'singular_name'	=>	'Listing', 'icon'	=>	'icon2-listings'),
//            'market-report'			=>	array('name'	=>	'Manage Market Reports', 'plural_name'	=>	'Market Reports', 'singular_name'	=>	'Market Reports', 'icon'	=>	'icon2-listings'),
//            'shortcode'				=>	array('name'	=>	'Manage Shortcode', 'plural_name'	=>	'Shortcode', 'singular_name'	=>	'Shortcode', 'icon'	=>	'icon2-listings'),
            'broker'				=>	array('name'	=>	'Broker Office', 'plural_name'	=>	'Broker Office', 'singular_name'	=>	'Broker Office', 'icon'	=>	'icon2-listings'),
            'agent-info'			=>	array('name'	=>	'Agent Info', 'plural_name'	=>	'Agent Info', 'singular_name'	=>	'Agent Info', 'icon'	=>	'icon2-listings'),
            'development'			=>	array('name'	=>	'Development', 'plural_name'	=>	'Development', 'singular_name'	=>	'Development', 'icon'	=>	'icon2-listings'),

        );

        foreach($arrMenu as $key =>	$menuInfo)
        {
            $slug = $menuInfo['slug'] ? "-".$menuInfo['slug'] : ($key != '' ? "-".$key : "");

            $strMenu = $menuInfo['name'];

            $page = add_submenu_page(Constants::SLUG, $menuInfo['name'], $strMenu, 'manage_options', Constants::SLUG.$slug, array($this, 'finalHandler'));
            add_action('load-' . $page, array($this, 'requestHandler'));
        }

        # Contacts module submenus
        $sub_menu_all_contacts = add_submenu_page('-user', 'All Contacts', 'All Contacts', 'manage_options', Constants::SLUG.'-user', array($this, 'finalHandler'));
        add_action('load-' . $sub_menu_all_contacts, array($this, 'requestHandler'));

        $sub_menu_hot_leads = add_submenu_page('-user', 'Hot Leads', 'Hot Leads', 'manage_options', Constants::SLUG.'-hot-leads', array($this, 'finalHandler'));
        add_action('load-' . $sub_menu_hot_leads, array($this, 'requestHandler'));

        $sub_menu_opportunity = add_submenu_page('-user', 'Opportunity', 'Opportunity', 'manage_options', Constants::SLUG.'-opportunity', array($this, 'finalHandler'));
        add_action('load-' . $sub_menu_opportunity, array($this, 'requestHandler'));
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

            $HostUrl = /*$_SERVER['HTTP_HOST'].*/$_SERVER['SCRIPT_NAME'];
            wp_localize_script( 'jquery-admin-script', 'HostUrl', $HostUrl );

            wp_enqueue_style( 'ore-style-bootstrap', 	$arrVirtualPath['TemplateCss']. 'bootstrap.css');
            wp_enqueue_style('ore-style-default');
            wp_dequeue_style( 'application_maker_style' );

            wp_enqueue_script('bootstrap-js');
            wp_enqueue_script('jquery-admin-script');

            $objTmpl->assign('baseAdminUrl', admin_url('admin.php?page='.Constants::SLUG));
        }

	    if($strModule != '')
	    {
		    add_action( 'wp_enqueue_scripts', '_remove_style', PHP_INT_MAX );
		    function _remove_style() {
			    wp_dequeue_style( 'yasrcss' );
		    }
		    /* Theme css */
		    wp_enqueue_style( 'ore-material-css', $arrVirtualPath['Libs']. 'assets/vendors/mdi/css/materialdesignicons.min.css',array(),Constants::CSS_JS_VERSION);
		    wp_enqueue_style( 'ore-bundle-ui-css', $arrVirtualPath['Libs']. 'assets/vendors/css/vendor.bundle.base.css',array(),Constants::CSS_JS_VERSION);
		    wp_enqueue_style( 'ore-style-ui-css', $arrVirtualPath['Libs']. 'assets/css/style.css',array(),Constants::CSS_JS_VERSION);

		    /* Theme JS */
		    wp_enqueue_script('ore-bundle-ui-js', $arrVirtualPath['Libs']. 'assets/vendors/js/vendor.bundle.base.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
		    wp_enqueue_script('ore-canvas-ui-js', $arrVirtualPath['Libs']. 'assets/js/off-canvas.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
		    wp_enqueue_script('ore-hoverable-ui-js', $arrVirtualPath['Libs']. 'assets/js/hoverable-collapse.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
		    wp_enqueue_script('ore-misc-ui-js', $arrVirtualPath['Libs']. 'assets/js/misc.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
	    }
        switch($strModule)
        {
            # Manage Listing
            case 'listings';
                include_once($arrPhysicalPath['UserBase']. 'AdminListings.php');
                AdminListings::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # Manage agent
            case 'agent';
                include_once($arrPhysicalPath['UserBase']. 'AdminAgent.php');
                AdminAgent::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # Manage shortcode
            case 'shortcode';
                include_once($arrPhysicalPath['UserBase']. 'AdminShortCode.php');
                AdminShortCode::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # Manage user
            case 'user':
            case 'hot-leads':
            case 'opportunity':
                include_once($arrPhysicalPath['UserBase']. 'UserMaster.php');
                UserMaster::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # Manage predefined
            case 'predefined';
                include_once($arrPhysicalPath['UserBase']. 'AdminPredefined.php');
                AdminPredefined::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # broker office codes
            case 'broker';
                include_once($arrPhysicalPath['UserBase']. 'AdminBroker.php');
                AdminBroker::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # agent codes
            case 'agent-info';
                include_once($arrPhysicalPath['UserBase']. 'AgentCodes.php');
                AgentCodes::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # Manage condo
            case 'condo';
                include_once($arrPhysicalPath['UserBase']. 'AdminCondo.php');
                AdminCondo::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;

            # Manage Market Reports
            /*case 'market-report';
                include_once($arrPhysicalPath['UserBase']. 'AdminMarketReports.php');
                AdminMarketReports::getInstance()->requestHandler($isAjaxRequest, $strModule);
                break;*/

            # Manage development
            case 'development';
                include_once($arrPhysicalPath['UserBase']. 'AdminDevelopment.php');
                AdminDevelopment::getInstance()->requestHandler($isAjaxRequest, $strModule);
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