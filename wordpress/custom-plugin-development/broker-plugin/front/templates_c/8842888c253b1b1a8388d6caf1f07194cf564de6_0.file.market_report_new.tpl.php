<?php
/* Smarty version 4.2.1, created on 2023-08-12 05:12:22
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/market_report_new.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d75b06a86759_16600467',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8842888c253b1b1a8388d6caf1f07194cf564de6' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/market_report_new.tpl',
      1 => 1676053538,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d75b06a86759_16600467 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/function.math.php','function'=>'smarty_function_math',),));
?>
<section id="te-new-market-report-container" class="py-5  ">
    <div class="market_insights">
        <h2  class="title-font text-left"> Miami Beach Real Estate Market Overview</h2>
        <p class="market-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <div id="chart-main-section">

            <div class="row">
                <div class="col-xxl-9 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12 market_chart">
                    <h3 id="market_insights_head" class="chart-head title-font text-left text-border-bottom pt-4 pb-3">Market Insights</h3>
                    <div class="row">
                        <?php if ((isset($_smarty_tpl->tpl_vars['PreSearch']->value)) && $_smarty_tpl->tpl_vars['PreSearch']->value == true) {?>
                            <div class="single-home-count">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="pt-4 text-center">Single Family Homes</p>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="p-3 h4"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['preTotCount']->value,0);?>
</p>
                                </div>
                            </div>
                        <?php }?>
                        <?php if ((isset($_smarty_tpl->tpl_vars['ConSearch']->value)) && 'ConSearch' == true) {?>
                            <div class="condo-count">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="pt-4 text-center">Condos</p>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="p-3 text-center h4"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['conTotCount']->value,0);?>
</p>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                            <canvas id="market_insights" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                    </div>
                                        <h3 id="avaiable_sale_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3 avaiable_sale">Available For sale</h3>
                    <p class="market-text">In comparision with sale prices last month, list price of Single Family homes <?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
$_prefixVariable1 = ob_get_clean();
if ($_prefixVariable1 > 0) {?>increased <?php } else { ?> decreased <?php }?> by <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 whereas, list price of Condos <?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
$_prefixVariable2 = ob_get_clean();
if ($_prefixVariable2 > 0) {?>increased <?php } else { ?> decreased <?php }?> by <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="avaiable_sale" class="graph-chart chartjs-render-monitor"></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            <?php if ((isset($_smarty_tpl->tpl_vars['PreSearch']->value)) && $_smarty_tpl->tpl_vars['PreSearch']->value == true) {?>
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active Listings:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStatic']->value['statistic_total_active_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['total_listing'];
$_prefixVariable3 = ob_get_clean();
if ($_prefixVariable3 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['total_listing'];?>
 mo</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['total_listing'];
$_prefixVariable4 = ob_get_clean();
if ($_prefixVariable4 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_avg_active_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
$_prefixVariable5 = ob_get_clean();
if ($_prefixVariable5 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_price'];
$_prefixVariable6 = ob_get_clean();
if ($_prefixVariable6 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_avg_active_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price_sqft'];
$_prefixVariable7 = ob_get_clean();
if ($_prefixVariable7 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_price_sqft'];
$_prefixVariable8 = ob_get_clean();
if ($_prefixVariable8 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStatic']->value['statistic_avg_active_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_dom'];
$_prefixVariable9 = ob_get_clean();
if ($_prefixVariable9 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_dom'];
$_prefixVariable10 = ob_get_clean();
if ($_prefixVariable10 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                            <br>
                            <?php if ((isset($_smarty_tpl->tpl_vars['ConSearch']->value)) && 'ConSearch' == true) {?>
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active Listings:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_total_active_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['total_listing'];
$_prefixVariable11 = ob_get_clean();
if ($_prefixVariable11 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['total_listing'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['total_listing'];
$_prefixVariable12 = ob_get_clean();
if ($_prefixVariable12 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_active_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
$_prefixVariable13 = ob_get_clean();
if ($_prefixVariable13 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_price'];
$_prefixVariable14 = ob_get_clean();
if ($_prefixVariable14 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_active_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price_sqft'];
$_prefixVariable15 = ob_get_clean();
if ($_prefixVariable15 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_price_sqft'];
$_prefixVariable16 = ob_get_clean();
if ($_prefixVariable16 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_active_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_dom'];
$_prefixVariable17 = ob_get_clean();
if ($_prefixVariable17 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_dom'];
$_prefixVariable18 = ob_get_clean();
if ($_prefixVariable18 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                        </div>
                    </div>
                                        <h3 id="pricesqft_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Price Per Square Foot</h3>
                    <p class="market-text">In comparision with sale prices last month, list price of Single Family homes <?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
$_prefixVariable19 = ob_get_clean();
if ($_prefixVariable19 > 0) {?>increased <?php } else { ?> decreased <?php }?> by <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 whereas, list price of Condos <?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
$_prefixVariable20 = ob_get_clean();
if ($_prefixVariable20 > 0) {?>increased <?php } else { ?> decreased <?php }?> by <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="pricesqft_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            <?php if ((isset($_smarty_tpl->tpl_vars['PreSearch']->value)) && $_smarty_tpl->tpl_vars['PreSearch']->value == true) {?>
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active :
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_avg_active_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
$_prefixVariable21 = ob_get_clean();
if ($_prefixVariable21 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_price'];
$_prefixVariable22 = ob_get_clean();
if ($_prefixVariable22 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Pending :
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticPND']->value['statistic_avg_pending_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_price'];
$_prefixVariable23 = ob_get_clean();
if ($_prefixVariable23 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_price'];
$_prefixVariable24 = ob_get_clean();
if ($_prefixVariable24 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Sold :
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticCLOSD']->value['statistic_six_month_avg_sold_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_price'];
$_prefixVariable25 = ob_get_clean();
if ($_prefixVariable25 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_price'];
$_prefixVariable26 = ob_get_clean();
if ($_prefixVariable26 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                            <br>
                            <?php if ((isset($_smarty_tpl->tpl_vars['ConSearch']->value)) && 'ConSearch' == true) {?>
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Active :
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_active_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
$_prefixVariable27 = ob_get_clean();
if ($_prefixVariable27 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_price'];
$_prefixVariable28 = ob_get_clean();
if ($_prefixVariable28 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Pending :
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_pending_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_price'];
$_prefixVariable29 = ob_get_clean();
if ($_prefixVariable29 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_price'];
$_prefixVariable30 = ob_get_clean();
if ($_prefixVariable30 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Sold :
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_six_month_avg_sold_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_price'];
$_prefixVariable31 = ob_get_clean();
if ($_prefixVariable31 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_price'];
$_prefixVariable32 = ob_get_clean();
if ($_prefixVariable32 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                        </div>
                    </div>
                                        <h3 id="price_adjust_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Price Adjustments</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-7 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="price_adjust" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-5 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            <?php if ((isset($_smarty_tpl->tpl_vars['PreSearch']->value)) && $_smarty_tpl->tpl_vars['PreSearch']->value == true) {?>
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Active):
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_largest_price_reduction'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['lg_price_red'];
$_prefixVariable33 = ob_get_clean();
if ($_prefixVariable33 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['lg_price_red'];
$_prefixVariable34 = ob_get_clean();
if ($_prefixVariable34 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>"> / <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Active):
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_largest_price_increase'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['lg_price_inc'];
$_prefixVariable35 = ob_get_clean();
if ($_prefixVariable35 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['MNT']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['lg_price_inc'];
$_prefixVariable36 = ob_get_clean();
if ($_prefixVariable36 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreSaleActive']->value['YR']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Pending):
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_pending_largest_price_reduction'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['lg_price_red'];
$_prefixVariable37 = ob_get_clean();
if ($_prefixVariable37 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['lg_price_red'];
$_prefixVariable38 = ob_get_clean();
if ($_prefixVariable38 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Pending):
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_pending_largest_price_increase'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['lg_price_inc'];
$_prefixVariable39 = ob_get_clean();
if ($_prefixVariable39 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['lg_price_inc'];
$_prefixVariable40 = ob_get_clean();
if ($_prefixVariable40 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Sold):
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_six_month_sold_largest_price_reduction'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['lg_price_red'];
$_prefixVariable41 = ob_get_clean();
if ($_prefixVariable41 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['lg_price_red'];
$_prefixVariable42 = ob_get_clean();
if ($_prefixVariable42 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Sold):
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_six_month_sold_largest_price_increase'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['lg_price_inc'];
$_prefixVariable43 = ob_get_clean();
if ($_prefixVariable43 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['lg_price_inc'];
$_prefixVariable44 = ob_get_clean();
if ($_prefixVariable44 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                            <br>
                            <?php if ((isset($_smarty_tpl->tpl_vars['ConSearch']->value)) && 'ConSearch' == true) {?>
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Active):
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_largest_price_reduction'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['lg_price_red'];
$_prefixVariable45 = ob_get_clean();
if ($_prefixVariable45 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['lg_price_red'];
$_prefixVariable46 = ob_get_clean();
if ($_prefixVariable46 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Active):
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_largest_price_increase'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['lg_price_inc'];
$_prefixVariable47 = ob_get_clean();
if ($_prefixVariable47 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['MNT']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['lg_price_inc'];
$_prefixVariable48 = ob_get_clean();
if ($_prefixVariable48 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConSaleActive']->value['YR']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Pending):
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_pending_largest_price_reduction'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['lg_price_red'];
$_prefixVariable49 = ob_get_clean();
if ($_prefixVariable49 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['lg_price_red'];
$_prefixVariable50 = ob_get_clean();
if ($_prefixVariable50 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Pending):
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_pending_largest_price_increase'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['lg_price_inc'];
$_prefixVariable51 = ob_get_clean();
if ($_prefixVariable51 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['lg_price_inc'];
$_prefixVariable52 = ob_get_clean();
if ($_prefixVariable52 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Reduction(Sold):
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_six_month_sold_largest_price_reduction'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['lg_price_red'];
$_prefixVariable53 = ob_get_clean();
if ($_prefixVariable53 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['lg_price_red'];
$_prefixVariable54 = ob_get_clean();
if ($_prefixVariable54 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['lg_price_red'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Largest Increase(Sold):
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStatic']->value['statistic_six_month_sold_largest_price_increase'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['lg_price_inc'];
$_prefixVariable55 = ob_get_clean();
if ($_prefixVariable55 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['lg_price_inc'];
$_prefixVariable56 = ob_get_clean();
if ($_prefixVariable56 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['lg_price_inc'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                        </div>
                    </div>
                                        <h3 id="pending_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Pending</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="pending_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            <?php if ((isset($_smarty_tpl->tpl_vars['PreSearch']->value)) && $_smarty_tpl->tpl_vars['PreSearch']->value == true) {?>
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Pending Listings:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStaticPND']->value['statistic_total_pending_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['total_listing'];
$_prefixVariable57 = ob_get_clean();
if ($_prefixVariable57 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['total_listing'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['total_listing'];
$_prefixVariable58 = ob_get_clean();
if ($_prefixVariable58 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticPND']->value['statistic_avg_pending_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_price'];
$_prefixVariable59 = ob_get_clean();
if ($_prefixVariable59 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_price'];
$_prefixVariable60 = ob_get_clean();
if ($_prefixVariable60 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticPND']->value['statistic_avg_pending_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_price_sqft'];
$_prefixVariable61 = ob_get_clean();
if ($_prefixVariable61 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_price_sqft'];
$_prefixVariable62 = ob_get_clean();
if ($_prefixVariable62 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStaticPND']->value['statistic_avg_pending_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_dom'];
$_prefixVariable63 = ob_get_clean();
if ($_prefixVariable63 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PrePending']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_dom'];
$_prefixVariable64 = ob_get_clean();
if ($_prefixVariable64 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PrePending']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                            <br>
                            <?php if ((isset($_smarty_tpl->tpl_vars['ConSearch']->value)) && 'ConSearch' == true) {?>
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Pending Listings:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_total_pending_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['total_listing'];
$_prefixVariable65 = ob_get_clean();
if ($_prefixVariable65 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['total_listing'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['total_listing'];
$_prefixVariable66 = ob_get_clean();
if ($_prefixVariable66 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_pending_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_price'];
$_prefixVariable67 = ob_get_clean();
if ($_prefixVariable67 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_price'];
$_prefixVariable68 = ob_get_clean();
if ($_prefixVariable68 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_pending_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_price_sqft'];
$_prefixVariable69 = ob_get_clean();
if ($_prefixVariable69 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_price_sqft'];
$_prefixVariable70 = ob_get_clean();
if ($_prefixVariable70 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_avg_pending_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_dom'];
$_prefixVariable71 = ob_get_clean();
if ($_prefixVariable71 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConPending']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_dom'];
$_prefixVariable72 = ob_get_clean();
if ($_prefixVariable72 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConPending']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                        </div>
                    </div>
                                        <h3 id="sold_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Sold</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        
                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="sold_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            <?php if ((isset($_smarty_tpl->tpl_vars['PreSearch']->value)) && $_smarty_tpl->tpl_vars['PreSearch']->value == true) {?>
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Sold Listings:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStaticCLOSD']->value['statistic_total_sold_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['total_listing'];
$_prefixVariable73 = ob_get_clean();
if ($_prefixVariable73 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['total_listing'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['total_listing'];
$_prefixVariable74 = ob_get_clean();
if ($_prefixVariable74 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticCLOSD']->value['statistic_six_month_avg_sold_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_price'];
$_prefixVariable75 = ob_get_clean();
if ($_prefixVariable75 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_price'];
$_prefixVariable76 = ob_get_clean();
if ($_prefixVariable76 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticCLOSD']->value['statistic_six_month_avg_sold_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_price_sqft'];
$_prefixVariable77 = ob_get_clean();
if ($_prefixVariable77 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_price_sqft'];
$_prefixVariable78 = ob_get_clean();
if ($_prefixVariable78 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStaticCLOSD']->value['statistic_six_month_avg_sold_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_dom'];
$_prefixVariable79 = ob_get_clean();
if ($_prefixVariable79 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_dom'];
$_prefixVariable80 = ob_get_clean();
if ($_prefixVariable80 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="pre-fields"><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['PreStaticCLOSD']->value['statistic_listing_discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['discount'];
$_prefixVariable81 = ob_get_clean();
if ($_prefixVariable81 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['PreClosed']->value['MNT']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosed']->value['YR']['discount'];
$_prefixVariable82 = ob_get_clean();
if ($_prefixVariable82 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['PreClosed']->value['YR']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                            <br>
                            <?php if ((isset($_smarty_tpl->tpl_vars['ConSearch']->value)) && 'ConSearch' == true) {?>
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Sold Listings:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_total_sold_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['total_listing'];
$_prefixVariable83 = ob_get_clean();
if ($_prefixVariable83 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['total_listing'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['total_listing'];
$_prefixVariable84 = ob_get_clean();
if ($_prefixVariable84 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_six_month_avg_sold_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_price'];
$_prefixVariable85 = ob_get_clean();
if ($_prefixVariable85 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_price'];
$_prefixVariable86 = ob_get_clean();
if ($_prefixVariable86 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_six_month_avg_sold_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_price_sqft'];
$_prefixVariable87 = ob_get_clean();
if ($_prefixVariable87 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_price_sqft'];
$_prefixVariable88 = ob_get_clean();
if ($_prefixVariable88 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_six_month_avg_sold_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_dom'];
$_prefixVariable89 = ob_get_clean();
if ($_prefixVariable89 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_dom'];
$_prefixVariable90 = ob_get_clean();
if ($_prefixVariable90 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="con-fields"><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['ConStatic']->value['statistic_listing_discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['discount'];
$_prefixVariable91 = ob_get_clean();
if ($_prefixVariable91 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['ConClosed']->value['MNT']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosed']->value['YR']['discount'];
$_prefixVariable92 = ob_get_clean();
if ($_prefixVariable92 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['ConClosed']->value['YR']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                        </div>
                    </div>
                                        <h3 id="sold_lux_chart_head" class="txt-heading title-font text-left text-border-bottom pt-5 pb-3">Sold - Luxury</h3>
                    <p class="market-text">In a month, on an average, 13 drops in Single  Family homes and 117 price drops in Condos are onserved.</p>

                    <div class="row ">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 market_chart_head">
                            <canvas id="sold_lux_chart" class="graph-chart chartjs-render-monitor" ></canvas>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 market_chart_info">
                            <?php if ((isset($_smarty_tpl->tpl_vars['PreSearch']->value)) && $_smarty_tpl->tpl_vars['PreSearch']->value == true) {?>
                                <div class="chart-content-box mt-md-0 pre">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Single family Home
                                    </p>
                                </div><hr class="market">
                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class="">Sold Listings:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStaticLUX']->value['statistic_total_sold_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['total_listing'];
$_prefixVariable93 = ob_get_clean();
if ($_prefixVariable93 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['total_listing'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['total_listing'];
$_prefixVariable94 = ob_get_clean();
if ($_prefixVariable94 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticLUX']->value['statistic_six_month_avg_sold_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['avg_price'];
$_prefixVariable95 = ob_get_clean();
if ($_prefixVariable95 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['avg_price'];
$_prefixVariable96 = ob_get_clean();
if ($_prefixVariable96 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class=""> Avg Price/Sqft:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['PreStaticLUX']->value['statistic_six_month_avg_sold_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['avg_price_sqft'];
$_prefixVariable97 = ob_get_clean();
if ($_prefixVariable97 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['avg_price_sqft'];
$_prefixVariable98 = ob_get_clean();
if ($_prefixVariable98 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="pre-fields"><?php echo $_smarty_tpl->tpl_vars['PreStaticLUX']->value['statistic_six_month_avg_sold_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['avg_dom'];
$_prefixVariable99 = ob_get_clean();
if ($_prefixVariable99 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['avg_dom'];
$_prefixVariable100 = ob_get_clean();
if ($_prefixVariable100 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="pre-fields"><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['PreStaticLUX']->value['statistic_listing_discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['discount'];
$_prefixVariable101 = ob_get_clean();
if ($_prefixVariable101 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['PreClosedLux']->value['MNT']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['discount'];
$_prefixVariable102 = ob_get_clean();
if ($_prefixVariable102 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['PreClosedLux']->value['YR']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                            <br>
                            <?php if ((isset($_smarty_tpl->tpl_vars['ConSearch']->value)) && 'ConSearch' == true) {?>
                                <div class="chart-content-box mt-md-0 con">
                                    <p class="chart-content mt-1 mb-md-3 mb-2 font-weight-bold">
                                        Condos
                                    </p>
                                </div><hr class="market">

                                <ul class="list-group border-0">
                                    <li class="border-0">
                                        <a class=""> Sold Listings:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_total_sold_listing'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['total_listing'];
$_prefixVariable103 = ob_get_clean();
if ($_prefixVariable103 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['total_listing'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['total_listing'];
$_prefixVariable104 = ob_get_clean();
if ($_prefixVariable104 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['total_listing'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg List Price:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_six_month_avg_sold_price'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['avg_price'];
$_prefixVariable105 = ob_get_clean();
if ($_prefixVariable105 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['avg_price'];
$_prefixVariable106 = ob_get_clean();
if ($_prefixVariable106 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['avg_price'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Price/Sqft:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['ConStatic']->value['statistic_six_month_avg_sold_price_sqft'],0);?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['avg_price_sqft'];
$_prefixVariable107 = ob_get_clean();
if ($_prefixVariable107 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['avg_price_sqft'];
$_prefixVariable108 = ob_get_clean();
if ($_prefixVariable108 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['avg_price_sqft'];
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Avg Days On Market:
                                            <span class="con-fields"><?php echo $_smarty_tpl->tpl_vars['ConStatic']->value['statistic_six_month_avg_sold_dom'];?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['avg_dom'];
$_prefixVariable109 = ob_get_clean();
if ($_prefixVariable109 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['avg_dom'];?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['avg_dom'];
$_prefixVariable110 = ob_get_clean();
if ($_prefixVariable110 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['avg_dom'];?>
 yr)</span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="">Listing Discount:
                                            <span class="con-fields"><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['ConStatic']->value['statistic_listing_discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
</span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['discount'];
$_prefixVariable111 = ob_get_clean();
if ($_prefixVariable111 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">(<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['ConClosedLux']->value['MNT']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 mo </span>
                                            <span class="<?php ob_start();
echo $_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['discount'];
$_prefixVariable112 = ob_get_clean();
if ($_prefixVariable112 > 0) {?>text-success<?php } else { ?>text-danger<?php }?>">/ <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['ConClosedLux']->value['YR']['discount']);
echo $_smarty_tpl->tpl_vars['percnt']->value;?>
 yr)</span></a>
                                    </li>
                                </ul>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 market-info">
                    <div class="section-nav ">
                        <div>
                            <a class="font-weight-bold" >Market Overview</a>
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 pt-5">
                    <h4 id="price_reduce_by_price" class="title-font text-left te-market-title text-border-bottom txt-heading heading_txt_color pb-4">Largest Price Reductions By Price</h4>
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
                                <th nowrap scope="col" class="border"><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
/Sq Ft</th>
                                <th nowrap scope="col" class="border">Beds/Baths</th>
                                <th nowrap scope="col" class="border">DOM</th>
                            </tr>
                            </thead>
                            <tbody class="te-tbody te-font-size-12">
                            <?php if (is_array($_smarty_tpl->tpl_vars['price_red_ByPrice']->value['rs']) && count($_smarty_tpl->tpl_vars['price_red_ByPrice']->value['rs']) > 0) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['price_red_ByPrice']->value['rs'], 'Record', false, NULL, 'priceRed', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                                    <?php $_smarty_tpl->_assignInScope('arrLargestPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                            <?php } else { ?>
                                                <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            <?php }?>
                                        </td>
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                            <?php } else { ?>
                                                <small>N/A</small>
                                            <?php }?>
                                        </td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice'],0);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],0);?>
</td>
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable113 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable113);?>
                                        <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 </td>
                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
                                        <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable114 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable114);?>
                                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
                                        <?php } else { ?>
                                            <td nowrap>0</td>

                                        <?php }?>

                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                                    </tr>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                                No Statistics Available for Single Family Home
                            <?php }?>
                            <?php if (is_array($_smarty_tpl->tpl_vars['price_red_ByPrice_con']->value['rs']) && count($_smarty_tpl->tpl_vars['price_red_ByPrice_con']->value['rs']) > 0) {?>
                                <br>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['price_red_ByPrice_con']->value['rs'], 'Record', false, NULL, 'priceRed', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                                    <?php $_smarty_tpl->_assignInScope('arrLargestPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                            <?php } else { ?>
                                                <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            <?php }?>
                                        </td>
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                            <?php } else { ?>
                                                <small>N/A</small>
                                            <?php }?>
                                        </td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice'],0);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],0);?>
</td>
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable115 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable115);?>
                                        <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 </td>
                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
                                        <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable116 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable116);?>
                                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
                                        <?php } else { ?>
                                            <td nowrap>0</td>

                                        <?php }?>

                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                                    </tr>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                                No Statistics Available for Condos
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                                <?php if (is_array($_smarty_tpl->tpl_vars['price_red']->value['rs']) && count($_smarty_tpl->tpl_vars['price_red']->value['rs']) > 0) {?>
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
                                    <th nowrap scope="col" class="border"><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
/Sq Ft</th>
                                    <th nowrap scope="col" class="border">Beds/Baths</th>
                                    <th nowrap scope="col" class="border">DOM</th>
                                </tr>
                                </thead>
                                <tbody class="te-tbody te-font-size-12">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['price_red']->value['rs'], 'Record', false, NULL, 'priceRed', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                                    <?php $_smarty_tpl->_assignInScope('arrLargestPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                            <?php } else { ?>
                                                <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            <?php }?>
                                        </td>
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                            <?php } else { ?>
                                                <small>N/A</small>
                                            <?php }?>
                                        </td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice'],0);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],0);?>
</td>
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable117 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable117);?>
                                        <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
                                        <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable118 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable118);?>
                                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
                                        <?php } else { ?>
                                            <td nowrap>0</td>
                                        <?php }?>
                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                                    </tr>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php if (is_array($_smarty_tpl->tpl_vars['price_red_con']->value['rs']) && count($_smarty_tpl->tpl_vars['price_red_con']->value['rs']) > 0) {?>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['price_red_con']->value['rs'], 'Record', false, NULL, 'priceRed', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                                        <?php $_smarty_tpl->_assignInScope('arrLargestPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
                                        <tr class="text-left text-capitalize">
                                            <td nowrap>
                                                <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                    <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                                <?php } else { ?>
                                                    <a href="#" class="text-"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                                <?php }?>
                                            </td>
                                            <td nowrap>
                                                <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                    <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                                <?php } else { ?>
                                                    <small>N/A</small>
                                                <?php }?>
                                            </td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice'],0);?>
</td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],0);?>
</td>
                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable119 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable119);?>
                                            <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                                            <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
                                            <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable120 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable120);?>
                                                <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
                                            <?php } else { ?>
                                                <td nowrap>0</td>

                                            <?php }?>

                                            <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                                        </tr>
                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    No Statistics Available
                <?php }?>
                <?php if (is_array($_smarty_tpl->tpl_vars['recent_sales']->value) && count($_smarty_tpl->tpl_vars['recent_sales']->value) > 0) {?>
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
                                    <th nowrap scope="col" class="border"><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
/Sq Ft</th>
                                    <th nowrap scope="col" class="border">Beds/Baths</th>
                                    <th nowrap scope="col" class="border">Closing Date</th>
                                </tr>
                                </thead>

                                <tbody class="te-tbody te-font-size-12">

                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recent_sales']->value, 'Record', false, NULL, 'recentSale', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>

                                    <tr class="text-left">
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                            <?php } else { ?>
                                                <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            <?php }?>
                                        </td>
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                            <?php } else { ?>
                                                <small>N/A</small>
                                            <?php }?>
                                        </td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['Sold_Price']),$_smarty_tpl);
$_prefixVariable121 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable121);?>
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"(z)*100*(a)/p",'z'=>$_smarty_tpl->tpl_vars['pricedef']->value,'p'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'a'=>-1),$_smarty_tpl);
$_prefixVariable122 = ob_get_clean();
$_smarty_tpl->_assignInScope('difference', $_prefixVariable122);?>

                                        <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['difference']->value >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['difference']->value,2);?>
%)</td>
                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>

                                        <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['Sold_Price'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable123 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable123);?>
                                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);?>

                                                <?php } else { ?>0<?php }?></td>
                                        <?php } else { ?>
                                            <td nowrap>0</td>

                                        <?php }?>
                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                                    </tr>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php if (is_array($_smarty_tpl->tpl_vars['recent_sales_con']->value) && count($_smarty_tpl->tpl_vars['recent_sales_con']->value) > 0) {?>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recent_sales_con']->value, 'Record', false, NULL, 'recentSale', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                                        <tr class="text-left">
                                            <td nowrap>
                                                <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                    <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                                <?php } else { ?>
                                                    <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                                <?php }?>
                                            </td>
                                            <td nowrap>
                                                <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                    <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                                <?php } else { ?>
                                                    <small>N/A</small>
                                                <?php }?>
                                            </td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Sold_Price']);?>
</td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['Sold_Price']),$_smarty_tpl);
$_prefixVariable124 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable124);?>
                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"(z)*100*(a)/p",'z'=>$_smarty_tpl->tpl_vars['pricedef']->value,'p'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'a'=>-1),$_smarty_tpl);
$_prefixVariable125 = ob_get_clean();
$_smarty_tpl->_assignInScope('difference', $_prefixVariable125);?>

                                            <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['difference']->value >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['difference']->value,2);?>
%)</td>
                                            <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>

                                            <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['Sold_Price'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable126 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable126);?>
                                                <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);?>

                                                    <?php } else { ?>0<?php }?></td>
                                            <?php } else { ?>
                                                <td nowrap>0</td>

                                            <?php }?>
                                            <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['Sold_Date'];?>
</td>
                                        </tr>
                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }?>
                <?php if (is_array($_smarty_tpl->tpl_vars['rsPending']->value['rs']) && count($_smarty_tpl->tpl_vars['rsPending']->value['rs']) > 0) {?>
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
                                    <th nowrap scope="col" class="border"><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
/Sq Ft</th>
                                    <th nowrap scope="col" class="border">Beds/Baths</th>
                                    <th nowrap scope="col" class="border">Days Listed</th>
                                </tr>
                                </thead>
                                <tbody class="te-tbody">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsPending']->value['rs'], 'Record', false, NULL, 'pendinglist', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                                    <?php $_smarty_tpl->_assignInScope('arrPendingPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
                                    <tr class="text-left text-capitalize">
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                            <?php } else { ?>
                                                <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                            <?php }?>
                                        </td>
                                        <td nowrap>
                                            <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                            <?php } else { ?>
                                                <small>N/A</small>
                                            <?php }?>
                                        </td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                                        <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable127 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable127);?>
                                        <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
                                        <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable128 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable128);?>
                                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
                                        <?php } else { ?>
                                            <td nowrap>0</td>

                                        <?php }?>

                                        <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                        <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                                    </tr>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php if (is_array($_smarty_tpl->tpl_vars['rsPending_con']->value['rs']) && count($_smarty_tpl->tpl_vars['rsPending_con']->value['rs']) > 0) {?>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsPending_con']->value['rs'], 'Record', false, NULL, 'pendinglist', array (
));
$_smarty_tpl->tpl_vars['Record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['Record']->value) {
$_smarty_tpl->tpl_vars['Record']->do_else = false;
?>
                                        <?php $_smarty_tpl->_assignInScope('arrPendingPrice', array_column($_smarty_tpl->tpl_vars['Record']->value,'Price_Diff'));?>
                                        <tr class="text-left text-capitalize">
                                            <td nowrap>
                                                <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['StreetNumber'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'] != '' && (isset($_smarty_tpl->tpl_vars['Record']->value['StreetName'])) && $_smarty_tpl->tpl_vars['Record']->value['StreetName'] != '') {?>
                                                    <a href="<?php echo Utility::formatListingUrl($_smarty_tpl->tpl_vars['arrConfig']->value[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$_smarty_tpl->tpl_vars['Record']->value);?>
" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12"><?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetNumber'];?>
 <?php echo $_smarty_tpl->tpl_vars['Record']->value['StreetDirPrefix'];?>
 <?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['StreetName'], 'UTF-8');
if ((isset($_smarty_tpl->tpl_vars['Record']->value['UnitNo'])) && $_smarty_tpl->tpl_vars['Record']->value['UnitNo'] != '') {?>, #<?php echo $_smarty_tpl->tpl_vars['Record']->value['UnitNo'];
}?></h6></a>
                                                <?php } else { ?>
                                                    <a href="#" class="text-dark"><h6 class="my-0 pb-0 te-font-size-12">Address Not Available</h6></a>
                                                <?php }?>
                                            </td>
                                            <td nowrap>
                                                <?php if ((isset($_smarty_tpl->tpl_vars['Record']->value['Subdivision'])) && $_smarty_tpl->tpl_vars['Record']->value['Subdivision'] != '') {?>
                                                    <small><?php echo mb_strtolower($_smarty_tpl->tpl_vars['Record']->value['Subdivision'], 'UTF-8');?>
</small>
                                                <?php } else { ?>
                                                    <small>N/A</small>
                                                <?php }?>
                                            </td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['ListPrice']);?>
</td>
                                            <?php ob_start();
echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['OriginalListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice']),$_smarty_tpl);
$_prefixVariable129 = ob_get_clean();
$_smarty_tpl->_assignInScope('pricedef', $_prefixVariable129);?>
                                            <td nowrap class="<?php if ($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format(str_replace('-','',$_smarty_tpl->tpl_vars['pricedef']->value));?>
 (<?php echo round($_smarty_tpl->tpl_vars['Record']->value['Price_Diff'],2);?>
%)</td>
                                            <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']);?>
</td>
                                            <?php if (smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['SQFT']) != 0) {?>

                                                <?php ob_start();
echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['Record']->value['ListPrice'],'y'=>$_smarty_tpl->tpl_vars['Record']->value['SQFT']),$_smarty_tpl);
$_prefixVariable130 = ob_get_clean();
$_smarty_tpl->_assignInScope('pripsqft', $_prefixVariable130);?>
                                                <td nowrap><?php if ($_smarty_tpl->tpl_vars['Record']->value['SQFT'] > 0) {
echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['pripsqft']->value);
} else { ?>0<?php }?></td>
                                            <?php } else { ?>
                                                <td nowrap>0</td>

                                            <?php }?>

                                            <td nowrap><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['Beds']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsFull']);?>
 / <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['Record']->value['BathsHalf']);?>
</td>
                                            <td nowrap><?php echo $_smarty_tpl->tpl_vars['Record']->value['DOM'];?>
</td>
                                        </tr>
                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</section>
<?php echo '<script'; ?>
>
    var statistic 	= '<?php echo $_smarty_tpl->tpl_vars['statistic']->value;?>
';
    var cnt 	= '<?php echo $_smarty_tpl->tpl_vars['count']->value;?>
';
    var monthlyData 	= <?php echo json_encode($_smarty_tpl->tpl_vars['monthlyData']->value);?>
;
    var monthlyDataPND 	= <?php echo json_encode($_smarty_tpl->tpl_vars['monthlyDataPND']->value);?>
;
    var monthlyDataCLOSD 	= <?php echo json_encode($_smarty_tpl->tpl_vars['monthlyDataCLOSD']->value);?>
;
    var monthlyDataLUX 	= <?php echo json_encode($_smarty_tpl->tpl_vars['monthlyDataLUX']->value);?>
;
<?php echo '</script'; ?>
><?php }
}
