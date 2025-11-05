<?php
if(!class_exists('Installer')){

    class Installer{
        private static $instance ;

        private function __construct(){
        }

        public static function getInstance(){
            if( !isset(self::$instance)){
                self::$instance = new Installer();
            }
            return self::$instance;
        }

        /**
         * Function installs the CustomWpPlugin plugin
         * and initializes rewrite rules.
         */
        public function install() {

            global $arrPhysicalPath, $wpdb;

            $DBFile = $arrPhysicalPath['Install']."db_create.sql";

            $strFileContent = file_get_contents($DBFile);

            $arrQuery = explode(";", $strFileContent);

            $wpdb->show_errors();

            $tablePrefix = "wp_";

            foreach($arrQuery as $key => $query)
            {
                if(!empty($query))
                {
                    ## NOTE : REplace database prefix, with current prefix set
                    $query = str_replace($tablePrefix, $wpdb->prefix, $query);
                    $wpdb->query($query);
                }
            }

            # Create required config
            $DBFile = $arrPhysicalPath['Install']."db_create_config.sql";

            $query_config = file_get_contents($DBFile);
            # Address

            /*$query = $query_config;

            $wpdb->query($query);*/

            $this->CustomWpPlugin_install_custom_pages();

        }
        public function update() {

            global $arrPhysicalPath, $wpdb;

            if (!get_option( '_lpt_is_updated_page' )) {

                $required_page = array();
                $required_page[] = array('slug' => 'terms-of-service', 'name' => __('Terms of Service ', 'lpt'), 'content' => '' );

                foreach ($required_page as $page_) {
                    if (!$this->CustomWpPlugin_is_page_exists($page_['slug'])) {
                        $this->CustomWpPlugin_insert_custom_page($page_);

                    }
                }

                $arrConfig = get_option(Constants::OPTIONS);

                $arrConfig['SocialConfig']['fb_app_id']         = '1822000924629721';
                $arrConfig['SocialConfig']['fb_app_secret']	    = 'e887a9f0d9f1d5c006fc911745cff414';
                $arrConfig['SocialConfig']['gml_app_id']	    = '565814697713-gskt3tgotpv9a6asevrfl5b85j150h6c.apps.googleusercontent.com';
                $arrConfig['SocialConfig']['gml_app_secret']    = 'yaBxIIZw3hXzyvffe3C8F90h';

                update_option(Constants::OPTIONS, $arrConfig);

            }
            $arrConfig = get_option(Constants::OPTIONS);

            $arrConfig['OtherConfig']['btn_color']= (isset($arrConfig['OtherConfig']['btn_color']) && $arrConfig['OtherConfig']['btn_color'] != '') ? ($arrConfig['OtherConfig']['btn_color']) :'#3a3a3a';
            $arrConfig['OtherConfig']['btn_txt_color']= (isset($arrConfig['OtherConfig']['btn_txt_color']) && $arrConfig['OtherConfig']['btn_txt_color'] != '') ? ($arrConfig['OtherConfig']['btn_txt_color']) :'#ffffff';
            $arrConfig['OtherConfig']['heading_txt_color']= (isset($arrConfig['OtherConfig']['heading_txt_color']) && $arrConfig['OtherConfig']['heading_txt_color'] != '') ? ($arrConfig['OtherConfig']['heading_txt_color']) :'#333333';
            $arrConfig['OtherConfig']['text_color']= (isset($arrConfig['OtherConfig']['text_color']) && $arrConfig['OtherConfig']['text_color'] != '') ? ($arrConfig['OtherConfig']['text_color']) :'#212529';
            $arrConfig['OtherConfig']['link_color']= (isset($arrConfig['OtherConfig']['link_color']) && $arrConfig['OtherConfig']['link_color'] != '') ? ($arrConfig['OtherConfig']['link_color']) :'#0261df';
            $arrConfig['OtherConfig']['main_font_family']= (isset($arrConfig['OtherConfig']['main_font_family']) && $arrConfig['OtherConfig']['main_font_family'] != '') ? ($arrConfig['OtherConfig']['main_font_family']) :'';
            $arrConfig['OtherConfig']['login_enable']= (isset($arrConfig['OtherConfig']['login_enable']) && $arrConfig['OtherConfig']['login_enable'] != '') ? ($arrConfig['OtherConfig']['login_enable']) :'';
            $arrConfig['OtherConfig']['qsrch_title']= (isset($arrConfig['OtherConfig']['qsrch_title']) && $arrConfig['OtherConfig']['qsrch_title'] != '') ? ($arrConfig['OtherConfig']['qsrch_title']) :'';
            $arrConfig['OtherConfig']['qsrch_title_size']= (isset($arrConfig['OtherConfig']['qsrch_title_size']) && $arrConfig['OtherConfig']['qsrch_title_size'] != '') ? ($arrConfig['OtherConfig']['qsrch_title_size']) :39;
            $arrConfig['OtherConfig']['qsrch_title_style']= (isset($arrConfig['OtherConfig']['qsrch_title_style']) && $arrConfig['OtherConfig']['qsrch_title_style'] != '') ? ($arrConfig['OtherConfig']['qsrch_title_style']) :'';
            $arrConfig['OtherConfig']['qsrch_title_align']= (isset($arrConfig['OtherConfig']['qsrch_title_align']) && $arrConfig['OtherConfig']['qsrch_title_align'] != '') ? ($arrConfig['OtherConfig']['qsrch_title_align']) :'left';
            $arrConfig['OtherConfig']['google_conv_code']= (isset($arrConfig['OtherConfig']['google_conv_code']) && $arrConfig['OtherConfig']['google_conv_code'] != '') ? ($arrConfig['OtherConfig']['google_conv_code']) :'';
            $arrConfig['OtherConfig']['google_manage_code']= (isset($arrConfig['OtherConfig']['google_manage_code']) && $arrConfig['OtherConfig']['google_manage_code'] != '') ? ($arrConfig['OtherConfig']['google_manage_code']) :'';
            $arrConfig['OtherConfig']['style8_view_page_url']= (isset($arrConfig['OtherConfig']['style8_view_page_url']) && $arrConfig['OtherConfig']['style8_view_page_url'] != '') ? ($arrConfig['OtherConfig']['style8_view_page_url']) :'';
            $arrConfig['OtherConfig']['quick_head_title']= (isset($arrConfig['OtherConfig']['quick_head_title']) && $arrConfig['OtherConfig']['quick_head_title'] != '') ? ($arrConfig['OtherConfig']['quick_head_title']) :55;
            $arrConfig['OtherConfig']['quick_sub_title']= (isset($arrConfig['OtherConfig']['quick_sub_title']) && $arrConfig['OtherConfig']['quick_sub_title'] != '') ? ($arrConfig['OtherConfig']['quick_sub_title']) :55;
            $arrConfig['OtherConfig']['quick_style']= (isset($arrConfig['OtherConfig']['quick_style']) && $arrConfig['OtherConfig']['quick_style'] != '') ? ($arrConfig['OtherConfig']['quick_style']) :'';
            $arrConfig['OtherConfig']['quick_font_family']= (isset($arrConfig['OtherConfig']['quick_font_family']) && $arrConfig['OtherConfig']['quick_font_family'] != '') ? ($arrConfig['OtherConfig']['quick_font_family']) :'';
            $arrConfig['OtherConfig']['quick_font_size']= (isset($arrConfig['OtherConfig']['quick_font_size']) && $arrConfig['OtherConfig']['quick_font_size'] != '') ? ($arrConfig['OtherConfig']['quick_font_size']) :'';
            $arrConfig['OtherConfig']['quick_text_color']= (isset($arrConfig['OtherConfig']['quick_text_color']) && $arrConfig['OtherConfig']['quick_text_color'] != '') ? ($arrConfig['OtherConfig']['quick_text_color']) :'#fff';
            $arrConfig['OtherConfig']['quick_btn_color']= (isset($arrConfig['OtherConfig']['quick_btn_color']) && $arrConfig['OtherConfig']['quick_btn_color'] != '') ? ($arrConfig['OtherConfig']['quick_btn_color']) :'#000';
            $arrConfig['OtherConfig']['quick2_head_title']= (isset($arrConfig['OtherConfig']['quick2_head_title']) && $arrConfig['OtherConfig']['quick2_head_title'] != '') ? ($arrConfig['OtherConfig']['quick2_head_title']) :27;
            $arrConfig['OtherConfig']['quick2_sub_title']= (isset($arrConfig['OtherConfig']['quick2_sub_title']) && $arrConfig['OtherConfig']['quick2_sub_title'] != '') ? ($arrConfig['OtherConfig']['quick2_sub_title']) :27;
            $arrConfig['OtherConfig']['quick2_style']= (isset($arrConfig['OtherConfig']['quick2_style']) && $arrConfig['OtherConfig']['quick2_style'] != '') ? ($arrConfig['OtherConfig']['quick2_style']) :'';
            $arrConfig['OtherConfig']['quick3_text_style']= (isset($arrConfig['OtherConfig']['quick3_text_style']) && $arrConfig['OtherConfig']['quick3_text_style'] != '') ? ($arrConfig['OtherConfig']['quick3_text_style']) :'';
            $arrConfig['OtherConfig']['quick3_title']= (isset($arrConfig['OtherConfig']['quick3_title']) && $arrConfig['OtherConfig']['quick3_title'] != '') ? ($arrConfig['OtherConfig']['quick3_title']) :'';
            $arrConfig['OtherConfig']['quick3_title_size']= (isset($arrConfig['OtherConfig']['quick3_title_size']) && $arrConfig['OtherConfig']['quick3_title_size'] != '') ? ($arrConfig['OtherConfig']['quick3_title_size']) :39;
            $arrConfig['OtherConfig']['quick3_title_style']= (isset($arrConfig['OtherConfig']['quick3_title_style']) && $arrConfig['OtherConfig']['quick3_title_style'] != '') ? ($arrConfig['OtherConfig']['quick3_title_style']) :'';
            $arrConfig['OtherConfig']['quick4_title']= (isset($arrConfig['OtherConfig']['quick4_title']) && $arrConfig['OtherConfig']['quick4_title'] != '') ? ($arrConfig['OtherConfig']['quick4_title']) :'';
            $arrConfig['OtherConfig']['quick4_title_size']= (isset($arrConfig['OtherConfig']['quick4_title_size']) && $arrConfig['OtherConfig']['quick4_title_size'] != '') ? ($arrConfig['OtherConfig']['quick4_title_size']) :39;
            $arrConfig['OtherConfig']['quick4_title_style']= (isset($arrConfig['OtherConfig']['quick4_title_style']) && $arrConfig['OtherConfig']['quick4_title_style'] != '') ? ($arrConfig['OtherConfig']['quick4_title_style']) :'';
            $arrConfig['OtherConfig']['quick5_title']= (isset($arrConfig['OtherConfig']['quick5_title']) && $arrConfig['OtherConfig']['quick5_title'] != '') ? ($arrConfig['OtherConfig']['quick5_title']) :'';
            $arrConfig['OtherConfig']['quick5_title_size']= (isset($arrConfig['OtherConfig']['quick5_title_size']) && $arrConfig['OtherConfig']['quick5_title_size'] != '') ? ($arrConfig['OtherConfig']['quick5_title_size']) :39;
            $arrConfig['OtherConfig']['quick5_title_style']= (isset($arrConfig['OtherConfig']['quick5_title_style']) && $arrConfig['OtherConfig']['quick5_title_style'] != '') ? ($arrConfig['OtherConfig']['quick5_title_style']) :'';
            $arrConfig['OtherConfig']['style9_text_color']= (isset($arrConfig['OtherConfig']['style9_text_color']) && $arrConfig['OtherConfig']['style9_text_color'] != '') ? ($arrConfig['OtherConfig']['style9_text_color']) :'#000';
            $arrConfig['OtherConfig']['style9_bdr_color']= (isset($arrConfig['OtherConfig']['style9_bdr_color']) && $arrConfig['OtherConfig']['style9_bdr_color'] != '') ? ($arrConfig['OtherConfig']['style9_bdr_color']) :'#000';
            $arrConfig['OtherConfig']['style9_bg_color']= (isset($arrConfig['OtherConfig']['style9_bg_color']) && $arrConfig['OtherConfig']['style9_bg_color'] != '') ? ($arrConfig['OtherConfig']['style9_bg_color']) :'#ffffff00';
            $arrConfig['OtherConfig']['style9_bdr_hvr_color']= (isset($arrConfig['OtherConfig']['style9_bdr_hvr_color']) && $arrConfig['OtherConfig']['style9_bdr_hvr_color'] != '') ? ($arrConfig['OtherConfig']['style9_bdr_hvr_color']) :'#000';
            $arrConfig['OtherConfig']['style9_bg_hvr_color']= (isset($arrConfig['OtherConfig']['style9_bg_hvr_color']) && $arrConfig['OtherConfig']['style9_bg_hvr_color'] != '') ? ($arrConfig['OtherConfig']['style9_bg_hvr_color']) :'#ffff';
            $arrConfig['OtherConfig']['style12_text_light']= (isset($arrConfig['OtherConfig']['style12_text_light']) && $arrConfig['OtherConfig']['style12_text_light'] != '') ? ($arrConfig['OtherConfig']['style12_text_light']) :'#fff';
            $arrConfig['OtherConfig']['style12_font_family_light']= (isset($arrConfig['OtherConfig']['style12_font_family_light']) && $arrConfig['OtherConfig']['style12_font_family_light'] != '') ? ($arrConfig['OtherConfig']['style12_font_family_light']) :'';
            $arrConfig['OtherConfig']['style12_font_size_light']= (isset($arrConfig['OtherConfig']['style12_font_size_light']) && $arrConfig['OtherConfig']['style12_font_size_light'] != '') ? ($arrConfig['OtherConfig']['style12_font_size_light']) :'';
            $arrConfig['OtherConfig']['style12_text_dark']= (isset($arrConfig['OtherConfig']['style12_text_dark']) && $arrConfig['OtherConfig']['style12_text_dark'] != '') ? ($arrConfig['OtherConfig']['style12_text_dark']) :'#000';
            $arrConfig['OtherConfig']['style12_font_family_dark']= (isset($arrConfig['OtherConfig']['style12_font_family_dark']) && $arrConfig['OtherConfig']['style12_font_family_dark'] != '') ? ($arrConfig['OtherConfig']['style12_font_family_dark']) :'';
            $arrConfig['OtherConfig']['style12_font_size_dark']= (isset($arrConfig['OtherConfig']['style12_font_size_dark']) && $arrConfig['OtherConfig']['style12_font_size_dark'] != '') ? ($arrConfig['OtherConfig']['style12_font_size_dark']) :'';
            $arrConfig['OtherConfig']['pre_market_light']= (isset($arrConfig['OtherConfig']['pre_market_light']) && $arrConfig['OtherConfig']['pre_market_light'] != '') ? ($arrConfig['OtherConfig']['pre_market_light']) :'#fff';
            $arrConfig['OtherConfig']['market_border_light']= (isset($arrConfig['OtherConfig']['market_border_light']) && $arrConfig['OtherConfig']['market_border_light'] != '') ? ($arrConfig['OtherConfig']['market_border_light']) :'#dee2e6';
            $arrConfig['OtherConfig']['pre_market_dark']= (isset($arrConfig['OtherConfig']['pre_market_dark']) && $arrConfig['OtherConfig']['pre_market_dark'] != '') ? ($arrConfig['OtherConfig']['pre_market_dark']) :'#000';
            $arrConfig['OtherConfig']['market_border_dark']= (isset($arrConfig['OtherConfig']['market_border_dark']) && $arrConfig['OtherConfig']['market_border_dark'] != '') ? ($arrConfig['OtherConfig']['market_border_dark']) :'#dee2e6';

            if (!get_option('_lpt_is_updated_condo_slug'))
            {
                $arrConfig = get_option(Constants::OPTIONS);

                $arrConfig['page-config']['page-permalink-text-detail']['condo-slug-1'] = 'CityName-properties';
                $arrConfig['page-config']['page-permalink-text-detail']['condo-slug-2'] = 'StreetNumber-StreetDirPrefix-StreetName-UnitNo-Subdivision-CityName-State-ZipCode';

                update_option(Constants::OPTIONS, $arrConfig);

            }

            update_option( '_lpt_is_updated_page', 1 );
            update_option( '_lpt_is_updated_condo_slug', 1 );

            # Update required queries
            $DBFile = $arrPhysicalPath['Install']."db_update.sql";

            $strFileContent = file_get_contents($DBFile);

            $arrQuery = explode(";", $strFileContent);

            $wpdb->show_errors();

            $tablePrefix = "wp_";

            foreach($arrQuery as $key => $query)
            {
                if(!empty($query))
                {
                    ## NOTE : REplace database prefix, with current prefix set
                    $query = str_replace($tablePrefix, $wpdb->prefix, $query);
                    $wpdb->query($query);
                }
            }
        }
        public function CustomWpPlugin_install_custom_pages(){
            if (!get_option( '_lpt_is_added_paged' )) {
                $required_page = array();
                $required_page[] = array('slug' => 'property-search', 'name' => __('Property Search', 'lpt'), 'content' => '[listing-search-form][listing-search-result]' );
                $required_page[] = array('slug' => 'privacy-policy', 'name' => __('Privacy Policy', 'lpt'), 'content' => '' );
                $required_page[] = array('slug' => 'terms-of-use', 'name' => __('Terms of Use ', 'lpt'), 'content' => '' );

                foreach ($required_page as $page_) {
                    if (!$this->CustomWpPlugin_is_page_exists($page_['slug'])) {
                         $this->CustomWpPlugin_insert_custom_page($page_);

                    }
                }

                $arrConfig['Listing']['AddressFull']['Format'] = 'UnitNo StreetNumber StreetName, Subdivision, CityName, State- ZipCode';
                $arrConfig['Listing']['AddressShort']['Format'] = 'StreetNumber StreetDirPrefix StreetName, UnitNo';

                $arrConfig['page-config']['page-title-search'] = 'Property Search';
                $arrConfig['page-config']['page-permalink-text-search'] = 'homes-search';
                $arrConfig['page-config']['page-title-search-result'] = 'Search Results';
                $arrConfig['page-config']['page-permalink-text-search-result'] = 'property-results';
                $arrConfig['page-config']['page-template-search-result'] = '';
                $page = get_page_by_path('property-search');
                $arrConfig['page-config']['page-search-result'] = $page->ID;
                $arrConfig['page-config']['page-title-detail']['Format'] = 'UnitNo StreetNumber StreetDirPrefix StreetName, CityName, State, ZipCode | Subdivision REALTOR®';
                $arrConfig['page-config']['page-permalink-text-detail']['slug-1'] = 'CityName-properties';
                $arrConfig['page-config']['page-permalink-text-detail']['slug-2'] = 'UnitNo-StreetNumber-StreetDirPrefix-StreetName-Subdivision-CityName-State-ZipCode';
                $arrConfig['page-config']['page-browser-title-detail']['Format'] = 'MLS# MLS_NUM';
                $arrConfig['page-config']['page-metakeyword-detail']['Format'] = 'UnitNo StreetNumber StreetName, CityName, State, ZipCode | Subdivision REALTOR®';
                $arrConfig['page-config']['page-metadesc-detail']['Format'] = 'Description';
                $arrConfig['page-config']['page-permalink-text-detail']['condo-slug-1'] = 'CityName-properties';
                $arrConfig['page-config']['page-permalink-text-detail']['condo-slug-2'] = 'StreetNumber-StreetDirPrefix-StreetName-UnitNo-Subdivision-CityName-State-ZipCode';

                $arrConfig = get_option(Constants::OPTIONS);

                $arrConfig['OtherConfig']['btn_color']= (isset($arrConfig['OtherConfig']['btn_color']) && $arrConfig['OtherConfig']['btn_color'] != '') ? ($arrConfig['OtherConfig']['btn_color']) :'#3a3a3a';
                $arrConfig['OtherConfig']['btn_txt_color']= (isset($arrConfig['OtherConfig']['btn_txt_color']) && $arrConfig['OtherConfig']['btn_txt_color'] != '') ? ($arrConfig['OtherConfig']['btn_txt_color']) :'#ffffff';
                $arrConfig['OtherConfig']['heading_txt_color']= (isset($arrConfig['OtherConfig']['heading_txt_color']) && $arrConfig['OtherConfig']['heading_txt_color'] != '') ? ($arrConfig['OtherConfig']['heading_txt_color']) :'#333333';
                $arrConfig['OtherConfig']['text_color']= (isset($arrConfig['OtherConfig']['text_color']) && $arrConfig['OtherConfig']['text_color'] != '') ? ($arrConfig['OtherConfig']['text_color']) :'#212529';
                $arrConfig['OtherConfig']['link_color']= (isset($arrConfig['OtherConfig']['link_color']) && $arrConfig['OtherConfig']['link_color'] != '') ? ($arrConfig['OtherConfig']['link_color']) :'#0261df';
                $arrConfig['OtherConfig']['main_font_family']= (isset($arrConfig['OtherConfig']['main_font_family']) && $arrConfig['OtherConfig']['main_font_family'] != '') ? ($arrConfig['OtherConfig']['main_font_family']) :'';
                $arrConfig['OtherConfig']['login_enable']= (isset($arrConfig['OtherConfig']['login_enable']) && $arrConfig['OtherConfig']['login_enable'] != '') ? ($arrConfig['OtherConfig']['login_enable']) :'';
                $arrConfig['OtherConfig']['qsrch_title']= (isset($arrConfig['OtherConfig']['qsrch_title']) && $arrConfig['OtherConfig']['qsrch_title'] != '') ? ($arrConfig['OtherConfig']['qsrch_title']) :'';
                $arrConfig['OtherConfig']['qsrch_title_size']= (isset($arrConfig['OtherConfig']['qsrch_title_size']) && $arrConfig['OtherConfig']['qsrch_title_size'] != '') ? ($arrConfig['OtherConfig']['qsrch_title_size']) :39;
                $arrConfig['OtherConfig']['qsrch_title_style']= (isset($arrConfig['OtherConfig']['qsrch_title_style']) && $arrConfig['OtherConfig']['qsrch_title_style'] != '') ? ($arrConfig['OtherConfig']['qsrch_title_style']) :'';
                $arrConfig['OtherConfig']['qsrch_title_align']= (isset($arrConfig['OtherConfig']['qsrch_title_align']) && $arrConfig['OtherConfig']['qsrch_title_align'] != '') ? ($arrConfig['OtherConfig']['qsrch_title_align']) :'left';
                $arrConfig['OtherConfig']['google_conv_code']= (isset($arrConfig['OtherConfig']['google_conv_code']) && $arrConfig['OtherConfig']['google_conv_code'] != '') ? ($arrConfig['OtherConfig']['google_conv_code']) :'';
                $arrConfig['OtherConfig']['google_manage_code']= (isset($arrConfig['OtherConfig']['google_manage_code']) && $arrConfig['OtherConfig']['google_manage_code'] != '') ? ($arrConfig['OtherConfig']['google_manage_code']) :'';
                $arrConfig['OtherConfig']['style8_view_page_url']= (isset($arrConfig['OtherConfig']['style8_view_page_url']) && $arrConfig['OtherConfig']['style8_view_page_url'] != '') ? ($arrConfig['OtherConfig']['style8_view_page_url']) :'';
                $arrConfig['OtherConfig']['quick_head_title']= (isset($arrConfig['OtherConfig']['quick_head_title']) && $arrConfig['OtherConfig']['quick_head_title'] != '') ? ($arrConfig['OtherConfig']['quick_head_title']) :55;
                $arrConfig['OtherConfig']['quick_sub_title']= (isset($arrConfig['OtherConfig']['quick_sub_title']) && $arrConfig['OtherConfig']['quick_sub_title'] != '') ? ($arrConfig['OtherConfig']['quick_sub_title']) :55;
                $arrConfig['OtherConfig']['quick_style']= (isset($arrConfig['OtherConfig']['quick_style']) && $arrConfig['OtherConfig']['quick_style'] != '') ? ($arrConfig['OtherConfig']['quick_style']) :'';
                $arrConfig['OtherConfig']['quick_font_family']= (isset($arrConfig['OtherConfig']['quick_font_family']) && $arrConfig['OtherConfig']['quick_font_family'] != '') ? ($arrConfig['OtherConfig']['quick_font_family']) :'';
                $arrConfig['OtherConfig']['quick_font_size']= (isset($arrConfig['OtherConfig']['quick_font_size']) && $arrConfig['OtherConfig']['quick_font_size'] != '') ? ($arrConfig['OtherConfig']['quick_font_size']) :'';
                $arrConfig['OtherConfig']['quick_text_color']= (isset($arrConfig['OtherConfig']['quick_text_color']) && $arrConfig['OtherConfig']['quick_text_color'] != '') ? ($arrConfig['OtherConfig']['quick_text_color']) :'#fff';
                $arrConfig['OtherConfig']['quick_btn_color']= (isset($arrConfig['OtherConfig']['quick_btn_color']) && $arrConfig['OtherConfig']['quick_btn_color'] != '') ? ($arrConfig['OtherConfig']['quick_btn_color']) :'#000';
                $arrConfig['OtherConfig']['quick2_head_title']= (isset($arrConfig['OtherConfig']['quick2_head_title']) && $arrConfig['OtherConfig']['quick2_head_title'] != '') ? ($arrConfig['OtherConfig']['quick2_head_title']) :27;
                $arrConfig['OtherConfig']['quick2_sub_title']= (isset($arrConfig['OtherConfig']['quick2_sub_title']) && $arrConfig['OtherConfig']['quick2_sub_title'] != '') ? ($arrConfig['OtherConfig']['quick2_sub_title']) :27;
                $arrConfig['OtherConfig']['quick2_style']= (isset($arrConfig['OtherConfig']['quick2_style']) && $arrConfig['OtherConfig']['quick2_style'] != '') ? ($arrConfig['OtherConfig']['quick2_style']) :'';
                $arrConfig['OtherConfig']['quick3_text_style']= (isset($arrConfig['OtherConfig']['quick3_text_style']) && $arrConfig['OtherConfig']['quick3_text_style'] != '') ? ($arrConfig['OtherConfig']['quick3_text_style']) :'';
                $arrConfig['OtherConfig']['quick3_title']= (isset($arrConfig['OtherConfig']['quick3_title']) && $arrConfig['OtherConfig']['quick3_title'] != '') ? ($arrConfig['OtherConfig']['quick3_title']) :'';
                $arrConfig['OtherConfig']['quick3_title_size']= (isset($arrConfig['OtherConfig']['quick3_title_size']) && $arrConfig['OtherConfig']['quick3_title_size'] != '') ? ($arrConfig['OtherConfig']['quick3_title_size']) :39;
                $arrConfig['OtherConfig']['quick3_title_style']= (isset($arrConfig['OtherConfig']['quick3_title_style']) && $arrConfig['OtherConfig']['quick3_title_style'] != '') ? ($arrConfig['OtherConfig']['quick3_title_style']) :'';
                $arrConfig['OtherConfig']['quick4_title']= (isset($arrConfig['OtherConfig']['quick4_title']) && $arrConfig['OtherConfig']['quick4_title'] != '') ? ($arrConfig['OtherConfig']['quick4_title']) :'';
                $arrConfig['OtherConfig']['quick4_title_size']= (isset($arrConfig['OtherConfig']['quick4_title_size']) && $arrConfig['OtherConfig']['quick4_title_size'] != '') ? ($arrConfig['OtherConfig']['quick4_title_size']) :39;
                $arrConfig['OtherConfig']['quick4_title_style']= (isset($arrConfig['OtherConfig']['quick4_title_style']) && $arrConfig['OtherConfig']['quick4_title_style'] != '') ? ($arrConfig['OtherConfig']['quick4_title_style']) :'';
                $arrConfig['OtherConfig']['quick5_title']= (isset($arrConfig['OtherConfig']['quick5_title']) && $arrConfig['OtherConfig']['quick5_title'] != '') ? ($arrConfig['OtherConfig']['quick5_title']) :'';
                $arrConfig['OtherConfig']['quick5_title_size']= (isset($arrConfig['OtherConfig']['quick5_title_size']) && $arrConfig['OtherConfig']['quick5_title_size'] != '') ? ($arrConfig['OtherConfig']['quick5_title_size']) :39;
                $arrConfig['OtherConfig']['quick5_title_style']= (isset($arrConfig['OtherConfig']['quick5_title_style']) && $arrConfig['OtherConfig']['quick5_title_style'] != '') ? ($arrConfig['OtherConfig']['quick5_title_style']) :'';
                $arrConfig['OtherConfig']['style9_text_color']= (isset($arrConfig['OtherConfig']['style9_text_color']) && $arrConfig['OtherConfig']['style9_text_color'] != '') ? ($arrConfig['OtherConfig']['style9_text_color']) :'#000';
                $arrConfig['OtherConfig']['style9_bdr_color']= (isset($arrConfig['OtherConfig']['style9_bdr_color']) && $arrConfig['OtherConfig']['style9_bdr_color'] != '') ? ($arrConfig['OtherConfig']['style9_bdr_color']) :'#000';
                $arrConfig['OtherConfig']['style9_bg_color']= (isset($arrConfig['OtherConfig']['style9_bg_color']) && $arrConfig['OtherConfig']['style9_bg_color'] != '') ? ($arrConfig['OtherConfig']['style9_bg_color']) :'#ffffff00';
                $arrConfig['OtherConfig']['style9_bdr_hvr_color']= (isset($arrConfig['OtherConfig']['style9_bdr_hvr_color']) && $arrConfig['OtherConfig']['style9_bdr_hvr_color'] != '') ? ($arrConfig['OtherConfig']['style9_bdr_hvr_color']) :'#000';
                $arrConfig['OtherConfig']['style9_bg_hvr_color']= (isset($arrConfig['OtherConfig']['style9_bg_hvr_color']) && $arrConfig['OtherConfig']['style9_bg_hvr_color'] != '') ? ($arrConfig['OtherConfig']['style9_bg_hvr_color']) :'#ffff';
                $arrConfig['OtherConfig']['style12_text_light']= (isset($arrConfig['OtherConfig']['style12_text_light']) && $arrConfig['OtherConfig']['style12_text_light'] != '') ? ($arrConfig['OtherConfig']['style12_text_light']) :'#fff';
                $arrConfig['OtherConfig']['style12_font_family_light']= (isset($arrConfig['OtherConfig']['style12_font_family_light']) && $arrConfig['OtherConfig']['style12_font_family_light'] != '') ? ($arrConfig['OtherConfig']['style12_font_family_light']) :'';
                $arrConfig['OtherConfig']['style12_font_size_light']= (isset($arrConfig['OtherConfig']['style12_font_size_light']) && $arrConfig['OtherConfig']['style12_font_size_light'] != '') ? ($arrConfig['OtherConfig']['style12_font_size_light']) :'';
                $arrConfig['OtherConfig']['style12_text_dark']= (isset($arrConfig['OtherConfig']['style12_text_dark']) && $arrConfig['OtherConfig']['style12_text_dark'] != '') ? ($arrConfig['OtherConfig']['style12_text_dark']) :'#000';
                $arrConfig['OtherConfig']['style12_font_family_dark']= (isset($arrConfig['OtherConfig']['style12_font_family_dark']) && $arrConfig['OtherConfig']['style12_font_family_dark'] != '') ? ($arrConfig['OtherConfig']['style12_font_family_dark']) :'';
                $arrConfig['OtherConfig']['style12_font_size_dark']= (isset($arrConfig['OtherConfig']['style12_font_size_dark']) && $arrConfig['OtherConfig']['style12_font_size_dark'] != '') ? ($arrConfig['OtherConfig']['style12_font_size_dark']) :'';
                $arrConfig['OtherConfig']['pre_market_light']= (isset($arrConfig['OtherConfig']['pre_market_light']) && $arrConfig['OtherConfig']['pre_market_light'] != '') ? ($arrConfig['OtherConfig']['pre_market_light']) :'#fff';
                $arrConfig['OtherConfig']['market_border_light']= (isset($arrConfig['OtherConfig']['market_border_light']) && $arrConfig['OtherConfig']['market_border_light'] != '') ? ($arrConfig['OtherConfig']['market_border_light']) :'#dee2e6';
                $arrConfig['OtherConfig']['pre_market_dark']= (isset($arrConfig['OtherConfig']['pre_market_dark']) && $arrConfig['OtherConfig']['pre_market_dark'] != '') ? ($arrConfig['OtherConfig']['pre_market_dark']) :'#000';
                $arrConfig['OtherConfig']['market_border_dark']= (isset($arrConfig['OtherConfig']['market_border_dark']) && $arrConfig['OtherConfig']['market_border_dark'] != '') ? ($arrConfig['OtherConfig']['market_border_dark']) :'#dee2e6';



                //delete_option(Constants::OPTIONS);
                update_option(Constants::OPTIONS, $arrConfig);
            }

            update_option( '_lpt_is_added_paged', 1 );
        }
        public function CustomWpPlugin_is_page_exists($slug, $val_format = 0) {
            global $wpdb;
            $page_found = 0;
            $page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_type='page' AND post_name = %s LIMIT 1;", $slug ) );
            if ($val_format == 0) {
                return ( !empty($page_found) && ($page_found != 0));
            } else {
                return $page_found;
            }
        }
        public function CustomWpPlugin_insert_custom_page($args = array()) {

            $page_data = array(
                'post_status'       => 'publish',
                'post_type'         => 'page',
                'post_author'       => 1,
                'post_name'         => $args['slug'],
                'post_title'        => $args['name'],
                'post_content'      => $args['content'],
                'post_parent'       => 0,
                'comment_status'    => 'closed'
            );

            $page_id = wp_insert_post( $page_data );

            return $page_id;
        }

    }
}