<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{if isset($PrefixToSiteTitle)}{$PrefixToSiteTitle}{/if}{$SiteTitle|default:$config.site_title}{if isset($AppendToSiteTitle)} : {$AppendToSiteTitle}{/if}</title>
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
    <link rel="dns-prefetch" href="{$MDN_Url}" />
    <link rel="dns-prefetch" href="{$CDN_Url}" />
	<link rel="dns-prefetch" href="{$Data_MDN_Url}" />
	<link rel="dns-prefetch" href="{$Data_CDN_Url}" />
    {*<meta http-equiv="content-language" content="en" />*}
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="google-site-verification" content="yEwJhaMKz9-SbgtjB9cnkG5W_swbGeoKFvU8xJdU5Dk" />
    {if !isset($HideMeta)}
        <meta name="keywords" content="{$MetaKeywords|default:$config.meta_keyword|strtolower}{if isset($config.meta_common_keyword) && !isset($HideGMetaKeyword)}, {$config.meta_common_keyword|strtolower}{/if}" />
        <meta name="description" content="{$MetaDescription|default:$config.meta_description}" />
        {if isset($PageExternalMeta) && $PageExternalMeta != ''}{$PageExternalMeta}{/if}
		{if strpos($Host_Url,'www.')===false}
			<meta name="robots" content="noindex,nofollow" />
		{else}
			{if (isset($CrawlerNoIndex) && isset($CrawlerNoFollow)) || $smarty.const.POPUP_WIN == 'true'}
				<meta name="robots" content="noindex,nofollow" />
			{else}
				{if isset($CrawlerNoIndex) && !isset($CrawlerNoFollow)}
					<meta name="robots" content="noindex,follow" />
				{elseif !isset($CrawlerNoIndex) && isset($CrawlerNoFollow)}
					<meta name="robots" content="index,nofollow" />
				{else}
					<meta name="robots" content="index,follow" />
				{/if}
			{/if}
		{/if}
        {if isset($config.meta_tag_additional)}{$config.meta_tag_additional}{/if}
        {if isset($config.meta_developer)}{$config.meta_developer}{/if}
    {/if}
    <link type="application/opensearchdescription+xml" rel="search" href="{$Host_Url}/opensearch.xml" />
    <link rel="alternate" media="handheld" href="{$Host_Url}" />
    {if isset($IsHome) && $IsHome == true}
        <link rel="alternate" href="{$Host_Url}" hreflang="en" />
        <link rel="alternate" href="{$Host_Url}" hreflang="x-default" />
    {/if}
    <link rel='canonical' href='{if isset($PageCanonicalUrl)}{$PageCanonicalUrl}{else}{$Host_Url}{$smarty.server.REQUEST_URI}{/if}' />
    <link rel="shortcut icon" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.site_favicon}" type="image/png" />

	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-title" content="{$config.smart_phone_app_name}">
	<link rel="apple-touch-icon" sizes="57x57" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_57x57}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_76x76}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_120x120}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_152x152}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_precomposed}" />
    <link rel="apple-touch-startup-image" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_startup}" />

	<meta name="application-name" content="{$config.smart_phone_app_name}" />
	<meta name="application-url" content="{$Main_Host_Url}" />
	<meta name="mobile-web-app-capable" content="yes" />
	<link rel="icon" sizes="192x192" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_152x152}" />
	<link rel="icon" sizes="128x128" href="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.apple_ti_120x120}" />

	<link id="app-css" type="text/css" rel="stylesheet" href="{$Data_MDN_Url}/{$config.site_timestamp}/{urlencode(implode('|',$Css))}/fcss.css" media="screen, print" />
    {if isset($PageExternalCSS) && $PageExternalCSS != ''}<style type="text/css">{$PageExternalCSS}</style>{/if}

    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
