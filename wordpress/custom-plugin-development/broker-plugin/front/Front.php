<?php
include_once $arrPhysicalPath['UserBase']. 'ShortCodeHandler.php';

class Front
{
	private static $instance;

	private function __construct()
	{

	}

	public static function getInstance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new Front();
		}
		return self::$instance;
	}
	public function initialize()
	{


		global $arrPhysicalPath, $arrVirtualPath, $objTmpl, $arrConfig,$_COOKIE;

		$objTmpl->assign(array('Site_Url' => get_home_url().'/',));

        date_default_timezone_set('America/Chicago');


//       wp_enqueue_script('p-common', $arrVirtualPath['TemplateJs'].'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

		//wp_enqueue_script('ore-google-map','https://maps.googleapis.com/maps/api/js?libraries=drawing,geometry,places&key=AIzaSyCrAgHmWDMdpLfnIMD8CMR5CcIyHX7fOxM',array(),Constants::CSS_JS_VERSION);
		//wp_enqueue_script('p-mapsearch', $arrVirtualPath['TemplateJs'].'map-search.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
		//wp_enqueue_script('p-gmap-marker', $arrVirtualPath['TemplateJs'].'gmap-marker.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
		//wp_enqueue_script('p-jsxcompressor', $arrVirtualPath['Libs'].'jQuery/JSXCompressor/jsxcompressor.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

		add_shortcode('edit-profile', array(ShortcodeHandler::getInstance(), 'EditProfile') );
		add_shortcode('change-password', array(ShortcodeHandler::getInstance(), 'ChangePassword') );
		add_shortcode('fav-property', array(ShortcodeHandler::getInstance(), 'FavouriteProperty') );
		add_shortcode('save-search', array(ShortcodeHandler::getInstance(), 'SavedSearches') );
		add_shortcode('predefine-search-result', array(ShortcodeHandler::getInstance(), 'PredefineSearchResult') );
		add_shortcode('condo-search-result', array(ShortcodeHandler::getInstance(), 'CondoSearchResult') );
		add_shortcode('predefine-market-report', array(ShortcodeHandler::getInstance(), 'PredefineMarketReport'));
        add_action('wp_ajax_nopriv_front_ajax', array(FrontAjaxRequest::getInstance(), 'requestHandler'));
        add_action('wp_ajax_front_ajax', array(FrontAjaxRequest::getInstance(), 'requestHandler'));


		add_action( 'wp_enqueue_scripts', array($this, 'PREFIX_remove_scripts'), 1 );

        add_filter('language_attributes', array($this, 'add_opengraph_nameser'));

		add_action('wp_footer', array($this, 'insert_my_footer'));

		add_action( 'init', array($this, 'insert_cookie') );

		add_filter('wp_nav_menu_items', array($this, 'add_login_logout_link'), 10, 2);
        //shortcode request
        add_shortcode('listing-search-form', array(ShortcodeHandler::getInstance(), 'listingSearchForm') );
        add_shortcode('quick-search-form', array(ShortcodeHandler::getInstance(), 'QuickSearchForm') );
        add_shortcode('listing-search-result', array(ShortcodeHandler::getInstance(), 'listingSearchResult') );
        add_shortcode('search-form', array(ShortcodeHandler::getInstance(), 'SearchForm') );
        add_shortcode('building-data', array(ShortcodeHandler::getInstance(), 'BuildingData') );
        add_shortcode('market-report', array(ShortcodeHandler::getInstance(), 'MarketReport') );
		//	add_shortcode('listing-detail', array(ShortcodeHandler::getInstance(), 'getListingDetail') );

//        wp_localize_script( 'p-common', 'objLPTAjax', array( 'action' => 'lpt_front_ajax', 'lpt_mod' => 'consumer-tools', 'ajaxurl_as' => $arrConfig['autosugg_url'],'ajaxurl' => admin_url( 'admin-ajax.php' )));


        add_action('template_redirect', array(FrontModuleDispatcher::getInstance(), 'requestHandler'));


	}
	function insert_cookie()
	{ 
	    global $_COOKIE;
		
	}
    function PREFIX_remove_scripts() {
        global $arrVirtualPath, $arrConfig;

        # Incluse theme required common css
        wp_enqueue_style( 'ore-jquery-ui-css', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_style( 'ore-jquery-ui-theme-css', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.theme.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_style( 'p-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',array(),Constants::CSS_JS_VERSION);
        //wp_enqueue_style( 'p-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css',array(),Constants::CSS_JS_VERSION);
       // wp_enqueue_style( 'p-bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',array(),Constants::CSS_JS_VERSION);

//        wp_enqueue_style( 'css-jQuery', $arrVirtualPath['Libs']. 'jQuery/jquery-ui.css',array(),Constants::CSS_JS_VERSION);

        //search result css
        wp_register_style( 'srchresult', $arrVirtualPath['TemplateCss'].'search-results.css',array(),Constants::CSS_JS_VERSION);
        wp_register_style('ore-color-style', $arrVirtualPath['TemplateCss']. 'color.php',array(),Constants::CSS_JS_VERSION);

        wp_enqueue_style( 'p-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_style( 'p-common', $arrVirtualPath['TemplateCss']. 'common.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_style( 'p-form', $arrVirtualPath['TemplateCss']. 'form-style.css',array(),Constants::CSS_JS_VERSION);
        wp_register_style( 'p-mapsearchCSS', $arrVirtualPath['TemplateCss']. 'map-search.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_script('p-common-js', $arrVirtualPath['TemplateJs']. 'common.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        //wp_enqueue_script('p-font-awesome-js', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/fontawesome.min.js', Constants::CSS_JS_VERSION, true);
        /*wp_localize_script(	'p-common-js',
            'objMem',
            array('action' => 'front_ajax', 'mod' => Constants::TYPE_MEMBER_DETAIL, 'url' => admin_url('admin-ajax.php')));*/

	    wp_localize_script(	'p-common-js',
	                           'objMem',
	                           array('action' => 'front_ajax', 'mod' => Constants::TYPE_MEMBER_DETAIL, 'url' => admin_url('admin-ajax.php'), 'google_conv_code' => $arrConfig['OtherConfig']['google_conv_code'], 'captcha_site_key' => $arrConfig['Listing']['google_site_key']));

        //wp_enqueue_style( 'datatable-css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_style( 'datatable-css', 'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/dataTables.bootstrap4.min.css',array(),Constants::CSS_JS_VERSION);
        //wp_enqueue_script( 'datatable-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',array(),Constants::CSS_JS_VERSION);


        # Incluse theme required common js
        wp_enqueue_script('ore-ajax-request', $arrVirtualPath['Libs']. 'jQuery/jquery.oe.ajaxrequest.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        wp_enqueue_script('p-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        wp_enqueue_script('p-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        //wp_enqueue_script('p-bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        /*wp_enqueue_script('p-kit', 'https://kit.fontawesome.com/538e211a74.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);*/
        wp_enqueue_script('f-kit', $arrVirtualPath['Libs']. 'fontawesome/js/all.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        wp_enqueue_script( 'ore-jquery-scrollto', $arrVirtualPath['Libs']. 'jQuery/jquery.scrollTo-min.js', array('jquery'),Constants::CSS_JS_VERSION);
        wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs']. 'jQuery/jquery-validation-1.15.0/dist/jquery.validate.js', array( 'jquery'), Constants::CSS_JS_VERSION, true);
        wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs']. 'jQuery/jquery.maskedinput-1.2.2.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        wp_enqueue_script('ore-jquery-ui-js', $arrVirtualPath['Libs']. 'jQuery/jquery-ui-1.12.0/jquery-ui.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, false);
        wp_enqueue_style('f-kit-css', $arrVirtualPath['Libs']. 'fontawesome/css/all.css', array(), Constants::CSS_JS_VERSION, true);
        wp_enqueue_style('ore-color-style');
        // Now register your styles and scripts here

        wp_enqueue_script( 'datatable-js', 'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js',array(),Constants::CSS_JS_VERSION);
        wp_enqueue_script( 'datatable-js', 'https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/dataTables.bootstrap4.min.js',array(),Constants::CSS_JS_VERSION);

        // Highchart js
        //wp_enqueue_script('p-highchart',$arrVirtualPath['Libs'].'/jQuery/highchart/code/highcharts.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
        wp_enqueue_script('p-chart',$arrVirtualPath['Libs'].'/jQuery/chart/chart.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
    }

    function insert_my_footer() {
        $poup = '<div class="modal fade header-sign-in" id="modal-sm-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignIn" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content px-2 border-0 rounded-0">

		</div>
	</div>
</div>';
        echo $poup;
    }

    function add_login_logout_link($items, $args)
    {

        global $arrConfig;

        ob_start();

        if($arrConfig['OtherConfig']['login_enable'] == 'Yes')
        {
            if (is_user_logged_in()) {
                $link = get_home_url() . '/myaccount';
                $logout = wp_logout_url(get_home_url());
                $loginoutlink = '<li class="nav-item dropdown">
        <a class="nav-link -dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">My Account</a>
        <div class="dropdown-menu myaccount-dropdown">
          <a class="dropdown-item" href="' . $link . '">DashBoard</a>
          <a class="dropdown-item" href="' . $logout . '">Logout</a>
       
        </div>
      </li>';
            } else {
                $link = get_home_url() . '/' . Constants::TYPE_MEMBER_DETAIL . '/?action=member-login';
                $member_register_link = get_home_url() . '/' . Constants::TYPE_MEMBER_DETAIL . '/?action=member-register';
                $loginoutlink = '<li><a class="popup-modal-sm memberSignup hideLogin" data-target="MemberLogin" data-url="' . $link . '" href="JavaScript:void(0);" role="button">Log In</a></li>';
                $signinoutlink = '<li><a class="popup-modal-sm memberSignup hideLogin d-none member-register-modal" data-target="MemberRegister" data-url="' . $member_register_link . '" href="JavaScript:void(0);" role="button">Sign Up</a></li>';
            }
        }

        ob_end_clean();
        $items .= $loginoutlink;
        $items .= $signinoutlink;
        return $items;
    }

    function add_opengraph_nameser( $output ) {
        return $output . '
xmlns:og="https://opengraphprotocol.org/schema/"
xmlns:fb="https://www.facebook.com/2008/fbml"';
    }
}
?>