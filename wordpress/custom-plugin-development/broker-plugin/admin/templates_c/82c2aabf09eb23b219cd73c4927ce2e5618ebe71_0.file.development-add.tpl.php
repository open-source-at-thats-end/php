<?php
/* Smarty version 4.2.1, created on 2024-01-04 09:52:56
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-add.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65967ff8a140e5_60246867',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '82c2aabf09eb23b219cd73c4927ce2e5618ebe71' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/loopt/admin/templates/development/development-add.tpl',
      1 => 1679673314,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65967ff8a140e5_60246867 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript" xmlns="http://www.w3.org/1999/html">
    var url = '<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['msgSuccess']->value) {?><div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['msgSuccess']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }
if ($_smarty_tpl->tpl_vars['msgError']->value) {?><div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['msgError']->value;?>
<button class="close" data-dismiss="alert" type="button">X</button></div><?php }?>
<h2>Development Page Details</h2>


<form id="frmDevelopmentUpload" class="frmDevelopment advanced-search search" action="https://looptcloud.com/upload/ImgUpload.php" method="post" enctype="multipart/form-data" >
    <div class="tab-content" style="overflow: hidden">
        <div  class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <h3>Image Upload</h3><hr><br class="fclear">
                <div class="span10-">
                    <div class="fholder2">
                        <label><b>Main Photo</b></label><br>
                        <input type="file" name="main_photo" id="main_photo" class="input-lg" style="height: 40px" /><br/><br/>
                                            </div>
                    <div class="fholder2">
                        <label><b>Upload Photo</b></label><br>
                        <input type="file" name="photo[]" class="input-lg" style="height: 40px" multiple ><br/><br/>
                                            </div>
                </div>
                <input type="submit" class="btn" value="Upload" name="Upload" />
                <input type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['pk']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" name="pk" />
                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" name="action" />
                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['addPK']->value;?>
" name="addPK" />
                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['RedirectURL']->value;?>
" name="RedirectURL" />
            </div>
        </div>
    </div>
</form>
<form id="frmDevelopment" class="frmDevelopment advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    <h3>Basic Details</h3>

                    <div class="fholder2">
                        <label><b>Title</b></label></br>
                        <input type="text" id="dev_title" name="dev_title" value="<?php echo $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_title'];?>
" class="input-lg required"/>
                        <label class="error" for="dev_title">Enter Development Title</label>
                    </div>

                    
                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Link 1</b></label></br>
                        <input type="text" id="dev_link1" name="dev_link1" value="<?php echo $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_link1'];?>
" class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Link 2</b></label></br>
                        <input type="text" id="dev_link2" name="dev_link2" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_link2'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Link 3</b></label></br>
                        <input type="text" id="dev_link3" name="dev_link3" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_link3'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"  class="input-lg for-search"/>
                                            </div>
                    <div class="fholder2">
                        <label><b>Google Embeded Map Code  </b></label><br>
                        <textarea rows="10" id="dev_google_map_code" name="dev_google_map_code" class="input-lg mb-2"><?php echo $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_google_map_code'];?>
</textarea>
                        <div class="note">Enter Google Embeded Map Code</div>
                    </div>
                    <br class="fclear">
                    <br class="fclear">
                    <div id="s_editor_head" class="fholder2- s_editor">
                        <label for="dev_content_head"><b>Head Content Section</b></label></br>
                        <textarea cols="80" rows="25" id="dev_content_head" name="dev_content_head">
                            <?php echo $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_content_head'];?>

                        </textarea>
                    </div>
                    <br class="fclear">
                    <hr>
                    <br class="fclear">
                    <div id="s_editor" class="fholder2- s_editor">
                        <label for="dev_content_build_info"><b>Building Information</b></label></br>
                        <textarea cols="80" rows="25" id="dev_content_build_info" name="dev_content_build_info">
                            <?php echo $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_content_build_info'];?>

                        </textarea>
                    </div>
                    <br class="fclear">
                    <hr>
                    <br class="fclear">
                    <div id="s_editor_footer" class="fholder2- s_editor">
                        <label for="dev_content_footer"><b>Footer Content Section</b></label></br>
                        <textarea cols="80" rows="25" id="dev_content_footer" name="dev_content_footer">
                                <?php echo $_smarty_tpl->tpl_vars['rsDevelopment']->value['dev_content_footer'];?>

                        </textarea>

                    </div>

                </div>
            </div>
        </div>

        <input type="submit" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
';"/>
        <input type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['pk']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" name="pk" />
            </div>
</form>
<br class="fclear">
<?php echo '<script'; ?>
 type="text/javascript">
    CKEDITOR.replace( 'dev_content_head' );
    CKEDITOR.replace( 'dev_content_build_info' );
    CKEDITOR.replace( 'dev_content_footer' );
<?php echo '</script'; ?>
><?php }
}