</head>
<body>
<header class="sb-slide">
	<div class="container-fluid">
        {if cw::$screen == CW_S_MD || cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}
        <div class="row header-top hidden-md-down">
            <div class="col-md-6"></div>
            <div class="col-md-6 top-links">
                <ul class="pull-right top-links">
                    {*<li><a real="index" href=""><i class="fa fa-gift"></i> Sell With Us</a></li>*}
                    {if isset($WebPageByList.PAGE_MANAGER_ID_PRODUCT_COMPARE)}<li><a class="" href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_PRODUCT_COMPARE.webpage_safe_url}"><i class="fa fa-clone"></i> {$WebPageByList.PAGE_MANAGER_ID_PRODUCT_COMPARE.webpage_title}</a></li>{/if}
                    {if isset($IsUserLogged) && $IsUserLogged === STATUS_ONLINE}
                        <li class="pull-right user-login-box">
                            <a class="text-capitalize p-a-0 dropdown-toggle disable-select btn-user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i>&nbsp; {$_RECUSER[UserMaster::obj()->Data[$smarty.const.F_P_FIELD]]} {$_RECUSER[UserMaster::obj()->Data[$smarty.const.FIELD_PREFIX]|cat:'lastname']}</a>
                            {if isset($WebPageByTree.PAGE_MANAGER_ID_MYACCOUNT.child) && is_array($WebPageByTree.PAGE_MANAGER_ID_MYACCOUNT.child)}
                                <div class="dropdown-menu">
                                    {foreach name='uam' from=$WebPageByTree.PAGE_MANAGER_ID_MYACCOUNT.child key=id item=info}
                                        {if isset($WebPageByList[$id])}
                                            {if $id == PAGE_MANAGER_ID_CHECKOUT}{continue}{/if}
                                            <a class="dropdown-item {if $id == PAGE_MANAGER_ID_LOGOUT}text-danger{/if}" href="{if $id == PAGE_MANAGER_ID_LOGOUT}{$Main_Host_Url}/{$WebPageByList[$id].webpage_safe_url}{else}{$USER_ACCOUNT_RW_URL}/{$WebPageByList[$id].webpage_safe_url}{/if}"><i class="fa {$OL_uai.$id|default:''}"></i>&nbsp; {$WebPageByList[$id].webpage_title}</a>
                                        {/if}
                                    {/foreach}
                                </div>
                            {/if}
                        </li>
                    {else}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_VISITED_PRODUCT)}<li><a href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_VISITED_PRODUCT.webpage_safe_url}"><i class="fa fa-eye"></i> {$WebPageByList.PAGE_MANAGER_ID_VISITED_PRODUCT.webpage_title}</a></li>{/if}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_WISHLIST)}<li><a href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_WISHLIST.webpage_safe_url}"><i class="fa fa-heart"></i> {$WebPageByList.PAGE_MANAGER_ID_WISHLIST.webpage_title}</a></li>{/if}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_LOGIN_SIGNUP)}<li><a href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_LOGIN_SIGNUP.webpage_safe_url}"> <i class="fa fa-user"></i>&nbsp; {$WebPageByList.PAGE_MANAGER_ID_LOGIN_SIGNUP.webpage_title}</a></li>{/if}
                    {/if}
                </ul>
            </div>
        </div>
        {/if}
        <div class="row header-middle">
			<div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 p-a-0">
                {if isset($InCheckout) && $InCheckout === false}<a  href="javascript:void(0);" class="sb-toggle-left mm-toggle" role="menubutton"><i class="fa fa-bars fa-2x"></i><span>SHOP</span></a>{/if}
			</div>
            <div class="col-xs-8 col-sm-8 col-md-3 col-lg-3 col-xl-3 p-a-0 text-xs-center brand-logo">
                <a href="{$Main_Host_Url}"><img width="185" class="img-fluid" src="{$MDN_Url}{$SC_V_ENC_Upload_Root}/{$config.site_logo}" alt="{$config.browser_title}" /></a>
            </div>
            {if cw::$screen == CW_S_MD || cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}
            <div class="col-xs-0 col-sm-0 col-md-7 col-lg-5 col-xl-5 p-r-0 hidden-sm-down search-box">
                <form role="form" name="site-search" class="site-search" id="site-search" method="get" action="{$Host_Url}/{SU_ER_LISTING_PAGE}/{SURL_QUERY}/">
                    <div class="input-group">
                        <input role="search" autocomplete="off" name="q" id="q" type="text" class="form-control" placeholder="So...What are you looking for today?" maxlength="30" value="{if isset($arrParams[$smarty.const.SURL_QUERY]) && is_array($arrParams[$smarty.const.SURL_QUERY])}{$arrParams[$smarty.const.SURL_QUERY][0]}{else}{$arrParams[$smarty.const.SURL_QUERY]|default:''}{/if}" />
                    </div>
                    <div class="input-group-btn">
                        <button form="site-search" class="btn btn-primary" type="submit"><span>Search</span><!--class="hidden-md-down" <span class="hidden-lg-up"><i class="fa fa-search"></i></span>--></button>
                    </div>
                </form>
            </div>
            {/if}
            {if cw::$screen == CW_S_MD || cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}
            <div class="col-xs-0 col-sm-0 col-md-0 col-lg-2 col-xl-2 text-xs-center hidden-md-down help">
                {if isset($WebPageByList.PAGE_MANAGER_ID_HELP)}<a class="btn btn-info-outline text-uppercase" href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_HELP.webpage_safe_url}"><i class="fa fa-info-circle fa-lg"></i> {$WebPageByList.PAGE_MANAGER_ID_HELP.webpage_title}</a>{/if}
            </div>
            {/if}
            {*<div class="col-xs-0 col-sm-0 col-md-0 col-lg-2 col-xl-2 text-center hidden-sm-down free-posting">
                <a class="btn fp-btn fp-btn-font" href="javascript:void(0);">Free Posting</a>
            </div>*}
            <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 p-a-0">
                {if isset($InCheckout) && $InCheckout === false}<a href="javascript:void(0);" class="pc-toggle" data-rsb-tab="#rsb-1"><i class="fa fa-shopping-cart fa-2x"></i><span>Cart <strong id="cart-item-count" class="label label-pill label-info">{if isset($SCGrandTotal.shopping_cart_total_item_quantity)}{$SCGrandTotal.shopping_cart_total_item_quantity}{else}0{/if}</strong></span></a>{/if}
            </div>
        </div>
    </div>
