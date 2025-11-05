<?php
/* Smarty version 4.2.1, created on 2023-10-07 09:47:46
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/market_report_shortcode.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65216f92bf2e83_89524502',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aea265f34a99b6cf8aad72015dd9d0a304e2bdde' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/market_report_shortcode.tpl',
      1 => 1668793252,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65216f92bf2e83_89524502 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
?>
<section id="te-market-report-container" class="px-xl-5 te-font-family">
    <div class="container-fluid con-mar- te-market-report-container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 offset-xl-1-">
                <?php if (is_array($_smarty_tpl->tpl_vars['statistic']->value) && count($_smarty_tpl->tpl_vars['statistic']->value) > 0) {?>
                                        <div class="row pt-3- market-statistics text-dark- <?php if ($_smarty_tpl->tpl_vars['attr']->value['background'] == 'dark') {?> pre_market_text_dark<?php } else { ?>pre_market_text_light<?php }?>">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1- pr-xl-3">
                            <h3 class="title-font text-center te-market-title- text-border-bottom pt-4 pb-4 <?php if ($_smarty_tpl->tpl_vars['attr']->value['background'] == 'dark') {?> pre_market_text_dark<?php } else { ?>pre_market_text_light<?php }?>">For Sale</h3>
                            <ul class="p-0 pt-3  px-0">
                                <li class="d-flex col-12 justify-content-between text-center  pb-3 pt-3  px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Active For Sale</span><span class="font-weight-bold col-5 border-bottom px-0 px-0"><?php echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_total_active_listing'];?>
</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Average Price</span><span class="font-weight-bold col-5 border-bottom px-0 px-0"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_price']);?>
</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Average Price / SqFt</span><span class="font-weight-bold col-5 border-bottom px-0 px-0"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_price_sqft']);?>
</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Average Days on Market</span><span class="font-weight-bold col-5 border-bottom px-0 px-0"><?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_dom']) {
echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_active_dom'];
} else { ?>-<?php }?></span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Largest Price Reduction</span><span class="font-weight-bold col-5 border-bottom px-0 <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_reduction']);?>
 </span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0 px-0"><span class="col-6 border-bottom mr-4 px-0">Largest Price Increase</span><span class="font-weight-bold col-5 border-bottom px-0 <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_diff_increase'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_price_increase']);?>
 </span></li>
                                                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1- px-xl-3">
                            <h3 class="title-font text-center te-market-title- text-border-bottom pt-4 pb-4 <?php if ($_smarty_tpl->tpl_vars['attr']->value['background'] == 'dark') {?> pre_market_text_dark<?php } else { ?>pre_market_text_light<?php }?>">Pending Sales</h3>
                            <ul class="p-0 pt-3">
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Pending Sales</span><span class="font-weight-bold col-5 border-bottom px-0"><?php echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_total_pending_listing'];?>
</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Price</span><span class="font-weight-bold col-5 border-bottom px-0"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_price']);?>
</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Price / SqFt</span><span class="font-weight-bold col-5 border-bottom px-0"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_price_sqft']);?>
</span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Days on Market</span><span class="font-weight-bold col-5 border-bottom px-0"><?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_dom'] > 0) {
echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_avg_pending_dom'];
} else { ?>-<?php }?></span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Reduction</span><span class="font-weight-bold col-5 border-bottom  px-0 <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_pending_price_diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_pending_largest_price_reduction']);?>
 </span></li>
                                <li class="d-flex col-12 justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Increase</span><span class="font-weight-bold col-5 border-bottom  px-0 <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_pending_price_diff_increase'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_pending_largest_price_increase']);?>
 </span></li>
                                                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pt-1- pl-xl-3">
                            <h3 class="title-font text-center te-market-title- text-border-bottom pt-4 pb-4 <?php if ($_smarty_tpl->tpl_vars['attr']->value['background'] == 'dark') {?> pre_market_text_dark<?php } else { ?>pre_market_text_light<?php }?>">Closed Sales</h3>
                            <ul class="p-0 pt-3">
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Sold (Last 180 Days)</span><span class="font-weight-bold col-5 px-0 border-bottom"><?php echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_sixmon_tot_sold_listing'];?>
</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4" >Average Price</span><span class="font-weight-bold col-5 px-0 border-bottom"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_price']);?>
</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Price / SqFt</span><span class="font-weight-bold col-5 px-0 border-bottom"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_price_sqft']);?>
</span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Average Days on Market</span><span class="font-weight-bold col-5 px-0 border-bottom"><?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_dom'] > 0) {
echo $_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_avg_sold_dom'];
} else { ?>-<?php }?></span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Reduction</span><span class="font-weight-bold col-5 px-0 border-bottom <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_sold_price_diff'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_sold_largest_price_reduction']);?>
 </span></li>
                                <li class="d-flex justify-content-between text-center pb-3 pt-3 px-0"><span class="col-6 px-0 border-bottom mr-4">Largest Price Increase</span><span class="font-weight-bold col-5 px-0 border-bottom <?php if ($_smarty_tpl->tpl_vars['statistic']->value['statistic_largest_sold_price_diff_increase'] >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['currency']->value;
echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['statistic']->value['statistic_six_month_sold_largest_price_increase']);?>
 </span></li>
                                                            </ul>
                        </div>
                    </div>

                <?php } else { ?>
                    No Statistics Available 
                <?php }?>
            </div>
        </div>
    </div>
</section>
<?php if ($_smarty_tpl->tpl_vars['pid']->value != '') {?>
    <input type="hidden" class="pid" id="pid" name="pid" value="<?php echo $_smarty_tpl->tpl_vars['pid']->value;?>
">
<input type="hidden" class="json_bg" id="bg_<?php echo $_smarty_tpl->tpl_vars['attr']->value['pid'];?>
" name="json_bg" value="<?php echo $_smarty_tpl->tpl_vars['attr']->value['background'];?>
" data-pid="bg_<?php echo $_smarty_tpl->tpl_vars['attr']->value['pid'];?>
">
<?php }?>


<?php }
}
