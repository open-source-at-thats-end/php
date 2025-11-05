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
         * Function installs the loopt plugin
         * and initializes rewrite rules.
         */
        public function install() {
            $this->loopt_install_custom_pages();

        }
        public function update() {
            if (!get_option( '_lpt_is_updated_paged' )) {

                $required_page = array();
                $required_page[] = array('slug' => 'terms-of-service', 'name' => __('Terms of Service ', 'lpt'), 'content' => '' );

                foreach ($required_page as $page_) {
                    if (!$this->loopt_is_page_exists($page_['slug'])) {
                        $this->loopt_insert_custom_page($page_);

                    }
                }
            }
            update_option( '_lpt_is_updated_paged', 1 );
        }
        public function loopt_install_custom_pages(){
            if (!get_option( '_lpt_is_added_paged' )) {

                $required_page = array();
                $required_page[] = array('slug' => 'property-search', 'name' => __('Property Search', 'lpt'), 'content' => '[listing-search-form][listing-search-result]' );
                $required_page[] = array('slug' => 'privacy-policy', 'name' => __('Privacy Policy', 'lpt'), 'content' => '' );
                $required_page[] = array('slug' => 'terms-of-use', 'name' => __('Terms of Use ', 'lpt'), 'content' => '' );

                foreach ($required_page as $page_) {
                    if (!$this->loopt_is_page_exists($page_['slug'])) {
                        $this->loopt_insert_custom_page($page_);

                    }
                }
            }
            update_option( '_lpt_is_added_paged', 1 );
        }
        public function loopt_is_page_exists($slug, $val_format = 0) {
            global $wpdb;
            $page_found = 0;
            $page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_type='page' AND post_name = %s LIMIT 1;", $slug ) );
            if ($val_format == 0) {
                return ( !empty($page_found) && ($page_found != 0));
            } else {
                return $page_found;
            }
        }
        public function loopt_insert_custom_page($args = array()) {

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