</header>
{if isset($InCheckout) && $InCheckout === false}
	<div data-sidebars-mt="0" data-sb-width="210px" class="mm-container sb-width-custom sb-slidebar sb-left  sb-style-overlay{*sb-static sb-style-overlay sb-style-push*} sb-momentum-scrolling">
		<div class="mm-header clearfix">
			<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-a-0"><button class="sb-close btn btn-link"><i class="fa fa-angle-left fa-2x"></i></button></div>
			<div class="col-xs-9 col-sm-10 col-md-10 col-lg-10 col-xl-10 p-a-0"><h4 class="m-t-1 text-xs-center">CLICK &amp; SHOP</h4></div>
		</div>
		<nav data-sidebars-mb="0" role="navigation">
			{include file="menu-main.tpl"}
		</nav>
		{*include file="menu-main-mega.tpl"*}
	</div>
	<div data-sidebars-mt="0" data-sb-width="300px" class="pc-container sb-width-custom sb-slidebar sb-right sb-style-overlay sb-momentum-scrolling">
		<div class="clearfix" data-sidebars-mb="0">
			<div class="pc-header clearfix">
				<div class="col-xs-9 col-sm-10 col-md-10 col-lg-10 col-xl-10 p-a-0">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a href="javascript:void(0);" class="nav-link active" data-toggle="tab" data-target="#rsb-1" role="tab"><i class="fa fa-shopping-cart fa-2x"></i></a>
						</li>
						<li class="nav-item">
							<a href="javascript:void(0);" class="nav-link" data-toggle="tab" data-target="#rsb-2" role="tab"><i class="fa fa-heart fa-2x"></i></a>
						</li>
						<li class="nav-item">
							<a href="javascript:void(0);" class="nav-link" data-toggle="tab" data-target="#rsb-3" role="tab"><i class="fa fa-eye fa-2x"></i></a>
						</li>
						<li class="nav-item">
							<a href="javascript:void(0);" class="nav-link" data-toggle="tab" data-target="#rsb-4" role="tab"><i class="fa fa-clone fa-2x"></i></a>
						</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-a-0"><button class="sb-close btn btn-link"><i class="fa fa-angle-right fa-2x"></i></button></div>
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="rsb-1" role="tabpanel">
					{include file="tpl_pc/pc-shopping-cart.tpl"}
				</div>
				<div class="tab-pane" id="rsb-2" role="tabpanel">
					<div class="clearfix" id="rsb-2-1">{include file="lp-wl.tpl"}</div>
					<div class="text-xs-center">
						<a href="{if isset($IsUserLogged) && $IsUserLogged === STATUS_ONLINE}{$USER_ACCOUNT_RW_URL}/{$WebPageByList.PAGE_MANAGER_ID_MY_WHISHLIST.webpage_safe_url}{else}{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_WISHLIST.webpage_safe_url}{/if}" class="btn btn-link">View All <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
				<div class="tab-pane" id="rsb-3" role="tabpanel">
					<div class="clearfix" id="rsb-3-1">{include file="lp-rv.tpl"}</div>
					<div class="text-xs-center">
						<a href="{if isset($IsUserLogged) && $IsUserLogged === STATUS_ONLINE}{$USER_ACCOUNT_RW_URL}/{$WebPageByList.PAGE_MANAGER_ID_MY_VISITED_PRODUCT.webpage_safe_url}{else}{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_VISITED_PRODUCT.webpage_safe_url}{/if}" class="btn btn-link">View All <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
				<div class="tab-pane" id="rsb-4" role="tabpanel">
					<div class="clearfix" id="rsb-4-1">{include file="lp-compare.tpl"}</div>
					<div class="text-xs-center">
						<a href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_PRODUCT_COMPARE.webpage_safe_url}" class="btn btn-link">View All <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
{/if}
<div id="sb-site">
    <div id="main-body" class="{$BodyBG|default:''}">{include file=$T_Body|default:'page.tpl'}</div>
    <footer>
        {if cw::$screen == CW_S_MD || cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}
        <div class="hidden-sm-down footer-big">
            <div class="container">
                {if isset($WebPageByPosition[$smarty.const.WEBPP_FOOTER])}
                <div class="row">
                    <ul class="text-xs-center top-links">
                        {foreach from=$WebPageByPosition[$smarty.const.WEBPP_FOOTER] key=id item=info}
                            {if $WebPageByList[$id].webpage_id != $smarty.const.PAGE_MANAGER_ID_COMPANY_POLICY}
                                {if isset($WebPageByList[$id])}
                                    {if $id == PAGE_MANAGER_ID_HOME}{$WebPageByList[$id].webpage_safe_url = ''}{/if}
                                    {if isset($IsUserLogged) && $IsUserLogged === STATUS_ONLINE && ($id == PAGE_MANAGER_ID_WISHLIST || $id == PAGE_MANAGER_ID_VISITED_PRODUCT)}
                                        {*if $id == PAGE_MANAGER_ID_WISHLIST || $id == PAGE_MANAGER_ID_VISITED_PRODUCT}{/if*}
                                        {*<li><a href="{if isset($IsUserLogged) && $IsUserLogged === STATUS_ONLINE}{$USER_ACCOUNT_RW_URL}{else}{$Host_Url}{/if}/{$WebPageByList[$id].webpage_safe_url}">{$WebPageByList[$id].webpage_link_title}</a></li>*}
                                    {else}
                                        <li><a href="{$Host_Url}/{$WebPageByList[$id].webpage_safe_url}">{$WebPageByList[$id].webpage_link_title}</a></li>
                                    {/if}
                                {/if}
                            {/if}
                        {/foreach}
                    </ul>
                </div>
                {/if}
                {*<div class="row">
                    <div class="footer-details">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus volutpat dapibus leo</p>
                    </div>
                </div>*}
                {*<div class="row">
                    <div class="process-step">
                        <div class="col-md-4">
                            <div class="sellwithus">
                                <a href="javascript:void(0);"> <i class="fa fa-gift fa-3x"></i><span>&nbsp; Sell With Us</span></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mybusiness">
                                <a href="javascript:void(0);"> <i class="fa fa-briefcase fa-3x"></i><span>&nbsp; My Business</span></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="login-signup">
                                <a href="javascript:void(0);"> <i class="fa fa-user fa-3x"></i><span>&nbsp; Login/Sign Up</span></a>
                            </div>
                        </div>
                    </div>
                </div>*}
                {*<div class="row">
                    <div class="social-pay">
                        <div class="col-md-4">
                            <h4>Keep in Touch</h4>
                            <ul>
                                <a href="javascript:void(0);"> <li class="fa fa-facebook-square fa-2x"> </li></a>
                                <a href="javascript:void(0);"> <li class="fa fa-google-plus-square fa-2x"> </li></a>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <h5>100% Secure and Trusted Payment</h5>
                            <p class="m-b-0"> We accept Net Banking, all major Credit cards, Debit cards, and Cash Cards.We also offer Cash on Delivery and India's largest selection of EMI options.</p>
                            <img class="img-responsive" src="" alt="">
                        </div>
                    </div>
                </div>*}
                {*<div class="row">
                    <nav class="nav">
                        <a class="nav-link" href="javascript:void(0);"> Ahmedabad </a>
                        <a class="nav-link" href="javascript:void(0);"> More+ </a>
                    </nav>
                </div>*}
                {if isset($PSByList) && is_array($PSByList) && count($PSByList) > 0}
                    <div class="row b-dotted-t m-t-1 p-t-1">
                        <ul class="text-xs-center top-links">
                            {foreach from=$PSByList key=psid item=psinfo}
                                <li><a href="{$Host_Url}/{SU_ER_LISTING_PAGE}/{SURL_PREDEFINED_SEARCH}/{$psinfo[PredefinedSearch::obj()->Data[$smarty.const.FIELD_PREFIX]|cat:'safe_url']}">{$psinfo[PredefinedSearch::obj()->Data[$smarty.const.FIELD_PREFIX]|cat:'link_title']}</a></li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
            <div class="container-fluid">
                <div class="row footerbottom">
                    <div class="col-md-6 p-x-0">
                        {if isset($WebPageByList[$smarty.const.PAGE_MANAGER_ID_COMPANY_POLICY])}
                        <ul class="top-links">
                            {foreach from=$CPolicyByList item=cpid item=cpinfo}
                                <li><a href="{$Host_Url}/{$WebPageByList[$smarty.const.PAGE_MANAGER_ID_COMPANY_POLICY].webpage_safe_url}/{$cpinfo.cpm_safe_url}">{$cpinfo.cpm_title}</a></li>
                            {/foreach}
                        </ul>
                        {/if}
                    </div>
                    <div class="col-md-6 text-xs-right">
                        <p class="copyright-link m-b-0">{str_replace(array('[CUR_YEAR]','[COPY_RIGHT]'),array(date('Y'),'<span>&copy;</span>'),$config.copyright_text)}</p>
                    </div>
                </div>
            </div>
        </div>
        {/if}
    </footer>
