<div id="ip-details">
	<div class="ip-lookup mt-5 mx-auto">
		<div class="card-box bg-light">
			<div class="card-header">
				<h2><i class="fa fa-search" aria-hidden="true"></i> Look up IP Address Location</h2>
			</div>
			<div class="card-body">
				<p>If you can find out the IPv4 or IPv6 address of an Internet user, you can get an idea what part of the country or world they're in by using our IP Lookup tool. What to do: Enter the IP address you're curious about in the box below, then click "Get IP Details." </p>
				<form class="inline-form mt-5" action="/ip-location" method="POST">
					<div class="row justify-content-center">
						<div class="col-6">
							<div class="input-group">
								<input type="text" name="LOOKUPADDRESS" class="form-control border" placeholder="Enter IP Address...">
								<div class="input-group-append">
									<input type="submit" name="submit" class="btn btn-primary" value="Get IP Details">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="my-5 mx-auto details-area card-box w-50">
		{if isset($location) && count($location) > 0 && $location['status'] == 'success'}
			<div class="card">
				<div class="card-header text-center">IP Details For: <strong>{$location['query']}</strong></div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">Organization: <strong>{$location['as']}</strong></li>
						<li class="list-group-item">city: <strong>{$location['city']}</strong></li>
						<li class="list-group-item">Postal Code: <strong>{$location['zip']}</strong></li>
						<li class="list-group-item">State/Region: <strong>{$location['regionName']}</strong></li>
						<li class="list-group-item">country: <strong>{$location['country']}</strong></li>
						<li class="list-group-item"></li>
					</ul>
				</div>
			</div>
		{/if}
	</div>
</div>