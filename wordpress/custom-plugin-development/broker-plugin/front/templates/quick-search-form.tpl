<div class="{if isset($style) && $style == 6}qstyle6 mx-0 w-100{/if} quick-container te-font-family {if isset($style) && ($style == 2 || $style == 3 || $style == 4 || $style == 5 || $style == 6)}h-container{/if}" style="{if isset($style) && ($style == 2 || $style == 3 || $style == 4 || $style == 5 || $style == 6)}height:100vh{/if}">
	{if isset($style) && $style == 2}
		<div class="style2-content text-center search-bar">
			<div>
				<h2 class="quick2-head-title quick2-style">Quick <strong class="quick2-sub-title quick2-style">Search</strong></h2>
				<div class="quick-form">
					<form action="{$formAction}" method="post">
						<div class="quick-field  qs-long arrow-clr">
							<select name="stype" class="quick-ptype">
								<option value="">PROPERTY TYPE</option>
								{foreach name=ptype from=$OtherConfig.quick_ptype2 key=skey item=sitem}
									{*{if isset($AgentSystemName)  && $AgentSystemName == {constant('Constants::ACTRIS')}}
										<option value="{$sitem}">{$arrMeta['SubTypeActris'][$sitem]}</option>
									{else}*}
										<option value="{$sitem}">{if $arrMeta['SubType'][$sitem] == 'Lease'}Rental{else}{$arrMeta['SubType'][$sitem]}{/if}</option>
									{*{/if}*}
								{/foreach}
							</select>
						</div>
						<div class="quick-field  qs-long">
							<select name="city">
								<option value="">SELECT A CITY</option>
								{foreach name=city from=$OtherConfig.quick_city2 key=citykey item=cityitem}
									<option value="{$cityitem}">{$cityitem}</option>
								{/foreach}
							</select>
						</div>
						<div class="quick-field  qs-short qs-left">
							<select name="minbed">
								<option value="">BEDS</option>
								{foreach name=minbed from=$arrBathRange key=bedkey item=beditem}
									<option value="{$bedkey}">{$beditem}</option>
								{/foreach}
							</select>
						</div>
						<div class="quick-field  qs-short qs-right">
							<select name="minbath">
								<option value="">BATHS</option>
								{foreach name=minbath from=$arrBathRange key=bathkey item=bathitem}
									<option value="{$bathkey}">{$bathitem}</option>
								{/foreach}
							</select>
						</div>
						<div class="quick-field  qs-short qs-left">
							<select name="minprice">
							
								{foreach name=minprice from=$arrPriceRange key=mkey item=mitem}
									<option value="{$mkey}">{$mitem}</option>
								{/foreach}
									<option value="" selected="selected">Any </option>
							</select>
						</div>
						<div class="quick-field  qs-short qs-right">
							<select name="maxprice">
							
								{foreach name=maxprice from=$arrPriceRange key=maxkey item=maxitem}
									<option value="{$maxkey}">{$maxitem}</option>
								{/foreach}
								<option value="" selected="selected">Any</option>
							</select>
						</div>
						<div class="qs-btn qs-left">
							<input type="submit" value="SEARCH" class="qs-submit lpt-btn- te-btn"/>
						</div>
						<div class="qs-btn qs-right">
							<a href="{$formAction}" class="qs-adv te-btn">Advanced</a>
						</div>
						<input type="hidden" name="status" value="active" class="status">
					</form>
				</div>
			</div>
		</div>
	{elseif isset($style) && $style == 3}
	    <div class="style2-content style3-content quick-content mw-100">
            <form action="{$formAction}" method="post" class="w-100">
				<div class="text-center">
					{if (isset($OtherConfig['quick3_title']) && $OtherConfig['quick3_title'] != '')}
						<h1 class="quick3_title pb-4 mb-0">{$OtherConfig['quick3_title']}</h1>
					{/if}
					<span class="quick3-style font-bold f-30 text-white"> I want to </span>
					<span class=" position-relative d-inline-block">
					    	<i class="fa fa-chevron-down f-arrow  fa-lg" aria-hidden="true"></i>
						<select name="status" class="quick3-style f-27 f-select lpt-quick-color-">
							<option value="active">Buy</option>
							<option value="rental">Rent</option>
						</select>
					

					</span> <span class="quick3-style font-bold f-30 text-white"> a </span>
					<span class=" position-relative d-inline-block">
					    	<i class="fa fa-chevron-down f-arrow  fa-lg" aria-hidden="true"></i>
						<select name="stype" class="quick3-style f-27 f-select lpt-quick-color-">
							<option value="">Property Type</option>
							{foreach name=ptype from=$OtherConfig.quick_ptype2 key=skey item=sitem}
								{*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
									<option value="{$sitem}">{$arrMeta['SubTypeActris'][$sitem]}</option>
								{else}*}
									{if $arrMeta['SubType'][$sitem] != 'Lease'}
										<option value="{$sitem}">{$arrMeta['SubType'][$sitem]}</option>
									{/if}
								{*{/if}*}
							{/foreach}
						</select>
					</span>
					<span class="quick3-style font-bold f-30 text-white"> in </span>
					<span class=" position-relative d-inline-block">
					    	<i class="fa fa-chevron-down f-arrow  fa-lg" aria-hidden="true"></i>
						<select name="city" class="quick3-style f-27 f-select lpt-quick-color-">
								<option value="">Select A City</option>
							{foreach name=city from=$OtherConfig.quick_city2 key=citykey item=cityitem}
								<option value="{$cityitem}">{$cityitem}</option>
							{/foreach}
						</select>
					</span>
				</div>
				<div class="quick text-center w-100 mw-100 -mt-3">
				<button type="submit" class="quick3-style d-inline-block w-auto text-italic text-uppercase px-5 py-2 btn btn-success- lpt-btn- text-white">Search</button>
				</div>
			</form>
		</div>
	{elseif isset($style) && $style == 4}
		<div class="style4-content text-center mw-100">
			<form class="form w-100" id="frmsearch" role="form" method="post" action="{$formAction}">
{*				<div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12 offset-xl-3 offset-lg-3 offset-md-1 px-4 mx-auto">*}
					{if (isset($OtherConfig['quick4_title']) && $OtherConfig['quick4_title'] != '')}
						<h1 class="quick4_title pb-4 mb-0">{$OtherConfig['quick4_title']}</h1>
					{/if}
					<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
						<div class="btn-group w-100- te-search-btn-group bg-white" role="group" aria-label="First group">
							<div class="status-div">
								<span class=" position-relative d-inline-block status"><i class="fa fa-chevron-down f-arrow fa-sm" aria-hidden="true"></i>
								<select class="" name="status">
								<option value="active">Buy</option>
								<option value="rental">Rent</option>
								</select></span>
							</div>
							<input type="text" id="AddressName" aria-labelledby="search-box" class="form-control h-auto border-0 px-lg-4 px-2 py-2- py-md-3- shadow-none rounded-0" name="AddressName" placeholder="Search by City, Neighborhood, Address, ZIP, MLS#, School" value="">
							<button id="search-box" type="submit" aria-label="button" class="btn px-lg-4 px-3 text-white- te-btn shadow-none rounded-0 lpt-btn lpt-btn-txt">
								{*									<i class="fas fa-search"></i>*}Search
							</button>
							<input name="addval" class="" id="AddressValue" value="" data-type="hidden" type="hidden">
							<input name="addtype" class="" id="AddressType" value="" data-type="hidden" type="hidden">
							<input type="hidden" value="" id="PropertyType" class="" name="ptype" />
							<input type="hidden" value="ResidentialLease" id="Not_PropertyType" class="" name="notptype" />
						</div>
					</div>
{*				</div>*}
			</form>
		</div>
	{elseif isset($style) && $style == 5}
		<div class="style5-content text-center mw-100">
			<form class="form w-100" id="frmsearch" role="form" method="post" action="{$formAction}">
				{*				<div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12 offset-xl-3 offset-lg-3 offset-md-1 px-4 mx-auto">*}
				{if (isset($OtherConfig['quick5_title']) && $OtherConfig['quick5_title'] != '')}
					<h1 class="quick5_title pb-4 mb-0">{$OtherConfig['quick5_title']}</h1>
				{/if}
				<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
					<div class="btn-group w-100- te-search-btn-group bg-white" role="group" aria-label="First group">
						<div class="status-div">
								<span class=" position-relative d-inline-block status"><i class="fa fa-chevron-down f-arrow fa-sm" aria-hidden="true"></i>
								<select class="" name="status">
								<option value="active">Buy</option>
								<option value="rental">Rent</option>
								</select></span>
						</div>
						<input type="text" id="AddressName" aria-labelledby="search-box" class="form-control h-auto border-0 px-lg-4 px-2 py-2- py-md-3- shadow-none rounded-0" name="AddressName" placeholder="Search by City, Neighborhood, Address, ZIP, MLS#, School" value="">
						<button id="search-box" type="submit" aria-label="button" class="btn px-lg-4 px-3  shadow-none rounded-0">
							{*									<i class="fas fa-search"></i>*}<i class="fas fa-search fa-lg"></i>
						</button>
						<input name="addval" class="" id="AddressValue" value="" data-type="hidden" type="hidden">
						<input name="addtype" class="" id="AddressType" value="" data-type="hidden" type="hidden">
					</div>
					<div class="textright advanced-search-link">
						<a href="{$formAction}" class="text-white text-right {*link-color*} link-hover"> + Advanced Search Options</a>
					</div>
				</div>

				{*				</div>*}
			</form>
		</div>
	{elseif isset($style) && $style == 6}
		<div class="style6-content text-center search-bar pb-0">
			{*<div>*}
				<div class="quick-form w-100 mw-100 {if isset($darkmode) && $darkmode == 'true'}darkmode{/if}">
					<form class="form mw-100 " id="frmsearch" role="form" action="{$formAction}" method="post">
						<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
							<div class="btn-group w-100- te-search-btn-group {*{if isset($darkmode) && $darkmode == 'true'}bg-black{else}bg-white{/if}*}" role="group" aria-label="First group" style="background-color: {$bgcolor}">
								<div class="status-div">
								<span class=" position-relative d-inline-block status"><i class="fa fa-chevron-down f-arrow fa-sm" aria-hidden="true"></i>
								<select class="{if isset($darkmode) && $darkmode == 'true'}bg-black- text-white{/if} font-weight-bold" name="status">
								<option value="active">BUY</option>
								<option value="rental">RENT</option>
								</select></span>
								</div>
								<input type="text" id="AddressName" aria-labelledby="search-box" class="form-control h-auto border-0 px-lg-4 px-2 py-2- py-md-3- shadow-none rounded-0 {if cw::$screen == 'MD'}w-50{else}w-75{/if} {if isset($darkmode) && $darkmode == 'true'}bg-black-{else}bg-white- font-weight-bold{/if}" name="AddressName" placeholder="Search by City, Name, Neighborhood, Address, Zip Code, MLS#" value="">
								<button id="search-box" type="submit" aria-label="button" class="btn px-lg-4 px-3  shadow-none rounded-0 pad-right {if isset($darkmode) && $darkmode == 'true'}text-white{/if} font-weight-bold" style="background-color: {$bgcolor}">
									{if (cw::$screen == 'MD') || (cw::$screen == 'LG') || (cw::$screen == 'XL')}SEARCH&nbsp;{/if} <i class="fas fa-search fa-lg"></i>
								</button>
								<input name="addval" class="" id="AddressValue" value="" data-type="hidden" type="hidden">
								<input name="addtype" class="" id="AddressType" value="" data-type="hidden" type="hidden">
							</div>
						</div>
					</form>
				</div>
			{*</div>*}
		</div>
	{else}
		<div class="quick-content">
			<div class="float-left pt-4">
				<h2><strong class="head-title quick-head-title quick_text_color quick-style quick_font_family pl-0 quick_title_transform quick_title_space">quick</strong>
					<strong class="head-sub-title quick-sub-title quick_text_color quick-style quick_font_family mt-3 pl-0 quick_title_transform quick_title_space">search</strong>
				</h2>
			</div>
			<div class="float-right quick-right">
				<form action="{$formAction}" method="post">
					<div class="quick-row">
						<div class="quick quick-w-100 quick_text_color arrow-clr">
							<select name="stype" class="quick-ptype quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="">property type</option>
								{foreach name=ptype from=$OtherConfig.quick_ptype key=skey item=sitem}
									{*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
										<option value="{$sitem}">{$arrMeta['SubTypeActris'][$sitem]}</option>
									{else}*}
										<option value="{$sitem}">{if $arrMeta['SubType'][$sitem] == 'Lease'}Rental{else}{$arrMeta['SubType'][$sitem]}{/if}</option>
									{*{/if}*}
								{/foreach}
							</select>
						</div>
						<div class="quick quick-w-100 quick_text_color arrow-clr">
							<select name="city" class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value=""> select a city</option>
								{foreach name=city from=$OtherConfig.quick_city key=citykey item=cityitem}
									<option value="{$cityitem}">{$cityitem}</option>
								{/foreach}
							</select>
						</div>
						<div class="quick quick_text_color arrow-clr">
							<select name="minprice" class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="" selected="selected">any price</option>
								{foreach name=minprice from=$arrPriceRange key=mkey item=mitem}
									<option value="{$mkey}">{$mitem}</option>
								{/foreach}

							</select>
						</div>
						<div class="quick quick_text_color arrow-clr">
							<select name="maxprice" class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="" selected="selected">any price</option>
								{foreach name=maxprice from=$arrPriceRange key=maxkey item=maxitem}
									<option value="{$maxkey}">{$maxitem}</option>
								{/foreach}

							</select>
						</div>
					</div>
					<div class="quick-row mt-3">
						<div class="quick quick_text_color arrow-clr">
							<select name="minbed" class="minimal quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="">beds</option>
								{foreach name=minbed from=$arrBathRange key=bedkey item=beditem}
									<option value="{$bedkey}">{$beditem}</option>
								{/foreach}
							</select>
						</div>
						<div class="quick quick_text_color arrow-clr">
							<select name="minbath " class="quick_font_size quick_srch_fnt_fmly quick_search_transform">
								<option value="">baths</option>
								{foreach name=minbath from=$arrBathRange key=bathkey item=bathitem}
									<option value="{$bathkey}">{$bathitem}</option>
								{/foreach}
							</select>
						</div>
						<div class="quick-w-100 quick-btn">
							<div class="quick ">
								<input type="submit" class="quick_text_color quick_btn_color quick_font_size quick_srch_fnt_fmly quick_search_transform" value="Search"/>
							</div>
							<div class="quick quick-m-t-4">
								<a href="{$formAction}" class="quick_text_color quick_btn_color quick_font_size quick_srch_fnt_fmly quick_search_transform"><span>Advanced</span></a>
							</div>
						</div>
					</div>
					<input type="hidden" name="status" value="active" class="status"> 
				</form>
			</div>
		</div>
	{/if}
</div>