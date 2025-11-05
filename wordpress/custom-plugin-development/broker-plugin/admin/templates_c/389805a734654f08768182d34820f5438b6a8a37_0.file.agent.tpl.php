<?php
/* Smarty version 4.2.1, created on 2023-08-11 21:24:44
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/agent/agent.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d6a71cc7c006_53724578',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '389805a734654f08768182d34820f5438b6a8a37' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/agent/agent.tpl',
      1 => 1672487544,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:agent/agent-search.tpl' => 1,
  ),
),false)) {
function content_64d6a71cc7c006_53724578 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.cycle.php','function'=>'smarty_function_cycle',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_pager2.php','function'=>'smarty_function_html_pager2',),));
?>
<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Agent Master
				</span>
            </li>
        </ul>
    </div>
</div>
<h4>Search Filters</h4>
<hr/>
<div>
	<?php $_smarty_tpl->_subTemplateRender('file:agent/agent-search.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
<hr/>
<a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=add"  id="a_add" class="pull-right"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Add New</b></a>&nbsp;&nbsp;
<form id="frmStdForm" name="frmStdForm" action="" method="post">
    <div id="col-container">
        <div id="-vcol-right">
            <div id="msg_box"><?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?></div>
            <div>                 <div class="vlist-head">
                    <div class="main-">
                        <table class="wp-list-table table table-bordered  table-condensed">
                            <thead>
                            <tr>
                                <th width="8%">Photo</th>
                                <th width="10%">First Name</th>
                                <th width="10%">Last Name</th>
                                <th width="11%">Email</th>
                                <th width="10%">Phone</th>
                                <th width="10%">Website</th>
                                <th width="11%">Key Code</th>
                                <th width="7%">Is Enabled</th>
                                <th width="7%">MLS</th>
                                <th width="9%">Market Report</th>
                                <th width="10%">Action</th>
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
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsAgent']->value, 'record');
$_smarty_tpl->tpl_vars['record']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
$_smarty_tpl->tpl_vars['record']->do_else = false;
?>
                        <tr class="<?php echo smarty_function_cycle(array('values'=>'alt,'),$_smarty_tpl);?>
">
                            <td width="10%">
                                <?php $_smarty_tpl->_assignInScope('agentImg', ((string)$_smarty_tpl->tpl_vars['agentImgUrl']->value).((string)$_smarty_tpl->tpl_vars['record']->value['agent_photo']));?>
                                                                <?php if ($_smarty_tpl->tpl_vars['record']->value['agent_photo'] != '') {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['agentImgUrl']->value;
echo $_smarty_tpl->tpl_vars['record']->value['agent_photo'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['record']->value['agent_first_name'];?>
" height="" width="45"/>
                                <?php } else { ?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['agentImgUrl']->value;?>
no-agent-img.jpg" width="45"/>
                                <?php }?>
                            </td>
                            <td width="9%"><?php echo $_smarty_tpl->tpl_vars['record']->value['agent_first_name'];?>
</td>
                            <td width="9%"><?php echo $_smarty_tpl->tpl_vars['record']->value['agent_last_name'];?>
</td>
                            <td width="9%"><?php echo $_smarty_tpl->tpl_vars['record']->value['agent_email'];?>
</td>
                            <td width="9%"><?php echo $_smarty_tpl->tpl_vars['record']->value['agent_phone'];?>
</td>
                            <td width="9%"><?php echo $_smarty_tpl->tpl_vars['record']->value['agent_website'];?>
</td>
                            <td width="10%"><?php echo $_smarty_tpl->tpl_vars['record']->value['agent_key_code'];?>
</td>
                            <td width="8%"><?php if ($_smarty_tpl->tpl_vars['record']->value['agent_active'] == true) {?>Yes<?php } else { ?>No<?php }?></td>
                            <td width="9%">MARBEACHES</td>
                            <td width="8%"><?php if ($_smarty_tpl->tpl_vars['record']->value['market_report_active'] == true) {?>Yes<?php } else { ?>No<?php }?></td>
                            <td width="10%">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
&action=edit&pk=<?php echo $_smarty_tpl->tpl_vars['record']->value['agent_id'];?>
"  id="a_edit" ><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Edit</b></a>&nbsp;&nbsp;
                                <a href="javascript:void(0);"  id="a_delete" onclick="JavaScript:CDelete_Click('<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['record']->value['agent_id'];?>
', '');"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp<b>Delete</b></a>&nbsp;&nbsp;
                            </td>
                        </tr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php } else { ?>
                    <tr class="alt"><td colspan="5">No Data Found.</td></tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</form>
<?php if ($_smarty_tpl->tpl_vars['totalFetched']->value >= $_smarty_tpl->tpl_vars['page_size']->value) {?>
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
                            <?php echo smarty_function_html_pager2(array('num_items'=>$_smarty_tpl->tpl_vars['totalFetched']->value,'per_page'=>$_smarty_tpl->tpl_vars['page_size']->value,'add_prevnext_text'=>true,'start_item'=>$_smarty_tpl->tpl_vars['startRecord']->value),$_smarty_tpl);?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>

    <?php echo '<script'; ?>
 type="text/javascript">
        jQuery(document).ready(function(){


        });
        function CDelete_Click(frm, PK, msg)
        {

            if(confirm(msg ? msg : 'Are you sure you want to delete this record?'))
            {
                window.location = frm+'&action=delete&pk='+PK

            }

        }
    <?php echo '</script'; ?>
>

<?php }
}
