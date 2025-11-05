<div class="card w-100 rounded-0 mt-4 mt-lg-4 border te-mortgage-calculator" id="te-mortgage-calculator-hash">
	<div class="card-header te-bg-light border-0 px-4 py-3">
		<div class="col-xl-12 col-lg-12 col-md-12 sec-title px-0">
			<h5 class="title-font text-left te-line-height-normal pb-0 mb-0">Mortgage Calculator</h5>
		</div>
	</div>
	<div class="card-body bg-white px-4">
		<form role="form" id="frmCalculator">
			<div class="group position-relative mt-3">
				<input class="form-input w-100 bg-transparent pt-2" type="text" name="loan_balance" id="loan_balance" placeholder="" value="{$currency}{$Record.ListPrice|number_format:'0'}" required>
				<span class="bar"></span>
				<label class="form-label position-absolute">Home Price</label>
			</div>
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
					<div class="group position-relative mt-2">
						<input name="down_payment_percent" id="down_payment_percent" class="form-input w-100 bg-transparent pt-2" type="text" placeholder="" value="20%" required>
						<span class="bar"></span>
						<label class="form-label position-absolute">Down Payment</label>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
					<div class="group position-relative mt-2">
						{math assign="downpay" equation = "a * b" a=$Record.ListPrice b=0.20}
						<input name="down_payment_amount" id="down_payment_amount" class="form-input w-100 bg-transparent pt-2" type="text" placeholder="" value="{$site_currency}{$downpay|number_format:'0'}" required>
						<span class="bar"></span>
						<label class="form-label position-absolute"></label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
					<div class="group position-relative mt-2 mb-3">
						<select name="loan_year" id="loan_year" class="custom-select rounded-0 border-0 te-form-border-bottom shadow-none pt-2">
							<option value="10 years">10 years</option>
							<option value="15 years">15 years</option>
							<option value="20 years">20 years</option>
							<option value="25 years">25 years</option>
							<option selected="selected" value="30 years">30 years</option>
						</select>
						<span class="bar"></span>
						<label class="form-label position-absolute">Terms & Rate</label>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
					<div class="group position-relative mt-2 mb-3">
						<input class="form-input w-100 bg-transparent pt-2" type="text" placeholder="" value="{if isset($Mortgage_rate) && $Mortgage_rate != ''}{$Mortgage_rate}%{else}6.42%{/if}" name="loan_interest" id="loan_interest" required>
						<span class="bar"></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="text-secondary font-weight-bold" for="loan_principal">Loan Amount</label>
				<input type="text" class="form-control rounded-0 border-0 shadow-none te-bg-light" name="loan_principal" id="loan_principal" aria-describedby="emailHelp" data-val="" value="" disabled>
			</div>
			<div class="form-group">
				<div class="te-bg-light text-center p-2 bg-gray">
					<label for="monthly_payment">Estimated Monthly Payment</label>
					<h4 class="text-secondary monthly_payment f-s-20 txt-heading heading_txt_color" id="monthly_payment"></h4>
					<p>Principal & interest</p>
				</div>
			</div>
			<div class="form-group">
				<p class="my-1">
					<small>* Property tax and homeowner insurance are not included.</small>
				</p>
				<p>
					<small>* If your down payment is less than 20%, there will be monthly private mortgage insurance (PMI).</small>
				</p class="my-1">
			</div>

			<button type="button" id="cal_now" class="btn border-secondary- te-btn text-white- text-uppercase w-100 rounded-0 shadow-none py-2 lpt-btn lpt-btn-txt">Calculate Now</button>
		</form>
	</div>
</div>