<script type="text/javascript">
	var maxViewedExceed 	= '{$maxViewedExceed}';
	var maxViewedExceedCount 	= '{$arrConfig['Listing']['site_max_viewed_without_login']}';
	var isloginReq 	= '{$isloginReq}';
	var url = '{$Record.VirtualTourUrl}';
	var video = document.createElement("iframe");
	//console.log(video);
	video.setAttribute("src", url);
	video.addEventListener("canplay", function() {
		console.log("video true");
		console.log(video.videoHeight);
	});
	video.addEventListener("error", function() {
		console.log("video false");
	});

</script>

<section class="d-none d-md-block">
	<div class="container te-font-family con-div px-md-1 px-lg-2 px-xl-0">
		{*{if isset($backToUrl) && $backToUrl != ''}
			<div class="row pt-lg-4">
				<div class="col-12 px-0">
					<a class="btn btn-sm te-font-size-14 shadow-none te-save-propery-detail- rounded-0 mx-1 mx-lg-0 p-0" href="{$backToUrl}" role="button" title="Back to Previous Page"><i class="far fa-arrow-alt-circle-left fa-2x align-middle"></i> Back to Previous Page</a>
				</div>
			</div>
		{/if}*}
		<div class="row py-md-3 py-lg-4 py-4 border-bottom border-dark">
			<div class="col-xl-3 col-lg-3 col-md-6 px-lg-0 align-self-center pb-3 pb-lg-0">
				<p class="text-left pb-0 mb-0 te-address-heading-property-details txt-color">{$Record.address_short}</p>
				<p class="text-left pb-0 mb-0 txt-color">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</p>
				{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
				{if $pricedef != 0}
					<p class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if}">{if $Record.Price_Diff|substr:0:1 == '-'}{$Record.Price_Diff|round:2}{else}+{$Record.Price_Diff|round:2}{/if}% ({$currency}{str_replace('-','',$pricedef)|number_format})</p>
				{/if}
			</div>
			<div class="col-xl-5 col-lg-5 col-md-6 align-self-center  price-detail-section px-0 pb-3 pb-lg-0">
				<div class="btn-group btn-group-sm te-heading-property-details-features d-inline-block my-1" role="group" aria-label="Basic example">
					<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">

						<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$currency}{if $Record.ListingStatus == 'Closed'}{$Record.Sold_Price|number_format}{else}{$Record.ListPrice|number_format}{/if}</h5>
						<p class="mb-0 text-secondary">Price</p>
					</button>
					{if !in_array($Record.PropertyType, $arrPType) && !in_array($Record.SubType, $arrSType)}
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.Beds|number_format}</h5>
							<p class="mb-0 text-secondary">Beds</p>
						</button>
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.BathsFull|number_format}</h5>
							<p class="mb-0 text-secondary">Baths</p>
						</button>
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.BathsHalf|number_format}</h5>
							<p class="mb-0 text-secondary">Half Baths</p>
						</button>
					{/if}
					{if $Record.SQFT != ''}
						<button type="button" class="btn px-2 px-xl-3 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.SQFT|number_format}</h5>
							<p class="mb-0 text-secondary">Sq. Ft</p>
						</button>
					{/if}
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-6 align-self-center px-md-1 px-lg-0 pb-3 pb-lg-0 crypto-data">
				{if $Record.PropertyType != "ResidentialLease"}
					<ul class="d-flex p-0 te-font-size-12 justify-content-between- justify-content-center py-1 py-xl-3 text-white crypto-box">
						{if isset($bitcoinPrice) || isset($etherium)}
						{$bitcoinPrice = {math equation="x / y" x=$Record.ListPrice y=$bitcoin}}
						{$etheriumPrice = {math equation="x / y" x=$Record.ListPrice y=$etherium}}
						{$cardanoPrice = {math equation="x / y" x=$Record.ListPrice y=$cardano}}
						<li class="px-2- px-3 text-center"><img class="d-block mx-auto mb-1" src="{$Site_Url}API/upload/pictures/bitcoin.png" alt="bitcoin"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black">{$bitcoinPrice|number_format}</span></li>
						<li class="px-2- px-3 text-center"><img class="d-block mx-auto mb-1" src="{$Site_Url}API/upload/pictures/etherium.png" alt="etherium"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black">{$etheriumPrice|number_format}</span></li>
						{/if}
						{*<li class="px-2 text-center"><img class="d-block mx-auto mb-1" src="{$Site_Url}API/upload/pictures/cardano.png" alt="cardano"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black">{$cardanoPrice|number_format}</span></li>*}
					</ul>
				{/if}
			</div>
			<div class="col-xl-1- col-lg-1- col-md-6- px-lg-0 align-self-center te-heading-save-share-button order-2 order-lg-1 pb-3 pb-md-0 text-lg-right">
				<div class="dropdown d-inline-block mx-1- mx-lg-0-">
					<button id = "share-btn" class="btn btn-sm dropdown-toggle te-font-size-13 te-btn- text-white- shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt- btn-gray" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{*<i class="fas fa-external-link-alt pr-1"></i> SHARE*}
						<i class="fas fa-share-alt fa-2x align-middle pr-2"></i>Share
					</button>
					<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$detail_url}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
						<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$detail_url}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
						<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$detail_url}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
						<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$detail_url}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
					</div>
				</div>
				{if $arrConfig['OtherConfig']['login_enable'] == 'Yes'}
					<span class="fav-link-container" id="fav-link-container">
						{if $isUserLoggedIn == true}
							{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
								<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','FullView','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fa-2x pr-1 align-middle"></i> Save</a>
							{else}
								<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','FullView','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i> Save</a>
							{/if}
						{else}
							<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail popup-modal-sm rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt- btn-gray" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i> Save</a>
						{/if}
					</span>
				{/if}
			</div>
		</div>
		<div class="row bg-white position-sticky section-hash-link">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-none d-lg-block py-3 px-0">
				<ul class="list-inline m-0 text-left">
					<li class="list-inline-item px-2"><a class="text-dark" href="#overview-hash"><h6 class="txt-heading heading_txt_color">Overview</h6></a></li>
					<li class="list-inline-item px-2"><a class="text-dark" href="#property-information-hash"><h6 class="txt-heading heading_txt_color">Property Information</h6></a></li>
					<li class="list-inline-item px-2"><a class="text-dark" href="#location-hash"><h6 class="txt-heading heading_txt_color">Location</h6></a></li>
					<li class="list-inline-item px-2"><a class="text-dark" href="#te-mortgage-calculator-hash"><h6 class="txt-heading heading_txt_color">Mortgage Calculator</h6></a></li>
					{if is_array($arrSimilar) && count($arrSimilar) > 0}<li class="list-inline-item px-2"><a class="text-dark" href="#te-similar-listings-hash"><h6 class="txt-heading heading_txt_color">Similar Properties</h6></a></li>{/if}

				</ul>
			</div>
		</div>
	</div>
</section>
<div class="content">
	<div class="single-property-gallery-container">
		<div class="single-property-gallery" itemscope itemtype="https://schema.org/ImageGallery">
			{if $Record.mls_is_pic_url_supported == 'Yes'}
				{if $Record.PictureArr.large|count > 0 && $Record.TotalPhotos > 0}
					{assign var=count value=1}
					{section name=pic loop=$Record.PictureArr.large|count}
						{assign var=photo_large value=$Record.PictureArr.large[pic].url}
						{assign var=photo_thumb value=$Record.PictureArr.thumb[pic].url|default:$Record.PictureArr.large[pic].url}
						{if  $smarty.section.pic.total > 0}
							<figure itemprop="associatedMedia" itemscope itemtype="https://schema.org/ImageObject" class="{if $smarty.section.pic.index == 0}sp-gallery-main-img{/if}{if $smarty.section.pic.index > 4}d-none{/if} {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}">
								<a aria-label="button" href="{$photo_large}" itemprop="contentUrl" data-size="1920x1280" class="te-cover image-size {if $Record.ListingStatus == 'Closed'}disabled{/if}" style="background-image: url({$photo_large});"></a>
								<figcaption itemprop="caption description">{$Record.address_short} - {$count}</figcaption>
								<div class="top-left">
									{if $smarty.section.pic.index == 0 && $Record.ListingStatus == 'ActiveUnderContract'}
										<div class="wedges list-detail-wedge">UNDER CONTRACT</div>
									{elseif $smarty.section.pic.index == 0 && $Record.ListingStatus == 'Closed'}
										<div class="wedges list-detail-wedge">CLOSED</div>
									{elseif $smarty.section.pic.index == 0 && $Record.ListingStatus == 'Pending'}
										<div class="wedges list-detail-wedge">Pending</div>
									{/if}
									{if $smarty.section.pic.index == 0 && isset($Record.DOM) && $Record.DOM < 7}
										<div class="wedges-newListing list-detail-wedge">NEW LISTING</div>
									{/if}
								</div>
							</figure>

							{assign var=tmpIndex value=$tmpIndex+1}
							{assign var=count value=$count+1}

							{if $tmpIndex >= $cntKeyword}{assign var=tmpIndex value=0}{/if}
						{/if}
					{/section}
				{else}
					{*					<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="sp-gallery-main-img w-100 {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}">*}
					<div class="pdetail-no-img text-center">
						<a aria-label="button" href="{$Record.PhotoBaseUrl}no-photo/0/0/" itemprop="contentUrl" data-size="1920x1280" class="te-cover {if $Record.ListingStatus == 'Closed'}disabled{/if}">
							<img src="{$Record.PhotoBaseUrl}no-photo/0/0/" alt="{$Record.address_short}">
						</a>
						{*						<figcaption itemprop="caption description">{$Record.address_short} - {$count}</figcaption>*}
						{if $Record.ListingStatus == 'ActiveUnderContract'}
							<span class="wedges list-detail-wedge">UNDER CONTRACT</span>
						{elseif $Record.ListingStatus == 'Closed'}
							<span class="wedges list-detail-wedge">CLOSED</span>

						{elseif $Record.ListingStatus == 'Pending'}
							<span class="wedges list-detail-wedge">Pending</span>
						{/if}
						{if isset($Record.DOM) && $Record.DOM < 7}
							<span class="wedges-newListing list-detail-wedge">NEW LISTING</span>
						{/if}
					</div>

					{*					</figure>*}
				{/if}
			{else}

				{*need to cehck this if . as we will come when pic url support is no and image found in array . In this if we need to implement logic to check whether image is available ons3 or not.*}
				{if $Record.PictureArr|count > 0}
					{assign var=count value=1}
					{section name=pic loop=$Record.PictureArr|count}
						{*{$Record.PictureArr|count}*}
						{assign var=photo_large value=$Record.PictureArr[pic]}
						{assign var=photo_thumb value=$Record.PictureArr[pic]|default:$Record.PictureArr[pic]}
						{if  $smarty.section.pic.total > 0}
							<figure itemprop="associatedMedia" itemscope itemtype="https://schema.org/ImageObject" class="{if $smarty.section.pic.index == 0}sp-gallery-main-img{/if}{if $smarty.section.pic.index > 4}d-none{/if} {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}">
								<a aria-label="button" href="{$photo_large}" itemprop="contentUrl" data-size="1920x1280" class="te-cover image-size {if $Record.ListingStatus == 'Closed'}disabled{/if}" style="background-image: url({$photo_large});"></a>
								<figcaption itemprop="caption description">{$Record.address_short} - {$count}</figcaption>
								<div class="top-left">
									{if $smarty.section.pic.index == 0 && $Record.ListingStatus == 'ActiveUnderContract'}
										<div class="wedges list-detail-wedge">UNDER CONTRACT</div>
									{elseif $smarty.section.pic.index == 0 && $Record.ListingStatus == 'Closed'}
										<div class="wedges list-detail-wedge">CLOSED</div>
									{elseif $smarty.section.pic.index == 0 && $Record.ListingStatus == 'Pending'}
										<div class="wedges list-detail-wedge">Pending</div>
									{/if}
									{if $smarty.section.pic.index == 0 && isset($Record.DOM) && $Record.DOM < 7}
										<div class="wedges-newListing list-detail-wedge">NEW LISTING</div>
									{/if}
								</div>
							</figure>

							{assign var=tmpIndex value=$tmpIndex+1}
							{assign var=count value=$count+1}

							{if $tmpIndex >= $cntKeyword}{assign var=tmpIndex value=0}{/if}
						{/if}
					{/section}
				{else}
					{*<pre>{$Record|print_r}</pre>*}
					{*					<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="sp-gallery-main-img w-100 {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}">*}
					<div class="pdetail-no-img text-center">
						<a aria-label="button" href="{$Record.Pic}no-photo/0/0/" itemprop="contentUrl" data-size="1920x1280" class="te-cover {if $Record.ListingStatus == 'Closed'}disabled{/if}">
							{*<img src="{$Record.PhotoBaseUrl}/no-photo/0/0/" alt="{$Record.address_short}">*}
							<img src="{$Record.PhotoBaseUrl}/no-photo/no-property-img.jpg" alt="{$Record.address_short}">
						</a>
						{*						<figcaption itemprop="caption description">{$Record.address_short} - {$count}</figcaption>*}
						{if $Record.ListingStatus == 'ActiveUnderContract'}
							<span class="wedges list-detail-wedge">UNDER CONTRACT</span>
						{elseif $Record.ListingStatus == 'Closed'}
							<span class="wedges list-detail-wedge">CLOSED</span>

						{elseif $Record.ListingStatus == 'Pending'}
							<span class="wedges list-detail-wedge">Pending</span>
						{/if}
						{if isset($Record.DOM) && $Record.DOM < 7}
							<span class="wedges-newListing list-detail-wedge">NEW LISTING</span>
						{/if}
					</div>
					{*					</figure>*}
				{/if}
			{/if}


		</div>
		{if $Record.mls_is_pic_url_supported == 'Yes'}
			{if $Record.PictureArr.large|count > 0}
				<a class="btn btn-sm sp-gallery-btn te-btn text-white- text-uppercase p-2 shadow-none rounded-0 position-absolute te-font-size-14 te-pd-gallery-view-more lpt-btn lpt-btn-txt {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}" href="javascript::void(0);" role="button">{$Record.PictureArr.large|count} more photos</a>
				<!-- <a href="#" class="sp-gallery-btn">View Photos</a> -->
			{/if}
		{else}
			{if $Record.PictureArr|count > 0}
				<a class="btn btn-sm sp-gallery-btn te-btn text-white- text-uppercase p-2 shadow-none rounded-0 position-absolute te-font-size-14 te-pd-gallery-view-more lpt-btn lpt-btn-txt {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}" href="javascript::void(0);" role="button">{$Record.PictureArr|count} more photos</a>
				<!-- <a href="#" class="sp-gallery-btn">View Photos</a> -->
			{/if}
		{/if}
		{*{if $Record.PictureArr.large|count > 0}
			<a class="btn btn-sm sp-gallery-btn te-btn text-white- text-uppercase p-2 shadow-none rounded-0 position-absolute te-font-size-14 te-pd-gallery-view-more lpt-btn lpt-btn-txt {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}" href="javascript::void(0);" role="button">{$Record.PictureArr.large|count} more photos</a>
			<!-- <a href="#" class="sp-gallery-btn">View Photos</a> -->
		{/if}*}
		<div class="clearfix"></div>
	</div>
</div>
<section class="d-block d-md-none">
	<div class="container con-div">
		{*{if isset($backToUrl) && $backToUrl != ''}
			<div class="row pt-4 px-2">
				<div class="col-12 px-0">
					<a class="btn btn-sm te-font-size-14 shadow-none te-save-propery-detail rounded-0 mx-1 mx-lg-0 p-0" href="{$backToUrl}" role="button" title="Back to Previous Page"><i class="far fa-arrow-alt-circle-left fa-2x align-middle"></i> Back Page</a>
				</div>
			</div>
		{/if}*}
		<div class="row pt-4 te-font-family">
			<div class="col-xl-4 col-lg-4 col-md-6 align-self-center pb-3">
				<p class="text-left mb-0 te-address-heading-property-details txt-color">{$Record.address_short}</p>
				<p class="text-left mb-0 txt-color">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</p>
			</div>
			<div class="col-xl-5 col-lg-6 col-md-6 align-self-center pb-3">
				<div class="btn-group btn-group-sm te-heading-property-details-features d-inline-block my-1" role="group" aria-label="Basic example">
					<button type="button" class="btn pl-0 pr-2 py-0 text-dark shadow-none">

						<h5 class="width-max-content mb-0 te-pd-features-valuemobile-value txt-heading heading_txt_color">{$currency}{if $Record.ListingStatus == 'Closed'}{$Record.Sold_Price|number_format}{else}{$Record.ListPrice|number_format}{/if}</h5>
						<p class="mb-0 text-secondary">Price</p>
					</button>
					{if !in_array($Record.PropertyType, $arrPType) && !in_array($Record.SubType, $arrSType)}
						<button type="button" class="btn px-2 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.Beds|number_format}</h5>
							<p class="mb-0 text-secondary">Beds</p>
						</button>
						<button type="button" class="btn px-2 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.BathsFull|number_format}</h5>
							<p class="mb-0 text-secondary">Baths</p>
						</button>
						<button type="button" class="btn px-2 py-0 text-dark shadow-none">
							<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.BathsHalf|number_format}</h5>
							<p class="mb-0 text-secondary">Half Baths</p>
						</button>
					{/if}
					<button type="button" class="btn pl-2 pr-0 py-0 text-dark shadow-none">
						<h5 class="width-max-content mb-0 txt-heading heading_txt_color">{$Record.SQFT|number_format}</h5>
						<p class="mb-0 text-secondary">Sq. Ft</p>
					</button>
				</div>

			</div>
			<div class="col-xl-1 col-lg-6 col-md-6 align-self-center px-0- pb-3 pb-lg-0 crypto-data">
				<div class="btn-group btn-group-sm te-heading-property-details-features d-inline-block my-1 w-100" role="group" aria-label="Basic example">
					{if $Record.PropertyType != "ResidentialLease"}
						<ul class="d-flex p-0 te-font-size-12 justify-content-around justify-content-sm-start py-1 py-xl-3 text-white crypto-box">
							{if isset($bitcoinPrice) || isset($etherium)}
							{$bitcoinPrice = {math equation="x / y" x=$Record.ListPrice y=$bitcoin}}
							{$etheriumPrice = {math equation="x / y" x=$Record.ListPrice y=$etherium}}
							{$cardanoPrice = {math equation="x / y" x=$Record.ListPrice y=$cardano}}
							<li class="px-2 text-center"><img class="d-block mx-auto mb-1" src="{$Site_Url}API/upload/pictures/bitcoin.png" alt="bitcoin"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black">{$bitcoinPrice|number_format}</span></li>
							<li class="px-2 text-center"><img class="d-block mx-auto mb-1" src="{$Site_Url}API/upload/pictures/etherium.png" alt="etherium"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black">{$etheriumPrice|number_format}</span></li>
							{/if}
							{*<li class="px-2 text-center"><img class="d-block mx-auto mb-1" src="{$Site_Url}API/upload/pictures/cardano.png" alt="cardano"> <span class="te-font-size-7 text-black font-weight-bold">APPROX</span> <span class="d-block te-font-size-11 te-font-weight-600 text-black">{$cardanoPrice|number_format}</span></li>*}
						</ul>
					{/if}
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 px-lg-0 align-self-center te-heading-save-share-button order-2 order-lg-1 pb-3 pb-md-0">
				<div class="dropdown d-inline-block mx-1 mx-lg-0- w-100">
					<button id = "share-btn" class="btn btn-sm dropdown-toggle te-font-size-13 te-btn- text-white- shadow-none p-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt- btn-gray" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{*<i class="fas fa-external-link-alt pr-2"></i> SHARE*}
						<i class="fas fa-share-alt fa-2x align-middle pr-1"></i>Share
					</button>
					<div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$detail_url}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
						<a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$detail_url}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
						<a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$detail_url}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
						<a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$detail_url}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
					</div>
				</div>
				<span class="fav-link-container w-100 mx-1- mx-lg-0-" id="fav-link-container-mobile">
				{if $isUserLoggedIn == true}
					{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
						<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2 te-save-propery-detail rounded-0 mx-1- mx-lg-0- w-100 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','FullView','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart align-middle fa-2x pr-1"></i> Save</a>
					{else}
						<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2 te-save-propery-detail rounded-0 mx-1- mx-lg-0- w-100 lpt-btn- lpt-btn-txt- btn-gray" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','FullView','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart align-middle fa-2x pr-1"></i> Save</a>
					{/if}
				{else}
					<a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none p-2 te-save-propery-detail popup-modal-sm rounded-0 mx-1- mx-lg-0- w-100 lpt-btn- lpt-btn-txt- btn-gray" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart align-middle fa-2x pr-1"></i> Save</a>
				{/if}
				</span>
			</div>
		</div>
	</div>
</section>
<section class="te-property-details-full te-font-family pt-4 pb-5 py-md-4">
	<div class="container con-div">

		<div class="row mt-md-4">
			<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 leftbar">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12 Featured-listings d-block d-md-none">
						<h4 class="pb-2 pl-2 txt-heading heading_txt_color">Property Details</h4>
						<table class="table te-font-size-14 te-table-property-detail table-borderless table-hover">
							<tbody>
							<tr>
								<td nowrap>Price</td>
								<td>{$currency}{if $Record.ListingStatus == 'Closed'}{$Record.Sold_Price|number_format}{else}{$Record.ListPrice|number_format}{/if}</td>

							</tr>
							{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
							{if $pricedef != 0}
								<tr>
									<td>Price Change</td>
									<td class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if}">{if $Record.Price_Diff|substr:0:1 == '-'}{$Record.Price_Diff|round:2}{else}+{$Record.Price_Diff|round:2}{/if}% ({$currency}{str_replace('-','',$pricedef)|number_format})
									</td>
								</tr>
							{/if}
							{if $Record.SQFT > 0 && $Record.ListPrice > 0}
								<tr>
									<td nowrap>Price Per Sq Ft</td>
									{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
									<td>{$currency}{$pripsqft|number_format}</td>
								</tr>
							{/if}
							<tr>
								<td nowrap>MLS#</td>
								<td>{$Record.MLS_NUM}</td>
							</tr>
							{if isset($Record.YearBuilt) && $Record.YearBuilt != ''}
								<tr>
									<td nowrap>Year Built</td>
									<td>{$Record.YearBuilt}</td>
								</tr>
							{/if}
							{if isset($Record.ListingStatus) && $Record.ListingStatus != ''}
								<tr>
									<td nowrap>Status</td>
									<td>{$Record.ListingStatus}</td>
								</tr>
							{/if}
							{if isset($Record.SubType) && $Record.SubType != ''}
								<tr>
									<td nowrap>Type</td>
									<td>{$Record.SubType}</td>
								</tr>
							{/if}
							{if isset($Record.Tax) && $Record.Tax != ''}
								<tr>
									<td nowrap>Taxes</td>
									<td>{$currency}{$Record.Tax|number_format} / year</td>
								</tr>
							{/if}
							{if (isset($Record.HOAFee) && $Record.HOAFee != '') || (isset($Record.HOAFrequency) && $Record.HOAFrequency != '')}
								<tr>
									<td nowrap>HOA Fees</td>
									<td>{if $Record.HOAFee != ''}{$currency}{$Record.HOAFee|number_format}{/if} {if $Record.HOAFrequency != ''}/ {$Record.HOAFrequency}{/if}</td>
								</tr>
							{/if}
							{if isset($Record.Subdivision) && $Record.Subdivision != ''}
								<tr>
									<td nowrap>Subdivision</td>
									<td>{$Record.Subdivision}</td>
								</tr>
							{/if}
							{if isset($Record.Is_Waterfront) && $Record.Is_Waterfront !=''}
								<tr>
									<td nowrap>Waterfront</td>
									<td>{$Record.Is_Waterfront}</td>
								</tr>
							{/if}
							</tbody>
						</table>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4 mt-md-0" id="overview-hash">
						<h4 class="text-left mb-3 txt-heading heading_txt_color">{$Record.address_short}</h4>
						<h6 class=" text-left mb-4 txt-heading txt-color">
							{if !in_array($Record.PropertyType, $arrPType) && !in_array($Record.SubType, $arrSType)}
								{if $Record.Beds > 0}{$Record.Beds|number_format} {else} 0{/if} Beds, {if $Record.BathsFull > 0} {$Record.BathsFull|number_format} {else} 0 {/if} Baths, {if $Record.BathsHalf > 0}{$Record.BathsHalf|number_format} {else} 0 {/if} Half Baths,
							{/if}
							{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else} 0 {/if}Sq Ft</h6>
						{if isset($Record.Description) && $Record.Description != ''}
							<p class="te-font-size-14 txt-color">
								{$Record.Description}
								{*{str_replace("â€™","'",$Record.Description)}*}
							</p>
						{/if}
					</div>
				</div>
				<div class="card mb-5 mt-3 bg-white text-left te-card border-0" id="location-hash">
					<div class="card-header te-card-header pl-0 border-0 py-2 bg-transparent">
						<div class="col-xl-12 col-lg-12 col-md-12 px-0">
							<h4 class="title-font text-left te-line-height-normal mb-3 txt-heading heading_txt_color">Location</h4>
						</div>
					</div>
					<div class="card-body p-0">
						{*						<iframe src="https://www.google.com/maps/embed/v1/place?key={$google_api_key}&q={$Record.Address},{$Record.CityName},{$Record.ZipCode}&z=20" scrolling="no" width="100%" height="400" style="border:0" allowfullscreen></iframe>*}
						<iframe width="100%" height="400" id="gmap_canvas" src="https://maps.google.com/maps?key={$google_api_key}&q={$Record.StreetNumber} {if isset($Record.StreetDirPrefix) && $Record.StreetDirPrefix != ''}{$Record.StreetDirPrefix}{/if} {$Record.StreetName},{$Record.CityName},{$Record.State},{$Record.ZipCode}&output=embed" frameborder="0" scrolling="no"></iframe>
						{if isset($Record.Office_Name) && $Record.Office_Name != ''}
							<p class="mt-2 mb-0 txt-color">Listing Courtesy of {$Record.Office_Name}</p>
						{/if}
					</div>
				</div>
				{*{if $virtual_url_link != ''}
					<div class="card mb-5 mt-3 bg-white text-left te-card border-0" id="location-hash">
						<div class="card-header te-card-header pl-0 border-0 py-2 bg-transparent">
							<div class="col-xl-12 col-lg-12 col-md-12 px-0">
								<h4 class="title-font text-left te-line-height-normal mb-3 txt-heading heading_txt_color">Virtual Tour</h4>
							</div>
						</div>
						<div class="card-body p-0">

							<iframe width="100%" height="400" id="gmap_canvas" src="{$virtual_url_link}" frameborder="0" scrolling="no"></iframe>
						</div>
					</div>
				{/if}*}
				<div>
					<div class="card bg-white text-left te-card rounded-0 border-0" id="property-information-hash">
						<h4 class="mb-4 te-pd-all-features-main-title txt-heading heading_txt_color">Property Information for {$Record.address_short}</h4>
						<div class="card-header te-card-header te-bg-light px-2 border-0 py-3">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h6 class="te-pd-title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">General Information</h6>
							</div>
						</div>
						<div class="card-body border te-gutter-colum px-4 py-3">
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">General Information</h6>
										{*<li class="d-flex">Sq Ft Liv Area : 1602</li>
                                        <li class="d-flex">Sq Ft Total : 1602</li>*}
										<li class="d-flex txt-color">For Lease: {if isset($Record.LeaseTerm) && $Record.LeaseTerm !='' && $Record.LeaseTerm != NULL}Yes{else}No{/if}</li>
										<li class="d-flex txt-color">Pet Restrictions : {if isset($Record.PetsAllowed) && $Record.PetsAllowed == 'No'}No{else}Yes{/if}</li>
									</div>
									{*{if isset($Record.PetsAllowed) && $Record.PetsAllowed !='No'}
                                        <li class="d-flex">Pet Restrictions : {$Record.PetsAllowed}</li>
                                    {/if}*}
									{*{if isset($Record.StreetNumber) && $Record.StreetNumber !=''}
                                        <li class="d-flex">Street Number Numeric : {$Record.StreetNumber}</li>
                                    {/if}
                                    {if isset($Record.StreetName) && $Record.StreetName !=''}
                                        <li class="d-flex">Street Name : {$Record.StreetName}</li>
                                    {/if}
                                    {if isset($Record.Area) && $Record.Area !=''}
                                        <li class="d-flex">Area : {$Record.Area}</li>
                                    {/if}*}
									{if isset($Record.County) && $Record.County !=''}
										<li class="d-flex txt-color">County Or Parish : {$Record.County}</li>
									{/if}
									<!--<li class="d-flex">Municipal Code : 31</li>-->
									{if isset($Record.Township) && $Record.Township !=''}
										<li class="d-flex txt-color">Township Range : {$Record.Township}</li>
									{/if}
									{if isset($Record.ZipCode) && $Record.ZipCode !=''}
										<li class="d-flex txt-color">Zip Code : {$Record.ZipCode}</li>
									{/if}
									{*{if isset($Record.Section) && $Record.Section != ''}
                                        <li class="d-flex">Section : {$Record.Section}</li>
                                    {/if}*}
									{if isset($Record.DevelopmentName) && $Record.DevelopmentName !=''}
										<li class="d-flex txt-color">Development Name : {$Record.DevelopmentName}</li>
									{/if}
									{if isset($Record.CityName) && $Record.CityName !=''}
										<li class="d-flex txt-color">City : {$Record.CityName}</li>
									{/if}

									<li class="d-flex txt-color">List Price : {$currency}{$Record.ListPrice|number_format}</li>
									<li class="d-flex txt-color">List Price : {$currency}{if $Record.ListingStatus == 'Closed'}{$Record.Sold_Price|number_format}{else}{$Record.ListPrice|number_format}{/if}</li>

								</ul>
							</div>
							<div>
								{if (isset($Record.MaintenanceExpense) && $Record.MaintenanceExpense != '') || (isset($Record.Tax) && $Record.Tax != '')
								|| (isset($Record.TaxYear) && $Record.TaxYear != '') || (isset($Record.MembershipRequiredYN) && $Record.MembershipRequiredYN != '' && $Record.SystemName != {Constants::MLS_ACTRIS})
								|| (isset($Record.MembershipFee) && $Record.MembershipFee != '' && $Record.SystemName != {Constants::MLS_ACTRIS})}
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Maintenance / Tax Information</h6>
											{if isset($Record.MaintenanceExpense) && $Record.MaintenanceExpense != ''}
												<li class="d-flex txt-color">Maintenance Charge Month : {$currency}{$Record.MaintenanceExpense}</li>
											{/if}
											<!--<li class="d-flex">Maintenance Fee Paid Per : Monthly</li>
                                            <li class="d-flex">Maintenance Includes : Common Area </li>-->
											{if isset($Record.Tax) && $Record.Tax != ''}
												<li class="d-flex txt-color">Tax Amount : {$currency}{$Record.Tax}</li>
											{/if}
										</div>

										<!--<li class="d-flex">Tax Information : Tax Reflects No</li>-->
										{if isset($Record.TaxYear) && $Record.TaxYear != ''}
											<li class="d-flex txt-color">Tax Year : {$Record.TaxYear}</li>
										{/if}

										{if isset($Record.MembershipRequiredYN) && $Record.MembershipRequiredYN != '' && $Record.SystemName != {Constants::MLS_ACTRIS}}
											<li class="d-flex txt-color">Membership Required : {$Record.MembershipRequiredYN}</li>
										{/if}
										{if isset($Record.MembershipFee) && $Record.MembershipFee != '' && $Record.MembershipFee > 0 && $Record.SystemName != {Constants::MLS_ACTRIS}}
											<li class="d-flex txt-color">Membership Fee : {$currency}{$Record.MembershipFee|number_format}</li>
										{/if}
									</ul>
								{/if}
							</div>
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Building Information</h6>
										{*								<li class="d-flex">Property Detached : {if isset($Record.Subtype) && $Record.Subtype == 'Detached'}Yes{else}No{/if}</li>*}
										{if isset($Record.PropertyType) && $Record.PropertyType != ''}
											<li class="d-flex txt-color">Property Type : {$Record.PropertyType}</li>
										{/if}
									</div>

									{if isset($Record.Subdivision) && $Record.Subdivision != ''}
										<li class="d-flex txt-color">Subdivision : {$Record.Subdivision}</li>
									{/if}
								</ul>
							</div>

							{if (isset($Record.Elementary_School) && $Record.Elementary_School != '') || (isset($Record.Middle_School) && $Record.Middle_School != '') || (isset($Record.High_School) && $Record.High_School !='')}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">School Information</h6>
											{if isset($Record.Elementary_School) && $Record.Elementary_School != ''}
												<li class="d-flex txt-color">Elementary School : {$Record.Elementary_School} </li>
											{/if}
										</div>
										{if isset($Record.Middle_School) && $Record.Middle_School != ''}
											<li class="d-flex txt-color">Middle School : {$Record.Middle_School} </li>
										{/if}
										{if  isset($Record.High_School) && $Record.High_School != ''}
											<li class="d-flex txt-color">Senior High School : {$Record.High_School} </li>
										{/if}
									</ul>
								</div>
							{/if}
						</div>
					</div>

					<div class="card bg-white text-left te-card border-0 rounded-0">
						<div class="card-header te-card-header te-bg-light px-2 border-0 py-3">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h6 class="te-pd-title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">Virtual Tour / Features / Utilities</h6>
							</div>
						</div>
						<div class="card-body border te-gutter-colum py-3 px-4">
							{if isset($Record.VirtualTourUrl) && $Record.VirtualTourUrl != ''}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Virtual Tour</h6>
										<li class="d-block txt-color">Virtual Tour :<br> <div class="pl-4"><a class="virtualTour-link link-color" href="{$Record.VirtualTourUrl}">{$Record.VirtualTourUrl}</a></div></li>
										{*										<li class="d-flex">Virtual Tour : <span><a class="virtualTour-link" href="{$Record.VirtualTourUrl}">{$Record.VirtualTourUrl}</a></span></li>*}
									</ul>
								</div>
							{/if}
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Interior</h6>

										<li class="d-flex txt-color">Room Count : {if isset($Record.TotalRooms) && $Record.TotalRooms != ''}{$Record.TotalRooms}{else}0{/if}</li>
										{if isset($Record.Appliances) && $Record.Appliances != ''}
											<li class="d-flex txt-color">Equipment Appliances : {str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/', ' $0', $Record.Appliances))}</li>
										{/if}
										{*{if isset($Record.Amenities) && $Record.Amenities != ''}
											<li class="d-flex">Amenities : {str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/', ' $0', $Record.Amenities))}</li>
										{/if}*}
									</div>
									{if isset($Record.Flooring) && $Record.Flooring != ''}
										<li class="d-flex txt-color">Floor Description : {$Record.Flooring}</li>
									{/if}
									{if isset($Record.InteriorFeatures) && $Record.InteriorFeatures != ''}
										<li class="d-flex txt-color">Interior Features : {str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/', ' $0', $Record.InteriorFeatures))}</li>
									{/if}
									{if !in_array($Record.PropertyType, $arrPType) && !in_array($Record.SubType, $arrSType)}
										<li class="d-flex txt-color">Beds Total : {if isset($Record.Beds) && $Record.Beds > 0} {$Record.Beds|number_format} {else} 0 {/if}</li>
										{*									<li class="d-flex">Main Living Area : Entry Level</li>*}
										{if isset($Record.BathsFull) &&  $Record.BathsFull != ''}
											<li class="d-flex txt-color">Num of Full Baths : {$Record.BathsFull|number_format}</li>
										{/if}
										{if isset($Record.BathsHalf) && $Record.BathsHalf != ''}
											<li class="d-flex txt-color">Num of Half Baths : {$Record.BathsHalf|number_format:1}</li>
										{/if}
									{/if}
									{if isset($Record.Furnished) && $Record.Furnished != ''}
										<li class="d-flex txt-color">Furnished : {$Record.Furnished}</li>
									{/if}
									{*									<li class="d-flex">AdjustedAreaSF : </li>*}
									<li class="d-flex txt-color">Spa : {if isset($Record.SpaYN) && $Record.SpaYN != ''}{$Record.SpaYN}{else}No{/if}</li>
								</ul>
							</div>
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Exterior</h6>
										{if isset($Record.ExteriorFeatures) && $Record.ExteriorFeatures != ''}
											<li class="d-flex txt-color">Exterior Features : {str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/', ' $0', $Record.ExteriorFeatures))}</li>
										{/if}
									</div>
									{*									<li class="d-flex">Balcony Porch/Patio : {if isset($Record.PatioAndPorchFeatures) && $Record.PatioAndPorchFeatures != ''}Yes{else}No{/if}</li>*}
									{if isset($Record.Construction) && $Record.Construction != ''}
										<li class="d-flex txt-color">Construction Type : {$Record.Construction}</li>
									{/if}
									{if isset($Record.PropertyStyle) && $Record.PropertyStyle != ''}
										<li class="d-flex txt-color">Design : {str_replace(',',', ',preg_replace('/(?<!\ )[A-Z]/', ' $0', $Record.PropertyStyle))}</li>
									{/if}
									{*									<li class="d-flex">Design Description : </li>*}
									{if isset($Record.Direction_Faces) && $Record.Direction_Faces != ''}
										<li class="d-flex txt-color">Front Exposure : {$Record.Direction_Faces}</li>
									{/if}
									<li class="d-flex">Pool : {if isset($Record.PoolDesc) && $Record.PoolDesc != ''}{if $Record.PoolDesc|strstr:'Pool'}Yes{else}No{/if}{else}No{/if}</li>
									{if isset($Record.PoolDesc) && $Record.PoolDesc != ''}
										<li class="d-flex txt-color">Pool Description : {str_replace(',',', ',$Record.PoolDesc)}</li>
									{/if}
									{*									<li class="d-flex">Pool Dimensions : </li>*}
									{if isset($Record.Roof) && $Record.Roof !== ''}
										<li class="d-flex txt-color">Roof Description :  {$Record.Roof|replace:',':' Roof, '}</li>
									{/if}
									{if isset($Record.Window_Features) && $Record.Window_Features != ''}
										<li class="d-flex txt-color">Windows Treatment : {str_replace(',',', ',$Record.Window_Features)}</li>
									{/if}
									{if isset($Record.HorseYN) && $Record.HorseYN != ''}
										<li class="d-flex txt-color">Horse Amenities : {str_replace(',',', ',$Record.HorseYN)}</li>
									{/if}
									{if isset($Record.SecuritySafety) && $Record.SecuritySafety != ''}
										<li class="d-flex txt-color">Security : {str_replace(',',', ',$Record.SecuritySafety)}</li>
									{/if}
								</ul>
							</div>

							{if isset($Record.Dining) && $Record.Dining != ''}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Room Information</h6>
											{if isset($Record.Dining) && $Record.Dining != ''}
												<li class="d-flex txt-color">Dining Description : {$Record.Dining}</li>
											{/if}
											{*											<li class="d-flex">Master Bathroom Description : </li>*}
											{*                                            <li class="d-flex">Bedroom Description : </li>*}

										</div>
										{*										<li class="d-flex">Rooms Description : </li>*}

									</ul>
								</div>
							{/if}
							{if isset($Recoed.Water) && $Recoed.Water != '' || (isset($Record.Frontage_Length) && $Record.Frontage_Length != '')}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Waterfront</h6>
											{*{if isset($Recoed.Water) && $Recoed.Water != ''}
											<li class="d-flex">Water Access : {$Recoed.Water}</li>{/if}*}
										</div>
										{if isset($Record.Frontage_Length) && $Record.Frontage_Length != ''}
											<li class="d-flex txt-color">Waterfront Frontage : {$Record.Frontage_Length|number_format}</li>
										{/if}
										{if isset($Record.WaterfrontDesc) && $Record.WaterfrontDesc != ''}
											<li class="d-flex txt-color">Waterfront Description : {$Record.WaterfrontDesc}</li>
										{/if}
										{*										<li class="d-flex">Water Description : </li>*}
									</ul>
								</div>

							{/if}
							{if (isset($Record.GarageDescription) && $Record.GarageDescription != '') || (isset($Record.ParkingFeatures) && $Record.ParkingFeatures != '')}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Parking</h6>
											{if isset($Record.GarageDescription) && $Record.GarageDescription != ''}
												<li class="d-flex txt-color">Garage Description : {str_replace(',',', ',$Record.GarageDescription)}</li>
											{/if}
										</div>

										{if isset($Record.ParkingFeatures) && $Record.ParkingFeatures != ''}
											<li class="d-flex txt-color">Parking Description : {str_replace(',',', ',$Record.ParkingFeatures)}</li>
										{/if}

									</ul>
								</div>
							{/if}
							{if (isset($Record.Cooling) && $Record.Cooling != '') || (isset($Record.Heating) && $Record.Heating != '')}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Utilities</h6>
											{if isset($Record.Cooling) && $Record.Cooling != ''}
												<li class="d-flex txt-color">Cooling Description : {str_replace(',',', ',$Record.Cooling)}</li>
											{/if}
										</div>
										{if isset($Record.Heating) && $Record.Heating != ''}
											<li class="d-flex txt-color">Heating Description : {str_replace(',',', ',$Record.Heating)}</li>
										{/if}
										{if isset($Record.Sewer) && $Record.Sewer != ''}
											<li class="d-flex txt-color">Sewer Description : {$Record.Sewer}</li>
										{/if}
										{*<li class="d-flex">Cable Available : Yes</li>*}
									</ul>
								</div>
							{/if}
						</div>
					</div>

					<div class="card bg-white text-left te-card border-0 rounded-0">
						<div class="card-header te-card-header te-bg-light px-2 border-0 py-3">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h6 class="te-pd-title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">Property / Lot Information</h6>
							</div>
						</div>
						<div class="card-body border te-gutter-colum py-3 px-4">

							{if isset($Record.HOAFee) && $Record.HOAFee != '' || (isset($Record.HOAFrequency) && $Record.HOAFrequency != '')}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Community Information</h6>
											{*										<li class="d-flex">Housing Older Persons Act: </li>*}
											{if isset($Record.HOAFee) && $Record.HOAFee != ''}
												<li class="d-flex txt-color">Association Fee: {$currency}{$Record.HOAFee|number_format}</li>
											{/if}
											{if isset($Record.HOAFrequency) && $Record.HOAFrequency != ''}
												<li class="d-flex txt-color">Assoc Fee Paid Per: {$Record.HOAFrequency}</li>
											{/if}
										</div>
										{*<li class="d-flex">Subdivision Information: </li>
										<li class="d-flex">Subdivision Number: </li>
										<li class="d-flex">Subdivision Number Numeric: </li>*}

									</ul>
								</div>
							{/if}
							<div>
								<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
									<div class="NoBreakSection">
										<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Building Information</h6>
										{if isset($Record.ParcelNumber) && $Record.ParcelNumber != ''}
											<li class="d-flex txt-color">Parcel Number Free Text: {$Record.ParcelNumber}</li>
										{/if}
										{if isset($Record.Zoning_Description) && $Record.Zoning_Description != ''}
											<li class="d-flex txt-color">Zoning Information: {$Record.Zoning_Description}</li>
										{/if}
										{if isset($Record.Garage) && $Record.Garage != ''}
											<li class="d-flex txt-color">Num Garage Spaces: {$Record.Garage|number_format}</li>
										{/if}
									</div>
									{*
									<li class="d-flex">Building Area Alternative: </li>
									<li class="d-flex">Building Area Alt Source: </li>*}
								</ul>
							</div>

							{if isset($Record.LotDescription) && $Record.LotDescription != '' || (isset($Record.LotSize_Area) && $Record.LotSize_Area != '')}
								<div>
									<ul class="list-unstyled text-dark pb-4 m-0 te-list-style-property-detail te-font-size-14">
										<div class="NoBreakSection">
											<h6 class="te-pd-sub-title pb-0 txt-heading heading_txt_color">Lot Information</h6>
											{*										<li class="d-flex">Flood Zone : </li>*}
											{*{if isset($Record.LotDescription) && $Record.LotDescription != ''}
												<li class="d-flex">Lot Description : {$Record.LotDescription}</li>
											{/if}*}
											{if isset($Record.LotSize_Area) && $Record.LotSize_Area != ''}
												<li class="d-flex txt-color">Lot Sq Footage : {$Record.LotSize_Area|number_format}</li>
											{/if}
										</div>
										{*									<li class="d-flex">LP Amt Sq Ft : </li>*}

									</ul>
								</div>
							{/if}

						</div>
					</div>

				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 aside">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Featured-listings d-none d-md-block">
						<h4 class="pb-2 pl-2 txt-heading heading_txt_color">Property Details</h4>
						<table class="table te-font-size-14 te-table-property-detail table-borderless table-hover">
							<tbody>
							<tr>
								<td nowrap>Price</td>
								<td>{$currency}{if $Record.ListingStatus == 'Closed'}{$Record.Sold_Price|number_format}{else}{$Record.ListPrice|number_format}{/if}</td>
							</tr>
							{if $Record.SQFT > 0 && $Record.ListPrice > 0}
								<tr>
									<td nowrap>Price Per Sq Ft</td>
									{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
									<td>{$currency}{$pripsqft|number_format}</td>
								</tr>
							{/if}
							<tr>
								<td nowrap>MLS#</td>
								<td>{$Record.MLS_NUM}</td>
							</tr>
							{if isset($Record.YearBuilt) && $Record.YearBuilt != ''}
								<tr>
									<td nowrap>Year Built</td>
									<td>{$Record.YearBuilt}</td>
								</tr>
							{/if}
							{if isset($Record.ListingStatus) && $Record.ListingStatus != ''}
								<tr>
									<td nowrap>Status</td>
									<td>{$Record.ListingStatus}</td>
								</tr>
							{/if}
							{if isset($Record.PropertyType) && $Record.PropertyType != ''}
								<tr>
									<td nowrap>Type</td>
									<td>{$Record.PropertyType}</td>
								</tr>
							{/if}
							{if isset($Record.Tax) && $Record.Tax != ''}
								<tr>
									<td nowrap>Taxes</td>
									<td>{$currency}{$Record.Tax|number_format} / year</td>
								</tr>
							{/if}
							{if (isset($Record.HOAFee) && $Record.HOAFee != '') || (isset($Record.HOAFrequency) && $Record.HOAFrequency != '')}
								<tr>
									<td nowrap>HOA Fees</td>
									<td>{if $Record.HOAFee != ''}{$currency}{$Record.HOAFee|number_format}{/if} {if $Record.HOAFrequency != ''}/ {$Record.HOAFrequency}{/if}</td>
								</tr>
							{/if}
							{if isset($Record.Subdivision) && $Record.Subdivision != ''}
								<tr>
									<td nowrap>Subdivision</td>
									<td>{$Record.Subdivision}</td>
								</tr>
							{/if}
							{if isset($Record.Is_Waterfront) && $Record.Is_Waterfront !=''}
								<tr>
									<td nowrap>Waterfront</td>
									<td>{$Record.Is_Waterfront}</td>
								</tr>
							{/if}
							</tbody>
						</table>
					</div>
					{*<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Featured-listings d-none d-md-block">
						<div class="card w-100 agent border mt-4 mt-md-0 mt-lg-4 rounded-0">
							<img src="{$agentImgUrl}{if isset($agentInfo.agent_photo) && $agentInfo.agent_photo != ''}{$agentInfo.agent_photo}{else}default-client.jpg{/if}" class="w-100 h-100" alt="...">
							<div class="card-body bg-white px-4 mx-4 te-property-agent-detail">
								<h5>{if isset($agentInfo.agent_name) && $agentInfo.agent_name != ''}{$agentInfo.agent_name}{/if}</h5>
								<p class="mb-2">Real Estate Agent</p>
								<ul class="list-unstyled w-100 p-0">
									<li class="py-2"><i class="fas fa-phone pr-2 text-secondary"></i> {if isset($agentInfo.agent_phone) && $agentInfo.agent_phone != ''}{$agentInfo.agent_phone}{/if}
									</li>
									<li class="py-2 text-truncate"><i class="far fa-envelope pr-2 text-secondary"></i> {if isset($agentInfo.agent_email) && $agentInfo.agent_email != ''}{$agentInfo.agent_email}{/if}
									</li>
								</ul>
								<a type="button" href="JavaScript: void(0);" data-url="{$detail_url}?action=listing-inquiry" class="btn border-secondary te-btn text-white text-uppercase w-100 contact-agent-button shadow-none rounded-0 te-z-index-99 hbn-popup-modal" data-toggle="modal" data-target="Inquiry" >Contact Agent</a>
							</div>
						</div>
					</div>*}
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="card w-100 rounded-0 mt-4 mt-md-0 mt-lg-4 border te-mortgage-calculator">
							<div class="card-header te-bg-light border-0 px-4 py-3">
								<div class="col-xl-12 col-lg-12 col-md-12 sec-title px-0">
									<h5 class="title-font text-left te-line-height-normal pb-0 mb-0 txt-heading heading_txt_color">Contact Us</h5>
								</div>
							</div>
							{include file="listing/schedule_showing.tpl"}
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						{if $Record.PropertyType != "ResidentialLease"}
							{include file="listing/mortgagae_calculator.tpl"}
						{/if}
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			{if is_array($arrSimilar) && count($arrSimilar) > 0}
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
					<div class="card mb-4 text-left te-card mt-4 border-0" id="te-similar-listings-hash">
						<div class="card-header pl-0 border-0 bg-transparent">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<h4 class="title-font text-left te-line-height-normal mb-0 txt-heading heading_txt_color">Similar Properties</h4>
							</div>
						</div>
						<div class="card-body px-4 py-2 te-featured-properties mw-100 overflow-hidden h-auto">
							<div class="row">
								{foreach name='SearchResult' from=$arrSimilar item=SRecord}
									<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2">
										<a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $SRecord)}" class="te-property-card d-block position-relative overflow-hidden">
											{if $SRecord.mls_is_pic_url_supported == 'Yes'}
												{assign var=photo_url value=$SRecord.MainPicture.large.url}
												{if $SRecord.MainPicture.large.url != ''}
													{assign var=photo_url value=$SRecord.MainPicture.large.url}
												{else}
													{assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
												{/if}
											{else}
												{*{assign var=photo_url value={$SRecord.MainPicture|cat:'/350/300/f/80'}}*}
												{assign var=photo_url value={$SRecord.MainPicture}}

											{/if}

											<img class="te-property-fig te-property-image position-absolute" src="{$photo_url}" alt="{$SRecord.Address}-1">
											<div class="-te-property-gradient position-absolute"></div>
											<div class="te-gradient te-property-details te-animate text-white position-absolute te-z-index-99 te-p-5 pt-5">
												<div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
													<div class="te-property-details-price">{$currency}{if $SRecord.ListingStatus == 'Closed'}{$SRecord.Sold_Price|number_format}{else}{$SRecord.ListPrice|number_format}{/if}</div>
													<div class="te-property-details-features te-font-size-14">
														{if !in_array($SRecord.PropertyType, $arrPType) && !in_array($SRecord.SubType, $arrSType)}
															{$SRecord.Beds|number_format} Beds <span>|</span> {$SRecord.BathsFull|number_format} Baths <span>|</span>
														{/if}
														{$SRecord.SQFT|number_format} Sq Ft
													</div>
													<div class="te-property-title text-truncate te-font-size-14">{$SRecord.StreetNumber} {$SRecord.StreetName}, {$SRecord.CityName}, {$SRecord.State} {$SRecord.ZipCode}</div>
												</div>
												{*											<a class="te-property-details-cta te-animate text-uppercase position-absolute text-white te-z-index-99 font-weight-bold px-3 py-2" href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $SRecord)}">View Details</a>*}
												<div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
											</div>
										</a>
										<div class="top-left">
											{if isset($SRecord.ListingStatus) && $SRecord.ListingStatus == 'ActiveUnderContract'}
												<span class="wedges list-detail-wedge">Under Contract</span>
											{elseif isset($SRecord.ListingStatus) && $SRecord.ListingStatus == 'Pending'}
												<span class="wedges list-detail-wedge">Pending</span>
											{/if}
											{if isset($SRecord.DOM) && $SRecord.DOM < 7}
												<span class="wedges-newListing list-detail-wedge">New Listing</span>
											{/if}
										</div>
										{if $arrConfig['OtherConfig']['login_enable'] == 'Yes'}
											<div class="position-absolute te-property-favourite te-z-index-99" id="fav-link-container-{$SRecord.ListingID_MLS}">

												{if $isUserLoggedIn == true}
													{if isset($userFavList) && in_array($SRecord.ListingID_MLS, $userFavList)}
														<a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$SRecord.ListingID_MLS}', 'Remove','Similar','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fav-icon"></i></a>
													{else}
														<a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$SRecord.ListingID_MLS}', 'Add','Similar','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fav-icon"></i></a>
													{/if}
												{else}
													<a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$SRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fav-icon"></i></a>
												{/if}
											</div>
										{/if}
									</div>
								{/foreach}
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="ftype" class="ftype" value="similar">
			{/if}

			{if $Record.PropertyType == 'Residential' && $Record.ListingStatus != 'Closed'}
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 px-3">
					{if $Record.SubType != '' && $Record.SubType != 'Other'}
						{assign var=subtype value={preg_replace('/(?<!\ )[A-Z]/', ' $0', $Record.SubType)}}
					{else}
						{assign var=subtype value=""}
					{/if}
					<h4 class="mb-4 te-pd-footer-disclaimer-title txt-heading heading_txt_color">More information about {$Record.address_short}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</h4>
					<p class="text-dark mb-3 txt-color seo-text">{$Record.address_short} is a {if $Record.Is_Waterfront == 'Yes'}waterfront{/if} {if array_key_exists($Record.SubType, $SEOSubtype)}{$SEOSubtype[$Record.SubType]}{else}{$subtype}{/if} for {if $Record.PropertyType == 'ResidentialLease'}rent{else}sale{/if} in {$Record.CityName}, {$Record.State} {$Record.ZipCode}. This property was listed for {if $Record.PropertyType == 'ResidentialLease'}rent{else}sale{/if} {if $Record.ListingDate != ''}on {$Record.ListingDate|date_format:"M d, Y"}{/if} {if $Record.Office_Name != ''}by {$Record.Office_Name}{/if} for {$currency}{$Record.ListPrice|number_format}. Located in {if $Record.Subdivision != ''}{$Record.Subdivision},{/if} {$Record.address_short} is a {if !in_array($SRecord.PropertyType, $arrPType) && !in_array($SRecord.SubType, $arrSType)}{if $Record.Beds > 0}{$Record.Beds|number_format}{else}0{/if}-bed, {if $Record.BathsFull > 0}{$Record.BathsFull|number_format}{else}0{/if}-bath,{/if} {if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if} sqft {if array_key_exists($Record.SubType, $SEOSubtype)}{$SEOSubtype[$Record.SubType]}{else}{$subtype}{/if} {if $Record.YearBuilt != ''} built in {$Record.YearBuilt}{/if}.</p>

				</div>

			{/if}
			{*<p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}">
				No guarantee, warranty or representation of any kind is made regarding the completeness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.
				<br/><br/>
				The data provided by Miami Association of REALTORS® MLS comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are © {'Y'|date} Miami Association of REALTORS®. All Rights Reserved. The information provided is for consumers’ personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
				<br/><br/>Miami Association of Realtors MLS data last updated on {$MLS_last_update_date}.
			</p>*}
			{*<p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}">*}
			{*{$Record.SystemName|print_r}*}
			{*{if isset($sys_name) && $sys_name == 'SEFMIAMI'}
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.</p>
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">The data provided by Miami Association of REALTORS® MLS comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©{'Y'|date} Miami Association of REALTORS®. All Rights Reserved. The information provided is for consumers’ personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">Miami Association of Realtors MLS data last updated on {$MLS_last_update_date}.</p>
            {elseif isset($sys_name) && $sys_name == 'FTL'}
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.</p>
                <img class = "disclaimer_img" src="{$Templates_Image}/both.png"> <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">The data provided by Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each indi-vidual listing are ©{'Y'|date} Palm Beach Board of Realtors Multiple Listing Service. All Rights Reserved. The information provided is for consumers’ personal, noncommercial use and may not be used for any purpose other than to identify pro-spective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This information is not verified for authenticity or accuracy and is not guaranteed. Copyright ©{'Y'|date} BeachesMLS, Inc.</p>
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">Listing information last updated on {$MLS_last_update_date}.</p>
            {else}
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">No guarantee, warranty or representation of any kind is made regarding the com-pleteness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.</p>
                <img class = "disclaimer_img" src="{$TPL_images}/both.png"> <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">The data provided by Miami Association of REALTORS® MLS and Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©{'Y'|date} Miami Association of REALTORS® MLS  and Palm Beach Board of Realtors Multiple List-ing Service. All Rights Reserved. The information provided is for consumers’ per-sonal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed relia-ble but is not guaranteed accurate, and should be independently verified.</p><br />
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This information is not verified for authenticity or accuracy and is not guaranteed. Copyright ©{'Y'|date} BeachesMLS, Inc.</p>
                <p class="px-3 text-micro txt-color {if $Record.PropertyType != 'Residential'}pt-4{/if}" align="justify">Listing information last updated on {$MLS_last_update_date}.</p>
            {/if}*}
			{*</p>*}
			<div class="py-xl-3">
				{if isset($Record.SystemName) && $Record.SystemName == 'SEFMIAMI'}
					<p class="px-3 text-micro txt-color" align="justify">No guarantee, warranty or representation of any kind is made regarding the completeness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.</p>
					<p class="px-3 text-micro txt-color" align="justify">The data provided by Miami Association of REALTORS® MLS comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©{'Y'|date} Miami Association of REALTORS®. All Rights Reserved. The information provided is for consumers’ personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>
					<p class="px-3 text-micro txt-color" align="justify">Miami Association of Realtors MLS data last updated on {$MLS_last_update_date}.</p>
				{elseif isset($Record.SystemName) && $Record.SystemName == 'FTL'}
					<p class="px-3 text-micro txt-color" align="justify">No guarantee, warranty or representation of any kind is made regarding the completeness or accuracy of descriptions or measurements (including square footage measurements and property condition), such should be independently verified, and expressly disclaim any liability in connection therewith. No financial or legal advice provided and fully support the principles of the Fair Housing Act and the Equal Opportunity Act.</p>
					<img class = "disclaimer_img" src="{$Templates_Image}/both.png"> <p class="px-3 text-micro txt-color" align="justify">The data provided by Palm Beach Board of Realtors Multiple Listing Service comes from a copyrighted compilation of listings. The compilation of listings and each individual listing are ©{'Y'|date} Palm Beach Board of Realtors Multiple Listing Service. All Rights Reserved. The information provided is for consumers’ personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All data provided is deemed reliable but is not guaranteed accurate, and should be independently verified.</p>
					<p class="px-3 text-micro txt-color" align="justify">All listings featuring the BMLS logo are provided by BeachesMLS, Inc. This information is not verified for authenticity or accuracy and is not guaranteed. Copyright ©{'Y'|date} BeachesMLS, Inc.</p>
					<p class="px-3 text-micro txt-color" align="justify">Listing information last updated on {$MLS_last_update_date}.</p>
				{elseif isset($Record.SystemName) && $Record.SystemName == {Constants::MLS_ACTRIS}}
					<p class="px-3 text-micro txt-color" align="justify">The information being provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing.</p>
					<p class="px-3 text-micro txt-color" align="justify">Based on information from the Austin Board of REALTORS® (alternatively, from ACTRIS) from {$MLS_last_update_date}. Neither the Board nor ACTRIS guarantees or is in any way responsible for its accuracy. The Austin Board of REALTORS®, ACTRIS and their affiliates provide the MLS and all content therein "AS IS" and without any warranty, express or implied. Data maintained by the Board or ACTRIS may not reflect all real estate activity in the market.</p>
					<p class="px-3 text-micro txt-color" align="justify">All information provided is deemed reliable but is not guaranteed and should be independently verified.</p>
				{/if}
			</div>
		</div>
		{*<div class="row">
			<div class="bg-white position-fixed w-100 p-3 te-mobile-contact-agent te-bg-light">
				<button type="button" data-url="{$detail_url}?action=listing-inquiry" class="btn border-secondary te-btn text-white text-uppercase w-100 contact-agent-button shadow-none rounded-0 w-100 hbn-popup-modal" data-toggle="modal" data-target="Inquiry">Contact Agent</button>
			</div>
		</div>*}
		<input type="hidden" name="OnPage" id="OnPage" value="FullView"/>
		{*{if isset($backToUrl) && $backToUrl != ''}
			<div class="row pt-lg-4">
				<div class="col-12">
					<a class="btn btn-sm te-font-size-14 shadow-none te-save-propery-detail- rounded-0 p-0" href="{$backToUrl}" role="button" title="Back to Previous Page"><i class="far fa-arrow-alt-circle-left fa-2x align-middle"></i> Back to Previous Page</a>
				</div>
			</div>
		{/if}*}
	</div>
</section>



<div class="modal fade property-contact-agent-modal" id="modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content px-2 rounded-0">

		</div>
	</div>
</div>
<div class="pswp te-z-index-99999" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>
		<div class="pswp__ui pswp__ui--hidden">
			<div class="pswp__top-bar">
				<div class="pswp__counter"></div>
				<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
				<button class="pswp__button pswp__button--share" title="Share"></button>
				<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
				<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
				<div class="pswp__share-tooltip"></div>
			</div>
			<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
			<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div>