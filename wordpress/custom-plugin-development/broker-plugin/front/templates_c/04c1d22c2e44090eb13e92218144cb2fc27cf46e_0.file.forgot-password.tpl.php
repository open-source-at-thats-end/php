<?php
/* Smarty version 4.2.1, created on 2024-02-05 01:11:16
  from '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/forgot-password.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_65c08a14b654f8_76960484',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '04c1d22c2e44090eb13e92218144cb2fc27cf46e' => 
    array (
      0 => '/home/650569.cloudwaysapps.com/bubwqcebhd/public_html/wp-content/plugins/CustomWpPlugin/front/templates/forgot-password.tpl',
      1 => 1632519710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c08a14b654f8_76960484 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal-header">
	<h5 class="modal-title txt-heading heading_txt_color" id="exampleModalLabel">Forgot password</h5>

		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	
</div>
<div id="forgot-error"></div>
<div class="modal-body">
	<form id="frmForgetPwd" for="form">
		<div class="form-group">
			<label for="exampleInputEmail1 text-secondary">Enter your sign in email where we will send you instructions to reset password.</label>
		</div>
		<div class="group position-relative mt-2">
			<input class="form-input w-100 bg-transparent required" type="email" placeholder="" name="user_email" value="">
			<span class="bar"></span>
			<label class="form-label position-absolute">Email</label>
		</div>
		<input type="hidden" name="mlsNum" id="mlsNum" value="<?php echo $_smarty_tpl->tpl_vars['mlsNum']->value;?>
" />
		<input type="hidden" name="ReqType" id="ReqType" value="<?php echo (($tmp = $_REQUEST['ReqType'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"/>
		<div class="loading-area"></div>
		<button type="submit" class="btn border-secondary te-btn text-white- w-100 shadow-none rounded-0 text-uppercase btn-fwd lpt-btn lpt-btn-txt">Send Me New Password</button>
	</form>

</div>
<div class="modal-footer justify-content-start">
	<p>Already have an account? <a class="text-main text-decoration-none popup-modal-sm link-color" data-toggle="modal" data-target="MemberLogin" data-url="<?php echo $_smarty_tpl->tpl_vars['Site_Url']->value;
echo Constants::TYPE_MEMBER_DETAIL;?>
/?action=member-login<?php if ((isset($_smarty_tpl->tpl_vars['ReqType']->value))) {?>&ReqType=<?php echo $_smarty_tpl->tpl_vars['ReqType']->value;
}
if ((isset($_smarty_tpl->tpl_vars['mlsNum']->value))) {?>&mlsNum=<?php echo $_smarty_tpl->tpl_vars['mlsNum']->value;
}?>" href="JavaScript:void(0);" data-dismiss="modal">Sign In</a></p>
</div><?php }
}
