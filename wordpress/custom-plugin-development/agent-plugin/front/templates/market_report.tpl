<section id="te-market-report-container" class="py-5 px-xl-5 te-font-family">
	<div class="container-fluid con-mar- te-market-report-container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1-">
				{if is_array($statistic) && count($statistic) > 0}
					<div class="row py-2">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-1 te-market-report-title">
							<h4 class="te-market-title txt-heading heading_txt_color">Market Insights for {$title}</h4>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-closed-sales-as text-left">
							<p class="text-dark mb-0 te-font-size-14">As of {$TodayDate}</p>
						</div>
					</div>
					<div class="row pt-3 market-statistics text-dark">
						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1 pr-xl-3">
							<h3 class="title-font text-left te-market-title- text-border-bottom pt-4 pb-3">For Sale</h3>
							<ul class="p-0 pt-3">
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Active For Sale</span><span class="font-weight-bold">{$statistic.statistic_total_active_listing}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price</span><span class="font-weight-bold">{$currency}{$statistic.statistic_avg_active_price|number_format}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price / Sqft</span><span class="font-weight-bold">{$currency}{$statistic.statistic_avg_active_price_sqft|number_format}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold">{if $statistic.statistic_avg_active_dom}{$statistic.statistic_avg_active_dom}{else}-{/if}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $statistic.statistic_largest_price_diff >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_largest_price_reduction|number_format} {*({$statistic.statistic_largest_price_diff|round:2}%)*}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Increase</span><span class="font-weight-bold {if $statistic.statistic_largest_price_diff_increase >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_largest_price_increase|number_format} {*({$statistic.statistic_largest_price_diff|round:2}%)*}</span></li>

								{*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $maxReducePercentage >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$max_price_diff)|number_format} ({$maxReducePercentage|round:2}%)</span></li>*}
							</ul>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1 px-xl-3">
							<h3 class="title-font text-left te-market-title- text-border-bottom pt-4 pb-3">Pending Sales</h3>
							<ul class="p-0 pt-3">
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Pending For Sale</span><span class="font-weight-bold">{$statistic.statistic_total_pending_listing}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price</span><span class="font-weight-bold">{$currency}{$statistic.statistic_avg_pending_price|number_format}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price / Sqft</span><span class="font-weight-bold">{$currency}{$statistic.statistic_avg_pending_price_sqft|number_format}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold">{if $statistic.statistic_avg_pending_dom > 0}{$statistic.statistic_avg_pending_dom}{else}-{/if}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $statistic.statistic_largest_pending_price_diff >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_pending_largest_price_reduction|number_format} {*({$statistic.statistic_largest_pending_price_diff|round:2}%)*}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Increase</span><span class="font-weight-bold {if $statistic.statistic_largest_pending_price_diff_increase >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_pending_largest_price_increase|number_format} {*({$statistic.statistic_largest_pending_price_diff|round:2}%)*}</span></li>

								{*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $maxPendingReducePercentage >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$max_pending_price_diff)|number_format} ({$maxPendingReducePercentage|round:2}%)</span></li>*}
							</ul>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1 pl-xl-3">
							<h3 class="title-font text-left te-market-title- text-border-bottom pt-4 pb-3">Closed Sales</h3>
							<ul class="p-0 pt-3">
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Sold (Last 180 Days)</span><span class="font-weight-bold">{$statistic.statistic_sixmon_tot_sold_listing}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price</span><span class="font-weight-bold">{$currency}{$statistic.statistic_six_month_avg_sold_price|number_format}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price / Sqft</span><span class="font-weight-bold">{$currency}{$statistic.statistic_six_month_avg_sold_price_sqft|number_format}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold">{if $statistic.statistic_six_month_avg_sold_dom > 0}{$statistic.statistic_six_month_avg_sold_dom}{else}-{/if}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $statistic.statistic_largest_sold_price_diff >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_six_month_sold_largest_price_reduction|number_format} {*({$statistic.statistic_largest_sold_price_diff|round:2}%)*}</span></li>
								<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Increase</span><span class="font-weight-bold {if $statistic.statistic_largest_sold_price_diff_increase >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_six_month_sold_largest_price_increase|number_format} {*({$statistic.statistic_largest_sold_price_diff|round:2}%)*}</span></li>

								{*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $maxSoldReducePercentage >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$max_sold_price_diff)|number_format} ({$maxSoldReducePercentage|round:2}%)</span></li>*}
							</ul>
						</div>
					</div>
					<div id="list-view" class="row pt-5">

						{if is_array($recent_sales) && count($recent_sales) > 0}
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<h4 class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Recent Sales</h4>
								<div class="table-responsive pt-4">
									<table class="table te-table-striped- table-hover mb-0">
										<thead>
											<tr class="text-center te-font-size-14">
												<th nowrap scope="col" class="border">Address</th>
												<th nowrap scope="col" class="border">Closed Price</th>
												<th nowrap scope="col" class="border">List Price</th>
												<th nowrap scope="col" class="border">Price Change</th>
												<th nowrap scope="col" class="border">Sq Ft</th>
												<th nowrap scope="col" class="border">{$currency}/Sq Ft</th>
												<th nowrap scope="col" class="border">Beds/Baths</th>
												<th nowrap scope="col" class="border">Closing Date</th>
											</tr>
										</thead>

										<tbody>

											{foreach name=recentSale from=$recent_sales item=Record}

												<tr class="text-center">
													<td nowrap>
														{if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
															<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading pb-0">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
															<small>{$Record.Subdivision}</small>
														{else}
															<a href="#" class="text-dark"><h6 class="my-0 txt-heading pb-0">Address Not Available</h6></a>
														{/if}
													</td>
													<td nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
													<td nowrap>{$currency}{$Record.ListPrice|number_format}</td>
													{$pricedef = {math equation="x - y" x=$Record.ListPrice y=$Record.Sold_Price}}
													{$difference = {math equation="(z)*100*(a)/p" z=$pricedef p=$Record.ListPrice a=-1}}

													<td nowrap class="{if $difference >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$pricedef)|number_format} ({$difference|round:2}%)</td>
													<td nowrap>{$Record.SQFT|number_format}</td>

													{if $Record.SQFT|number_format !=0}

														{$pripsqft = {math equation="x / y" x=$Record.Sold_Price y=$Record.SQFT}}
														<td nowrap>{if $Record.SQFT > 0}{$currency}{$pripsqft|number_format}
															{else}0{/if }</td>
													{else}
														<td nowrap>0</td>

													{/if}
													<td nowrap>{$Record.Beds|number_format} / {$Record.BathsFull|number_format} / {$Record.BathsHalf|number_format}</td>
													<td nowrap>{$Record.Sold_Date}</td>
												</tr>
											{/foreach}
										</tbody>
									</table>
								</div>
							</div>
						{/if}
						{if is_array($rsPending['rs']) && count($rsPending['rs']) > 0}
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2 pt-5">
								<h4 class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Pending Sales</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive pt-4">
									<table class="table te-table-striped- table-hover mb-0">
										<thead>
											<tr class="text-center te-font-size-14">
												<th nowrap scope="col" class="border">Address</th>
												<th nowrap scope="col" class="border">List Price</th>
												<th nowrap scope="col" class="border">Price Change</th>
												<th nowrap scope="col" class="border">Sq Ft</th>
												<th nowrap scope="col" class="border">{$currency}/Sq Ft</th>
												<th nowrap scope="col" class="border">Beds/Baths</th>
												<th nowrap scope="col" class="border">Days Listed</th>
											</tr>
										</thead>
										<tbody class="te-tbody">
											{foreach name=pendinglist from=$rsPending['rs'] item=Record}
												{$arrPendingPrice = array_column($Record,'Price_Diff')}
												<tr class="text-center">
													<td nowrap>
														{if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
															<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading pb-0">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
															<small>{$Record.Subdivision}</small>
														{else}
															<a href="#" class="text-dark"><h6 class="my-0 txt-heading pb-0">Address Not Available</h6></a>
														{/if}
													</td>
													<td nowrap>{$currency}{$Record.ListPrice|number_format}</td>
													{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
													<td nowrap class="{if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
													<td nowrap>{$Record.SQFT|number_format}</td>
													{if $Record.SQFT|number_format !=0}

														{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
														<td nowrap>{if $Record.SQFT > 0}{$currency}{$pripsqft|number_format}{else}0{/if}</td>
														{else}
														<td nowrap>0</td>

													{/if}

													<td nowrap>{$Record.Beds|number_format} / {$Record.BathsFull|number_format} / {$Record.BathsHalf|number_format}</td>
													<td nowrap>{$Record.DOM}</td>
												</tr>
											{/foreach}
										</tbody>
									</table>
								</div>
							</div>
						{/if}
						{if is_array($price_red['rs']) && count($price_red['rs']) > 0}
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 pt-5">
								<h4 class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Largest Price Reductions</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive pt-4">
									<table class="table table-hover mb-0">
										<thead>
											<tr class="text-center te-font-size-14">
												<th nowrap scope="col" class="border">Address</th>
												<th nowrap scope="col" class="border">New Price</th>
												<th nowrap scope="col" class="border">List Price</th>
												<th nowrap scope="col" class="border">Price Change</th>
												<th nowrap scope="col" class="border">Sq Ft</th>
												<th nowrap scope="col" class="border">{$currency}/Sq Ft</th>
												<th nowrap scope="col" class="border">Beds/Baths</th>
												<th nowrap scope="col" class="border">Days Listed</th>
											</tr>
										</thead>
										<tbody class="te-tbody">
											{foreach name=priceRed from=$price_red['rs'] item=Record}
												{$arrLargestPrice = array_column($Record,'Price_Diff')}
												<tr class="text-center">
													<td nowrap>
														{if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
															<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading pb-0">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
															<small>{$Record.Subdivision}</small>
														{else}
															<a href="#" class="text-dark"><h6 class="my-0 txt-heading pb-0">Address Not Available</h6></a>
														{/if}
													</td>
													<td nowrap>{$currency}{$Record.OriginalListPrice|number_format}</td>
													<td nowrap>{$currency}{$Record.ListPrice|number_format}</td>
													{*{$pricereduction = {math equation="x / y" x=$Record.Price_Diff y=$Record.OriginalListPrice}}
													{$priceper = {math equation="x * y" x=$pricereduction y=100}}*}
													{*										<td nowrap class="text-danger">{$priceper|number_format}% ({$currency}{str_replace('-','',$Record.Price_Diff)|number_format})</td>*}
													{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
													<td nowrap class="{if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
													<td nowrap>{$Record.SQFT|number_format}</td>
													{if $Record.SQFT|number_format != 0}

														{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
														<td nowrap>{if $Record.SQFT > 0}{$currency}{$pripsqft|number_format}{else}0{/if}</td>
														{else}
														<td nowrap>0</td>

													{/if}

													<td nowrap>{$Record.Beds|number_format} / {$Record.BathsFull|number_format} / {$Record.BathsHalf|number_format}</td>
													<td nowrap>{$Record.DOM}</td>
												</tr>
											{/foreach}
										</tbody>
									</table>
								</div>
							</div>
						{/if}
					</div>
				{else}
					No Statistics Available for {$title}
				{/if}
			</div>
		</div>
	</div>
</section>