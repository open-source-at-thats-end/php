<?php
/* Smarty version 4.2.1, created on 2023-08-31 13:29:17
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined-add.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64f095ad0d5e57_81671129',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ec2347b52aeffc1d492f2d1fa230e387c486ee1b' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/predefined/predefined-add.tpl',
      1 => 1674643922,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:search_form.tpl' => 1,
  ),
),false)) {
function content_64f095ad0d5e57_81671129 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
echo '<script'; ?>
 type="text/javascript">
    var url = '<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }
if ($_smarty_tpl->tpl_vars['msgError']->value) {?><div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['msgError']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?>
<h2>Predefined Search Details</h2>
<ul class="nav nav-tabs" id="myTab">
    <!--li class="active"><a data-toggle="tab" href="#tab1">RETS Setting</a></li-->
    <li class="active"><a data-toggle="tab" href="#tab-search">Search from</a></li>
    <li><a data-toggle="tab" class="bindMap" href="#tab-map">Map</a></li>
</ul>
<form id="frmPredSearch" class="frmPredSearch advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
    <div class="tab-content">
        <div id="tab-search" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    <h3>Basic Details</h3>
                    <div class="fholder2">
                        <label><b>Title</b></label>
                        <input type="text" id="psearch_title" name="psearch_title" value="<?php echo $_smarty_tpl->tpl_vars['rsPredefined']->value['psearch_title'];?>
" class="input-lg required"/>
                        <label class="error" for="psearch_title">Enter Predefined Search Title</label>
                    </div>
                    <div class="fholder2">
                        <label><b>Limit Results by Number</b></label>
                        <input type="text" id="psearch_result_limit" name="psearch_result_limit" value="<?php echo $_smarty_tpl->tpl_vars['rsPredefined']->value['psearch_result_limit'];?>
" class="input-lg"/>
                    </div>

					<div class="fholder2">
						<label><b>Tag</b></label>
						<input type="text" id="psearch_tag" name="psearch_tag" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsPredefined']->value['psearch_tag'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
					</div>
					<div class="fholder2">
						<b><input type="checkbox" id="psearch_generate_mrktreport" name="psearch_generate_mrktreport" value="Yes" <?php if ($_smarty_tpl->tpl_vars['rsPredefined']->value['psearch_generate_mrktreport'] == 'Yes') {?>checked<?php }?> class="input-lg"/> Generate Market Report</b>
						<?php if (((isset($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'])) && $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status'] != 'renatl') || (is_array($_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status']) && !in_array('rental',$_smarty_tpl->tpl_vars['arrSearchCriteria']->value['status']))) {?>
							<b class="pl-10"><input type="checkbox" id="psearch_generate_rental" name="psearch_generate_rental" value="Yes" <?php if ($_smarty_tpl->tpl_vars['rsPredefined']->value['psearch_generate_rental'] == 'Yes') {?>checked<?php }?> class="input-lg"/> Generate Rentals Page</b>
						<?php }?>
						<b class="pl-10"><input type="checkbox" id="psearch_display_tab" name="psearch_display_tab" value="Yes" <?php if ($_smarty_tpl->tpl_vars['rsPredefined']->value['psearch_display_tab'] == 'Yes') {?>checked<?php }?> class="input-lg"/> Display Tab Layout?</b><br>
                        <b class=""><input type="checkbox" id="psearch_monthwise_report" name="psearch_monthwise_report" value="Yes" <?php if ($_smarty_tpl->tpl_vars['rsPredefined']->value['psearch_monthwise_report'] == 'Yes') {?>checked<?php }?> class="input-lg"/> Generate Monthwise Market Report</b>
					</div>
                    <br class="fclear">
                    <h3>Search Criteria</h3>

                    <?php $_smarty_tpl->_subTemplateRender('file:search_form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                    <div class="fholder2">
                        <label><b>Sort By</b></label>
                        <select name="sort_by" class="apm_monoselect input-lg">

                            <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['arrSortingOption']->value,'selected'=>(($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['sort_by'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp)),$_smarty_tpl);?>

                        </select>
                    </div>
                    
                    <div class="fright">
                        <p class="result-count aright">
                            <a href="JavaScript: void(0);" class="match button" onclick="JavaScript: Show_MatchedListing();"><i class="fa fa-filter fa-lg"></i>&nbsp;<b><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['total_record']->value,'0');?>
 MATCHES</b></a>
                            <input type="hidden" name="Action" value="<?php echo $_smarty_tpl->tpl_vars['Action']->value;?>
">
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <div id="tab-map" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                
                    <style>
                        .field-list {max-height:500px; overflow:auto}
                        .sub-list {margin-left:20px; width:98%; padding:1%; background:#fff; float:left}
                        .sub-list label {float:left; width:48%;}
                        .sub-list label input {margin-right:3px;}
                    </style>
                
                <div id="pms-area-map" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0 visible-xl d-xl-block te-half-map-div order-2 d-none ">
                    <div id="pms-map" data-map='true'>

                    </div>
                    <div id="map-infobox-small" class="oeibSmall hide-me">
                        <div class="ibContent"></div>
                    </div>
                    
                    <div class=" te-draw-radius-button  position-absolute">
                        <a id="btn_draw" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                            <i class="fas fa-draw-polygon text-secondary te-icon-draw"></i><br>draw
                        </a>
                                                <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 d-none lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_cancel">Cancel</a>
                        <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 d-none lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_remove">Reset</a>
                    </div>
                </div>

            </div>
            <span class="clearfix"></span>
        </div>
        <input type="submit" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';"/>
        <input type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['pk']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" name="pk" />
        <input type="hidden" id="poly" name="poly" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['poly'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
        <input type="hidden" id="MapZoomLevel" name="mz" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['mz'] ?? null)===null||$tmp==='' ? 13 ?? null : $tmp);?>
">
        <input type="hidden" id="MapCenterLat" name="clat" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['clat'] ?? null)===null||$tmp==='' ? 25.761681 ?? null : $tmp);?>
">
        <input type="hidden" id="MapCenterLng" name="clng" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrSearchCriteria']->value['clng'] ?? null)===null||$tmp==='' ? -80.191788 ?? null : $tmp);?>
">
    </div>
</form>

    <?php echo '<script'; ?>
 type="text/javascript">
        jQuery(document).ready(function() {
            //jQuery('#frmPredSearch').validate();
        });
    <?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 type="text/javascript">
    var mapZoomLevel 	= <?php echo $_smarty_tpl->tpl_vars['mapZoomLevel']->value;?>
;
    var mapCenterLat 	= <?php echo $_smarty_tpl->tpl_vars['mapCenterLat']->value;?>
;
    var mapCenterLng 	= <?php echo $_smarty_tpl->tpl_vars['mapCenterLng']->value;?>
;

<?php echo '</script'; ?>
><?php }
}
