<?php
/**
 * CustomWpPlugin plugin related constants.  These are used in many
 * different classes.
 *
 * @author -
 */
define('V_TYPE',                        'vt');
define("VT_SITE_MAP",           'sitemap');
if( !interface_exists('Constants')){
    interface Constants{
        const DEBUG = false;

        const CSS_JS_VERSION = 45;

        # Group for Activation related options
        # Also used as menu slug for the Activate Menu
        const SLUG="lpt";

        const OPTIONS="lpt_config";

        const DB_TABLE_PREFIX="lpt_";

        const RETS_IMAGE_BASE_DIR="rets";

        const TYPE_URL_VAR="lpt-type";

        const PAGE_SIZE=8;
        const PRE_DEFINE_PAGE_SIZE=25;
        const AGENT_PROFILE_PAGE_SIZE=25;

        const LISTING_PAGE_SIZE=50;
        const GRIDVIEW_PAGE_SIZE=45;
        const GRIDVIEW_STYLE2_PAGE_SIZE=9;
        const GRIDVIEW_STYLE5_PAGE_SIZE=10;
        const GRIDVIEW_STYLE6_PAGE_SIZE=10;
        //const GRIDVIEW_STYLE10_PAGE_SIZE=6;
        const GRIDVIEW_STYLE10_PAGE_SIZE=45;
        const DEFAULT_SO = 'price';
        const DEFAULT_SD = 'desc';
        const DEFAULT_STATUS = 'all';
        const DEFAULT_LISTINGS = 'sefmiami';
        const VT_MAP = 'map';
        const VT_SITE_MAP = 'sitemap';
        const VT_LIST = 'list';
        const TYPE_LISTING_SEARCH_FORM="listing-search-form";
        const TYPE_THIRD_PARTY_RESPONSE="third-party-response";

        const OPTION_PAGE_CONFIG="page-config";
        const OPTION_VIRTUAL_PAGE_TEMPLATE_DEFAULT="vertual-page-template-default";
        const OPTION_PAGE_TEMPLATE_SEARCH="page-template-search";
        const OPTION_PAGE_TITLE_SEARCH="page-title-search";
        const OPTION_PAGE_PERMALINK_SEARCH="page-permalink-text-search";

        # Listing Search Result VirtualPage Options
        const OPTION_PAGE_TITLE_SEARCH_RESULT="page-title-search-result";
        const OPTION_PAGE_TEMPLATE_SEARCH_RESULT="page-template-search-result";
        const OPTION_PAGE_PERMALINK_SEARCH_RESULT="page-permalink-text-search-result";
        const OPTION_PAGE_SEARCH_RESULT="page-search-result";
        const OPTION_PAGE_PERMALINK_THIRD_PARTY_RESPONSE="page-permalink-text-third_party_response";

        # Listing DetailVirtualPage related options
        const OPTION_PAGE_TITLE_DETAIL="page-title-detail";
        const OPTION_PAGE_TEMPLATE_DETAIL="page-template-detail";
        const OPTION_PAGE_PERMALINK_DETAIL="page-permalink-text-detail";
        const OPTION_PAGE_BROWSER_TITLE_DETAIL="page-browser-title-detail";
        const OPTION_PAGE_META_KEYWORD_DETAIL="page-metakeyword-detail";
        const OPTION_PAGE_META_DESC_DETAIL="page-metadesc-detail";
        const OPTION_PAGE_PROPERTY_MAX_VIEW_EXCEED="page-prop-max-view-exceed";

	    const OPTION_PAGE_PERMALINK_MEMBER_DETAILS="page-permalink-text-member-details";

	    const TYPE_LISTING_DETAIL="listing-detail";
	    const TYPE_MEMBER_DETAIL="member-details";
	    const TYPE_MY_ACCOUNT="myaccount";
	    const TYPE_MARKET_REPORT_DETAIL="market-report";
	    const TYPE_SALES="sales";
	    const TYPE_RENTALS="rentals";
	    const TYPE_SOLD="sold";
	    const TYPE_PRE_DEFINE="info";
	    const TYPE_LISTING_MAPSEARCH="listing-mapsearch";

        # Multiple MLS options
        const MARBEACHES=1;
        const ACTRIS=2;

        const MLS_MARBEACHES="MARBEACHES";
        const MLS_ACTRIS="ACTRIS";
    }
}
?>