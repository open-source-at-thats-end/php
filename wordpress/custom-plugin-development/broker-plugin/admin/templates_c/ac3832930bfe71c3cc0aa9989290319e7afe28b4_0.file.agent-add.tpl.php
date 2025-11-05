<?php
/* Smarty version 4.2.1, created on 2023-08-11 21:24:58
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/agent/agent-add.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64d6a72a717060_55917229',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac3832930bfe71c3cc0aa9989290319e7afe28b4' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/agent/agent-add.tpl',
      1 => 1675159792,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64d6a72a717060_55917229 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/modifier.explode.php','function'=>'smarty_modifier_explode',),1=>array('file'=>'/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/libs/Smarty4/plugins/function.html_checkboxes.php','function'=>'smarty_function_html_checkboxes',),));
if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }
if ($_smarty_tpl->tpl_vars['msgError']->value) {?><div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['msgError']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?>
<h2>Agent Details</h2>

<form id="frmAgent" action="" method="post" enctype="multipart/form-data">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span8">
                    <div>
                        <label>Photo</label>
                        <input type="file" name="agent_photo" id="agent_photo" class="input-xlarge" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_photo'];?>
"/>
                        <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['agent_photo'] != '') {?><br/><br />
                            <img src="<?php echo $_smarty_tpl->tpl_vars['agentImgUrl']->value;
echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_photo'];?>
" width="90"/>
                            <br><input type="checkbox" id= "del_agent_photo" tabindex="<?php echo $_smarty_tpl->tpl_vars['ControlTabIndex']->value;?>
" name="del_agent_photo" value="1" class="stdCheckbox"> Delete Agent Photo
                        <?php } else { ?>
                            <br><img src="<?php echo $_smarty_tpl->tpl_vars['agentImgUrl']->value;?>
no-agent-img.jpg" width="90"/>
                        <?php }?>

                        <input type="hidden" name="prev_agent_photo" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_photo'];?>
" />
                    </div><br>
                    <div>
                        <label>First Name</label>
                        <input type="text" id="agent_first_name" name="agent_first_name" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_first_name'];?>
" required class="input-xxlarge required"/>
                        <label class="error" for="agent_first_name">Enter Agent First Name</label>
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" id="agent_last_name" name="agent_last_name" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_last_name'];?>
" required class="input-xxlarge required"/>
                        <label class="error" for="agent_last_name">Enter Agent Last Name</label>
                    </div>
                    <div>
                        <label>Phone No.</label>
                        <input type="text" id="agent_phone" name="agent_phone" minlength="10" maxlength="15" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_phone'];?>
" class="input-xxlarge phone_no- required"/>
                        <label class="error" for="agent_phone">Enter Agent Phone Number</label>
                    </div>
                    <div>
                        <label>About Agent</label>
                        <textarea id="agent_about" name="agent_about" class="input-xxlarge mb-2"><?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_about'];?>
</textarea>
                        <label class="error" for="agent_about">Enter something about agent</label>
                    </div>
                    <div>
                        <label>Address</label>
                        <textarea id="agent_address" name="agent_address" class="input-xxlarge mb-2"><?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_address'];?>
</textarea>
                        <label class="error" for="agent_address">Enter Agent Address</label>
                    </div>
                    <div>
                        <label>E-mail</label>
                        <input type="text" id="agent_email" name="agent_email" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_email'];?>
" class="input-xxlarge required"/>
                        <label class="error" for="agent_email">Enter Agent E-mail</label>
                    </div>
                    <div>
                        <label>Site Title</label>
                        <input type="text" id="agent_site_title" name="agent_site_title" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_site_title'];?>
" required class="input-xxlarge required"/>
                        <label class="error" for="agent_site_title">Enter Agent Site Title</label>
                    </div>
                    <div>
                        <label>Website</label>
                        <input type="text" id="agent_website" name="agent_website" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_website'];?>
" required class="input-xxlarge required"/>
                        <p><b>Note:</b> Don't enter http with domain name.</p>
                        <label class="error" for="agent_website">Enter Agent Website</label>
                    </div>
                    <div>
                        <label>LogIn Screen Text</label>
                        <textarea id="agent_signin_text" name="agent_signin_text" class="input-xxlarge"><?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_signin_text'];?>
</textarea>
                        <p><b>Note:</b> Enter Header Text for Log In screen.</p>
                        <label class="error" for="agent_signin_text">Enter Log In text</label>
                    </div>
                                        <div>
                        <label>Email Logo</label>
                        <input type="file" name="agent_print_photo" id="agent_print_photo" class="input-xlarge" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_print_photo'];?>
"/>
                        <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['agent_print_photo'] != '') {?><br/><br />
                            <img src="<?php echo $_smarty_tpl->tpl_vars['agentImgUrl']->value;
echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_print_photo'];?>
" width="90"/>
                            <br><input type="checkbox" id= "del_agent_print_photo" tabindex="<?php echo $_smarty_tpl->tpl_vars['ControlTabIndex']->value;?>
" name="del_agent_print_photo" value="1" class="stdCheckbox"> Delete Agent Photo <br><br>
                        <?php } else { ?>
                            <br><img src="<?php echo $_smarty_tpl->tpl_vars['agentImgUrl']->value;?>
default-print-logo.png" width="90"/> <br><br>
                        <?php }?>

                        <input type="hidden" name="prev_agent_photo" value="<?php echo $_smarty_tpl->tpl_vars['rsAgent']->value['agent_photo'];?>
" />
                    </div>
                                                            <div class="multi-options <?php echo (($tmp = $_smarty_tpl->tpl_vars['Field']->value['addClass'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
                        <label class="multi-city">City</label>
                        <div class="aright">
                        </div>
                                                                           <div id="miami" class="">
                                                                                                           <div class="multi-options-container">
                                <?php echo smarty_function_html_checkboxes(array('name'=>"agent_city_serving",'options'=>$_smarty_tpl->tpl_vars['arrMIAMICity']->value,'separator'=>'','cols'=>'4','selected'=>(($tmp = smarty_modifier_explode(",",$_smarty_tpl->tpl_vars['rsAgent']->value['agent_city_serving']) ?? null)===null||$tmp==='' ? '' ?? null : $tmp),'labels'=>true,'class'=>'city-option'),$_smarty_tpl);?>

                            </div>
                        </div>
                                            </div>
                    <div class="pt-10">
                        <label>Is Enabled?</label>
                        <input type="radio" value="1" name="agent_active" <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['agent_active'] == true) {?>checked<?php } else { ?>checked<?php }?> class="input-xxlarge required">Yes
                        <input type="radio" value="0" name="agent_active" <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['agent_active'] != true) {?>checked<?php }?> class="input-xxlarge required m-l-40">No
                    </div>
                    <div class="pt-10">
                        <label>Crypto Values?</label>
                        <input type="radio" value="1" name="crypto_active" <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['crypto_active'] == true) {?>checked<?php } else { ?>checked<?php }?> class="input-xxlarge required">Yes
                        <input type="radio" value="0" name="crypto_active" <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['crypto_active'] != true) {?>checked<?php }?> class="input-xxlarge required m-l-40">No
                    </div>
                    <div class="pt-10">
                        <label>Market Reports?</label>
                        <input type="radio" value="1" name="market_report_active" <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['market_report_active'] == true) {?>checked<?php } else { ?>checked<?php }?> class="input-xxlarge required"> Yes
                        <input type="radio" value="0" name="market_report_active" <?php if ($_smarty_tpl->tpl_vars['rsAgent']->value['market_report_active'] != true) {?>checked<?php }?> class="input-xxlarge required m-l-40"> No
                    </div>
                    <div class="pt-10">
                        <label><b>Select MLS </b></label><br>
                        <div class="multi-opt cols3 multi-options-container ">
                            <?php $_smarty_tpl->_assignInScope('mls', smarty_modifier_explode(",",$_smarty_tpl->tpl_vars['rsAgent']->value['agent_select_mls']));?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['selectMLS']->value, 'value', false, 'mls_key', 'agent_select_mls', array (
));
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['mls_key']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
                                <label><input type="checkbox" name="agent_select_mls[]" <?php if (((isset($_smarty_tpl->tpl_vars['rsAgent']->value['agent_select_mls']))) && (in_array($_smarty_tpl->tpl_vars['mls_key']->value,$_smarty_tpl->tpl_vars['mls']->value) || $_smarty_tpl->tpl_vars['mls_key']->value == $_smarty_tpl->tpl_vars['rsAgent']->value['agent_select_mls'])) {?>checked="checked"<?php }?> id="<?php echo $_smarty_tpl->tpl_vars['mls_key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['mls_key']->value;?>
" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</label>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <input type="submit" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';"/>
        <input type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['pk']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" name="pk" />
        <input type="hidden" class="sys_name_change" value="No" name="sys_name_change" />
    </div>
</form>

    <?php echo '<script'; ?>
 type="text/javascript">
        jQuery(document).ready(function(){
            // Input Masking for Phone Number
            if(jQuery("input.phone_no").length)
            {
                jQuery("input.phone_no").mask("(999)-999-9999");
            }
            jQuery('#frmAgent').validate();

            jQuery('.generateKeyCode').on('click', function(){
                var randomnumber=Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                jQuery('#agent_key_code').val(randomnumber);
            });
            console.log(jQuery('#agent_system_name').val());

            jQuery("#agent_system_name").on('change', function () {

                console.log(jQuery('#agent_system_name').val());

            });
        });
    <?php echo '</script'; ?>
>
<?php }
}
