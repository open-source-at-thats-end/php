<?php
if( !class_exists('ThirdPartyResponseUrl')) {

    class ThirdPartyResponseUrl{

        private static $instance ;

        private $path="third-party-response";

        public function __construct(){

        }

        public static function getInstance(){
            if( !isset(self::$instance)) {
                self::$instance = new ThirdPartyResponseUrl();
            }
            return self::$instance;
        }

        public function getPath(){
            global $arrConfig;

            $customPath = $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_THIRD_PARTY_RESPONSE];

            if( $customPath != null && "" != $customPath ){
                $this->path = $customPath;
            }
            return $this->path;
        }
    }
}
?>