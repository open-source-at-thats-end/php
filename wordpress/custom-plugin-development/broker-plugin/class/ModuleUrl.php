<?php
if( !class_exists('ModuleUrl')) {
    /**
     * Singleton class that provides convenience methods for building plugin URLs
     *
     * @author oequal
     */
    class ModuleUrl
    {

        private $baseUrl = null;

        private static $instance;
        private $virtualPageFactory;

        private function __construct()
        {

        }

        public static function getInstance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new ModuleUrl();
            }
            return self::$instance;
        }

       /* /**
         *
         * Gets the base URL for this blog
         */
        public function getBaseUrl()
        {
            if ($this->baseUrl == null) {
                $baseUrl = site_url();
                //if almost pretty permalinks are used then alter the baseUrl to include
                $permalinkStructure = get_option('permalink_structure');
                $thePosition = strpos($permalinkStructure, 'index.php');
                if ($thePosition > -1) {
                    $currentBlogAddress = $currentBlogAddress . '/index.php';
                }
            }
            return $baseUrl;
        }

        private function prependBaseUrl($path, $includeBaseUrl)
        {
            if ($includeBaseUrl) {
                $path = $this->getBaseUrl() . "/" . $path . "/";
            }

            return $path;
        }

        public function makeRelativeUrl($url)
        {
            $urlParts = parse_url($url);
            $value = $urlParts['path'];

            $query = $urlParts['query'];

            if ($query) {
                $value .= '?' . $query;
            }

            if ($value == null || $value == "") {
                $value = "/";
            }

            return $value;
        }

        private function removeAfter($haystack, $needle)
        {
            $value = $haystack;
            if (strpos($haystack, $needle)) {
                $value = str_replace($needle, "", $haystack);
            }
            return $value;
        }
        public function getModuleUrl($module_type, $includeBaseUrl=true)
        {

            global $arrPhysicalPath;

            if (empty($module_type))
                return;

            switch($module_type) {

                case Constants::TYPE_LISTING_DETAIL :
                    include_once $arrPhysicalPath['Base'] . 'class/ListingDetailUrl.php';

                    $module = "ListingDetailUrl";

                    $path = ListingDetailUrl::getInstance()->getPath();

                    $value = $this->prependBaseUrl($path, $includeBaseUrl);

                    break;
	            case Constants::TYPE_MEMBER_DETAIL :
		            include_once $arrPhysicalPath['Base']. 'class/MemberDetailUrl.php';

		            $module = "MemberDetailUrl";

		            $path	= MemberDetailUrl::getInstance()->getPath();
		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
	            case Constants::TYPE_PRE_DEFINE :
		            include_once $arrPhysicalPath['Base']. 'class/PreDefineUrl.php';

		            $module = "PreDefineUrl";

		            $path	= PreDefineUrl::getInstance()->getPath();
		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
	            case Constants::TYPE_MARKET_REPORT_DETAIL :
		            include_once $arrPhysicalPath['Base']. 'class/MarketReportUrl.php';

		            $module = "MarketReportUrl";

		            $path	= MarketReportUrl::getInstance()->getPath();

		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
	            case Constants::TYPE_SALES :

	            	$module = "SalesUrl";
	            	$path	= 'sales';
		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
	            case Constants::TYPE_RENTALS :

		            $module = "RentalUrl";
		            $path	= Constants::TYPE_RENTALS;
		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
	            case Constants::TYPE_SOLD :

		            $module = "SoldUrl";
		            $path	= Constants::TYPE_SOLD;
		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
	            case Constants::TYPE_MY_ACCOUNT :
		            include_once $arrPhysicalPath['Base']. 'class/MarketReportUrl.php';

		            $module = "MyAccountUrl";

		            $path	= 'myaccount';
		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
	            case Constants::TYPE_IP_LOCATION :

		            $path	= 'ip-location';
		            $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
		            break;
                case Constants::TYPE_SITEMAP :
                    include_once $arrPhysicalPath['Base']. 'class/Sitemap.php';

                    $path	= 'sitemap';
                    $value 	= $this->prependBaseUrl( $path, $includeBaseUrl );
                    break;
                case Constants::TYPE_THIRD_PARTY_RESPONSE :
                    include_once $arrPhysicalPath['Base']. 'class/ThirdPartyResponseUrl.php';

                    $module = "ThirdPartyResponseUrl";
                    $path	= ThirdPartyResponseUrl::getInstance()->getPath();
                    $value 	= $this->prependBaseUrl( $path, $includeBaseUrl);
                    break;
            }
            return 	$value ;
        }
    }
}
?>