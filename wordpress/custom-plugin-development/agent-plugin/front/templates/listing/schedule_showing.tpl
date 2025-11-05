<div id="schedule-message-container" class="col-12"></div>
<div class="card-body setbgcolor px-4 pb-4 formpx">

	<form id="frmSchedule" role="form"  method="POST">
		{if isset($arrDevelopment['dev_id']) && $arrDevelopment['dev_id'] != ''}
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6">
					<div class="group position-relative mt-2">
						<input class="form-input w-100 mt-2 forminput-bgcolor border required" type="text" placeholder="" name="lead_first_name" value="{str_replace('_',' ',$current_user->display_name|default:'')}" >
						<span class="bar"></span>
						<label class="form-label position-absolute">First Name <span class="text-secondary sub-text"> - required</span></label>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6">
					<div class="group position-relative mt-2">
						<input class="form-input w-100 mt-2 forminput-bgcolor border required" type="text" placeholder="" name="lead_last_name" value="{str_replace('_',' ',$current_user->display_name|default:'')}" >
						<span class="bar"></span>
						<label class="form-label position-absolute">Last Name <span class="text-secondary sub-text"> - required</span></label>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6">
					<div class="group position-relative">
						<input class="form-input w-100  mt-2 forminput-bgcolor required phone_no-" maxlength="15" minlength="10" type="tel" placeholder="" name="lead_home_phone" value="{$meta['user_phone'][0]|default:''}" >
						<span class="bar"></span>
						<label class="form-label position-absolute ">Mobile Number <span class="text-secondary sub-text"> - required</span></label>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6">
					<div class="group position-relative">
						<input class="form-input w-100  mt-2 forminput-bgcolor required" type="email" placeholder="" name="lead_email" value="{$current_user->user_email|default:''}" >
						<span class="bar"></span>
						<label class="form-label position-absolute">Email <span class="text-secondary sub-text"> - required</span></label>
					</div>
				</div>
			</div>
		{else}
			<div class="group position-relative mt-2">
				<input class="form-input w-100 mt-2 forminput-bgcolor required" type="text" placeholder="" name="lead_first_name" value="{str_replace('_',' ',$current_user->display_name|default:'')}" >
				<span class="bar"></span>
				<label class="form-label position-absolute">Name <span class="text-secondary sub-text"> - required</span></label>
			</div>
			<div class="group position-relative">
				<input class="form-input w-100  mt-2 forminput-bgcolor required" type="email" placeholder="" name="lead_email" value="{$current_user->user_email|default:''}" >
				<span class="bar"></span>
				<label class="form-label position-absolute">Email <span class="text-secondary sub-text"> - required</span></label>
			</div>
			<div class="group position-relative">
				<input class="form-input w-100  mt-2 forminput-bgcolor required phone_no-" maxlength="15" minlength="10" type="tel" placeholder="" name="lead_home_phone" value="{$meta['user_phone'][0]|default:''}" >
				<span class="bar"></span>
				<label class="form-label position-absolute ">Mobile Number <span class="text-secondary sub-text"> - required</span></label>
			</div>
		{/if}
		<div class="group position-relative mb-4">
			<textarea class="form-input w-100  mt-2 pb-4 pb-lg-5 pb-xl-3 forminput-bgcolor required" type="text" placeholder="I would like more information about {$Record.address_short}." name="lead_comment" >I would like more information about{if $hideAddress != '' && $hideAddress == 'Yes'}{if $isUserLoggedIn != '' && $isUserLoggedIn == true} {$Record.address_short}.{else} this Property.{/if}{/if}</textarea>
			<span class="bar"></span>
			<label class="form-label position-absolute"></label>
		</div>
		{*{if $arrConfig['Listing']['enable_google_captcha'] == 'Yes' && $arrConfig['Listing']['google_site_key'] != ''}
			<div class="g-recaptcha mb-4" data-sitekey="{$arrConfig['Listing']['google_site_key']}"></div>
		{/if}*}
		<input name="ListingID_MLS" id="ListingID_MLS" type="hidden" value="{$Record.ListingID_MLS}" />
		<input name="email_to" id="email_to" type="hidden" value="{$agentInfo.agent_email}" />
		<input name="agent_id" id="agent_id" type="hidden" value="{$agentInfo.agent_id|default:0}" />
		<input name="reset" id="reset" type="reset" value="" class="d-none"/>
		<input name="AType" id="AType" type="hidden" value="" />
		<span class="inquiry-loading-area">

		</span>
		<button type="submit" id="send-massage" class="btn border-secondary- btn_txt_color shadow-none rounded-0 w-100 text-uppercase btn-schedule lpt-btn lpt-btn-txt button_color hover-color hover-text-color">Send Message</button>
		{if $arrConfig['Listing']['enable_google_captcha'] == 'Yes' && $arrConfig['Listing']['google_site_key'] != ''}
			<input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
			<input type="hidden" name="action" value="contact_agent">
		{/if}
	</form>
</div>
<script src="https://www.google.com/recaptcha/api.js?render={$arrConfig['Listing']['google_site_key']}" async defer></script>