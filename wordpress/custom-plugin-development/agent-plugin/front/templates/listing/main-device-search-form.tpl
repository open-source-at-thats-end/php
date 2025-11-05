<form class="form" id="frmlistingsearch" role="form" method="post" action="{$formAction}">
	<div id="search-filters" class="row te-search-filter-row shadow-none">
		{if isset($login_enable) && $login_enable == 'Yes'}
			<div class="col-xl-4 col-lg-10 col-md-8 col-sm-8 col-8 px-0 px-lg-3-  px-xl-0 py-0 py-xl-0 te-filter-searchbar ">
		{else}
			<div class="col-xl-4 col-lg-10 col-md-10 col-sm-10 col-10 px-0 px-lg-3-  px-xl-0 py-0 py-xl-0 te-filter-searchbar ">
		{/if}
			<div class="input-group h-100 px-xl-2 px-md-2 px-0 btn-gray border-right-">
				<input type="text" id="AddressName" class="form-control shadow-none rounded-0 align-self-center h-100 py-1 py-lg-4 pl-2 border-0 te-filter-searchbox btn-gray" name="AddressName" value="{$arrSearchCriteria.addval|default:''}" placeholder="City, Neighborhood, Address, School, ZIP, MLS#" aria-label="Username" aria-describedby="basic-addon1">
				<div id="search-box" class="input-group-prepend px-xl-4 px-1">
					<span class="input-group-text border-0 btn-gray svg-icon-color te-btn- text-white- lpt-btn- lpt-btn-txt-" id="basic-addon1"><i class="fas fa-search fa-lg"></i></span>
				</div>
				<input name="addval" class="" id="AddressValue" value="{$arrSearchCriteria.addval|default:''}" data-type="hidden" type="hidden">
				<input name="addtype" class="" id="AddressType" value="{$arrSearchCriteria.addtype|default:''}" data-type="hidden" type="hidden">
			</div>
		</div>

		{*<div class="col-auto d-block d-lg-none align-self-center px-2 px-md-3 te-map-switch-column ml-auto">
			<div class="custom-control custom-switch te-width-max-content- d-inline-block te-map-switch" data-toggle="modal" data-target="#te-map-modal">
				<input type="checkbox" class="custom-control-input" id="toggle-trigger">
				<label class="custom-control-label" for="toggle-trigger">MAP</label>
			</div>
		</div>*}

		<div class="col-2 col-lg-2 col-md-2 col-sm-2 d-block d-xl-none d-flex justify-content-around pb-1  py-0 mb-2- px-0 btn-gray border-right- px-md-3-">
			<div class="d-flex d-xl-none svg-icon-color">
				<a class="btn te-btn- text-white- w-100 rounded-0 responsive-filters-tab align-self-center shadow-none te-font-size-14 font-weight-bold te-width-max-content- px-2 mr-3- lpt-btn- lpt-btn-txt-" role="button" data-toggle="modal" data-target="#exampleModalScrollable"><i class="fas fa-sliders-h fa-2x font-svg pr-1 align-middle"></i>
				</a>
				{* <button type="button" class="btn ml-1 rounded-0 shadow-none border-secondary te-btn text-white te-font-size-14 font-weight-bold px-2 d-block d-sm-none" data-toggle="modal" data-target="#exampleModal">
					 Save Search
				 </button>*}
			</div>
		</div>
		{if isset($login_enable) && $login_enable == 'Yes'}
			{if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD'}
				<div class="col-2 col-lg-2 col-md-2 col-sm-2 d-block d-xl-none justify-content-around px-0 px-md-4- pt-1 text-center save_search_mob btn-gray svg-icon-color">
					<button id="save_search" type="button" class="btn ml-2- ml-lg-1- rounded-0 shadow-none border-secondary- te-btn- text-white- lpt-btn- lpt-btn-txt- popup-modal-sm {if isset($issavesearch) && $issavesearch == 'false' && (isset($isGrid) || $isGrid == 'true')}d-none{/if}" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch{else}/?action=member-login&ReqType=SaveSearch{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
						<i class="far fa-2x font-svg fa-bell align-middle pr-1"></i>
					</button>
				</div>
			{/if}
		{/if}

		{if $deviceType == 'computer' || $deviceType == 'tablet'}
			<div class="col-xl-7 col-lg-5- col-md-9- col-sm-12- col-12- d-none d-xl-block d-xl-inline-flex justify-content-around- px-1 py-0 mt-2 mt-md-0 te-filter-dropdowns btn-gray border-right-">
				<div class="row w-100 btn-gray-  px-0 mx-0 justify-content-around-">
					<div class="col-xl-2 col col-lg col-lg-3- search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownStype" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Property Type
							</a>
							<div class="dropdown-menu mt-12 bg-white px-4 border rounded-0 mx-height" aria-labelledby="dropdownStype">
								<div class="row">
									{*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
										<div class="col-xl-12 col-lg-12 px-3 py-0">
											{foreach name=ptype from=$arrMeta['SubTypeActris'] key=skey item=sitem}
												<div class="custom-control custom-checkbox py-2">
													<input type="checkbox" class="custom-control-input fstype" {if $skey|in_array:$arrSearchCriteria.stype || $skey == $arrSearchCriteria.stype}checked="checked"{/if} value="{$skey}" name="stype[]" id="{$skey}">
													<label class="custom-control-label" for="{$skey}">{$sitem}</label>
												</div>
											{/foreach}
										</div>
									{else}*}
									<div class="col-xl-12 col-lg-12 px-3 py-0">
										{foreach name=ptype from=$arrMeta['SubType'] key=skey item=sitem}
											<div class="custom-control custom-checkbox py-2">
												<input type="checkbox" class="custom-control-input fstype" {if (isset($arrSearchCriteria.stype)) && ($skey|in_array:$arrSearchCriteria.stype || $skey == $arrSearchCriteria.stype)}checked="checked"{/if} value="{$skey}" name="stype[]" id="{$skey}">
												<label class="custom-control-label" for="{$skey}">{$sitem}</label>
											</div>
										{/foreach}
									</div>
									{*{/if}*}
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- filter-button search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500 filter-btn-txt" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status
							</a>
							<div class="dropdown-menu mt-12 bg-white px-3 py-1 border rounded-0">
								<div class="row">
									<div class="col-xl-12 col-lg-12 py-0">
										{foreach name=beds from=$arrStatus key=statuskey item=statusitem}
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fstatus" {if $arrSearchCriteria.status == $statuskey}checked{elseif  !isset($arrSearchCriteria.status) && $statuskey == 'all'} checked{/if} value="{$statuskey}" name="status" id="status-{$statuskey}">
												<label class="custom-control-label" for="status-{$statuskey}">{$statusitem}</label>
											</div>
										{/foreach}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex py-1">
										<div class="te-width-max-content">
											{*<select class="custom-select rounded-0 fprice" name="minprice">
												<option value="" selected>Min</option>
												{html_options options=$arrPriceRange selected=$arrSearchCriteria.minprice}
											</select>*}
											<input type="text" name="minprice" value="{$arrSearchCriteria.minprice}" class="form-control rounded-0 fprice" id="minprice" placeholder="Min Price" aria-describedby="min price">
										</div>

										<div class="mx-3 align-self-center"> To </div>
										<div class="te-width-max-content">
											{*<select class="custom-select rounded-0 fprice" name="maxprice">
												<option value="" selected>Max</option>
												{html_options options=$arrPriceRange selected=$arrSearchCriteria.maxprice}
											</select>*}
											<input type="text" name="maxprice" value="{$arrSearchCriteria.maxprice}" class="form-control rounded-0 fprice" id="maxprice" placeholder="Max Price" aria-describedby="max price">
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- d-lg-none d-xl-block search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Beds
							</a>
							<div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
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
					</div>
					<div class="col-xl-2 col col-lg col-lg-3- d-lg-none d-xl-block search-btn-hover">
						<div class="dropdown d-none d-xl-flex justify-content-center py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds">
							<a class="btn dropdown-toggle rounded-0 shadow-none text-uppercase- align-self-center te-font-weight-500" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Baths
							</a>
							<div class="dropdown-menu mt-12 bg-white px-4 border rounded-0">
								<div class="row">
									<div class="col-xl-12 col-lg-12 px-3 py-0">
										<div class="custom-control custom-radio py-2">
											<input type="radio" class="custom-control-input fbath" {if $arrSearchCriteria.minbath == ''}checked{/if} value="" name="minbath" id="bath-any">
											<label class="custom-control-label" for="bath-any">Any</label>
										</div>
										{foreach name=beds from=$arrBathRange key=bathkey item=bathitem}
											<div class="custom-control custom-radio py-2">
												<input type="radio" class="custom-control-input fbath" {if $arrSearchCriteria.minbath == $bathkey}checked{/if} value="{$bathkey}" name="minbath" id="bath-{$bathkey}">
												<label class="custom-control-label" for="bath-{$bathkey}">{$bathitem}</label>
											</div>
										{/foreach}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 align-self-center d-none d-lg-flex py-2 py-xl-0 border-right- d-flex justify-content-around search-filter-btn-hover h-100">
						<div class="dropdown d-none d-xl-flex py-1 filter-dropdown te-more-filter-dropdown align-self-center">
							<a class="dropdown-toggle btn bg-white- px-4 rounded-0 shadow-none text-uppercase- te-font-weight-500 more-filter-dropdown" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-sliders-h fa-2x pr-2 align-middle"></i>More Filters
							</a>
							<div class="dropdown-menu dropdown-menu-right bg-white p-4 te-bg-light border-0 rounded-0 te-more-filter" aria-labelledby="dropdownMenuLink" style="">
								<div class="te-close-more-filter position-absolute te-btn text-white-  lpt-btn p-3 lpt-btn-txt">
									<a aria-label="button" href="javascript:void(0);" role="button">
										<i class="fas fa-times p-3-  te-more-filter-close"></i>
									</a>
								</div>

								<div class="row pb-5 d-lg-block d-xl-none d-sm-none lg-device-bedbath">
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<h5 class="txt-heading heading_txt_color">Bathrooms</h5>
									</div>
									<div class="col-xl-12 col-lg-12 py-0 px-3">
										<div class="custom-control custom-radio py-2 te-width-max-content d-inline-block px-4">
											<input type="radio" class="custom-control-input" {if $arrSearchCriteria.minbath == ''}checked{/if} value="" name="lgminbath" id="ps-small-bath-any">
											<label class="custom-control-label" for="ps-small-bath-any">Any</label>
										</div>
										{foreach name=beds from=$arrBathRange key=bathkey item=bathitem}
											<div class="custom-control custom-radio py-2 te-width-max-content d-inline-block px-4">
												<input type="radio" class="custom-control-input" {if $arrSearchCriteria.minbath == $bathkey}checked{/if} value="{$bathkey}" name="lgminbath" id="ps-small-bath-{$bathkey}">
												<label class="custom-control-label" for="ps-small-bath-{$bathkey}">{$bathitem}</label>
											</div>
										{/foreach}
									</div>
								</div>

								<div class="row pb-5 d-lg-block d-xl-none d-sm-none lg-device-bedbath">
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<h5 class="txt-heading heading_txt_color">Bedrooms</h5>
									</div>
									<div class="col-xl-12 col-lg-12 py-0 px-3">
										<div class="d-flex px-0">
											<div class="w-100">
												<select class="custom-select rounded-0 border-0 shadow-none" name="minbed">
													<option value="" selected="selected">Min</option>
													{html_options options=$arrBedRange selected=$arrSearchCriteria.minbed}
												</select>

											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select class="custom-select rounded-0 border-0 shadow-none" name="maxbed">
													<option value="" selected="selected">Max</option>
													{html_options options=$arrBedRange selected=$arrSearchCriteria.maxbed}
												</select>
											</div>
										</div>
									</div>
									<div class="row pb-5">
										<div class="{*{if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}col-xl-6 col-lg-6{*{else}col-xl-12 col-lg-12{/if}*} col-md-12 col-sm-12 col-12 form-group mb-0">
											<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Waterfront Description</h6>
											<select name="waterfrontdesc" class="custom-select rounded-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrWaterfrontDesc selected=$arrSearchCriteria.waterfrontdesc}
											</select>
										</div>
										{*{if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
										<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
											<div class="d-flex px-0">
												<div class="w-100">
													<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Security</h6>
													<select name="security_safety" class="custom-select rounded-0 border-0 shadow-none">
														<option value="" selected="">No preference</option>
														{html_options options=$arrSecuritySafety selected=$arrSearchCriteria.security_safety}
													</select>
												</div>
											</div>
										</div>
										{*{/if}*}
									</div>

									<div class="row pb-5" style="bottom: 0;">
										<div class="col-xl-12">
											<a class="btn btn-secondary- rounded-0 te-btn border-secondary- te-btn px-5 btn-search-filter lpt-btn lpt-btn-txt" href="javascript:void(0);" role="button">Search</a>
											<a class="btn btn-white rounded-0 border-dark bg-white px-5 ml-2 btn-search-reset" href="javascript:void(0);" role="button">Reset</a>
											{*                                            <input class="btn btn-white rounded-0 border-dark bg-white px-5 ml-2 btn-search-reset" type="reset" value="Reset">*}
										</div>
									</div>

								</div>

								<h5 class="text-uppercase text-secondary mb-5 font-weight-bold txt-heading heading_txt_color">Property Facts</h5>
								{*<div class="row pb-5">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<h5 class="text-uppercase mb-5 font-weight-bold">Property Facts</h5>
										<h6 class="text-uppercase mb-4 font-weight-bold">Subdivision</h6>
										<input type="text" name="sdivlist" value="{$arrSearchCriteria.sdivlist}" class="form-control rounded-0 border-0 shadow-none" id="sdivlist" aria-describedby="sdivlist" placeholder="">
									</div>
								</div>
*}
								{*<div class="row pb-5">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<h6 class="text-uppercase mb-4 font-weight-bold">Property Style</h6>
										{foreach name=pstyle from=$arrMeta['PropertyStyle'] key=pkey item=pitem}
											<div class="custom-control custom-checkbox px-4 py-3 d-inline-block">
												<input type="checkbox" class="custom-control-input p-0 m-o fpstyle" name="pstyle[]" value="{$pkey}" {if $pkey|in_array:$arrSearchCriteria.pstyle || $pkey == $arrSearchCriteria.pstyle}checked="checked"{/if} id="ps-{$pkey}">
												<label class="custom-control-label" for="ps-{$pkey}">{$pitem}</label>
											</div>
										{/foreach}

									</div>
								</div>*}

								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Square Feet</h6>
										<div class="d-flex px-0">
											<div class="w-100">
												<select name="minsqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Min</option>
													{html_options options=$arrSqftRange selected=$arrSearchCriteria.minsqft}
												</select>
											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select name="maxsqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Max</option>
													{html_options options=$arrSqftRange selected=$arrSearchCriteria.maxsqft}
												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Days on Market</h6>
										<div class="w-100">
											<select name="dom" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrDayMarket selected=$arrSearchCriteria.dom}
											</select>
										</div>
									</div>
								</div>

								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Lot Size</h6>
										<div class="d-flex px-0">
											<div class="w-100">
												<select name="minlotsizesqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Min</option>
													{html_options options=$arrLotSize selected=$arrSearchCriteria.minlotsizesqft}
												</select>
											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select name="maxlotsizesqft" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Max</option>
													{html_options options=$arrLotSize selected=$arrSearchCriteria.maxlotsizesqft}
												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">HOA</h6>
										<div class="w-100">
											<select name="ishoa" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrYesNo selected=$arrSearchCriteria.ishoa}
											</select>
										</div>
									</div>

								</div>

								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Year Built</h6>
										<div class="d-flex px-0">
											<div class="w-100">
												<select name="minyear" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Min</option>
													{html_options options=$arrminYearBuild selected=$arrSearchCriteria.minyear}
												</select>
											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select name="maxyear" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Max</option>
													{html_options options=$arrmaxYearBuild selected=$arrSearchCriteria.maxyear}
												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">New Construction</h6>
										<div class="w-100">
											<select name="isnew" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrTrueFalse selected=$arrSearchCriteria.isnew}
											</select>
										</div>
									</div>

								</div>

								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Pool</h6>
												<select name="pool" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Any</option>
													{html_options options=$arrYesNo selected=$arrSearchCriteria.pool}
												</select>
											</div>
											<div class="mx-3 align-self-center"></div>
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Pets Allowed</h6>
												<select name="petsallowed" class="custom-select rounded-0 border-0 py-0 shadow-none">
													<option value="" selected="">Any</option>
													{html_options options=$arrYesNo selected=$arrSearchCriteria.petsallowed}
												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Furnished</h6>
												<select name="furnished" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													{html_options options=$arrFurnished selected=$arrSearchCriteria.furnished}
												</select>
											</div>
										</div>
									</div>

								</div>

								<div class="row pb-5">
									<div class="col-xl-6 col-lg-5 col-md-5">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Waterfront</h6>
										<div class="w-100">
											<select name="waterfront" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrYesNo selected=$arrSearchCriteria.waterfront}
											</select>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group mb-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Waterfront Description</h6>
										<select name="waterfrontdesc" class="custom-select rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											{html_options options=$arrWaterfrontDesc selected=$arrSearchCriteria.waterfrontdesc}
										</select>
									</div>
									{*<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">System Name</h6>
												<select name="sys_name" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">All</option>
													{html_options options=$arrSystemName selected=$arrSearchCriteria.sys_name}
												</select>
											</div>
										</div>
									</div>*}
								</div>
								<div class="row pb-5">
									{*<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group mb-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Horse Amenities</h6>
										<input type="text" name="horse_amenities" value="{$arrSearchCriteria.horse_amenities}" class="form-control rounded-0 border-0 py-0 shadow-none" id="horse_amenities" placeholder="Horse Amenities" aria-describedby="">
									</div>*}
									<div class="{*{if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}col-xl-6{*{else}col-xl-12{/if}*} col-lg-4 col-md-12 col-sm-12 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Horse Amenities</h6>
												<select name="horse_yn" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													{html_options options=$arrYesNo selected=$arrSearchCriteria.horse_yn}
												</select>
											</div>
										</div>
									</div>
									{*{if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
									<div class="col-xl-6 col-lg-4 col-md-12 col-sm-12 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Security</h6>
												<select name="security_safety" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">No preference</option>
													{html_options options=$arrSecuritySafety selected=$arrSearchCriteria.security_safety}
												</select>
											</div>
										</div>
									</div>
									{*{/if}*}
								</div>
								{*{if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
								<div class="row pb-5">
									<div class="col-xl-6 col-lg-6 col-md-6">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Membership Required</h6>
										<div class="w-100">
											<select name="membership_required" class="custom-select rounded-0 border-0 py-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrYesNo selected=$arrSearchCriteria.membership_required}
											</select>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group mb-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Membership Fee</h6>
										<input type="text" name="membership_fee" value="{$arrSearchCriteria.membership_fee}" class="form-control rounded-0 border-0 py-0 shadow-none" id="membership_fee" placeholder="Membership Fee">
									</div>
								</div>
								{*{/if}*}
								<div class="row pb-5">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group mb-0">
										<h6 class="text-capitalize mb-2 font-weight-bold txt-heading heading_txt_color">Keywords</h6>
										<input type="text" name="kword" value="{$arrSearchCriteria.kword}" class="form-control rounded-0 border-0 py-0 shadow-none" id="kword" placeholder="Try remodel, renovated, turn key, fence, new roof" aria-describedby="kwordHelp">
									</div>
								</div>
								<div class="row pb-5" style="bottom: 0;">
									<div class="col-xl-12">
										<a class="btn btn-secondary- rounded-0 te-btn border-secondary- te-btn px-5 btn-search-filter lpt-btn lpt-btn-txt" href="javascript:void(0);" role="button">Search</a>
										<a class="btn btn-white rounded-0 border-dark bg-white px-5 ml-2 btn-search-reset" href="javascript:void(0);" role="button">Reset</a>
										{*                                            <input class="btn btn-white rounded-0 border-dark bg-white px-5 ml-2 btn-search-reset" type="reset" value="Reset">*}
									</div>
								</div>
							</div>
						</div>
					</div>
					{*                    <input type="hidden" id="so" name="so" value="{$arrSearchCriteria.so|default:'price'}">*}
					{*                    <input type="hidden" id="sd" name="sd" value="{$arrSearchCriteria.sd|default:'asc'}">*}
					{*                    <input type="hidden" id="spage" name="spage" value="{$arrSearchCriteria.spage|default:1}">*}
					{*<input type="hidden" id="MapZoomLevel" name="mz" value="{$arrSearchCriteria.mz|default:13}">
					<input type="hidden" id="MapCenterLat" name="clat" value="{$arrSearchCriteria.clat|default:25.761681}">
					<input type="hidden" id="MapCenterLng" name="clng" value="{$arrSearchCriteria.clng|default:-80.191788}">
					<input type="hidden" id="map" name="map" value="{$arrSearchCriteria.map|default:''}">
					<input type="hidden" id="poly" name="poly" value="{$arrSearchCriteria.poly|default:''}">
					<input type="hidden" id="cir" name="cir" value="{$arrSearchCriteria.cir|default:''}">*}
				</div>
				{if isset($login_enable) && $login_enable == 'Yes'}
					<div class="col-6- col-xl-2 align-self-center pr-0">
						<button id="save_search" type="button" class="btn ml-1- ml-lg-1 rounded-0 shadow-none te-font-size-13 te-btn- text-white- lpt-btn- lpt-btn-txt- popup-modal-sm p-0 {if isset($issavesearch) && $issavesearch == 'false' && (isset($isGrid) || $isGrid == 'true')}d-none{/if}" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch{else}/?action=member-login&ReqType=SaveSearch{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
							<i class="far fa-2x fa-bell align-middle pr-2"></i>Save Search
						</button>
					</div>
				{/if}
			</div>
			<div class="col-xl-1 col-lg-5- col-md-9- col-sm-12- col-12- d-none d-xl-block d-xl-inline-flex px-1 px-xl-0 mt-md-0 te-filter-dropdowns btn-gray">
				<div class="row w-100 px-0 mx-0 search-filter-btn-hover">

					{*<div class="col-xl-6 align-self-center ml-2- d-none d-lg-flex d-flex justify-content-around">
						<button id="save_search" type="button" class="btn ml-lg-1 rounded-0 shadow-none te-font-weight-500 border-secondary- te-btn- text-white- lpt-btn- lpt-btn-txt- popup-modal-sm {if isset($issavesearch) && $issavesearch == 'false' && (isset($isGrid) || $isGrid == 'true')}d-none{/if}" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch{else}/?action=member-login&ReqType=SaveSearch{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
							<i class="far fa-2x fa-bell align-middle pr-2"></i>Alerts
						</button>
					</div>*}
					{if isset($isGrid) && $isGrid !== 'true'}
						<div class="col-xl-12 align-self-center hover-unset text-center">
							<div class=" {if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}order-1 col-xl-6 mt-1 py-1 {else}col-xl-1 {/if} custom-control custom-switch d-none d-xl-inline-flex te-map-switch-grid btn-gray align-items-center te-font-weight-500" data-toggle="modal" data-target="#te-map-modal">
								<input type="checkbox" class="custom-control-input" id="toggle-trigger-grid" name="toggle-trigger-grid" {if isset($is_map) && $is_map == 'true'}checked{/if}>
								<label class="custom-control-label py-1" for="toggle-trigger-grid">Map</label>
							</div>
						</div>
					{/if}
				</div>
			</div>
		{/if}
	</div>
</form>