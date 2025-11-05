{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Real Estate</h2>
<ul class="nav nav-tabs" id="myTab">
    <!--li class="active"><a data-toggle="tab" href="#tab1">RETS Setting</a></li-->
    <li class="active"><a data-toggle="tab" href="#tab-agent">Agent Details</a></li>
    <li><a data-toggle="tab" href="#tab2">Listing Config</a></li>
    <li><a data-toggle="tab" href="#tab3">Listing SEO</a></li>
    <li><a data-toggle="tab" href="#tab4">Color Setting</a></li>
    <li><a data-toggle="tab" href="#tab6">Other Setting</a></li>
    <li><a data-toggle="tab" href="#tab7">Social Config</a></li>
    <li><a data-toggle="tab" href="#tab5">Help</a></li>
</ul>
<form id="frmSettings" action="" method="post" enctype="multipart/form-data">
    <div class="tab-content" style="overflow: unset;">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span8">
                    <div>
                        <label>Name</label>
                        <input type="text" id="agent_name" name="AgentConfig[agent_name]" value="{$arrAgentConfig.agent_name}" class="input-xxlarge required"/>
                        <label class="error" for="agent_name">Enter Your Name</label>
                    </div>
                    <div>
                        <label>E-mail</label>
                        <input type="text" id="agent_email" name="AgentConfig[agent_email]" value="{$arrAgentConfig.agent_email}" class="input-xxlarge required"/>
                        <label class="error" for="agent_email">Enter Your E-mail</label>
                    </div>
                    <div>
                        <label>Phone No.</label>
                        <input type="text" id="agent_phone" name="AgentConfig[agent_phone]" minlength="10" maxlength="15" value="{$arrAgentConfig.agent_phone}" class="input-xxlarge phone_no- required"/>
                        <label class="error" for="agent_phone">Enter Your Phone Number</label>
                    </div>
                    <div>
                        <label>About You</label>
                        <textarea id="agent_about" name="AgentConfig[agent_about]" class="input-xxlarge mb-2">{$arrAgentConfig.agent_about}</textarea>
                        <label class="error" for="agent_about">Enter something about you</label>
                    </div>
                    <div>
                        <label>Address</label>
                        <textarea id="agent_address" name="AgentConfig[agent_address]" class="input-xxlarge mb-2">{$arrAgentConfig.agent_address}</textarea>
                        <label class="error" for="agent_address">Enter Your Address</label>
                    </div>
                    {* <div>
                        <label>System Name</label>
                        <select id="agent_system_name" name="AgentConfig[agent_system_name]">
                            {foreach from=$arrAgentSystemName key=key item=item}
                                <option value="{$key}" {if $key == $arrAgentConfig['agent_system_name']}selected {elseif $arrAgentConfig['agent_system_name'] == '' && $key == 'No'}selected{/if}>{$item}</option>
                            {/foreach}
                        </select>
                    </div> *}
                    <div>
                        <label>Photo</label>
                        <input type="file" name="agent_photo" id="agent_photo" class="input-xlarge" />
                        {if $arrAgentConfig.agent_photo != ''}<br/><br />
                            <img src="{$uploadPath}{$arrAgentConfig.agent_photo}" width="90"/>
                            <input type="hidden" name="prev_agent_photo" value="{$arrAgentConfig.agent_photo}" /><br/><br/>
                        {else}
                            <br/><img src="{$agentImgUrl}no-agent-img.jpg" width="90"/><br/><br/>
                        {/if}
                    </div>
                    <div class="">
                        <label>Email Logo</label>
                        <input type="file" name="print_photo" id="print_photo" class="input-xlarge" />
                        {if $arrAgentConfig.print_photo != ''}<br/><br />
                            <img src="{$uploadPath}{$arrAgentConfig.print_photo}" width="90"/>
                            <input type="hidden" name="prev_print_photo" value="{$arrAgentConfig.print_photo}" />
                        {/if}
                    </div>
                    <div><label>&nbsp;</label></div>
                </div>
            </div><span class="clearfix"></span>
        </div>
        <div id="tab2" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                {literal}
                    <style>
                        .field-list {max-height:500px; overflow:auto}
                        .sub-list {margin-left:20px; width:98%; padding:1%; background:#fff; float:left}
                        .sub-list label {float:left; width:48%;}
                        .sub-list label input {margin-right:3px;}
                    </style>
                {/literal}
                <div class="span8">
                    <h5>Address Format</h5>
                    <div>
                        <label>Full</label>
                        <input type="text" id="address_full" name="Listing[AddressFull]" value="{$arrListingConfig.AddressFull.Format}" class="input-xxlarge required"/>
                        <label class="error" for="address_full">Enter full address format</label>
                    </div>
                    <div>
                        <label>Short</label>
                        <input type="text" id="address_short" name="Listing[AddressShort]" value="{$arrListingConfig.AddressShort.Format}" class="input-xxlarge required"/>
                        <label class="error" for="address_short">Enter short address format</label>
                    </div>
                   {* <h5>Search Form</h5>
                    <div>
                        <label>Page Title</label>
                        <input type="text" id="page_title_search" name="PageConfig[page-title-search]" value="{$arrPageConfig['page-title-search']}" class="input-xxlarge required"/>
                        <label class="error" for="page_title_search">Enter page title</label>
                    </div>
                    <div>
                        <label>Slug</label>
                        <input type="text" id="page_slug_search" name="PageConfig[page-permalink-text-search]" value="{$arrPageConfig['page-permalink-text-search']}" class="input-xxlarge sefurl required"/>
                    </div>*}
                    {*<div>
                        <label>Page Template</label>
                        <select id="page-template-detail" name="PageConfig[page-template-search]">
                            <option value="">Default Template</option>
                            {html_options options=$arrThemeTemplates selected=$arrPageConfig['page-template-search']}
                        </select>
                    </div>*}
                    {*<h5>Search Result</h5>
                    <div>
                        <label>Page Title</label>
                        <input type="text" id="page_title_search_result" name="PageConfig[page-title-search-result]" value="{$arrPageConfig['page-title-search-result']}" class="input-xxlarge required"/>
                        <label class="error" for="page_title_search_result">Enter page title</label>
                    </div>
                    <div>
                        <label>Slug</label>
                        <input type="text" id="page_slug_search_result" name="PageConfig[page-permalink-text-search-result]" value="{$arrPageConfig['page-permalink-text-search-result']}" class="input-xxlarge sefurl required"/>
                    </div>*}
                    <div class="mb-2">
                        <label>Page</label>
                        <select id="page-search-result" name="PageConfig[page-search-result]">
                            {*                            <option value="">Default Page</option>*}
                            {foreach from=$arrThemePages key=key item=item}
                                <option value="{$item->ID}" {if $item->ID == $arrPageConfig['page-search-result']}selected{/if}>{$item->post_title}</option>
                            {/foreach}
                            {*                            {html_options options=$arrThemePages['post_title'] selected=$arrPageConfig['page-search-result']}*}
                        </select>
                    </div>
                    {*<pre>{$arrOtherConfig|print_r}*}
                    {if $arrOtherConfig.login_enable == 'Yes'}
                        <div class="mb-2">
                            <label>Signup Required to View Property</label>
                            <select id="signup_required_for_view_property" name="Listing[signup_required_for_view_property]">
                                {foreach from=$arrYesNo key=key item=item}
                                    <option value="{$key}" {if $key == $arrListingConfig['signup_required_for_view_property']}selected {elseif $arrListingConfig['signup_required_for_view_property'] == '' && $key == 'No'}selected{/if}>{$item}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div>
                            <label># of listing viewed before asking for login/registration</label>
                            <input type="text" id="site_max_full_details_without_login" name="Listing[site_max_viewed_without_login]" value="{if isset($arrListingConfig.site_max_viewed_without_login) && $arrListingConfig.site_max_viewed_without_login != 0}{$arrListingConfig.site_max_viewed_without_login}{else}0{/if}" class="input-xxlarge"/>
                            {*                        <span>Keep it 0 for unlimited.</span>*}
                        </div>
                    {/if}
                    <div class="mb-2">
						<label>Enable Google Captcha ?</label>
						<select id="enable_google_captcha" name="Listing[enable_google_captcha]">
							{foreach from=$arrYesNo key=key item=item}
								<option value="{$key}" {if $key == $arrListingConfig['enable_google_captcha']}selected {elseif $arrListingConfig['enable_google_captcha'] == '' && $key == 'No'}selected{/if}>{$item}</option>
							{/foreach}
						</select>
					</div>
				    <div>
						<label>Google Captcha Site Key</label>
						<input type="text" id="google_site_key" name="Listing[google_site_key]" value="{$arrListingConfig['google_site_key']}" class="input-xxlarge"/>
					</div>
					<div>
						<label>Google Captcha Secret Key</label>
						<input type="text" id="google_secret_key" name="Listing[google_secret_key]" value="{$arrListingConfig['google_secret_key']}" class="input-xxlarge"/>
					</div>
					<div>
                        <label>CC Email</label>
                        <input type="text" id="cc_emails" name="Listing[cc_emails]" value="{$arrListingConfig['cc_emails']}" class="input-xxlarge" placeholder="Separate multiple emails with comma"/>
                        <p> <b>Note:</b> Enter email with comma separate which you want to add in CC to get all lead emails</p>
                    </div>
                    {*<div>
                        <label>Page Template</label>
                        <select id="page-template-detail" name="PageConfig[page-template-search-result]">
                            <option value="">Default Template</option>
                            {html_options options=$arrThemeTemplates selected=$arrPageConfig['page-template-search-result']}
                        </select>
                    </div>*}
                </div>
                <div class="span3">
                    <h5>Listing Fields</h5>
                    <div class="field-list">
                        {foreach from=$arrListingField key=key item=item}
                            <p>{$item}</p>
                        {/foreach}
                    </div>
                </div>
            </div>
            <span class="clearfix"></span>
        </div>
        <div id="tab3" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                <strong></strong>
                <div class="span8">
                    <h5>Listing Detailed Page</h5>
                    <div>
                        <label>Page Title</label>
                        <input type="text" id="page_title_listing_detail" name="PageConfig[page-title-detail]" value="{$arrPageConfig['page-title-detail']['Format']}" class="input-xxlarge required"/>
                        <label class="error" for="page_title_listing_detail">Enter page title</label>
                    </div>
                    <div>
                        <label>Browser Title</label>
                        <input type="text" id="page_browser_title_listing_detail" name="PageConfig[page-browser-title-detail]" value="{$arrPageConfig['page-browser-title-detail']['Format']}" class="input-xxlarge"/>
                        <label class="error" for="page_browser_title_listing_detail">Enter browser title</label>
                    </div>
                    <div>
                        <label>Slug</label>
                        <input type="text" id="page_slug1_listing_detail" name="PageConfig[page-permalink-text-detail][slug-1]" value="{$arrPageConfig['page-permalink-text-detail']['slug-1']}" class="input-medium sefurl required"/>/
                        <input type="text" id="page_slug2_listing_detail" name="PageConfig[page-permalink-text-detail][slug-2]" value="{$arrPageConfig['page-permalink-text-detail']['slug-2']}" class="input-xxlarge sefurl required"/>-mls-MLS_NUM
                    </div>
                    <div>
                        <label>Condo Slug</label>
                        <input type="text" id="page_slug1_listing_detail" name="PageConfig[page-permalink-text-detail][condo-slug-1]" value="{$arrPageConfig['page-permalink-text-detail']['condo-slug-1']}" class="input-medium sefurl required"/>/
                        <input type="text" id="page_slug2_listing_detail" name="PageConfig[page-permalink-text-detail][condo-slug-2]" value="{$arrPageConfig['page-permalink-text-detail']['condo-slug-2']}" class="input-xxlarge sefurl required"/>-mls-MLS_NUM
                    </div>
                   {* <div>
                        <label>Page Template</label>
                        <select id="page-template-detail" name="PageConfig[page-template-detail]">
                            <option value="">Default Template</option>
                            {html_options options=$arrThemeTemplates selected=$arrPageConfig['page-template-detail']}
                        </select>
                    </div>*}
                    <div>
                        <label>Meta Keywords</label>
                        <textarea id="page_metakeyword_listing_detail" name="PageConfig[page-metakeyword-detail]" class="input-xxlarge mb-2">{$arrPageConfig['page-metakeyword-detail']['Format']}</textarea>
                        <label class="error" for="page_metakeyword_listing_detail">Enter meta keywords</label>
                    </div>
                    <div>
                        <label>Meta Description</label>
                        <textarea id="page_metadesc_listing_detail" name="PageConfig[page-metadesc-detail]" class="input-xxlarge">{$arrPageConfig['page-metadesc-detail']['Format']}</textarea>
                        <label class="error" for="page_metadesc_listing_detail">Enter meta description</label>
                    </div>
                    {*<div>
                        <label>Max. Properties allowed to view without registration</label>
                        <input type="text" id="prop-max-view-exceed" name="PageConfig[page-prop-max-view-exceed]" value="{$arrPageConfig['page-prop-max-view-exceed']['Format']}" class="input-xxlarge"/>
                        *}{*}{*<label class="error" for="prop-max-view-exceed">How many times user have viewed listing details</label>*}{*}{*
                    </div>*}
                </div>
                <div class="span3">
                    <h5>Listing Fields</h5>
                    <div class="field-list">
                        {foreach from=$arrListingField key=key item=item}
                            <p>{$item}</p>
                        {/foreach}
                    </div>
                </div>
            </div>
            <span class="clearfix"></span>
        </div>
        <div id="tab4" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                <strong></strong>
                <div class="span8">
                    <h5>Color Settings</h5>
                    <div class="fholder2">
                        <div>
                            <label>Button Color</label><br>
                            <input type="text" id="button_color" autocomplete="off" name="OtherConfig[btn_color]" value="{if isset($arrOtherConfig['btn_color']) && $arrOtherConfig['btn_color'] != ''}{$arrOtherConfig['btn_color']}{else}#3a3a3a{/if}" class="input-xlarge"/>
                            <label class="error" for="button_color">Enter button color</label>
                        </div>
                        <div>
                            <label>Button Text Color</label><br>
                            <input type="text" id="btn_txt_color" autocomplete="off" name="OtherConfig[btn_txt_color]" value="{if isset($arrOtherConfig['btn_txt_color']) && $arrOtherConfig['btn_txt_color'] != ''}{$arrOtherConfig['btn_txt_color']}{else}#ffffff{/if}" class="input-xlarge"/>
                            <label class="error" for="button_color">Enter button color</label>
                        </div>
                    </div>
                    <div class="fholder2">
                        <div>
                            <label>Heading Text Color</label><br>
                            <input type="text" id="heading_txt_color" autocomplete="off" name="OtherConfig[heading_txt_color]" value="{if isset($arrOtherConfig['heading_txt_color']) && $arrOtherConfig['heading_txt_color'] != ''}{$arrOtherConfig['heading_txt_color']}{else}#333333{/if}" class="input-xlarge"/>
                            <label class="error" for="heading_txt_color">Enter heading text color</label>
                        </div>
                        <div>
                            <label>Text Color</label><br>
                            <input type="text" id="text_color" autocomplete="off" name="OtherConfig[text_color]" value="{if isset($arrOtherConfig['text_color']) && $arrOtherConfig['text_color'] != ''}{$arrOtherConfig['text_color']}{else}#212529{/if}" class="input-xlarge"/>
                            <label class="error" for="text_color">Enter text color</label>
                        </div>
                    </div>

                    <div>
                        <label>Link Color</label><br>
                        <input type="text" id="link_color" autocomplete="off" name="OtherConfig[link_color]" value="{if isset($arrOtherConfig['link_color']) && $arrOtherConfig['link_color'] != ''}{$arrOtherConfig['link_color']}{else}#0261df{/if}" class="input-xlarge"/>
                        <label class="error" for="link_color">Enter link color</label>
                    </div>

                </div>

            </div>
        </div>
        <div id="tab6" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="mb-2">
                <label>Font Family</label><br>
                <input type="text" id="main_font_family" autocomplete="off" name="OtherConfig[main_font_family]" value="{if isset($arrOtherConfig['main_font_family']) && $arrOtherConfig['main_font_family'] != ''}{$arrOtherConfig['main_font_family']}{/if}" class="input-xlarge"/>
                <label class="error" for="link_color">Enter link color</label>
            </div>
            </div>
            <div class="row-fluid">
                <div class="mb-2">
                    <label><b>Enable Login:</b></label>
                    <select id="login_enable" name="OtherConfig[login_enable]">
                        {foreach from=$arrYesNo key=key item=item}
                            <option value="{$key}" {if $key == $arrOtherConfig['login_enable']}selected {elseif $arrOtherConfig['login_enable'] == '' && $key == 'No'}selected{/if}>{$item}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="row-fluid">
                <strong></strong>
                <h3>Search Form:</h3>
                <div class="span8">
                    <div>
                        <label>Title</label>
                        <input type="text" id="qsrch_title" name="OtherConfig[qsrch_title]" value="{$arrOtherConfig['qsrch_title']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Enter title for display it above the search bar.</p>
                    </div>
                    <div>
                        <label> Title Text Size </label>
                        <input type="text" id="qsrch_title_size" name="OtherConfig[qsrch_title_size]" value="{$arrOtherConfig['qsrch_title_size']|default:39}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>
                    <div>
                        <label>Title Font Family </label>
                        <input type="text" id="qsrch_title_style" name="OtherConfig[qsrch_title_style]" value="{$arrOtherConfig['qsrch_title_style']|default:''}" class="input-xxlarge"/>
                    </div>
                    <div>
                        <label> Title Text Align </label>
                        <input type="text" id="qsrch_title_align" name="OtherConfig[qsrch_title_align]" value="{$arrOtherConfig['qsrch_title_align']|default:'left'}" class="input-xxlarge"/>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div>
                    <label>Google Ads Conversion Code</label>
                    <textarea id="google_conv_code" name="OtherConfig[google_conv_code]" placeholder="Google Conversion Code" rows="7" class="input-xxlarge">{$arrOtherConfig['google_conv_code']|stripslashes}</textarea>
                    <p> <b>Note:</b> Enter Your Google JavaScript Code.</p>
                </div>

                <div>
                    <label>Google Tag Manager Code </label>
                    <textarea id="google_manage_code" name="OtherConfig[google_manage_code]" placeholder="Google Tag Manager Code" rows="7" class="input-xxlarge">{$arrOtherConfig['google_manage_code']|stripslashes}</textarea>
                    <p> <b>Note:</b> Enter Your Google Tag Manager Code for body.</p>
                </div>
                <div>
						<label>View all button URL</label>
						<input type="text" id="style8_view_page_url" name="OtherConfig[style8_view_page_url]" value="{$arrOtherConfig['style8_view_page_url']}" class="input-xxlarge"/>
						<p> <b>Note:</b> Enter URL extension like "/featured-properties/" for "View All" button which will be used in the shortcode [predefine-search-result pid=''] with style 8</p>
					</div>
            </div>
			<div class="row-fluid">
				<strong></strong>
				<h3>Quick Search(Style 1):</h3>
				<div class="span8">
					<label><b> City </b></label>
                    {*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
                        <br><label><b> ACTRIS </b></label><br>
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=city from=$arrMeta['City']['ACTRIS'] key=ckey item=citem}
                                <label><input type="checkbox" name="OtherConfig[quick_city][]" {if $ckey|in_array:$arrOtherConfig['quick_city'] || $ckey == $arrOtherConfig['quick_city']}checked="checked"{/if} id="{$ckey}" value="{$ckey}" />&nbsp;{$citem}</label>
                           {/foreach}
                        </div>
                    {else}*}
                        {*<br><label><b> MIAMI/BEACHES </b></label><br>*}
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=city from=$arrMeta['City']['MIAMI/BEACHES'] key=ckey item=citem}
                                <label><input type="checkbox" name="OtherConfig[quick_city][]" {if (isset($arrOtherConfig['quick_city'])) && ($ckey|in_array:$arrOtherConfig['quick_city'] || $ckey == $arrOtherConfig['quick_city'])}checked="checked"{/if} id="{$ckey}" value="{$ckey}" />&nbsp;{$citem}</label>
                            {/foreach}
                        </div>
                    {*{/if}*}
					<label><b> Property Type </b></label>
                    {*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
                        <br><label><b> ACTRIS </b></label><br>
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=ptype from=$arrMeta['SubTypeActris'] key=skey item=sitem}
                                <label><input type="checkbox" name="OtherConfig[quick_ptype][]" {if $skey|in_array:$arrOtherConfig['quick_ptype'] || $skey == $arrOtherConfig['quick_ptype']}checked="checked"{/if} id="{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
                            {/foreach}
                        </div>
                    {*{else}
                        <br><label><b> MIAMI/BEACHES </b></label><br>*}
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=ptype from=$arrMeta['SubType'] key=skey item=sitem}
                                <label><input type="checkbox" name="OtherConfig[quick_ptype][]" {if (isset($arrOtherConfig['quick_ptype'])) && ($skey|in_array:$arrOtherConfig['quick_ptype'] || $skey == $arrOtherConfig['quick_ptype'])}checked="checked"{/if} id="{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
                            {/foreach}
                        </div>
                    {*{/if}*}
					<div>
						<label> Head Title Text Size (Quick)</label>
						<input type="text" id="quick_head_title" name="OtherConfig[quick_head_title]" value="{$arrOtherConfig['quick_head_title']|default:55}" class="input-xxlarge"/>
						<p> <b>Note:</b> Please enter only numeric value without unit. </p>
					</div>
					<div>
						<label> Sub Title Text Size (Search)</label>
						<input type="text" id="quick_sub_title" name="OtherConfig[quick_sub_title]" value="{$arrOtherConfig['quick_sub_title']|default:55}" class="input-xxlarge"/>
						<p> <b>Note:</b> Please enter only numeric value without unit. </p>
					</div>
					<div>
						<label> Title Text Style</label>
						<input type="text" id="quick_style" name="OtherConfig[quick_style]" value="{$arrOtherConfig['quick_style']}" class="input-xxlarge"/>
					</div>
                    <div>
                        <label> Title Text Transform</label>
                        <input type="text" id="quick_title_transform" name="OtherConfig[quick_title_transform]" value="{$arrOtherConfig['quick_title_transform']|default:'uppercase'}" class="input-xxlarge"/>
                    </div>

                    <div>
                        <label> Title Space</label>
                        <input type="text" id="quick_title_space" name="OtherConfig[quick_title_space]" value="{$arrOtherConfig['quick_title_space']|default:2}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>

                    <div>
                        <label> Title Font Family</label>
                        <input  type="text" id="quick_font_family" name="OtherConfig[quick_font_family]" value="{$arrOtherConfig['quick_font_family']}" class="input-xxlarge"/>
                    </div>

                    <div>
                        <label> Quick Search Font Size</label>
                        <input  type="text" id="quick_font_size" name="OtherConfig[quick_font_size]" value="{$arrOtherConfig['quick_font_size']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>
                    <div>
                        <label> Quick Search Font Family</label>
                        <input  type="text" id="quick_srch_fnt_fmly" name="OtherConfig[quick_srch_fnt_fmly]" value="{$arrOtherConfig['quick_srch_fnt_fmly']}" class="input-xxlarge"/>
                    </div>
                    <div>
                        <label> Text Color</label>
                        <input type="text" id="quick_text_color" name="OtherConfig[quick_text_color]" value="{$arrOtherConfig['quick_text_color']|default:'#fff'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                    <div>
                        <label> Quick Button Color</label>
                        <input type="text" id="quick_btn_color" name="OtherConfig[quick_btn_color]" value="{$arrOtherConfig['quick_btn_color']|default:'#000'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>
                    <div>
                        <label> Quick Search Text Transform</label>
                        <input type="text" id="quick_search_transform" name="OtherConfig[quick_search_transform]" value="{$arrOtherConfig['quick_search_transform']|default:'uppercase'}" class="input-xxlarge"/>
                    </div>

				</div>
			</div>
			<div class="row-fluid">
				<strong></strong>
				<h3>Quick Search(Style 2):</h3>
				<div class="span8">
					<label><b> City </b></label>
					{*<div class="multi-opt cols3 multi-options-container">

						{foreach name=city from=$arrMeta['City'] key=ckey item=citem}
							<label><input type="checkbox" name="OtherConfig[quick_city2][]" {if $ckey|in_array:$arrOtherConfig['quick_city2'] || $ckey == $arrOtherConfig['quick_city2']}checked="checked"{/if} id="{$ckey}" value="{$ckey}" />&nbsp;{$citem}</label>
						{/foreach}
					</div>*}
                    {*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
                        <br><label><b> ACTRIS </b></label><br>
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=city from=$arrMeta['City']['ACTRIS'] key=ckey item=citem}
                                <label><input type="checkbox" name="OtherConfig[quick_city2][]" {if $ckey|in_array:$arrOtherConfig['quick_city2'] || $ckey == $arrOtherConfig['quick_city2']}checked="checked"{/if} id="{$ckey}" value="{$ckey}" />&nbsp;{$citem}</label>
                            {/foreach}
                        </div>
                    {else}

                        <br><label><b> MIAMI/BEACHES </b></label><br>*}
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=city from=$arrMeta['City']['MIAMI/BEACHES'] key=ckey item=citem}
                                <label><input type="checkbox" name="OtherConfig[quick_city2][]" {if (isset($arrOtherConfig['quick_city2'])) && ($ckey|in_array:$arrOtherConfig['quick_city2'] || $ckey == $arrOtherConfig['quick_city2'])}checked="checked"{/if} id="{$ckey}" value="{$ckey}" />&nbsp;{$citem}</label>
                            {/foreach}
                        </div>
                    {*{/if}*}
					<label><b> Property Type </b></label>
                    {*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
                        <br><label><b> ACTRIS </b></label><br>
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=ptype from=$arrMeta['SubTypeActris'] key=skey item=sitem}
                                <label><input type="checkbox" name="OtherConfig[quick_ptype2][]" {if $skey|in_array:$arrOtherConfig['quick_ptype2'] || $skey == $arrOtherConfig['quick_ptype2']}checked="checked"{/if} id="{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
                            {/foreach}
                        </div>
                    {else}
                        <br><label><b> MIAMI/BEACHES </b></label><br>*}
                        <div class="multi-opt cols3 multi-options-container">
                            {foreach name=ptype from=$arrMeta['SubType'] key=skey item=sitem}
                                <label><input type="checkbox" name="OtherConfig[quick_ptype2][]" {if (isset($arrOtherConfig['quick_ptype2'])) && ($skey|in_array:$arrOtherConfig['quick_ptype2'] || $skey == $arrOtherConfig['quick_ptype2'])}checked="checked"{/if} id="{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
                            {/foreach}
                        </div>
                   {* {/if}*}
					<div>
						<label> Head Title Text Size (Quick)</label>
						<input type="text" id="quick2_head_title" name="OtherConfig[quick2_head_title]" value="{$arrOtherConfig['quick2_head_title']|default:27}" class="input-xxlarge"/>
						<p> <b>Note:</b> Please enter only numeric value without unit. </p>
					</div>
					<div>
						<label> Sub Title Text Size (Search)</label>
						<input type="text" id="quick2_sub_title" name="OtherConfig[quick2_sub_title]" value="{$arrOtherConfig['quick2_sub_title']|default:27}" class="input-xxlarge"/>
						<p> <b>Note:</b> Please enter only numeric value without unit. </p>
					</div>
					<div>
						<label> Title Text Style</label>
						<input type="text" id="quick2_style" name="OtherConfig[quick2_style]" value="{$arrOtherConfig['quick2_style']}" class="input-xxlarge"/>
					</div>
				</div>
			</div>
            <div class="row-fluid">
				<strong></strong>
				<h3>Quick Search(Style 3):</h3>
				<div class="span8">
					
					<div>
						<label>Font Family </label>
						<input type="text" id="quick3_text_style" name="OtherConfig[quick3_text_style]" value="{$arrOtherConfig['quick3_text_style']|default:''}" class="input-xxlarge"/>
					</div>

                    <div>
                        <label>Title</label>
                        <input type="text" id="quick3_title" name="OtherConfig[quick3_title]" value="{$arrOtherConfig['quick3_title']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Enter title for display it above the search.</p>
                    </div>
                    <div>
                        <label> Title Text Size </label>
                        <input type="text" id="quick3_title_size" name="OtherConfig[quick3_title_size]" value="{$arrOtherConfig['quick3_title_size']|default:39}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>
                    <div>
                        <label>Title Font Family </label>
                        <input type="text" id="quick3_title_style" name="OtherConfig[quick3_title_style]" value="{$arrOtherConfig['quick3_title_style']|default:''}" class="input-xxlarge"/>
                    </div>
				
				</div>
			</div>
            <div class="row-fluid">
                <strong></strong>
                <h3>Quick Search(Style 4):</h3>
                <div class="span8">
                    <div>
                        <label>Title</label>
                        <input type="text" id="quick4_title" name="OtherConfig[quick4_title]" value="{$arrOtherConfig['quick4_title']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Enter title for display it above the search.</p>
                    </div>
                    <div>
                        <label> Title Text Size </label>
                        <input type="text" id="quick4_title_size" name="OtherConfig[quick4_title_size]" value="{$arrOtherConfig['quick4_title_size']|default:39}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>
                    <div>
                        <label>Title Font Family </label>
                        <input type="text" id="quick4_title_style" name="OtherConfig[quick4_title_style]" value="{$arrOtherConfig['quick4_title_style']|default:''}" class="input-xxlarge"/>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <strong></strong>
                <h3>Quick Search(Style 5):</h3>
                <div class="span8">
                    <div>
                        <label>Title</label>
                        <input type="text" id="quick5_title" name="OtherConfig[quick5_title]" value="{$arrOtherConfig['quick5_title']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Enter title for display it above the search.</p>
                    </div>
                    <div>
                        <label> Title Text Size </label>
                        <input type="text" id="quick5_title_size" name="OtherConfig[quick5_title_size]" value="{$arrOtherConfig['quick5_title_size']|default:39}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>
                    <div>
                        <label>Title Font Family </label>
                        <input type="text" id="quick5_title_style" name="OtherConfig[quick5_title_style]" value="{$arrOtherConfig['quick5_title_style']|default:''}" class="input-xxlarge"/>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <strong></strong>
                <h3>Property Style(Style 9):</h3>
                <div class="span8">

                    <div>
                        <label> Text Color</label>
                        <input type="text" id="style9_text_color" name="OtherConfig[style9_text_color]" value="{$arrOtherConfig['style9_text_color']|default:'#000'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>
                    <div>
                        <label> Border Color</label>
                        <input type="text" id="style9_bdr_color" name="OtherConfig[style9_bdr_color]" value="{$arrOtherConfig['style9_bdr_color']|default:'#000'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>
                    <div>
                        <label> Background Color</label>
                        <input type="text" id="style9_bg_color" name="OtherConfig[style9_bg_color]" value="{$arrOtherConfig['style9_bg_color']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                    <div>
                        <label> border Hover Color</label>
                        <input type="text" id="style9_bdr_hvr_color" name="OtherConfig[style9_bdr_hvr_color]" value="{$arrOtherConfig['style9_bdr_hvr_color']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                    <div>
                        <label> Background Hover Color</label>
                        <input type="text" id="style9_bg_hvr_color" name="OtherConfig[style9_bg_hvr_color]" value="{$arrOtherConfig['style9_bg_hvr_color']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                </div>
            </div>
            <div class="row-fluid">
                <strong></strong>
                <h3>Property Style(Style 12):</h3>
                <div class="span8">
                    <h3>Dark Background</h3>
                    <p> <b>Note:</b> You can use this option to set color, font size, and font family for the dark background.</p>
                    <div>
                        <label> Text Color</label>
                        <input type="text" id="style12_text_light" name="OtherConfig[style12_text_light]" value="{$arrOtherConfig['style12_text_light']|default:'#fff'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                    <div>
                        <label> Font Family</label>
                        <input  type="text" id="style12_font_family_light" name="OtherConfig[style12_font_family_light]" value="{$arrOtherConfig['style12_font_family_light']}" class="input-xxlarge"/>
                    </div>

                    <div>
                        <label> Title Font Size</label>
                        <input  type="text" id="style12_font_size_light" name="OtherConfig[style12_font_size_light]" value="{$arrOtherConfig['style12_font_size_light']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>

                </div>

                <div class="span8">
                    <h3>Light Background</h3>
                    <p> <b>Note:</b> You can use this option to set color, font size, and font family for the light background.</p>
                    <div>
                        <label> Text Color</label>
                        <input type="text" id="style12_text_dark" name="OtherConfig[style12_text_dark]" value="{$arrOtherConfig['style12_text_dark']|default:'#000'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                    <div>
                        <label> Font Family</label>
                        <input  type="text" id="style12_font_family_dark" name="OtherConfig[style12_font_family_dark]" value="{$arrOtherConfig['style12_font_family_dark']}" class="input-xxlarge"/>
                    </div>

                    <div>
                        <label> Title Font Size</label>
                        <input  type="text" id="style12_font_size_dark" name="OtherConfig[style12_font_size_dark]" value="{$arrOtherConfig['style12_font_size_dark']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>

                </div>
            </div>
            <div class="row-fluid">
                <strong></strong>
                <h3>Predefine Market Report:</h3>
                <div class="span8">
                    <h3>Dark Background</h3>
                    <p> <b>Note:</b> You can use this option to set text color and border color for the dark background.</p>
                    <div>
                        <label> Text Color</label>
                        <input type="text" id="pre_market_light" name="OtherConfig[pre_market_light]" value="{$arrOtherConfig['pre_market_light']|default:'#fff'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                    <div>
                        <label> Border Color</label>
                        <input type="text" id="market_border_light" name="OtherConfig[market_border_light]" value="{$arrOtherConfig['market_border_light']|default:'#dee2e6'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>

                    {*<div>
                        <label> Font Family</label>
                        <input  type="text" id="style12_font_family_light" name="OtherConfig[style12_font_family_light]" value="{$arrOtherConfig['style12_font_family_light']}" class="input-xxlarge"/>
                    </div>*}

                    {*<div>
                        <label> Title Font Size</label>
                        <input  type="text" id="style12_font_size_light" name="OtherConfig[style12_font_size_light]" value="{$arrOtherConfig['style12_font_size_light']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>*}

                </div>

                <div class="span8">
                    <h3>Light Background</h3>
                    <p> <b>Note:</b> You can use this option to set text color and border color for the light background.</p>
                    <div>
                        <label> Text Color</label>
                        <input type="text" id="pre_market_dark" name="OtherConfig[pre_market_dark]" value="{$arrOtherConfig['pre_market_dark']|default:'#000'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>
                    <div>
                        <label> Border Color</label>
                        <input type="text" id="market_border_dark" name="OtherConfig[market_border_dark]" value="{$arrOtherConfig['market_border_dark']|default:'#dee2e6'}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter color code. </p>
                    </div>
                    {*<div>
                        <label> Font Family</label>
                        <input  type="text" id="style12_font_family_dark" name="OtherConfig[style12_font_family_dark]" value="{$arrOtherConfig['style12_font_family_dark']}" class="input-xxlarge"/>
                    </div>

                    <div>
                        <label> Title Font Size</label>
                        <input  type="text" id="style12_font_size_dark" name="OtherConfig[style12_font_size_dark]" value="{$arrOtherConfig['style12_font_size_dark']}" class="input-xxlarge"/>
                        <p> <b>Note:</b> Please enter only numeric value without unit. </p>
                    </div>*}

                </div>
            </div>
		</div>
        <div id="tab7" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                <h3>Facebook</h3>
                <div>
                    <label>Facebook App ID</label>
                    <input type="text" id="fb_app_id" name="SocialConfig[fb_app_id]" value="{$arrSocialConfig['fb_app_id']}" class="input-xxlarge"/>
                </div>
                <div>
                    <label>Facebook App Secret</label>
                    <input type="text" id="fb_app_secret" name="SocialConfig[fb_app_secret]" value="{$arrSocialConfig['fb_app_secret']}" class="input-xxlarge"/>
                </div>
            </div>
            <div class="row-fluid">
                <h3>Google</h3>
                <div>
                    <label>Google App ID</label>
                    <input type="text" id="gml_app_id" name="SocialConfig[gml_app_id]" value="{$arrSocialConfig['gml_app_id']}" class="input-xxlarge"/>
                </div>
                <div>
                    <label>Google App Secret</label>
                    <input type="text" id="gml_app_secret" name="SocialConfig[gml_app_secret]" value="{$arrSocialConfig['gml_app_secret']}" class="input-xxlarge"/>
                </div>
            </div>
        </div>
        <div id="tab5" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                <strong></strong>
                <div class="span8">
                    <h5>Shortcodes Available </h5>
                    {if $arrShortCode && count($arrShortCode) > 0}
                        {foreach $arrShortCode as $record}
                            <div>
                                <b>{$record['shortcode_name']}</b> :
                                <br/>
                                {$record['shortcode_detail']}
                            </div>
                            <br/>
                        {/foreach}
                    {else}
                        <h3 class="text-error">There is no shortcodes available.</h3>
                    {/if}
                </div>
            </div>
        </div>
        <input type="submit" class="btn" value="Update" name="Submit" />
    </div>
</form>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){

            // Input Masking for Phone Number
            if(jQuery("input.phone_no").length)
            {
                jQuery("input.phone_no").mask("(999)-999-9999");
            }
            jQuery('#frmSettings').validate();

            jQuery('#button_color').minicolors();
            jQuery('#btn_txt_color').minicolors();
            jQuery('#heading_txt_color').minicolors();
            jQuery('#text_color').minicolors();
            jQuery('#link_color').minicolors();

        });
    </script>
{/literal}