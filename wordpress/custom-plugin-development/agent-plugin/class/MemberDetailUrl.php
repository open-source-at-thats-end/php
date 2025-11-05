<?php
if( !class_exists('MemberDetailUrl')) {
	class MemberDetailUrl{

		private static $instance ;

		private $path="member-details";

		public function __construct(){

		}

		public static function getInstance(){
			if( !isset(self::$instance)){
				self::$instance = new MemberDetailUrl();
			}
			return self::$instance;
		}

		public function getPath(){
			global $arrOREConfig;

			$customPath = $arrOREConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_MEMBER_DETAILS];

            if( $customPath != null && "" != $customPath ){
				$this->path = $customPath ;
			}
			return $this->path;
		}
	}
}
?>