</div>
<div class="sb-slide hidden-lg-up footer-quick-access">
    <div class="container-fluid">
        <div class="row" id="quick-access">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <nav class="owl-theme-2">
                    {if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM}
                        <a class="btn btn-link"  href="javascript:void(0);" data-toggle="modal" data-target="#site-search-modal"><i class="fa fa-search"></i><small>Search</small></a>
                    {/if}
                    {if isset($IsUserLogged) && $IsUserLogged === STATUS_ONLINE}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_DASHBOAD)}<a class="btn btn-link" href="{$USER_ACCOUNT_RW_URL}/{$WebPageByList.PAGE_MANAGER_ID_DASHBOAD.webpage_safe_url}"><i class="fa fa-user"></i><small>It's Me</small></a>{/if}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_MY_ORDER)}<a class="btn btn-link" href="{$USER_ACCOUNT_RW_URL}/{$WebPageByList.PAGE_MANAGER_ID_MY_ORDER.webpage_safe_url}"><i class="fa fa-flash"></i><small>{$WebPageByList.PAGE_MANAGER_ID_MY_ORDER.webpage_title}</small></a>{/if}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_MY_WHISHLIST)}<a class="btn btn-link " href="{$USER_ACCOUNT_RW_URL}/{$WebPageByList.PAGE_MANAGER_ID_MY_WHISHLIST.webpage_safe_url}"><i class="fa fa-heart"></i><small>{$WebPageByList.PAGE_MANAGER_ID_MY_WHISHLIST.webpage_title}</small></a>{/if}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_MY_VISITED_PRODUCT)}<a class="btn btn-link" href="{$USER_ACCOUNT_RW_URL}/{$WebPageByList.PAGE_MANAGER_ID_MY_VISITED_PRODUCT.webpage_safe_url}"><i class="fa fa-eye"></i><small>{$WebPageByList.PAGE_MANAGER_ID_MY_VISITED_PRODUCT.webpage_title}</small></a>{/if}
                    {else}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_LOGIN_SIGNUP)}<a class="btn btn-link" href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_LOGIN_SIGNUP.webpage_safe_url}"><i class="fa fa-user"></i><small>{$WebPageByList.PAGE_MANAGER_ID_LOGIN_SIGNUP.webpage_title}</small></a>{/if}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_VISITED_PRODUCT)}<a class="btn btn-link" href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_VISITED_PRODUCT.webpage_safe_url}"><i class="fa fa-eye"></i><small>{$WebPageByList.PAGE_MANAGER_ID_VISITED_PRODUCT.webpage_title}</small></a>{/if}
                        {if isset($WebPageByList.PAGE_MANAGER_ID_WISHLIST)}<a class="btn btn-link " href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_WISHLIST.webpage_safe_url}"><i class="fa fa-heart"></i><small>{$WebPageByList.PAGE_MANAGER_ID_WISHLIST.webpage_title}</small></a>{/if}
                    {/if}
                    {if isset($WebPageByList.PAGE_MANAGER_ID_PRODUCT_COMPARE)}<a class="btn btn-link" href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_PRODUCT_COMPARE.webpage_safe_url}"><i class="fa fa-clone"></i><small>{$WebPageByList.PAGE_MANAGER_ID_PRODUCT_COMPARE.webpage_title}</small></a>{/if}
                    {if isset($WebPageByList.PAGE_MANAGER_ID_HELP)}<a class="btn btn-link" href="{$Host_Url}/{$WebPageByList.PAGE_MANAGER_ID_HELP.webpage_safe_url}"><i class="fa fa-info-circle"></i><small>{$WebPageByList.PAGE_MANAGER_ID_HELP.webpage_title}</small></a>{/if}
                </nav>
            </div>
        </div>
    </div>
