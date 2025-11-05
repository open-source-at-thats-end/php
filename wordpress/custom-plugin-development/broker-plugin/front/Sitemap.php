<?php

if( !class_exists('Sitemap'))
{
    class Sitemap implements FrontModule
    {
        private static $instance;

        public function __construct()
        {

        }

        public static function getInstance()
        {
            if(!isset(self::$instance))
            {
                self::$instance = new Sitemap();
            }

            return self::$instance;
        }


        public function getTitle(){
            return $this->title;
        }

        public function getPageTemplate(){
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
            global $objTmpl, $wp;

            $url = home_url( $wp->request );

            $objTmpl->assign(array(
                'currency' => '$'
            ));

            $sitemapIndex = array();

            if(strpos($url, '.xml') == true)
            {
                if(strpos($url, 'sitemap.xml') == true)
                {
                    add_action("publish_post", "eg_create_sitemap");
                    add_action("publish_page", "eg_create_sitemap");

                    $pagesForSitemap = get_pages(array(
                        'numberposts' => -1,
                        'orderby' => 'modified',
                        'order' => 'DESC'
                    ));

                    $objTmpl->assign(array(
                        'pagesForSitemap' => $pagesForSitemap
                    ));

                    $sitemap_for = 'sitemap/xml';
                }
                elseif(strpos($url, 'sitemap-') == true)
                {
                    $sitemapIndex = explode('/', $url);

                    /* Set xml header */
                    /*header ("Content-Type:text/xml");

                    $objTmpl->display('../../'.$sitemapIndex[3]);

                    exit;*/
                }
                else{

                    $sitemap_for = 'sitemap/sitemap-index';
                }

                //$content = $objTmpl->fetch('sitemap/index.tpl');

                /* Set xml header */
                header ("Content-Type:text/xml");

                /* Send output */
                if(strpos($url, 'sitemap-') == true)
                {
                    $objTmpl->display('../../sitemap/'.$sitemapIndex[3]);
                }
                else
                {
                    $objTmpl->display($sitemap_for.'.tpl');
                }

                //$objTmpl->display('../sitemap-index.xml');
                exit();
            }

            $content = $objTmpl->fetch('sitemap/index.tpl');

            return $content;


        }
    }
}
?>