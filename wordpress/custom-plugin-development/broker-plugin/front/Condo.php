<?php

if( !class_exists('Condo'))
{
    class Condo implements FrontModule
    {
        private static $instance;
        private $title = '';
        public $browser_title, $meta_keyword, $meta_desc;

        public function __construct()
        {

        }

        public static function getInstance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new PreDefined();
            }
            return self::$instance;
        }

        public function requestHandler($isAjaxRequest = false, $moduleKey)
        {
            global $objAjaxResp;


        }

        public function getTitle()
        {
            $this->title = ucwords(str_replace('-', ' ', get_query_var('title')));
            return $this->title;
        }

        public function getPageTemplate()
        {
            global $arrOREConfig;
            add_filter('template_include', function($default_template) {

                global $arrPhysicalPath;

                $templatefilename = 'detail_template.php';
                $template = $arrPhysicalPath['Base'] . $templatefilename;
                $default_template = $template;

                // Load new template also fallback if both condition fails load default
                return $default_template;

            }, 9999);

            //return $pageTemplate;
        }

        public function getContent($POST='')
        {
            global $objTmpl, $arrPhysicalPath, $arrVirtualPath, $arrConfig, $userinfo;

            $objAPI = IDXAPI::getInstance();
        }
    }
}
?>