<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                          <i class="mdi mdi-home"></i>
                        </span> {*Listings For: <i class="mdi mdi-account-outline text-primary" style="font-size: 20px;"></i>adrian antonio*}
                    </h3>
                </div>
                <div class="row" id="top-data">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div class="card-title font-weight-bold">Total Viewed Listings {$total_record|number_format:0}</div>
                                    <div class="card-title page-title">
                                        {if count($rsUser) > 0}Looking for at least a <b>{$stats['max_bed']}</b> Bedroom <b>{$stats['max_community']}</b> in <b>{$stats['max_city']}</b> {if isset($stats['max_zip']) && $stats['max_zip'] != ''}({$stats['max_zip']}){/if} around <b>{if $objUtility->PriceFormat($stats['avg_price']) != ''}${$objUtility->PriceFormat($stats['avg_price'])}{/if}</b>.{/if}
                                    </div>
                                    <table class="table table-hover c-table mt-3">
                                        <thead>
                                            <tr>
                                                <th class="text-primary border-0"><i class="mdi mdi-plus-circle-outline text-primary" style="font-size: 15px;"></i>Cities</th>
                                                <th class="text-primary border-0"><i class="mdi mdi-plus-circle-outline text-primary" style="font-size: 15px;"></i>Zip Codes</th>
                                                <th class="text-primary border-0"><i class="mdi mdi-plus-circle-outline text-primary" style="font-size: 15px;"></i>Bedrooms</th>
                                                <th class="text-primary border-0"><i class="mdi mdi-plus-circle-outline text-primary" style="font-size: 15px;"></i>Subdivisions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if count($stats) > 0}
                                                <tr>
                                                    <td class="align-top">
                                                        {if isset($stats['city']) && count($stats['city']) > 0}
                                                            <ul id="city_td" class="m-0">
                                                                {foreach from=$stats['city'] item=city name=Cities}
                                                                    <li class="city_sh {if $smarty.foreach.Cities.index >= 3}d-none{/if}">{$city@key}<strong><sup>{$city}%</sup></strong></li>
                                                                {/foreach}
                                                                {if count($stats['city']) > 3}
                                                                    <div class="font-weight-normal"><a class="text-primary" href="javascript:void(0);" id="city_sh">See More</a></div>
                                                                {/if}
                                                            </ul>
                                                        {/if}
                                                    </td>
                                                    <td class="align-top">
                                                        {if isset($stats['zip']) && count($stats['zip']) > 0}
                                                            <ul id="zip_td" class="m-0">
                                                                {foreach from=$stats['zip'] item=zip name=ZipCodes}
                                                                    <li class="zip_sh {if $smarty.foreach.ZipCodes.index >= 3}d-none{/if}">{$zip@key}<strong><sup>{$zip}%</sup></strong></li>
                                                                {/foreach}
                                                                {if count($stats['zip']) > 3}
                                                                    <div class="font-weight-normal"><a class="text-primary" href="javascript:void(0);" id="zip_sh">See More</a></div>
                                                                {/if}
                                                            </ul>
                                                        {/if}
                                                    </td>
                                                    <td class="align-top">
                                                        {if isset($stats['bed']) && count($stats['bed']) > 0}
                                                            <ul id="bed_td" class="m-0">
                                                                {foreach from=$stats['bed'] item=bed name=Beds}
                                                                    <li class="bed_sh {if $smarty.foreach.Beds.index >= 3}d-none{/if}">{$bed@key}<strong><sup>{$bed}%</sup></strong></li>
                                                                {/foreach}
                                                                {if count($stats['bed']) > 3}
                                                                    <div class="font-weight-normal"><a class="text-primary" href="javascript:void(0);" id="bed_sh">See More</a></div>
                                                                {/if}
                                                            </ul>
                                                        {/if}
                                                    </td>
                                                    <td class="align-top">
                                                        {if isset($stats['community']) && count($stats['community']) > 0}
                                                            <ul id="community_td" class="m-0">
                                                                {foreach from=$stats['community'] item=community name=Communities}
                                                                    <li class="community_sh {if $smarty.foreach.Communities.index >= 3}d-none{/if}">{$community@key}<strong><sup>{$community}%</sup></strong></li>
                                                                {/foreach}
                                                                {if count($stats['community']) > 3}
                                                                    <div class="font-weight-normal"><a class="text-primary" href="javascript:void(0);" id="community_sh">See More</a></div>
                                                                {/if}
                                                            </ul>
                                                        {/if}
                                                    </td>
                                                </tr>
                                            {/if}
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <table class="table table-hover c-table mt-3">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Date</th>
                                            <th class="text-primary">Buyer</th>
                                            <th class="text-primary">MLS ID</th>
                                            <th class="text-primary">City</th>
                                            <th class="text-primary">Zip</th>
                                            <th class="text-primary">Price</th>
                                            <th class="text-primary">Property</th>
                                            <th class="text-primary">Community</th>
                                            <th class="text-primary"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {if count($rsUser) > 0}
                                            {foreach $rsUser as $record}
                                                {*{assign var=Record value=$record['log_additional_info']|json_decode:true}*}
                                                {assign var=Record value=$record['log_additional_info']|unserialize}
                                                <tr>
                                                    <td><p class="font-weight-bold mb-1">{$Record.Listing_Created_Date|date_format:'%m-%d-%Y'}</p><p class="mb-0 text-lowercase">{$Record.Listing_Created_Date|date_format:'%I:%M %p'}</p></td>
                                                    <td>{if $Record.lead_first_name && $Record.lead_last_name != ''}
                                                            {if isset($Record.lead_first_name) && $Record.lead_first_name != ''}{$Record.lead_first_name}{/if}
                                                            {if isset($Record.lead_first_name) && $Record.lead_first_name != ''}<br>{$Record.lead_last_name}{/if}
                                                        {else}
                                                            -
                                                        {/if}
                                                    </td>
                                                    <td>{$Record.MLS_NUM}</td>
                                                    <td>{$Record.CityName}</td>
                                                    <td>{$Record.ZipCode}</td>
                                                    <td><b>${$Record.ListPrice|number_format}</b></td>
                                                    <td>{$Record.Address}<br>{$Record.PropertyType}</td>
                                                    <td>{if isset($Record.Subdivision) && $Record.Subdivision != ''}{$Record.Subdivision}{else}-{/if}</td>
                                                    <td>
                                                        {if $Record.ListingID_MLS != ''}
                                                            <a href="{$scriptname}&action=view_listing&mls_id={$Record.ListingID_MLS}"><i class="mdi mdi-account-outline text-primary" style="font-size: 15px;"></i><b>Profile</b></a>
                                                        {else}
                                                            <i class="mdi mdi-account-outline text-primary" style="font-size: 15px;"></i><b>Profile</b>
                                                        {/if}
                                                    </td>
                                                </tr>
                                            {/foreach}
                                        {else}
                                            <tr class="alt"><td colspan="12">No Data Found.</td></tr>
                                        {/if}
                                    </tbody>
                                </table>
                                {if count($rsUser) > 0}
                                    <hr/>
                                    <div class="btn-group float-left" role="group" aria-label="Basic example">
                                        <span class="card-title- font-weight-bold">Showing {$startRecord+1} to {if $total_record <= $page_size || $totalFetched < $page_size}{$total_record}{else}{$startRecord+$page_size}{/if} of {$total_record} entries</span>
                                    </div>
                                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                                        {if $total_record >= $page_size}
                                            {html_pager_responsive_loopt num_items=$total_record per_page=$page_size start_item=$startRecord add_prevnext_text=true}
                                        {/if}
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>