</div>
{if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM}
<div class="modal fade modal-theme-1 modal-expanded" id="site-search-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-xs-left p-a-0">
                    <button type="button" class="close back-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-angle-left fa-2x"></i></span>
                    </button>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-xs-right p-a-0">
                    <button form="site-search" type="submit" class="btn btn-primary btn-2">Apply</button>
                </div>
            </div>
            <div class="modal-body">
                <form role="form" name="site-search" class="site-search" id="site-search" method="get" action="{$Host_Url}/{SU_ER_LISTING_PAGE}/{SURL_QUERY}/">
                    <input role="search" autocomplete="off" name="q" id="q" type="text" class="form-control" placeholder="So...What are you looking for today?" maxlength="30" value="{if isset($arrParams[$smarty.const.SURL_QUERY]) && is_array($arrParams[$smarty.const.SURL_QUERY])}{$arrParams[$smarty.const.SURL_QUERY][0]}{else}{$arrParams[$smarty.const.SURL_QUERY]|default:''}{/if}" />
                </form>
            </div>
        </div>
    </div>
</div>
{/if}
{if !isset($HideContactUsPopUp) && !isset($IsUserLogged) || $IsUserLogged != STATUS_ONLINE}
    {include file="contact-us-form.tpl" InPopUp=true}
{/if}
<div class="hidden-sm-down back-top"><i class="fa fa-chevron-up fa-2x"></i></div>
<div id="DEBUGINFO"></div>
{*<script type="text/javascript">document.domain= '{$smarty.server.NON_WWW_HTTP_HOST}';</script>*}
{*<script data-id="App.Config">var UnderMaintenanceNotice='{if isset($UnderMaintenanceNotice)}{$UnderMaintenanceNotice}{else}{NO}{/if}', InPopUp='{if defined('POPUP_WIN')}{YES}{else}{NO}{/if}', CurDateTime='{date("Y/m/d H:i:s")}', msgSuccess='{$msgSuccess}', msgError='{$msgError}', TPL_images='{$TPL_images}',Site_Root='{$Site_Root}',XHR_Url='{$XHR_Url}', InCheckout={if $InCheckout===true}true{else}false{/if},IsUserLogged={if isset($IsUserLogged) && $IsUserLogged == STATUS_ONLINE}true{else}false{/if},primaryColor='{THEME_PRIMARY_COLOR}',dangerColor='{THEME_DANGER_COLOR}',successColor='{THEME_SUCCESS_COLOR}',infoColor='{THEME_INFO_COLOR}',warningColor='{THEME_WARNING_COLOR}',inverseColor='{THEME_INVERSE_COLOR}',CR='{TRANTYPE_CREDIT}',DR='{TRANTYPE_DEBIT}',YES='{YES}',NO='{NO}',DEV=false;</script>*}
{*<script id="load-js" type="text/javascript" src="{$CDN_Url}/templates/js/load.js?t={$config.site_timestamp}" data-src="{$CDN_Url}/fjs.js?f={implode('|',$JavaScript)}&t={$config.site_timestamp}"></script>*}
{*<script id="app-js" type="text/javascript" src="{$CDN_Url}/fjs.js?f={implode('|',$JavaScript)}&t={$config.site_timestamp}" async=""></script>*}
<script type="text/javascript" rel="nofollow,noindex">var UnderMaintenanceNotice='{if isset($UnderMaintenanceNotice)}{$UnderMaintenanceNotice}{else}{NO}{/if}', InPopUp='{if defined('POPUP_WIN')}{YES}{else}{NO}{/if}', CurDateTime='{date("Y/m/d H:i:s")}', msgSuccess='{$msgSuccess}', msgError='{$msgError}', TPL_images='{$TPL_images}',Site_Root='{$Site_Root}',XHR_Url='{$XHR_Url}', InCheckout={if $InCheckout===true}true{else}false{/if},IsUserLogged={if isset($IsUserLogged) && $IsUserLogged == STATUS_ONLINE}true{else}false{/if},primaryColor='{THEME_PRIMARY_COLOR}',dangerColor='{THEME_DANGER_COLOR}',successColor='{THEME_SUCCESS_COLOR}',infoColor='{THEME_INFO_COLOR}',warningColor='{THEME_WARNING_COLOR}',inverseColor='{THEME_INVERSE_COLOR}',CR='{TRANTYPE_CREDIT}',DR='{TRANTYPE_DEBIT}',YES='{YES}',NO='{NO}',DEV=false;</script>
<script id="app-js" type="text/javascript" src="{$Data_CDN_Url}/{$config.site_timestamp}/{urlencode(implode('|',$JavaScript))}/fjs.js" async=""></script>
{if isset($PageExternalJS) && $PageExternalJS != ''}<script type="text/javascript">{$PageExternalJS}</script>{/if}
{if isset($Google_Analytics)}{$Google_Analytics}{/if}
</body>
</html>