<?php
if( !class_exists('ListingDetailUrl')) {
    class ListingDetailUrl{

        private static $instance ;

        private $path="";

        public function __construct(){

        }

        public static function getInstance(){
            if( !isset(self::$instance)){
                self::$instance = new ListingDetailUrl();
            }
            return self::$instance;
        }

        public function getPath(){
            global $arrConfig;


           /* if( $customPath != null && "" != $customPath ){
                $this->path = $customPath ;
            }*/

            return $this->path;
        }
    }
}
?>