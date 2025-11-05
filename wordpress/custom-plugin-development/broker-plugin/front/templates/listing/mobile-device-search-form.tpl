<div class="modal fade filter-modal w-100 mbl-searchfrm" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true">
	<div class="modal-dialog modal-dialog-scrollable m-0 mw-100" role="document">
		<div class="modal-content border-0 rounded-0 te-bg-light">

			<div class="modal-header px-3 border-dark">
				<h5 class="modal-title txt-heading heading_txt_color" id="exampleModalScrollableTitle">Filters</h5>
				<button type="button" class="close hide" data-dismiss="modal" aria-label="Close">
					<span class="text-dark" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="form" id="mbfrmsearch" role="form" method="post" action="{$formAction}">
					<div class="row p-2">
						{if isset($isGrid) && $isGrid !== 'true'}
							<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 pb-3 py-md-0">
								<h5 class="text-capitalize mb-3 font-weight-bold- txt-heading heading_txt_color">Status</h5>
								<div class="w-100">
									<select name="status" class="custom-select rounded-0 border-0 py-0 shadow-none">
										{if $arrSearchCriteria.status && $arrSearchCriteria.status != ''}
											{assign var="lsStatus" value={$arrSearchCriteria.status}}
										{elseif !isset($arrSearchCriteria.status)}
											{assign var="lsStatus" value="all"}
										{/if}
										{html_options options=$arrStatus selected=$lsStatus}

									</select>
								</div>
							</div>
						{/if}
						<div class="col-xl-7 col-lg-7 {if isset($isGrid) && $isGrid == 'true'} col-md-12 {else} col-md-7{/if} col-sm-12 col-12">
							<h5 class="text-capitalize mb-3 txt-heading heading_txt_color">Price Range </h5>
							<div class="d-flex px-0">
								<div class="w-100">
									<!--<select class="custom-select rounded-0 border-0 shadow-none" name="minprice">
										<option value="" selected="selected">Min</option>
										{html_options options=$arrPriceRange selected=$arrSearchCriteria.minprice}
									</select>-->
									<input type="text" name="minprice" value="{$arrSearchCriteria.minprice}" class="form-control rounded-0 py-0 border-0 shadow-none" id="minprice" placeholder="Min Price" aria-describedby="min price">
								</div>
								<div class="mx-3 align-self-center"> - </div>
								<div class="w-100">
									<!--<select class="custom-select rounded-0 border-0 shadow-none" name="maxprice">
										<option value="" selected="selected">Max</option>
										{html_options options=$arrPriceRange selected=$arrSearchCriteria.maxprice}
									</select>-->
									<input type="text" name="maxprice" value="{$arrSearchCriteria.maxprice}" class="form-control border-0 rounded-0 py-0 shadow-none" id="maxprice" placeholder="Max Price" aria-describedby="max price">
								</div>
							</div>
						</div>
					</div>
					<hr class="w-100">
					<div class="row p-2">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<h5 class="txt-heading heading_txt_color">Bathrooms</h5>
						</div>
						<div class="col-xl-12 col-lg-12 py-0 px-3">
							<div class="custom-control custom-radio py-2 te-width-max-content d-inline-block px-4">
								<input type="radio" class="custom-control-input" {if $arrSearchCriteria.minbath == ''}checked{/if} value="" name="minbath" id="ps-small-bath-any">
								<label class="custom-control-label" for="ps-small-bath-any">Any</label>
							</div>
							{foreach name=beds from=$arrBathRange key=bathkey item=bathitem}
								<div class="custom-control custom-radio py-2 te-width-max-content d-inline-block px-4">
									<input type="radio" class="custom-control-input" {if $arrSearchCriteria.minbath == $bathkey}checked{/if} value="{$bathkey}" name="minbath" id="ps-small-bath-{$bathkey}">
									<label class="custom-control-label" for="ps-small-bath-{$bathkey}">{$bathitem}</label>
								</div>
							{/foreach}
						</div>
					</div>
					<hr class="w-100">
					<div class="row p-2">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<h5 class="txt-heading heading_txt_color">Bedrooms</h5>
						</div>
						<div class="col-xl-12 col-lg-12 py-0 px-3">
							<div class="d-flex px-0">
								<div class="w-100">
									<select class="custom-select rounded-0 border-0 shadow-none py-0" name="minbed">
										<option value="" selected="selected">Min</option>
										{html_options options=$arrBedRange selected=$arrSearchCriteria.minbed}
									</select>

								</div>
								<div class="mx-3 align-self-center"> - </div>
								<div class="w-100">
									<select class="custom-select rounded-0 border-0 shadow-none py-0" name="maxbed">
										<option value="" selected="selected">Max</option>
										{html_options options=$arrBedRange selected=$arrSearchCriteria.maxbed}
									</select>
								</div>
							</div>
						</div>
					</div>
					<hr class="w-100">
					{if isset($isGrid) && $isGrid !== 'true'}
						<div class="row p-2">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<h5 class="txt-heading heading_txt_color">Type</h5>
							</div>
							{*{if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									{foreach name=ptype from=$arrMeta['SubTypeActris'] key=skey item=sitem}
										<div class="custom-control custom-checkbox py-2 te-width-max-content d-inline-block px-4">
											<input type="checkbox" class="custom-control-input" {if $skey|in_array:$arrSearchCriteria.stype || $skey == $arrSearchCriteria.stype}checked="checked"{/if} value="{$skey}" name="stype[]" id="{$skey}">
											<label class="custom-control-label" for="{$skey}">{$sitem}</label>
										</div>
									{/foreach}
								</div>
							{else}*}
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									{foreach name=ptype from=$arrMeta['SubType'] key=skey item=sitem}
										<div class="custom-control custom-checkbox py-2 te-width-max-content d-inline-block px-4">
											<input type="checkbox" class="custom-control-input" {if $skey|in_array:$arrSearchCriteria.stype || $skey == $arrSearchCriteria.stype}checked="checked"{/if} value="{$skey}" name="stype[]" id="{$skey}">
											<label class="custom-control-label" for="{$skey}">{$sitem}</label>
										</div>
									{/foreach}
								</div>
							{*{/if}*}
						</div>
						<hr class="w-100">
					{/if}

					<div class="row px-2">
						<div class="col-xl-12 col-lg-12">
							{* <div class="row pb-5">
								 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									 <h5 class="text-uppercase mb-5 font-weight-bold">Property Facts </h5>
									 <h6 class="text-uppercase mb-2">Subdivision </h6>
									 <input type="text" name="sdivlist" value="{$arrSearchCriteria.sdivlist}" class="form-control rounded-0 border-0 shadow-none" id="sdivlist" aria-describedby="sdivlist" placeholder="">
								 </div>
							 </div>
							 <div class="row pb-5">
								 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									 <h6 class="text-uppercase mb-4 font-weight-bold">Property Style</h6>
									 {foreach name=pstyle from=$arrMeta['PropertyStyle'] key=pkey item=pitem}
										 <div class="custom-control custom-checkbox px-4 py-3 d-inline-block te-width-max-content d-inline-block px-4">
											 <input type="checkbox" class="custom-control-input p-0 m-o fpstyle" name="pstyle[]" value="{$pkey}" {if $pkey|in_array:$arrSearchCriteria.pstyle || $pkey == $arrSearchCriteria.pstyle}checked="checked"{/if} id="ps-{$pkey}">
											 <label class="custom-control-label" for="ps-{$pkey}">{$pitem}</label>
										 </div>
									 {/foreach}
								 </div>
							 </div>*}
							<div class="row pb-5">
								<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
									<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Square Feet</h6>
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
							</div>
							{if isset($isGrid) && $isGrid !== 'true' }
								<div class="row pb-5">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Lot Size</h6>
										<div class="d-flex px-0">
											<div class="w-100">
												<select name="minlotsizesqft" class="custom-select py-0 rounded-0 border-0 shadow-none">
													<option value="" selected="">Min</option>
													{html_options options=$arrLotSize selected=$arrSearchCriteria.minlotsizesqft}
												</select>
											</div>
											<div class="mx-3 align-self-center"> - </div>
											<div class="w-100">
												<select name="maxlotsizesqft" class="custom-select py-0 rounded-0 border-0 shadow-none">
													<option value="" selected="">Max</option>
													{html_options options=$arrLotSize selected=$arrSearchCriteria.maxlotsizesqft}
												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-5 col-md-5 py-3 py-md-0">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Days on Market</h6>
										<div class="w-100">
											<select name="dom" class="custom-select rounded-0 py-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrDayMarket selected=$arrSearchCriteria.dom}
											</select>
										</div>
									</div>
								</div>
							{/if}
							<div class="row pb-5">
								<div class="col-xl-7 col-lg-7 {if isset($isGrid) && $isGrid == 'true'} col-md-12 {else} col-md-7{/if} col-sm-12 col-12">
									<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Year Built</h6>
									<div class="d-flex px-0">
										<div class="w-100">
											<select name="minyear" class="custom-select py-0 rounded-0 border-0 shadow-none">
												<option selected="" value="">Min</option>
												{html_options options=$arrminYearBuild selected=$arrSearchCriteria.minyear}
											</select>
										</div>
										<div class="mx-3 align-self-center"> - </div>
										<div class="w-100">
											<select name="maxyear" class="custom-select py-0 rounded-0 border-0 shadow-none">
												<option selected="" value="">Max</option>
												{html_options options=$arrmaxYearBuild selected=$arrSearchCriteria.maxyear}
											</select>
										</div>
									</div>
								</div>
								{if isset($isGrid) && $isGrid !== 'true' }
									<div class="col-xl-5 col-lg-6 col-md-5 col-sm-12 py-3 py-md-0 col-12 mt-5-">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Furnished</h6>
												<select name="furnished" class="custom-select rounded-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													{html_options options=$arrFurnished selected=$arrSearchCriteria.furnished}
												</select>
											</div>
										</div>
									</div>
								{/if}
							</div>

							<div class="row pb-5">
								{if isset($isGrid) && $isGrid !== 'true' }
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="d-flex px-0">
										<div class="w-100">
											<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Pool</h6>
											<select name="pool" class="custom-select rounded-0 py-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrYesNo selected=$arrSearchCriteria.pool}
											</select>
										</div>
										{*<div class="mx-3 align-self-center"></div>*}
									</div>
								</div>
								{/if}
								<div class="col-xl-6 col-lg-6 {if isset($isGrid) && $isGrid == 'true'} col-md-12 {else} col-md-6{/if} col-sm-12 col-12">
									<div class="w-100">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Pets Allowed</h6>
										<select name="petsallowed" class="custom-select py-0 rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											{html_options options=$arrYesNo selected=$arrSearchCriteria.petsallowed}
										</select>
									</div>
								</div>
							</div>
							{if isset($isGrid) && $isGrid !== 'true' }
								<div class="row pb-5">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 py-3 py-md-0 col-12">
										<div class="d-flex px-0">
											<div class="w-100">
												<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">HOA</h6>
												<select name="ishoa" class="custom-select rounded-0 py-0 border-0 shadow-none">
													<option value="" selected="">Any</option>
													{html_options options=$arrYesNo selected=$arrSearchCriteria.ishoa}
												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 form-group mb-0">
										<div class="w-100">
											<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">New Construction</h6>
											<select name="isnew" class="custom-select rounded-0 py-0 border-0 shadow-none">
												<option value="" selected="">Any</option>
												{html_options options=$arrTrueFalse selected=$arrSearchCriteria.isnew}
											</select>
										</div>
									</div>
								</div>
							{/if}

							<div class="row pb-5">
								<div class="col-xl-6 col-lg-6 {if isset($isGrid) && $isGrid == 'true'} col-md-12 {else} col-md-6{/if} py-3 py-md-0">
									<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Waterfront</h6>
									<div class="w-100">
										<select name="waterfront" class="custom-select py-0 rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											{html_options options=$arrYesNo selected=$arrSearchCriteria.waterfront}
										</select>
									</div>
								</div>
								{if isset($isGrid) && $isGrid !== 'true' }
									<div class="col-xl-6 col-lg-6 col-md-6 form-group mb-0">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Waterfront Description</h6>
										<select name="waterfrontdesc" class="custom-select rounded-0 border-0 shadow-none">
											<option value="" selected="">Any</option>
											{html_options options=$arrWaterfrontDesc selected=$arrSearchCriteria.waterfrontdesc}
										</select>
									</div>
								{/if}
							</div>
							{if isset($isGrid) && $isGrid !== 'true' }
								<div class="row pb-5">
									{*<div class="col-xl-12 col-lg-12 form-group mb-0">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Horse Amenities</h6>
										<input type="text" name="horse_amenities" value="{$arrSearchCriteria.horse_amenities}" placeholder="Horse Amenities" class="form-control rounded-0 border-0 py-0 shadow-none" id="horse_amenities" aria-describedby="kwordHelp">
									</div>*}
									<div class="{*{if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}col-xl-6 col-lg-6 col-md-6{*{else}col-xl-12 col-lg-12 col-md-12{/if}*} col-sm-12 col-12 mt-5-">
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
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 py-3 py-md-0 col-12 mt-5-">
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
							{/if}
							{*{if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
								<div class="row pb-5">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 py-3 py-md-0">
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
							{if isset($isGrid) && $isGrid !== 'true' }
								<div class="row pb-5">
									<div class="col-xl-12 col-lg-12 col-md-12 py-md-0 py-0 form-group mb-0">
										<h6 class="text-capitalize mb-3 font-weight-bold txt-heading heading_txt_color">Keywords</h6>
										<input type="text" name="kword" value="{$arrSearchCriteria.kword}" placeholder="Try remodel, renovated, turn key, fence, new roof" class="form-control rounded-0 border-0 py-0 shadow-none" id="kword" aria-describedby="kwordHelp">
									</div>
								</div>
							{/if}
						</div>
						<input name="addval" class="" id="AddressValuembl" value="{$arrSearchCriteria.addval|default:''}" data-type="hidden" type="hidden">
						<input name="addtype" class="" id="AddressTypembl" value="{$arrSearchCriteria.addtype|default:''}" data-type="hidden" type="hidden">
						{* <input type="hidden" id="so" name="so" value="{$arrSearchCriteria.so|default:'price'}">
						 <input type="hidden" id="sd" name="sd" value="{$arrSearchCriteria.sd|default:'asc'}">
						 <input type="hidden" id="spage" name="spage" value="{$arrSearchCriteria.spage|default:1}">*}
						{*<input type="hidden" id="MapZoomLevel" name="mz" value="{$arrSearchCriteria.mz|default:13}">
						<input type="hidden" id="MapCenterLat" name="clat" value="{$arrSearchCriteria.clat|default:25.761681}">
						<input type="hidden" id="MapCenterLng" name="clng" value="{$arrSearchCriteria.clng|default:-80.191788}">
						<input type="hidden" id="map" name="map" value="{$arrSearchCriteria.map|default:''}">*}
					</div>
				</form>
			</div>
			<div class="modal-footer justify-content-center respo-clear-filters p-0">
				<button type="button" class="btn w-50 text-white- te-btn rounded-0 m-0 py-2 shadow-none te-small-device-search btn-mbl-search lpt-btn lpt-btn-txt">Search</button>
				<button type="button" class="btn w-50 bg-white text-dark border-dark btn-search-reset rounded-0 m-0 py-2 shadow-none">Reset</button>
			</div>

		</div>
	</div>
</div>