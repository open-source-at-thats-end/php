<div id="schedule-message-container" class="col-12"></div>
<div class="card-body bg-white px-4">

	<form id="frmSchedule" role="form"  method="POST">

		<div class="group position-relative mt-2">
			<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="lead_first_name" value="{str_replace('_',' ',$current_user->display_name|default:'')}" >
			<span class="bar"></span>
			<label class="form-label position-absolute">Name</label>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required" type="email" placeholder="" name="lead_email" value="{$current_user->user_email|default:''}" >
			<span class="bar"></span>
			<label class="form-label position-absolute">Email</label>
		</div>
		<div class="group position-relative">
			<input class="form-input w-100 bg-transparent required phone_no-" maxlength="15" minlength="10" type="tel" placeholder="" name="lead_home_phone" value="{$meta['user_phone'][0]|default:''}" >
			<span class="bar"></span>
			<label class="form-label position-absolute ">Mobile Number</label>
		</div>
		<div class="group position-relative mb-4">
			<textarea class="form-input w-100 bg-transparent pb-4 pb-lg-5 pb-xl-3 required" type="text" placeholder="I would like more information about {$Record.address_short}." name="lead_comment" >I would like more information about {$Record.address_short}.</textarea>
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
		<button type="submit" class="btn border-secondary- te-btn text-white- shadow-none rounded-0 w-100 py-2 text-uppercase btn-schedule lpt-btn lpt-btn-txt">Send Message</button>
		{if $arrConfig['Listing']['enable_google_captcha'] == 'Yes' && $arrConfig['Listing']['google_site_key'] != ''}
			<input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
			<input type="hidden" name="action" value="contact_agent">
		{/if}
	</form>
</div>
<script src="https://www.google.com/recaptcha/api.js?render={$arrConfig['Listing']['google_site_key']}" async defer></script>