<section class="py-5">
	<div class="container con-mar te-market-report-container">
		<div class="row">
			<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1">
				{if is_array($statistic) && count($statistic) > 0}
					<div class="row py-2">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-1 te-market-report-title">
							<h4 class="te-market-title txt-heading heading_txt_color">Market Insights for {$title}</h4>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-closed-sales-as text-left">
{*							<p class="text-dark mb-0">Closed Sales as of {$smarty.now|date_format:"%m-%d-%Y"}</p>*}
							<p class="text-dark mb-0">Closed Sales as of {$TodayDate}</p>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-1">
							<div class="btn-group btn-group-sm te-closed-sales-report py-4 d-block text-center" role="group" aria-label="Basic example">
								<button type="button" class="btn px-3 pr-md-3 pr-lg-5 text-dark shadow-none te-border-right mx-auto">
									{*<p class="mb-0 te-market-stats">{$currency}{$statistic.statistic_median_sold_price|number_format}</p>*}
									<p class="mb-0 te-market-stats">{$currency}{$statistic.statistic_avg_sold_price|number_format}</p>
									{*<p class="mb-0 te-market-value te-font-size-sm-12">Median Closing Price</p>*}
									<p class="mb-0 te-market-value te-font-size-sm-12">Average Closing Price</p>
								</button>
								<button type="button" class="btn px-3 px-md-3 px-lg-5 text-dark shadow-none te-border-right mx-auto">
									{*<p class=" mb-0 te-market-stats">{$currency}{$statistic.statistic_median_sold_price_sqft|number_format}</p>*}
									<p class=" mb-0 te-market-stats">{$currency}{$statistic.statistic_avg_sold_price_sqft|number_format}</p>
									<p class="mb-0 te-font-size-sm-12">Price Per Square Foot</p>
								</button>
								<button type="button" class="btn px-3 px-md-3 px-lg-5 text-dark shadow-none mx-auto">
									<p class="mb-0 te-market-stats">{$statistic.statistic_sixmon_tot_sold_listing}</p>
									<p class="mb-0 te-font-size-sm-12">Closed In Last 180 Days</p>
								</button>
							</div>
						</div>
						{if is_array($recent_sales) && count($recent_sales) > 0}
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
								<h4 class="title-font text-left te-market-title txt-heading heading_txt_color">Recent Sales</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive">
									<table class="table te-table-striped table-hover table-borderless mb-0">
										<thead class="te-bg-table">
										<tr>
											<th nowrap scope="col">Address</th>
											<th nowrap scope="col">Closed Price</th>
											<th nowrap scope="col">Listing Price</th>
											<th nowrap scope="col">Sq Ft</th>
											<th nowrap scope="col">Cost / Sq Ft</th>
											<th nowrap scope="col">Bd / Ba</th>
											<th nowrap scope="col">Closing Date</th>
										</tr>
										</thead>
										<tbody>
										{foreach name=recentSale from=$recent_sales item=Record}
										<tr>
											<td nowrap>
												{*<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
												<small>{$Record.Subdivision}</small>*}
												{if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
													<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
													<small>{$Record.Subdivision}</small>
												{else}
													<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">Address Not Available</h6></a>
												{/if}
											</td>
											<td nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
											<td nowrap class="te-text-dark-light">{$currency}{$Record.ListPrice|number_format}</td>
											<td nowrap>{$Record.SQFT|number_format}</td>
											{$pripsqft = {math equation="x / y" x=$Record.Sold_Price y=$Record.SQFT}}
											<td nowrap>{if $Record.SQFT > 0}{$currency}{$pripsqft|number_format}
									    {else}0{/if }</td>
											<td nowrap>{$Record.Beds|number_format} / {$Record.BathsFull|number_format}</td>
											<td nowrap>{$Record.Sold_Date}</td>
										</tr>
										{/foreach}
										</tbody>
									</table>
								</div>
							</div>
						{/if}
					</div>
					<div class="row pt-5 mt-3">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 te-active-listing-sale-overview-title">
							<h4 class="text-dark font-weight-bold te-market-title txt-heading heading_txt_color">Active Listings For Sale</h4>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
							<div class="btn-group btn-group-sm te-closed-sales-report py-4 d-block text-center" role="group" aria-label="Basic example">
								<button type="button" class="btn px-3 pr-md-3 pr-lg-5 text-dark shadow-none te-border-right mx-auto">
									{*<p class="mb-0 te-market-stats">{$currency}{$statistic.statistic_median_active_price|number_format}</p>*}
									<p class="mb-0 te-market-stats">{$currency}{$statistic.statistic_avg_active_price|number_format}</p>
									{*<p class="mb-0">Median Listing Price</p>*}
									<p class="mb-0">Average Listing Price</p>
								</button>
								<button type="button" class="btn px-3 px-md-3 px-lg-5 text-dark shadow-none te-border-right mx-auto">
									{*<p class=" mb-0 te-market-stats">{$currency}{$statistic.statistic_median_active_price_sqft|number_format}</p>*}
									<p class=" mb-0 te-market-stats">{$currency}{$statistic.statistic_avg_active_price_sqft|number_format}</p>
									<p class="mb-0">Price Per Square Foot</p>
								</button>
								<button type="button" class="btn px-3 px-md-3 px-lg-5 text-dark shadow-none mx-auto">
									<p class="mb-0 te-market-stats">{$statistic.statistic_total_active_listing}</p>
									<p class="mb-0">Active For Sale</p>
								</button>
							</div>
						</div>
						{if is_array($price_red['rs']) && count($price_red['rs']) > 0}
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
							<h4 class="title-font text-left te-market-title txt-heading heading_txt_color">Largest Price Reductions</h4>
						</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
							<div class="table-responsive">
								<table class="table te-table-striped table-hover table-borderless mb-0">
									<thead class="te-bg-table">
									<tr>
										<th nowrap scope="col">Address</th>
										<th nowrap scope="col">Sale Price</th>
										<th nowrap scope="col">Price Changes</th>
										<th nowrap scope="col">Sq Ft</th>
										<th nowrap scope="col">Bd / Ba</th>

									</tr>
									</thead>
									<tbody class="te-tbody">
									{foreach name=priceRed from=$price_red['rs'] item=Record}
									<tr>
										<td nowrap>
											{*<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
											<small>{$Record.Subdivision}</small>*}
											{if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
												<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
												<small>{$Record.Subdivision}</small>
											{else}
												<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">Address Not Available</h6></a>
											{/if}
										</td>
										<td nowrap>{$currency}{$Record.ListPrice|number_format}</td>
										{*{$pricereduction = {math equation="x / y" x=$Record.Price_Diff y=$Record.OriginalListPrice}}
										{$priceper = {math equation="x * y" x=$pricereduction y=100}}*}
{*										<td nowrap class="text-danger">{$priceper|number_format}% ({$currency}{str_replace('-','',$Record.Price_Diff)|number_format})</td>*}
										{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
										<td nowrap class="text-danger">{$Record.Price_Diff|round:2}% {if $Record.Price_Diff > 0}({$currency}{str_replace('-','',$pricedef)|number_format}){/if}</td>
										{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
										<td nowrap>{if $Record.SQFT > 0}{$currency}{$pripsqft|number_format}{else}0{/if}</td>
										<td nowrap>{$Record.Beds|number_format} / {$Record.BathsFull|number_format}</td>
									</tr>
									{/foreach}

									</tbody>
								</table>
							</div>
						</div>
						{/if}
						<div class="row pt-5 mt-3">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 te-active-listing-sale-overview-title">
								<h4 class="text-dark font-weight-bold te-market-title txt-heading heading_txt_color">Under Contract Listings For Sale</h4>
							</div>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
							<div class="btn-group btn-group-sm te-closed-sales-report py-4 d-block text-center" role="group" aria-label="Basic example">
								<button type="button" class="btn px-3 pr-md-3 pr-lg-5 text-dark shadow-none te-border-right mx-auto">
									{*<p class="mb-0 te-market-stats">{$currency}{$statistic.statistic_median_pending_price|number_format}</p>*}
									<p class="mb-0 te-market-stats">{$currency}{$statistic.statistic_avg_pending_price|number_format}</p>
									{*<p class="mb-0">Median Listing Price</p>*}
									<p class="mb-0">Average Listing Price</p>
								</button>
								<button type="button" class="btn px-3 px-md-3 px-lg-5 text-dark shadow-none te-border-right mx-auto">
									{*<p class=" mb-0 te-market-stats">{$currency}{$statistic.statistic_median_pending_price_sqft|number_format}</p>*}
									<p class=" mb-0 te-market-stats">{$currency}{$statistic.statistic_avg_pending_price_sqft|number_format}</p>
									{*<p class="mb-0">Price Per Square Foot</p>*}
									<p class="mb-0">Price Per Square Foot</p>
								</button>
								<button type="button" class="btn px-3 px-md-3 px-lg-5 text-dark shadow-none mx-auto">
									<p class="mb-0 te-market-stats">{$statistic.statistic_total_pending_listing}</p>
									<p class="mb-0">Under Contract For Sale</p>
								</button>
							</div>
						</div>
						{if is_array($rsPending['rs']) && count($rsPending['rs']) > 0}
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
								<h4 class="title-font text-left te-market-title txt-heading heading_txt_color">Under Contract Listings</h4>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
								<div class="table-responsive">
									<table class="table te-table-striped table-hover table-borderless mb-0">
										<thead class="te-bg-table">
										<tr>
											<th nowrap scope="col">Address</th>
											<th nowrap scope="col">Sale Price</th>
											<th nowrap scope="col">Price Changes</th>
											<th nowrap scope="col">Sq Ft</th>
											<th nowrap scope="col">Bd / Ba</th>
										</tr>
										</thead>
										<tbody class="te-tbody">
											{foreach name=pendinglist from=$rsPending['rs'] item=Record}
												<tr>
													<td nowrap>
														{*<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
														<small>{$Record.Subdivision}</small>*}
														{if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
															<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
															<small>{$Record.Subdivision}</small>
														{else}
															<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 txt-heading">Address Not Available</h6></a>
														{/if}
													</td>
													<td nowrap>{$currency}{$Record.ListPrice|number_format}</td>

													{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
													<td nowrap class="text-danger">{$Record.Price_Diff|round:2}% {if $Record.Price_Diff > 0}({$currency}{str_replace('-','',$pricedef)|number_format}){/if}</td>
													{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
													<td nowrap>{if $Record.SQFT > 0}{$currency}{$pripsqft|number_format}{else}0{/if}</td>
													<td nowrap>{$Record.Beds|number_format} / {$Record.BathsFull|number_format}</td>
												</tr>
											{/foreach}
										</tbody>
									</table>
								</div>
							</div>
						{/if}

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-5 mt-5 px-3">
							<h4 class="mb-4 te-market-title txt-heading heading_txt_color">More information about {$title} Market Insights</h4>
{*							<p class="font-weight-bold text-dark mb-0">{$currency}{$statistic.statistic_median_active_price|number_format} or {$currency}{$statistic.statistic_median_active_price_sqft|number_format} per square foot. In the last 180 days, approximately {$statistic.statistic_sixmon_tot_sold_listing} {$title}, Florida with a median closing price of {$currency}{$statistic.statistic_median_sold_price|number_format} or {$currency}{$statistic.statistic_median_sold_price_sqft|number_format} per square foot. For more information on {$title}, contact a {$title} real estate agent or {$title} Realtor®.</p>*}
							<p class="font-weight-bold- text-dark mb-0 seo-text">{$SEODescription}</p>
							{*<p class="text-micro">
								No guarantee, warranty or representation of any kind is made regarding the completeness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.								<br/>
								<br>
								The data provided by Miami Association of REALTORS® MLS comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are © 2020 Miami Association of REALTORS®. All Rights Reserved. The information provided is for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
								<br>
								<br>
								Miami Association of Realtors MLS data last updated on {$price_red.MLS_last_update_date|date_format:"M d, Y"}.
							</p>*}
							{*<div class="pt-4">
								{if isset($sys_name) && $sys_name == 'sefmiami'}
									<p class="text-micro" align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Op-portunity Act.</p>
									<p class="text-micro" align="justify">The data provided by Miami Association of REALTORS® MLS comes from a copy-righted compilation of listings. The compilation of listings and each individual listing are ©{'Y'|date} Miami Association of REALTORS®. All Rights Reserved. The infor-mation provided is for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be in-dependently verified.</p>
									<p class="text-micro" align="justify">Miami Association of Realtors MLS data last updated on {$MLS_last_update_date}.</p>
								{elseif isset($sys_name) && $sys_name == 'ftl'}
									<p class="text-micro pt-4" align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Op-portunity Act.</p>
									<img class = "disclaimer_img pt-4" src="{$Templates_Image}both.png"> <p class="text-micro pt-4" align="justify">The data provided by Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each indi-vidual listing are ©{'Y'|date} Palm Beach Board of Realtors Multiple Listing Service. All Rights Reserved. The information provided is for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify pro-spective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>
									<p class="text-micro" align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This infor-mation is not verified for authenticity or accuracy and is not guaranteed. Copyright ©{'Y'|date} BeachesMLS, Inc.</p>
									<p class="text-micro" align="justify">Listing information last updated on {$MLS_last_update_date}.</p>
								{elseif isset($sys_name) && $sys_name == 'ACTRIS'}
									<p class="text-micro" align="justify">The information being provided is for consumers' personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing.</p>
									<p class="text-micro" align="justify">Based on information from the Austin Board of REALTORS® (alternatively, from ACTRIS) from {$MLS_last_update_date}. Neither the Board nor ACTRIS guarantees or is in any way responsible for its accuracy. The Austin Board of REALTORS®, ACTRIS and their affiliates provide the MLS and all content therein "AS IS" and without any warranty, express or implied. Data maintained by the Board or ACTRIS may not reflect all real estate activity in the market.</p>
									<p class="text-micro" align="justify">All information provided is deemed reliable but is not guaranteed and should be independently verified.</p>
								{else}
									<p class="pb-0 text-micro pt-4" align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Op-portunity Act.</p>
									<img class = "disclaimer_img pt-4" src="{$Templates_Image}both.png"> <p class="text-micro pt-4" align="justify">The data provided by Miami Association of REALTORS® MLS and Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©{'Y'|date} Miami Association of REALTORS® MLS  and Palm Beach Board of Realtors Multiple List-ing Service. All Rights Reserved. The information provided is for consumers’ per-sonal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed relia-ble but is not guaranteed accurate, and should be independently verified.</p><br />
									<p class="text-micro" align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This infor-mation is not verified for authenticity or accuracy and is not guaranteed. Copyright ©{'Y'|date} BeachesMLS, Inc.</p>
									<p class="text-micro" align="justify">Listing information last updated on {$MLS_last_update_date}.</p>
								{/if}
							</div>*}
						</div>

					</div>
				{else}
					No Statistics Available for {$title}
				{/if}
			</div>
		</div>
	</div>
</section>