<?php
/* Smarty version 4.2.1, created on 2023-08-11 21:24:37
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/broker.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d6a71531d969_93018854',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '635abbb983d9632ac0053026d27bc9b78d3dcaf0' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/broker.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d6a71531d969_93018854 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_pager2.php','function'=>'smarty_function_html_pager2',),));
?>
<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Broker Office
				</span>
            </li>
        </ul>
    </div>
</div>
<h4>Search Filters</h4>
<hr/>
<form id="FrmBrokerInfo" method="get" action="">
	<input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"/>
	<div class="row">
		<div class="span6">
			<label><b>ID</b></label>
			<input type="text" id="agent_first_name" name="broker_id" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['broker_id'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
		</div>
		<div class="span9">
			<label><b>Name</b></label>
			<input type="text" id="agent_last_name" name="broker_name" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['arrParams']->value['broker_name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" class="input-lg for-search"/>
		</div>
        
		
      
	</div>
	<div class="row">
    <div class="span1">
			<label></label>
			<input type="submit" id="search"  value="Search" class="input-lg btn btn-sm for-search"/>
		</div>
		<div class="span1">
			<label></label>
			<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
" type="button" value="" class="for-search btn btn-sm">Reset</a>
		</div>
	</div>
</form>
<hr/>
<form id="frmStdForm" name="frmStdForm" action="" method="post">
    <div id="col-container">
        <div id="-vcol-right">
            <div>
                <div class="vlist-head">
                    <div class="main-">
                        <table class="wp-list-table table table-bordered  table-condensed">
                            <thead>
                            <tr>
                                <th width="15%">Broker Id</th>
                                <th width="85%">Broker Name</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="-vlist-data" id="agent-list-holder">
        <div class="main-">
            <table class="table table-bordered  table-condensed table-hover  table-striped">
                <tbody id="the-list">
                <?php if ($_smarty_tpl->tpl_vars['total_record']->value > 0) {?>
                    <?php
 while ($_smarty_tpl->tpl_vars['rsBroker']->value->next_record()) {?>
                        <tr>
                            <td width="15%"><?php echo $_smarty_tpl->tpl_vars['rsBroker']->value->f('Office_ID');?>
</td>
                            <td width="85%"><?php echo $_smarty_tpl->tpl_vars['rsBroker']->value->f('Office_Name');?>
</td>
                        </tr>
                    <?php }?>

                <?php } else { ?>
                    <tr class="alt"><td colspan="5">No Data Found.</td></tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</form>
<?php if ($_smarty_tpl->tpl_vars['total_record']->value >= $_smarty_tpl->tpl_vars['page_size']->value) {?>
    <div class="vlist-footer" id="list-pagination">
        <div class="navbar">
            <div class="navbar-inner">
                <div class=" pull-left" >
                    <div class="pagination-text">
                        <label>Items: <span class="footertalabitems"><?php echo $_smarty_tpl->tpl_vars['totalFetched']->value;?>
 row(s) / <?php echo $_smarty_tpl->tpl_vars['total_record']->value;?>
 total result(s) (on <?php echo $_smarty_tpl->tpl_vars['total_record']->value;?>
 items)</span></label>
                    </div>

                </div>
                <div class="pull-right" >
                    <div class="pagination pagination-mini">
                        <ul class=''>
                            <?php echo smarty_function_html_pager2(array('num_items'=>$_smarty_tpl->tpl_vars['total_record']->value,'per_page'=>$_smarty_tpl->tpl_vars['page_size']->value,'add_prevnext_text'=>true,'start_item'=>$_smarty_tpl->tpl_vars['startRecord']->value),$_smarty_tpl);?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
}
}
