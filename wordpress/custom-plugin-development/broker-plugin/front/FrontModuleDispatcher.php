<?php
if( !class_exists('FrontModuleDispatcher')) {
	/**
	 *
	 * This singleton class is used to filter the content of VirtualPages.
	 *
	 * @author oequal
	 */
	class FrontModuleDispatcher {

		private static $instance ;

		private $currentModule = null;
		private $content = null;
		private $title = null;
		private $initialized=false;

		private function __construct(){
		}

		public static function getInstance(){
			if( !isset(self::$instance)){
				self::$instance = new FrontModuleDispatcher();
			}
			return self::$instance;
		}

		# This will be used to handle all types of AJAX request for diffrent modules
		# TODO : Need to check if we can control WIDGET/SHORTCODES request from here only,
		# we can pass {mod, action} params from diffrent sections
		public function requestHandler(){

			global $arrPhysicalPath, $objAjaxResp;

			include_once($arrPhysicalPath['Libs']. "AjaxResponse.php");
			$objAjaxResp 		= new AjaxResponse();

			# Note : Need more proper checking
			$isAjaxRequest 	= ($_POST['action'] == 'ore_front_ajax');

			if($isAjaxRequest) {
				$strModule 	= strtolower($_POST['ajax_mod']);

				# Note : Following items will be moved in requestHandler for partuclar module
				# Currently it is used for serach module only
				//$this->_mod 		= $_POST['ajax_mod'];
				$this->_action 		= $_POST['ajax_action'];
				$this->_subaction 	= $_POST['ajax_subaction'];
			}
			else
			{
				$strModule = get_query_var(Constants::TYPE_URL_VAR);
			}

			$ret = "";


			if($isAjaxRequest)
			{
				$objAjaxResp = $ret;

				echo json_encode($objAjaxResp->aCommands);
				die();
			}
			else
			{
				return $ret;
			}
		}

		private function init(){
			global $wp_query, $arrPhysicalPath, $arrVirtualPath, $objTmpl, $userinfo, $arrConfig;

			$postsCount = $wp_query->post_count;

			# we only try to initialize, if we are accessing a virtual page
			# which does not have any true posts in the global posts array
			if( !$this->initialized && $postsCount == 0 ){

				if( $type = get_query_var(Constants::TYPE_URL_VAR) ) {
                    if( is_user_logged_in() ){
                        /*include_once $arrOREPhysicalPath['DBAccess']. 'OREUserFavoriteProperty.php';
                        $objUserFavoriteProperty = OREUserFavoriteProperty::getInstance();

                        $current_user = wp_get_current_user();

                        $userFavMLSNo       = $objUserFavoriteProperty->getUserFavoritesHomes($current_user->data->ID);

                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  true,
                            //'myaccount_url' =>  get_permalink(get_page_by_title('My Account')),
                            //'logout_url'    =>  wp_logout_url( home_url() ),
                            'recUser'       =>  $current_user->data,
                            'user_id'       =>  $current_user->data->ID,
                            "userFavList"	=>	array_keys($userFavMLSNo['arrIds']),
                            'Site_Root'         =>  get_home_url(),
                		));*/
                    }
                    else {
                        $objTmpl->assign(array(
                            'isUserLoggedIn'    =>  false,
                            'Site_Root'         =>  get_home_url(),
            			));
                    }

					$fnParams = '';



					if($type == Constants::TYPE_LISTING_DETAIL ){

						# Temporary settings, we need to remove ot from here
						if($_GET['action'] != 'print')
						{
							# Load css
							wp_enqueue_style( 'p-photo-swipe', $arrVirtualPath['TemplateCss'].'photoswipe.css',array(),Constants::CSS_JS_VERSION);
							wp_enqueue_style( 'p-property-detail', $arrVirtualPath['TemplateCss']. 'property-details.css',array(),Constants::CSS_JS_VERSION);

							wp_enqueue_style( 'p-search-result', $arrVirtualPath['TemplateCss']. 'search-results.css',array(),Constants::CSS_JS_VERSION);
                            //wp_enqueue_style('srchresult');
							//wp_enqueue_style( 'p-common', $arrVirtualPath['TemplateCss']. 'common.css',array(),Constants::CSS_JS_VERSION);
							wp_enqueue_style( 'p-default-skin', $arrVirtualPath['TemplateCss']. 'default-skin.css',array(),Constants::CSS_JS_VERSION);


							wp_enqueue_script('p-photo-swipe-js', $arrVirtualPath['TemplateJs']. 'photoswipe.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
							wp_enqueue_script('p-photo-swipe-ui-js', $arrVirtualPath['TemplateJs']. 'photoswipe-ui-default.min.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);
							wp_enqueue_script('p-gallery-js', $arrVirtualPath['TemplateJs']. 'gallery.js', array( 'jquery' ), Constants::CSS_JS_VERSION, true);

							wp_enqueue_script('p-property-detail-js',              $arrVirtualPath['TemplateJs']. 'property-detail.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
							/*wp_localize_script(	'p-property-detail-js',
							                       'objProp',
							                       array('action' => 'front_ajax', 'mod' => $type, 'url' => admin_url('admin-ajax.php')));*/
							wp_localize_script(	'p-property-detail-js',
							                       'objProp',
							                       array('action' => 'front_ajax', 'mod' => $type, 'url' => admin_url('admin-ajax.php'), 'google_conv_code' => $arrConfig['OtherConfig']['google_conv_code'],'captcha_site_key' => $arrConfig['Listing']['google_site_key']));

							wp_enqueue_style('lpt-color-style');
						}

						$fnParams = $_GET;

						include_once $arrPhysicalPath['UserBase']. 'ListingDetail.php';
						$this->currentModule = ListingDetail::getInstance();
					}
					else if($type == Constants::TYPE_MEMBER_DETAIL ) {
						$fnParams = array();
						$fnParams['sparams'] = array_filter($_GET);
                        wp_enqueue_style('lpt-color-style');

                        include_once $arrPhysicalPath['UserBase']. 'MemberDetails.php';
						$this->currentModule = MemberDetails::getInstance();
					}
					elseif($type == Constants::TYPE_PRE_DEFINE)
					{
						wp_enqueue_style( 'p-market-report', $arrVirtualPath['Libs']. 'front/css/market-reports.css',array(),Constants::CSS_JS_VERSION);
                        wp_enqueue_style('lpt-color-style');
						$fnParams = array();
						$fnParams['sparams'] = array_filter($_GET);

						include_once $arrPhysicalPath['UserBase']. 'PreDefined.php';
						$this->currentModule = PreDefined::getInstance();
					}
					else if($type == Constants::TYPE_IP_LOCATION ) {
						$fnParams = array();

						wp_enqueue_style('lpt-color-style');

						include_once $arrPhysicalPath['UserBase']. 'IpLocation.php';
						$this->currentModule = IpLocation::getInstance();
					}
                    else if($type == Constants::TYPE_SITEMAP) {
                        $fnParams = array();

                        include_once $arrPhysicalPath['UserBase']. 'Sitemap.php';
                        $this->currentModule = Sitemap::getInstance();
                    }
                    else if($type == Constants::TYPE_THIRD_PARTY_RESPONSE) {
                        $fnParams = array();
                        $fnParams['sparams'] = array_filter($_GET);
                        include_once $arrPhysicalPath['UserBase']. 'ThirdPartyResponse.php';
                        $this->currentModule = ThirdPartyResponse::getInstance();
                    }
					elseif($type == Constants::TYPE_MY_ACCOUNT)
					{
						wp_enqueue_style( 'p-user-dashboard', $arrVirtualPath['Libs']. 'front/css/user-dashboard.css',array(),Constants::CSS_JS_VERSION);
						//wp_enqueue_style( 'p-search-result', $arrVirtualPath['Libs']. 'front/css/search-results.css',array(),Constants::CSS_JS_VERSION);
						wp_enqueue_style( 'p-search-result', $arrVirtualPath['TemplateCss']. 'search-results.css',array(),Constants::CSS_JS_VERSION);
                        //wp_enqueue_style('srchresult');
                        wp_enqueue_style( 'p-mls-property', $arrVirtualPath['Libs']. 'front/css/mls-properties-embedding.css',array(),Constants::CSS_JS_VERSION);
						wp_enqueue_script('p-my-account',              $arrVirtualPath['TemplateJs']. 'my-account.js', array( 'jquery' ),Constants::CSS_JS_VERSION,true);
						wp_localize_script(	'p-my-account',
						                       'objMyAccount',
						                       array('action' => 'front_ajax', 'mod' => $type, 'url' => admin_url('admin-ajax.php')));
						wp_localize_script(	'p-my-account',
						                       'objMem',
						                       array('action' => 'front_ajax', 'mod' => $type, 'url' => admin_url('admin-ajax.php')));
                        wp_enqueue_style('lpt-color-style');
						include_once $arrPhysicalPath['UserBase']. 'MyAccount.php';
						$this->currentModule = MyAccount::getInstance();
					}

					//echo "<pre>";print_r($fnParams);die;
					if(is_object($this->currentModule))
					{
						$this->content 	= $this->currentModule->getContent($fnParams['sparams']);

						$this->title	= $this->currentModule->getTitle();

					}
					else
					{
						$this->content 	= 'Opps! Invalid Module';
						$this->title	= 'Invalid Module';
					}
					$this->initialized=true;
				}
			}
		}

		/**
		 * Cleanup state after filtering.  This fixes an issue
		 * where widgets display different loop content, such
		 * as featured posts.
		 */
		private function afterFilter(){
			$this->initialized=false;
		}

		public function clearComments($comments){
			# If this is a virtual page, clear out any comments
			if( get_query_var(Constants::TYPE_URL_VAR) ) {
				$comments=array();
			}
			return $comments;
		}

		/**
		 * We identify ORE requests based on the query_var
		 * Constants::ORE_TYPE_URL_VAR.
		 * Set the proper title and update the posts array to contain only
		 * a single posts.  This will get updated in another action later
		 * during processing.  We cannot set the post content here, because
		 * Wordpress does some odd formatting of the post_content, if we
		 * add it here (see the getContent method below, where content is properly set)
		 *
		 * @param $posts
		 */
		function postCleanUp($posts){

			$this->init();

			if( $this->initialized ){

				# TODO : NO IDEA, WHY MULTIPLE CALLS used to get title, COMMENTED FOR NOW, LET SEE IF ANY ISSUE OCCURE */
				// $title = $this->currentModule->getTitle();
			   // $_postArray['post_title'] = $this->getTitle() ;
				$_postArray['post_title'] = $this->title ;
				# This value will get replaced with remote content.  If it is not replaced, then an error
				# has occurred and we leave the following default text.
				$_postArray['post_content'] = $this->content ;

                add_filter( 'pre_get_document_title', function( $title ){
                    // return custom title for remove site title from title tag
                    return $this->title;
                }, 999, 1 );

				if(is_object($this->currentModule))
				{
					#  Browser Title ?
					/*if(isset($this->currentModule->browser_title))
					{
						$_postArray['browser_title'] = $this->currentModule->browser_title;
						add_filter('wp_title', function() { global $post; return $post->browser_title; });
					}*/
                    //add_filter('wp_title', function() { echo "<title>.$this->title.</title>". "\n"; }, 1);
					# Meta keyword ?
					if(isset($this->currentModule->meta_keyword))
					{
						$_postArray['meta_keyword'] = $this->currentModule->meta_keyword;
						add_filter('wp_head', function() { global $post; echo "<meta name='keywords' content='".$post->meta_keyword."' />". "\n"; }, 1);
					}
					# Meta Desc ?
					if(isset($this->currentModule->meta_desc))
					{
						$_postArray['meta_desc'] = htmlspecialchars($this->currentModule->meta_desc);
						add_filter('wp_head', function() { global $post; echo "<meta name='description' content='".$post->meta_desc."' />"."\n"; echo "<meta content='index,follow' name='robots'>"; }, 1);
					}
					if(isset($this->currentModule->og_image))
                    {
                        add_filter('wp_head', function() { global $post; echo "<meta property='og:title' id='ogtitle' content='".$this->title."' />"."\n"; }, 1);
                        add_filter('wp_head', function() { global $post; echo "<meta property='og:description' id='ogtitle' content='".$post->meta_desc."' />"."\n"; echo "<meta property='og:type' content='website' />"; }, 1);
                        add_filter('wp_head', function() { global $post; echo "<meta property='og:site_name' content='".get_bloginfo()."' />"."\n"; }, 1);
                        add_filter('wp_head', function() { global $post; echo "<meta property='og:image' content='".$this->currentModule->og_image."' />"."\n"; }, 1);
                        add_filter('wp_head', function() { global $post; echo "<meta property='og:image:width' content='1200' />"."\n"; }, 1);
                        add_filter('wp_head', function() { global $post; echo "<meta property='og:image:height' content='600' />"."\n"; }, 1);
                    }

                    if($this->currentModule->type != '')
                        $type = $this->currentModule->type;
				}

                $_postArray['ID'] = -1 ;

				$_postArray['post_excerpt'] = '' ;
				$_postArray['post_status'] = 'publish';
				//$_postArray['post_type'] = 'page'; // Default: page

                $_postArray['post_type']   = isset($type)?$type:'page';
                $_postArray['is_page'] = 1;
				$_postArray['is_single'] = 1;
				$_postArray['comment_status'] = 'closed';
				$_postArray['comment_count'] = 0;
				$_postArray['ping_status'] = 'closed';
				//$_postArray['post_category'] = array(1); // the default 'Uncategorized'
				$_postArray['post_parent'] = 0;
				$_postArray['post_author'] = 0;
				//$_postArray['posts_per_page'] = 1;
				$_postArray['post_date'] = current_time('mysql');

				//old wordpress
				$_postObject=(object) $_postArray ;
                $_postObject=get_post($_postObject);

				$posts= array();
				$posts[0]=$_postObject;

			}
			
			return $posts ;
		}

		function getTitle(){
			$this->init();
			if( $this->initialized ){
				$virtualPageTitle=$this->currentModule->getTitle();
				if( $virtualPageTitle != null && '' != $virtualPageTitle){
					$title=$virtualPageTitle ;
				}
			}
			return $this->title ;
		}

		/**
		 * Sets the page template used for our virtual pages
		 * The page templates are set in Wordpress admin.
		 *
		 * @param $pageTemplate
		 */
		function getPageTemplate($pageTemplate){

			$this->init();
			$virtualPageTemplate=null;

			if( $this->initialized ){
				if(is_object($this->currentModule)) {
					$virtualPageTemplate=$this->currentModule->getPageTemplate();
				}
				if( $this->isStringEmpty($virtualPageTemplate)){
			     	$virtualPageTemplate=$this->getDefaultTemplate() ;
				}

				# If the $virtualPageTemplate is NOT empty, then reset $pageTemplate
				if( !$this->isStringEmpty($virtualPageTemplate)){
					$templates=array($virtualPageTemplate);
					# gets the disk location of the template
					$pageTemplate=  locate_template(  $templates ) ;
				}
			}
			return $pageTemplate;
		}

		/**
		 * This function uses a Factory to get the correct VirtualPage implementation.
		 *
		 * @param $content
		 */
		function getContent( $content ) {

			$this->init();
			if( $this->initialized ){
				$content = $this->content;
			}
			# reset init params
			$this->afterFilter();

			return $content;
		}

		/**
		 * This function uses a Factory to get the correct VirtualPage implementation.
		 *
		 * @param $content
		 */
		function getExcerpt( $excerpt ) {
			$this->init();
			if( $this->initialized ){
				$excerpt = $this->content;
			}
			# reset init params
			$this->afterFilter() ;
			return $excerpt;
		}

		public function getDefaultTemplate(){
			global $arrConfig;
			//$defaultTemplate= $arrConfig[Constants::OPTION_PAGE_CONFIG][OPTION_VIRTUAL_PAGE_TEMPLATE_DEFAULT];
			$defaultTemplate= $arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_VIRTUAL_PAGE_TEMPLATE_DEFAULT];

			return $defaultTemplate ;
		}
		/**
		 *
		 * Return true if the string is empty, else return false
		 * @param unknown_type $value
		 */
		public function isStringEmpty( $value ){
			$result=true;

			if( $value != null && strlen($value) > 0){
				$result=false;
			}
			return $result;
		}
	}
}
?>