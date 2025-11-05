<?php
if(!class_exists('RewriteRules')){
    /**
     *
     * Singleton implementation of ORERewriteRules
     *
     * All ore requests are directed to the $rootPageName, which tries to load a wordpress page that
     * does not exist.  We do not want to load a real page.  We will display it as a virtual Wordpress post.
     *
     * The rewrite rules below set a variable OREConstants::ORE_TYPE_URL_VAR  that is used to determine
     * VirtualPage
     *
     * @author -
     *
     */
    class RewriteRules{

        private static $instance ;
        private $urlFactory ;
        private $rootPageName ;

        private function __construct(){
            $this->rootPageName = 'index.php?pagename=non_existent_page';
        }

        public static function getInstance(){
            if( !isset(self::$instance)){
                self::$instance = new RewriteRules();
            }
            return self::$instance;
        }

        public function initialize(){
            $this->initQueryVariables();
            $this->initRewriteRules();
        }

        public function flushRules(){
            global $wp_rewrite;

            $wp_rewrite->flush_rules();
        }

        private function initQueryVariables(){
            global $wp ;

            //Used for listing search, results and detail
            $wp->add_query_var( Constants::TYPE_URL_VAR );
            $wp->add_query_var('mls_no');
            $wp->add_query_var('agent_id');
            $wp->add_query_var('param');
            $wp->add_query_var('type');
            $wp->add_query_var('city');
            $wp->add_query_var('state');
            $wp->add_query_var('county');
            $wp->add_query_var('action');
            $wp->add_query_var('title');
            $wp->add_query_var('pic_no');
            $wp->add_query_var('MlsNum');
            $wp->add_query_var('cmd');
        }
        /**
         * Function to initialize rewrite rules for the ORE plugin.
         *
         *  During development we initialize and flush the rules often, but
         *  this should only be performed when the plugin is registered.
         *
         *  We need to map certain URL patters ot an internal page
         *  Once requests are routed to that page, we can handle different
         *  behavior in functions that listen for updates on that page.
         */
        private function initRewriteRules(){

            $this->setAllRewriteRules( '');
            # set the rules again, to support almost pretty permalinks
            $this->setAllRewriteRules( 'index.php/');
        }

        private function setAllRewriteRules($matchRulePrefix){
            #The order of these search rules is important.
            $this->setDetailPageRewriteRules($matchRulePrefix);
	        $this->setMemberDetailsPageRewriteRules($matchRulePrefix);
	        $this->setMarketReportPageRewriteRules($matchRulePrefix);
	        $this->setSalesPageRewriteRules($matchRulePrefix);
	        $this->setRentalPageRewriteRules($matchRulePrefix);
	        $this->setMyAccountPageRewriteRules($matchRulePrefix);
            $this->setThirdPartyResponse($matchRulePrefix);
	        $this->setSoldPageRewriteRules($matchRulePrefix);

        }
        function setDetailPageRewriteRules($matchRulePrefix) {

            global $wp_rewrite;

            $wp_rewrite->add_rule(
                $matchRulePrefix . '(.*)'.(ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_LISTING_DETAIL, false)) . '/.*-mls-(.*)/(.*)/?$',
                $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_LISTING_DETAIL . '&mls_no=$matches[2]&city=$matches[1]&agent_id=$matches[3]',
                'top');


            $wp_rewrite->add_rule(
                $matchRulePrefix . '(.*)'.(ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_LISTING_DETAIL, false)) . '/.*-mls-(.*)/?$',
                $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_LISTING_DETAIL . '&mls_no=$matches[2]&city=$matches[1]',
                'top');
            $wp_rewrite->flush_rules(true);

        }
	    private function setMemberDetailsPageRewriteRules($matchRulePrefix ){
		    global $wp_rewrite;

		    $wp_rewrite->add_rule(
			    $matchRulePrefix  . (ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_MEMBER_DETAIL, false)),
			    $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_MEMBER_DETAIL,
			    'top');
	    }
	    function setMarketReportPageRewriteRules($matchRulePrefix)
	    {
		    global $wp_rewrite;

		    $wp_rewrite->add_rule(
			    $matchRulePrefix  . (ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_MARKET_REPORT_DETAIL,false)).'/(.*)/?$',
			    $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_PRE_DEFINE.'&action='.Constants::TYPE_MARKET_REPORT_DETAIL.'&title=$matches[1]',
			    'top');
	    }
	    function setSalesPageRewriteRules($matchRulePrefix)
	    {
		    global $wp_rewrite;

		    $wp_rewrite->add_rule(
			    $matchRulePrefix  . (ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_SALES,false)).'/(.*)/?$',
			    $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_PRE_DEFINE.'&action='.Constants::TYPE_SALES.'&title=$matches[1]',
			    'top');
	    }
	    function setRentalPageRewriteRules($matchRulePrefix)
	    {
		    global $wp_rewrite;

		    $wp_rewrite->add_rule(
			    $matchRulePrefix  . (ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_RENTALS,false)).'/(.*)/?$',
			    $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_PRE_DEFINE.'&action='.Constants::TYPE_RENTALS.'&title=$matches[1]',
			    'top');
	    }
	    function setSoldPageRewriteRules($matchRulePrefix)
	    {
		    global $wp_rewrite;

		    $wp_rewrite->add_rule(
			    $matchRulePrefix  . (ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_SOLD,false)).'/(.*)/?$',
			    $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_PRE_DEFINE.'&action='.Constants::TYPE_SOLD.'&title=$matches[1]',
			    'top');
	    }
	    function setMyAccountPageRewriteRules($matchRulePrefix)
	    {
		    global $wp_rewrite;

		    $wp_rewrite->add_rule(
			    $matchRulePrefix  . (ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_MY_ACCOUNT,false)),
			    $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_MY_ACCOUNT,
			    'top');

			     $wp_rewrite->add_rule('pictures/property/([^/]+)/([^/]+)/?$	', 'https://CustomWpPluginDemoDomain.com/API/assets/assets.php?cmd=property&type=pic&MlsNum=$1&pic_no=$2', 'top');
	    }
        private function setThirdPartyResponse($matchRulePrefix){
            global $wp_rewrite;

            $wp_rewrite->add_rule(
                $matchRulePrefix. (ModuleUrl::getInstance()->getModuleUrl(Constants::TYPE_THIRD_PARTY_RESPONSE, false)),
                $this->rootPageName . '&' . Constants::TYPE_URL_VAR . '=' . Constants::TYPE_THIRD_PARTY_RESPONSE,
                'top');
        }


    }
}
?>