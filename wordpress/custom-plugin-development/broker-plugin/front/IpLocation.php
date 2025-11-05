<?php
if( !class_exists('IpLocation'))
{
	class IpLocation implements FrontModule
	{

		private static $instance;

		public function __construct()
		{

		}

		public static function getInstance()
		{
			if(!isset(self::$instance))
			{
				self::$instance = new IpLocation();
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
			global $objTmpl, $arrConfig;

			if(isset($_POST['submit']))
			{
				$url = 'http://ip-get-geolocation.com/api/json/'.$_POST['LOOKUPADDRESS'];

				$LocationArray = json_decode( file_get_contents($url), true);

				$objTmpl->assign(array(
					                 'location' => $LocationArray
				                 ));

			}
			$content = $objTmpl->fetch('ip-location.tpl');

			return $content;

		}
	}
}
?>