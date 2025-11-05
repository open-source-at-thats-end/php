<section class="py-5">
	<div class="container con-mar te-market-report-container px-md-4 px-2">
		<div class="row">
			<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1">
				<div class="row te-search-filter-row- justify-content-between pre-filter-line pb-2 border-bottom pb-md-2 p-0 m-0 btn-align btn-gray py-2 pl-xl-3 ">
					<div class=" col-xl-9 col-lg-9 col-md-9 col-12 col-sm-9 px-md-2 px-0 text-lg-left text-xl-left text-md-left align-self-center">
						<a href="{$Site_Url}{str_replace(' ', '-', $pre_search['psearch_title'])}" class="btn btn-sm font-size-sm-12 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0 {if !isset($Action) ||  (isset($Action) && $Action == '')} te-btn lpt-btn lpt-btn-txt{else} tab-btn{/if} "><i class="fa fa-th pr-md-1 pr-0"></i> FOR SALE</a>
						<a href="{$Site_Url}{Constants::TYPE_SALES}/{str_replace(' ', '-', $pre_search['psearch_title'])}" class="btn btn-sm font-size-sm-12 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0 {if isset($Action) && $Action == Constants::TYPE_SALES} lpt-btn lpt-btn-txt te-btn {else} tab-btn {/if}"><i class="fa fa-bars pr-md-1 pr-0"></i> FOR SALE</a>
						<a href="{$Site_Url}{Constants::TYPE_RENTALS}/{str_replace(' ', '-', $pre_search['psearch_title'])}" class="btn btn-sm font-size-sm-12 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0 {if isset($Action) && $Action == Constants::TYPE_RENTALS} lpt-btn lpt-btn-txt te-btn {else} tab-btn {/if}"><i class="fa fa-bars pr-md-1 pr-0"></i> FOR RENT</a>
						<a href="{$Site_Url}{Constants::TYPE_SOLD}/{str_replace(' ', '-', $pre_search['psearch_title'])}" class="btn btn-sm font-size-sm-12 te-font-size-13  shadow-none p-lg-2 p-xl-2 px-1 te-pre-saveser rounded-0 {if isset($Action) && $Action == Constants::TYPE_SOLD} lpt-btn lpt-btn-txt te-btn {else} tab-btn {/if}"><i class="fa fa-bars pr-md-1 pr-0"></i> SOLD </a>
						{*<div class="dropdown d-inline-block mx-1- mx-lg-0 d-block d-sm-none">
							<button class="btn btn-sm dropdown-toggle font-size-sm-12 te-font-size-13 te-btn text-white- shadow-none p-lg-2 p-xl-2 px-1 te-share-propery-detail rounded-0 w-100 lpt-btn lpt-btn-txt" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-external-link-alt pr-2-"></i> SHARE
							</button>
							<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
								<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
								<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
								<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
								<a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($pre_search['psearch_title']) && $pre_search['psearch_title'] != ''}{$pre_search['psearch_title']}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>
							</div>
						</div>*}
					</div>
					<div class="col-12 col-xl-3 col-lg-3 col-md-3 col-sm-3 px-0 px-lg-0 pt-2 pt-sm-0 pt-2 text-sm-right px-xl-2 {*d-none d-sm-block*}">
						<div class="dropdown d-inline-block mx-1- mx-lg-0">
							<button class="btn btn-sm dropdown-toggle font-size-sm-12 te-font-size-13 te-btn text-white- shadow-none p-lg-2 p-xl-2 px-1 te-share-propery-detail rounded-0 w-100 lpt-btn lpt-btn-txt" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-external-link-alt pr-2-"></i> SHARE
							</button>
							<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
								<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
								<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
								<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
								<a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($pre_search['psearch_title']) && $pre_search['psearch_title'] != ''}{$pre_search['psearch_title']}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>
							</div>
						</div>
					</div>
				</div>
				{if isset($arrRecord) && count($arrRecord) > 0}
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
							<h4 class="title-font text-left te-market-title txt-heading heading_txt_color">{$total_record|number_format} {if isset($Action) && $Action != Constants::TYPE_SOLD}Total{/if} Units {if isset($Action) && $Action == Constants::TYPE_SALES}For Sale{elseif isset($Action) && $Action == Constants::TYPE_RENTALS}For Rent{else}Sold{/if} - {$pre_search['psearch_title']|capitalize}</h4>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
							<div class="table-responsive">
								<table class="table te-table-striped table-hover table-borderless mb-0">
									<thead class="te-bg-table">
										<tr>
											<th nowrap scope="col">Bedrooms</th>
											<th nowrap scope="col"># of Units</th>
											<th nowrap scope="col">Avg. $/SqFt</th>
											<th nowrap scope="col">Avg. Listing Price </th>
											<th nowrap scope="col">Avg. Days on Market</th>
											<th nowrap scope="col">Min Price</th>
										</tr>
									</thead>
									<tbody>
									{foreach name=arrRecord from=$arrRecord item=Record key=key}
										{$arrPrice = array_column($Record,'ListPrice')}
										{$arrDOM = array_column($Record,'DayOnMarket')}
										{$arrSQFT = array_column($Record,'SQFT')}
										<tr>
											<td nowrap>

												{$key} Bedroom Units
											</td>
											<td nowrap>{count($Record)}</td>
											<td nowrap class="">
												{$pripsqft = {math equation="x / y" x=array_sum($arrPrice)/count($arrPrice) y=array_sum($arrSQFT)/count($arrSQFT)}}
												{if $pripsqft > 0}{$currency}{$pripsqft|number_format}{else}0{/if}
											</td>
											<td nowrap>
												{$a = array_filter($arrPrice)}
												{$average = array_sum($a)/count($a)}
												{$currency}{$average|number_format}</td>
											<td nowrap>
												{$dom = array_filter($arrDOM)}
												{$avdom = array_sum($dom)/count($dom)}
												{$avdom|number_format:0}</td>
											</td>
											<td nowrap>

												{$min_Price = min($arrPrice)}
												From {$currency}{$min_Price|number_format}
											</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row ">
						{foreach name=arrRecord from=$arrRecord item=Record key=key}
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
								<h4 class="title-font text-left te-market-title txt-heading text-muted ">{$key} Bedroom In {$pre_search['psearch_title']|capitalize} - {if isset($Action) && $Action == Constants::TYPE_SALES}For Sale{elseif isset($Action) && $Action == Constants::TYPE_RENTALS}For Rent{else}Units Sold{/if} - ({count($Record)})</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive">
									<table class="table te-table-striped table-hover table-borderless mb-0">
										<thead class="te-bg-table">
										{if isset($Action) && $Action == Constants::TYPE_SOLD}
											<tr>
												<th nowrap scope="col">List Price</th>
												<th nowrap scope="col">Sale Price</th>
												<th nowrap scope="col">Closing Date</th>
												<th nowrap scope="col">Unit # </th>
												<th nowrap scope="col">MLS # </th>
												<th nowrap scope="col">Bed / Bath</th>
												<th nowrap scope="col">Living Area</th>
												<th nowrap scope="col">$/SqFt</th>
												<th nowrap scope="col">Days Listed</th>
											</tr>
										{else}
											<tr>
												<th nowrap scope="col">Details</th>
												<th nowrap scope="col">List Price</th>
												<th nowrap scope="col">Unit #</th>
												<th nowrap scope="col">MLS # </th>
												<th nowrap scope="col">Bed / Bath</th>
												<th nowrap scope="col">Living Area</th>
												<th nowrap scope="col">$/SqFt</th>
												<th nowrap scope="col">Days Listed</th>
											</tr>
										{/if}
										</thead>
										<tbody class="border-bottom">
										{if isset($Action) && $Action == Constants::TYPE_SOLD}
											{foreach name=SubRecord from=$Record item=subRecord key=subkey}
												<tr>
													<td nowrap>{$currency}{$subRecord.ListPrice|number_format}</td>
													<td nowrap>{$currency}{$subRecord.Sold_Price|number_format}</td>
													<td nowrap class="">{$subRecord.Sold_Date}</td>
													<td nowrap class="">{$subRecord.UnitNo}</td>
													<td nowrap>{$subRecord.MLS_NUM}</td>
													<td nowrap>{$subRecord.Beds|number_format} / {$subRecord.BathsFull|number_format}</td>
													<td nowrap>{if $subRecord.SQFT > 0}{$subRecord.SQFT|number_format}{else}0{/if}</td>
													<td nowrap>
														{$pripsqft = {math equation="x / y" x=$subRecord.ListPrice y=$subRecord.SQFT}}
														{if $subRecord.SQFT > 0}{$currency}{$pripsqft|number_format}{else}0{/if}
													</td>
													<td nowrap>{$subRecord.DayOnMarket}</td>
												</tr>
											{/foreach}
										{else}
											{foreach name=SubRecord from=$Record item=subRecord key=subkey}
												<tr>
													<td nowrap>

														<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $subRecord)}" class="text-dark" target="_blank"><h6 class="my-0 txt-heading text-primary"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</h6></a>
													</td>
													<td nowrap>{$currency}{$subRecord.ListPrice|number_format}</td>
													<td nowrap class="">{$subRecord.UnitNo}</td>
													<td nowrap>{$subRecord.MLS_NUM}</td>
													<td nowrap>{$subRecord.Beds|number_format} / {$subRecord.BathsFull|number_format}</td>
													<td nowrap>{if $subRecord.SQFT > 0}{$subRecord.SQFT|number_format}{else}0{/if}</td>
													<td nowrap>
														{$pripsqft = {math equation="x / y" x=$subRecord.ListPrice y=$subRecord.SQFT}}
														{if $subRecord.SQFT > 0}{$currency}{$pripsqft|number_format}{else}0{/if}
													</td>
													<td nowrap>{$subRecord.DayOnMarket}</td>
												</tr>
											{/foreach}
										{/if}
										</tbody>
									</table>
								</div>
							</div>
						{/foreach}
					</div>
					{if isset($Action) && $Action!= Constants::TYPE_SOLD}
						<div class="row pt-4">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 pt-md-0 pt-4">
								<h4 class="title-font text-left te-market-title txt-heading heading_txt_color border-bottom pb-3">New Listings</h4>
								{foreach name=new_prop from=$new_prop item=Record key=key}
									<p class="pt-2">
										<a class="text-primary" href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}"> Unit {$Record.UnitNo} {if isset($Action) && $Action == Constants::TYPE_SALES}For Sale{else}For Rent{/if} at {$currency}{$Record.ListPrice|number_format} listed {$Record.DayOnMarket} days ago.</a>
									</p>
								{/foreach}
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 -pr-0 pt-md-0 pt-3">
								<h4 class="title-font text-left te-market-title txt-heading heading_txt_color border-bottom pb-3">Recently Reduced</h4>
								{foreach name=recent_reduce from=$recent_reduce item=Record key=key}
									{if $Record.Price_Diff < 0}
										<p class="pt-2">
											<a class="text-dark" href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}"> Unit {$Record.UnitNo} {if isset($Action) && $Action == Constants::TYPE_SALES}For Sale{else}For Rent{/if} at {$currency}{$Record.ListPrice|number_format} Reduced by ({$Record.Price_Diff|round:2}%) </a>
										</p>
									{/if}
								{/foreach}
							</div>
						</div>
					{/if}
				{else}

				<div class="col-12 no-data-msg text-center text-danger pt-3">';
						0 Results
				</div>
				{/if}
			</div>
		</div>
	</div>
</section>