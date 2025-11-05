<section class="pt-4 te-font-family">
    <div id="building-data" class="container pt-0 text-white">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white text-uppercase">{$title}</h2>
            </div>
        </div>
        </br>
        <ul class="list-unstyled row list-stats p-0">
            <li class="list-item col-sm-6 col-12 text-center">
                <div class="num-stat">{$statistic.statistic_total_active_listing|number_format}</div>
                <p class="text-white text-uppercase" data-open-accessibility-text-original="15px" style="font-size: 15px;">Available Sales</p>
            </li>
            <li class="list-item col-sm-6 col-12 text-center">
                <div class="num-stat">{$statistic.statistic_total_rental_listing|number_format}</div>
                <p class="text-white text-uppercase" data-open-accessibility-text-original="15px" style="font-size: 15px;">Available Rentals</p>
            </li>
            <li class="list-item col-sm-6 col-12 text-center">
                <div class="num-stat">{$statistic.statistic_sixmon_tot_sold_listing|number_format}</div>
                <p class="text-white text-uppercase" data-open-accessibility-text-original="15px" style="font-size: 15px;">Recent Sales</p>
            </li>
            <li class="list-item col-sm-6 col-12 text-center">
                <div class="num-stat">{$statistic.statistic_total_pending_listing|number_format}</div>
                <p class="text-white text-uppercase" data-open-accessibility-text-original="15px" style="font-size: 15px;">Under Contract</p>
            </li>
            <li class="list-item col-sm-6 col-12 text-center">
                <div class="num-stat">{$currency}{$statistic.statistic_median_active_price_sqft|number_format}</div>
                <p class="text-white text-uppercase" data-open-accessibility-text-original="15px" style="font-size: 15px;">Avg Per Sq Ft<br>(Active)</p>
            </li>
            <li class="list-item col-sm-6 col-12 text-center">
                <div class="num-stat">{$currency}{$statistic.statistic_median_sold_price_sqft|number_format}</div>
                <p class="text-white text-uppercase" data-open-accessibility-text-original="15px" style="font-size: 15px;">Avg Per Sq Ft<br>(Sold)</p>
            </li>
        </ul>
        <ul class="list-unstyled row p-0 list-stats">
            <li class="list-item col-12 text-center border-0">
                <div class="num-stat text-white">-{$currency}{str_replace('-','',$statistic.statistic_largest_price_reduction|number_format)}</div>
                <p class="text-white text-uppercase" data-open-accessibility-text-original="15px" style="font-size: 15px;">Largest Price Reduction</p>
            </li>
        </ul>
    </div>
</section>