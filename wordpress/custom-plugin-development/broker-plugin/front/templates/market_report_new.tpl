<section id="te-new-market-report-container" class="py-5  ">
    <div class="market_insights">
        <h2 {*id="market_overview_head"*} class="title-font text-left"> Miami Beach Real Estate Market Overview</h2>
        <p class="market-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <div id="chart-main-section">

            <div class="row">
                <div class="col-xxl-9 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12 market_chart">
                    <h3 id="market_insights_head" class="chart-head title-font text-left text-border-bottom pt-4 pb-3">Market Insights</h3>
                    <div class="row">
                        {if isset($PreSearch) && $PreSearch == true}
                            <div class="single-home-count">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="pt-4 text-center">Single Family Homes</p>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="p-3 h4">{$preTotCount|number_format:0}</p>
                                </div>
                            </div>
                        {/if}
                        {if isset($ConSearch) && ConSearch == true}
                            <div class="condo-count">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="pt-4 text-center">Condos</p>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="p-3 text-center h4">{$conTotCount|number_format:0}</p>
                                </div>
                            </div>
                        {/if}
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                            <canvas id="market_insights" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                    </div>
                    {*---------ACTIVE FOR SALE-------------------*}
                    <h3 id="avaiable_sale_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3 avaiable_sale">Available For sale</h3>
                    <p class="market-text">In comparision with sale prices last month, list price of Single Family homes {if {$PreSaleActive['MNT']['avg_price']} > 0}increased {else} decreased {/if} by {$PreSaleActive['MNT']['avg_price']}{$percnt} whereas, list price of Condos {if {$ConSaleActive['MNT']['avg_price']} > 0}increased {else} decreased {/if} by {$ConSaleActive['MNT']['avg_price']}{$percnt}</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="avaiable_sale" class="graph-chart chartjs-render-monitor"></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            {if isset($PreSearch) && $PreSearch == true}
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                {*</div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-5 col-5  ">*}
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active Listings:
                                            <span class="pre-fields">{$PreStatic['statistic_total_active_listing']}</span>
                                            <span class="{if {$PreSaleActive['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$PreSaleActive['MNT']['total_listing']} mo</span>
                                            <span class="{if {$PreSaleActive['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$PreSaleActive['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_avg_active_price']|number_format:0}</span>
                                            <span class="{if {$PreSaleActive['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$PreSaleActive['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$PreSaleActive['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$PreSaleActive['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_avg_active_price_sqft']|number_format:0}</span>
                                            <span class="{if {$PreSaleActive['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$PreSaleActive['MNT']['avg_price_sqft']}{$percnt} mo</span>
                                            <span class="{if {$PreSaleActive['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$PreSaleActive['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields">{$PreStatic['statistic_avg_active_dom']}</span>
                                            <span class="{if {$PreSaleActive['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$PreSaleActive['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$PreSaleActive['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$PreSaleActive['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                            <br>
                            {if isset($ConSearch) && ConSearch == true}
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active Listings:
                                            <span class="con-fields">{$ConStatic['statistic_total_active_listing']}</span>
                                            <span class="{if {$ConSaleActive['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$ConSaleActive['MNT']['total_listing']} mo </span>
                                            <span class="{if {$ConSaleActive['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$ConSaleActive['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_avg_active_price']|number_format:0}</span>
                                            <span class="{if {$ConSaleActive['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$ConSaleActive['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$ConSaleActive['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$ConSaleActive['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_avg_active_price_sqft']|number_format:0}</span>
                                            <span class="{if {$ConSaleActive['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$ConSaleActive['MNT']['avg_price_sqft']}{$percnt} mo </span>
                                            <span class="{if {$ConSaleActive['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$ConSaleActive['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields">{$ConStatic['statistic_avg_active_dom']}</span>
                                            <span class="{if {$ConSaleActive['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$ConSaleActive['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$ConSaleActive['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$ConSaleActive['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                        </div>
                    </div>
                    {*---------PRICE PER SQUARE FOOT-------------------*}
                    <h3 id="pricesqft_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Price Per Square Foot</h3>
                    <p class="market-text">In comparision with sale prices last month, list price of Single Family homes {if {$PreSaleActive['MNT']['avg_price']} > 0}increased {else} decreased {/if} by {$PreSaleActive['MNT']['avg_price']}{$percnt} whereas, list price of Condos {if {$ConSaleActive['MNT']['avg_price']} > 0}increased {else} decreased {/if} by {$ConSaleActive['MNT']['avg_price']}{$percnt}</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="pricesqft_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            {if isset($PreSearch) && $PreSearch == true}
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                {*</div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-5 col-5  ">*}
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active :
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_avg_active_price']|number_format:0}</span>
                                            <span class="{if {$PreSaleActive['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$PreSaleActive['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$PreSaleActive['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$PreSaleActive['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Pending :
                                            <span class="pre-fields">{$currency}{$PreStaticPND['statistic_avg_pending_price']|number_format:0}</span>
                                            <span class="{if {$PrePending['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$PrePending['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$PrePending['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$PrePending['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Sold :
                                            <span class="pre-fields">{$currency}{$PreStaticCLOSD['statistic_six_month_avg_sold_price']|number_format:0}</span>
                                            <span class="{if {$PreClosed['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$PreClosed['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                            <br>
                            {if isset($ConSearch) && ConSearch == true}
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active :
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_avg_active_price']|number_format:0}</span>
                                            <span class="{if {$ConSaleActive['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$ConSaleActive['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$ConSaleActive['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$ConSaleActive['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Pending :
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_avg_pending_price']|number_format:0}</span>
                                            <span class="{if {$ConPending['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$ConPending['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$ConPending['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$ConPending['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Sold :
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_six_month_avg_sold_price_sqft']|number_format:0}</span>
                                            <span class="{if {$ConClosed['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$ConClosed['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                        </div>
                    </div>
                    {*---------PRICE ADJUSTMENTS-------------------*}
                    <h3 id="price_adjust_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Price Adjustments</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-7 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="price_adjust" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-5 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            {if isset($PreSearch) && $PreSearch == true}
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                {*</div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-5 col-5  ">*}
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Active):
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_largest_price_reduction']|number_format:0}</span>
                                            <span class="{if {$PreSaleActive['MNT']['lg_price_red']} > 0}text-success{else}text-danger{/if}">({$PreSaleActive['MNT']['lg_price_red']}{$percnt} </span>
                                            <span class="{if {$PreSaleActive['YR']['lg_price_red']} > 0}text-success{else}text-danger{/if}"> / {$PreSaleActive['YR']['lg_price_red']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Active):
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_largest_price_increase']|number_format:0}</span>
                                            <span class="{if {$PreSaleActive['MNT']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">({$PreSaleActive['MNT']['lg_price_inc']}{$percnt} mo </span>
                                            <span class="{if {$PreSaleActive['YR']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">/ {$PreSaleActive['YR']['lg_price_inc']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Pending):
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_pending_largest_price_reduction']|number_format:0}</span>
                                            <span class="{if {$PrePending['MNT']['lg_price_red']} > 0}text-success{else}text-danger{/if}">({$PrePending['MNT']['lg_price_red']}{$percnt} mo </span>
                                            <span class="{if {$PrePending['YR']['lg_price_red']} > 0}text-success{else}text-danger{/if}">/ {$PrePending['YR']['lg_price_red']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Pending):
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_pending_largest_price_increase']|number_format:0}</span>
                                            <span class="{if {$PrePending['MNT']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">({$PrePending['MNT']['lg_price_inc']}{$percnt} mo </span>
                                            <span class="{if {$PrePending['YR']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">/ {$PrePending['YR']['lg_price_inc']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Sold):
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_six_month_sold_largest_price_reduction']|number_format:0}</span>
                                            <span class="{if {$PreClosed['MNT']['lg_price_red']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['lg_price_red']}{$percnt} mo </span>
                                            <span class="{if {$PreClosed['YR']['lg_price_red']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['lg_price_red']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Sold):
                                            <span class="pre-fields">{$currency}{$PreStatic['statistic_six_month_sold_largest_price_increase']|number_format:0}</span>
                                            <span class="{if {$PreClosed['MNT']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['lg_price_inc']}{$percnt} mo </span>
                                            <span class="{if {$PreClosed['YR']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['lg_price_inc']}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                            <br>
                            {if isset($ConSearch) && ConSearch == true}
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Active):
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_largest_price_reduction']|number_format:0}</span>
                                            <span class="{if {$ConSaleActive['MNT']['lg_price_red']} > 0}text-success{else}text-danger{/if}">({$ConSaleActive['MNT']['lg_price_red']}{$percnt} mo</span>
                                            <span class="{if {$ConSaleActive['YR']['lg_price_red']} > 0}text-success{else}text-danger{/if}">/ {$ConSaleActive['YR']['lg_price_red']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Active):
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_largest_price_increase']|number_format:0}</span>
                                            <span class="{if {$ConSaleActive['MNT']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">({$ConSaleActive['MNT']['lg_price_inc']}{$percnt} mo </span>
                                            <span class="{if {$ConSaleActive['YR']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">/ {$ConSaleActive['YR']['lg_price_inc']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Pending):
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_pending_largest_price_reduction']|number_format:0}</span>
                                            <span class="{if {$ConPending['MNT']['lg_price_red']} > 0}text-success{else}text-danger{/if}">({$ConPending['MNT']['lg_price_red']}{$percnt} mo </span>
                                            <span class="{if {$ConPending['YR']['lg_price_red']} > 0}text-success{else}text-danger{/if}">/ {$ConPending['YR']['lg_price_red']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Pending):
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_pending_largest_price_increase']|number_format:0}</span>
                                            <span class="{if {$ConPending['MNT']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">({$ConPending['MNT']['lg_price_inc']}{$percnt} mo </span>
                                            <span class="{if {$ConPending['YR']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">/ {$ConPending['YR']['lg_price_inc']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Sold):
                                            <span class="con-fields">{$currency}{$PreStatic['statistic_six_month_sold_largest_price_reduction']|number_format:0}</span>
                                            <span class="{if {$ConClosed['MNT']['lg_price_red']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['lg_price_red']}{$percnt} mo </span>
                                            <span class="{if {$ConClosed['YR']['lg_price_red']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['lg_price_red']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Sold):
                                            <span class="con-fields">{$currency}{$PreStatic['statistic_six_month_sold_largest_price_increase']|number_format:0}</span>
                                            <span class="{if {$ConClosed['MNT']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['lg_price_inc']}{$percnt} mo </span>
                                            <span class="{if {$ConClosed['YR']['lg_price_inc']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['lg_price_inc']}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                        </div>
                    </div>
                    {*---------PENDING-------------------*}
                    <h3 id="pending_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Pending</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="pending_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            {if isset($PreSearch) && $PreSearch == true}
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Pending Listings:
                                            <span class="pre-fields">{$PreStaticPND['statistic_total_pending_listing']}</span>
                                            <span class="{if {$PrePending['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$PrePending['MNT']['total_listing']} mo </span>
                                            <span class="{if {$PrePending['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$PrePending['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields">{$currency}{$PreStaticPND['statistic_avg_pending_price']|number_format:0}</span>
                                            <span class="{if {$PrePending['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$PrePending['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$PrePending['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$PrePending['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="pre-fields">{$currency}{$PreStaticPND['statistic_avg_pending_price_sqft']|number_format:0}</span>
                                            <span class="{if {$PrePending['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$PrePending['MNT']['avg_price_sqft']}{$percnt} mo </span>
                                            <span class="{if {$PrePending['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$PrePending['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields">{$PreStaticPND['statistic_avg_pending_dom']}</span>
                                            <span class="{if {$PrePending['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$PrePending['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$PrePending['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$PrePending['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                            <br>
                            {if isset($ConSearch) && ConSearch == true}
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Pending Listings:
                                            <span class="con-fields">{$ConStatic['statistic_total_pending_listing']}</span>
                                            <span class="{if {$ConPending['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$ConPending['MNT']['total_listing']} mo </span>
                                            <span class="{if {$ConPending['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$ConPending['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_avg_pending_price']|number_format:0}</span>
                                            <span class="{if {$ConPending['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$ConPending['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$ConPending['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$ConPending['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_avg_pending_price_sqft']|number_format:0}</span>
                                            <span class="{if {$ConPending['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$ConPending['MNT']['avg_price_sqft']}{$percnt} mo </span>
                                            <span class="{if {$ConPending['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$ConPending['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields">{$ConStatic['statistic_avg_pending_dom']}</span>
                                            <span class="{if {$ConPending['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$ConPending['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$ConPending['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$ConPending['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                        </div>
                    </div>
                    {*---------SOLD-------------------*}
                    <h3 id="sold_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Sold</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        {*<hr class="market">*}

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="sold_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            {if isset($PreSearch) && $PreSearch == true}
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Sold Listings:
                                            <span class="pre-fields">{$PreStaticCLOSD['statistic_total_sold_listing']}</span>
                                            <span class="{if {$PreClosed['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['total_listing']} mo </span>
                                            <span class="{if {$PreClosed['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields">{$currency}{$PreStaticCLOSD['statistic_six_month_avg_sold_price']|number_format:0}</span>
                                            <span class="{if {$PreClosed['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$PreClosed['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="pre-fields">{$currency}{$PreStaticCLOSD['statistic_six_month_avg_sold_price_sqft']|number_format:0}</span>
                                            <span class="{if {$PreClosed['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['avg_price_sqft']}{$percnt} mo </span>
                                            <span class="{if {$PreClosed['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields">{$PreStaticCLOSD['statistic_six_month_avg_sold_dom']}</span>
                                            <span class="{if {$PreClosed['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$PreClosed['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="pre-fields">{$PreStaticCLOSD['statistic_listing_discount']|string_format:"%.2f"}{$percnt}</span>
                                            <span class="{if {$PreClosed['MNT']['discount']} > 0}text-success{else}text-danger{/if}">({$PreClosed['MNT']['discount']|string_format:"%.2f"}{$percnt} mo </span>
                                            <span class="{if {$PreClosed['YR']['discount']} > 0}text-success{else}text-danger{/if}">/ {$PreClosed['YR']['discount']|string_format:"%.2f"}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                            <br>
                            {if isset($ConSearch) && ConSearch == true}
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Sold Listings:
                                            <span class="con-fields">{$ConStatic['statistic_total_sold_listing']}</span>
                                            <span class="{if {$ConClosed['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['total_listing']} mo </span>
                                            <span class="{if {$ConClosed['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_six_month_avg_sold_price']|number_format:0}</span>
                                            <span class="{if {$ConClosed['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$ConClosed['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_six_month_avg_sold_price_sqft']|number_format:0}</span>
                                            <span class="{if {$ConClosed['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['avg_price_sqft']}{$percnt} mo </span>
                                            <span class="{if {$ConClosed['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields">{$ConStatic['statistic_six_month_avg_sold_dom']}</span>
                                            <span class="{if {$ConClosed['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$ConClosed['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="con-fields">{$ConStatic['statistic_listing_discount']|string_format:"%.2f"}{$percnt}</span>
                                            <span class="{if {$ConClosed['MNT']['discount']} > 0}text-success{else}text-danger{/if}">({$ConClosed['MNT']['discount']|string_format:"%.2f"}{$percnt} mo </span>
                                            <span class="{if {$ConClosed['YR']['discount']} > 0}text-success{else}text-danger{/if}">/ {$ConClosed['YR']['discount']|string_format:"%.2f"}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                        </div>
                    </div>
                    {*---------SOLD LUXURY-------------------*}
                    <h3 id="sold_lux_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Sold - Luxury</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="sold_lux_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            {if isset($PreSearch) && $PreSearch == true}
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Sold Listings:
                                            <span class="pre-fields">{$PreStaticLUX['statistic_total_sold_listing']}</span>
                                            <span class="{if {$PreClosedLux['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$PreClosedLux['MNT']['total_listing']} mo </span>
                                            <span class="{if {$PreClosedLux['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$PreClosedLux['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields">{$currency}{$PreStaticLUX['statistic_six_month_avg_sold_price']|number_format:0}</span>
                                            <span class="{if {$PreClosedLux['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$PreClosedLux['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$PreClosedLux['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$PreClosedLux['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class=""> Avg Price/Sqft:
                                            <span class="pre-fields">{$currency}{$PreStaticLUX['statistic_six_month_avg_sold_price_sqft']|number_format:0}</span>
                                            <span class="{if {$PreClosedLux['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$PreClosedLux['MNT']['avg_price_sqft']}{$percnt} mo </span>
                                            <span class="{if {$PreClosedLux['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$PreClosedLux['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields">{$PreStaticLUX['statistic_six_month_avg_sold_dom']}</span>
                                            <span class="{if {$PreClosedLux['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$PreClosedLux['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$PreClosedLux['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$PreClosedLux['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="pre-fields">{$PreStaticLUX['statistic_listing_discount']|string_format:"%.2f"}{$percnt}</span>
                                            <span class="{if {$PreClosedLux['MNT']['discount']} > 0}text-success{else}text-danger{/if}">({$PreClosedLux['MNT']['discount']|string_format:"%.2f"}{$percnt} mo </span>
                                            <span class="{if {$PreClosedLux['YR']['discount']} > 0}text-success{else}text-danger{/if}">/ {$PreClosedLux['YR']['discount']|string_format:"%.2f"}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                            <br>
                            {if isset($ConSearch) && ConSearch == true}
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class=""> Sold Listings:
                                            <span class="con-fields">{$ConStatic['statistic_total_sold_listing']}</span>
                                            <span class="{if {$ConClosedLux['MNT']['total_listing']} > 0}text-success{else}text-danger{/if}">({$ConClosedLux['MNT']['total_listing']} mo </span>
                                            <span class="{if {$ConClosedLux['YR']['total_listing']} > 0}text-success{else}text-danger{/if}">/ {$ConClosedLux['YR']['total_listing']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_six_month_avg_sold_price']|number_format:0}</span>
                                            <span class="{if {$ConClosedLux['MNT']['avg_price']} > 0}text-success{else}text-danger{/if}">({$ConClosedLux['MNT']['avg_price']}{$percnt} mo </span>
                                            <span class="{if {$ConClosedLux['YR']['avg_price']} > 0}text-success{else}text-danger{/if}">/ {$ConClosedLux['YR']['avg_price']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields">{$currency}{$ConStatic['statistic_six_month_avg_sold_price_sqft']|number_format:0}</span>
                                            <span class="{if {$ConClosedLux['MNT']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">({$ConClosedLux['MNT']['avg_price_sqft']}{$percnt} mo </span>
                                            <span class="{if {$ConClosedLux['YR']['avg_price_sqft']} > 0}text-success{else}text-danger{/if}">/ {$ConClosedLux['YR']['avg_price_sqft']}{$percnt} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields">{$ConStatic['statistic_six_month_avg_sold_dom']}</span>
                                            <span class="{if {$ConClosedLux['MNT']['avg_dom']} > 0}text-success{else}text-danger{/if}">({$ConClosedLux['MNT']['avg_dom']} mo </span>
                                            <span class="{if {$ConClosedLux['YR']['avg_dom']} > 0}text-success{else}text-danger{/if}">/ {$ConClosedLux['YR']['avg_dom']} yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="con-fields">{$ConStatic['statistic_listing_discount']|string_format:"%.2f"}{$percnt}</span>
                                            <span class="{if {$ConClosedLux['MNT']['discount']} > 0}text-success{else}text-danger{/if}">({$ConClosedLux['MNT']['discount']|string_format:"%.2f"}{$percnt} mo </span>
                                            <span class="{if {$ConClosedLux['YR']['discount']} > 0}text-success{else}text-danger{/if}">/ {$ConClosedLux['YR']['discount']|string_format:"%.2f"}{$percnt} yr)</span></a>
                                    </li>
                                </ul>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 market-info">
                    <div class="section-nav ">
                        <div>
                            <a class="font-weight-bold" {*href="#market_overview_head"*}>Market Overview</a>
                        </div>
                        <div>
                            <a class="font-weight-bold" href="#market_insights_head">Market Insights</a>
                            <ul class="grid list-disc pl-6">
                                <li><a href="#avaiable_sale_head">Available For Sale</a></li>
                                <li><a href="#pricesqft_chart_head">Price Per Square Foot</a></li>
                                <li><a href="#price_adjust_head">Price Adjustments</a></li>
                                <li><a href="#pending_chart_head">Pending</a></li>
                                <li><a href="#sold_chart_head">Sold</a></li>
                                <li><a href="#sold_lux_chart_head">Sold - Luxury</a></li>
                            </ul>
                            <a class="font-weight-bold" href="#price_reduce_by_price">Price Reduction By Price</a>
                            <a class="font-weight-bold" href="#price_reduce_by_prcnt">Price Reduction By %</a>
                            <a class="font-weight-bold" href="#recent_sales">Recent Sales</a>
                            <a class="font-weight-bold" href="#under_contract_pending">Under Contract/Pending</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row ">
            <div id="market-list-view" class="row pt-5 market-list">
                {*                {if is_array($price_red_ByPrice['rs']) && count($price_red_ByPrice['rs']) > 0}*}
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 pt-5">
                    <h4 id="price_reduce_by_price" class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Largest Price Reductions By Price</h4>
                {*</div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">*}
                    <div class="table pt-4 mrkt-font">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr class="text-left te-font-size-12">
                                <th nowrap scope="col" class="border">Address</th>
                                <th nowrap scope="col" class="border">Subdivision</th>
                                <th nowrap scope="col" class="border">List Price</th>
                                <th nowrap scope="col" class="border">New Price</th>
                                <th nowrap scope="col" class="border">Price Change</th>
                                <th nowrap scope="col" class="border">Sq Ft</th>
                                <th nowrap scope="col" class="border">{$currency}/Sq Ft</th>
                                <th nowrap scope="col" class="border">Beds/Baths</th>
                                <th nowrap scope="col" class="border">DOM</th>
                            </tr>
                            </thead>
                            <tbody class="te-tbody te-font-size-12">
                            {if is_array($price_red_ByPrice['rs']) && count($price_red_ByPrice['rs']) > 0}
                                {foreach name=priceRed from=$price_red_ByPrice['rs'] item=Record}
                                    {$arrLargestPrice = array_column($Record,'Price_Diff')}
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                            {else}
                                                <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            {/if}
                                        </td>
                                        <td nowrap>
                                            {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                <small>{$Record.Subdivision|lower}</small>
                                            {else}
                                                <small>N/A</small>
                                            {/if}
                                        </td>
                                        <td nowrap>{$currency}{$Record.ListPrice|number_format:0}</td>
                                        <td nowrap>{$currency}{$Record.OriginalListPrice|number_format:0}</td>
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <td nowrap class="{if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$pricedef)|number_format} {*({$currency}{$pricedef|number_format})*}</td>
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
                            {else}
                                No Statistics Available for Single Family Home
                            {/if}
                            {if is_array($price_red_ByPrice_con['rs']) && count($price_red_ByPrice_con['rs']) > 0}
                                <br>
                                {foreach name=priceRed from=$price_red_ByPrice_con['rs'] item=Record}
                                    {$arrLargestPrice = array_column($Record,'Price_Diff')}
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                            {else}
                                                <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            {/if}
                                        </td>
                                        <td nowrap>
                                            {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                <small>{$Record.Subdivision|lower}</small>
                                            {else}
                                                <small>N/A</small>
                                            {/if}
                                        </td>
                                        <td nowrap>{$currency}{$Record.ListPrice|number_format:0}</td>
                                        <td nowrap>{$currency}{$Record.OriginalListPrice|number_format:0}</td>
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <td nowrap class="{if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}">{$currency}{str_replace('-','',$pricedef)|number_format} {*({$currency}{$pricedef|number_format})*}</td>
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
                            {else}
                                No Statistics Available for Condos
                            {/if}
                            </tbody>
                        </table>
                    </div>
                </div>
                {*{else}
                    No Statistics Available
                {/if}*}
                {if is_array($price_red['rs']) && count($price_red['rs']) > 0}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 pt-5">
                        <h4 id="price_reduce_by_prcnt" class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Largest Price Reductions By %</h4>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="table-responsive pt-4 mrkt-font">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr class="text-left te-font-size-12">
                                    <th nowrap scope="col" class="border">Address</th>
                                    <th nowrap scope="col" class="border">Subdivision</th>
                                    <th nowrap scope="col" class="border">List Price</th>
                                    <th nowrap scope="col" class="border">New Price</th>
                                    <th nowrap scope="col" class="border">Price Change</th>
                                    <th nowrap scope="col" class="border">Sq Ft</th>
                                    <th nowrap scope="col" class="border">{$currency}/Sq Ft</th>
                                    <th nowrap scope="col" class="border">Beds/Baths</th>
                                    <th nowrap scope="col" class="border">DOM</th>
                                </tr>
                                </thead>
                                <tbody class="te-tbody te-font-size-12">
                                {foreach name=priceRed from=$price_red['rs'] item=Record}
                                    {$arrLargestPrice = array_column($Record,'Price_Diff')}
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                            {else}
                                                <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            {/if}
                                        </td>
                                        <td nowrap>
                                            {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                <small>{$Record.Subdivision|lower}</small>
                                            {else}
                                                <small>N/A</small>
                                            {/if}
                                        </td>
                                        <td nowrap>{$currency}{$Record.ListPrice|number_format:0}</td>
                                        <td nowrap>{$currency}{$Record.OriginalListPrice|number_format:0}</td>
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
                                {if is_array($price_red_con['rs']) && count($price_red_con['rs']) > 0}
                                    {foreach name=priceRed from=$price_red_con['rs'] item=Record}
                                        {$arrLargestPrice = array_column($Record,'Price_Diff')}
                                        <tr class="text-left text-capitalize">
                                            <td nowrap>
                                                {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                    <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                                {else}
                                                    <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                                {/if}
                                            </td>
                                            <td nowrap>
                                                {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                    <small>{$Record.Subdivision|lower}</small>
                                                {else}
                                                    <small>N/A</small>
                                                {/if}
                                            </td>
                                            <td nowrap>{$currency}{$Record.ListPrice|number_format:0}</td>
                                            <td nowrap>{$currency}{$Record.OriginalListPrice|number_format:0}</td>
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
                                    {*{else}
                                        No Statistics Available*}
                                {/if}
                                </tbody>
                            </table>
                        </div>
                    </div>
                {else}
                    No Statistics Available
                {/if}
                {if is_array($recent_sales) && count($recent_sales) > 0}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-5">
                        <h4 id="recent_sales" class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4 text-capitalize">Recent Sales</h4>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="table-responsive pt-4">
                            <table class="table te-table-striped- table-hover mb-0">
                                <thead>
                                <tr class="text-left te-font-size-12">
                                    <th nowrap scope="col" class="border">Address</th>
                                    <th nowrap scope="col" class="border">Subdivision</th>
                                    <th nowrap scope="col" class="border">Closed Price</th>
                                    <th nowrap scope="col" class="border">List Price</th>
                                    <th nowrap scope="col" class="border">Price Change</th>
                                    <th nowrap scope="col" class="border">Sq Ft</th>
                                    <th nowrap scope="col" class="border">{$currency}/Sq Ft</th>
                                    <th nowrap scope="col" class="border">Beds/Baths</th>
                                    <th nowrap scope="col" class="border">Closing Date</th>
                                </tr>
                                </thead>

                                <tbody class="te-tbody te-font-size-12">

                                {foreach name=recentSale from=$recent_sales item=Record}

                                    <tr class="text-left">
                                        <td nowrap>
                                            {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                            {else}
                                                <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            {/if}
                                        </td>
                                        <td nowrap>
                                            {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                <small>{$Record.Subdivision|lower}</small>
                                            {else}
                                                <small>N/A</small>
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
                                {if is_array($recent_sales_con) && count($recent_sales_con) > 0}
                                    {foreach name=recentSale from=$recent_sales_con item=Record}
                                        <tr class="text-left">
                                            <td nowrap>
                                                {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                    <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                                {else}
                                                    <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                                {/if}
                                            </td>
                                            <td nowrap>
                                                {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                    <small>{$Record.Subdivision|lower}</small>
                                                {else}
                                                    <small>N/A</small>
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
                                {/if}
                                </tbody>
                            </table>
                        </div>
                    </div>
                {/if}
                {if is_array($rsPending['rs']) && count($rsPending['rs']) > 0}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2 pt-5">
                        <h4 id="under_contract_pending" class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Under Contract/Pending</h4>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="table-responsive pt-4">
                            <table class="table te-table-striped- table-hover mb-0">
                                <thead>
                                <tr class="text-left te-font-size-12">
                                    <th nowrap scope="col" class="border">Address</th>
                                    <th nowrap scope="col" class="border">Subdivision</th>
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
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                            {else}
                                                <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            {/if}
                                        </td>
                                        <td nowrap>
                                            {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                <small>{$Record.Subdivision|lower}</small>
                                            {else}
                                                <small>N/A</small>
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
                                {if is_array($rsPending_con['rs']) && count($rsPending_con['rs']) > 0}
                                    {foreach name=pendinglist from=$rsPending_con['rs'] item=Record}
                                        {$arrPendingPrice = array_column($Record,'Price_Diff')}
                                        <tr class="text-left text-capitalize">
                                            <td nowrap>
                                                {if isset($Record.StreetNumber) && $Record.StreetNumber != '' && isset($Record.StreetName) && $Record.StreetName != ''}
                                                    <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">{$Record.StreetNumber} {$Record.StreetDirPrefix} {$Record.StreetName|lower}{if isset($Record.UnitNo) && $Record.UnitNo != ''}, #{$Record.UnitNo}{/if}</h6></a>
                                                {else}
                                                    <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                                {/if}
                                            </td>
                                            <td nowrap>
                                                {if isset($Record.Subdivision) && $Record.Subdivision != ''}
                                                    <small>{$Record.Subdivision|lower}</small>
                                                {else}
                                                    <small>N/A</small>
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
                                {/if}
                                </tbody>
                            </table>
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</section>
<script>
    var statistic 	= '{$statistic}';
    var cnt 	= '{$count}';
    var monthlyData 	= {$monthlyData|@json_encode};
    var monthlyDataPND 	= {$monthlyDataPND|@json_encode};
    var monthlyDataCLOSD 	= {$monthlyDataCLOSD|@json_encode};
    var monthlyDataLUX 	= {$monthlyDataLUX|@json_encode};
</script>