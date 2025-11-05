<?php
if( !class_exists('ORETinyMceManager')) {
	class TinyMceManager {
		
		private static $instance ;
		
		private function __construct(){
			
		}
		
		public static function getInstance(){
			if( !isset(self::$instance)){
				self::$instance = new TinyMceManager();
			}
			return self::$instance;		
		}		
		
		function addButtons(){	
			if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') )
				return;
											
			if ( get_user_option('rich_editing') == 'true') {
				add_filter("mce_external_plugins", array($this,"addTinymcePlugins"));
				add_filter('mce_buttons',          array($this,"registerButtons"));
			}
		}

		/**
		 * Used for TinyMCE to register buttons
		 */
		function registerButtons($buttons) {
			array_push($buttons, "|", "OREShortCodes");
			return $buttons;
		}

		/**
		 * Load the TinyMCE plugin : editor_plugin.js (wp2.5)
		 * Note the url variable is configured in WordPress
		 */
		function addTinymcePlugins($plugin_array) {
			global $arrVirtualPath;
		
            $pluginUrl= $arrVirtualPath['Libs'] . 'tinymce/shortcode/editor_plugin.js';
			$plugin_array['OREShortCodes'] = $pluginUrl ;						
			return $plugin_array;
		}

	}//end class
}// end if class_exists
?>