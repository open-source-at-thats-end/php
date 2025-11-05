<?php
if( !class_exists('MyAccount')) {
	class MyAccount implements FrontModule {
		private static $instance;
		private static $title;

		public static function getInstance(){
			if( !isset(self::$instance)){
				self::$instance = new MyAccount();
			}
			return self::$instance;
		}
		public function getTitle(){
			return $this->title;
		}
		public function getPageTemplate(){

			add_filter('template_include', function($default_template) {

				global $arrPhysicalPath;

				$templatefilename = 'detail_template.php';
				$template = $arrPhysicalPath['Base'] . $templatefilename;
				$default_template = $template;

				// Load new template also fallback if both condition fails load default
				return $default_template;

			}, 9999);

		}

		public function getContent($POST='')
		{
			global $objTmpl,$arrConfig;
			include_once ("ShortCodeHandler.php");
			$ShortCodeHandlerobj = ShortCodeHandler::getInstance();
			$userInfo = wp_get_current_user();
			$arrname = explode('_',$userInfo->data->display_name);
			$meta = get_user_meta($userInfo->data->ID);
			$objAPI = IDXAPI::getInstance();
			$save_search = LPTUserSavedSearches::getInstance()->getUserSaveSearch($userInfo->data->ID);

			if( is_user_logged_in() ){
				$userFavMLSNo       = LPTUserFavoriteProperty::getInstance()->getUserFavoritesHomes($userInfo->data->ID);
				if(count($userFavMLSNo) > 0)
				{
					$arrParams = array();
					$arrParams['mlsnowithmarket']    =   implode(",",$userFavMLSNo);

					$arrListing =    $objAPI->getListingByParam($arrParams);

					$objTmpl->assign(array(
						                 "rsResult"			=>	$arrListing['rs'],
						                 "total_record"		=>	$arrListing['total_record'],
						                 "PhotoBaseUrl"		=>	$arrListing['PhotoBaseUrl'],
						                 'userFavList'    =>  explode(',',$userFavMLSNo['strIds']),
						                 'currency'          =>  '$',
						                 'Action'           => isset($_GET['action'])?$_GET['action']:'edit-profile',

					                 ));
				}
				$objTmpl->assign(array(

					                 'userInfo'           =>  $userInfo->data,
					                 'first_name'         =>  $arrname[0],
					                 'last_name'          =>  $arrname[1],
					                 'meta'               =>  $meta,
					                 'arrConfig'          =>  $arrConfig,
					                 'save_search'        =>  $save_search,
					                 'arr_email_notification'        =>  StaticArray::Email_Notification(),
                                     'arrPType'	            =>	StaticArray::arrPropertyType(),
                                     'arrSType'	            =>	StaticArray::arrSubType()

				                 ));
				$content = $objTmpl->fetch('my-account/myaccount.tpl');

				return $content;
			}
			else
			{
				header("Location:".get_home_url());
				exit(0);
			}
		}

	}
}
?>