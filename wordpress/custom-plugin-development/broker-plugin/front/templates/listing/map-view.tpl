{if isset($isPredefined) && $isPredefined == true && isset($isGrid) && $isGrid == 'true'}
	{*{if isset($isPredefined) && $isPredefined == true && (!isset($isFilter) || (isset($isFilter) && $isFilter !== 'false' && $isFilter !== false) || $psearch_display_tab == 'Yes')}*}
	{if isset($isPredefined) && $isPredefined == true && (isset($isFilter) && $isFilter !== 'false') || (isset($psearch_display_tab) && $psearch_display_tab == 'Yes' && isset($tabs) && $tabs !== 'false')}
		<div class="row te-search-filter-row- justify-content-between pre-filter-line pb-2 pr-1- border-bottom- bg-white {if isset($isGrid) && $isGrid == 'true' && isset($isstyle) && ($isstyle !== false)} px-3 {/if}">
			{*{if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}*}
			{if isset($psearch_display_tab) && $psearch_display_tab == 'Yes' && isset($tabs) && $tabs !== 'false'}
				<div class="col-12 {if isset($isGrid) && $isGrid == 'true'}col-xl-8 col-lg-8{else}col-xl-12 col-lg-12{/if} col-md-8  pl-md-2  pr-md-0  px-1 text-md-left text-center align-self-center btn-gray py-2 border-btm pl-xl-3">
					<a href="{$shareUrl}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 lpt-btn- lpt-btn-txt-"><i class="fa fa-th pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> {if isset($is_rental) && $is_rental == true} GRID VIEW {else}GRID VIEW{/if}</a>
					<a href="{$Site_Url}{Constants::TYPE_SALES}/{str_replace(' ', '-', $presearch_title)}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> LIST VIEW</a>
					<a href="{$Site_Url}{Constants::TYPE_RENTALS}/{str_replace(' ', '-', $presearch_title)}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> RENTALS</a>
					<a href="{$Site_Url}{Constants::TYPE_SOLD}/{str_replace(' ', '-', $presearch_title)}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> PAST SALES</a>
				</div>
			{elseif isset($isFilter) && $isFilter !== 'false' && $isFilter !== false}
				<div class="col-12 {if isset($isGrid) && $isGrid == 'true'}col-xl-8 col-lg-8{else}col-xl-6 col-lg-6{/if} col-md-12 pl-md-2  pr-md-0  px-1 py-2 pt-11- align-self-center- btn-gray d-none d-lg-flex align-items-center">
					<form class="form w-100 d-none d-lg-block d-xl-block pre-search py-1 {if isset($isPredefined) && $isPredefined == true }pre-search-arrow {/if}" id="frmlistingsearch" role="form" method="post" action="{$formAction}">
						<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 {if isset($isGrid) && $isGrid == 'true'}pr-xl-3 pr-lg-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-xl-1 pr-lg-1 px-xl-3 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-3{/if}{/if} pr-1 px-0">
							<a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div class="te-width-max-content">
											<input type="text" name="minprice" value="{$arrSearchCriteria.minprice}" class="form-control rounded-0 fprice" id="minprice" placeholder="Min Price" aria-describedby="min price">
										</div>
										<div class="mx-3 align-self-center"> To </div>
										<div class="te-width-max-content">
											<input type="text" name="maxprice" value="{$arrSearchCriteria.maxprice}" class="form-control rounded-0 fprice" id="maxprice" placeholder="Max Price" aria-describedby="max price">
										</div>
									</div>
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div id="price-range"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-xl-3 pr-lg-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-xl-1 pr-lg-1 px-xl-3 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-3 {/if}{/if} pr-1 pl-0 ">
							<a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Beds</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div class="te-width-max-content- w-100">
											<select class="custom-select rounded-0 fbed pr-5 py-0" name="minbed">
												<option value="" selected>Min</option>
												{html_options options=$arrBedRange selected=$arrSearchCriteria.minbed}
											</select>
										</div>
										<div class="mx-3 align-self-center"> To </div>
										<div class="te-width-max-content- w-100">
											<select class="custom-select rounded-0 fbed pr-5 py-0" name="maxbed">
												<option value="" selected>Max</option>
												{html_options options=$arrBedRange selected=$arrSearchCriteria.maxbed}
											</select>
										</div>

									</div>
								</div>
							</div>
						</div>
						{if isset($isGrid) && $isGrid == 'true' }
							<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-1 px-xl-2 px-0 {/if} pl-0">
								<a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Baths
								</a>
								<div class="dropdown-menu mt-12 bg-white px-4 border rounded-0">
									<div class="row">
										<div class="col-xl-12 col-lg-12 px-3 py-0">
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fbath" {if $arrSearchCriteria.minbath == ''}checked{/if} value="" name="minbath" id="bath-any">
												<label class="custom-control-label" for="bath-any">Any</label>
											</div>
											{foreach name=bath from=$arrBathRange key=bathkey item=bathitem}
												<div class="custom-control custom-radio py-2">
													<input type="radio" class="custom-control-input fbath" {if $arrSearchCriteria.minbath == $bathkey}checked{/if} value="{$bathkey}" name="minbath" id="bath-{$bathkey}">
													<label class="custom-control-label" for="bath-{$bathkey}">{$bathitem}</label>
												</div>
											{/foreach}
										</div>
									</div>
								</div>
							</div>
						{/if}
						<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-3{if isset($isPredefined) && $isPredefined == 'true'} px-xl-3 {/if}{else}pr-1 px-xl-3 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-3{/if} {/if} pl-0">
							<a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Square Ft
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div class="te-width-max-content">
											<select name="minsqft" class="custom-select rounded-0 fsqft shadow-none">
												<option value="" selected="">Min</option>
												{html_options options=$arrSqftRange selected=$arrSearchCriteria.minsqft}
											</select>
										</div>

										<div class="mx-3 align-self-center"> To </div>
										<div class="te-width-max-content">
											<select name="maxsqft" class="custom-select rounded-0 fsqft shadow-none">
												<option value="" selected="">Max</option>
												{html_options options=$arrSqftRange selected=$arrSearchCriteria.maxsqft}
											</select>
										</div>

									</div>
								</div>
							</div>
						</div>
						{if isset($isGrid) && $isGrid == 'true'}
							<div class="dropdown d-none d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 pr-3 pl-0 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}">
								<a class="btn dropdown-toggle rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Waterfront
								</a>
								<div class="dropdown-menu mt-12 bg-white px-3 py-2 border rounded-0">
									<div class="row">
										<div class="col-xl-12 col-lg-12 py-0">
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fwf" {if $arrSearchCriteria.waterfront == ''}checked{/if} value="" name="waterfront" id="wf-any">
												<label class="custom-control-label" for="wf-any">Any</label>
											</div>
											{foreach name=beds from=$arrYesNo key=wfkey item=wfitem}
												<div class="custom-control custom-radio py-2">
													<input type="radio" class="custom-control-input fwf" {if $arrSearchCriteria.waterfront == $wfkey}checked{/if} value="{$wfkey}" name="waterfront" id="wf-{$wfkey}">
													<label class="custom-control-label" for="wf-{$wfkey}">{$wfitem}</label>
												</div>
											{/foreach}
										</div>
									</div>
								</div>
							</div>

							<div class="dropdown d-none d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 pr-3 pl-0 {if isset($isPredefined) && $isPredefined == 'true' && isset($isGrid) && $isGrid == 'true'}px-xl-3 {/if}">
								<a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab  {else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pets
								</a>
								<div class="dropdown-menu mt-12 bg-white px-3 py-2 border rounded-0">
									<div class="row">
										<div class="col-xl-12 col-lg-12 py-0">
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fpetsa" {if $arrSearchCriteria.petsallowed == ''}checked{/if} value="" name="petsallowed" id="pets-any">
												<label class="custom-control-label" for="pets-any">Any</label>
											</div>
											{foreach name=beds from=$arrYesNo key=petskey item=petsitem}
												<div class="custom-control custom-radio py-2">
													<input type="radio" class="custom-control-input fpetsa" {if $arrSearchCriteria.petsallowed == $petskey}checked{/if} value="{$petskey}" name="petsallowed" id="pets-{$petskey}">
													<label class="custom-control-label" for="pets-{$petskey}">{$petsitem}</label>
												</div>
											{/foreach}
										</div>
									</div>
								</div>
							</div>

							<div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds pr-3 pl-0">
								<a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Year built
								</a>
								<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
									<div class="row">
										<div class="col-xl-12 col-lg-12 d-flex py-1">
											<div class="te-width-max-content">
												<select name="minyear" class="custom-select rounded-0 shadow-none fyear">
													<option value="" selected="">Min</option>
													{html_options options=$arrminYearBuild selected=$arrSearchCriteria.minyear}
												</select>
											</div>

											<div class="mx-3 align-self-center"> To </div>
											<div class="te-width-max-content">
												<select name="maxyear" class="custom-select rounded-0 shadow-none fyear">
													<option value="" selected="">Max</option>
													{html_options options=$arrmaxYearBuild selected=$arrSearchCriteria.maxyear}
												</select>
											</div>

										</div>
									</div>
								</div>
							</div>
						{/if}
					</form>
				</div>
			{/if}
			<div class="col-12 {if isset($isGrid) && $isGrid == 'true'}col-xl-4 col-lg-4 {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}text-sm-right{/if} {if isset($isPredefined) && $isPredefined == true} justify-content-between justify-content-sm-center font-size-sm-10 {if cw::$screen !== 'XS'}p-unset{/if} justify-content-md-end px-xl-3 {/if} {else} justify-content-between justify-content-sm-end {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}col-xl-12 col-lg-12 mt-lg-2 {else}col-xl-6 col-lg-6 {/if}{/if}   px-1- px-md-0-  text-center {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'} btn-gray col-md-4 justify-content-between py-1 {else} btn-gray col-md-12 py-2 {/if}  pt-lg-0- pt-2- d-flex d-md-block-  px-2 px-xl-2 py-xl-2 py-md-0 pb-2- {*{if isset($psearch_display_tab) && $psearch_display_tab == 'Yes' && cw::$screen !== 'XS'}p-unset{/if}*}">
				{if isset($psearch_generate_mrktreport) && $psearch_generate_mrktreport == 'Yes'}
					<a href="{$marketReportURL}" class="btn btn-sm btn-primary- btn-market-insight text-primary align-self-center  {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}font-size-sm-12{/if} te-font-size-13 font-size-sm-10 shadow-none p-1 p-lg-1 p-xl-2 px-2 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab text-sm-right {if isset($isPredefined) && $isPredefined == true && (cw::$screen == 'MD' || cw::$screen == 'SM')}col col-md-4- col-xl-auto- px-sm-3 {/if} {/if} rounded-0"><i class="fas fa-2x fa-poll text-dark pr-2 align-middle"></i><span class="d-none- d-sm-inline {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}d-md-none{/if} d-lg-inline">Market Insights</span></a>
				{/if}
				<div class="dropdown d-inline-block mx-1- mx-lg-0 align-self-center{if isset($isPredefined) && $isPredefined == true && isset($isGrid) && $isGrid !== 'true' && (cw::$screen == 'MD' || cw::$screen == 'SM')} col-md-auto- col-xl-auto- px-sm-3{/if}">
					<button id="share-btn" class="btn btn-sm dropdown-toggle  {if isset($isGrid) && $isGrid == 'true'}f-tab btn-gray- {else}font-tab dropdown-block {/if} {if isset($psearch_display_tab) && $psearch_display_tab == 'No'} font-size-sm-10 font-size-sm-12  {else}te-btn- text-white- {/if} te-font-size-12- te-btn- text-white- shadow-none p-lg-2 px-xl-3 px-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{*<i class="fas fa-external-link-alt pr-2-"></i> Share*}
						<i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline- {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}d-md-none{/if} d-lg-inline">Share</span>
					</button>
					<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2-"></i> Facebook</a>
						<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-fa-w-16 pr-1-"></i> Twitter</a>
						<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2-" ></i> Pinterest</a>
						<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2-"></i> LinkedIn</a>
						<a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($presearch_title) && $presearch_title != ''}{$presearch_title}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2-"></i> Email</a>
					</div>
				</div>
				{if isset($psearch_display_tab) && $psearch_display_tab == 'No'}
					{if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD'}
						<a class="btn btn-sm rounded-0 d-lg-none {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}font-size-sm-12 font-size-sm-10{/if} te-font-size-13 responsive-filters-tab align-self-center shadow-none te-font-size-14 px-3 lpt-btn- lpt-btn-txt- btn-gray- {if isset($isGrid) && $isGrid == 'true'}te-pre-mblf{else}font-tab {if isset($isPredefined) && $isPredefined == true }d-none {/if}{/if}" role="button" data-toggle="modal" data-target="#exampleModalScrollable"><i class="fas fa-sliders-h fa-2x pr-2 align-middle"></i>More Filters <i class="fas fa-angle-down align-middle"></i>
						</a>
					{/if}
				{/if}
				{*<a href="javascript::void(0);" class="btn btn-sm align-self-center btn-gray- {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}font-size-sm-12  font-size-sm-10 {else} te-btn- text-white- {/if} te-font-size-13 te-btn- shadow-none p-lg-2 p-xl-2 px-2 text-md-right {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser px-xl-3{else}font-tab {if isset($isPredefined) && $isPredefined == true && (cw::$screen == 'MD' || cw::$screen == 'SM')}col-md-4- col-xl-auto- px-sm-3 {/if}{/if} rounded-0 lpt-btn- lpt-btn-txt- popup-modal-sm" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch&pid={$predefinedId}{else}/?action=member-login&ReqType=SaveSearch&pid={$predefinedId}{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}"><i class="far fa-2x fa-bell align-middle pr-2"></i>*}{**}{*{if cw::$screen != 'XS'}Alerts{/if}{print_r(cw::$screen)}*}{**}{*{if isset($isGrid) && $isGrid == 'true'}{if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}<span class="d-inline d-md-none d-lg-inline">Alerts</span>{else}<span class="d-none d-sm-inline">Alerts</span>{/if}{else}<span class="d-sm-inline">Alerts</span>{/if}</a>*}
			</div>
		</div>
		{if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD' }
			{include file="listing/mobile-device-search-form.tpl"}
		{/if}
	{/if}
{/if}
{if !isset($isHeading) || (isset($isHeading) && $isHeading !== 'false' && $isHeading !== false)}
	{if isset($isPredefined) && $isPredefined == true && ($device !== 'XS' && $device !== 'SM' && $device !== 'MD')}<div class="row {if isset($isGrid) && $isGrid == 'true' && (isset($isstyle) && ($isstyle !== false))} px-3 {/if} {if isset($isPredefined) && $isPredefined == 'true'} px-3 pt-1 pt-md-2 {/if}">{/if}
	<div class="{if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}col {if isset($isGrid) && $isGrid == 'true'}col-lg-4 col-xl-5{else}col-xl-7{/if} px-0{else}row {if isset($isPredefined) && $isPredefined == true }border-sm-btm {/if}{/if}  {if isset($isPredefined) && $isPredefined == true }pre-search-arrow py-1 py-md-0{/if} justify-content-between {if isset($psearch_generate_mrktreport) && $psearch_generate_mrktreport == 'No'}{if cw::$screen == 'XS' || cw::$screen == 'SM'}pt-2{/if}{/if}">
		<div class="{if isset($isPredefined) && $isPredefined == true}col-xl-12 col-md-12 d-flex{else}col-xl-9{/if}  col-lg-8 col-md-auto col-sm-auto px-2 align-self-center">
			{if isset($presearch_title) && $presearch_title != '' && cw::$screen != 'MD'}
				<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 pb-0 mb-0 txt-heading heading_txt_color col-10 col-xl-12 d-lg-block d-xl-block d-sm-none heading-font heading-truncate- mr-auto">{$presearch_title|capitalize}</h1>
			{elseif isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == 'cs'}
				{*        {if isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == 'cs'}*}
				<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 pb-0 mb-0 txt-heading heading_txt_color col-10 col-xl-12 d-lg-block d-xl-block d-sm-none heading-font heading-truncate- mr-auto">{$arrSearchCriteria.addval} Real Estate & Homes For Sale</h1>
			{/if}
			{if isset($isGrid) && $isGrid !== 'true'}
				<div class="col-2 d-block- d-xl-none align-self-center- mt-1 px-2 {if isset($isPredefined) && $isPredefined == 'true'}d-sm-none d-block{else} d-none {/if}">
					<div class="custom-control custom-switch te-width-max-content- d-block d-xl-none d-inline-block te-map-switch float-right pre-map-mbl-toggle" {*data-toggle="modal"*} data-target="#te-map-modal">
						<input type="checkbox" class="custom-control-input" id="toggle-trigger">
						<label class="custom-control-label te-font-size-14" for="toggle-trigger">Map</label>
					</div>
				</div>
			{/if}
		</div>

		{*{if isset($presearch_title) && $presearch_title != '' || (isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == 'cs')}*}
		{if isset($presearch_title) && $presearch_title != ''}
			<div id="user-savesearch" class="col-xl-3 col-lg-4 col-md-auto col-sm-auto px-2 px-lg-0 text-right px-xl-2 {if isset($issavesearch) && $issavesearch == 'true' && (isset($isGrid) || $isGrid !== 'true')}d-none d-xl-block- {else} d-none {/if}">
				<button id="save_search" type="buttocon" class="btn ml-1 ml-lg-1 rounded-0 shadow-none border-secondary- te-btn text-white- popup-modal-sm lpt-btn lpt-btn-txt" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch{else}/?action=member-login&ReqType=SaveSearch{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
					Save Search
				</button>
			</div>
		{/if}

	</div>
	{*<div class="row mb-2 d-xl-none px-2- ">*}

		{*{if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD'}
		<div class="col-6 align-self-center px-2 save_search_mob">
			<button id="save_search" type="button" class="btn ml-1- ml-lg-1 rounded-0 shadow-none border-secondary- te-btn text-white- lpt-btn lpt-btn-txt popup-modal-sm {if isset($issavesearch) && $issavesearch == 'false' && (isset($isGrid) || $isGrid == 'true')}d-none{/if}" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch{else}/?action=member-login&ReqType=SaveSearch{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
				Save Search
			</button>
		</div>
		{/if}*}
		{*{if isset($isGrid) && $isGrid !== 'true'}
			<div class="col-6 align-self-center px-2">
				<div class="custom-control custom-switch te-width-max-content- d-block d-xl-none d-inline-block te-map-switch float-right" *}{*data-toggle="modal"*}{* data-target="#te-map-modal">
					<input type="checkbox" class="custom-control-input" id="toggle-trigger">
					<label class="custom-control-label" for="toggle-trigger">Map</label>
				</div>
			</div>
		{/if}*}
	{*</div>*}
{if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}<div class="col {if isset($isGrid) && $isGrid == 'true'}col-lg-8 col-xl-7{else}col-xl-5{/if}">{/if}
	<div id ="sort_content_end" class="row te-font-family- {if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')} {if isset($isGrid) && $isGrid == 'true'}float-right {/if}{/if} {if isset($isGrid) && $isGrid == 'true' || (!isset($presearch_title) && $presearch_title == '' && (!isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == ''))}justify-content-between{/if} {if isset($isPredefined) && $isPredefined == true }pre-search-arrow {else} {if (!isset($presearch_title) && $presearch_title == '') && (!isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == '')}mt-xl-1 mt-0{/if}{/if} mb-2- mb-xl-0 px-2 px-md-2 px-xl-0-">
		{if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD' }
			{if isset($presearch_title) && $presearch_title != ''}
				<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 mb-0 txt-heading heading_txt_color col-sm-6 col-lg-6 d-none d-sm-block heading-font heading-truncate- mr-auto">{$presearch_title|capitalize}</h1>
			{elseif isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == 'cs'}
				{*        {if isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == 'cs'}*}
				<h1 class="te-search-property-title te-font-family mt-xl-2 pt-1 pt-md-0 mb-0 txt-heading heading_txt_color col-sm-6 col-lg-4 d-none d-sm-block heading-font heading-truncate- mr-auto">{$arrSearchCriteria.addval} Real Estate & Homes For Sale</h1>
			{/if}
		{/if}
		{if isset($isPredefined) && $isPredefined == true && isset($isGrid) && $isGrid == 'true'}
			<div class="col-auto {if isset($isPredefined) && $isPredefined == true }order-1{/if} align-self-center px-2 d-none d-lg-block">
				{foreach name=quicksort from=$arrPreQuickSorting key=qsortkey item=qsortitem}
					<a href="javascript::void(0);" class="link-color link-hover preqsort te-font-weight-600 pr-3" data-value="{$qsortkey}">{$qsortitem}</a>
				{/foreach}
				{*				<a href="javascript::void(0);" class="link-color link-hover te-font-weight-600 popup-modal-sm" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch&pid={$predefinedId}{else}/?action=member-login&ReqType=SaveSearch&pid={$predefinedId}{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">Save Search</a>*}
			</div>
		{/if}
		{*<div class=" {if isset($isMap) && $isMap == 'true'}col-3 {else}col-auto{/if} {if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}order-3{/if} align-self-center- px-2">
			<h5 class="font-weight-bold *}{*{if isset($isPredefined) && $isPredefined == true }*}{*te-font-weight-500 text-dark*}{*{/if} *}{*my-0 te-search-result-count pb-0 txt-heading">{$total_record|number_format} Results</h5>
		</div>*}
		<div class=" {if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}order-2 text-right {if isset($isGrid) && $isGrid == 'true'}col-auto {else} col-xl-7 col-lg-3 {/if} {else} col-5  mt-1 col-xl-3 col-lg-3 {if isset($isPredefined) && $isPredefined == true }order-sm-3 col-sm-2 {/if} {/if} align-self-center px-3 px-md-2 px-xl-2 {if isset($isPredefined) && $isPredefined == true && isset($isGrid) && $isGrid !== 'true'} text-xl-right {else} text-xl-left {/if}">
			<h5 class="font-weight-bold {*{if isset($isPredefined) && $isPredefined == true }*}te-font-weight-500 text-dark{*{/if} *} my-0 te-search-result-count pb-0 txt-heading-">{$total_record|number_format} Results</h5>
		</div>
		{if isset($isGrid) && $isGrid !== 'true'}
			<div class="col-2 d-block- d-xl-none align-self-center mt-1 px-2  {if isset($isPredefined) && $isPredefined == 'true'}d-none d-sm-block{else} d-block {/if}">
				<div class="custom-control custom-switch te-width-max-content- d-xl-none d-inline-block te-map-switch float-right" {*data-toggle="modal"*} data-target="#te-map-modal">
					<input type="checkbox" class="custom-control-input" id="toggle-trigger">
					<label class="custom-control-label" for="toggle-trigger">Map</label>
				</div>
			</div>
		{/if}
		{*{if isset($isGrid) && $isGrid !== 'true'}
		<div class=" {if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}order-1 col-xl-6 mt-1 py-1 {else}col-xl-1 mt-2- float-right py-0 {/if}align-self-center custom-control custom-switch te-width-max-content- d-xl-block- d-none d-inline-xl-block te-map-switch-grid   *}{*{if isset($isPredefined) && $isPredefined == true}d-none d-xl-none {else}*}{*d-xl-block*}{*{/if}*}{*" data-toggle="modal" data-target="#te-map-modal">
			<input type="checkbox" class="custom-control-input" id="toggle-trigger-grid" name="toggle-trigger-grid" {if isset($is_map) && $is_map == 'true'}checked{/if}>
			<label class="custom-control-label" for="toggle-trigger-grid">Map</label>
		</div>
		{/if}*}

		{if isset($issorting) && $issorting == 'true'}
			<div class="{if isset($isPredefined) && $isPredefined == true} col-auto {else} col-5 col-sm-2 col-xl-8 text-right mt-xl-2- mt-1- oreder-2 {/if}{if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}order-2 text-right {if isset($isGrid) && $isGrid == 'true'}col-auto {else} col-xl-5 {/if}   {/if} align-self-center px-2">
				<div class="dropdown te-width-max-content d-inline-block pr-md-2">
					<button class="btn dropdown-toggle  bg-transparent border-0 shadow-none font-weight-bold- te-font-weight-600 te-sort-by" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Sort By
					</button>
					<div class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
						{foreach name=SortingOption from=$arrSortingOption key=sortkey item=sortitem}
							<a class="dropdown-item fsort {if isset($arrSearchCriteria.so) && $arrSearchCriteria.so|cat:'|'|cat:$arrSearchCriteria.sd == $sortkey}active{/if}" href="javascript:void(0);" data-value="{$sortkey}">{$sortitem}</a>
						{/foreach}
					</div>
				</div>
			</div>
		{/if}
		{*{if !isset($presearch_title) && $presearch_title == '' && (!isset($arrSearchCriteria.addtype) && $arrSearchCriteria.addtype == '')}
			{if cw::$screen == 'XL'}
				<div id="user-savesearch" class="{if !isset($presearch_title) && $presearch_title == ''}col-auto col-xl-5{else}col-xl-3{/if} col-lg-4 col-md-auto col-sm-auto px-2 px-lg-0 text-right px-xl-2 {if isset($issavesearch) && $issavesearch == 'true' && (isset($isGrid) || $isGrid !== 'true')}d-none d-xl-block{else} d-none {/if}">
					<button id="save_search" type="button" class="btn ml-1 ml-lg-1 rounded-0 shadow-none border-secondary- te-btn text-white- popup-modal-sm lpt-btn lpt-btn-txt" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch{else}/?action=member-login&ReqType=SaveSearch{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
						Save Search
					</button>
				</div>
			{/if}
		{/if}*}
	</div>
	{if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}</div></div>{/if}
{/if}
<div class="{if (!isset($isstyle) || (isset($isstyle) && ($isstyle == false || $isstyle == 4 || $isstyle == 6 || $isstyle == 5 || $isstyle == 10))) || (!isset($isGrid) || (isset($isGrid) && $isGrid == 'false' && (isset($isstyle) && ($isstyle !== false) )))}row {/if} {if isset($isstyle)  && ($isstyle == 4 || $isstyle == 5 || $isstyle == 6) || ($isstyle == 10 && $device == 'MD' && $device != 'XS' && $device != 'SM')}px-4{/if} {if isset($isPredefined) && $isPredefined == true && $isstyle == ''} px-xl-3 px-2 px-md-3 {/if} {if isset($predefinedId) && $predefinedId != '' && isset($isstyle) && $isstyle != ''} pms-listing-result-{$predefinedId} {else} pms-listing-result {/if}">

</div>
{if !isset($isstyle) || (isset($isstyle) && $isstyle != 1 && $isstyle != 2 && $isstyle != 3 && $isstyle != 4 && $isstyle != 7 && $isstyle != 8 && $isstyle != 9 && $isstyle != 11 && $isstyle != 12) || (isset($isstyle) && $isstyle == 5 && $page_size >= 10) || (isset($isstyle) && $isstyle == 6 && $page_size >= 10)}
	<div class="row py-2">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-2- {if $isstyle == 10} style-10 px-xl-2 {/if}">
			<nav aria-label="...">
				{if $total_record > $page_size}
					<ul id="pms-area-pager" class="pagination mb-0{if $isstyle == 10} p-0 {/if}">

					</ul>
				{/if}
			</nav>
		</div>
	</div>

	{if isset($is_rental) && $is_rental == false && isset($psearch_generate_rental) && $psearch_generate_rental == 'Yes'}
		<div class="row pt-2 pb-4">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center pms-market-report">
				{if isset($psearch_generate_rental) && $psearch_generate_rental == 'Yes'}
					<div class=" no-data-msg text-center  d-inline-block">
						<a class="btn btn-primary p-3" href="{$rental_url}"> View Rentals</a>
					</div>
					<input type="hidden" name="rental" value="true" id="prenatl">
				{/if}
			</div>
		</div>
	{/if}
{/if}
{*{if $total_record > 0 && $disclaimer == 'true'}
	*}{*{if isset($isstyle) && $isstyle == true && isset($isPredefined) && $isPredefined == true}
		{else}*}{*
		<div id = "disclaimer-section" class="d-none">
			*}{*{if (isset($sys_name) && $sys_name == 'ACTRIS' && isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}) || (isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')})}*}{*
			{if (isset($sys_name) && $sys_name == 'ACTRIS') || (isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')})}
				<div class="disclaimer-txt-color">
					<p align="justify">The information being provided is for consumers' personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing.</p>

					<p align="justify">Based on information from the Austin Board of REALTORS® (alternatively, from ACTRIS) from {$MLS_last_update_date} *}{*October 8th, 2021 at 4:19am*}{*. Neither the Board nor ACTRIS guarantees or is in any way responsible for its accuracy. The Austin Board of REALTORS®, ACTRIS and their affiliates provide the MLS and all content therein "AS IS" and without any warranty, express or implied. Data maintained by the Board or ACTRIS may not reflect all real estate activity in the market.</p>

					<p align="justify">All information provided is deemed reliable but is not guaranteed and should be independently verified.</p>
				</div>
			{elseif isset($sys_name) && $sys_name == 'FTL'}
				<div class= "disclaimer-txt-color">
					<p align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Op-portunity Act.</p>

					<img class = "disclaimer_img" src="{$TPL_images}/both.png"> <p align="justify">The data provided by Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each indi-vidual listing are ©{'Y'|date} Palm Beach Board of Realtors Multiple Listing Service. All Rights Reserved. The information provided is for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify pro-spective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>

					<p align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This infor-mation is not verified for authenticity or accuracy and is not guaranteed. Copyright ©{'Y'|date} BeachesMLS, Inc.</p>

					<p align="justify">Listing information last updated on {$MLS_last_update_date}.</p>

				</div>
			{else}
				<div class="disclaimer-txt-color">
					<p align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Op-portunity Act.</p>

					<img class = "disclaimer_img" src="{$TPL_images}/both.png"> <p align="justify">The data provided by Miami Association of REALTORS® MLS and Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©{'Y'|date} Miami Association of REALTORS® MLS  and Palm Beach Board of Realtors Multiple List-ing Service. All Rights Reserved. The information provided is for consumers’ per-sonal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed relia-ble but is not guaranteed accurate, and should be independently verified.</p><br />

					<p align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This infor-mation is not verified for authenticity or accuracy and is not guaranteed. Copyright ©{'Y'|date} BeachesMLS, Inc.</p>

					<p align="justify">Listing information last updated on {$MLS_last_update_date}.</p>
				</div>
			{/if}
		</div>
	*}{*{/if}*}{*
{/if}*}
<input type="hidden" id="cur-page" value="{$page}">
<input type="hidden" class="pid" id="pid" name="pid" value="{$predefinedId}">
{if isset($predefinedId) && $predefinedId != '' && isset($isstyle) && $isstyle != ''}
    <input type="hidden" class="json" id="json_{$predefinedId}" name="json_{$predefinedId}" value="{$jsonMapData}" data-pid="{$predefinedId}">
	<input type="hidden" class="json_css" id="css_{$predefinedId}" name="json_css" value="{$attr.css}" data-pid="css_{$predefinedId}">
	<input type="hidden" class="json_title" id="title_{$predefinedId}" name="json_title" value="{$attr.title}" data-pid="title_{$predefinedId}">
	<input type="hidden" class="json_bg" id="bg_{$predefinedId}" name="json_bg" value="{$attr.background}" data-pid="bg_{$predefinedId}">
	<input type="hidden" class="json_url" id="url_{$predefinedId}" name="json_url" value="{$attr.url}" data-pid="url_{$predefinedId}">
{/if}
<input type="hidden" name="OnPage" id="OnPage" value="SearchResult"/>
