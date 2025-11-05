<section id="te-market-report-container" class="px-xl-5 te-font-family">
    <div class="container-fluid con-mar- te-market-report-container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1-">
                {if is_array($statistic) && count($statistic) > 0}
                    {*<div class="row py-2">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-1 te-market-report-title">
                            <h4 class="te-market-title txt-heading heading_txt_color">Market Insights for {$title}</h4>
                        </div>
                        *}{*<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-closed-sales-as text-left">
                            <p class="text-dark mb-0 te-font-size-14">As of {$TodayDate}</p>
                        </div>*}{*
                    </div>*}
                    <div class="row pt-3- market-statistics text-dark- {if $attr['background'] == 'dark'} pre_market_text_dark{else}pre_market_text_light{/if}">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1- pr-xl-3">
                            <h3 class="title-font text-center te-market-title- text-border-bottom pt-4 pb-4 {if $attr['background'] == 'dark'} pre_market_text_dark{else}pre_market_text_light{/if}">For Sale</h3>
                            <ul class="p-0 pt-3  px-0">
                                <li class="d-flex col-12 justify-content-between text-center  pb-3 pt-3  px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Active For Sale</span><span class="font-weight-bold col-5 border-bottom px-0 px-0">{$statistic.statistic_total_active_listing}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Average Price</span><span class="font-weight-bold col-5 border-bottom px-0 px-0">{$currency}{$statistic.statistic_avg_active_price|number_format}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Average Price / SqFt</span><span class="font-weight-bold col-5 border-bottom px-0 px-0">{$currency}{$statistic.statistic_avg_active_price_sqft|number_format}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Average Days on Market</span><span class="font-weight-bold col-5 border-bottom px-0 px-0">{if $statistic.statistic_avg_active_dom}{$statistic.statistic_avg_active_dom}{else}-{/if}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Largest Price Reduction</span><span class="font-weight-bold col-5 border-bottom px-0 {if $statistic.statistic_largest_price_diff >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_largest_price_reduction|number_format} {*({$statistic.statistic_largest_price_diff|round:2}%)*}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Largest Price Increase</span><span class="font-weight-bold col-5 border-bottom px-0 {if $statistic.statistic_largest_price_diff_increase >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_largest_price_increase|number_format} {*({$statistic.statistic_largest_price_diff|round:2}%)*}</span></li>
                                {*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $maxReducePercentage >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$max_price_diff)|number_format} ({$maxReducePercentage|round:2}%)</span></li>*}
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1- px-xl-3">
                            <h3 class="title-font text-center te-market-title- text-border-bottom pt-4 pb-4 {if $attr['background'] == 'dark'} pre_market_text_dark{else}pre_market_text_light{/if}">Pending Sales</h3>
                            <ul class="p-0 pt-3">
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Pending Sales</span><span class="font-weight-bold col-5 border-bottom px-0">{$statistic.statistic_total_pending_listing}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Price</span><span class="font-weight-bold col-5 border-bottom px-0">{$currency}{$statistic.statistic_avg_pending_price|number_format}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Price / SqFt</span><span class="font-weight-bold col-5 border-bottom px-0">{$currency}{$statistic.statistic_avg_pending_price_sqft|number_format}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Days on Market</span><span class="font-weight-bold col-5 border-bottom px-0">{if $statistic.statistic_avg_pending_dom > 0}{$statistic.statistic_avg_pending_dom}{else}-{/if}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Reduction</span><span class="font-weight-bold col-5 border-bottom  px-0 {if $statistic.statistic_largest_pending_price_diff >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_pending_largest_price_reduction|number_format} {*({$statistic.statistic_largest_pending_price_diff|round:2}%)*}</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Increase</span><span class="font-weight-bold col-5 border-bottom  px-0 {if $statistic.statistic_largest_pending_price_diff_increase >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_pending_largest_price_increase|number_format} {*({$statistic.statistic_largest_pending_price_diff|round:2}%)*}</span></li>
                                {*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $maxPendingReducePercentage >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$max_pending_price_diff)|number_format} ({$maxPendingReducePercentage|round:2}%)</span></li>*}
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1- pl-xl-3">
                            <h3 class="title-font text-center te-market-title- text-border-bottom pt-4 pb-4 {if $attr['background'] == 'dark'} pre_market_text_dark{else}pre_market_text_light{/if}">Closed Sales</h3>
                            <ul class="p-0 pt-3">
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Sold (Last 180 Days)</span><span class="font-weight-bold col-5 px-0 border-bottom">{$statistic.statistic_sixmon_tot_sold_listing}</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4" >Average Price</span><span class="font-weight-bold col-5 px-0 border-bottom">{$currency}{$statistic.statistic_six_month_avg_sold_price|number_format}</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Price / SqFt</span><span class="font-weight-bold col-5 px-0 border-bottom">{$currency}{$statistic.statistic_six_month_avg_sold_price_sqft|number_format}</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Days on Market</span><span class="font-weight-bold col-5 px-0 border-bottom">{if $statistic.statistic_six_month_avg_sold_dom > 0}{$statistic.statistic_six_month_avg_sold_dom}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Reduction</span><span class="font-weight-bold col-5 px-0 border-bottom {if $statistic.statistic_largest_sold_price_diff >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_six_month_sold_largest_price_reduction|number_format} {*({$statistic.statistic_largest_sold_price_diff|round:2}%)*}</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Increase</span><span class="font-weight-bold col-5 px-0 border-bottom {if $statistic.statistic_largest_sold_price_diff_increase >= 0}text-success{else}text-danger{/if}">{$currency}{$statistic.statistic_six_month_sold_largest_price_increase|number_format} {*({$statistic.statistic_largest_sold_price_diff|round:2}%)*}</span></li>
                                {*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Price Reduction</span><span class="font-weight-bold {if $maxSoldReducePercentage >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$max_sold_price_diff)|number_format} ({$maxSoldReducePercentage|round:2}%)</span></li>*}
                            </ul>
                        </div>
                    </div>

                {else}
                    No Statistics Available 
                {/if}
            </div>
        </div>
    </div>
</section>
{if $pid !=''}
    <input type="hidden" class="pid" id="pid" name="pid" value="{$pid}">
<input type="hidden" class="json_bg" id="bg_{$attr['pid']}" name="json_bg" value="{$attr.background}" data-pid="bg_{$attr['pid']}">
{/if}


