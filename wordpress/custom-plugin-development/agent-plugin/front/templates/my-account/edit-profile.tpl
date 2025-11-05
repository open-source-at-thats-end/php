<div class="card mb-3 bg-white text-left te-card border-0" id="Exterior-hash">
	<div class="card-header te-card-header te-bg-light pl-0 border-0 rounded-0 py-3">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<h5 class="title-font text-left te-line-height-normal mb-0 pb-0 px-2 txt-heading heading_txt_color">Update Profile</h5>
		</div>
	</div>
	<div class="card-body p-0 collapse show" id="exterior">
		<span id="message-container"></span>
		<form class="p-4" role="form" id="frmAccount" >
			<div class="form-group my-0">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_first_name" value="{$first_name}">
							<span class="bar"></span>
							<label class="form-label position-absolute">First Name</label>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_last_name" value="{$last_name}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Last Name</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group my-0">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative">
							<input class="form-input w-100 bg-transparent required" type="email" placeholder="" name="user_email" value="{$userInfo->user_email}" readonly>
							<span class="bar"></span>
{*							<label class="form-label position-absolute">Email</label>*}
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative">
							<input class="form-input w-100 bg-transparent required -phone_no" maxlength="15" minlength="10" type="tel" placeholder="" name="user_phone" value="{$meta.user_phone[0]}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Phone Number</label>
						</div>
					</div>
				</div>
			</div>
			{*<div class="form-group my-0">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
					<div class="group position-relative">
						<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_address" value="{$meta.user_address[0]}">
						<span class="bar"></span>
						<label class="form-label position-absolute">Address</label>
					</div>
				</div>
			</div>*}
			<div class="form-group my-0">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mb-4">
							<select class="custom-select rounded-0 border-0 te-form-border-bottom shadow-none px-1"  name="user_preference" value="{$meta.user_preference[0]}">
								<option selected="">Buy & Sell</option>
								<option value="15 years">Buy</option>
								<option value="20 years">Sell</option>
							</select>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mb-4">
							<select class="custom-select rounded-0 border-0 te-form-border-bottom shadow-none px-1" name="user_time" value="{$meta.user_time[0]}">
							{html_options options=$arr_email_notification selected=$meta.user_time[0]}
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group my-0">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_ptype" value="{$meta.user_ptype[0]}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Property Type Interested In</label>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_area" value="{$meta.user_area[0]}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Main Areas</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group my-0">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_price" value="{$meta.user_price[0]}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Desired Price Range</label>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_bed" value="{$meta.user_bed[0]}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Minimum Number of Bedrooms</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group my-0">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_approve" value="{$meta.user_approve[0]}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Are You Pre-Approved?</label>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
						<div class="group position-relative mt-2">
							<input class="form-input w-100 bg-transparent required" type="text" placeholder="" name="user_sell_pre" value="{$meta.user_sell_pre[0]}">
							<span class="bar"></span>
							<label class="form-label position-absolute">Do You Need to Sell Before Buying?</label>
						</div>
					</div>
				</div>
				<input type="hidden" name="user_id" value="{$userInfo->ID}">
			</div>
			<div class="loading-area"></div>
			<button class="btn btn-account border-secondary- te-btn text-white- shadow-none rounded-0 px-4 mt-1 lpt-btn lpt-btn-txt" type="submit" role="button">Save Changes</button>
		</form>
	</div>
</div>