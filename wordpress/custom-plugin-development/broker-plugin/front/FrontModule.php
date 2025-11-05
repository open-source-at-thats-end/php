<?php
if( !interface_exists('FrontModule')) {
	interface FrontModule {
		static function getInstance() ;
		function getContent() ;
		function getTitle();
		function getPageTemplate();
		//function getPath();
	}
}
?>