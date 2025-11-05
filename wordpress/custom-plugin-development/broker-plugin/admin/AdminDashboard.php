<?php
// phpinfo();
class AdminDashboard extends AdminModule {
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

        parent::requestHandler($isAjaxRequest, $moduleKey);

        $this->baseUrl = admin_url('admin.php?page='.Constants::SLUG);

        switch($this->_action)
        {
            default:
                $this->manage();
                break;
        }
    }
    public function manage() {
        global $arrPhysicalPath, $arrVirtualPath, $arrConfig, $objTmpl;
        $objApi = IDXAPI::getInstance();
        # Non-ajax request
        if(!$this->__isAjaxRequest)
        {
            $wordpress_upload_dir = wp_upload_dir();

            if(isset($_POST['Submit']) && $_POST['Submit'] == 'Update')
            {
                //echo '<pre>';print_r($_POST['OtherConfig']);exit();
                $uploadPath = $wordpress_upload_dir['basedir'].'/';
                # Upload Image & Get upload file name checked but cannot access
                if(isset($_FILES['agent_photo']['size']) && $_FILES['agent_photo']['size'] > 0)
                {
                    //$photoUrl = Utility::uploadFile($_FILES['agent_photo'], $arrPhysicalPath['UploadBase']."agent/", $_POST['prev_agent_photo']);
                    $photoUrl = Utility::uploadFile($_FILES['agent_photo'], $uploadPath, $_POST['prev_agent_photo']);
                }
                else
                {
                    $photoUrl = $_POST['prev_agent_photo'];
                }

                if(isset($_FILES['print_photo']['size']) && $_FILES['print_photo']['size'] > 0)
                {
                    $printPhotoUrl = Utility::uploadFile($_FILES['print_photo'], $uploadPath, $_POST['prev_print_photo']);
                }
                else
                {
                    $printPhotoUrl = $_POST['prev_print_photo'];
                }

                $_POST['AgentConfig']['agent_photo'] = $photoUrl;
                $_POST['AgentConfig']['print_photo'] = $printPhotoUrl;

                $arrConfig['Agent'] = $_POST['AgentConfig'];
                $arrConfig['Agent']['agent_system_name'] = 1;

	            $_POST['OtherConfig']['quick3_title'] = stripslashes($_POST['OtherConfig']['quick3_title']);

	            $_POST['OtherConfig']['quick4_title'] = stripslashes($_POST['OtherConfig']['quick4_title']);

	            $_POST['OtherConfig']['quick5_title'] = stripslashes($_POST['OtherConfig']['quick5_title']);
	            //$_POST['OtherConfig']['quick5_title_size'] = stripslashes($_POST['OtherConfig']['quick5_title_size']);

	            $_POST['OtherConfig']['qsrch_title'] = stripslashes($_POST['OtherConfig']['qsrch_title']);

                $arrConfig['OtherConfig'] = $_POST['OtherConfig'];

                # Address
                $arrConfig['Listing']['AddressFull']['Format'] = $_POST['Listing']['AddressFull'];
                $arrConfig['Listing']['AddressShort']['Format'] = $_POST['Listing']['AddressShort'];

                # Listing Limit
                $arrConfig['Listing']['ListingLimitForSale']		= $_POST['Listing']['ListingLimitForSale'];
                $arrConfig['Listing']['ListingLimitForRent']		= $_POST['Listing']['ListingLimitForRent'];

                #Listing detail page maximum viewed
                $arrConfig['Listing']['signup_required_for_view_property']	= $_POST['Listing']['signup_required_for_view_property'];
                $arrConfig['Listing']['site_max_viewed_without_login']		= $_POST['Listing']['site_max_viewed_without_login'];


                $arrConfig['Listing']['enable_google_captcha']		= $_POST['Listing']['enable_google_captcha'];
                $arrConfig['Listing']['google_site_key']		= $_POST['Listing']['google_site_key'];
                $arrConfig['Listing']['google_secret_key']		= $_POST['Listing']['google_secret_key'];
                $arrConfig['Listing']['cc_emails']		= $_POST['Listing']['cc_emails'];

                # Social Config
                $arrConfig['SocialConfig']['fb_app_id']         = $_POST['SocialConfig']['fb_app_id'];
                $arrConfig['SocialConfig']['fb_app_secret']	    = $_POST['SocialConfig']['fb_app_secret'];
                $arrConfig['SocialConfig']['gml_app_id']	    = $_POST['SocialConfig']['gml_app_id'];
                $arrConfig['SocialConfig']['gml_app_secret']    = $_POST['SocialConfig']['gml_app_secret'];

                # Search Form
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_SEARCH] 		= $_POST['PageConfig'][Constants::OPTION_PAGE_TITLE_SEARCH];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_SEARCH] 	= $_POST['PageConfig'][Constants::OPTION_PAGE_PERMALINK_SEARCH];

                # Search Result
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_SEARCH_RESULT] 	= $_POST['PageConfig'][Constants::OPTION_PAGE_TITLE_SEARCH_RESULT];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_SEARCH_RESULT] = $_POST['PageConfig'][Constants::OPTION_PAGE_PERMALINK_SEARCH_RESULT];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TEMPLATE_SEARCH_RESULT] = $_POST['PageConfig'][Constants::OPTION_PAGE_TEMPLATE_SEARCH_RESULT];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_SEARCH_RESULT] = $_POST['PageConfig'][Constants::OPTION_PAGE_SEARCH_RESULT];

                # Listing Details
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TITLE_DETAIL]['Format'] 		= $_POST['PageConfig'][Constants::OPTION_PAGE_TITLE_DETAIL];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL]['slug-1'] 	= $_POST['PageConfig'][Constants::OPTION_PAGE_PERMALINK_DETAIL]['slug-1'];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL]['slug-2'] 	= $_POST['PageConfig'][Constants::OPTION_PAGE_PERMALINK_DETAIL]['slug-2'];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL]['condo-slug-1'] 	= $_POST['PageConfig'][Constants::OPTION_PAGE_PERMALINK_DETAIL]['condo-slug-1'];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL]['condo-slug-2'] 	= $_POST['PageConfig'][Constants::OPTION_PAGE_PERMALINK_DETAIL]['condo-slug-2'];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_BROWSER_TITLE_DETAIL]['Format'] = $_POST['PageConfig'][Constants::OPTION_PAGE_BROWSER_TITLE_DETAIL];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_META_KEYWORD_DETAIL]['Format']  = $_POST['PageConfig'][Constants::OPTION_PAGE_META_KEYWORD_DETAIL];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_META_DESC_DETAIL]['Format']	  = $_POST['PageConfig'][Constants::OPTION_PAGE_META_DESC_DETAIL];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PROPERTY_MAX_VIEW_EXCEED]['Format']	  = $_POST['PageConfig'][Constants::OPTION_PAGE_PROPERTY_MAX_VIEW_EXCEED];
                $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_TEMPLATE_DETAIL]                = $_POST['PageConfig'][Constants::OPTION_PAGE_TEMPLATE_DETAIL];

                update_option(Constants::OPTIONS, $arrConfig);

                $post = $arrConfig['Agent'];
                //$post['PhotoURL'] = $arrVirtualPath['UploadBase']."agent/";
                $objApi->addDefaultAgent($post);

                wp_redirect( $this->baseUrl."&save=true" );

                exit;
            }

            wp_enqueue_script('js-jquery-validate', $arrVirtualPath['Libs']. 'jQuery/validate/jquery.validate.min.js', array( 'jquery' ));
            wp_enqueue_script('js-jquery-validate-methods', $arrVirtualPath['Libs']. 'jQuery/validate/additional-methods.js', array( 'jquery' ));

            # JQuery Input Masking
            wp_enqueue_script('js-jquery-inputmasking', $arrVirtualPath['Libs']. 'jQuery/jquery.maskedinput.min.js', array( 'jquery' ));

            wp_enqueue_style( 'jquery-colorpic-css', $arrVirtualPath['Libs']. 'jQuery/Color-Picker/jquery.minicolors.css');
            wp_enqueue_script( 'jquery-colorpic-js', $arrVirtualPath['Libs']. 'jQuery/Color-Picker/jquery.minicolors.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

            # Get the current Theme templates
            $arrThemeTemplates = wp_get_theme()->get_page_templates();

            $arrThemeTemplates = get_page_templates();
//            echo"<pre>";print_r($arrThemeTemplates);die;
            $arrThemePages = get_pages();

            #Get available shortcode

            $rsShortcode = $objApi->ViewAllShortcode('');

            if(isset($_GET['save']) && $_GET['save'] == 'true')
                $msgSuccess = "Settings has been saved successfully.";

            $uploadPath = $wordpress_upload_dir['baseurl'].'/';
            //echo '<pre>';print_r( $objApi->getMeta(array('City','SubType','SubTypeActris')));exit();
            $objTmpl->assign(array(
                'T_Body'			    =>	'dashboard.tpl',
                'arrAgentConfig'	    =>	$arrConfig['Agent'],
                'arrOtherConfig'	    =>	$arrConfig['OtherConfig'],
                'agentImgUrl'           =>  $arrVirtualPath['UploadBase']."agent/",
                'uploadPath'            =>  $uploadPath,
                'arrListingConfig'	    =>	$arrConfig['Listing'],
                'arrShortCode'	        =>	$rsShortcode,
                'arrPageConfig'		    =>	$arrConfig[Constants::OPTION_PAGE_CONFIG],
                'arrListingField'	    =>	StaticArray::arrListingField(),
                'arrYesNo'	            =>	StaticArray::arrYesNo(),
                'msgSuccess'		    =>	$msgSuccess,
                "arrThemeTemplates"	    =>	$arrThemeTemplates,
                'TemplateImages'        =>  $arrVirtualPath['TemplateImages'],
                'arrThemePages'         =>  $arrThemePages,
                'arrMeta'               =>  $objApi->getMeta(array('City','SubType','SubTypeActris')),
                'arrSocialConfig'	    =>	$arrConfig['SocialConfig'],
                'arrAgentSystemName'    =>	StaticArray::arrAgentSystemName(),
                'AgentSystemName'       =>	$arrConfig['Agent']['agent_system_name'],
            ));
        }
    }
}
?>